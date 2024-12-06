<?php
require_once 'procesar.php';
$ejecutar = new moduloEstadisticas ($_SESSION['telefono']);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/icono.png" type="image/png">
    <title>Estadísticas de Consumo - La Biblioteka Gaming Lounge</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --color-primario: #7A1CAC;
            --color-secundario: #2E073F;
        }

        body {
            background-color: #2E073F;
            color: azure;
            background: url('img/fondo.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .barra-navegacion {
            width: 100%;
            background-color: var(--color-primario);
            position: fixed;
            top: 0;
            z-index: 1000;
        }

        .boton-primario {
            background-color: var(--color-primario);
            border-color: var(--color-primario);
            color: white;
        }

        .boton-primario:hover {
            background-color: #EBD3F8;
            border-color: #EBD3F8;
            ;
        }

        .boton-secundario {
            background-color: var(--color-secundario);
            border-color: var(--color-secundario);
            color: white;
        }

        .boton-secundario:hover {
            background-color: #EBD3F8;
            border-color: #EBD3F8;
            ;
        }

        .navbar-brand,
        .nav-link {
            color: azure;
        }

        /* Botones estilo menú de estadísticas */
        .menu-estadisticas {
            display: flex;
            gap: 10px;
            padding: 20px;
            margin-top: 80px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .menu-estadisticas .btn {
            background-color: var(--color-primario);
            color: white;
            border: none;
            transition: background-color 0.3s;
        }

        .menu-estadisticas .btn:hover {
            background-color: #EBD3F8;
            color: #fbfbfb;
        }

        .content {
            max-width: 800px;
            width: 100%;
            margin-top: 20px;
            padding: 20px;
            background-color: rgba(96, 23, 127, 0.9);
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
            color: azure;
        }

        .chart-container {
            padding: 20px;
        }
    </style>
</head>

<body>
    <!-- Barra de navegación superior -->
    <nav class="barra-navegacion navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <img src="img/Logo.png" alt="Logo" style="width: 120px; height: auto; margin-right: 15px;">
            <!-- Tamaño aumentado -->
            <strong style="font-size: 36px; color: azure;">La Biblioteka Gaming Lounge</strong>
            <!-- Tamaño de texto aumentado -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNavegacion"
                aria-controls="menuNavegacion" aria-expanded="false" aria-label="Alternar navegación">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menuNavegacion">
                <ul class="navbar-nav ms-auto">
                    <!-- Botones de Registro e Inicio de Sesión -->
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

   

    <!-- Botones de estadísticas -->

    <!--Boton regresar-->
    <div class="menu-estadisticas">
        <div class="container mt-3">
            <button class="btn btn-regresar" onclick="window.location.href='Interfaz_Grafica.php'">
             <i class="bi bi-arrow-left-circle-fill"></i> Regresar
            </button>
        </div>

        <button class="btn" onclick="loadChart('consolaMasRentada')">Consola Más Rentada</button>
        <button class="btn" onclick="loadChart('horasPromedio')">Promedio de Horas Jugadas</button>
        <button class="btn" onclick="loadChart('visitasPorMes')">Visitas por Mes</button>
        <button class="btn" onclick="loadChart('juegosMasElegidos')">Juegos Más Elegidos</button>
    </div>

    <!-- Contenido principal -->
    <div class="content text-center">
        <h1>Estadísticas de Consumo</h1>
        <p>Selecciona una estadística en el menú para ver los detalles.</p>
        <div id="chartContainer" class="chart-container">
            <canvas id="mainChart"></canvas>
        </div>
    </div>

    <script>
        const chartData = {
            consolaMasRentada: {
                type: 'bar',
                labels: ['PlayStation 5', 'Xbox Series X', 'Nintendo Switch', 'PC Gamer'],
                <?php
                $ejecutar->consolaMayorRentada();
                ?>                                
                label: 'Número de Rentas'
            },
            horasPromedio: {
                type: 'doughnut',
                labels: ['1-2 horas', '3-4 horas', '5-6 horas', '7+ horas'],
                <?php
                $ejecutar->porcentajeVisitas();
                ?>
                label: 'Porcentaje de Visitas'
            },
            visitasPorMes: {
                type: 'line',
                labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                //data: [45, 50, 70, 80, 90, 100, 110, 120, 90, 85, 95, 105],
                <?php
                $ejecutar->visitasPorMes();
                ?>
                label: 'Visitas'
            },
            juegosMasElegidos: {
                type: 'pie',
                <?php
                $ejecutar->juegosMasElegidos();
                ?>
                label: 'Popularidad de Juegos'
            }
        };

        let mainChart;

        function loadChart(chartName) {
            const ctx = document.getElementById('mainChart').getContext('2d');
            if (mainChart) mainChart.destroy();

            const { type, labels, data, label } = chartData[chartName];
            mainChart = new Chart(ctx, {
                type,
                data: {
                    labels,
                    datasets: [{
                        label,
                        data,
                        backgroundColor: ['#7A1CAC', '#EBD3F8', '#2E073F', '#8A3D8C', '#5E1A69']
                    }]
                },
                options: {
                    responsive: true,
                    scales: type === 'bar' || type === 'line' ? { y: { beginAtZero: true } } : {},
                    plugins: {
                        legend: {
                            labels: {
                                color: 'white' // Cambia el color a blanco o el color que prefieras
                            }
                        }
                    }
                }
            });
        }

    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>