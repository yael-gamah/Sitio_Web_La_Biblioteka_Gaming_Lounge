<?php
require_once 'procesar.php';
$ejecutar = new moduloReservaciones($_SESSION['telefono']);
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
            ;
        }

        .btn-primario {
            background-color: var(--color-primario);
            color: white;
            border-color: var(--color-primario);
        }

        .btn-primario:hover {
            background-color: #EBD3F8;
            color: #2E073F;
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
            justify-content: space-between;
            align-items: flex-start;
            margin-top: 2rem;
        }

        .carousel-container {
            width: 40%;
            max-height: 600px;
            overflow-y: auto;
            border-radius: 10px;
        }

        .carousel-item img {
            width: 100%;
            object-fit: cover;
            border-radius: 10px;
        }

        .form-container {
            width: 55%;
            padding: 2rem;
            background-color: #1a0523;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5);
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

    <!--Boton regresar-->
    <div class="container mt-3">
    <button class="btn btn-regresar" onclick="window.location.href='Interfaz_Grafica.php'">
        <i class="bi bi-arrow-left-circle-fill"></i> Regresar
    </button>
</div>


    <!-- Contenedor principal -->
    <div class="container container-contenido">
        <!-- Carrusel vertical de paquetes -->
        <div id="carouselPaquetes" class="carousel-container carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="img/img1.png" class="d-block" alt="Paquete Smash" />
                    <div class="carousel-caption d-none d-md-block">
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="img/img2.png" class="d-block" alt="Paquete Survival" />
                    <div class="carousel-caption d-none d-md-block">
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="img/img3.png" class="d-block" alt="Paquete Ultimate" />
                    <div class="carousel-caption d-none d-md-block">
                    </div>
                </div>
            </div>
            </strong>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselPaquetes" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselPaquetes" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <!-- Formulario de reservación -->
        <div class="form-container">
            <h2 class="titulo">Reservación de Eventos</h2>
            <form id="form-reservacion" action="procesar.php" method="post" onsubmit="return validarFormulario()">
                <!-- Campos del formulario -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nombre" class="form-label">Nombre Completo</label>
                        <?php
                        $ejecutar->mostrarNombre();
                        ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="correo" class="form-label">Correo Electrónico</label>
                        <?php
                        $ejecutar->mostrarCorreo();
                        ?>
                    </div>
                    <!--Hidden-->
                    <div>
                        <input type="hidden" id="formulario" name="formulario" value="reservarEvento">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="telefono" class="form-label">Teléfono de Contacto</label>
                        <?php
                        $ejecutar->mostrarTelefono();
                        ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="fecha" class="form-label">Fecha del Evento</label>
                        <input type="date" class="form-control" id="fecha" name = "fecha"required />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="hora" class="form-label">Hora del Evento</label>
                        <input type="time" class="form-control" id="hora" name = "hora" required />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="paquete" class="form-label">Paquete de Servicio</label>
                        <select class="form-select" id="paquete" name = "paquete" required>
                            <option value ="" selected disabled>Selecciona un paquete</option>
                            <?php
                            $ejecutar->mostrarPaquetes();
                            ?>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primario w-100">
                    Confirmar Reservación
                </button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function validarFormulario(){
            const selectPaquete = document.getElementById("paquete");
            if (selectPaquete.value === "") {
                selectPaquete.focus();
                return false;
            }  
            return true;
        }
    </script>
</body>

</html>