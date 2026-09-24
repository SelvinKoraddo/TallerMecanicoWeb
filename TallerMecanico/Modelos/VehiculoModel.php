<?php
require_once 'Conexion.php';

class VehiculoModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Conexion())->getConexion();
    }

    public function insertarVehiculo($placa, $marca_modelo, $anio_fabricacion, $id_cliente)
    {
        $sql = "INSERT INTO automovil (placa, marcaYmodelo, anio_fabricacion, id_cliente, id_servicio)
                VALUES (:placa, :marcaYmodelo, :anio_fabricacion, :id_cliente, NULL)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id_cliente' => $id_cliente,
            'placa' => $placa,
            'marcaYmodelo' => $marca_modelo,
            'anio_fabricacion' => $anio_fabricacion
        ]);
    }

    public function obtenerConCliente($id_usuario)
    {
        $stmt = $this->db->prepare("
        SELECT a.id_automovil, a.placa, a.marcaYmodelo
        FROM automovil a
        INNER JOIN clientes c ON a.id_cliente = c.id_cliente
        WHERE c.id_usuario = ?
    ");
        $stmt->execute([$id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function obtenerPorId($id)
    {
        $sql = "SELECT * FROM automovil WHERE id_automovil = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function editarVehiculo($id, $placa, $marca_modelo, $anio_fabricacion, $id_cliente)
    {
        $sql = "UPDATE automovil 
                SET placa = :placa, marca_modelo = :marca_modelo, anio_fabricacion = :anio_fabricacion, id_cliente = :id_cliente
                WHERE id_automovil = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'placa' => $placa,
            'marca_modelo' => $marca_modelo,
            'anio_fabricacion' => $anio_fabricacion,
            'id_cliente' => $id_cliente,
            'id' => $id
        ]);
    }

    public function eliminarVehiculo($id)
    {
        $sql = "DELETE FROM automovil WHERE id_automovil = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function placaExiste($placa)
    {
        $sql = "SELECT COUNT(*) FROM automovil WHERE placa = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$placa]);
        return $stmt->fetchColumn() > 0;
    }
    public function actualizarVehiculo($id, $placa, $marcaYmodelo, $anio_fabricacion, $id_cliente)
    {
        $sql = "UPDATE automovil 
            SET placa = ?, marcaYmodelo = ?, anio_fabricacion = ?, id_cliente = ?
            WHERE id_automovil = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$placa, $marcaYmodelo, $anio_fabricacion, $id_cliente, $id]);
    }
   public function obtenerTodos()
{
    $stmt = $this->db->query("
        SELECT 
            a.id_automovil,
            a.placa,
            a.marcaYmodelo,
            a.anio_fabricacion,
            c.nombre_cliente
        FROM automovil a
        INNER JOIN clientes c ON a.id_cliente = c.id_cliente
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}




}
?>