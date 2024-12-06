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

    <title>La Biblioteka Gaming Lounge</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --color-primario: #7A1CAC;
            --color-secundario: #7A1CAC;
        }
        body {
            background-color: #2E073F;
            background: url('img/fondo.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .barra-navegacion {
            background-color: #7A1CAC;
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
        .navbar-brand, .nav-link {
            color: azure;
        }
        .boton-accion {
            color: azure;
        }
        .descripcion-negocio {
            color: azure;
            margin-top: 2rem;
            text-align: center;
        }
        .pie-de-pagina {
            background-color: #1A0523;
            color: white;
            padding: 1rem 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <nav class="barra-navegacion navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <img src="img/Logo.png" alt="Logo" style="width: 120px; height: auto; margin-right: 15px;"> <!-- Tamaño aumentado -->
            <strong style="font-size: 36px; color: azure;">La Biblioteka Gaming Lounge</strong> <!-- Tamaño de texto aumentado -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNavegacion" aria-controls="menuNavegacion" aria-expanded="false" aria-label="Alternar navegación">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menuNavegacion">
                <ul class="navbar-nav ms-auto">
                    <!-- Botones de Registro e Inicio de Sesión -->
                    <li class="nav-item ms-3">                        
                        <a href="AcercaDe.php" class="btn boton-primario">Acerca De</a>
                        <a href="Modulo-InicioSesion.php" class="btn boton-primario">Iniciar Sesion</a>
                        <a href="Modulo-Registro.php" class="btn boton-primario">Registrarse</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    
    

    <header class="encabezado py-5 text-center">
        <div class="container">
            <div class="contenedor-logo">
                <img src="img/Logo.png" class="img-fluid logo-personalizado">
            </div>
            <h1 style="color: azure;">Bienvenido a La Biblioteka Gaming Lounge</h1>
            <br><br>
            <div class="row justify-content-center">
                <!-- Botones de módulos -->
                <div class="col-md-3 col-6 mb-3">
                    <a href="Modulo-InicioSesion.php" class="btn boton-primario w-100 py-3">
                        <i class="bi bi-calendar-event mb-2 d-block"></i>
                        Reservar Evento
                    </a>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <a href="Modulo-InicioSesion.php" class="btn boton-secundario w-100 py-3">
                        <i class="bi bi-person mb-2 d-block"></i>
                        Mi Perfil
                    </a>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <a href="Modulo-InicioSesion.php" class="btn boton-secundario w-100 py-3">
                        <i class="bi bi-tags mb-2 d-block"></i>
                        Promociones y Descuentos
                    </a>
                </div>
            </div>

            <!-- Sección de descripción del negocio -->
            <div class="descripcion-negocio">
                <h2>Acerca de La Biblioteka Gaming Lounge</h2>
                <p>
                    La Biblioteka Gaming Lounge es un espacio dedicado a los amantes de los videojuegos, ofreciendo
                    una experiencia única de juego en consolas y PCs de última generación, así como eventos sociales y
                    torneos. Nuestro objetivo es crear un ambiente acogedor y divertido para toda la comunidad gamer.
                </p>
            </div>
        </div>
    </header>

    <!-- Pie de página -->
    <footer class="pie-de-pagina">
        <div class="container">
            <p>&copy; 2024 La Biblioteka Gaming Lounge. Todos los derechos reservados.</p>
            <p>Dirección: Belisario Dominguez #210 C
                Col. Centro, Plaza Estrella, Leon, gto.</p>
            <p>Teléfono:  477 101 1935   |   Email: master@labiblioteka.cafe</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
</body>
</html>
