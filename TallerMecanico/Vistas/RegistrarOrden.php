<?php
if (session_status() === PHP_SESSION_NONE) {
session_start();
}
require_once("../Modelos/Conexion.php");
require_once("../Modelos/ServicioModel.php");

$id_servicio = $_GET['id_servicio'] ?? null;
if (!$id_servicio) {
    header("Location: Home.php");
    exit();
}

$db = (new Conexion())->getConexion();
$stmt = $db->prepare("SELECT * FROM servicios WHERE id_servicio = ?");
$stmt->execute([$id_servicio]);
$servicio = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registrar Orden | Motor Masters</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5 p-4 bg-white shadow rounded" style="max-width: 600px;">
  <h3 class="text-center mb-4">Registrar Orden de Servicio AA</h3>

  <form action="../Controladores/OrdenControlador.php?accion=Registrar" method="POST">
    <input type="hidden" name="accion" value="Registrar">
    <input type="hidden" name="id_servicio" value="<?= $servicio['id_servicio'] ?>">

    <div class="mb-3">
      <label class="form-label">Servicio</label>
      <input type="text" class="form-control" value="<?= htmlspecialchars($servicio['nombre_servicio']) ?>" disabled>
    </div>

    <div class="mb-3">
      <label class="form-label">Selecciona tu Vehículo</label>
      <select name="id_automovil" class="form-select" required>
        <option value="">Seleccione...</option>
        <?php foreach ($vehiculos as $v): ?>
          <option value="<?= $v['id_automovil'] ?>">
            <?= htmlspecialchars($v['placa']) ?> - <?= htmlspecialchars($v['marcaYmodelo']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <button type="submit" class="btn btn-success w-100">Registrar Orden</button>
    <a href="../Vistas/Home.php" class="btn btn-secondary mt-2 w-100">Volver</a>
  </form>
</div>

</body>
<style>
    .bg-light {
        background-color: #011423 !important;        /*COLOR CHIDO*/
    }
</style>
</html>
