<?php
session_start();
require_once("../Modelos/Conexion.php");
$mensaje = $mensaje ?? "";
$tipoMensaje = $tipoMensaje ?? "info";

$db = (new Conexion())->getConexion();
    class admnLog extends Conexion{

    }
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión - Motor Masters</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-image: url("./IMG/HomePresentacion.jpg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            margin: 0;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center" style="height:100vh;">
        <div class="card shadow p-4" style="width: 360px;">
            <h3 class="text-center mb-4">Iniciar Sesión</h3>

            
            <?php if (isset($_GET['mensaje'])): ?>
                <div class="alert alert-<?= htmlspecialchars($_GET['tipo'] ?? 'info') ?> text-center">
                    <?= htmlspecialchars($_GET['mensaje']) ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['registro']) && $_GET['registro'] == 'exitoso'): ?>
                <div class="alert alert-success text-center">
                    Registro exitoso. Ahora puedes iniciar sesión.
                </div>
            <?php endif; ?>


            <form action="../Controladores/UsuarioControlador.php?Tipo=Login" method="POST">
                <div class="mb-3">
                    <label for="correo" class="form-label">Correo electrónico</label>
                    <input type="email" name="correo" id="correo" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="contrasena" class="form-label">Contraseña</label>
                    <input type="password" name="contrasena" id="contrasena" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Ingresar</button>
            </form>

            <hr>
            <p class="text-center">
                ¿No tienes cuenta?<br>
                <a href="../Vistas/RegistroClientes.php">Registrarme</a>
            </p>
        </div>
    </div>
</body>

</html>