<?php
session_start();
$mensaje = $_GET['mensaje'] ?? '';
$tipo = $_GET['tipo'] ?? '';
require_once("../Modelos/Conexion.php");

// Conexión a la BD
$db = (new Conexion())->getConexion();

// Obtener servicios existentes
$stmt = $db->query("SELECT * FROM servicios ORDER BY id_servicio DESC");
$servicios = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
 
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Motor Master</title>
  <script src="./JS/java.js" defer></script>
  <link rel="stylesheet" href="./CSS/estilos.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />

</head>

<body>
  <div class="hero">
    <img src="./IMG/HomePresentacion.jpg" alt="auto clásico" class="hero-img">

    <div class="hero-overlay"></div> <!-- capa oscura -->

    <div class="hero-text">

      <h1 class="display-4 fw-bold text-white">
        BIENVENIDO A MOTOR MASTERS
        <?php
        if (isset($_SESSION['nombre'])) {
          // separa el primer nombre antes del primer espacio
          $primerNombre = explode(' ', $_SESSION['nombre'])[0];
          echo strtoupper($primerNombre); // lo muestra en mayúsculas para mantener el estilo
        }
        ?>
      </h1>
      <?php if (!empty($mensaje)): ?>
        <div class="alert alert-<?= htmlspecialchars($tipo) ?> alert-dismissible fade show text-center mt-3" role="alert"
          style="max-width: 600px; margin: 0 auto;">
          <?= htmlspecialchars($mensaje) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>



      <h2>Taller de Reparación de Autos</h2>
      <p>Ofrecemos servicios de mantenimiento y reparación de automóviles de primera calidad.</p>
    </div>

    <i class="bi bi-list hamburger" id="openSidebar"></i><!--boton amburguesa-->

  </div>

  <div class="contenedorPrincipal" id="ContenidoPrincipal">

    <!-- ===== SECCIÓN SERVICIOS ===== -->
    <section class="container my-0 py-5 text-center" id="servicios">
      <h2 class="fw-bold text-warning mb-4">
        <i class="bi bi-tools me-2"></i> Nuestros Servicios
      </h2>
      <p class="text-light mb-5">
        Contamos con personal especializado y equipo moderno para el mantenimiento de tu vehículo.
        ¿Que tipo de reparación necesita?
      </p>

      <div class="row g-4">
        <!-- Tarjeta de servicio 1 -->
        <div class="col-md-4 col-lg-3">
          <div class="card service-card h-100 text-light text-center p-4 cambio-aceite">
            <i class="bi bi-droplet-half service-icon"></i>
            <div class="service-card-overlay"></div>
            <div class="info">
              <h5 class="mt-3 fw-bold">Cambio de Aceite</h5>
              <p class="small">Reemplazo de aceite del motor y filtro con revisión general.</p>
              <p class="text-warning fw-bold mb-0">$30</p>
            </div>
          </div>
        </div>


        <!-- Tarjeta de servicio 2 -->
        <div class="col-md-4 col-lg-3">
          <div class="card service-card h-100 text-light text-center p-4 alineacion">
            <i class="bi bi-speedometer2 service-icon"></i>
            <div class="service-card-overlay"></div>
            <div class="info">
              <h5 class="mt-3 fw-bold">Alineación y Balanceo</h5>
              <p class="small">Ajuste preciso del ángulo de las ruedas para mayor estabilidad.</p>
              <p class="text-warning fw-bold mb-0">$40</p>
            </div>

          </div>
        </div>

        <!-- Tarjeta de servicio 3 -->
        <div class="col-md-4 col-lg-3">
          <div class="card service-card h-100 text-light text-center p-4 revision-electrica">
            <i class="bi bi-battery-charging service-icon"></i>
            <div class="service-card-overlay"></div>
            <div class="info">
              <h5 class="mt-3 fw-bold">Revisión Eléctrica</h5>
              <p class="small">Diagnóstico de batería, alternador y luces del vehículo.</p>
              <p class="text-warning fw-bold mb-0">$25</p>
            </div>

          </div>
        </div>

        <!-- Tarjeta de servicio 4 -->
        <div class="col-md-4 col-lg-3">
          <div class="card service-card h-100 text-light text-center p-4 servicio-frenos">
            <i class="bi bi-gear-wide-connected service-icon"></i>
            <div class="service-card-overlay"></div>
            <div class="info">
              <h5 class="mt-3 fw-bold">Servicio de Frenos</h5>
              <p class="small">Reemplazo de pastillas y revisión completa del sistema de frenos.</p>
              <p class="text-warning fw-bold mb-0">$50</p>
            </div>
          </div>
        </div>
      </div>
      <br>

    </section><!-- ===== FIN SECCIÓN SERVICIOS ===== -->


    <!-- ========== INICIO  Section AGREGADOS RECIENTE========== -->
    <div class="container mt-4">
      <h2>Servicios Agregados recientemente</h2>
      <br><br>
      <div class="row justify-content-center">

        <?php if (!empty($servicios)): ?>
          <?php foreach ($servicios as $s): ?>
            <div class="col-md-4 col-lg-3 mb-4">
              <div class="card shadow-sm h-100 text-center border-0">
                <div class="card-body">
                  <h5 class="card-title fw-bold text-primary"><?= htmlspecialchars($s['nombre_servicio']) ?></h5>
                  <p class="card-text small text-muted"><?= htmlspecialchars($s['descripcion_servicio']) ?></p>
                  <p class="fw-bold text-success">$<?= htmlspecialchars($s['precio_servicio']) ?></p>
                  <a href="../Controladores/OrdenControlador.php?accion=FormRegistrar&id_servicio=<?= $s['id_servicio'] ?>"
                    class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-plus-circle"></i> Solicitar Servicio
                  </a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="text-light text-center">No hay servicios registrados aún.</p>
        <?php endif; ?>
      </div>
    </div>
    <!-- ========== FIN  Section AGREGADOS RECIENTE========== -->


    <!-- ========== INICIO Section HISTORIAL ORDENES ========== -->
    <?php
    if (isset($_SESSION['id_usuario'])) {
      $stmt = $db->prepare("
        SELECT o.id_orden, s.nombre_servicio, o.estado_servicio, o.fecha_orden, a.placa
        FROM ordendeservicio o
        INNER JOIN servicios s ON o.id_servicio = s.id_servicio
        INNER JOIN automovil a ON o.id_automovil = a.id_automovil
        INNER JOIN clientes c ON a.id_cliente = c.id_cliente
        WHERE c.id_usuario = ?
        ORDER BY o.fecha_orden DESC
    ");
      $stmt->execute([$_SESSION['id_usuario']]);
      $ordenes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    ?>

    <div class="container mt-5" id="Hist">
      <h3 class="text-light text-center mb-4"><i class="bi bi-list-check"></i> Mis Órdenes de Trabajo</h3>
      <div class="table-responsive bg-white rounded shadow">
        <table class="table table-striped mb-0">
          <thead class="table-dark">
            <tr>
              <th>Vehículo</th>
              <th>Servicio</th>
              <th>Fecha</th>
              <th>Estado</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($ordenes)): ?>
              <?php foreach ($ordenes as $o): ?>
                <tr>
                  <td><?= htmlspecialchars($o['placa']) ?></td>
                  <td><?= htmlspecialchars($o['nombre_servicio']) ?></td>
                  <td><?= htmlspecialchars($o['fecha_orden']) ?></td>
                  <td><?= ucfirst($o['estado_servicio']) ?></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="4" class="text-center">No tienes órdenes registradas.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
    <!-- ========== FIN  Section HISTORIAL ORDENES========== -->

    <br><br>
    <!-- ===== Panel Horarios de Atención ===== -->
    <section class="container my-0 py-5" id="HDA">
      <div class="card shadow-lg border-0 info-panel" id="inf">
        <div class="card-body p-4 text-center text-light">
          <h3 class="mb-4 fw-bold">
            <i class="bi bi-clock-history me-2"></i> Horarios de Atención
          </h3>

          <div class="row mb-3">
            <div class="col-md-4 mb-3 mb-md-0">
              <div class="p-3 bg-dark rounded-3">
                <h5 class="fw-bold">Lunes a Viernes</h5>
                <p class="mb-0">8:00 a.m. – 5:30 p.m.</p>
              </div>
            </div>
            <div class="col-md-4 mb-3 mb-md-0">
              <div class="p-3 bg-dark rounded-3">
                <h5 class="fw-bold">Sábado</h5>
                <p class="mb-0">8:00 a.m. – 12:00 p.m.</p>
              </div>
            </div>
            <div class="col-md-4">
              <div class="p-3 bg-dark rounded-3">
                <h5 class="fw-bold">Domingo</h5>
                <p class="mb-0">Cerrado</p>
              </div>
            </div>
          </div>

          <hr class="bg-light">

          <div class="contact-info mt-3">
            <p class="mb-1">
              <i class="bi bi-geo-alt-fill me-2"></i>
              Calle Principal #42, Ahuachapán, El Salvador
            </p>
            <p class="mb-1">
              <i class="bi bi-telephone-fill me-2"></i> (503) 7123-4567
            </p>
            <p class="mb-4">
              <i class="bi bi-envelope-fill me-2"></i> contacto@motormasters.com
            </p>
          </div>
        </div>
      </div>
    </section>
    <!-- ===== FIN Panel Horarios de Atención ===== -->



    <!-- ==============Sidebar================ -->
    <div class="sidebar bg-dark" id="sidebar">
      <i class="bi bi-x close-btn" id="closeSidebar"></i>
      <div class="px-3 mb-4 d-flex align-items-center">
        <i class="bi bi-bootstrap fs-3 me-2"></i>
        <span class="fs-5 fw-bold">Motor Masters</span>
      </div>
      <hr class="text-secondary" />
      <ul class="nav flex-column px-2">
        <li class="nav-item">
          <a href="#" class="nav-link active"><i class="bi bi-house"></i> Home</a>
        </li>
        <li class="nav-item">
          <a href="#servicios" class="nav-link"><i class="bi bi-tools"></i> Nuestros servicios</a>
        </li>
        <li class="nav-item">
          <a href="#Hist" class="nav-link"><i class="bi bi-clock-history"></i> Historial Ordenes</a>
        </li>
        <li class="nav-item">
          <a href="#HDA" class="nav-link"><i class="bi bi-clock-fill"></i> Horarios de atencion</a>
        </li>
        <li class="nav-item">
          <a href="../Controladores/VehiculoControlador.php?accion=Formulario" class="nav-link">
            <i class="bi bi-car-front-fill"></i> Registrar Mi Vehículo
          </a>

        </li>
        <li class="nav-item">
          <a href="Login.php" class="nav-link"><i class="bi bi-box-arrow-in-right"></i> iniciar Sesion</a>
        </li>
        <li class="nav-item">
          <a href="../Controladores/UsuarioControlador.php?Tipo=Logout" class="nav-link"><i
              class="bi bi-box-arrow-in-left"></i> Cerrar Sesion</a>
        </li>

      </ul>
    </div><!-- =============FIN Sidebar================== -->
  </div>
  <footer class="footer text-center text-light py-3">
    <p>© 2025 Motor Masters</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
</body>

</html>