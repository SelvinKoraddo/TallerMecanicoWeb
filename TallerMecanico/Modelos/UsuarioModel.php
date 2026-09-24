<?php
require_once("Conexion.php");

class UsuarioModel extends Conexion
{
    private $db;

    public function __construct()
    {
        $this->db = (new Conexion())->getConexion();
    }

    public function insertarUsuario($nombre, $corrEo, $contraHash, $rol)
    {
        try {
            $sql = "INSERT INTO usuarios (nombre_completo, correo, contrasena, rol)
                VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$nombre, $corrEo, $contraHash, $rol]);
            return $this->db->lastInsertId(); 
        } catch (PDOException $e) {
            
            error_log("Error al insertar usuario: " . $e->getMessage());
            return false;
        }
    }



    public function buscarPorCorreo(string $correo)
    {
        $sql = "SELECT 1 FROM usuarios WHERE correo = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$correo]);
        return $stmt->fetchColumn(); // true/false
    }

    public function validarUsuario(string $correo, string $pass)
    {
        $sql = "SELECT id_usuarios, nombre_completo, correo, contrasena, rol
                FROM usuarios WHERE correo = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$correo]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && password_verify($pass, $row['contrasena'])) {
            return $row;
        }
        return null;
    }
}
