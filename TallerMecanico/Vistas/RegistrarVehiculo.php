<?php
// Iniciar sesión solo si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Validar que el usuario haya iniciado sesión y sea cliente
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'cliente') {
    echo "<script>
            alert('Debes iniciar sesión para registrar tu vehículo.');
            window.location.href = 'Login.php';
            </script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Vehículo | Motor Masters</title>
    <script src="./JS/java.js" defer></script>
    <link rel="stylesheet" href="./CSS/estilos.css" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-ligth">

    
        <div class="container mt-5 p-4 shadow-lg bg-white rounded">
            <h2 class="text-center mb-4">Registro de Vehículo</h2>

            <?php if (isset($_GET['mensaje'])): ?>
                <div class="alert alert-info text-center">
                    <?= htmlspecialchars($_GET['mensaje']) ?>
                </div>
            <?php endif; ?>

            <form action="../Controladores/VehiculoControlador.php" method="POST">

                <!-- Acción del controlador -->
                <input type="hidden" name="accion" value="Registrar">

                <!-- id del usuario logueado -->
                <input type="hidden" name="id_cliente" value="<?= htmlspecialchars($_SESSION['id_cliente']); ?>">

                <div class="mb-3">
                    <label class="form-label">Placa del Vehículo</label>
                    <input type="text" name="placa" class="form-control" placeholder="Ejemplo: P123ABC" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Marca y Modelo</label>
                    <input type="text" name="marcaYmodelo" class="form-control" placeholder="Ejemplo: Toyota Corolla"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Año de Fabricación</label>
                    <input type="number" name="anio_fabricacion" min="1900" max="<?= date('Y') ?>"required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Registrar Vehículo</button>
                <a href="../Vistas/Home.php" class="btn btn-secondary mt-3 w-100">Volver</a>
            </form>
        </div>
    

    
    </div>
    <footer class="footer text-center text-light py-3">
        <p>© 2025 Motor Masters</p>
    </footer>
    <style>
    .p-4 {
        font-family: system-ui, sans-serif;
        background-color: #011423;
    }

    </style>
            
</body>
</html>