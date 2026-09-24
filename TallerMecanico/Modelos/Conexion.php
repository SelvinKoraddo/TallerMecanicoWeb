<?php
class Conexion
{
    private $host;
    private $user;
    private $pass;
    private $db;
    private $conBD;

    public function __construct()
    {
        // 1. Obtener valores desde Azure (getenv) o usar valores locales por defecto
        $this->host = getenv('DB_HOST') ?: "localhost";
        $this->user = getenv('DB_USER') ?: "root";
        $this->pass = getenv('DB_PASS') ?: "1234";
        $this->db   = getenv('DB_NAME') ?: "L2_TallerCM23042";

        $cadenaConexion = "mysql:host=" . $this->host . ";dbname=" . $this->db . ";charset=utf8";

        try
        {
            // 2. Opciones de conexión PDO
            $opciones = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );

            // Si está ejecutándose en la nube (no en localhost), habilitamos SSL
            if ($this->host !== 'localhost' && $this->host !== '127.0.0.1') {
                $opciones[PDO::MYSQL_ATTR_SSL_CA] = true;
                $opciones[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = false;
            }

            $this->conBD = new PDO($cadenaConexion, $this->user, $this->pass, $opciones);
        }
        catch(Exception $e)
        {
            $this->conBD = null;
            // En producción es aconsejable registrar el error en logs y no mostrar contraseñas en pantalla
            echo "Error de conexión a la base de datos: " . $e->getMessage();
        }
    }

    public function getConexion()
    {
        return $this->conBD;
    }
}
?>