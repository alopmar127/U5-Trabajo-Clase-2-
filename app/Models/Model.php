<?php


namespace App\Models;

require_once __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv;


/**
 * Gestiona la conexión de la base de datos e incluye un esquema para
 * un Query Builder. Los return son ejemplo en caso de consultar la tabla
 * usuarios.
 */

class Model
{

    protected $db_host;
    protected $db_user;
    protected $db_pass;
    protected $db_name;

    // protected $db_host = $_ENV['DB_HOST'];
    // protected $db_user =  $_ENV['DB_USER']; // Las credenciales se deben guardar en un archivo .env
    // protected $db_pass =  $_ENV['DB_PASS'];
    // protected $db_name =  $_ENV['DB_NAME'];

    protected $connection;

    protected $query; // Consulta a ejecutar

    protected $select = '*';
    protected $where, $values = [];
    protected $orderBy;

    protected $table; // Definido en la clase hijo
    protected $table2; // Definido en la clase hijo
    protected $campoEspecifico; // Definido en la clase hijo

    public function __construct()  // Se puede modificar según montéis la conexión
    {
        $this->connection();
    }

    public function connection()
    {
        try {

            // Cargar variables de entorno
            $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
            $dotenv->load();

            // Asignar las variables
            $this->db_host = $_ENV['DB_HOST'];
            $this->db_user = $_ENV['DB_USER'];
            $this->db_pass = $_ENV['DB_PASS'];
            $this->db_name = $_ENV['DB_NAME'];

            // Mostrar para depuración
            //echo "Host: {$this->db_host}, User: {$this->db_user}, DB: {$this->db_name} <br>";

            // Crear conexión PDO
            $dsn = "mysql:host={$this->db_host};dbname={$this->db_name};charset=utf8mb4";
            $this->connection = new \PDO($dsn, $this->db_user, $this->db_pass);

            // Configurar el manejo de errores
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    // public function prueba()
    // {
    //     $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
    //     $dotenv->load();
    //     $db_host = $_ENV['DB_HOST'];
    //     $db_user =  $_ENV['DB_USER']; // Las credenciales se deben guardar en un archivo .env
    //     $db_pass =  $_ENV['DB_PASS'];
    //     $db_name =  $_ENV['DB_NAME'];
    // }

    // QUERY BUILDER
    // Consultas: 

    // Recibe la cadena de consulta y la ejecuta
    public function query($sql, $data = [], $params = null)
    {
        // Mostrar para depuración
       /*  echo "Consulta: {$sql} <br>"; // borrar, solo para ver ejemplo
        echo "Data: ";
        var_dump($data);
        echo "Params: ";
        var_dump($params);
        echo "<br>"; */

        // Si hay $data se lanzará una consulta preparada, en otro caso una normal
        // Está configurado para mysqli, cambiar para usar PDO
        try {
            // Si hay datos, usar consulta preparada
            if ($data) {
                $stmt = $this->connection->prepare($sql);
                $stmt->execute($data);
                $this->query = $stmt;
            } else {
                // Si no hay datos, ejecutar directamente
                $this->query = $this->connection->query($sql);
            }
        } catch (\PDOException $e) {
            die("Error en la consulta: " . $e->getMessage());
        }

        return $this;
    }

    public function select(...$columns)
    {
        // Separamos el array en una cadena con ,
        $this->select = implode(', ', $columns);

        return $this;
    }

    // Devuelve todos los registros de una tabla
    public function all()
    {
        // SELECT ALL
        $sql = "SELECT * FROM {$this->table}";

        // Ejecuta la consulta
        $this->query($sql);

        // Retornar todos los resultados como un array asociativo
        return $this->query->fetchAll();
    }

    // Consulta base a la que se irán añadiendo partes
    public function get()
    {
        if (empty($this->query)) {
            $sql = "SELECT {$this->select} FROM {$this->table}";

            // Se comprueban si están definidos para añadirlos a la cadena $sql
            if ($this->where) {
                $sql .= " WHERE {$this->where}";
            }

            if ($this->orderBy) {
                $sql .= " ORDER BY {$this->orderBy}";
            }

            $this->query($sql, $this->values);
        }
        // Devolver los resultados si existen
        if ($this->query) {
            return $this->query->fetchAll();
            // Retorna un array asociativo
        }

        return [];
    }

    public function find($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";

        $this->query($sql, [$id]);

        return $this->query->fetch();
    }

    // Se añade where a la sentencia con operador específico
    public function where($column, $operator, $value = null, $chainType = 'AND')
    {
        if ($value == null) { // Si no se pasa operador, por defecto =
            $value = $operator;
            $operator = '=';
        }

        // Si ya había algo de antes 
        if ($this->where) {
            $this->where .= " {$chainType} {$column} {$operator} ?";
        } else {
            $this->where = "{$column} {$operator} ?";
        }

        $this->values[] = $value;

        return $this;
    }

    // Se añade orderBy a la sentencia
    public function orderBy($column, $order = 'ASC')
    {
        if ($this->orderBy) {
            $this->orderBy .= ", {$column} {$order}";
        } else {
            $this->orderBy = "{$column} {$order}";
        }

        return $this;
    }

    // Insertar, recibimos un $_GET o $_POST
    public function create($data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";

        $this->query($sql, array_values($data));

        return $this;
    }

    public function update($id, $data)
    {
        $fields = implode(', ', array_map(fn($key) => "{$key} = ?", array_keys($data)));

        $sql = "UPDATE {$this->table} SET {$fields} WHERE id = ?";

        $values = array_values($data);
        $values[] = $id;

        $this->query($sql, $values);

        return $this;
    }

    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";

        $this->query($sql, [$id]);

        return $this;
    }

    // Para pruebas, devuelve como si fuese unan consulta, borrar
    public function consultaPrueba()
    {
        return [
            ['id' => 1, 'nombre' => 'Nombre1', 'apellido' => 'Apellido1'],
            ['id' => 1, 'nombre' => 'Nombre2', 'apellido' => 'Apellido2'],
            ['id' => 1, 'nombre' => 'Nombre3', 'apellido' => 'Apellido3']
        ];
    }

    public function joinTablas(array $camposTabla, array $camposRelacionados): array
    {
        // Validar que las propiedades necesarias estén definidas
        if (!isset($this->table) || !isset($this->table2)) {
            throw new \Exception('Las propiedades $table y $table2 deben definirse en la clase hija.');
        }

        // Convertir los campos en formato SQL
        $selectTabla = implode(', ', array_map(fn($campo) => "{$this->table}.{$campo} AS {$this->table}_{$campo}", $camposTabla));
        $selectRelacionados = implode(', ', array_map(fn($campo) => "{$this->table2}.{$campo} AS {$this->table2}_{$campo}", $camposRelacionados));

        // Combinar los campos para el SELECT
        $select = "{$selectTabla}, {$selectRelacionados}";

        // Construcción de la consulta dinámica
        $sql = "SELECT {$select}
            FROM {$this->table}
            INNER JOIN {$this->table2} ON {$this->table}.id_p = {$this->table2}.id";

        // Ejecutar la consulta
        $this->query($sql);

        // Retornar los resultados
        return $this->query->fetchAll();
    }
}
