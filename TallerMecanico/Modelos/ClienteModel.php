<?php
require_once("Conexion.php");

class ClienteModel extends Conexion
{
    private $db;

    public function __construct()
    {
        $this->db = (new Conexion())->getConexion();
    }

    public function insertarCliente(
        int $id_usuario,
        string $nombre_cliente,
        int $dui,
        string $fecha_nacimiento,
        ?int $telefono
    ) {
        try {
            $sql = "INSERT INTO clientes (id_usuario, nombre_cliente, numero_dui, fecha_nacimiento, numero_telefono)
                VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id_usuario, $nombre_cliente, $dui, $fecha_nacimiento, $telefono]);
            return true;
        } catch (PDOException $e) {
            // Verificamos si el error es por duplicado
            if (str_contains($e->getMessage(), 'Duplicate') && str_contains($e->getMessage(), 'numero_dui')) {
                return "existe_dui";
            } else {
                return false;
            }
        }
    }


    public function obtenerClientes()
    {
        // Útil hacer JOIN para ver correo también
        $sql = "SELECT c.id_cliente, c.nombre_cliente, c.numero_dui, c.fecha_nacimiento, c.numero_telefono,
                       u.correo, u.rol
                FROM clientes c
                JOIN usuarios u ON u.id_usuarios = c.id_usuario
                ORDER BY c.id_cliente DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerClientePorId($id_cliente)
    {
        $sql = "SELECT 
                c.id_cliente,
                c.id_usuario,
                c.nombre_cliente,
                c.numero_dui,
                c.fecha_nacimiento,
                c.numero_telefono,
                u.nombre_completo,
                u.correo,
                u.contrasena,
                u.rol
            FROM clientes c
            INNER JOIN usuarios u ON c.id_usuario = u.id_usuarios
            WHERE c.id_cliente = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_cliente]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function actualizarCliente(int $id, string $nombre, int $dui, string $fecha_nac, ?int $telefono)
    {
        $sql = "UPDATE clientes
                   SET nombre_cliente = ?, numero_dui = ?, fecha_nacimiento = ?, numero_telefono = ?
                 WHERE id_cliente = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nombre, $dui, $fecha_nac, $telefono, $id]);
    }

    public function eliminarCliente(int $id)
    {
        $sql = "DELETE FROM clientes WHERE id_cliente = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
    public function obtenerPorUsuario($id_usuario)
    {
        $sql = "SELECT id_cliente FROM clientes WHERE id_usuario = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_usuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function obtenerTodos()
    {
        try {
            $sql = "SELECT id_cliente, nombre_cliente FROM clientes";
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener clientes: " . $e->getMessage();
            return [];
        }
    }


}
