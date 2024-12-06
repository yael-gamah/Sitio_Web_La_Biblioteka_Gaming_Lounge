<?php
if (session_status() == PHP_SESSION_ACTIVE){
    session_destroy();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/icono.png" type="image/png">
    <title>Bienvenida - La Biblioteka Gaming Lounge</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Importar Bootstrap Icons -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <style>
        :root {
            --color-primario: #7A1CAC;
            --color-secundario: #7A1CAC;
        }

        body {
            background: url('img/fondo.jpg') no-repeat center center fixed;
            background-size: cover;
            color: azure;
            margin: 0;
        }

        .barra-navegacion {
            background-color: #7A1CAC;
        }

        .navbar-brand,
        .nav-link {
            color: azure;
        }

        .container-bienvenida {
            max-width: 600px;
            text-align: center;
            background-color: rgba(26, 5, 35, 0.85);
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.7);
            margin-top: 5%; /* Agrega un margen superior para que no esté muy pegado a la barra */
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

        .boton-secundario {
            background-color: var(--color-secundario);
            border-color: var(--color-secundario);
            color: white;
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

        .boton-secundario:hover {
            background-color: #EBD3F8;
            border-color: #EBD3F8;
        }

        .logo {
            width: 200px;
            height: auto;
            margin-bottom: 1rem;
        }

        .redes-sociales {
            margin-top: 2rem;
        }

        .redes-sociales a {
            color: white;
            font-size: 1.5rem;
            margin: 0 10px;
            transition: color 0.3s;
        }

        .redes-sociales a:hover {
            color: #EBD3F8;
        }
    </style>
</head>

<body>
    <!-- Barra de navegación -->
    <nav class="barra-navegacion navbar navbar-expand-lg navbar-light">
        <div class="container">
            <strong style="font-size: 30px; color: azure;">La Biblioteka Gaming Lounge</strong>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNavegacion"
                aria-controls="menuNavegacion" aria-expanded="false" aria-label="Alternar navegación">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menuNavegacion">
                <ul class="navbar-nav ms-auto">
                    <!-- Botones de Registro e Inicio de Sesión -->
                    <li class="nav-item ms-3">
                        <!-- <a href="Interfaz Grafica.html" class="btn boton-primario">Inicio</a>
                        <a href="AcercaDe.html" class="btn boton-primario">Acerca De</a> -->
                        <a href="Modulo-InicioSesion.php" class="btn boton-primario">Iniciar Sesion</a>
                        <a href="Modulo-Registro.php" class="btn boton-primario">Registrarse</a>
                        <!--<a href="AcercaDe.html" class="btn boton-primario">Cerrar Sesion</a>-->
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    
  

    <!-- Contenedor de bienvenida -->
    <div class="container-bienvenida mx-auto">
        <!-- Logo -->
        <img src="Img/Logo.png" alt="Logo La Biblioteka" class="logo">

        <!-- Título de bienvenida -->
        <h1 class="mb-4">¡Bienvenido a La Biblioteka Gaming Lounge!</h1>

        <!-- Información general -->
        <p class="mb-4">
            <b> Bienvenido a La Biblioteka Gaming Lounge, tu espacio ideal para disfrutar de videojuegos y eventos
                temáticos.
                Además, contamos con un Centro de Recompensas, donde podrás acumular puntos por cada visita y
                reservación.
                ¡Canjea tus puntos por descuentos, horas de juego extra y promociones especiales! </b>
        </p>
        
        <!-- Botones para registrarse e iniciar sesión -->
        <a href="Modulo-Registro.php" class="btn boton-secundario w-100 mb-2">Registrarme</a>
        <a href="Modulo-InicioSesion.php" class="btn boton-secundario w-100">Iniciar Sesión</a>

        <!-- Redes sociales -->
        <div class="redes-sociales mt-4">
            <h5 class="mb-3">Síguenos en:</h5>
            <a href="https://www.facebook.com/LaBibliotekaGL?locale=es_LA" target="_blank" class="bi bi-facebook"
                title="Facebook"></a>
            <a href="https://www.instagram.com/la_biblioteka/?hl=es" target="_blank" class="bi bi-instagram"
                title="Instagram"></a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
