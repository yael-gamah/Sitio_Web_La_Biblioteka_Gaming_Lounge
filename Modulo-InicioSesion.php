<?php
if (session_status() == PHP_SESSION_ACTIVE) {
    session_destroy();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/icono.png" type="image/png">
    <title>Iniciar Sesión - La Biblioteka Gaming Lounge</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11">    </script>
    <script>

        window.history.replaceState(null, null, window.location.href);
    </script>
    <style>
        :root {
            --color-primario: #7A1CAC;
            --color-secundario: #7A1CAC;
        }

        body {
            background-color: #2E073F;
            color: azure;
            background: url('img/fondo.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding-top: 56px;
            /* Espacio para la barra de navegación fija */
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


        .form-container {
            max-width: 400px;
            margin: 5% auto;
            padding: 2rem;
            background-color: #1A0523;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5);
        }

        .form-control,
        .btn {
            border-radius: 0.5rem;
        }

        .btn-secundario {
            background-color: var(--color-secundario);
            color: white;
            border-color: var(--color-secundario);
        }

        .btn-secundario:hover {
            background-color: #EBD3F8;
            color: #2E073F;
            border-color: #EBD3F8;
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

    <!-- Barra de navegación fija en la parte superior -->
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
                        <!--<a href="Interfaz Grafica.html" class="btn boton-primario">Inicio</a>-->
                        <a href="AcercaDe.php" class="btn boton-primario">Acerca De</a>
                        <!--<a href="Modulo-InicioSesion.html" class="btn boton-primario">Iniciar Sesion</a>-->
                        <a href="Modulo-Registro.php" class="btn boton-primario">Registrarse</a>
                        <!--<a href="AcercaDe.html" class="btn boton-primario">Cerrar Sesion</a>-->
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <br>

    <!-- Contenedor de inicio de sesión -->
    <div class="form-container">
        <h2 class="titulo">Iniciar Sesión</h2>
        <form action="procesar.php" method="post" onsubmit="return validarFormulario()">
            <!-- Campo de teléfono -->
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                    <input type="number" class="form-control" oninput="limitarTelefono(this)" id="telefono" name="telefono"
                        placeholder="Ingresa tu número de teléfono" required>
                </div>
            </div>

            <!-- Campo de contraseña -->
            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" class="form-control" id="contrasena" name="contrasena"
                        placeholder="Ingresa tu contraseña" required>
                </div>
            </div>
            <!--Hidden-->
            <div>
                <input type="hidden" id="formulario" name="formulario" value="iniciarSesion">
            </div>

            <!-- Botón de inicio de sesión -->
            <button type="submit" class="btn btn-secundario w-100">Iniciar Sesión</button>
            <div align="center">¿Aun no te has registrado? <a href="Modulo-Registro.php">Registrate aqui.</a></div>
        </form>
    </div>
    <script>
        function limitarTelefono(input) {
            input.value = input.value.replace(/[^0-9]/g, ""); //permite solo numeros del 0 al 9
        }
        function validarFormulario() {
            const campoNumerico = document.getElementById("telefono").value;
            if (campoNumerico.length !== 10 || parseInt(campoNumerico) < 1000000000 || parseInt(campoNumerico) > 9999999999) {
                Swal.fire({
                    title: "Advertencia",
                    text: "El número telefonico debe tener exactamente 10 dígitos.",
                    icon: "warning",
                    background: "#2e073f",  // Fondo personalizado 
                    color: "#ffffff",       // Texto en color blanco
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Aceptar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "Modulo-InicioSesion.php";
                    }
                });
                return false; // Bloquea el envío
            }
            const contrasena = document.getElementById("contrasena").value;
            if (contrasena.length < 8 || contrasena.length > 100) {
                Swal.fire({
                    title: "Advertencia",
                    text: "La contraseña debe tener entre 8 y 100 caracteres.",
                    icon: "warning",
                    background: "#2e073f",  // Fondo personalizado 
                    color: "#ffffff",       // Texto en color blanco
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Aceptar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "Modulo-InicioSesion.php";
                    }
                });
                return false; // Bloquea el envío
            }
            return true; // Permite el envío si ambos campos son válidos
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>