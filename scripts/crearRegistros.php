<?php

use App\BaseDatos\Usuario;

require __DIR__ . "/../vendor/autoload.php";
$cant = 0;
do {
    $cant = readline("Dame el numero de usuarios a crear entre 10 y 50, 'q' para salir: ");
    if ($cant == 'q') {
        echo "\n Saliendo a petición del usuario.";
        $cant = 0;
        break;
    }
    $cant = (int) $cant;
    if ($cant < 10 || $cant > 50) {
        echo "\nError, se esperaba una cantidad entre 10 y 50!!!\n";
    }
} while ($cant < 10 || $cant > 50);
if ($cant) {
    Usuario::crearRegistrosRandom($cant);
    echo "\n Se han creado $cant registros.";
}
