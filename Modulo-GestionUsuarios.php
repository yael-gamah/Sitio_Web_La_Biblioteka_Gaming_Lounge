<?php
require_once 'procesar.php';
$ejecutar = new moduloGestionUsuarios();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="img/icono.png" type="image/png" />
    <title>Gestión de Usuarios - La Biblioteka Gaming Lounge</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" />
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

        .container-gestion {
            max-width: 900px;
            margin: auto;
            padding: 2rem;
            background-color: #1a0523;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5);
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

        .tabla-container {
            max-height: 150px;
            /* Altura máxima de la tabla */
            overflow-y: auto;
            /* Habilita la barra de desplazamiento vertical */
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

    <!--Boton regresar-->
    <div class="container mt-3">
    <button class="btn btn-regresar" onclick="window.location.href='Interfaz_Grafica.php'">
        <i class="bi bi-arrow-left-circle-fill"></i> Regresar
    </button>
</div>

    <!-- Contenedor de gestión de usuarios -->
    <div class="container-gestion">
        <h2 class="titulo" name="titulo">Gestión de Usuarios</h2>

        <!-- Formulario para crear un nuevo usuario -->
        <div class="mb-4">
            <h5>Crear Nuevo Usuario</h5>
            <form id="form-crear-usuario" action="procesar.php" method="post" onsubmit="return validarFormulario()">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                            <input type="text" class="form-control" id="nombre" name="nombre"
                                placeholder="Nombre completo" oninput="limitarTexto(this)" required />
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                            <input type="number" class="form-control" min="0" id="telefono" name="telefono"
                                placeholder="Teléfono" required/>
                        </div>
                    </div>

                    <!--Hideen-->
                    <div>
                        <input type="hidden" id="formulario" name="formulario" value="gestionUsuarios">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="correo" class="form-label">Correo</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control" id="correo" name="correo"
                                placeholder="Correo electrónico"  required/>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="contrasena" class="form-label">Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" class="form-control" id="contrasena" name="contrasena"
                                placeholder="Contraseña" required/>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="confirmar_contrasena" class="form-label">Confirmar Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" class="form-control" id="confirmar_contrasena"
                                name="confirmar_contrasena" placeholder="Confirma contraseña" required/>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="rol" class="form-label">Rol</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-controller"></i></span>
                            <select class="form-select" id="roles" name="roles" required>
                                <option value="" selected disabled>Selecciona una rol</option>
                                <option value="Cliente">Cliente</option>
                                <option value="Trabajador">Trabajador</option>
                                <option value="Administrador">Administrador</option>
                            </select>
                        </div>
                    </div>

                </div>
                <button type="submit" class="btn btn-primario w-100">
                    Crear Usuario
                </button>
            </form>
        </div>

        <!-- Lista de usuarios con barra lateral -->
        <div class="mb-4">
            <h5>Lista de Usuarios</h5>
            <div class="tabla-container">
                <table class="table table-dark table-striped" id="tablaUsuarios">
                    <thead>
                        <tr>
                            <th>Nombre de Usuario</th>
                            <th>Correo</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="listaUsuarios">
                        <?php
                        $ejecutar->mostrarUsuarios();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal para editar el rol del usuario -->
    <div class="modal fade" id="modalEditarRol" tabindex="-1" aria-labelledby="modalEditarRolLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarRolLabel">
                        Editar Rol de Usuario
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="procesar.php" method="post">
                    <!--Hideen-->
                    <div>
                        <input type="hidden" id="formulario" name="formulario" value="editarUsuario">
                    </div>
                    <div>
                        <input type="hidden" id="name" name="name" value="">
                    </div>
                    <div class="modal-body">
                        <select class="form-select" id="nuevoRolUsuario" name="nuevoRol">
                            <option value="Cliente">Cliente</option>
                            <option value="Trabajador">Trabajador</option>
                            <option value="Administrador">Administrador</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primario">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
        function limitarTexto(input) {            
            input.value = input.value.replace(/[^a-zA-ZÀ-ÿ\u00f1\u00d1\s]/g, "");
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
                        window.location.href = "Modulo-GestionUsuarios.php";
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
                        window.location.href = "Modulo-GestionUsuarios.php";
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
                        window.location.href = "Modulo-GestionUsuarios.php";
                    }
                });
                return false; // Bloquea el envío
            }

            const correo = document.getElementById("correo").value;
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
                        window.location.href = "Modulo-GestionUsuarios.php";
                    }
                });
                return false; // Bloquea el envío
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
                        window.location.href = "Modulo-GestionUsuarios.php";
                    }
                });
                return false; // Bloquea el envío
            }

            const selectRol = document.getElementById("roles");
            if (selectRol.value === "") {
                selectRol.focus();
                return false;
            }  

            return true; // Permite el envío si ambos campos son válidos
        }        
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>