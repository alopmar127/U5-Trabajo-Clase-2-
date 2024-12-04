<?php
declare(strict_types=1);


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

    private string $db_host;
    private string $db_user;
    private string $db_pass;
    private string $db_name;

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
    public function all(): array
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

    public function find($id): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";

        $this->query($sql, [$id]);

        return $this->query->fetch();
    }

    // Se añade where a la sentencia con operador específico
    public function where($column, $operator, $value = null, $chainType = 'AND')
    {
        // Si no se pasa el operador tipo %, =, >, <, IN, NOT IN, BETWEEN, se asume =
        if ($value === null) {
            $value = $operator;
            // Se asume que el operador es =
            $operator = '=';
        }
        // Se convierte el operador a mayúsculas
        $operator = strtoupper($operator);

        // Se verifica si el operador es IN o NOT IN y se aplica el formato adecuado
        if (in_array($operator, ['IN', 'NOT IN']) && is_array($value)) {
            // Se crean las variables para los valores de la consulta 
            $placeholders = implode(', ', array_fill(0, count($value), '?'));
            // Se crea la condición con el operador y los valores
            $condition = "{$column} {$operator} ({$placeholders})";
            // Se agregan los valores a las variables
            $this->values = array_merge($this->values, $value);
        // Se verifica si el operador es BETWEEN y se aplica el formato adecuado
        } elseif ($operator == 'BETWEEN' && is_array($value) && count($value) == 2) {
            // Se crea la condición con el operador y los valores
            $condition = "{$column} BETWEEN ? AND ?";
            // Se agregan los valores a las variables
            $this->values = array_merge($this->values, $value);
        // Si es LIKE se aplica el formato adecuado
        } else {
            // Se crea la condición con el operador y el valor
            $condition = "{$column} {$operator} ?";
            // Se agregan los valores a las variables
            $this->values[] = $value;
        }
        // Se verifica si hay una condición existente y se agrega el operador y la condición
        if ($this->where) {
            // Se agrega el operador y la condición
            $this->where .= " {$chainType} {$condition}";
        // En caso contrario, se crea la condición
        } else {
            $this->where = $condition;
        }
        // Se devuelve para permitir el uso de métodos en cascada
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
        // Convierte el array asociativo en una cadena separado por comas con los nombres de las columnas
        //Ej si data es ['nombre' => 'Juan', 'apellidos' => 'Pérez'] array keys devuelve ['nombre', 'apellidos']
        //Y el implode lo convierte en 'nombre, apellidos'
        $columns = implode(', ', array_keys($data));
        //Crea los mismos huecos con ? que columnas haya en el array $data
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        //Construye la consulta con la tabla, las columnas de antes y el placeholder con los elementos a sustituir 
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        //Ejecuta la consulta y le pasa los valores del array $data
        $this->query($sql, array_values($data));

        return $this;
    }

    //Actualizar registro en la BBDD
    public function update($id, $data)
    {
        //array_keys pilla el nombre de las columnas de $data
        //array_map pone el ? en cada columna ej ['nombre = ?', 'apellidos = ?']
        //implode convierte todo en una cadena tipo: 'nombre = ?, apellidos = ?'
        $fields = implode(', ', array_map(fn($key) => "{$key} = ?", array_keys($data)));

        //Crea la consulta con la tabla, los campos de antes y el placeholder con los elementos a sustituir
        $sql = "UPDATE {$this->table} SET {$fields} WHERE id = ?";
        //Ejecuta la consulta y le pasa los valores del array $data
        $values = array_values($data);
        //Agrega el id del registro a actualizar que va en el ? del where
        $values[] = $id;
        //Ejecuta la consulta
        $this->query($sql, $values);

        return $this;
    }

    //Eliminar registro de la BBDD
    public function delete($id)
    {
        //Crea la consulta con la tabla y el placeholder con el id
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        //Ejecuta la consulta y le pasa el id
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


    //Añadido para transacciones, rollback y commit
    /**
     * Función que utiliza el método where para filtrar resultados.
     * @param string $columna Nombre de la columna para filtrar.
     * @param mixed $valor Valor a buscar en la columna.
     * @return array Resultados de la consulta.
     */
    public function obtenerPorCampo($columna, $operador, $valor)
    {
        return $this->where($columna, $operador, $valor)->get();
    }


    //Inicia una transacción en la base de datos.
    public function iniciarTransaccion()
    {
        $this->connection->beginTransaction();
    }

    
    //Confirma los cambios realizados durante la transacción.

    public function confirmarTransaccion()
    {
        $this->connection->commit();
    }

    //Hacer rollback de transaccion
    public function deshacerTransaccion()
    {
        $this->connection->rollBack();
    }

    /**
     * Ejecuta un procedimiento almacenado de forma genérica.
     * @param string $nombreProcedimiento Nombre del procedimiento almacenado.
     * @param array $parametros Array de parámetros con tipo y valor.
     * @return array Resultados de los parámetros OUT e INOUT.
     */
    public function ejecutarProcedimiento($nombreProcedimiento, $parametros = [])
    {
        //Para almacenar los placeholders
        $placeholders = [];
        $valores = [];

        foreach ($parametros as $nombre => $parametro) {
            //Si es IN
            if ($parametro['tipo'] == 'IN') {
                //Agrega el placeholder con el nombre del procedimiento
                $placeholders[] = ":{$nombre}";
                //Agrega el valor del valor a introducir en el IN 
                $valores[$nombre] = $parametro['valor'];
            } elseif ($parametro['tipo'] == 'OUT' || $parametro['tipo'] == 'INOUT') {
                $placeholders[] = "@{$nombre}";
                if ($parametro['tipo'] == 'INOUT') {
                    // Para INOUT, asignar el valor inicial
                    $this->connection->query("SET @{$nombre} = {$parametro['valor']}");
                }
            }
        }

        $placeholderString = implode(', ', $placeholders);
        $sql = "CALL {$nombreProcedimiento}({$placeholderString})";

        $stmt = $this->connection->prepare($sql);

        // Vincular parámetros IN
        foreach ($parametros as $nombre => $parametro) {
            if ($parametro['tipo'] == 'IN') {
                $stmt->bindValue(":{$nombre}", $parametro['valor']);
            }
        }

        // Ejecutar el procedimiento
        $stmt->execute();

        // Obtener los valores de los parámetros OUT e INOUT
        $resultados = [];
        foreach ($parametros as $nombre => $parametro) {
            if ($parametro['tipo'] == 'OUT' || $parametro['tipo'] == 'INOUT') {
                $resultado = $this->connection->query("SELECT @{$nombre} AS {$nombre}")->fetch();
                $resultados[$nombre] = $resultado[$nombre];
            }
        }

        return $resultados;
    }
}
