<?php
session_start();
require_once("../Modelos/VehiculoModel.php");
require_once("../Modelos/ClienteModel.php");

class VehiculoControlador
{
    private $vehiculoModel;
    private $clienteModel;

    public function __construct()
    {
        $this->vehiculoModel = new VehiculoModel();
        $this->clienteModel = new ClienteModel();
    }

    // ======================== CLIENTE: FORMULARIO ========================
    public function FormRegistrar()
    {
        // Verificar si hay sesión iniciada
        if (!isset($_SESSION['id_usuario'])) {
            header("Location: ../Vistas/Home.php?mensaje=Debes iniciar sesión para registrar tu vehículo.&tipo=warning");
            exit();
        }

        // Si es cliente normal, debe tener un cliente asociado
        if ($_SESSION['rol'] === 'cliente') {
            $cliente = $this->clienteModel->obtenerPorUsuario($_SESSION['id_usuario']);

            if (!$cliente) {
                header("Location: ../Vistas/Home.php?mensaje=No se encontró un cliente asociado a tu usuario.&tipo=danger");
                exit();
            }

            // Guardar id_cliente en sesión solo para clientes
            $_SESSION['id_cliente'] = $cliente['id_cliente'];
        }

        // Mostrar el formulario de registro de vehículo
        include("../Vistas/RegistrarVehiculo.php");
    }


    // ======================== CLIENTE: REGISTRO ========================
    public function Registrar()
    {
        if (!isset($_SESSION['id_usuario'])) {
            header("Location: ../Vistas/Login.php?mensaje=Debes iniciar sesión.&tipo=warning");
            exit();
        }
        $placa = trim($_POST['placa'] ?? '');
        $marcaYmodelo = trim($_POST['marcaYmodelo'] ?? '');
        $anio = $_POST['anio_fabricacion'] ?? '';
        $id_cliente = $_POST['id_cliente'] ?? ($_SESSION['id_cliente'] ?? '');
        
        

        // Validar campos
        if (empty($id_cliente) || empty($placa) || empty($marcaYmodelo) || empty($anio)) {
            if ($_SESSION['rol'] === 'administrador') {
                header("Location: VehiculoControlador.php?accion=GestionAdmin&mensaje=Campos incompletos.&tipo=warning");
            } else {
                header("Location: ../Vistas/Home.php?mensaje=Campos incompletos.&tipo=warning");
            }
            exit();
        }

        // Validar placa duplicada
        if ($this->vehiculoModel->placaExiste($placa)) {
            if ($_SESSION['rol'] === 'administrador') {
                header("Location: VehiculoControlador.php?accion=GestionAdmin&mensaje=Ya existe un vehículo con esa placa.&tipo=danger");
            } else {
                header("Location: ../Vistas/Home.php?mensaje=Ya existe un vehículo con esa placa.&tipo=danger");
            }
            exit();
        }

        // Registrar
        $ok = $this->vehiculoModel->insertarVehiculo($placa, $marcaYmodelo, $anio, $id_cliente);

        if ($ok) {
            if ($_SESSION['rol'] === 'administrador') {
                header("Location: VehiculoControlador.php?accion=GestionAdmin&mensaje=Vehículo registrado correctamente!&tipo=success");
            } else {
                header("Location: ../Vistas/Home.php?mensaje=Vehículo registrado correctamente!&tipo=success");
            }
        } else {
            if ($_SESSION['rol'] === 'administrador') {
                header("Location: VehiculoControlador.php?accion=GestionAdmin&mensaje=Error al registrar vehículo.&tipo=danger");
            } else {
                header("Location: ../Vistas/Home.php?mensaje=Error al registrar vehículo.&tipo=danger");
            }
        }

        exit();
    }



    // ======================== ADMIN: GESTIÓN ========================
    public function GestionAdmin()
    {
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
            header("Location: ../Vistas/Home.php?mensaje=Acceso denegado.&tipo=danger");
            exit();
        }

        // Cargar todos los vehículos con sus clientes
        $vehiculos = $this->vehiculoModel->obtenerTodos();

        // Cargar todos los clientes para el select
        $clientes = $this->clienteModel->obtenerTodos();

        $mensaje = $_GET['mensaje'] ?? '';
        $tipo = $_GET['tipo'] ?? '';

        include("../Vistas/GestionVehiculos.php");
    }


    // ======================== ADMIN: EDITAR ========================
    public function FormEditar($id)
    {
        // Verifica sesión
        if (!isset($_SESSION['id_usuario'])) {
            header("Location: ../Vistas/Home.php?mensaje=Debes iniciar sesión.&tipo=warning");
            exit();
        }

        // Obtiene los datos del vehículo por ID
        $vehiculo = $this->vehiculoModel->obtenerPorId($id);

        if (!$vehiculo) {
            header("Location: VehiculoControlador.php?accion=GestionAdmin&mensaje=Vehículo no encontrado.&tipo=danger");
            exit();
        }

        // Obtiene todos los clientes para el combo (solo si eres admin)
        $clientes = $this->clienteModel->obtenerTodos();

        // Variables para la vista
        $mensaje = $_GET['mensaje'] ?? '';
        $tipo = $_GET['tipo'] ?? '';

        include("../Vistas/EditarVehiculo.php");
    }


    public function Editar()
    {
        $id = $_POST['id_automovil'] ?? null;
        $placa = strtoupper(trim($_POST['placa'] ?? ''));
        $marcaYmodelo = trim($_POST['marcaYmodelo'] ?? '');
        $anio_fabricacion = $_POST['anio_fabricacion'] ?? '';
        $id_cliente = $_POST['id_cliente'] ?? '';

        if (!$id || empty($placa) || empty($marcaYmodelo)) {
            header("Location: VehiculoControlador.php?accion=GestionAdmin&mensaje=Campos incompletos.&tipo=warning");
            exit();
        }

        $ok = $this->vehiculoModel->editarVehiculo($id, $placa, $marcaYmodelo, $anio_fabricacion, $id_cliente);

        if ($ok) {
            header("Location: VehiculoControlador.php?accion=GestionAdmin&mensaje=Vehículo actualizado correctamente.&tipo=success");
        } else {
            header("Location: VehiculoControlador.php?accion=GestionAdmin&mensaje=Error al actualizar el vehículo.&tipo=danger");
        }
        exit();
    }

    // ======================== ADMIN: ELIMINAR ========================
    public function Eliminar($id)
    {
        $ok = $this->vehiculoModel->eliminarVehiculo($id);

        if ($ok) {
            header("Location: VehiculoControlador.php?accion=GestionAdmin&mensaje=Vehículo eliminado correctamente.&tipo=success");
        } else {
            header("Location: VehiculoControlador.php?accion=GestionAdmin&mensaje=Error al eliminar el vehículo.&tipo=danger");
        }
        exit();
    }
    public function Actualizar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_automovil'] ?? '';
            $placa = strtoupper(trim($_POST['placa'] ?? ''));
            $marcaYmodelo = trim($_POST['marcaYmodelo'] ?? '');
            $anio_fabricacion = $_POST['anio_fabricacion'] ?? '';
            $id_cliente = $_POST['id_cliente'] ?? '';

            if (empty($id) || empty($placa) || empty($marcaYmodelo) || empty($anio_fabricacion) || empty($id_cliente)) {
                header("Location: ../Controladores/VehiculoControlador.php?accion=GestionAdmin&mensaje=Campos incompletos.&tipo=warning");
                exit();
            }

            $ok = $this->vehiculoModel->actualizarVehiculo($id, $placa, $marcaYmodelo, $anio_fabricacion, $id_cliente);

            if ($ok) {
                header("Location: ../Controladores/VehiculoControlador.php?accion=GestionAdmin&mensaje=Vehículo actualizado correctamente.&tipo=success");
            } else {
                header("Location: ../Controladores/VehiculoControlador.php?accion=GestionAdmin&mensaje=Error al actualizar el vehículo.&tipo=danger");
            }
            exit();
        }
    }


}

// =================== CONTROLADOR PRINCIPAL ===================
$accion = $_GET['accion'] ?? ($_POST['accion'] ?? '');

$vehiculoCtrl = new VehiculoControlador();

switch ($accion) {
    case 'Formulario':
        $vehiculoCtrl->FormRegistrar();
        break;
    case 'Registrar':
        $vehiculoCtrl->Registrar();
        break;
    case 'GestionAdmin':
        $vehiculoCtrl->GestionAdmin();
        break;
    case 'Editar':
        $vehiculoCtrl->Editar();
        break;
    case 'FormEditar':
        $vehiculoCtrl->FormEditar($_GET['id']);
        break;
    case 'Eliminar':
        $vehiculoCtrl->Eliminar($_GET['id']);
        break;
    case 'Actualizar':
        $vehiculoCtrl->Actualizar();
        break;
    default:
        header("Location: ../Vistas/Home.php");
        break;
}
?>