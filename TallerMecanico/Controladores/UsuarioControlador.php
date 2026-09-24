<?php
require_once(__DIR__ . "/../Modelos/UsuarioModel.php");
require_once(__DIR__ . "/../Modelos/ClienteModel.php");

class UsuarioController
{
    private $ObjUsuarioModel;
    private $ObjClienteModel;

    public function __construct()
    {
        $this->ObjUsuarioModel = new UsuarioModel();
        $this->ObjClienteModel = new ClienteModel();
    }


   
    // LOGIN DE USUARIOS
   
    public function Login()
{
    $correo = $_REQUEST['correo'] ?? '';
    $contra = $_REQUEST['contrasena'] ?? '';

    // Validar credenciales
    $ValidarUsuario = $this->ObjUsuarioModel->validarUsuario($correo, $contra);

    if ($ValidarUsuario != null) {
        session_start();
        $_SESSION["id_usuario"] = $ValidarUsuario["id_usuarios"];
        $_SESSION["nombre"] = $ValidarUsuario["nombre_completo"];
        $_SESSION["rol"] = $ValidarUsuario["rol"];

        // Redirigir según rol
        switch ($_SESSION["rol"]) {
            case 'administrador':
                header('Location: ../Vistas/adminPanel.php');
                break;
            case 'cliente':
                header('Location: ../Vistas/Home.php');
                break;
            default:
                header('Location: ../Vistas/Home.php');
                break;
        }
        exit;
    } else {
        // Credenciales inválidas → redirige con mensaje
        header("Location: ../Vistas/Login.php?mensaje=Correo o contraseña incorrectos.&tipo=danger");
        exit;
    }
}


    
    // REGISTRO DE CLIENTE
   
    public function RegistrarCliente()
    {
        $nombre = $_REQUEST['nombre'] ?? '';
        $correo = $_REQUEST['correo'] ?? '';
        $telefono = $_REQUEST['telefono'] ?? '';
        $dui = $_REQUEST['dui'] ?? '';
        $fecha = $_REQUEST['fecha_nacimiento'] ?? '';
        $contra = $_REQUEST['contra'] ?? '';
        $rol = 'cliente'; // fijo

        if (empty($nombre) || empty($correo) || empty($telefono) || empty($dui) || empty($contra) || empty($fecha)) {
            $mensaje = "Por favor completa todos los campos.";
            $tipoMensaje = "danger";
            include("../Vistas/RegistroClientes.php");
            return;
        }

        // verificar duplicado
        if ($this->ObjUsuarioModel->buscarPorCorreo($correo)) {
            $mensaje = "El correo ya está registrado.";
            $tipoMensaje = "warning";
            include("../Vistas/RegistroClientes.php");
            return;
        }

        // encriptar contraseña
        $contraHash = password_hash($contra, PASSWORD_BCRYPT);

        // insertar usuario
        $id_usuario = $this->ObjUsuarioModel->insertarUsuario($nombre, $correo, $contraHash, $rol);

        if (!$id_usuario) {
            $mensaje = "Error al crear el usuario.";
            $tipoMensaje = "danger";
            include("../Vistas/RegistroClientes.php");
            return;
        }

        // insertar cliente con el id del usuario
        $insertCliente = $this->ObjClienteModel->insertarCliente(
            $id_usuario,
            $nombre,
            $dui,
            $fecha,
            (int) $telefono
        );

        if ($insertCliente) {
            header("Location: ../Vistas/Login.php?registro=exitoso");
            exit;
        } else {
            $mensaje = "Usuario creado, pero error al guardar datos del cliente.";
            $tipoMensaje = "warning";
            include("../Vistas/RegistroClientes.php");
        }
    }


    
    // CERRAR SESIÓN
    
    public function Logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header("Location: ../Vistas/Login.php?mensaje=Sesión cerrada correctamente");
        exit();
    }

}

// ======================================
// CONTROLADOR CENTRALIZADO CON SWITCH
// ======================================
$Tipo = $_REQUEST['Tipo'] ?? '';

$ObjUsuarioController = new UsuarioController();

switch ($Tipo) {
    case "Login":
        $ObjUsuarioController->Login();
        break;

    case "RegistrarCliente":
        $ObjUsuarioController->RegistrarCliente();
        break;

    case "Logout":
        $ObjUsuarioController->Logout();
        break;

    default:
        echo "Operación no válida";
}
?>