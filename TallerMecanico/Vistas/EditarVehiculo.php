<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
        header("Location: Home.php");
        exit();
    }
}
?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Vehículo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-light">

    <div class="container mt-5 bg-secondary p-4 rounded shadow">
        <h2 class="text-center text-white mb-4">Editar Vehículo</h2>

        <?php if ($mensaje): ?>
            <div class="alert alert-<?= htmlspecialchars($tipo) ?> text-center">
                <?= htmlspecialchars($mensaje) ?>
            </div>
        <?php endif; ?>

        <form action="../Controladores/VehiculoControlador.php?accion=Actualizar" method="POST">
            <input type="hidden" name="id_automovil" value="<?= $vehiculo['id_automovil'] ?>">

            <div class="mb-3">
                <label class="form-label">Cliente</label>
                <select name="id_cliente" class="form-select" required>
                    <?php foreach ($clientes as $cliente): ?>
                        <option value="<?= $cliente['id_cliente'] ?>" <?= ($vehiculo['id_cliente'] == $cliente['id_cliente']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cliente['nombre_cliente']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Placa</label>
                <input type="text" name="placa" class="form-control" value="<?= htmlspecialchars($vehiculo['placa']) ?>"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Marca y Modelo</label>
                <input type="text" name="marcaYmodelo" class="form-control"
                    value="<?= htmlspecialchars($vehiculo['marcaYmodelo']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Año de Fabricación</label>
                <input type="date" name="anio_fabricacion" class="form-control"
                    value="<?= htmlspecialchars($vehiculo['anio_fabricacion']) ?>" required>
            </div>

            <button type="submit" class="btn btn-success w-100">Guardar Cambios</button>
            <a href="../Controladores/VehiculoControlador.php?accion=GestionAdmin" class="btn btn-secondary mt-3 w-100">Cancelar</a>
        </form>
    </div>

</body>

</html>