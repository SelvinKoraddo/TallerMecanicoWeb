<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motor Masters | Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
</head>

<body class="p-4">
    <i class="bi bi-list hamburger" id="openSidebar"></i><!--boton amburguesa-->
    <div class="hero">
        <h2 class="text-center mb-4 text-primary fw-bold">Gestión de Vehículos</h2>

        <?php if ($mensaje): ?>
            <div class="alert alert-<?= htmlspecialchars($tipo) ?> alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($mensaje) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- ====================== FORMULARIO DE REGISTRO ====================== -->
        <div class="card mb-4 shadow">
            <div class="card-header bg-primary text-white fw-bold">
                Registrar Nuevo Vehículo
            </div>
            <div class="card-body">
                <form action="../Controladores/VehiculoControlador.php?accion=Registrar" method="POST">
                    <div class="row g-2 align-items-end">
                        <div class="col-md-4">
                            <p>Seleccione un cliente:</p>
                            <select name="id_cliente" class="form-select" required>
                                <?php foreach ($clientes as $c): ?>
                                    <option value="<?= $c['id_cliente'] ?>"><?= htmlspecialchars($c['nombre_cliente']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <p>Ingrese la placa del vehículo:</p>
                            <input type="text" name="placa" class="form-control" placeholder="P123ABC" required>
                        </div>
                        <div class="col-md-3">
                            <p>Ingrese la marca y modelo:</p>
                            <input type="text" name="marcaYmodelo" class="form-control" placeholder="Toyota Corolla"
                                required>
                        </div>
                        <div class="col-md-2">
                            <p>Ingrese el año de fabricación:</p>
                            <input type="number" name="anio_fabricacion" class="form-control" min="1900" max="<?= date('Y') ?>"required>
                        </div>
                        <div class="col-md-1 text-end">
                            <button type="submit" class="btn btn-success w-200">
                                <i class="bi bi-plus-circle"></i> Registrar
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>

        <!-- ====================== LISTADO DE VEHÍCULOS ====================== -->
        <div class="card shadow">
            <div class="card-header bg-dark text-white fw-bold">
                Lista de Vehículos Registrados
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>ID</th>
                            <th>Placa</th>
                            <th>Marca y Modelo</th>
                            <th>Año</th>
                            <th>Propietario</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($vehiculos): ?>
                            <?php foreach ($vehiculos as $v): ?>
                                <tr>
                                    <td><?= $v['id_automovil'] ?></td>
                                    <td><?= htmlspecialchars($v['placa']) ?></td>
                                    <td><?= htmlspecialchars($v['marcaYmodelo']) ?></td>
                                    <td><?= htmlspecialchars($v['anio_fabricacion']) ?></td>
                                    <td><?= htmlspecialchars($v['nombre_cliente']) ?></td>
                                    <td class="text-center">
                                        <a href="../Controladores/VehiculoControlador.php?accion=FormEditar&id=<?= $v['id_automovil'] ?>"
                                            class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i> Editar
                                        </a>

                                        <a href="../Controladores/VehiculoControlador.php?accion=Eliminar&id=<?= $v['id_automovil'] ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('¿Seguro que desea eliminar este vehículo?');">
                                            <i class="bi bi-trash"></i> Eliminar
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">No hay vehículos registrados.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="../Vistas/adminPanel.php" class="btn btn-secondary">Volver al Panel</a>
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
                <a href="../Vistas/adminPanel.php" class="nav-link active"><i class="bi bi-house"></i> Home</a>
            </li>
            <li class="nav-item">
                <a href="../Vistas/adminPanel.php" class="nav-link"><i class="bi bi-clock-fill"></i> Gestion de
                    clientes</a>
            </li>
            <li class="nav-item">
                <a href="../Controladores/VehiculoControlador.php?accion=GestionAdmin" class="nav-link"><i class="bi bi-table"></i> Gestion de vehiculos</a>
            </li>
            <li class="nav-item">
                <a href="../Vistas/GestionServicios.php" class="nav-link"><i class="bi bi-box-arrow-in-right"></i> Gestion de Servicios</a>
            </li>
            <li class="nav-item">
                <a href="../Controladores/OrdenControlador.php?accion=Gestionar" class="nav-link"><i class="bi bi-box-arrow-in-right"></i> Gestion ordenes de
                    trabajo</a>
            </li>
            <li class="nav-item">
                <a href="../Controladores/UsuarioControlador.php?Tipo=Logout" class="nav-link"><i class="bi bi-box-arrow-in-left"></i> Cerrar Sesion</a>
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
<style>
    .p-4 {
        font-family: system-ui, sans-serif;
        background-color: #011423;
    }

    .hero {
        color: white;
        text-align: center;
        width: 100%;
        padding: 20px;
        transition: margin-left 0.3s ease, width 0.3s ease;
        min-height: 100vh;
        box-sizing: border-box;
    }

    .hero.shifted {
        margin-left: 250px;
        /* ajusta según el ancho de tu sidebar */
        width: calc(100% - 250px);
        /* Resta el ancho del sidebar */
    }

    .hamburger {
        position: fixed;
        color: #ffffff !important;
    }

    /* ============Estilo del SIDEBAR==============*/
    .sidebar {
        width: 250px;
        height: 100vh;
        position: fixed;
        top: 0;
        left: -250px;
        /* Oculto inicialmente */
        background: #292121;
        color: #fff;
        transition: all 0.3s;
        z-index: 1050;
        padding-top: 1rem;
    }

    .sidebar.active {
        left: 0;
    }

    .sidebar .nav-link {
        color: #fff;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
        background: #0d6efd;
        color: #fff;
    }

    .sidebar .close-btn {
        position: absolute;
        top: 15px;
        right: 15px;
        font-size: 1.5rem;
        cursor: pointer;
        color: #fff;
    }

    /* Botón hamburguesa */
    .hamburger {
        font-size: 1.8rem;
        cursor: pointer;
        color: #212529;
    }

    /* ============fin Estilo del SIDEBAR==============*/
    .footer.shifted {
        margin-left: 250px;
        /* igual al ancho del sidebar */
        transition: margin-left 0.3s ease;
    }
</style>
<script>
    const sidebar = document.getElementById("sidebar");
    const openBtn = document.getElementById("openSidebar");
    const closeBtn = document.getElementById("closeSidebar");
    const footer = document.querySelector('.footer');
    const herotxt = document.querySelector(".hero");

    openBtn.addEventListener("click", () => {
        sidebar.classList.add("active");
        openBtn.style.display = "none"; //Oculta el botón hamburguesa
        footer.classList.add('shifted');
        herotxt.classList.add('shifted');
    });

    closeBtn.addEventListener("click", () => {
        sidebar.classList.remove("active");
        openBtn.style.display = "block"; //volver a mostrar el boton burguer
        footer.classList.remove('shifted');
        herotxt.classList.remove('shifted');

    });

</script>

</html>