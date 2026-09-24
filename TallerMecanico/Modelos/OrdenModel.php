<?php
require_once "Conexion.php";

class OrdenModel {
    private $db;

    public function __construct() {
        $this->db = (new Conexion())->getConexion();
    }

    // Obtener todas las órdenes (opcionalmente filtradas por estado)
    public function obtenerTodas($estado = null) {
        if ($estado) {
            $stmt = $this->db->prepare("SELECT o.*, v.placa, v.marcaYmodelo, s.nombre_servicio
                FROM ordendeservicio o
                JOIN automovil v ON o.id_automovil = v.id_automovil
                JOIN servicios s ON o.id_servicio = s.id_servicio
                WHERE o.estado_servicio = ?
                ORDER BY o.fecha_orden ASC");
            $stmt->execute([$estado]);
        } else {
            $stmt = $this->db->query("SELECT o.*, v.placa, v.marcaYmodelo, s.nombre_servicio
                FROM ordendeservicio o
                JOIN automovil v ON o.id_automovil = v.id_automovil
                JOIN servicios s ON o.id_servicio = s.id_servicio
                ORDER BY o.fecha_orden ASC");
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Insertar nueva orden
    public function insertar($id_automovil, $id_servicio) {
        $sql = "INSERT INTO ordendeservicio (id_automovil, id_servicio, fecha_orden, estado_servicio)
                VALUES (?, ?, NOW(), 'pendiente')";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id_automovil, $id_servicio]);
    }

    // Validar si ya existe una orden activa para ese vehículo y servicio
    public function existeOrdenActiva($id_automovil, $id_servicio) {
        $sql = "SELECT COUNT(*) FROM ordendeservicio
                WHERE id_automovil = ? AND id_servicio = ? 
                AND estado_servicio IN ('pendiente', 'en_proceso')";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_automovil, $id_servicio]);
        return $stmt->fetchColumn() > 0;
    }

    // Cambiar estado de una orden
    public function actualizarEstado($id_orden, $nuevo_estado) {
        $sql = "UPDATE ordendeservicio SET estado_servicio = ? WHERE id_orden = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nuevo_estado, $id_orden]);
    }

    // Obtener una orden por ID
    public function obtenerPorId($id) {
        $stmt = $this->db->prepare("SELECT * FROM ordendeservicio WHERE id_orden = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Eliminar orden
    public function eliminar($id) {
        $stmt = $this->db->prepare("DELETE FROM ordendeservicio WHERE id_orden = ?");
        return $stmt->execute([$id]);
    }
}
?>
