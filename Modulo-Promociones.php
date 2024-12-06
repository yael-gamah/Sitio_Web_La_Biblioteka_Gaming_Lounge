<?php
require_once 'procesar.php';
$ejecutar = new moduloPromociones($_SESSION['telefono']);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/icono.png" type="image/png">
    <title>Promociones y Descuentos - La Biblioteka Gaming Lounge</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
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
        }

        .container-promociones {
            max-width: 1200px;
            margin: 3% auto;
            padding: 2rem;
            background-color: #1A0523;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5);
        }

        .titulo {
            text-align: center;
            margin-bottom: 1.5rem;
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
        }

        .btn-primario {
            background-color: #7A1CAC;
            border-color: #7A1CAC;
            color: #EBD3F8;
        }

        .tarjeta-promocion {
            background-color: #3E0A5A;
            padding: 1rem;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
            margin-bottom: 1rem;
        }

        .tarjeta-promocion h5 {
            color: #EBD3F8;
        }

        .btn-canjear {
            background-color: var(--color-primario);
            color: white;
            border-color: var(--color-primario);
        }

        .btn-canjear:hover {
            background-color: #EBD3F8;
            color: #2E073F;
            border-color: #EBD3F8;
        }

        .codigo-promocion {
            background-color: #5E1A69;
            padding: 1rem;
            border-radius: 10px;
            text-align: center;
            margin-top: 1.5rem;
            font-size: 1.2rem;
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

        .form-control,
        .btn {
            border-radius: 0.5rem;
        }

        .scroll-table {
            max-height: 150px;
            overflow-y: auto;
        }
    </style>
</head>

<body>

    <nav class="barra-navegacion navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <img src="img/Logo.png" alt="Logo" style="width: 120px; height: auto; margin-right: 15px;">
            <strong style="font-size: 36px; color: azure;">La Biblioteka Gaming Lounge</strong>
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

    <div class="container-promociones">
        <h2 class="titulo" name="titulo">Tienda de Promociones</h2>

        <div class="mb-4">
            <?php
            $ejecutar->mostrarPuntos();
            ?>
            
        </div>

        <div class="row" id="promocionesClientes" name="promocionesClientes">
            <!-- Tarjeta de promociones -->
             <?php
             $ejecutar->mostrarPromociones();
             ?>
        </div>

        <div id="codigoPromocion" class="codigo-promocion" name="codigo-promocion" style="display: none;">
            <p><strong>¡Promoción Canjeada!</strong></p>
            <p>Código de Promoción: <span id="codigoGenerado" name="codigoGenerado"></span></p>
            <p>Muestra este código en el local para aplicar el descuento.</p>
        </div>
        <?php
        $ejecutar->procesarMenu();
        $ejecutar->mostrarTablaPromociones();
        ?>
                


    </div>
    <script>
        function validarFormulario(){
            const nombre = document.getElementById("nombrePromocion").value;
            if (nombre.length < 1 || nombre.length > 100) {
                Swal.fire({
                    title: "Advertencia",
                    text: "El nombre de promocion debe tener entre 1 y 100 caracteres.",
                    icon: "warning",
                    background: "#2e073f",  // Fondo personalizado 
                    color: "#ffffff",       // Texto en color blanco
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Aceptar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "Modulo-Promociones.php";
                    }
                });
                return false; // Bloquea el envío
            }

            const codigo = document.getElementById("codigoPromocion").value;
            if (codigo.length < 1 || codigo.length > 50) {
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
                        window.location.href = "Modulo-Promociones.php";
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