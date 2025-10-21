<?php

namespace App\Utils;

class Validacion
{
    public static function limpiarCadenas(string $cad): string
    {
        return htmlspecialchars(trim($cad));
    }

    public static function isLongitudCampoValida(string $nomCampo, string $valorCampo, int $min, int $max): bool
    {
        if (strlen($valorCampo) < $min || strlen($valorCampo) > $max) {
            $_SESSION["err_" . $nomCampo] = "*** Error el campo $nomCampo debe tener entre $min y $max caracteres.";
            return false;
        }
        return true;
    }
    public static function isEmailValido(string $email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['err_email'] = "*** Error se esperaba un email válido.";
            return false;
        }
        return true;
    }
    public static function isAdminValido(string $valor): bool
    {
        $valores = ['SI', 'NO'];
        if (!in_array($valor, $valores)) {
            $_SESSION['err_admin'] = "*** Error valor del campo inválido o no marcó ninguno.";
            return false;
        }
        return true;
    }

    public static function pintarError(string $nombreError): void
    {
        if (isset($_SESSION[$nombreError])) {
            echo <<< TXT
                <div class='text-sm text-red-600 italic mt-1'>{$_SESSION[$nombreError]}</div>
            TXT;
            unset($_SESSION[$nombreError]);
        }
    }
}
