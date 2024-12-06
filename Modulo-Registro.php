<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="img/icono.png" type="image/png" />
    <title>Registro - La Biblioteka Gaming Lounge</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11">    </script>
    <style>
        :root {
            --color-primario: #7a1cac;
            --color-secundario: #7a1cac;
        }

        body {
            background-color: #2e073f;
            background: url("img/fondo.jpg") no-repeat center center fixed;
            background-size: cover;
            color: azure;
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

        .form-container {
            max-width: 600px;
            margin: 5% auto;
            padding: 2rem;
            background-color: #1a0523;
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
            background-color: #ebd3f8;
            color: #2e073f;
            border-color: #ebd3f8;
        }

        .titulo {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .input-group-text {
            background-color: #3e0a5a;
            color: white;
            border: none;
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
                        <!-- <a href="Interfaz Grafica.html" class="btn boton-primario">Inicio</a> -->
                        <a href="AcercaDe.php" class="btn boton-primario">Acerca De</a>
                        <a href="Modulo-InicioSesion.php" class="btn boton-primario">Iniciar Sesion</a>
                        <!-- <a href="Modulo-Registro.html" class="btn boton-primario">Registrarse</a>-->
                        <!-- <a href="AcercaDe.html" class="btn boton-primario">Cerrar Sesion</a>-->
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="form-container">
        <h2 class="titulo">Registro</h2>
        <form action="procesar.php" method="post" onsubmit="return validarFormulario()">
            <div class="row">
                <!-- Campo de nombre -->
                <div class="col-md-6 mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre completo"
                            maxlength="100" oninput="limitarTexto(this)" required />
                    </div>
                </div>

                <!-- Campo de teléfono -->
                <div class="col-md-6 mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                        <input type="number" class="form-control" min="0" id="telefono" name="telefono"
                            oninput="limitarTelefono(this)" placeholder="Teléfono" required />
                    </div>
                </div>

                <!-- Campo de correo -->
                <div class="col-md-6 mb-3">
                    <label for="correo" class="form-label">Correo</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control" id="correo" name="correo"
                            placeholder="Correo electrónico" oninput="limitarCorreo(this)" required />
                    </div>
                </div>

                <!-- Campo de contraseña -->
                <div class="col-md-6 mb-3">
                    <label for="contrasena" class="form-label">Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" class="form-control" id="contrasena" name="contrasena"
                            placeholder="Contraseña" maxlength="255" required />
                    </div>
                </div>

                <!-- Campo de confirmar contraseña -->
                <div class="col-md-6 mb-3">
                    <label for="confirmar_contrasena" class="form-label">Confirmar Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" class="form-control" id="confirmar_contrasena"
                            name="confirmar_contrasena" maxlength="255" placeholder="Confirma contraseña" required />
                    </div>
                </div>

                <div>
                    <input type="hidden" id="formulario" name="formulario" value="registrarUsuario">
                </div>
            </div>

            <!-- Botón de registro -->
            <button type="submit" class="btn btn-primario w-100">
                Registrarme
            </button>
            <div align="center">
                ¿Ya tienes una cuenta?
                <a href="Modulo-InicioSesion.php">Inicia sesion aqui.</a>
            </div>
        </form>
    </div>
    <script>
        function limitarTexto(input) {
            input.value = input.value.replace(/[^a-zA-ZÀ-ÿ\u00f1\u00d1\s]/g, "");
        }
        function limitarTelefono(input) {
            input.value = input.value.replace(/[^0-9]/g, ""); //permite solo numeros del 0 al 9
        }
        function limitarCorreo(input){
            input.value = input.value.replace(/[^a-zA-Z0-9._%+-@.]/g, '');; //filtro para el campo del email aceptando solo mayusculas, mimnuscylas numeros y caracteres (mas adelante hay otro filtro para el email para verificar su estructura cuadno se quiera enviar)

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
                        window.location.href = "Modulo-Registro.php";
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
                        window.location.href = "Modulo-Registro.php";
                    }
                });
                return false; // Bloquea el envío
            }

            const nombre = document.getElementById("nombre").value;
            if (nombre.length < 1 || nombre.length > 100) {
                Swal.fire({
                    title: "Advertencia",
                    text: "El nombre debe tener entre 1 y 100 caracteres.",
                    icon: "warning",
                    background: "#2e073f",  // Fondo personalizado 
                    color: "#ffffff",       // Texto en color blanco
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Aceptar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "Modulo-Registro.php";
                    }
                });
                return false; // Bloquea el envío
            }
            const emailInput = document.getElementById('correo');
            const emailValue = emailInput.value.trim(); // Elimina espacios en blanco
            const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

            if (emailValue.length < 7 || emailValue.length > 45) {
                emailInput.focus();
                Swal.fire({
                    title: "Advertencia",
                    text: "El correo debe tener entre 7 caracteres como minimo y 45 caracteres como maximo.",
                    icon: "warning",
                    background: "#2e073f",  // Fondo personalizado 
                    color: "#ffffff",       // Texto en color blanco
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Aceptar"
                });
                return false;
            }

            if (!emailRegex.test(emailValue)) {
                emailInput.focus();
                Swal.fire({
                    title: "Advertencia",
                    text: "El correo ingresado no cumple con las caracteristicas de una dirección de correo.",
                    icon: "warning",
                    background: "#2e073f",  // Fondo personalizado 
                    color: "#ffffff",       // Texto en color blanco
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Aceptar"
                });
                return false;
            }            

            const contra_confirma = document.getElementById("confirmar_contrasena").value;
            if (contra_confirma.length < 8 || contra_confirma.length > 100) {
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
                        window.location.href = "Modulo-Registro.php";
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