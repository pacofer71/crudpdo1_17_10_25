<?php
use App\BaseDatos\Usuario;
use App\Utils\Validacion;

session_start();
require __DIR__."/../vendor/autoload.php";
$id=filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
//$id=$_GET['id']; //si elusuario entra directamente en borrar.php esto me da un warning!!!!

if(!$id || !$usuario=Usuario::getUserById($id)){
    header("Location:index.php");
    die();
}
$adminChecked=($usuario->getAdmin()=='SI') ? "checked" : "";
$noAdminChecked=($usuario->getAdmin()=='NO') ? "checked" : "";

if (isset($_POST['nombre'])) {
    //1.- Recogemos y limpamos lo que nos llega del form
    $nombre = Validacion::limpiarCadenas($_POST['nombre']);
    $email = Validacion::limpiarCadenas($_POST['email']);
    $descripcion = Validacion::limpiarCadenas($_POST['descripcion']);
    //$admin=Validacion::limpiarCadenas($_POST['admin']);
    
    //$admin = (isset($_POST['admin'])) ? Validacion::limpiarCadenas($_POST['admin']) : "ERROR"; //??
    $admin = $_POST['admin'] ?? "ERROR";
    $admin=Validacion::limpiarCadenas($admin);
    //2.- Validamos los campos
    $errores = false;
    if (!Validacion::isLongitudCampoValida('nombre', $nombre, 3, 50)) {
        $errores = true;
    }else{
        if(Validacion::existeValor($nombre, 'nombre', $id)) $errores=true;
    }
    if (!Validacion::isLongitudCampoValida('descripcion', $descripcion, 10, 500)) {
        $errores = true;
    }
    if (!Validacion::isEmailValido($email)) {
        $errores = true;
    }else{
        // es un email valido, comprobare si exite
        if(Validacion::existeValor($email, 'email', $id)) $errores=true;
    }
    if (!Validacion::isAdminValido($admin)) {
        $errores = true;
    }
    //3.- Si hay errores los muestro y si no inerto los valores
    if ($errores) {
        header("Location:update.php?id=$id");
        die();
    }
    //Si estoy aquí es pq no ha habido errores, edito los datos;
    (new Usuario)->setNombre($nombre)
        ->setDescripcion($descripcion)
        ->setEmail($email)
        ->setAdmin($admin)
        ->update($id);
    $_SESSION['mensaje'] = "Usuario editado con éxito";
    header("Location:index.php");
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CDN Tailwindcss -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- CDN FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CDn SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Document</title>
</head>

<body class="p-8 bg-blue-200">
    <h3 class="text-center text-xl font-bold mb-2">EDITAR USUARIO</h3>
    <div class="p-4 rounded-xl shadow-xl w-1/2 mx-auto bg-gray-100">
        <form action="update.php?id=<?= $id ?>" method="POST" class="space-y-5">

            <!-- Campo Nombre -->
            <div>
                <label for="nombre" class="block text-gray-700 font-medium mb-1">
                    <i class="fa-solid fa-user text-blue-500 mr-1"></i> Nombre
                </label>
                <input type="text" id="nombre" name="nombre" value="<?= $usuario->getNombre() ?>"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <?php Validacion::pintarError('err_nombre') ?>
            </div>

            <!-- Campo Email -->
            <div>
                <label for="email" class="block text-gray-700 font-medium mb-1">
                    <i class="fa-solid fa-envelope text-blue-500 mr-1"></i> Email
                </label>
                <input type="email" id="email" name="email" value="<?= $usuario->getEmail() ?>"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <?php Validacion::pintarError('err_email') ?>
            </div>

            <!-- Textarea Descripción -->
            <div>
                <label for="descripcion" class="block text-gray-700 font-medium mb-1">
                    <i class="fa-solid fa-comment text-blue-500 mr-1"></i> Descripción
                </label>
                <textarea id="descripcion" name="descripcion" rows="4"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"><?= $usuario->getDescripcion() ?></textarea>
                <?php Validacion::pintarError('err_descripcion') ?>
            </div>

            <!-- Radio Buttons Administrador -->
            <div>
                <span class="block text-gray-700 font-medium mb-2">
                    <i class="fa-solid fa-user-shield text-blue-500 mr-1"></i> Administrador
                </span>
                <div class="flex items-center space-x-4">
                    <label class="flex items-center space-x-1">
                        <input type="radio" name="admin" value="SI" class="text-blue-600 focus:ring-blue-500" <?= $adminChecked?>>
                        <span>SI</span>
                    </label>
                    <label class="flex items-center space-x-1">
                        <input type="radio" name="admin" value="NO" class="text-blue-600 focus:ring-blue-500" <?= $noAdminChecked?> >
                        <span>NO</span>
                    </label>
                </div>
                <?php Validacion::pintarError('err_admin') ?>
            </div>

            <!-- Botones -->
            <div class="flex flex-row-reverse gap-3 pt-4">
                <button type="submit" class="flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    <i class="fa-solid fa-edit"></i> Update
                </button>
                <a href="index.php" class="flex items-center gap-2 bg-red-400 text-gray-800 px-4 py-2 rounded-lg hover:bg-red-600 transition">
                    <i class="fa-solid fa-xmark"></i> Cancelar
                </a>
            </div>

        </form>
    </div>
</body>

</html>