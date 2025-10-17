<?php
namespace App\BaseDatos;
use \PDO;
class Conexion{
    private static ?PDO $conexion=null;

    public static function getConexion(): PDO{
        if(self::$conexion==null){
            self::setConexion();
        }
        return self::$conexion;
    }
    private static function setConexion(){
        //Cojemos los parametros para conectarnos
        // de .env usando dotenv
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__."/../../");
        $dotenv->load();
        $puerto=$_ENV['PORT'];
        $usuario=$_ENV['USUARIO'];
        $base=$_ENV['DATABASE'];
        $pass=$_ENV['PASS'];
        $host=$_ENV['HOST'];

        $dsn="mysql:host=$host;dbname=$base;port=$puerto;charset=utf8mb4";
        







    }
}