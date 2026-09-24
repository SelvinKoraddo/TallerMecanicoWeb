<?php
require_once("../Controladores/ClienteControlador.php");
$clienteCtrl = new ClienteControlador();
$clientes = $clienteCtrl->Listar(true); //pasamos true para que devuelva los datos

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motor Masters | Panel de Administración</title>
    <script src="./JS/scriptAdm.js" defer></script>
    <link rel="stylesheet" href="./CSS/estilosPanelAdmin.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
</head>

<body class="p-4">
    <i class="bi bi-list hamburger" id="openSidebar"></i><!--boton amburguesa-->
    <div class="hero">
        <div class="container">
            <h3 class="text-center mb-4">Gestión de Clientes</h3>
            <?php if (isset($mensaje)): ?>
                <div class="alert alert-info"><?= $mensaje ?></div>
            <?php endif; ?>

            <div class="mb-3 text-end">
                <a href="../Controladores/ClienteControlador.php?accion=Formulario" class="btn btn-primary">+ Nuevo
                    Cliente</a>
            </div>

            <table class="table table-bordered table-striped">

                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>DUI</th>
                        <th>Fecha Nac.</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($clientes) && is_array($clientes)): ?>
                        <?php foreach ($clientes as $c): ?>
                            <tr>
                                <td><?= htmlspecialchars($c['id_cliente']) ?></td>
                                <td><?= htmlspecialchars($c['nombre_cliente']) ?></td>
                                <td><?= htmlspecialchars($c['correo']) ?></td>
                                <td><?= htmlspecialchars($c['numero_telefono']) ?></td>
                                <td><?= htmlspecialchars($c['numero_dui']) ?></td>
                                <td><?= htmlspecialchars($c['fecha_nacimiento']) ?></td>
                                <td>
                                    <a class="btn btn-warning btn-sm"
                                        href="../Controladores/ClienteControlador.php?accion=Editar&id=<?= $c['id_cliente'] ?>">Editar</a>
                                    <a class="btn btn-danger btn-sm"
                                        href="../Controladores/ClienteControlador.php?accion=Eliminar&id=<?= $c['id_cliente'] ?>"
                                        onclick="return confirm('¿Eliminar este cliente?');">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">No hay clientes registrados</td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>

    </div>

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
                <a href="../Vistas/adminPanel.php" class="nav-link"><i class="bi bi-clock-fill"></i> Gestion de clientes</a>
            </li>
            <li class="nav-item">
                <a href="../Controladores/VehiculoControlador.php?accion=GestionAdmin" class="nav-link">
                    <i class="bi bi-table"></i> Gestión de Vehículos
                </a>

            </li>
            <li class="nav-item">
                <a href="../Controladores/ServicioControlador.php?accion=Gestionar" class="nav-link"><i class="bi bi-box-arrow-in-right"></i> Gestion de Servicios</a>
            </li>
            <li class="nav-item">
                <a href="../Controladores/OrdenControlador.php?accion=Gestionar" class="nav-link"><i class="bi bi-box-arrow-in-right"></i> Gestion ordenes de
                    trabajo</a>
            </li>
            <li class="nav-item">
                <a href="../Controladores/UsuarioControlador.php?Tipo=Logout" class="nav-link"><i
                        class="bi bi-box-arrow-in-left"></i> Cerrar Sesion</a>
            </li>

        </ul>
    </div><!-- =============FIN Sidebar================== -->

    <footer class="footer text-center text-light py-3">
        <p>© 2025 Motor Masters</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
        </script>

</body>

</html>