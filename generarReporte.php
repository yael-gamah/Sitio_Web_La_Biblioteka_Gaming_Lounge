<?php
// Clase para la conexión a la base de datos con PDO
class crearConexion
{
    private $host = 'localhost';
    private $dbname = 'laBliblioteka';
    private $username = 'root';
    private $password = '';
    private $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8", $this->username, $this->password);
            // Configurar PDO para manejar errores como excepciones
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    public function getConexion()
    {
        return $this->pdo;
    }
}
class ReporteReservaciones {
    // Método para generar el reporte de las reservaciones en formato CSV
    public function generarReporte() {
        // Crear una instancia de la clase de conexión
        $obj = new crearConexion();
        $conexion = $obj->getConexion();

        // Consultar los datos usando PDO
        $query = "SELECT Reservacion.ID_reservacion, Usuario.nombre_usuario, Paquete.nombre_paquete, Reservacion.telefono, Reservacion.correo, Reservacion.fecha_evento, Reservacion.hora_evento, Reservacion.ID_paquete, Reservacion.ID_usuario 
                  FROM Reservacion
                  JOIN Usuario ON Reservacion.ID_usuario = Usuario.ID_usuario
                  JOIN Paquete ON Reservacion.ID_paquete = Paquete.ID_paquete";
        $stmt = $conexion->prepare($query);
        $stmt->execute();

        // Establecer los encabezados para la descarga del archivo CSV
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename="reporte_reservaciones.csv"');
        header('Cache-Control: max-age=0'); // Evitar cachear el archivo

        // Abrir el archivo para salida en el navegador
        $output = fopen('php://output', 'w');

        // Agregar los encabezados de las columnas en la primera fila
        fputcsv($output, ['ID Reservacion', 'Nombre Usuario', 'Nombre Paquete', 'Telefono', 'Correo', 'Fecha Evento', 'Hora Evento']);

        // Agregar los datos de la base de datos al archivo CSV
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            fputcsv($output, [
                $data['ID_reservacion'],
                $data['nombre_usuario'],
                $data['nombre_paquete'],
                $data['telefono'],
                $data['correo'],
                $data['fecha_evento'],
                $data['hora_evento']
            ]);
        }

        // Cerrar el archivo y la conexión a la base de datos
        fclose($output);
    }
}

// Crear una instancia de la clase y llamar al método generarReporte
$reporte = new ReporteReservaciones();
$reporte->generarReporte();
?>
