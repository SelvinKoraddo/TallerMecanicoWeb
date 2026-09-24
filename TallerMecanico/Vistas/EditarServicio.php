<?php
if (session_status() === PHP_SESSION_NONE) {
session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Servicio | Motor Masters</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">

<div class="container mt-5">
    <div class="card bg-light text-dark mx-auto" style="max-width: 600px;">
        <div class="card-header bg-warning text-center fw-bold">Editar Servicio</div>
        <div class="card-body">
            <form action="../Controladores/ServicioControlador.php?accion=Actualizar" method="POST">
                <input type="hidden" name="id_servicio" value="<?= $servicio['id_servicio'] ?>">

                <div class="mb-3">
                    <label class="form-label">Nombre del Servicio</label>
                    <input type="text" name="nombre_servicio" class="form-control" value="<?= htmlspecialchars($servicio['nombre_servicio']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <input type="text" name="descripcion_servicio" class="form-control" value="<?= htmlspecialchars($servicio['descripcion_servicio']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Precio ($)</label>
                    <input type="number" step="0.01" name="precio_servicio" class="form-control" value="<?= htmlspecialchars($servicio['precio_servicio']) ?>" required>
                </div>

                <button type="submit" class="btn btn-success w-100">Guardar Cambios</button>
                <a href="../Controladores/ServicioControlador.php?accion=Gestionar" class="btn btn-secondary w-100 mt-2">Cancelar</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>
