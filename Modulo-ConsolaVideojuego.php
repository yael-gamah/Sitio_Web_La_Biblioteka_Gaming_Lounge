<?php
require_once 'procesar.php';
$ejecutar = new moduloConsolaVideojuego();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="icono.png" type="image/png">
    <title>Gestión de Consolas y Videojuegos - La Biblioteka Gaming Lounge</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <style>
        :root {
            --color-primario: #7A1CAC;
        }

        body {
            background-color: #2E073F;
            color: azure;
            background: url('img/fondo.jpg') no-repeat center center fixed;
            background-size: cover;
            padding-top: 56px;
        }

        .barra-navegacion {
            background-color: #7A1CAC;
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

        .form-container {
            max-width: 600px;
            margin: 1% auto;
            padding: 2rem;
            background-color: #1A0523;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5);
        }

        .form-control,
        .btn {
            border-radius: 0.5rem;
        }

        .btn-primario {
            background-color: var(--color-primario);
            color: white;
            border-color: var(--color-primario);
        }

        .btn-primario:hover {
            background-color: #EBD3F8;
            color: #2E073F;
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

        .titulo {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .input-group-text {
            background-color: #3E0A5A;
            color: white;
            border: none;
        }
    </style>
</head>

<body>

    <!-- Barra de navegación -->
    <nav class="barra-navegacion navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container-fluid">
            <img src="img/Logo.png" alt="Logo" style="width: 120px; height: auto; margin-right: 15px;">
            <strong style="font-size: 36px; color: azure;">La Biblioteka Gaming Lounge</strong>
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
    <!-- Botón de regresar -->
    <div class="container mt-3">
    <button class="btn btn-regresar" onclick="window.location.href='Interfaz_Grafica.php'">
        <i class="bi bi-arrow-left-circle-fill"></i> Regresar
    </button>
</div>

    <!-- Contenedor de gestión de consolas y videojuegos -->
    <div class="form-container">
        <h2 class="titulo">Gestión de Consolas y Videojuegos</h2>

        <!-- Formulario para registrar un videojuego -->
        <form id="form-juego" action="procesar.php" method="post" onsubmit="return validarFormulario()">
            <center>
                <h5>Registrar Videojuego</h5>
            </center>
            <div class="mb-3">
                <label for="nombreJuego" class="form-label">Nombre del Juego</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-gamepad"></i></span>
                    <input type="text" class="form-control" name="nombreJuego" id="nombreJuego"
                        placeholder="Ingresa el nombre del juego" maxlength="100"  required>
                </div>
            </div>
            <div class="mb-3">
                <label for="tipoConsola" class="form-label">Tipo de Consola</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-controller"></i></span>
                    <select class="form-select" id="tipoConsola" name="tipoConsola" required>
                        <option value="" selected disabled>Selecciona una consola</option>
                        <!-- Opciones de consolas agregadas dinámicamente desde la base de datos o manualmente -->
                        <?php
                        $ejecutar->mostrarConsolas();
                        ?>
                    </select>
                </div>
            </div>
            <div>
                <input type="hidden" id="formulario" name="formulario" value="registrar_videojuego">
            </div>
            <button type="submit" class="btn btn-primario w-100">Registrar
                Videojuego</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function validarFormulario(){
            const nombre = document.getElementById("nombreJuego").value;
            if (nombre.length < 1 || nombre.length > 100) {
                Swal.fire({
                    title: "Advertencia",
                    text: "El nombre de juego debe tener entre 1 y 100 caracteres.",
                    icon: "warning",
                    background: "#2e073f",  // Fondo personalizado 
                    color: "#ffffff",       // Texto en color blanco
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Aceptar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "Modulo-ConsolaVideojuego.php";
                    }
                });
                return false; // Bloquea el envío
            }
            const selectConsola = document.getElementById("tipoConsola");
            if (selectConsola.value === "") {
                selectConsola.focus();
                return false;
            }

            return true;
        }
    </script>
</body>

</html>