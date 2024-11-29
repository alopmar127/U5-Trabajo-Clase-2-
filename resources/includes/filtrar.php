<?php
declare(strict_types=1);

    /*Funcion filtrar que recibe el valor introducido por el usuario, 
una función opcional para devolver el valor a la función que inicializamos a null para comprobar
si se ha pasado una función. Devolvera el dato una vez filtrado.
*/
function filtrar(mixed $datos, ?callable $function = null): mixed
{
    //Con trim eliminamos los espacios en blanco al inicio y al final
    $datos = trim($datos);
    //Con stripslashes eliminamos / y \
    $datos = stripslashes($datos);
    //Con htmlspecialchars convertimos los caracteres especiales
    $datos = htmlspecialchars($datos);

    //Comprobamos si se ha pasado una función y si es así devolvemos el valor a la función
    if ($function !== null) {
        
        return $function($datos);

    //Si no se ha pasado una función devolvemos el valor normal
    } else {
        //Una vez comprobado devolvemos el dato
        return $datos;
    }       
}