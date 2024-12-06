<?php
require_once 'procesar.php';
$ejecutar = new moduloRegistroVisitas();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="img/icono.png" type="image/png" />
    <title>Registro de Visitas - La Biblioteka Gaming Lounge</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11">    </script>
    <style>
        :root {
            --color-primario: #7a1cac;
            --color-secundario: #7a1cac;
        }

        body {
            background-color: #2e073f;
            color: azure;
            background: url("img/fondo.jpg") no-repeat center center fixed;
            background-size: cover;
        }

        .container-visitas {
            max-width: 900px;
            margin: 3% auto;
            padding: 2rem;
            background-color: rgba(26, 5, 35, 0.9);
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5);
        }

        .form-control,
        .btn {
            border-radius: 0.5rem;
        }

        .barra-navegacion {
            background-color: #7a1cac;
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
            background-color: #ebd3f8;
            border-color: #ebd3f8;
        }

        .btn-primario {
            background-color: var(--color-primario);
            color: white;
            border-color: var(--color-primario);
        }

        .btn-primario:hover {
            background-color: #ebd3f8;
            color: #2e073f;
            border-color: #ebd3f8;
        }

        .btn-regresar {
            background-color: #7a1cac;
            color: white;
            border: none;
            margin-bottom: 1rem;
        }

        .btn-regresar:hover {
            background-color: #5a6268;
            color: #ebd3f8;
        }

        .titulo {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .puntos-container {
            text-align: center;
            margin-top: 1rem;
            padding: 1rem;
            background-color: #3e0a5a;
            border-radius: 10px;
        }

        .puntos-container h4 {
            color: #ebd3f8;
        }
    </style>
</head>

<body>
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

    <!-- Botón de regresar -->
    <div class="container mt-3">
    <button class="btn btn-regresar" onclick="window.location.href='Interfaz_Grafica.php'">
        <i class="bi bi-arrow-left-circle-fill"></i> Regresar
    </button>
</div>

    <!-- Contenedor del registro de visitas -->
    <div class="container-visitas">
        <h2 class="titulo" name="titulo">Registro de Visitas</h2>
        <form id="form-visita" action="procesar.php" method="post" onsubmit="return validarFormulario()">
            <div class="row">
                <!-- Selección del cliente -->
                <div class="col-md-6 mb-3">
                    <label for="cliente" class="form-label">Cliente</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                        <select class="form-select" id="cliente" name="cliente" required>
                            <option value="" selected disabled>Selecciona un cliente</option>
                            <?php
                            $ejecutar->mostrarClientes();
                            ?>
                        </select>
                    </div>
                </div>

                <!-- Fecha de la visita -->
                <div class="col-md-6 mb-3">
                    <label for="fecha" class="form-label">Fecha de la Visita</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                        <input type="date" class="form-control" id="fecha" name="fecha" required />
                    </div>
                </div>

                <!--Hideen-->
                <div>
                    <input type="hidden" id="formulario" name="formulario" value="registrarVisita">
                </div>

                <!-- Hora de la visita -->
                <div class="col-md-6 mb-3">
                    <label for="hora" class="form-label">Hora de la Visita</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-clock-fill"></i></span>
                        <input type="time" class="form-control" min="1" id="hora" name="hora" required />
                    </div>
                </div>

                <!-- Horas jugadas -->
                <div class="col-md-6 mb-3">
                    <label for="horas" class="form-label">Horas Jugadas</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-clock-fill"></i></span>
                        <input type="number" class="form-control" id="horas" min="1" name="horas" required />
                    </div>
                </div>

                <!-- Consola utilizada -->
                <div class="col-md-6 mb-3">
                    <label for="consola" class="form-label">Consola Utilizada</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-controller"></i></span>
                        <select class="form-select" id="consola" name="consola" required onchange="actualizarJuegos()">
                            <option value="" selected disabled>Selecciona una consola</option>
                            <?php
                            $ejecutar->mostrarConsolas();
                            ?>
                        </select>
                    </div>
                </div>

                <!-- Juego elegido -->
                <div class="col-md-6 mb-3">
                    <label for="juego" class="form-label">Juego Elegido</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-joystick"></i></span>
                        <select class="form-select" id="juego" name="juego" required>
                            <option value="" selected disabled>Selecciona un juego</option>
                        </select>
                    </div>
                </div>>
                <!-- Usar promoción -->
                <div class="col-md-12 mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="promocion" name="promocion" value="si" />
                        <label class="form-check-label" for="promocion">
                            ¿Usar promoción?
                        </label>
                    </div>
                </div>

                <!-- Confirmar registro -->
                <button type="submit" class="btn btn-primario w-100">
                    Registrar Visita
                </button>
        </form>

        <!-- Contenedor de puntos acumulados -->
        <div class="puntos-container" id="puntos-container" style="display: none">
            <h4>Puntos Acumulados</h4>
            <p>
                <strong>Total de Puntos Ganados:</strong>
                <span id="puntosGanados">0</span>
            </p>
        </div>
    </div>

    <script>
        const juegosPorConsola = {
            <?php
            $ejecutar->muestraJuegosConsola();
            ?>
        };

        function validarFormulario() {
            const campoNumerico = document.getElementById("horas").value;
            if (parseInt(campoNumerico) < 1 || parseInt(campoNumerico) > 12) {
                Swal.fire({
                    title: "Advertencia",
                    text: "El numero de horas no puede exceder 12.",
                    icon: "warning",
                    background: "#2e073f",  // Fondo personalizado 
                    color: "#ffffff",       // Texto en color blanco
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Aceptar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "Modulo-RegistroVisitas.php";
                    }
                });
                return false; // Bloquea el envío
            }

            const selectCliente = document.getElementById("cliente");
            if (selectCliente.value === "") {
                selectCliente.focus();
                return false;
            }
            const selectConsola = document.getElementById("consola");
            if (selectConsola.value === "") {
                selectConsola.focus();
                return false;
            }
            const selectJuego = document.getElementById("juego");
            if (selectJuego.value === "") {
                selectJuego.focus();
                return false;
            }            
            return true;
        }
        function actualizarJuegos() {
            const consolaSeleccionada = document.getElementById("consola").value;
            const juegoSelect = document.getElementById("juego");

            // Limpiar opciones anteriores
            juegoSelect.innerHTML = '<option selected disabled>Selecciona un juego</option>';

            // Agregar opciones según la consola seleccionada
            juegosPorConsola[consolaSeleccionada].forEach(juego => {
                const option = document.createElement("option");
                option.value = juego;
                option.textContent = juego;
                juegoSelect.appendChild(option);
            });
        }        
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>