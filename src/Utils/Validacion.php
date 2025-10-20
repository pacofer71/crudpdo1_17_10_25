<?php
namespace App\Utils;
class Validacion{
    public static function limpiarCadenas(string $cad): string{
        return htmlspecialchars(trim($cad));
    }
}