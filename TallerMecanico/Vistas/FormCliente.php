<?php
// ==============================
// Evitar warnings cuando no existe $cliente
// ==============================
$cliente = $cliente ?? [
    'id_cliente' => '',
    'id_usuario' => '',
    'nombre_completo' => '',
    'correo' => '',
    'numero_telefono' => '',
    'numero_dui' => '',
    'fecha_nacimiento' => ''
];

// Determinar si estamos editando o registrando
$esEdicion = !empty($cliente['id_cliente']);
$accion = $esEdicion ? 'Actualizar' : 'Registrar';
$titulo = $esEdicion ? 'Editar Cliente' : 'Registrar Nuevo Cliente';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?> - Motor Masters</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    .bg-light {
        background-color: #011423 !important;        /*COLOR CHIDO*/
    }
</style>

<body class="bg-light">

    <div class="container my-5">
        <h2 class="text-center mb-4" style="color: aliceblue;"><?= $titulo ?></h2>

        <?php if (!empty($mensaje)): ?>
            <div class="alert alert-info text-center"><?= htmlspecialchars($mensaje) ?></div>
        <?php endif; ?>

        <!-- Formulario de registro / edición -->
        <form action="../Controladores/ClienteControlador.php?accion=<?= $accion ?>" method="POST"
            class="card shadow p-4 mx-auto" style="max-width:600px;">

            <!-- Campos ocultos -->
            <input type="hidden" name="id_cliente" value="<?= htmlspecialchars($cliente['id_cliente']) ?>">
            <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($cliente['id_usuario']) ?>">

            <div class="mb-3">
                <label class="form-label">Nombre Completo</label>
                <input type="text" name="nombre" class="form-control"
                    value="<?= htmlspecialchars($cliente['nombre_completo']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Correo Electrónico</label>
                <input type="email" name="correo" class="form-control"
                    value="<?= htmlspecialchars($cliente['correo']) ?>" <?= $esEdicion ? 'readonly' : 'required' ?>>
            </div>

            <div class="mb-3">
                <label class="form-label">Fecha de nacimiento</label>
                <input type="date" name="fecha_nacimiento" class="form-control"
                    value="<?= htmlspecialchars($cliente['fecha_nacimiento']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Teléfono</label>
                <input type="number" name="telefono" class="form-control"
                    value="<?= htmlspecialchars($cliente['numero_telefono']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Número de DUI (sin guión)</label>
                <input type="number" name="dui" class="form-control"
                    value="<?= htmlspecialchars($cliente['numero_dui']) ?>" minlength="9" required>
            </div>

            <?php if (!$esEdicion): ?>
                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="contra" class="form-control" minlength="6" required>
                    <small class="text-muted">Mínimo 6 caracteres</small>
                </div>
            <?php endif; ?>

            <button type="submit" class="btn btn-success w-100">
                <?= $esEdicion ? 'Actualizar Cliente' : 'Registrar Cliente' ?>
            </button>
            <a href="../Vistas/adminPanel.php" class="btn btn-secondary mt-3 w-100">Volver</a>

        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>