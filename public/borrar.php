<?php

use App\BaseDatos\Usuario;

session_start();
require __DIR__."/../vendor/autoload.php";
$id=filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
//$id=$_POST['id']; //si elusuario entra directamente en borrar.php esto me da un warning!!!!
if(!$id || $id<=0){
    header("Location:index.php");
    die();
}
Usuario::delete($id);
$_SESSION['mensaje']="Usuario Borrado.";
header("Location:index.php");
