<?php
session_start();
$mensaje = $mensaje ?? "";
$tipoMensaje = $tipoMensaje ?? "info";

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Cliente - Motor Masters</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-image: url("./IMG/HomePresentacion.jpg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
        }
    </style>
</head>

<body>
    <main class="container my-5">
        <section class="text-center text-white mb-4">
            <h1 class="fw-bold">Registro de Clientes</h1>
        </section>

        <?php if (!empty($mensaje)): ?>
            <div class="alert alert-<?= htmlspecialchars($tipoMensaje) ?> text-center mx-auto" style="max-width: 600px;">
                <?= htmlspecialchars($mensaje) ?>
            </div>
        <?php endif; ?>

        <section class="d-flex justify-content-center align-items-center mt-4">
            <div class="card p-4 shadow-lg" style="max-width: 500px; width: 100%;">
                <form action="../Controladores/UsuarioControlador.php?Tipo=RegistrarCliente" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nombre Completo</label>
                        <input type="text" name="nombre" class="form-control"
                            value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Correo Electrónico</label>
                        <input type="email" name="correo" class="form-control"
                            value="<?= htmlspecialchars($_POST['correo'] ?? '') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="telefono" class="form-control" pattern="[0-9]{8}" maxlength="8"
                            placeholder="Ej: 78901234" value="<?= htmlspecialchars($_POST['telefono'] ?? '') ?>"
                            required>
                        <small class="text-muted">Debe tener exactamente 8 dígitos</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Fecha de nacimiento</label>
                        <input type="date" name="fecha_nacimiento" class="form-control"
                            value="<?= htmlspecialchars($_POST['fecha_nacimiento'] ?? '') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Número de DUI (sin guión)</label>
                        <input type="text" name="dui" class="form-control" pattern="[0-9]{9}" maxlength="9"
                            placeholder="Ej: 012345678" value="<?= htmlspecialchars($_POST['dui'] ?? '') ?>" required>
                        <small class="text-muted">Debe tener exactamente 9 dígitos</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="contra" class="form-control" minlength="6" required>
                        <small class="text-muted">Mínimo 6 caracteres</small>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-person-check-fill me-2"></i>Registrar Cliente
                    </button>
                </form>

                <hr class="my-4">
                <p class="text-center mb-0">
                    ¿Ya tienes cuenta? <a href="Login.php">Inicia sesión aquí</a>
                </p>
            </div>
        </section>
    </main>
</body>

</html>