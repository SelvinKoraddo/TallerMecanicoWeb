<?php
require_once(__DIR__ . '/../Modelos/ClienteModel.php');
require_once(__DIR__ . '/../Modelos/UsuarioModel.php');

class ClienteControlador
{
    private $clienteModel;
    private $usuarioModel;

    public function __construct()
    {
        $this->clienteModel = new ClienteModel();
        $this->usuarioModel = new UsuarioModel();
    }

    public function Listar($soloDatos = false)
    {
        $clientes = $this->clienteModel->obtenerClientes();

        if ($soloDatos) {
            return $clientes; // para adminPanel
        } 
        //include("../Vistas/adminPanel.php"); // para uso normal del controlador
    }


    public function MostrarFormulario()
    {
        // Form vacío para registrar
        include("../Vistas/FormCliente.php");
    }

    public function Registrar()
    {
        $nombre = trim($_POST['nombre'] ?? '');
        $correo = trim($_POST['correo'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $dui = (int) ($_POST['dui'] ?? 0);
        $fecha_n = $_POST['fecha_nacimiento'] ?? '';
        $contra = $_POST['contra'] ?? '';

        // ========================
        // Validar campos vacíos
        // ========================
        if (!$nombre || !$correo || !$dui || !$fecha_n || !$contra) {
            $mensaje = " Todos los campos requeridos deben llenarse.";
            include("../Vistas/FormCliente.php");
            return;
        }

        // ========================
        // Encriptar contraseña
        // ========================
        $hash = password_hash($contra, PASSWORD_BCRYPT);

        // ========================
        // Insertar en usuarios
        // ========================
        $id_usuario = $this->usuarioModel->insertarUsuario($nombre, $correo, $hash, 'cliente');

        // Si el correo ya está registrado
        if ($id_usuario === "existe_correo") {
            $mensaje = " El correo electrónico ya está registrado. Usa otro o inicia sesión.";
            include("../Vistas/FormCliente.php");
            return;
        }

        // Si hubo un error genérico en la inserción
        if (!$id_usuario) {
            $mensaje = " Error al crear el usuario. Intenta nuevamente.";
            include("../Vistas/FormCliente.php");
            return;
        }

        // ========================
        // Insertar en clientes
        // ========================
        $resultado = $this->clienteModel->insertarCliente(
            (int) $id_usuario,
            $nombre,
            $dui,
            $fecha_n,
            (int) $telefono
        );

        //  el DUI ya existe
        if ($resultado === "existe_dui") {
            $mensaje = "El número de DUI ya está registrado en el sistema.";
            include("../Vistas/FormCliente.php");
            return;
        }

        // Registro correcto
        if ($resultado) {
            $mensaje = "Cliente registrado correctamente.";
            $clientes = $this->clienteModel->obtenerClientes();
            include("../Vistas/adminPanel.php");
        } else {
            $mensaje = "Error al registrar el cliente. Intenta nuevamente.";
            include("../Vistas/FormCliente.php");
        }
    }


    public function EditarCliente()
    {
        $id_cliente = $_GET['id'] ?? 0;

        if (!$id_cliente) {
            echo "ID de cliente inválido.";
            return;
        }

        $cliente = $this->clienteModel->obtenerClientePorId($id_cliente);

        if ($cliente) {
            include("../Vistas/FormCliente.php");
        } else {
            echo "Cliente no encontrado.";
        }
    }


    public function Actualizar()
    {
        $id = (int) $_POST['id_cliente'];
        $nombre = trim($_POST['nombre']);
        $dui = (int) $_POST['dui'];
        $fecha_n = $_POST['fecha_nacimiento'];
        $telefono = (int) $_POST['telefono'];

        $ok = $this->clienteModel->actualizarCliente($id, $nombre, $dui, $fecha_n, $telefono);
        $mensaje = $ok ? "Cliente actualizado." : "No se pudo actualizar.";
        $clientes = $this->clienteModel->obtenerClientes();
        //include("../Vistas/adminPanel.php");
    }

    public function Eliminar()
    {
        $id = (int) ($_GET['id'] ?? 0);
        $this->clienteModel->eliminarCliente($id);
        $mensaje = "Cliente eliminado.";
        $clientes = $this->clienteModel->obtenerClientes();
        include("../Vistas/adminPanel.php");
    }
}

$accion = $_GET['accion'] ?? 'Listar';
$c = new ClienteControlador();

switch ($accion) {
    case 'Listar':
        $c->Listar();
        break;
    case 'Formulario':
        $c->MostrarFormulario();
        break; // Mostrar Form
    case 'Registrar':
        $c->Registrar();
        break;         // POST
    case 'Editar':
        $c->EditarCliente();
        break;
    case 'Actualizar':
        $c->Actualizar();
        break;        // POST
    case 'Eliminar':
        $c->Eliminar();
        break;
    default:
        $c->Listar();
        break;
}
