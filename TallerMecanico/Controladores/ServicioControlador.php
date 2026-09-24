<?php
session_start();
require_once("../Modelos/ServicioModel.php");

class ServicioControlador
{
    private $servicioModel;

    public function __construct()
    {
        $this->servicioModel = new ServicioModel();
    }

    // Mostrar lista de servicios
    public function Gestionar()
    {
        $servicios = $this->servicioModel->obtenerTodos();
        $mensaje = $_GET['mensaje'] ?? '';
        $tipo = $_GET['tipo'] ?? '';
        include("../Vistas/GestionServicios.php");
    }

    // Insertar servicio nuevo
    public function Registrar()
    {
        $nombre = trim($_POST['nombre_servicio'] ?? '');
        $descripcion = trim($_POST['descripcion_servicio'] ?? '');
        $precio = $_POST['precio_servicio'] ?? '';

        if (empty($nombre) || empty($descripcion) || empty($precio)) {
            header("Location: ../Controladores/ServicioControlador.php?accion=Gestionar&mensaje=Campos incompletos.&tipo=warning");
            exit();
        }

        $ok = $this->servicioModel->insertar($nombre, $descripcion, $precio);

        if ($ok)
            header("Location: ../Controladores/ServicioControlador.php?accion=Gestionar&mensaje=Servicio registrado correctamente.&tipo=success");
        else
            header("Location: ../Controladores/ServicioControlador.php?accion=Gestionar&mensaje=Error al registrar el servicio.&tipo=danger");
        exit();
    }

    // Editar
    public function FormEditar($id)
    {
        $servicio = $this->servicioModel->obtenerPorId($id);
        $mensaje = $_GET['mensaje'] ?? '';
        $tipo = $_GET['tipo'] ?? '';
        include("../Vistas/EditarServicio.php");
    }

    public function Actualizar()
    {
        $id = $_POST['id_servicio'] ?? '';
        $nombre = trim($_POST['nombre_servicio'] ?? '');
        $descripcion = trim($_POST['descripcion_servicio'] ?? '');
        $precio = $_POST['precio_servicio'] ?? '';

        if (empty($id) || empty($nombre) || empty($descripcion) || empty($precio)) {
            header("Location: ../Controladores/ServicioControlador.php?accion=Gestionar&mensaje=Campos incompletos.&tipo=warning");
            exit();
        }

        $ok = $this->servicioModel->actualizar($id, $nombre, $descripcion, $precio);

        if ($ok)
            header("Location: ../Controladores/ServicioControlador.php?accion=Gestionar&mensaje=Servicio actualizado correctamente.&tipo=success");
        else
            header("Location: ../Controladores/ServicioControlador.php?accion=Gestionar&mensaje=Error al actualizar el servicio.&tipo=danger");
        exit();
    }

    // Eliminar
    public function Eliminar($id)
    {
        $ok = $this->servicioModel->eliminar($id);

        if ($ok)
            header("Location: ../Controladores/ServicioControlador.php?accion=Gestionar&mensaje=Servicio eliminado correctamente.&tipo=success");
        else
            header("Location: ../Controladores/ServicioControlador.php?accion=Gestionar&mensaje=Error al eliminar el servicio.&tipo=danger");
        exit();
    }
}

// ==== RUTAS ====
$accion = $_GET['accion'] ?? '';
$ctrl = new ServicioControlador();

switch ($accion) {
    case 'Registrar':
        $ctrl->Registrar();
        break;
    case 'FormEditar':
        $ctrl->FormEditar($_GET['id']);
        break;
    case 'Actualizar':
        $ctrl->Actualizar();
        break;
    case 'Eliminar':
        $ctrl->Eliminar($_GET['id']);
        break;
    default:
        $ctrl->Gestionar();
        break;
}
?>