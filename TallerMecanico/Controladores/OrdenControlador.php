<?php
session_start();
require_once("../Modelos/OrdenModel.php");
require_once("../Modelos/VehiculoModel.php");
require_once("../Modelos/ServicioModel.php");

class OrdenControlador
{
    private $ordenModel;
    private $vehiculoModel;
    private $servicioModel;

    public function __construct()
    {
        $this->ordenModel = new OrdenModel();
        $this->vehiculoModel = new VehiculoModel();
        $this->servicioModel = new ServicioModel();
    }

    // Mostrar vista de gestión
    public function Gestionar()
    {
        $estado = $_GET['estado'] ?? null;
        $ordenes = $this->ordenModel->obtenerTodas($estado);
        $vehiculos = $this->vehiculoModel->obtenerTodos();
        $servicios = $this->servicioModel->obtenerTodos();
        $mensaje = $_GET['mensaje'] ?? '';
        $tipo = $_GET['tipo'] ?? '';
        include("../Vistas/GestionOrdenes.php");
    }

    // Registrar nueva orden
    public function Registrar()
    {
        if (!isset($_SESSION['id_usuario'])) {
            header("Location: ../Vistas/Login.php?mensaje=Debes iniciar sesión.&tipo=warning");
            exit();
        }

        $id_automovil = $_POST['id_automovil'] ?? '';
        $id_servicio = $_POST['id_servicio'] ?? '';

        if (empty($id_automovil) || empty($id_servicio)) {
            header("Location: OrdenControlador.php?accion=Gestionar&mensaje=Campos incompletos.&tipo=warning");
            exit();
        }

        // Evitar duplicados
        if ($this->ordenModel->existeOrdenActiva($id_automovil, $id_servicio)) {
            if ($_SESSION['rol'] === 'administrador') {
                header("Location: OrdenControlador.php?accion=Gestionar&mensaje=Ya existe una orden activa para ese vehículo y servicio.&tipo=danger");
            } else {
                header("Location: ../Vistas/Home.php?mensaje=Ya existe una orden activa para ese vehículo y servicio.&tipo=danger");
            }
            exit();
        }

        // Insertar nueva orden
        $ok = $this->ordenModel->insertar($id_automovil, $id_servicio);

        if ($ok) {
            if ($_SESSION['rol'] === 'administrador') {
                header("Location: OrdenControlador.php?accion=Gestionar&mensaje=Orden registrada correctamente.&tipo=success");
            } else {
                header("Location: ../Vistas/Home.php?mensaje=Orden registrada correctamente.&tipo=success");
            }
        } else {
            if ($_SESSION['rol'] === 'administrador') {
                header("Location: OrdenControlador.php?accion=Gestionar&mensaje=Error al registrar la orden.&tipo=danger");
            } else {
                header("Location: ../Vistas/Home.php?mensaje=Error al registrar la orden.&tipo=danger");
            }
        }

        exit();
    }



    // Cambiar estado de orden
    public function CambiarEstado()
    {
        $id = $_GET['id'] ?? '';
        $nuevo_estado = $_GET['estado'] ?? '';

        if (empty($id) || empty($nuevo_estado)) {
            header("Location: OrdenControlador.php?accion=Gestionar&mensaje=Datos incompletos.&tipo=warning");
            exit();
        }

        $ok = $this->ordenModel->actualizarEstado($id, $nuevo_estado);

        if ($ok)
            header("Location: OrdenControlador.php?accion=Gestionar&mensaje=Estado actualizado correctamente.&tipo=success");
        else
            header("Location: OrdenControlador.php?accion=Gestionar&mensaje=Error al actualizar el estado.&tipo=danger");
        exit();
    }

    // Eliminar orden
    public function Eliminar()
    {
        $id = $_GET['id'] ?? '';
        $ok = $this->ordenModel->Eliminar($id);

        if ($ok)
            header("Location: OrdenControlador.php?accion=Gestionar&mensaje=Orden eliminada correctamente.&tipo=success");
        else
            header("Location: OrdenControlador.php?accion=Gestionar&mensaje=Error al eliminar la orden.&tipo=danger");
        exit();
    }
    public function FormRegistrar()
    {
        if (!isset($_SESSION['id_usuario'])) {
            header("Location: ../Vistas/Login.php?mensaje=Debes iniciar sesión para solicitar un servicio.&tipo=warning");
            exit();
        }

        $id_servicio = $_GET['id_servicio'] ?? null;
        if (!$id_servicio) {
            header("Location: ../Vistas/Home.php?mensaje=Servicio no válido.&tipo=danger");
            exit();
        }

        require_once("../Modelos/VehiculoModel.php");
        $vehiculoModel = new VehiculoModel();
        $vehiculos = $vehiculoModel->obtenerConCliente($_SESSION['id_usuario']); // función que debes tener en VehiculoModel

        include("../Vistas/RegistrarOrden.php");
    }

}

// ==== Enrutamiento ====
$accion = $_POST['accion'] ?? $_GET['accion'] ?? 'Gestionar';
$ctrl = new OrdenControlador();

switch ($accion) {
    case 'Registrar':
        $ctrl->Registrar();
        break;

    case 'FormRegistrar':
        $ctrl->FormRegistrar();
        break;

    case 'CambiarEstado':
        $ctrl->CambiarEstado();
        break;

    case 'Eliminar':
        $ctrl->Eliminar();
        break;

    default:
        $ctrl->Gestionar();
        break;
}
?>