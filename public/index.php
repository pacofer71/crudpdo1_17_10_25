<?php
session_start();

use App\BaseDatos\Usuario;


require __DIR__ . "/../vendor/autoload.php";
$usuarios = Usuario::read();
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

<body class="py-8 px-12 bg-blue-200">
    <h3 class="text-center text-xl font-bold mb-2">Ver Usuarios</h3>
    <div class="relative overflow-x-auto">
        <div class="mb-2 flex flex-row-reverse">
            <a href="nuevo.php" class="p-2 rounded-lg bg-green-500 hover:bg-green-700 font-bold text-white">
                <i class="fas fa-add mr-1"></i>NUEVO
            </a>
        </div>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        NOMBRE
                    </th>
                    <th scope="col" class="px-6 py-3">
                        EMAIL
                    </th>
                    <th scope="col" class="px-6 py-3">
                        DESCRIPCION
                    </th>
                    <th scope="col" class="px-6 py-3">
                        ADMIN
                    </th>
                    <th scope="col" class="px-6 py-3">
                        ACCIONES
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $item):
                    $fondo=$item->admin=='SI' ? "bg-red-500" : "bg-green-500";
                     ?>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <?= $item->id; // $item['id'] si hubiese usado FETCH_ASSOC 
                            ?>
                        </th>
                        <td class="px-6 py-4">
                            <?= $item->nombre; ?>
                        </td>
                        <td class="px-6 py-4 italic">
                            <?= $item->email; ?>
                        </td>
                        <td class="px-6 py-4">
                            <?= $item->descripcion; ?>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-center p-2 font-bold rounded-lg text-white <?=$fondo ?>"><?= $item->admin; ?></div>
                        </td>
                        <td class="px-6 py-4">
                            Botones
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- mensajes de alerta -->
    <?php
    if (isset($_SESSION['mensaje'])) {
        echo <<< TXT
        <script>
            Swal.fire({
            icon: "success",
            title: "{$_SESSION['mensaje']}",
            showConfirmButton: false,
            timer: 1500
            });
        </script>
        TXT;
        unset($_SESSION['mensaje']);
    }
    ?>
</body>

</html>