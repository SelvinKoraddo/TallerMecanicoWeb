<?php
require_once "Conexion.php";

class ServicioModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Conexion())->getConexion();
    }

    // Obtener todos los servicios
    public function obtenerTodos()
    {
        $stmt = $this->db->query("SELECT * FROM servicios ORDER BY id_servicio DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un servicio por ID
    public function obtenerPorId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM servicios WHERE id_servicio = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Insertar un nuevo servicio
    public function insertar($nombre, $descripcion, $precio)
    {
        $sql = "INSERT INTO servicios (nombre_servicio, descripcion_servicio, precio_servicio)
                VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nombre, $descripcion, $precio]);
    }

    // Actualizar un servicio
    public function actualizar($id, $nombre, $descripcion, $precio)
    {
        $sql = "UPDATE servicios
                SET nombre_servicio = ?, descripcion_servicio = ?, precio_servicio = ?
                WHERE id_servicio = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nombre, $descripcion, $precio, $id]);
    }

    // Eliminar un servicio
    public function eliminar($id)
    {
        $stmt = $this->db->prepare("DELETE FROM servicios WHERE id_servicio = ?");
        return $stmt->execute([$id]);
    }
}
?>