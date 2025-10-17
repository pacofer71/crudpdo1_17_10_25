<?php
namespace App\BaseDatos;
use \PDO;
use \PDOException;

use \Dotenv\Dotenv;
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
        $dotenv = Dotenv::createImmutable(__DIR__."/../../");
        $dotenv->load();
        $puerto=$_ENV['PORT'];
        $usuario=$_ENV['USUARIO'];
        $base=$_ENV['DATABASE'];
        $pass=$_ENV['PASS'];
        $host=$_ENV['HOST'];

        $dsn="mysql:host=$host;dbname=$base;port=$puerto;charset=utf8mb4";
        $opciones=[
            PDO::ATTR_PERSISTENT=>true, // se recomienda por rendimiento
            PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES=>false //por rendimiento
        ];
        try{
            self::$conexion= new PDO($dsn, $usuario, $pass, $opciones);
        }catch(PDOException $ex){
            throw new \Exception("Error en la conexion: ".$ex->getMessage());
        }









    }
}