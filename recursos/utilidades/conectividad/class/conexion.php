<?php

class BD
{
    private static $conexion = null;
    private static $db_host = "localhost";
    private static $db_user = 'root';
    private static $db_pass = '';
    private static $db_name = "flashgram";

    public static function crearConexion()
    {
        try {
            self::$conexion = new PDO("mysql:host=" . self::$db_host . ";dbname=" . self::$db_name . ";charset=UTF8", self::$db_user, self::$db_pass);
            self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            self::$conexion->setAttribute(PDO::MYSQL_ATTR_FOUND_ROWS, TRUE);
        } catch (PDOException $exception) {
            echo $exception->getMessage();
            die("[-] Conexion con la base de datos fallida");
        }
        return self::$conexion;
    }

    public static function cerrarConexion()
    {
        self::$conexion = null;
    }
}