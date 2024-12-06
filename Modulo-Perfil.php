<?php
require_once 'procesar.php';
$ejecutar = new moduloPerfil($_SESSION['telefono']);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="img/icono.png" type="image/png" />
    <title>Perfil de Usuario - La Biblioteka Gaming Lounge</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11">    </script>
    <style>
        :root {
            --color-primario: #7a1cac;
            --color-secundario: #3e0a5a;
            --color-fondo: rgba(26, 5, 35, 0.9);
        }

        body {
            background-color: #2e073f;
            color: azure;
            background: url("img/fondo.jpg") no-repeat center center fixed;
            background-size: cover;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        .container-perfil {
            max-width: 850px;
            margin: 1% auto;
            padding: 2rem;
            background-color: var(--color-fondo);
            border-radius: 15px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.6);
        }

        .barra-navegacion {
            background-color: var(--color-primario);
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.3);
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
            border: none;
            transition: background-color 0.3s, transform 0.2s;
        }

        .btn-primario:hover {
            background-color: #ebd3f8;
            color: #2e073f;
            transform: scale(1.05);
        }

        .btn-regresar {
            background-color: var(--color-primario);
            color: white;
            border: none;
            transition: background-color 0.3s, transform 0.2s;
        }

        .btn-regresar:hover {
            background-color: #5a6268;
            color: #ebd3f8;
            transform: scale(1.05);
        }

        .titulo {
            text-align: center;
            margin-bottom: 1.5rem;
            font-weight: bold;
            font-size: 2rem;
            color: #ebd3f8;
        }

        .tabla-visitas {
            margin-top: 2rem;
            max-height: 300px;
            overflow-y: scroll;
        }

        .form-control,
        .btn {
            border-radius: 0.5rem;
        }

        .puntos-container {
            text-align: center;
            margin-top: 1.5rem;
            padding: 1rem;
            background-color: var(--color-secundario);
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .puntos-container h4 {
            color: #ebd3f8;
        }
    </style>
</head>

<body>
    <nav class="barra-navegacion navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <img src="img/Logo.png" alt="Logo" style="width: 80px; height: auto; margin-right: 10px" />
            <strong style="font-size: 28px; color: azure">La Biblioteka Gaming Lounge</strong>
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

    <div class="container-perfil">
        <h2 class="titulo">Perfil de Usuario</h2>

        <div class="row mb-4">
            <div class="col-md-6 mb-2">
                <p>
                    <?php
                    $ejecutar->mostrarNombre();
                    ?>
                </p>
            </div>
            <div class="col-md-6 mb-2">
                <p>
                    <strong>Correo:</strong>
                    <?php
                    $ejecutar->mostrarCorreo();
                    ?>
                </p>
            </div>
            <div class="col-md-6 mb-2">
                <p>
                    <strong>Teléfono:</strong>
                    <?php
                    $ejecutar->mostrarTelefono();
                    ?>
                </p>
            </div>
            <div class="col-md-6 mb-2">
                <p>
                    <strong>Promoción Activa:</strong>
                    <?php
                    $ejecutar->mostrarPromocionActiva();
                    ?>
                </p>
            </div>
            <button class="btn btn-primario mt-2" data-bs-toggle="modal" data-bs-target="#modalEdicion">
                Editar Información
            </button>
        </div>

        <!-- Modal para editar datos personales -->
        <div class="modal fade" id="modalEdicion" tabindex="-1" aria-labelledby="modalEdicionLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalEdicionLabel">
                            Editar Información Personal
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="form-edicion" action="procesar.php" method="post" onsubmit="return validarFormulario()">
                            <div class="mb-3">
                                <label for="editNombre" class="form-label">Nombre</label>
                                <?php
                                $ejecutar->mostrarNombreForm();
                                ?>
                            </div>
                            <div class="mb-3">
                                <label for="editCorreo" class="form-label">Correo</label>
                                <?php
                                $ejecutar->mostrarCorreoForm();
                                ?>
                            </div>
                            <div class="mb-3">
                                <label for="editTelefono" class="form-label">Teléfono</label>
                                <?php
                                $ejecutar->mostrarTelefonoForm();
                                ?>
                            </div>
                            <!--Hidden-->
                            <div>
                                <input type="hidden" id="formulario" name="formulario" value="informacionPersonal">
                            </div>
                            <button type="submit" class="btn btn-primario w-100">
                                Guardar Cambios
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="puntos-container">
            <h4>Game Points</h4>
            <p>
                <?php
                $ejecutar->mostrarPuntos();
                ?>
            </p>
        </div>

        <div class="tabla-visitas">
            <h5>Historial de Visitas</h5>
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Duración</th>
                        <th>Consola</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $ejecutar->mostrarVisitas();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function limitarTexto(input) {
            input.value = input.value.replace(/[^a-zA-ZÀ-ÿ\u00f1\u00d1\s]/g, "");
        }
        function validarFormulario (){
            const campoNumerico = document.getElementById("editTelefono").value;
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
                        window.location.href = "Modulo-Perfil.php";
                    }
                });
                return false; // Bloquea el envío
            }

            const nombre = document.getElementById("editNombre").value;
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
                        window.location.href = "Modulo-Perfil.php";
                    }
                });
                return false; // Bloquea el envío
            }

            const correo = document.getElementById("editCorreo").value;
            if (correo.length < 1 || correo.length > 100) {
                Swal.fire({
                    title: "Advertencia",
                    text: "El correo debe tener entre 1 y 100 caracteres.",
                    icon: "warning",
                    background: "#2e073f",  // Fondo personalizado 
                    color: "#ffffff",       // Texto en color blanco
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Aceptar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "Modulo-Perfil.php";
                    }
                });
                return false; // Bloquea el envío
            }

            return true;
        }        
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>