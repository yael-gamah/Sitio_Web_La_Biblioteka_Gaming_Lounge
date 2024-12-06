<?php
require_once 'procesar.php';
$ejecutar = new moduloVerReserva ($_SESSION['telefono']);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="img/icono.png" type="image/png" />
    <title>Reservación de Eventos - La Biblioteka Gaming Lounge</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" />
    <style>
        .btn-reporte {
            display: inline-flex;
            align-items: center;
            background-color: #4CAF50; /* Color de fondo verde */
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        :root {
            --color-primario: #7a1cac;
        }

        body {
            background-color: #2e073f;
            color: azure;
            background: url("img/fondo.jpg") no-repeat center center fixed;
            background-size: cover;
            padding-top: 80px;
        }

        .barra-navegacion {
            background-color: #7a1cac;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .navbar-brand,
        .nav-link {
            color: azure;
        }

        .boton-primario {
            background-color: var(--color-primario);
            border-color: var(--color-primario);
            color: white;
        }

        .boton-primario:hover {
            background-color: #EBD3F8;
            border-color: #EBD3F8;
        }

        .btn-regresar {
            background-color: #7A1CAC;
            color: white;
            border: none;
            margin-bottom: 1rem;
        }

        .btn-regresar:hover {
            background-color: #5A6268;
            color: #EBD3F8;
        }

        .container-contenido {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            margin-top: 2rem;
            flex-wrap: wrap;
        }

        .table-container {
            max-width: 100%;
            max-height: 400px;
            overflow: auto;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5);
            background-color: rgba(26, 5, 35, 0.9);
            margin: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
            color: white;
            min-width: 150px;
        }

        th {
            background-color: #7A1CAC;
            color: white;
            position: sticky;
            top: 0;
        }

        tbody tr:nth-child(even) {
            background-color: #3e0a5a;
        }
    </style>
</head>

<body>
    <!-- Barra de navegación -->
    <nav class="barra-navegacion navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <img src="img/Logo.png" alt="Logo" style="width: 120px; height: auto; margin-right: 15px" />
            <strong style="font-size: 36px; color: azure">La Biblioteka Gaming Lounge</strong>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNavegacion"
                aria-controls="menuNavegacion" aria-expanded="false" aria-label="Alternar navegación">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menuNavegacion">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item ms-3">
                        <?php
                        $ejecutar->menuNavegacion();
                        ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <br>
    <!--Botón de regresar-->
    <div class="container mt-3">
    <button class="btn btn-regresar" onclick="window.location.href='Interfaz_Grafica.php'">
        <i class="bi bi-arrow-left-circle-fill"></i> Regresar
    </button>
</div>
    <div class="texto">
        <center><strong style="font-size: 36px; color: azure">Reservaciones</strong></center>
    </div>

    <!-- Contenedor principal -->
    <div class="container container-contenido">



        <!-- Contenedor de la tabla desplazable -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Nombre Completo</th>
                        <th>Correo Electrónico</th>
                        <th>Teléfono</th>
                        <th>Fecha del Evento</th>
                        <th>Hora del Evento</th>
                        <th>Paquete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $ejecutar->mostrarReservaciones();
                    ?>


                    <!-- Más filas según sea necesario -->
                </tbody>
            </table>
             
        </div>
        <!-- Botón para generar el reporte -->
    <a href="generarReporte.php" class="btn-reporte">
        <i class="fas fa-file-excel"></i> Generar Reporte
    </a>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>