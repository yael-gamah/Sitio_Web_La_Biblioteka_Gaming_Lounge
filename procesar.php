<html>

<head>
    <link rel="icon" href="img/icono.png" type="image/png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>La Biblioteka Gaming Lounge</title>
    <style>
        body {
            background-color: #2e073f;
            background: url("img/fondo.jpg") no-repeat center center fixed;
            background-size: cover;
            color: azure;
        }
    </style>
</head>

</html>
<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $formulario = $_POST['formulario'] ?? '';
    switch ($formulario) {
        case 'registrarUsuario':
            #Header ("Location: procesar.php");
            $modulo_registro = new moduloRegistro($_POST['nombre'], $_POST['telefono'], $_POST['correo'], $_POST['contrasena'], $_POST['confirmar_contrasena']);
            break;
        case 'iniciarSesion':
            $iniciar_sesion = new inicioSesion($_POST['telefono'], $_POST['contrasena']);
            break;
        case 'reservarEvento':
            $reservar = new moduloReservaciones($_SESSION['telefono']);
            $reservar->procesarReservacion($_POST['nombre'], $_POST['correo'], $_POST['telefono'], $_POST['fecha'], $_POST['hora'], $_POST['paquete']);
            break;
        case 'informacionPersonal':
            $editInformacion = new moduloPerfil($_SESSION['telefono']);
            $editInformacion->editarInformacion($_POST['editNombre'], $_POST['editCorreo'], $_POST['editTelefono']);
            break;
        case 'registrarVisita':
            $registraVisita = new moduloRegistroVisitas();
            $usar_promocion = false;
            if (isset($_POST['promocion']) && $_POST['promocion'] == "si") {
                $usar_promocion = true;
            }
            $registraVisita->registrarVisitas($_POST['cliente'], $_POST['fecha'], $_POST['hora'], $_POST['horas'], $_POST['consola'], $_POST['juego'], $usar_promocion);
            break;
        case 'gestionUsuarios':
            $gestion = new moduloGestionUsuarios();
            $gestion->registrarUsuario($_POST['roles'], $_POST['nombre'], $_POST['correo'], $_POST['telefono'], $_POST['contrasena'], $_POST['confirmar_contrasena']);
            break;
        case 'registrarConsola':
            $consola = new moduloConsolaVideojuego();
            $consola->registrarconsola(tipo_consola: $_POST['nombreConsola']);
            break;
        case 'registrar_videojuego':
            $juego = new moduloConsolaVideojuego();
            $juego->registrarJuego($_POST['nombreJuego'], $_POST['tipoConsola']);
            break;
        case 'canjeaPromocion':
            $canjea = new moduloPromociones($_SESSION['telefono']);
            $canjea->canjearPromocion($_POST['botonCanejar']);
            break;
        case 'registrarPromocion':
            $registra = new moduloPromociones($_SESSION['telefono']);
            $registra->registrarPromocion($_POST['nombrePromocion'], $_POST['costoPromocion'], $_POST['descripcionPromocion'], $_POST['codigoPromocion']);
            break;
        case 'borrarPromocion':
            #Header("Location: procesar.php?ps");
            $borrar = new moduloPromociones($_SESSION['telefono']);
            $borrar->borrarPromocion($_POST['valor']);
            break;
        case 'editarUsuario':
            $editar = new moduloGestionUsuarios();
            $editar->editarUsuario($_POST['nuevoRol'], $_POST['name']);
            break;
        case 'eliminarUsuario':
            $eliminar = new moduloGestionUsuarios();
            $eliminar->eliminarUsuario($_POST['valor']);
            break;

    }
}




class moduloVerReserva
{
    private $telefono;
    public function __construct($telefono)
    {
        $this->telefono = $telefono ?? null;
        $this->telefono = $telefono ?? '';
    }
    public function mostrarReservaciones()
    {
        try {
            $obj = new crearConexion();
            $conexion = $obj->getConexion();
            $SQL = "SELECT nombre_completo, correo, telefono, fecha_evento, hora_evento, ID_paquete, ID_usuario FROM Reservacion";
            $sentencia = $conexion->prepare($SQL);
            $res = $sentencia->execute();
            if ($res) {
                if ($sentencia->rowCount() > 0) {
                    while ($row = $sentencia->fetch(PDO::FETCH_ASSOC)) {
                        $SQL = "SELECT nombre_paquete FROM Paquete WHERE ID_paquete = ?";
                        $sen = $conexion->prepare($SQL);
                        $r = $sen->execute([$row['ID_paquete']]);
                        if ($r) {
                            $m = $sen->fetch(PDO::FETCH_ASSOC);
                            $nombre_paquete = $m['nombre_paquete'];
                            $SQL = "SELECT nombre_usuario FROM Usuario WHERE ID_usuario = ?";
                            $sent = $conexion->prepare($SQL);
                            $resultado = $sent->execute([$row['ID_usuario']]);
                            if ($resultado) {
                                $n = $sent->fetch(PDO::FETCH_ASSOC);
                                $nombre_user = $n['nombre_usuario'];
                                echo ('<tr>
                                        <td>' . $nombre_user . '</td>
                                        <td>' . $row['correo'] . '</td>
                                        <td>' . $row['telefono'] . '</td>
                                        <td>' . $row['fecha_evento'] . '</td>
                                        <td>' . $row['fecha_evento'] . '</td>
                                        <td>' . $nombre_paquete . '</td>
                                    </tr>');
                            } else {
                                #fallo la consulta
                                echo ('<script>
                        Swal.fire({
                            title: "Error encontrado",
                            text: "No se pudo ejecutar la consulta, intentelo nuevamente",
                            icon: "error",
                            background: "#2e073f",  // Fon1do personalizado 
                            color: "#ffffff",       // Texto en color blanco
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "Aceptar"
                        }).then((result) => {           
                            if (result.isConfirmed) {
                                window.location.href = "Modulo-VerReserva.php";
                            }
                        });
                    </script>');
                            }
                        } else {
                            #fallo la consulta
                            echo ('<script>
                        Swal.fire({
                            title: "Error encontrado",
                            text: "No se pudo ejecutar la consulta, intentelo nuevamente",
                            icon: "error",
                            background: "#2e073f",  // Fon1do personalizado 
                            color: "#ffffff",       // Texto en color blanco
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "Aceptar"
                        }).then((result) => {           
                            if (result.isConfirmed) {
                                window.location.href = "Modulo-VerReserva.php";
                            }
                        });
                    </script>');
                        }
                    }
                }
            } else {
                echo ('<script>
                        Swal.fire({
                            title: "Error encontrado",
                            text: "No se pudo ejecutar la consulta, intentelo nuevamente",
                            icon: "error",
                            background: "#2e073f",  // Fon1do personalizado 
                            color: "#ffffff",       // Texto en color blanco
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "Aceptar"
                        }).then((result) => {           
                            if (result.isConfirmed) {
                                window.location.href = "Modulo-VerReserva.php";
                            }
                        });
                    </script>');
            }
        } catch (PDOException $e) {
            echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "Ha ocurrido un error fatal en la comunicación con la base de datos, regresando al inicio...",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-InicioSesion.php";
                        }
                    });
                </script>');
        } finally {
            $conexion = null;
        }
    }
    public function menuNavegacion()
    {
        if (session_status() == PHP_SESSION_ACTIVE) {
            echo ('<a href="Interfaz_Grafica.php" class="btn boton-primario">Inicio</a>                        
                        <a href="AcercaDe.php" class="btn boton-primario">Cerrar Sesion</a>');
        } else {
            echo ('<a href="AcercaDe.php" class="btn boton-primario">Acerca De</a>
                        <a href="Modulo-InicioSesion.php" class="btn boton-primario">Iniciar Sesion</a>
                        <a href="Modulo-Registro.php" class="btn boton-primario">Registrarse</a>');
        }
    }
}
class moduloEstadisticas
{
    private $telefono;
    public function __construct($telefono)
    {
        $this->telefono = $telefono ?? null;
        $this->telefono = $telefono ?? '';
    }


    public function menuNavegacion()
    {
        if (session_status() == PHP_SESSION_ACTIVE) {
            echo ('<a href="Interfaz_Grafica.php" class="btn boton-primario">Inicio</a>                        
                        <a href="AcercaDe.php" class="btn boton-primario">Cerrar Sesion</a>');
        } else {
            echo ('<a href="AcercaDe.php" class="btn boton-primario">Acerca De</a>
                        <a href="Modulo-InicioSesion.php" class="btn boton-primario">Iniciar Sesion</a>
                        <a href="Modulo-Registro.php" class="btn boton-primario">Registrarse</a>');
        }
    }

    public function consolaMayorRentada()
    {
        try {
            $obj = new crearConexion();
            $conexion = $obj->getConexion();
            $SQL = "SELECT ID_consola FROM Registro_visita";
            $sentencia = $conexion->prepare($SQL);
            $sentencia->execute();
            $ps5 = 0;
            $xbox = 0;
            $nintendo = 0;
            $pc = 0;
            if ($sentencia->rowCount() > 0) {
                #solo si hay visitas
                while ($res = $sentencia->fetch(PDO::FETCH_ASSOC)) {
                    $SQL = "SELECT tipo_consola FROM Consola WHERE ID_consola = ?";
                    $sen = $conexion->prepare($SQL);
                    $sen->execute([$res['ID_consola']]);
                    $re = $sen->fetch(PDO::FETCH_ASSOC);
                    $r = $re['tipo_consola'];
                    if ($r == "PlayStation_5") {
                        $ps5 = $ps5 + 1;
                    } else if ($r == "Xbox_Series_X") {
                        $xbox = $xbox + 1;
                    } else if ($r == "Nintendo_Switch") {
                        $nintendo = $nintendo + 1;
                    } else if ($r == "PC_Gamer") {
                        $pc = $pc + 1;
                    }
                }
                echo ("data: [$ps5, $xbox, $nintendo, $pc],");
            } else {
                #aun no hay visitas
            }
        } catch (PDOException $e) {
            Header("Location: Modulo-Estadisticas.php?error");
        } finally {
            $conexion = null;
        }
    }

    public function porcentajeVisitas()
    {
        try {
            $obj = new crearConexion();
            $conexion = $obj->getConexion();
            $horas_12 = 0;
            $horas_34 = 0;
            $horas_56 = 0;
            $horas_7 = 0;
            $SQL = "SELECT horas_jugadas FROM Registro_visita";
            $sentencia = $conexion->prepare($SQL);
            $sentencia->execute();
            if ($sentencia->rowCount() > 0) {
                #solo si hay registros
                while ($res = $sentencia->fetch(PDO::FETCH_ASSOC)) {
                    if ($res['horas_jugadas'] >= 1 && $res['horas_jugadas'] <= 2) {
                        $horas_12 = $horas_12 + 1;
                    } else if ($res['horas_jugadas'] >= 3 && $res['horas_jugadas'] <= 4) {
                        $horas_34 = $horas_34 + 1;
                    } else if ($res['horas_jugadas'] >= 5 && $res['horas_jugadas'] <= 6) {
                        $horas_56 = $horas_56 + 1;
                        ;
                    } else if ($res['horas_jugadas'] >= 7) {
                        $horas_7 = $horas_7 + 1;
                    }
                }
                echo ("data: [$horas_12, $horas_34, $horas_56, $horas_7],");
            }
        } catch (PDOException $e) {

        } finally {
            $conexion = null;
        }
    }
    public function visitasPorMes()
    {
        try {
            $obj = new crearConexion();
            $conexion = $obj->getConexion();

            // Consulta SQL para obtener visitas por mes de 2024
            $SQL = "SELECT 
                    MONTH(fecha_visita) AS mes,
                    COUNT(ID_visita) AS total_visitas
                FROM 
                    Registro_visita
                WHERE 
                    YEAR(fecha_visita) = 2024
                GROUP BY 
                    MONTH(fecha_visita)
                ORDER BY 
                    mes";
            $sentencia = $conexion->prepare($SQL);
            $sentencia->execute();

            // Inicializar arreglo con 0 visitas para los 12 meses
            $visitasPorMes = array_fill(1, 12, 0);

            // Actualizar los valores con los datos obtenidos
            while ($res = $sentencia->fetch(PDO::FETCH_ASSOC)) {
                $visitasPorMes[$res['mes']] = (int) $res['total_visitas'];
            }

            // Generar la estructura requerida
            echo "data: [" . implode(", ", $visitasPorMes) . "],";

        } catch (PDOException $e) {
            // Manejo de errores
            header("Location: Modulo-Estadisticas.php?error");
        } finally {
            $conexion = null;
        }
    }
    public function juegosMasElegidos()
    {
        try {
            $obj = new crearConexion();
            $conexion = $obj->getConexion();

            // Consulta SQL para obtener nombres de juegos y total de visitas por juego
            $SQL = "SELECT 
                    j.nombre_juego AS nombre,
                    COUNT(rv.ID_visita) AS total_visitas
                FROM 
                    Registro_visita rv
                INNER JOIN 
                    Juego j ON rv.ID_juego = j.ID_juego
                GROUP BY 
                    j.ID_juego
                ORDER BY 
                    total_visitas DESC"; // Opcional: ordenar por juegos más visitados
            $sentencia = $conexion->prepare($SQL);
            $sentencia->execute();

            // Inicializar arreglos para nombres de juegos y visitas
            $labels = [];
            $data = [];

            // Procesar los resultados
            while ($res = $sentencia->fetch(PDO::FETCH_ASSOC)) {
                $labels[] = $res['nombre'];
                $data[] = (int) $res['total_visitas'];
            }

            // Generar la estructura requerida
            echo "labels: ['" . implode("', '", $labels) . "'],";
            echo "data: [" . implode(", ", $data) . "],";

        } catch (PDOException $e) {
            // Manejo de errores
            header("Location: Modulo-Estadisticas.php?error");
        } finally {
            $conexion = null;
        }
    }




}
class moduloPromociones
{
    private $telefono;
    private $ID_usuario;
    public function __construct($tel)
    {
        $this->telefono = $tel ?? null;
        $this->telefono = $tel ?? '';
        $this->buscarID_usuario();
    }

    public function registrarPromocion($nombre, $costo, $descripcion, $codigo)
    {
        try {
            $obj = new crearConexion();
            $conexion = $obj->getConexion();
            $SQL = "SELECT codigo_promocion FROM Promocion WHERE codigo_promocion = ?";
            $sentencia = $conexion->prepare($SQL);
            $sentencia->execute([$codigo]);
            if ($sentencia->rowCount() == 0) {
                $SQL = "INSERT INTO Promocion (nombre_promocion, descripcion, costo_en_puntos, codigo_promocion)values(?,?,?,?)";
                $sentencia = $conexion->prepare($SQL);
                $res = $sentencia->execute([$nombre, $descripcion, $costo, $codigo]);
                if ($res) {
                    echo ('<script>
                                    Swal.fire({
                                        title: "Exito",
                                        text: "La promocion con codigo: ' . $codigo . ' se ha registrado en la base de datos",
                                        icon: "success",
                                        iconColor: "#00ff00",  // Icono verde para indicar éxito
                                        background: "#2e073f",  // Fondo personalizado                                        
                                        color: "#ffffff",       // Texto en color blanco
                                        confirmButtonColor: "#3085d6",
                                        confirmButtonText: "Aceptar"
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = "Modulo-Promociones.php?";                                            
                                        }
                                    });
                                </script>');
                } else {
                    echo ('<script>
                        Swal.fire({
                            title: "Error encontrado",
                            text: "La promocion con el codigo: ' . $codigo . ' no se pudo registrar en la base de datos, intentalo nuevamente.",
                            icon: "error",
                            background: "#2e073f",  // Fon1do personalizado 
                            color: "#ffffff",       // Texto en color blanco
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "Aceptar"
                        }).then((result) => {           
                            if (result.isConfirmed) {
                                window.location.href = "Modulo-Promociones.php";
                            }
                        });
                    </script>');
                }

            } else {
                echo ('<script>
                    Swal.fire({
                        title: "Promocion ya registrada",
                        text: "La promocion con el codigo: ' . $codigo . ' ya se encuentra registrada en la base de datos, intentalo nuevamente con otro codigo de descuento.",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-Promociones.php";
                        }
                    });
                </script>');
            }
        } catch (PDOException $e) {
            echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "Ha ocurrido un error fatal en la comunicación con la base de datos, regresando al inicio...",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-InicioSesion.php";
                        }
                    });
                </script>');

        } finally {
            $conexion = null;
        }
    }

    public function borrarPromocion($boton)
    {
        try {
            $obj = new crearConexion();
            $conexion = $obj->getConexion();
            $SQL = "DELETE FROM Promocion WHERE codigo_promocion = ?";
            $sentencia = $conexion->prepare($SQL);
            $res = $sentencia->execute([$boton]);
            if ($res) {
                echo ('<script>
                Swal.fire({
                    title: "¡Eliminación Exitoso!",
                    text: "La promocion con codigo: ' . $boton . ' ha sido eliminada de la base de datos",
                    icon: "success",
                    iconColor: "#00ff00",  // Icono verde para indicar éxito
                    background: "#2e073f",  // Fondo personalizado                                        
                    color: "#ffffff",       // Texto en color blanco
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Aceptar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "Modulo-Promociones.php?";                                            
                    }
                });
            </script>');
            } else {
                echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "Ha ocurrido un error al intentar eliminar la promocion de la base de datos.",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-Promociones.php";
                        }
                    });
                </script>');
            }
        } catch (PDOException $e) {
            echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "Ha ocurrido un error fatal en la comunicación con la base de datos, regresando al inicio...",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-InicioSesion.php";
                        }
                    });
                </script>');

        } finally {
            $conexion = null;
        }
    }

    public function canjearPromocion($nueva_promo)
    {
        try {
            $obj = new crearConexion();
            $conexion = $obj->getConexion();
            $SQL = "SELECT promocion_activa, puntos FROM Usuario WHERE ID_usuario = ?";
            $sentencia = $conexion->prepare($SQL);
            $sentencia->execute([$this->ID_usuario]);
            if ($sentencia->rowCount() == 1) {
                $row = $sentencia->fetch(PDO::FETCH_ASSOC);
                $promocion = $row['promocion_activa'];
                if ($promocion == '') {
                    $puntos = $row['puntos'];
                    $SQL = "SELECT nombre_promocion, costo_en_puntos FROM Promocion WHERE codigo_promocion = ?";
                    $sentencia = $conexion->prepare($SQL);
                    $sentencia->execute([$nueva_promo]);
                    if ($sentencia->rowCount() == 1) {
                        $res = $sentencia->fetch(PDO::FETCH_ASSOC);
                        $nombre_promo = $res['nombre_promocion'];
                        $costo = $res['costo_en_puntos'];
                        if ($puntos >= $costo) {
                            $nuevoPuntos = $puntos - $costo;
                            $SQL = "UPDATE Usuario SET puntos = ? WHERE ID_usuario =?";
                            $sentencia = $conexion->prepare($SQL);
                            $res = $sentencia->execute([$nuevoPuntos, $this->ID_usuario]);
                            if ($res) {
                                $SQL = "UPDATE Usuario SET promocion_activa = ? WHERE ID_usuario = ?";
                                $sentencia = $conexion->prepare($SQL);
                                $res = $sentencia->execute([$nombre_promo, $this->ID_usuario]);
                                if ($res) {
                                    echo ('<script>
                                        Swal.fire({
                                            title: "¡Canjeo Exitoso!",
                                            text: "Haz canjeado la promocion: ' . $nombre_promo . '",
                                            icon: "success",
                                            iconColor: "#00ff00",  // Icono verde para indicar éxito
                                            background: "#2e073f",  // Fondo personalizado                                        
                                            color: "#ffffff",       // Texto en color blanco
                                            confirmButtonColor: "#3085d6",
                                            confirmButtonText: "Aceptar"
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.href = "Modulo-Promociones.php?";                                            
                                            }
                                        });
                                    </script>');
                                } else {
                                    echo ('<script>
                                    Swal.fire({
                                        title: "Error encontrado",
                                        text: "Ha ocurrido un error al canjear tu promocion, intentalo nuevamente.",
                                        icon: "error",
                                        background: "#2e073f",  // Fon1do personalizado 
                                        color: "#ffffff",       // Texto en color blanco
                                        confirmButtonColor: "#3085d6",
                                        confirmButtonText: "Aceptar"
                                    }).then((result) => {           
                                        if (result.isConfirmed) {
                                            window.location.href = "Modulo-Promociones.php";
                                        }
                                    });
                                </script>');
                                }
                            } else {
                                echo ('<script>
                                    Swal.fire({
                                        title: "Error encontrado",
                                        text: "Ha ocurrido un error al canjear tu promocion, intentalo nuevamente.",
                                        icon: "error",
                                        background: "#2e073f",  // Fon1do personalizado 
                                        color: "#ffffff",       // Texto en color blanco
                                        confirmButtonColor: "#3085d6",
                                        confirmButtonText: "Aceptar"
                                    }).then((result) => {           
                                        if (result.isConfirmed) {
                                            window.location.href = "Modulo-Promociones.php";
                                        }
                                    });
                                </script>');
                            }
                        } else {
                            echo ('<script>
                                    Swal.fire({
                                        title: "Puntos insuficientes",
                                        text: "No tienes puntos suficientes para canjear esta promocion, ¡Adquiere mas puntos visitando nuestras instalaciones!.",
                                        icon: "error",
                                        background: "#2e073f",  // Fon1do personalizado 
                                        color: "#ffffff",       // Texto en color blanco
                                        confirmButtonColor: "#3085d6",
                                        confirmButtonText: "Aceptar"
                                    }).then((result) => {           
                                        if (result.isConfirmed) {
                                            window.location.href = "Modulo-Promociones.php";
                                        }
                                    });
                                </script>');
                        }
                    }
                }else{
                    echo('<script>Swal.fire({
                    title: "Advertencia",
                    text: "Actualmente ya cuentas con una promocion activa.",
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
                </script>');
                }
            }
        } catch (PDOException $e) {
            echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "Ha ocurrido un error fatal en la comunicación con la base de datos, regresando al inicio...",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-InicioSesion.php";
                        }
                    });
                </script>');

        } finally {

        }

    }
    public function menuNavegacion()
    {
        if (session_status() == PHP_SESSION_ACTIVE) {
            echo ('<a href="Interfaz_Grafica.php" class="btn boton-primario">Inicio</a>                        
                        <a href="AcercaDe.php" class="btn boton-primario">Cerrar Sesion</a>');
        } else {
            echo ('<a href="AcercaDe.php" class="btn boton-primario">Acerca De</a>
                        <a href="Modulo-InicioSesion.php" class="btn boton-primario">Iniciar Sesion</a>
                        <a href="Modulo-Registro.php" class="btn boton-primario">Registrarse</a>');
        }
    }
    private function buscarID_usuario()
    {
        try {
            $obj = new crearConexion();
            $conexion = $obj->getConexion();
            $SQL = "SELECT ID_usuario FROM Usuario WHERE telefono = ?";
            $sentencia = $conexion->prepare($SQL);
            $sentencia->execute([$this->telefono]);
            if ($sentencia->rowCount() == 1) {
                $row = $sentencia->fetch(PDO::FETCH_ASSOC);
                $this->ID_usuario = $row['ID_usuario'];
            } else {
                echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "Ha ocurrido un error al buscar el usuario en la base de datos, regresando al inicio...",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-InicioSesion.php";
                        }
                    });
                </script>');
            }
        } catch (PDOException $e) {
            echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "Ha ocurrido un error fatal en la comunicación con la base de datos, regresando al inicio...",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-InicioSesion.php";
                        }
                    });
                </script>');
        } finally {
            $conexion = null;
        }
    }

    public function mostrarPuntos()
    {
        try {
            $obj = new crearConexion();
            $conexion = $obj->getConexion();
            $SQL = "SELECT puntos FROM Usuario WHERE ID_usuario = ?";
            $sentencia = $conexion->prepare($SQL);
            $sentencia->execute([$this->ID_usuario]);
            if ($sentencia->rowCount() == 1) {
                $row = $sentencia->fetch(PDO::FETCH_ASSOC);
                $puntos = $row['puntos'];
                echo ('<h5>Puntos Disponibles: <span id="puntosDisponibles" name="puntosDisponibles">' . $puntos . '</span></h5>');
            } else {
                echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "Ha ocurrido un error al buscar el usuario en la base de datos, regresando al inicio...",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-InicioSesion.php";
                        }
                    });
                </script>');
            }
        } catch (PDOException $e) {
            echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "Ha ocurrido un error fatal en la comunicación con la base de datos, regresando al inicio...",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-InicioSesion.php";
                        }
                    });
                </script>');
        } finally {
            $conexion = null;
        }
    }

    public function procesarMenu()
    {
        try {
            $obj = new crearConexion();
            $conexion = $obj->getConexion();
            $SQL = "SELECT rol FROM Usuario WHERE ID_usuario = ?";
            $sentencia = $conexion->prepare($SQL);
            $sentencia->execute([$this->ID_usuario]);
            if ($sentencia->rowCount() == 1) {
                $row = $sentencia->fetch(PDO::FETCH_ASSOC);
                $rol = $row['rol'];
                if ($rol == "Trabajador" || $rol == "Administrador") {
                    echo ('<hr class="my-4">
        <h2 class="titulo" name="titulo">Gestión de Promociones (Trabajadores)</h2>                            
            
                    <!-- Formulario para agregar nuevas promociones -->
                    <div class="mb-4">
                        <h5>Agregar Nueva Promoción</h5>
                                    <form id="formAgregarPromocion" name="formAgregarPromocion" action="procesar.php" method="post" onsubmit="return validarFormulario()">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nombrePromocion" class="form-label">Nombre de la Promoción</label>
                        <input type="text" class="form-control" id="nombrePromocion" name="nombrePromocion"
                            placeholder="Nombre de la promoción" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="costoPromocion" class="form-label">Costo en Puntos</label>
                        <input type="number" class="form-control" id="costoPromocion" name="costoPromocion" min="1"
                            placeholder="Costo en puntos" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="descripcionPromocion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcionPromocion" name="descripcionPromocion" rows="2"
                            placeholder="Descripción de la promoción" required></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="codigoPromocion" class="form-label">Código de Promoción</label>
                        <input type="text" class="form-control" id="codigoPromocion" name="codigoPromocion"
                            placeholder="Código para aplicar la promoción" required>
                    </div>
                    <!--Hidden-->
            <div>
                <input type="hidden" id="formulario" name="formulario" value="registrarPromocion">
            </div>
                </div>
                <button type="submit" class="btn btn-primario w-100" id="botonAgregarPromocion"
                    name="botonAgregarPromocion">Agregar Promoción</button>
            </form>
                    </div>
            
                    <!-- Lista de promociones para trabajadores -->
                   <div class="mb-4">
            <h5>Lista de Promociones Activas</h5>
            <div class="scroll-table">
                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Costo (Puntos)</th>
                            <th>Código</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="listaPromocionesTrabajadores">
                        <!-- Promociones precargadas -->               
                                ');
                }
            } else {
                echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "Ha ocurrido un error al buscar el usuario en la base de datos, regresando al inicio...",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-InicioSesion.php";
                        }
                    });
                </script>');
            }
        } catch (PDOException $e) {
            echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "Ha ocurrido un error fatal en la comunicación con la base de datos, regresando al inicio...",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-InicioSesion.php";
                        }
                    });
                </script>');
        } finally {
            $conexion = null;
        }
    }

    public function mostrarPromociones()
    {
        try {
            $obj = new crearConexion();
            $conexion = $obj->getConexion();
            $SQL = "SELECT nombre_promocion, descripcion, costo_en_puntos, codigo_promocion FROM Promocion";
            $sentencia = $conexion->prepare($SQL);
            $sentencia->execute();
            if ($sentencia->rowCount() > 0) {
                while ($mostrar = $sentencia->fetch(PDO::FETCH_ASSOC)) {
                    echo ('<div class="col-md-4">
                            <div class="tarjeta-promocion">
                                <h5>' . $mostrar['nombre_promocion'] . '</h5>
                                <p>' . $mostrar['descripcion'] . '</p>
                                <p><strong>Costo: ' . $mostrar['costo_en_puntos'] . ' Puntos</strong></p>
                                <form action="procesar.php" method="post">
                                <input type="hidden" id="formulario" name="formulario" value="canjeaPromocion">
                                <button type="submit" name ="botonCanejar" value = "' . $mostrar['codigo_promocion'] . '" class="btn btn-canjear w-100">Canjear</button>
                                </form>
                            </div>
                        </div>');
                }
            }
        } catch (PDOException $e) {
            echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "Ha ocurrido un error fatal en la comunicación con la base de datos, regresando al inicio...",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-InicioSesion.php";
                        }
                    });
                </script>');
        } finally {

        }
    }

    public function mostrarTablaPromociones()
    {
        try {
            $obj = new crearConexion();
            $conexion = $obj->getConexion();
            $SQL = "SELECT nombre_promocion, descripcion, costo_en_puntos, codigo_promocion FROM Promocion";
            $sent = $conexion->prepare($SQL);
            $sent->execute();

            $SQL = "SELECT rol FROM Usuario WHERE ID_usuario = ?";
            $sentencia = $conexion->prepare($SQL);
            $sentencia->execute([$this->ID_usuario]);
            if ($sentencia->rowCount() == 1) {
                $row = $sentencia->fetch(PDO::FETCH_ASSOC);
                $rol = $row['rol'];
                if ($rol != "Cliente") {
                    while ($result = $sent->fetch(PDO::FETCH_ASSOC)) {
                        echo ('<tr>
                        <td>' . $result['nombre_promocion'] . '</td>
                        <td>' . $result['descripcion'] . '</td>
                        <td>' . $result['costo_en_puntos'] . '</td>
                        <td>' . $result['codigo_promocion'] . '</td>
                        <td><form action="procesar.php" method="post"><input type="hidden" id="formulario" name="formulario" value ="borrarPromocion"><button type="submit" name="valor" class="btn btn-danger btn-sm" value= "' . $result['codigo_promocion'] . '"><i class="bi bi-trash"></i></button></form></td>
                        </tr>');
                    }
                    echo ('
                            </tbody>
                </table>
            </div>
        </div>');
                }
            }
        } catch (PDOException $e) {
            echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "Ha ocurrido un error fatal en la comunicación con la base de datos, regresando al inicio...",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-InicioSesion.php";
                        }
                    });
                </script>');
        } finally {
            $conexion = null;
        }
    }

}

class moduloConsolaVideojuego
{
    public function __construct()
    {

    }
    public function registrarconsola($tipo_consola)
    {
        try {
            $obj = new crearConexion();
            $conexion = $obj->getConexion();
            $SQL = "SELECT tipo_consola FROM Consola WHERE tipo_consola = ?";
            $sentencia = $conexion->prepare($SQL);
            $sentencia->execute([$tipo_consola]);
            if ($sentencia->rowCount() < 1) {
                $SQL = "INSERT INTO Consola (tipo_consola)values (?)";
                $sentencia = $conexion->prepare($SQL);
                $res = $sentencia->execute([$tipo_consola]);
                if ($res) {
                    echo ('<script>
                                    Swal.fire({
                                        title: "¡Registro Exitoso!",
                                        text: "La consola: ' . $tipo_consola . ' ha sido registrada en el sistema.",
                                        icon: "success",
                                        iconColor: "#00ff00",  // Icono verde para indicar éxito
                                        background: "#2e073f",  // Fondo personalizado                                        
                                        color: "#ffffff",       // Texto en color blanco
                                        confirmButtonColor: "#3085d6",
                                        confirmButtonText: "Aceptar"
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = "Modulo-ConsolaVideojuego.php?";                                            
                                        }
                                    });
                                </script>');
                } else {
                    echo ('<script>
                    Swal.fire({
                        title: "Error",
                        text: "Ha ocurrido un error al intentar registrar la consola: ' . $tipo_consola . ' en el sistema",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-ConsolaVideojuego.php";
                        }
                    });
                </script>');
                }
            } else {
                echo ('<script>
                    Swal.fire({
                        title: "Consola ya registrada",
                        text: "La consola: ' . $tipo_consola . ' ya se encuentra registrada en el sistema",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-ConsolaVideojuego.php";
                        }
                    });
                </script>');
            }
        } catch (PDOException $e) {
            echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "Ha ocurrido un error fatal en la comunicación con la base de datos, regresando al inicio...",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-InicioSesion.php";
                        }
                    });
                </script>');

        } finally {
            $conexion = null;
        }
    }

    public function registrarJuego($nombre_juego, $tipo_consola)
    {
        try {
            $obj = new crearConexion();
            $conexion = $obj->getConexion();
            $SQL = "SELECT nombre_juego, ID_consola FROM Juego WHERE nombre_juego = ? AND ID_consola = ?";
            $sentencia = $conexion->prepare($SQL);
            $sentencia->execute([$nombre_juego, $tipo_consola]);
            if ($sentencia->rowCount() >= 1) {
                echo ('<script>
                    Swal.fire({
                        title: "Juego ya registrado",
                        text: "El juego: ' . $nombre_juego . ' ya se encuentra registrado para la consola seleccionada.",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-ConsolaVideojuego.php";
                        }
                    });
                </script>');
            } else {
                $SQL = "INSERT INTO Juego (nombre_juego, ID_consola)values (?,?)";
                $sentencia = $conexion->prepare($SQL);
                $sentencia->execute([$nombre_juego, $tipo_consola]);
                if ($sentencia) {
                    echo ('<script>
                                        Swal.fire({
                                            title: "¡Registro Exitoso!",
                                            text: "El juego: ' . $nombre_juego . ' ha sido registrada en el sistema.",
                                            icon: "success",
                                            iconColor: "#00ff00",  // Icono verde para indicar éxito
                                            background: "#2e073f",  // Fondo personalizado                                        
                                            color: "#ffffff",       // Texto en color blanco
                                            confirmButtonColor: "#3085d6",
                                            confirmButtonText: "Aceptar"
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.href = "Modulo-ConsolaVideojuego.php?";                                            
                                            }
                                        });
                                    </script>');
                } else {
                    echo ('<script>
                        Swal.fire({
                            title: "Error encontrado",
                            text: "No se ha podido registrar el juego ingresado, vuelva a intentarlo nuevamente",
                            icon: "error",
                            background: "#2e073f",  // Fon1do personalizado 
                            color: "#ffffff",       // Texto en color blanco
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "Aceptar"
                        }).then((result) => {           
                            if (result.isConfirmed) {
                                window.location.href = "Modulo-ConsolaVideojuego.php";
                            }
                        });
                    </script>');
                }


            }
        } catch (PDOException $e) {
            echo ('<script>
            Swal.fire({
                title: "Error encontrado",
                text: "Ha ocurrido un error fatal en la comunicación con la base de datos, regresando al inicio...",
                icon: "error",
                background: "#2e073f",  // Fon1do personalizado 
                color: "#ffffff",       // Texto en color blanco
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Aceptar"
            }).then((result) => {           
                if (result.isConfirmed) {
                    window.location.href = "Modulo-InicioSesion.php";
                }
            });
        </script>');
        } finally {
            $conexion = null;
        }
    }
    public function menuNavegacion()
    {
        if (session_status() == PHP_SESSION_ACTIVE) {
            echo ('<a href="Interfaz_Grafica.php" class="btn boton-primario">Inicio</a>                        
                        <a href="AcercaDe.php" class="btn boton-primario">Cerrar Sesion</a>');
        } else {
            echo ('<a href="AcercaDe.php" class="btn boton-primario">Acerca De</a>
                        <a href="Modulo-InicioSesion.php" class="btn boton-primario">Iniciar Sesion</a>
                        <a href="Modulo-Registro.php" class="btn boton-primario">Registrarse</a>');
        }
    }

    public function mostrarConsolas()
    {
        try {
            $obj = new crearConexion();
            $conexion = $obj->getConexion();
            $SQL = "SELECT tipo_consola, ID_consola  FROM Consola";
            $sentencia = $conexion->prepare($SQL);
            $sentencia->execute();
            if ($sentencia->rowCount() > 0) {
                while ($row = $sentencia->fetch(PDO::FETCH_ASSOC)) {
                    echo ('<option value="' . $row['ID_consola'] . '">' . $row['tipo_consola'] . '</option>');
                }
            } else {
                echo ('<option value="error">error</option>');
            }
        } catch (PDOException $e) {
            echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "Ha ocurrido un error fatal en la comunicación con la base de datos, regresando al inicio...",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-InicioSesion.php";
                        }
                    });
                </script>');
        } finally {

        }
    }
}
class moduloGestionUsuarios
{
    public function __construct()
    {

    }
    public function eliminarUsuario($ID_usuarioD)
    {
        try {
            $obj = new crearConexion();
            $conexion = $obj->getConexion();
            $SQL = "SELECT ID_usuario FROM Usuario WHERE ID_usuario = ?";
            $sentencia = $conexion->prepare($SQL);
            $sentencia->execute([$ID_usuarioD]);
            if ($sentencia->rowCount() == 1) {
                #se encpontro al usuario
                $SQL = "DELETE FROM Usuario WHERE ID_usuario = ?";
                $sentencia = $conexion->prepare($SQL);
                $res = $sentencia->execute([$ID_usuarioD]);
                if ($res) {
                    echo ('<script>
                                        Swal.fire({
                                            title: "¡Eliminación éxitosa!",
                                            text: "Haz eliminado al usuario de forma exitosa",
                                            icon: "success",
                                            iconColor: "#00ff00",  // Icono verde para indicar éxito
                                            background: "#2e073f",  // Fondo personalizado                                        
                                            color: "#ffffff",       // Texto en color blanco
                                            confirmButtonColor: "#3085d6",
                                            confirmButtonText: "Aceptar"
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.href = "Modulo-GestionUsuarios.php?";                                            
                                            }
                                        });
                                    </script>');
                } else {
                    echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "Ha ocurrio un error al intentar eliminar el usuario de la base de datos.",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "AcercaDe.php";
                        }
                    });
                </script>');
                }

            } else {
                #error
                echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "No se ha encontrado el usuario en la base de datos.",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "AcercaDe.php";
                        }
                    });
                </script>');
            }
        } catch (PDOException $e) {
            echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "Ha ocurrido un error fatal en la comunicación con la base de datos, regresando al inicio...",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-InicioSesion.php";
                        }
                    });
                </script>');
        } finally {
            $conexion = null;
        }
    }
    public function editarUsuario($n_rol, $name)
    {
        try {
            $obj = new crearConexion();
            $conexion = $obj->getConexion();
            $SQL = "SELECT nombre_usuario, ID_usuario FROM Usuario WHERE nombre_usuario = ?";
            $sentencia = $conexion->prepare($SQL);
            $sentencia->execute([$name]);
            if ($sentencia->rowCount() == 1) {
                $res = $sentencia->fetch(PDO::FETCH_ASSOC);
                $id = $res['ID_usuario'];
                #se encontro un solo usuario puedo continuar
                $SQL = "UPDATE Usuario SET rol = ? WHERE ID_usuario = ?";
                $sentencia = $conexion->prepare($SQL);
                $res = $sentencia->execute([$n_rol, $id]);
                if ($res) {
                    echo ('<script>
                                        Swal.fire({
                                            title: "¡Cambios Guardados!",
                                            text: "Haz cambiado el rol del usuario: ' . $name . ' ",
                                            icon: "success",
                                            iconColor: "#00ff00",  // Icono verde para indicar éxito
                                            background: "#2e073f",  // Fondo personalizado                                        
                                            color: "#ffffff",       // Texto en color blanco
                                            confirmButtonColor: "#3085d6",
                                            confirmButtonText: "Aceptar"
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.href = "Modulo-GestionUsuarios.php?";                                            
                                            }
                                        });
                                    </script>');
                } else {
                    echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "Ocurrio un error al actualizar el rol de usuario.",
                        icon: "error",
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-GestionUsuarios.php?";
                        }
                    });
                </script>');
                }

            } else {
                echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "No se encontro el usuario en la Base de Datos",
                        icon: "error",
                        background: "#2e073f",  // Fondo personalizado                                        
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "AcercaDe.php?";
                        }
                    });
                </script>');
            }
        } catch (PDOException $e) {
            echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "Ha ocurrido un error fatal en la comunicación con la base de datos, regresando al inicio...",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-InicioSesion.php";
                        }
                    });
                </script>');
        } finally {
            $conexion = null;
        }

    }

    public function mostrarUsuarios()
    {
        try {
            $obj = new crearConexion();
            $conexion = $obj->getConexion();
            $SQL = "SELECT nombre_usuario, correo, rol, ID_usuario FROM Usuario";
            $sentencia = $conexion->prepare($SQL);
            $sentencia->execute();
            if ($sentencia->rowCount() > 0) {
                while ($mostrar = $sentencia->fetch(PDO::FETCH_ASSOC)) {
                    echo ('<tr>
                        <td>' . htmlspecialchars($mostrar['nombre_usuario']) . '</td>
                        <td>' . htmlspecialchars($mostrar['correo']) . '</td>
                        <td>' . htmlspecialchars($mostrar['rol']) . '</td>
                        <td>
                            <form action="procesar.php" method="post">
                                <button class="btn btn-danger btn-sm" type="submit" name ="valor" value ="' . $mostrar['ID_usuario'] . '">
                                    <i class="bi bi-trash"></i>
                                </button>
                                <!-- Hidden -->
                                <div>
                                    <input type="hidden" id="formulario" name="formulario" value="eliminarUsuario">
                                </div>
                            </form>                            
                                <button class="btn btn-warning btn-sm"  onclick="editarRolUsuario(this)">
                                    <i class="bi bi-pencil"></i>
                                </button>                               
                           
                        </td>
                    </tr>');
                }
            }

        } catch (PDOException $e) {
            echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "Ha ocurrido un error fatal en la comunicación con la base de datos, regresando al inicio...",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-InicioSesion.php";
                        }
                    });
                </script>');
        } finally {
            $conexion = null;
        }
    }

    public function registrarUsuario($rol, $nombre, $correo, $telefonoU, $contrasena, $confirmar_contrasena)
    {
        try {
            $obj = new crearConexion();
            $conexion = $obj->getConexion();
            if ($contrasena == $confirmar_contrasena) {
                $SQL = "SELECT telefono FROM Usuario WHERE telefono = ?";
                $sentencia = $conexion->prepare($SQL);
                $sentencia->execute([$telefonoU]);
                if ($sentencia->rowCount() >= 1) {
                    echo ('<script>
                    Swal.fire({
                        title: "Teléfono ya registrado",
                        text: "El teléfono ' . $telefonoU . ' ya se encuentra registrado, intente nuevamente con otro teléfono.",
                        icon: "error",
                        background: "#2e073f",  // Fondo personalizado                                        
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",                        
                        confirmButtonText: "Aceptar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-GestionUsuarios.php";
                        }
                    });
                </script>');
                } else {
                    $SQL = "SELECT correo FROM Usuario WHERE correo = ?";
                    $sentencia = $conexion->prepare($SQL);
                    $sentencia->execute([$correo]);
                    if ($sentencia->rowCount() >= 1) {
                        echo ('<script>
                        Swal.fire({
                            title: "Correo ya registrado",
                            text: "El correo ' . $correo . ' ya se encuentra registrado, intente nuevamente con otro correo.",
                            icon: "error",
                            background: "#2e073f",  // Fondo personalizado                                        
                            color: "#ffffff",       // Texto en color blanco
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "Aceptar"
                        }).then((result) => {
                            if (result.isConfirmed) {                        
                                window.location.href = "Modulo-GestionUsuarios.php";                           
                            }
                        });
                    </script>');
                    } else {
                        $SQL = "SELECT nombre_usuario FROM Usuario WHERE nombre_usuario = ?";
                        $sentencia = $conexion->prepare($SQL);
                        $sentencia->execute([$nombre]);
                        if ($sentencia->rowCount() >= 1) {
                            echo ('<script>
                        Swal.fire({
                            title: "Nombre ya registrado",
                            text: "El nombre ' . $nombre . ' ya se encuentra registrado, intente nuevamente con otro nombre.",
                            icon: "error",
                            background: "#2e073f",  // Fondo personalizado                                        
                            color: "#ffffff",       // Texto en color blanco
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "Aceptar"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "Modulo-GestionUsuarios.php";
                            }
                        });
                    </script>');
                        } else {
                            #puedo registrar
                            $SQL = "INSERT INTO Usuario (nombre_usuario, telefono, contraseña, correo, rol, puntos, promocion_activa) VALUES (?, ?, ?, ?, ?, ?, ?)";
                            $sentencia = $conexion->prepare($SQL);
                            $puntos = 0;
                            $promocion = '';
                            $res = $sentencia->execute([$nombre, $telefonoU, $contrasena, $correo, $rol, $puntos, $promocion]);
                            if ($res) {
                                echo ('<script>
                            Swal.fire({
                                title: "¡Registro Éxitoso!",
                                text: "Haz registrado correctamente al usuario: ' . $nombre . ' en el sistema.",
                                icon: "success",
                                iconColor: "#00ff00",  // Icono verde para indicar éxito
                                background: "#2e073f",  // Fondo personalizado                                        
                                color: "#ffffff",       // Texto en color blanco
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Aceptar"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "Modulo-GestionUsuarios.php";
                                }
                            });
                        </script>');
                            } else {
                                echo ('<script>
                                    Swal.fire({
                                        title: "¡Ha ocurrido un error!",
                                        text: "Error encontrado al intentar registrar el usuario, favor de intentarlo nuevamente",
                                        icon: "error",
                                        background: "#2e073f",  // Fondo personalizado                                        
                                        color: "#ffffff",       // Texto en color blanco
                                        confirmButtonColor: "#3085d6",
                                        confirmButtonText: "Aceptar"
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = "Modulo-GestionUsuarios.php";
                                        }
                                    });
                                </script>');
                            }
                        }
                    }
                }
            } else {
                echo ('<script>
                    Swal.fire({
                        title: "Error",
                        text: "Las contraseñas ingresadas no coinciden",
                        icon: "error",
                        background: "#2e073f",  // Fondo personalizado                                        
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-GestionUsuarios.php?";
                        }
                    });
                </script>');
            }
        } catch (PDOException $e) {
            echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "Ha ocurrido un error fatal en la comunicación con la base de datos, regresando al inicio...",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-InicioSesion.php";
                        }
                    });
                </script>');
        } finally {
            $conexion = null;
        }
    }

    public function menuNavegacion()
    {
        if (session_status() == PHP_SESSION_ACTIVE) {
            echo ('<a href="Interfaz_Grafica.php" class="btn boton-primario">Inicio</a>                        
                        <a href="AcercaDe.php" class="btn boton-primario">Cerrar Sesion</a>');
        } else {
            echo ('<a href="AcercaDe.php" class="btn boton-primario">Acerca De</a>
                        <a href="Modulo-InicioSesion.php" class="btn boton-primario">Iniciar Sesion</a>
                        <a href="Modulo-Registro.php" class="btn boton-primario">Registrarse</a>');
        }
    }
}
class moduloRegistroVisitas
{
    private $telefono;
    private $ID_usuario;

    public function __construct()
    {

    }

    public function registrarVisitas($cliente, $fecha, $hora, $horas, $consola, $juego, $usar_promocion)
{
    try {
        
        // Convertir la fecha ingresada en un objeto DateTime
        $fechaIngresada = new DateTime($fecha);
        $diaSemana = $fechaIngresada->format('N'); // Devuelve 1 (lunes) a 7 (domingo)

        // Convertir la hora ingresada a formato completo (HH:mm:ss)
        $horaIngresada = new DateTime($hora . ":00");

        // Establecer los horarios permitidos
        $horaInicioSemana = new DateTime("10:00:00");
        $horaFinSemana = new DateTime("20:30:00");
        $horaFinDomingo = new DateTime("16:00:00");

        // Validar horario según el día de la semana
        $horaValida = false;
        if ($diaSemana >= 1 && $diaSemana <= 6) { // Lunes a sábado
            $horaValida = ($horaIngresada >= $horaInicioSemana && $horaIngresada <= $horaFinSemana);
        } elseif ($diaSemana == 7) { // Domingo
            $horaValida = ($horaIngresada >= $horaInicioSemana && $horaIngresada <= $horaFinDomingo);
        }

        // Si la hora no es válida, mostrar advertencia y salir del método
        if (!$horaValida) {
            echo ('<script>
                    Swal.fire({
                        title: "Hora no permitida",
                        text: "Las visitas solo están permitidas:\n - Lunes a sábado: 10:00 AM - 08:30 PM\n - Domingos: 10:00 AM - 04:00 PM.",
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
                </script>');
            return; // Salir del método si la hora no es válida
        }

        // Continuar con el resto del método si la hora es válida
        $obj = new crearConexion();
        $conexion = $obj->getConexion();

        // Verificar que el juego exista
        $SQL = "SELECT ID_juego FROM Juego WHERE nombre_juego = ?";
        $sentencia = $conexion->prepare($SQL);
        $sentencia->execute([$juego]);

        if ($sentencia->rowCount() == 1) {
            $row = $sentencia->fetch(PDO::FETCH_ASSOC);
            $ID_juego = $row['ID_juego'];

            // Verificar que el cliente exista
            $SQL = "SELECT ID_usuario, puntos FROM Usuario WHERE nombre_usuario = ?";
            $sentencia = $conexion->prepare($SQL);
            $sentencia->execute([$cliente]);

            if ($sentencia->rowCount() == 1) {
                $row = $sentencia->fetch(PDO::FETCH_ASSOC);
                $id = $row['ID_usuario'];
                $puntos_actuales = $row['puntos'];

                // Verificar que la consola exista
                $SQL = "SELECT ID_consola FROM Consola WHERE tipo_consola = ?";
                $sentencia = $conexion->prepare($SQL);
                $sentencia->execute([$consola]);
                $rp = $sentencia->fetch(PDO::FETCH_ASSOC);
                $id_consola = $rp['ID_consola'];

                // Insertar el registro de visita
                $SQL = "INSERT INTO Registro_visita (nombre_cliente, fecha_visita, hora_visita, horas_jugadas, ID_consola, ID_juego, ID_usuario) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
                $sentencia = $conexion->prepare($SQL);
                $sentencia->execute([$cliente, $fecha, $hora, $horas, $id_consola, $ID_juego, $id]);

                // Actualizar los puntos del usuario
                $puntos = $horas * 50;
                $puntos_actuales += $puntos;
                $SQL = "UPDATE Usuario SET puntos = ? WHERE ID_usuario = ?";
                $sentencia = $conexion->prepare($SQL);
                $sentencia->execute([$puntos_actuales, $id]);

                // Manejo de promociones
                if ($usar_promocion) {
                    $SQL = "SELECT promocion_activa FROM Usuario WHERE ID_usuario = ?";
                    $sen = $conexion->prepare($SQL);
                    $sen->execute([$id]);
                    $rst = $sen->fetch(PDO::FETCH_ASSOC);
                    $d = $rst['promocion_activa'];

                    if (!empty($d)) {
                        $SQL = "UPDATE Usuario SET promocion_activa = ? WHERE ID_usuario = ?";
                        $sent = $conexion->prepare($SQL);
                        $sent->execute(['', $id]);

                        echo ('<script>
                                Swal.fire({
                                    title: "¡Registro Éxitoso!",
                                    text: "Haz registrado la visita de forma exitosa y canjeado tu promoción.",
                                    icon: "success",
                                    background: "#2e073f",  // Fondo personalizado 
                                    color: "#ffffff",       // Texto en color blanco
                                    confirmButtonColor: "#3085d6",
                                    confirmButtonText: "Aceptar"
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "Modulo-RegistroVisitas.php";
                                    }
                                });
                            </script>');
                    } else {
                        echo ('<script>
                                Swal.fire({
                                    title: "¡Registro Éxitoso!",
                                    text: "Haz registrado la visita de forma exitosa.",
                                    icon: "success",
                                    background: "#2e073f",  // Fondo personalizado 
                                    color: "#ffffff",       // Texto en color blanco
                                    confirmButtonColor: "#3085d6",
                                    confirmButtonText: "Aceptar"
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "Modulo-RegistroVisitas.php";
                                    }
                                });
                            </script>');
                    }
                } else {
                    echo ('<script>
                            Swal.fire({
                                title: "¡Registro Éxitoso!",
                                text: "Haz registrado la visita de forma exitosa.",
                                icon: "success",
                                background: "#2e073f",  // Fondo personalizado 
                                color: "#ffffff",       // Texto en color blanco
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Aceptar"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "Modulo-RegistroVisitas.php";
                                }
                            });
                        </script>');
                }
            }
        } else {
            echo ('<script>
                    Swal.fire({
                        title: "Juego NO encontrado",
                        text: "No se encontró el juego: ' . $juego . ' en la base de datos.",
                        icon: "error",
                        background: "#2e073f",  // Fondo personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-RegistroVisitas.php";
                        }
                    });
                </script>');
        }
    } catch (PDOException $e) {
        echo ('<script>
                Swal.fire({
                    title: "Error encontrado",
                    text: "Ha ocurrido un error fatal en la comunicación con la base de datos.",
                    icon: "error",
                    background: "#2e073f",  // Fondo personalizado 
                        color: "#ffffff",       // Texto en color blanco
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Aceptar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "Modulo-InicioSesion.php";
                    }
                });
            </script>');
    } finally {
        $conexion = null;
    }
}



    public function mostrarClientes()
    {
        try {
            $obj = new crearConexion();
            $conexion = $obj->getConexion();
            $SQL = "SELECT nombre_usuario FROM Usuario";
            $sentencia = $conexion->prepare($SQL);
            $sentencia->execute();
            if ($sentencia->rowCount() > 0) {
                while ($mostrar = $sentencia->fetch(PDO::FETCH_ASSOC)) {
                    echo ('<option value="' . htmlspecialchars($mostrar['nombre_usuario']) . '">' . htmlspecialchars($mostrar['nombre_usuario']) . '</option>');
                }
            }
        } catch (PDOException $e) {
            echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "Ha ocurrido un error fatal en la comunicación con la base de datos, regresando al inicio...",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-InicioSesion.php";
                        }
                    });
                </script>');
        } finally {
            $conexion = null;
        }
    }

    public function mostrarConsolas()
    {
        try {
            $obj = new crearConexion();
            $conexion = $obj->getConexion();
            $SQL = "SELECT tipo_consola, ID_consola FROM Consola";
            $sentencia = $conexion->prepare($SQL);
            $sentencia->execute();
            if ($sentencia->rowCount() > 0) {
                while ($mostrar = $sentencia->fetch(PDO::FETCH_ASSOC)) {
                    echo ('<option value="' . $mostrar['tipo_consola'] . '">' . htmlspecialchars($mostrar['tipo_consola']) . '</option>');
                }
            }
        } catch (PDOException $e) {
            echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "Ha ocurrido un error fatal en la comunicación con la base de datos, regresando al inicio...",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-InicioSesion.php";
                        }
                    });
                </script>');
        } finally {
            $conexion = null;
        }
    }
    public function menuNavegacion()
    {
        if (session_status() == PHP_SESSION_ACTIVE) {
            echo ('<a href="Interfaz_Grafica.php" class="btn boton-primario">Inicio</a>                        
                        <a href="AcercaDe.php" class="btn boton-primario">Cerrar Sesion</a>');
        } else {
            echo ('<a href="AcercaDe.php" class="btn boton-primario">Acerca De</a>
                        <a href="Modulo-InicioSesion.php" class="btn boton-primario">Iniciar Sesion</a>
                        <a href="Modulo-Registro.php" class="btn boton-primario">Registrarse</a>');
        }
    }

    private function buscarID_usuario()
    {
        try {
            $obj = new crearConexion();
            $conexion = $obj->getConexion();
            $SQL = "SELECT ID_usuario FROM Usuario WHERE telefono = ?";
            $sentencia = $conexion->prepare($SQL);
            $sentencia->execute([$this->telefono]);
            if ($sentencia->rowCount() == 1) {
                $row = $sentencia->fetch(PDO::FETCH_ASSOC);
                $this->ID_usuario = $row['ID_usuario'];
            } else {
                echo ('<script>
                            Swal.fire({
                                title: "Error encontrado",
                                text: "No se encontro el usuario en la base de datos.",
                                icon: "error",
                                background: "#2e073f",  // Fondo personalizado                                        
                                color: "#ffffff",       // Texto en color blanco
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Aceptar"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = AcercaDe.php?";
                                }
                            });
                        </script>');
            }
        } catch (PDOException $e) {
            echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "Ha ocurrido un error fatal en la comunicación con la base de datos, regresando al inicio...",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-InicioSesion.php";
                        }
                    });
                </script>');
        } finally {
            $conexion = null;
        }
    }

    public function muestraJuegosConsola()
    {
        try {
            $obj = new crearConexion();
            $conexion = $obj->getConexion();
            $SQL = "SELECT nombre_juego, ID_consola FROM Juego";
            $sentencia = $conexion->prepare($SQL);
            $sentencia->execute();

            // Inicializamos cadenas para cada consola
            $ps5 = 'PlayStation_5: [';
            $xbox = 'Xbox_Series_X: [';
            $nint = 'Nintendo_Switch: [';
            $pc = 'PC_Gamer: [';

            $contadorPS5 = $contadorXbox = $contadorNint = $contadorPC = 0;

            if ($sentencia->rowCount() > 0) {
                while ($res = $sentencia->fetch(PDO::FETCH_ASSOC)) {
                    // Obtenemos el tipo de consola según el ID
                    $SQL = "SELECT tipo_consola FROM Consola WHERE ID_consola = ?";
                    $sen = $conexion->prepare($SQL);
                    $sen->execute([$res['ID_consola']]);
                    $re = $sen->fetch(PDO::FETCH_ASSOC);

                    $tipoConsola = $re['tipo_consola'];
                    $nombreJuego = addslashes($res['nombre_juego']); // Evitamos problemas con comillas

                    // Concatenamos cada juego en la consola correspondiente
                    if ($tipoConsola == "PlayStation_5") {
                        $ps5 .= ($contadorPS5++ > 0 ? ', ' : '') . "\"$nombreJuego\"";
                    } elseif ($tipoConsola == "Xbox_Series_X") {
                        $xbox .= ($contadorXbox++ > 0 ? ', ' : '') . "\"$nombreJuego\"";
                    } elseif ($tipoConsola == "Nintendo_Switch") {
                        $nint .= ($contadorNint++ > 0 ? ', ' : '') . "\"$nombreJuego\"";
                    } elseif ($tipoConsola == "PC_Gamer") {
                        $pc .= ($contadorPC++ > 0 ? ', ' : '') . "\"$nombreJuego\"";
                    }
                }
            }

            // Cerramos los corchetes de cada consola
            $ps5 .= ']';
            $xbox .= ']';
            $nint .= ']';
            $pc .= ']';

            // Concatenamos todas las consolas en una sola cadena
            $resultado = $ps5 . ', ' . $xbox . ', ' . $nint . ', ' . $pc;

            // Imprimimos el resultado final
            echo $resultado;

        } catch (PDOException $e) {

        } finally {
            $conexion = null;
        }
    }
}
class moduloPerfil
{
    private $telefono;
    private $ID_usuario;

    public function __construct($telefono)
    {
        $this->telefono = $telefono ?? null;
        $this->telefono = $telefono ?? '';
        $this->buscarID_usuario();
    }

    public function mostrarVisitas()
    {
        try {
            $obj = new crearConexion();
            $conexion = $obj->getConexion();
            $SQL = "SELECT fecha_visita, hora_visita, horas_jugadas, ID_consola FROM Registro_visita WHERE ID_usuario = ?";
            $sentencia = $conexion->prepare($SQL);
            $sentencia->execute([$this->ID_usuario]);
            if ($sentencia->rowCount() > 0) {
                while ($row = $sentencia->fetch(PDO::FETCH_ASSOC)) {
                    $ID_consola = $row['ID_consola'];
                    $SQL = "SELECT tipo_consola FROM Consola WHERE ID_consola =?";
                    $sen = $conexion->prepare($SQL);
                    $sen->execute([$ID_consola]);
                    $res = $sen->fetch(PDO::FETCH_ASSOC);
                    $tipo_consola = $res['tipo_consola'];
                    echo ('<tr>
                        <td>' . $row['fecha_visita'] . '</td>
                        <td>' . $row['hora_visita'] . '</td>
                        <td>' . $row['horas_jugadas'] . ' horas</td>
                        <td>' . $tipo_consola . '</td>
                    </tr>');
                }
            }
        } catch (PDOException $e) {
            echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "Ha ocurrido un error fatal en la comunicación con la base de datos, regresando al inicio...",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-InicioSesion.php";
                        }
                    });
                </script>');
        } finally {
            $conexion = null;
        }
    }

    public function editarInformacion($nuevo_nombre, $nuevo_correo, $nuevo_telefono)
    {
        try {
            $obj = new crearConexion();
            $conexion = $obj->getConexion();
            $SQL = "SELECT nombre_usuario FROM Usuario WHERE ID_usuario = ?";
            $sentencia = $conexion->prepare($SQL);
            $sentencia->execute([$this->ID_usuario]);
            if ($sentencia->rowCount() == 1) {
                $row = $sentencia->fetch(PDO::FETCH_ASSOC);
                $nombre = $row['nombre_usuario'];
                if ($nombre != $nuevo_nombre) {
                    $SQL = "UPDATE Usuario SET nombre_usuario = ? WHERE ID_usuario = ?";
                    $sentencia = $conexion->prepare($SQL);
                    $res = $sentencia->execute([$nuevo_nombre, $this->ID_usuario]);
                    if ($res) {
                        echo ('<script>
                                    Swal.fire({
                                        title: "Exito",
                                        text: "¡Los cambios se guardaron correctamente!",
                                        icon: "success",
                                        iconColor: "#00ff00",  // Icono verde para indicar éxito
                                        background: "#2e073f",  // Fondo personalizado                                        
                                        color: "#ffffff",       // Texto en color blanco                                        
                                        confirmButtonColor: "#3085d6",
                                        confirmButtonText: "Aceptar"
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = "Modulo-Perfil.php?";                                            
                                        }
                                    });
                                </script>');
                    } else {
                        echo ('<script>
                            Swal.fire({
                                title: "Error al actualizar nombre...",
                                text: "Ocurrio un error en hacer los cambios, vuelve a intentarlo",
                                icon: "error",
                                background: "#2e073f",  // Fondo personalizado                                        
                                color: "#ffffff",       // Texto en color blanco
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Aceptar"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = Modulo-Perfil.php?";
                                }
                            });
                        </script>');
                    }

                    $SQL = "UPDATE Registro_visita SET nombre_cliente = ? WHERE ID_usuario = ?";
                    $sentencia = $conexion->prepare($SQL);
                    $res = $sentencia->execute([$nuevo_nombre, $this->ID_usuario]);
                    if ($res) {
                        echo ('<script>
                                    Swal.fire({
                                        title: "Exito",
                                        text: "¡Los cambios se guardaron correctamente!",
                                        icon: "success",
                                        iconColor: "#00ff00",  // Icono verde para indicar éxito
                                        background: "#2e073f",  // Fondo personalizado                                        
                                        color: "#ffffff",       // Texto en color blanco
                                        confirmButtonColor: "#3085d6",
                                        confirmButtonText: "Aceptar"
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = "Modulo-Perfil.php?";                                            
                                        }
                                    });
                                </script>');
                    } else {
                        echo ('<script>
                            Swal.fire({
                                title: "Error al actualizar nombre...",
                                text: "Ocurrio un error en hacer los cambios, vuelve a intentarlo",
                                icon: "error",
                                background: "#2e073f",  // Fondo personalizado                                        
                                color: "#ffffff",       // Texto en color blanco
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Aceptar"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = Modulo-Perfil.php?";
                                }
                            });
                        </script>');
                    }

                    $SQL = "UPDATE Reservacion SET nombre_completo = ? WHERE ID_usuario = ?";
                    $sentencia = $conexion->prepare($SQL);
                    $res = $sentencia->execute([$nuevo_nombre, $this->ID_usuario]);
                    if ($res) {
                        echo ('<script>
                                    Swal.fire({
                                        title: "Exito",
                                        text: "¡Los cambios se guardaron correctamente!",
                                        icon: "success",
                                        iconColor: "#00ff00",  // Icono verde para indicar éxito
                                        background: "#2e073f",  // Fondo personalizado                                        
                                        color: "#ffffff",       // Texto en color blanco
                                        confirmButtonColor: "#3085d6",
                                        confirmButtonText: "Aceptar"
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = "Modulo-Perfil.php?";                                            
                                        }
                                    });
                                </script>');
                    } else {
                        echo ('<script>
                            Swal.fire({
                                title: "Error al actualizar nombre...",
                                text: "Ocurrio un error en hacer los cambios, vuelve a intentarlo",
                                icon: "error",
                                background: "#2e073f",  // Fondo personalizado                                        
                                color: "#ffffff",       // Texto en color blanco
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Aceptar"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = Modulo-Perfil.php?";
                                }
                            });
                        </script>');
                    }
                }
            } else {
                echo ('<script>
                            Swal.fire({
                                title: "Error encontrado",
                                text: "No se encontro al usuario en la base de datos.",
                                icon: "error",
                                background: "#2e073f",  // Fondo personalizado                                        
                                color: "#ffffff",       // Texto en color blanco
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Aceptar"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = AcercaDe.php?";
                                }
                            });
                        </script>');
            }
            $SQL = "SELECT correo FROM Usuario WHERE ID_usuario = ?";
            $sentencia = $conexion->prepare($SQL);
            $sentencia->execute([$this->ID_usuario]);
            if ($sentencia->rowCount() == 1) {
                $row = $sentencia->fetch(PDO::FETCH_ASSOC);
                $correo = $row['correo'];
                if ($correo != $nuevo_correo) {
                    $SQL = "UPDATE Usuario SET correo = ? WHERE ID_usuario = ?";
                    $sentencia = $conexion->prepare($SQL);
                    $res = $sentencia->execute([$nuevo_correo, $this->ID_usuario]);
                    if ($res) {
                        echo ('<script>
                                    Swal.fire({
                                        title: "Exito",
                                        text: "¡Los cambios se guardaron correctamente!",
                                        icon: "success",
                                        iconColor: "#00ff00",  // Icono verde para indicar éxito
                                        background: "#2e073f",  // Fondo personalizado                                        
                                        color: "#ffffff",       // Texto en color blanco
                                        confirmButtonColor: "#3085d6",
                                        confirmButtonText: "Aceptar"
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = "Modulo-Perfil.php?";                                            
                                        }
                                    });
                                </script>');
                    } else {
                        echo ('<script>
                            Swal.fire({
                                title: "Error al actualizar correo...",
                                text: "Ocurrio un error en hacer los cambios, vuelve a intentarlo",
                                icon: "error",
                                background: "#2e073f",  // Fondo personalizado                                        
                                color: "#ffffff",       // Texto en color blanco
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Aceptar"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = Modulo-Perfil.php?";
                                }
                            });
                        </script>');
                    }

                    $SQL = "UPDATE Reservacion SET correo = ? WHERE ID_usuario = ?";
                    $sentencia = $conexion->prepare($SQL);
                    $res = $sentencia->execute([$nuevo_correo, $this->ID_usuario]);
                    if ($res) {
                        echo ('<script>
                                    Swal.fire({
                                        title: "Exito",
                                        text: "¡Los cambios se guardaron correctamente!",
                                        icon: "success",
                                        iconColor: "#00ff00",  // Icono verde para indicar éxito
                                        background: "#2e073f",  // Fondo personalizado                                        
                                        color: "#ffffff",       // Texto en color blanco
                                        confirmButtonColor: "#3085d6",
                                        confirmButtonText: "Aceptar"
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = "Modulo-Perfil.php?";                                            
                                        }
                                    });
                                </script>');
                    } else {
                        echo ('<script>
                            Swal.fire({
                                title: "Error al actualizar correo...",
                                text: "Ocurrio un error en hacer los cambios, vuelve a intentarlo",
                                icon: "error",
                                background: "#2e073f",  // Fondo personalizado                                        
                                color: "#ffffff",       // Texto en color blanco
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Aceptar"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = Modulo-Perfil.php?";
                                }
                            });
                        </script>');
                    }
                }
            } else {
                echo ('<script>
                            Swal.fire({
                                title: "Error encontrado",
                                text: "No se encontro al usuario en la base de datos.",
                                icon: "error",
                                background: "#2e073f",  // Fondo personalizado                                        
                                color: "#ffffff",       // Texto en color blanco
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Aceptar"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = AcercaDe.php?";
                                }
                            });
                        </script>');
            }

            if ($this->telefono != $nuevo_telefono) {
                $SQL = "UPDATE Usuario SET telefono = ? WHERE ID_usuario = ?";
                $sentencia = $conexion->prepare($SQL);
                $res = $sentencia->execute([$nuevo_telefono, $this->ID_usuario]);
                if ($res) {
                    $_SESSION['telefono'] = $nuevo_telefono;
                    echo ('<script>
                                    Swal.fire({
                                        title: "Exito",
                                        text: "¡Los cambios se guardaron correctamente!",
                                        icon: "success",
                                        iconColor: "#00ff00",  // Icono verde para indicar éxito
                                        background: "#2e073f",  // Fondo personalizado                                        
                                        color: "#ffffff",       // Texto en color blanco
                                        confirmButtonColor: "#3085d6",
                                        confirmButtonText: "Aceptar"
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = "Modulo-Perfil.php?";                                            
                                        }
                                    });
                                </script>');
                } else {
                    echo ('<script>
                            Swal.fire({
                                title: "Error al actualizar telefono...",
                                text: "Ocurrio un error en hacer los cambios, vuelve a intentarlo",
                                icon: "error",
                                background: "#2e073f",  // Fondo personalizado                                        
                                color: "#ffffff",       // Texto en color blanco
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Aceptar"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = Modulo-Perfil.php?";
                                }
                            });
                        </script>');
                }

                $SQL = "UPDATE Reservacion SET telefono = ? WHERE ID_usuario = ?";
                $sentencia = $conexion->prepare($SQL);
                $res = $sentencia->execute([$this->ID_usuario]);
                if ($res) {
                    echo ('<script>
                                    Swal.fire({
                                        title: "Exito",
                                        text: "¡Los cambios se guardaron correctamente!",
                                        icon: "success",
                                        iconColor: "#00ff00",  // Icono verde para indicar éxito
                                        background: "#2e073f",  // Fondo personalizado                                        
                                        color: "#ffffff",       // Texto en color blanco
                                        confirmButtonColor: "#3085d6",
                                        confirmButtonText: "Aceptar"
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = "Modulo-Perfil.php?";                                            
                                        }
                                    });
                                </script>');
                } else {
                    echo ('<script>
                            Swal.fire({
                                title: "Error al actualizar telefono...",
                                text: "Ocurrio un error en hacer los cambios, vuelve a intentarlo",
                                icon: "error",
                                background: "#2e073f",  // Fondo personalizado                                        
                                color: "#ffffff",       // Texto en color blanco
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Aceptar"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = Modulo-Perfil.php?";
                                }
                            });
                        </script>');
                }
            }

        } catch (PDOException $e) {
            echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "Ha ocurrido un error fatal en la comunicación con la base de datos, regresando al inicio...",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-InicioSesion.php";
                        }
                    });
                </script>');
        } finally {
            $conexion = null;
        }
    }
    public function mostrarNombre()
    {
        try {
            $obj = new crearConexion();
            $conexion = $obj->getConexion();
            $SQL = "SELECT nombre_usuario FROM Usuario WHERE ID_usuario = ?";
            $sentencia = $conexion->prepare($SQL);
            $sentencia->execute([$this->ID_usuario]);
            if ($sentencia->rowCount() == 1) {
                $row = $sentencia->fetch(PDO::FETCH_ASSOC);
                $nombre = $row['nombre_usuario'];
                echo ('<strong>Nombre:</strong> <span id="nombreUsuario">' . $nombre . '</span>');
            } else {
                echo ('<script>
                            Swal.fire({
                                title: "Error encontrado",
                                text: "No se encontro el usuario en la base de datos.",
                                icon: "error",
                                background: "#2e073f",  // Fondo personalizado                                        
                                color: "#ffffff",       // Texto en color blanco
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Aceptar"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = AcercaDe.php?";
                                }
                            });
                        </script>');
            }
        } catch (PDOException $e) {
            echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "Ha ocurrido un error fatal en la comunicación con la base de datos, regresando al inicio...",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-InicioSesion.php";
                        }
                    });
                </script>');
        } finally {
            $conexion = null;
        }
    }
    public function mostrarCorreo()
    {
        try {
            $obj = new crearConexion();
            $pdo = $obj->getConexion();
            $SQL = "SELECT correo FROM Usuario WHERE ID_usuario = ?";
            $sentencia = $pdo->prepare($SQL);
            $sentencia->execute([$this->ID_usuario]);
            if ($sentencia->rowCount() == 1) {
                $row = $sentencia->fetch(PDO::FETCH_ASSOC);
                $correo = $row['correo'];
                echo ('<span id="correoUsuario">' . $correo . '</span>');
            } else {
                echo ('<script>
                            Swal.fire({
                                title: "Error encontrado",
                                text: "No se encontro el usuario en la base de datos.",
                                icon: "error",
                                background: "#2e073f",  // Fondo personalizado                                        
                                color: "#ffffff",       // Texto en color blanco
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Aceptar"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = AcercaDe.php?";
                                }
                            });
                        </script>');
            }
        } catch (PDOException $e) {
            echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "Ha ocurrido un error fatal en la comunicación con la base de datos, regresando al inicio...",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-InicioSesion.php";
                        }
                    });
                </script>');
        } finally {
            $pdo = null;
        }
    }

    public function mostrarTelefono()
    {
        echo ('<span id="telefonoUsuario">' . $this->telefono . '</span>');
    }

    public function mostrarPromocionActiva()
    {
        try {
            $obj = new crearConexion();
            $conexion = $obj->getConexion();
            $SQL = "SELECT promocion_activa FROM Usuario WHERE ID_usuario = ?";
            $sentencia = $conexion->prepare($SQL);
            $sentencia->execute([$this->ID_usuario]);
            if ($sentencia->rowCount() == 1) {
                $row = $sentencia->fetch(PDO::FETCH_ASSOC);
                $promocion = $row['promocion_activa'];
                if ($promocion == '') {
                    echo ('<span id="promocionActiva">Ninguna</span>');
                } else {
                    echo ('<span id="promocionActiva">' . $promocion . '</span>');
                }
            } else {
                echo ('<script>
                            Swal.fire({
                                title: "Error encontrado",
                                text: "No se encontro el usuario en la base de datos.",
                                icon: "error",
                                background: "#2e073f",  // Fondo personalizado                                        
                                color: "#ffffff",       // Texto en color blanco
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Aceptar"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = AcercaDe.php?";
                                }
                            });
                        </script>');
            }
        } catch (PDOException $e) {
            echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "Ha ocurrido un error fatal en la comunicación con la base de datos, regresando al inicio...",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-InicioSesion.php";
                        }
                    });
                </script>');
        } finally {
            $conexion = null;
        }
    }

    public function mostrarPuntos()
    {
        try {
            $obj = new crearConexion();
            $conexion = $obj->getConexion();
            $SQL = "SELECT puntos FROM Usuario WHERE ID_usuario = ?";
            $sentencia = $conexion->prepare($SQL);
            $sentencia->execute([$this->ID_usuario]);
            if ($sentencia->rowCount() == 1) {
                $row = $sentencia->fetch(PDO::FETCH_ASSOC);
                $puntos = $row['puntos'];

                echo ('<strong>Total de Puntos:</strong> <span id="puntosUsuario">' . $puntos . '</span>');
            } else {
                echo ('<script>
                            Swal.fire({
                                title: "Error encontrado",
                                text: "No se encontro el usuario en la base de datos.",
                                icon: "error",
                                background: "#2e073f",  // Fondo personalizado                                        
                                color: "#ffffff",       // Texto en color blanco
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Aceptar"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = AcercaDe.php?";
                                }
                            });
                        </script>');
            }
        } catch (PDOException $e) {
            echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "Ha ocurrido un error fatal en la comunicación con la base de datos, regresando al inicio...",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-InicioSesion.php";
                        }
                    });
                </script>');
        } finally {
            $conexion = null;
        }
    }

    public function mostrarNombreForm()
    {
        try {
            $obj = new crearConexion();
            $conexion = $obj->getConexion();
            $SQL = "SELECT nombre_usuario FROM Usuario WHERE ID_usuario = ?";
            $sentencia = $conexion->prepare($SQL);
            $sentencia->execute([$this->ID_usuario]);
            if ($sentencia->rowCount() == 1) {
                $row = $sentencia->fetch(PDO::FETCH_ASSOC);
                $nombre = $row['nombre_usuario'];
                echo ('<input type="text" class="form-control" oninput="limitarTexto(this)" id="editNombre" name="editNombre" value="' . $nombre . '" required/>');
            } else {
                echo ('<script>
                            Swal.fire({
                                title: "Error encontrado",
                                text: "No se encontro el usuario en la base de datos.",
                                icon: "error",
                                background: "#2e073f",  // Fondo personalizado                                        
                                color: "#ffffff",       // Texto en color blanco
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Aceptar"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = AcercaDe.php?";
                                }
                            });
                        </script>');
            }
        } catch (PDOException $e) {
            echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "Ha ocurrido un error fatal en la comunicación con la base de datos, regresando al inicio...",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-InicioSesion.php";
                        }
                    });
                </script>');
        } finally {
            $conexion = null;
        }
    }

    public function mostrarCorreoForm()
    {
        try {
            $obj = new crearConexion();
            $conexion = $obj->getConexion();
            $SQL = "SELECT correo FROM Usuario WHERE ID_usuario = ?";
            $sentencia = $conexion->prepare($SQL);
            $sentencia->execute([$this->ID_usuario]);
            if ($sentencia->rowCount() == 1) {
                $row = $sentencia->fetch(PDO::FETCH_ASSOC);
                $correo = $row['correo'];
                echo ('<input type="email" class="form-control" id="editCorreo" name="editCorreo" value="' . $correo . '" required/>');
            } else {
                echo ('<script>
                Swal.fire({
                    title: "Error encontrado",
                    text: "No se encontro el usuario en la base de datos.",
                    icon: "error",
                    background: "#2e073f",  // Fondo personalizado                                        
                    color: "#ffffff",       // Texto en color blanco
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Aceptar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = AcercaDe.php?";
                    }
                });
            </script>');
            }
        } catch (PDOException $e) {
            echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "Ha ocurrido un error fatal en la comunicación con la base de datos, regresando al inicio...",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-InicioSesion.php";
                        }
                    });
                </script>');
        } finally {
            $conexion = null;
        }
    }

    public function mostrarTelefonoForm()
    {
        echo ('<input type="number" class="form-control" min="0" id="editTelefono" name="editTelefono" value="' . $this->telefono . '" required/>');
    }

    private function buscarID_usuario()
    {
        try {
            $obj = new crearConexion();
            $conexion = $obj->getConexion();
            $SQL = "SELECT ID_usuario FROM Usuario WHERE telefono = ?";
            $sentencia = $conexion->prepare($SQL);
            $sentencia->execute([$this->telefono]);
            if ($sentencia->rowCount() == 1) {
                $row = $sentencia->fetch(PDO::FETCH_ASSOC);
                $this->ID_usuario = $row['ID_usuario'];
            } else {
                echo ('<script>
                            Swal.fire({
                                title: "Error encontrado",
                                text: "No se encontro el usuario en la base de datos.",
                                icon: "error",
                                background: "#2e073f",  // Fondo personalizado                                        
                                color: "#ffffff",       // Texto en color blanco
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Aceptar"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = AcercaDe.php?";
                                }
                            });
                        </script>');
            }
        } catch (PDOException $e) {
            echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "Ha ocurrido un error fatal en la comunicación con la base de datos, regresando al inicio...",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-InicioSesion.php";
                        }
                    });
                </script>');
        } finally {
            $conexion = null;
        }
    }
    public function menuNavegacion()
    {
        if (session_status() == PHP_SESSION_ACTIVE) {
            echo ('<a href="Interfaz_Grafica.php" class="btn boton-primario">Inicio</a>                        
                        <a href="AcercaDe.php" class="btn boton-primario">Cerrar Sesion</a>');
        } else {
            echo ('<a href="AcercaDe.php" class="btn boton-primario">Acerca De</a>
                        <a href="Modulo-InicioSesion.php" class="btn boton-primario">Iniciar Sesion</a>
                        <a href="Modulo-Registro.php" class="btn boton-primario">Registrarse</a>');
        }
    }
}
class moduloReservaciones
{
    private $telefono;
    private $ID_usuario;
    public function __construct($telefono)
    {
        $this->telefono = $telefono ?? null;
        $this->telefono = $telefono ?? '';
        $this->buscarID_usuario();
    }
    public function mostrarPaquetes()
    {
        try {
            $obj = new crearConexion();
            $conexion = $obj->getConexion();
            $SQL = "SELECT nombre_paquete, ID_paquete FROM Paquete";
            $sentencia = $conexion->prepare($SQL);
            $sentencia->execute();
            if ($sentencia->rowCount() > 0) {
                while ($row = $sentencia->fetch(PDO::FETCH_ASSOC)) {
                    echo ('<option value="' . $row['ID_paquete'] . '">' . $row['nombre_paquete'] . '</option>');
                    echo ($SQL);
                }
            }
        } catch (PDOException $e) {
            echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "Ha ocurrido un error fatal en la comunicación con la base de datos, regresando al inicio...",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-InicioSesion.php";
                        }
                    });
                </script>');
        } finally {
            $conexion = null;
        }
    }

    public function procesarReservacion($nombre, $correo, $telefono, $fecha, $hora, $paquete)
    {
        try {
            // Convertir la fecha ingresada en un objeto DateTime
            $fechaIngresada = new DateTime($fecha);
            $diaSemana = $fechaIngresada->format('N'); // Devuelve 1 (lunes) a 7 (domingo)
    
            // Convertir la hora ingresada a formato completo (HH:mm:ss)
            $horaIngresada = new DateTime($hora . ":00");
    
            // Establecer los horarios permitidos
            $horaInicioSemana = new DateTime("10:00:00");
            $horaFinSemana = new DateTime("20:30:00");
            $horaFinDomingo = new DateTime("18:00:00");
            $horaUltimaReserva = new DateTime("16:30:00"); // Última hora para reservar (4:30 PM)
    
            // Validar horario según el día de la semana
            $horaValida = false;
            if ($diaSemana >= 1 && $diaSemana <= 6) { // Lunes a sábado
                $horaValida = ($horaIngresada >= $horaInicioSemana && $horaIngresada <= $horaFinSemana && $horaIngresada <= $horaUltimaReserva);
            } elseif ($diaSemana == 7) { // Domingo
                $horaValida = ($horaIngresada >= $horaInicioSemana && $horaIngresada <= $horaFinDomingo && $horaIngresada <= $horaUltimaReserva);
            }
    
            // Si la hora no es válida, mostrar advertencia y salir del método
            if (!$horaValida) {
                echo ('<script>
                        Swal.fire({
                            title: "Hora no permitida",
                            text: "Las reservaciones solo están permitidas:\n - Lunes a sábado: 10:00 AM - 04:30 PM\n - Domingos: 10:00 AM - 12:00 PM\n\nEl último evento se puede reservar hasta las 4:30 PM.",
                            icon: "warning",
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "Aceptar"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "Modulo-Reservaciones.php";
                            }
                        });
                    </script>');
                return; // Salir del método si la hora no es válida
            }
    
            // Si la hora es válida, continuar con el proceso de la reservación
            $obj = new crearConexion();
            $conexion = $obj->getConexion();
    
            // Verificar que el horario ya no esté ocupado
            $SQL = "SELECT fecha_evento, hora_evento FROM Reservacion WHERE fecha_evento = ? AND hora_evento = ?";
            $sentencia = $conexion->prepare($SQL);
            $sentencia->execute([$fecha, $hora]);
    
            if ($sentencia->rowCount() >= 1) {
                echo ('<script>
                        Swal.fire({
                            title: "Horario no disponible",
                            text: "El horario y fecha que elegiste no está disponible para reservaciones, favor de intentar nuevamente.",
                            icon: "error",
                            background: "#2e073f",  // Fondo personalizado 
                            color: "#ffffff",       // Texto en color blanco
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "Aceptar"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "Modulo-Reservaciones.php";
                            }
                        });
                    </script>');
            } else {
                // Si hay disponibilidad, hacer la reservación
                $SQL = "INSERT INTO Reservacion (nombre_completo, correo, telefono, fecha_evento, hora_evento, ID_paquete, ID_usuario) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
                $sentencia = $conexion->prepare($SQL);
                $res = $sentencia->execute([$nombre, $correo, $telefono, $fecha, $hora, $paquete, $this->ID_usuario]);
    
                if ($res) {
                    echo ('<script>
                            Swal.fire({
                                title: "¡Reservación Éxitosa!",
                                text: "Haz hecho una reservación el día: ' . $fecha . ' a las ' . $hora . '",
                                icon: "success",
                                iconColor: "#00ff00",  // Icono verde para indicar éxito
                                background: "#2e073f",  // Fondo personalizado                                        
                                color: "#ffffff",       // Texto en color blanco
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Aceptar"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "Modulo-Reservaciones.php";                                            
                                }
                            });
                        </script>');
                } else {
                    echo ('<script>
                            Swal.fire({
                                title: "Ha ocurrido un error",
                                text: "Ocurrió un error al realizar tu reservación, favor de volver a intentarlo",
                                icon: "error",
                                background: "#2e073f",  // Fondo personalizado                                        
                                color: "#ffffff",       // Texto en color blanco
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Aceptar"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "Modulo-Reservaciones.php";
                                }
                            });
                        </script>');
                }
            }
    
        } catch (PDOException $e) {
            echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "Ha ocurrido un error fatal en la comunicación con la base de datos.",
                        icon: "error",
                        background: "#2e073f",  // Fondo personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-InicioSesion.php";
                        }
                    });
                </script>');
        } finally {
            $conexion = null;
        }
    }
    

    public function mostrarNombre()
    {
        try {
            $obj = new crearConexion();
            $conexion = $obj->getConexion();
            $SQL = "SELECT nombre_usuario FROM Usuario WHERE ID_usuario =?";
            $sentencia = $conexion->prepare($SQL);
            $sentencia->execute([$this->ID_usuario]);
            if ($sentencia->rowCount() == 1) {
                $row = $sentencia->fetch(PDO::FETCH_ASSOC);
                $nombre = $row['nombre_usuario'];
                echo ('<input type="text" class="form-control" id="nombre" name = "nombre" value = "' . $nombre . '" placeholder="Ingresa tu nombre completo"
                            required readonly />');
            } else {
                echo ('<script>
                    Swal.fire({
                        title: "Usuario no encontrado",
                        text: "Ocurrio un error fatal, regresando al inicio",
                        icon: "error",
                        background: "#2e073f",  // Fondo personalizado                                        
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "AcercaDe.php?";
                        }
                    });
                </script>');
            }
        } catch (PDOException $e) {
            echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "Ha ocurrido un error fatal en la comunicación con la base de datos, regresando al inicio...",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-InicioSesion.php";
                        }
                    });
                </script>');
        } finally {
            $conexion = null;
        }
    }

    public function mostrarCorreo()
    {
        try {
            $obj = new crearConexion();
            $conexion = $obj->getConexion();
            $SQL = "SELECT correo FROM Usuario WHERE ID_usuario =?";
            $sentencia = $conexion->prepare($SQL);
            $sentencia->execute([$this->ID_usuario]);
            if ($sentencia->rowCount() == 1) {
                $row = $sentencia->fetch(PDO::FETCH_ASSOC);
                $correo = $row['correo'];
                echo ('<input type="text" class="form-control" id="nombre" name = "correo" value = "' . $correo . '" placeholder="Ingresa tu nombre completo"
                            required readonly />');
            } else {
                echo ('<script>
                    Swal.fire({
                        title: "Usuario no encontrado",
                        text: "Ocurrio un error fatal, regresando al inicio",
                        icon: "error",
                        background: "#2e073f",  // Fondo personalizado                                        
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "AcercaDe.php?";
                        }
                    });
                </script>');
            }
        } catch (PDOException $e) {
            echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "Ha ocurrido un error fatal en la comunicación con la base de datos, regresando al inicio...",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-InicioSesion.php";
                        }
                    });
                </script>');
        } finally {
            $conexion = null;
        }
    }
    public function mostrarTelefono()
    {
        echo ('<input type="tel" class="form-control" id="telefono" name = "telefono" value= "' . $this->telefono . '" placeholder="Ingresa tu número de teléfono"
                            required readonly/>');
    }

    private function buscarID_usuario()
    {
        try {
            $obj = new crearConexion();
            $conexion = $obj->getConexion();
            $SQL = "SELECT ID_usuario FROM Usuario WHERE telefono = ?";
            $sentencia = $conexion->prepare($SQL);
            $sentencia->execute([$this->telefono]);
            if ($sentencia->rowCount() == 1) {
                $row = $sentencia->fetch(PDO::FETCH_ASSOC);
                $this->ID_usuario = $row['ID_usuario'];
            } else {
                echo ('<script>
                    Swal.fire({
                        title: "Usuario no encontrado",
                        text: "Ocurrio un error fatal, regresando al inicio",
                        icon: "error",
                        background: "#2e073f",  // Fondo personalizado                                        
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "AcercaDe.php?";
                        }
                    });
                </script>');
            }
        } catch (PDOException $e) {
            echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "Ha ocurrido un error fatal en la comunicación con la base de datos, regresando al inicio...",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-InicioSesion.php";
                        }
                    });
                </script>');
        } finally {
            $conexion = null;
        }
    }

    public function menuNavegacion()
    {
        if (session_status() == PHP_SESSION_ACTIVE) {
            echo ('<a href="Interfaz_Grafica.php" class="btn boton-primario">Inicio</a>                        
                        <a href="AcercaDe.php" class="btn boton-primario">Cerrar Sesion</a>');
        } else {
            echo ('<a href="AcercaDe.php" class="btn boton-primario">Acerca De</a>
                        <a href="Modulo-InicioSesion.php" class="btn boton-primario">Iniciar Sesion</a>
                        <a href="Modulo-Registro.php" class="btn boton-primario">Registrarse</a>');
        }
    }
}
class interfazGrafica
{
    private $telefono;
    private $ID_usuario;
    public function __construct($telefono)
    {
        $this->telefono = $telefono ?? null;
        $this->telefono = $telefono ?? '';
    }

    public function menuRoles()
    {
        try {
            $obj = new crearConexion();
            $conexion = $obj->getConexion();
            $SQL = "SELECT ID_usuario FROM Usuario WHERE telefono = ?";
            $sentencia = $conexion->prepare($SQL);
            $sentencia->execute([$this->telefono]);
            if ($sentencia->rowCount() == 1) {
                $row = $sentencia->fetch(PDO::FETCH_ASSOC);
                $this->ID_usuario = $row['ID_usuario'];
                $SQL = "SELECT rol FROM Usuario WHERE ID_usuario = ?";
                $sentencia = $conexion->prepare($SQL);
                $sentencia->execute([$this->ID_usuario]);
                if ($sentencia->rowCount() == 1) {
                    $row = $sentencia->fetch(PDO::FETCH_ASSOC);
                    $rol = $row['rol'];
                    if ($rol == "Cliente") {
                        echo ('<div class="col-md-3 col-6 mb-3">
                                <a href="Modulo-Reservaciones.php" class="btn boton-primario w-100 py-3">
                                    <i class="bi bi-calendar-event mb-2 d-block"></i>
                                    Reservar Evento
                                </a>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <a href="Modulo-Perfil.php" class="btn boton-secundario w-100 py-3">
                                    <i class="bi bi-person mb-2 d-block"></i>
                                    Mi Perfil
                                </a>
                            </div><div class="col-md-3 col-6 mb-3">
                                <a href="Modulo-Promociones.php" class="btn boton-secundario w-100 py-3">
                                    <i class="bi bi-tags mb-2 d-block"></i>
                                    Promociones y Descuentos
                                </a>
                            </div>');
                    } else {
                        echo ('                <div class="col-md-3 col-6 mb-3">
                                <a href="Modulo-Reservaciones.php" class="btn boton-primario w-100 py-3">
                                    <i class="bi bi-calendar-event mb-2 d-block"></i>
                                    Reservar Evento
                                </a>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <a href="Modulo-Perfil.php" class="btn boton-secundario w-100 py-3">
                                    <i class="bi bi-person mb-2 d-block"></i>
                                    Mi Perfil
                                </a>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <a href="Modulo-RegistroVisitas.php" class="btn boton-primario w-100 py-3">
                                    <i class="bi bi-clipboard-check mb-2 d-block"></i>
                                    Registro de Visitas
                                </a>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <a href="Modulo-Estadisticas.php" class="btn boton-secundario w-100 py-3">
                                    <i class="bi bi-bar-chart mb-2 d-block"></i>
                                    Estadísticas de Consumo
                                </a>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <a href="Modulo-GestionUsuarios.php" class="btn boton-primario w-100 py-3">
                                    <i class="bi bi-people mb-2 d-block"></i>
                                    Gestión de Usuarios
                                </a>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <a href="Modulo-Promociones.php" class="btn boton-secundario w-100 py-3">
                                    <i class="bi bi-tags mb-2 d-block"></i>
                                    Promociones y Descuentos
                                </a>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <a href="Modulo-ConsolaVideojuego.php" class="btn boton-secundario w-100 py-3">
                                    <i class="bi bi-tags mb-2 d-block"></i>
                                    Gestion de Consolas y Videojuegos
                                </a>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                    <a href="Modulo-VerReserva.php" class="btn boton-secundario w-100 py-3">
                        <i class="bi bi-bag-check-fill mb-2 d-block"></i>
                        Ver Reservaciones
                    </a>
                </div>
                            ');
                    }
                } else {
                    echo ('<script>
                        Swal.fire({
                            title: "Error encontrado",
                            text: "No se ha encontrado el usuario en la Base de Datos",
                            icon: "error",
                            background: "#2e073f",  // Fondo personalizado                                        
                            color: "#ffffff",       // Texto en color blanco
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "Aceptar"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "AcercaDe.php";
                            }
                        });
                    </script>');
                }
            } else {
                echo ('<script>
                        Swal.fire({
                            title: "Error encontrado",
                            text: "No se ha encontrado el usuario en la Base de Datos",
                            icon: "error",
                            background: "#2e073f",  // Fondo personalizado                                        
                            color: "#ffffff",       // Texto en color blanco
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "Aceptar"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "AcercaDe.php";
                            }
                        });
                    </script>');
            }
        } catch (PDOException $e) {
            echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "Ha ocurrido un error fatal en la comunicación con la base de datos, regresando al inicio...",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-InicioSesion.php";
                        }
                    });
                </script>');
        } finally {
            $conexion = null;
        }
    }

    public function menuNavegacion()
    {
        if (session_status() == PHP_SESSION_ACTIVE) {
            echo ('<a href="Interfaz_Grafica.php" class="btn boton-primario">Inicio</a>                        
                        <a href="AcercaDe.php" class="btn boton-primario">Cerrar Sesion</a>');
        } else {
            echo ('<a href="AcercaDe.php" class="btn boton-primario">Acerca De</a>
                        <a href="Modulo-InicioSesion.php" class="btn boton-primario">Iniciar Sesion</a>
                        <a href="Modulo-Registro.php" class="btn boton-primario">Registrarse</a>');
        }
    }
}
class inicioSesion
{
    private $telefono;
    private $contrasena;
    public function __construct($telefono, $contrasena)
    {
        $this->telefono = $telefono ?? null;
        $this->contrasena = $contrasena ?? null;

        $this->telefono = $telefono ?? '';
        $this->contrasena = $contrasena ?? '';
        $this->iniciarSesion();
    }

    public function iniciarSesion()
    {
        try {
            $obj = new crearConexion();
            $conexion = $obj->getConexion();
            $SQL = "SELECT * FROM Usuario WHERE telefono = ?";
            $sentencia = $conexion->prepare($SQL);
            $sentencia->execute([$this->telefono]);
            if ($sentencia->rowCount() == 1) {
                $row = $sentencia->fetch(PDO::FETCH_ASSOC);
                if ($this->contrasena == $row['contraseña']) {
                    $_SESSION['telefono'] = $this->telefono;
                    header("Location: Interfaz_Grafica.php?tel={$this->telefono}");
                } else {
                    echo ('<script>
                    Swal.fire({
                        title: "Contraseña incorrecta",
                        text: "Favor de verificar su contraseña e intentelo nuevamente.",
                        icon: "error",
                        background: "#2e073f",  // Fondo personalizado                                        
                        color: "#ffffff",       // Texto en color blanco                                                                      
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {
                        if (result.isConfirmed) {                        
                            window.location.href = "Modulo-InicioSesion.php";                            
                        }
                    });
                </script>');
                }
            } else {
                echo ('<script>
                    Swal.fire({
                        title: "Usuario no encontrado",
                        text: "Las credenciales ingresadas no coinciden con ningun usuario, verifique sus credenciales y vuelva a internarlo.",
                        icon: "error",
                        background: "#2e073f",  // Fondo personalizado                                        
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {
                        if (result.isConfirmed) {                        
                            window.location.href = "Modulo-InicioSesion.php";                            
                        }
                    });
                </script>');
            }
        } catch (PDOException $e) {
            echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "Ha ocurrido un error fatal en la comunicación con la base de datos, regresando al inicio...",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-InicioSesion.php";
                        }
                    });
                </script>');
        } finally {
            $conexion = null;
        }
    }
}
class moduloRegistro
{
    private $nombre;
    private $telefono;
    private $correo;

    private $contrasena;
    private $confirmar_contrasena;
    public function __construct($nombre, $telefono, $correo, $contrasena, $confirmar_contrasena)
    {
        $this->nombre = $nombre ?? null;
        $this->telefono = $telefono ?? null;
        $this->correo = $correo ?? null;
        $this->contrasena = $contrasena ?? null;
        $this->confirmar_contrasena = $confirmar_contrasena ?? null;

        $this->nombre = $nombre ?? '';
        $this->telefono = $telefono ?? '';
        $this->correo = $correo ?? '';
        $this->contrasena = $contrasena ?? '';
        $this->confirmar_contrasena ?? '';
        $this->registrarUsuarios();
    }

    private function registrarUsuarios()
    {
        try {
            $obj = new crearConexion();
            $conexion = $obj->getConexion();
            $SQL = "SELECT nombre_usuario FROM Usuario";
            $sentencia = $conexion->prepare($SQL);
            $sentencia->execute();
            if ($sentencia->rowCount() == 0) {
                $SQL = "SELECT telefono FROM Usuario WHERE telefono=?";
                $sentencia = $conexion->prepare($SQL);
                $sentencia->execute([$this->telefono]);
                if ($sentencia->rowCount() >= 1) {
                    echo ('<script>
                    Swal.fire({
                        title: "Teléfono ya registrado",
                        text: "El teléfono ' . $this->telefono . ' ya se encuentra registrado, intente nuevamente con otro teléfono.",
                        icon: "error",
                        background: "#2e073f",  // Fondo personalizado                                        
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",                        
                        confirmButtonText: "Aceptar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-Registro.php";
                        }
                    });
                    </script>');
                } else {
                    $SQL = "SELECT correo FROM Usuario WHERE correo = ?";
                    $sentencia = $conexion->prepare($SQL);
                    $sentencia->execute([$this->correo]);
                    if ($sentencia->rowCount() >= 1) {
                        echo ('<script>
                    Swal.fire({
                        title: "Correo ya registrado",
                        text: "El correo ' . $this->correo . ' ya se encuentra registrado, intente nuevamente con otro correo.",
                        icon: "error",
                        background: "#2e073f",  // Fondo personalizado                                        
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {
                        if (result.isConfirmed) {                        
                            window.location.href = "Modulo-Registro.php";                            
                        }
                    });
                </script>');
                    } else {
                        $SQL = "SELECT nombre_usuario FROM Usuario WHERE nombre_usuario = ?";
                        $sentencia = $conexion->prepare($SQL);
                        $sentencia->execute([$this->nombre]);
                        if ($sentencia->rowCount() >= 1) {
                            echo ('<script>
                                Swal.fire({
                                    title: "Nombre ya registrado",
                                    text: "El nombre ' . $this->nombre . ' ya se encuentra registrado, intente nuevamente con otro nombre.",
                                    icon: "error",
                                    background: "#2e073f",  // Fondo personalizado                                        
                                     color: "#ffffff",       // Texto en color blanco
                                    confirmButtonColor: "#3085d6",
                                    confirmButtonText: "Aceptar"
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "Modulo-Registro.php";
                                    }
                                });
                            </script>');
                        } else {
                            if ($this->contrasena == $this->confirmar_contrasena) {
                                $SQL = "INSERT INTO Usuario (nombre_usuario, telefono, contraseña, correo, rol, puntos, promocion_activa)values (?, ?, ?, ?, ?, ?, ?)";
                                $sentencia = $conexion->prepare($SQL);
                                $rol = 'Administrador';
                                $puntos = 0;
                                $promocion_activa = '';
                                $resultado = $sentencia->execute([$this->nombre, $this->telefono, $this->confirmar_contrasena, $this->correo, $rol, $puntos, $promocion_activa]);
                                if ($resultado) {
                                    echo ('<script>
                                    Swal.fire({
                                        title: "¡Registro Exitoso!",
                                        text: "' . $this->nombre . ' te has registrado en nuestro sistema, guarda tus credenciales en un lugar seguro.",
                                        icon: "success",
                                        iconColor: "#00ff00",  // Icono verde para indicar éxito
                                        background: "#2e073f",  // Fondo personalizado                                        
                                        color: "#ffffff",       // Texto en color blanco
                                        confirmButtonColor: "#3085d6",
                                        confirmButtonText: "Aceptar"
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = "Modulo-InicioSesion.php?";                                            
                                        }
                                    });
                                </script>');
                                } else {
                                    echo ('<script>
                            Swal.fire({
                                title: "¡Ha ocurrido un error!",
                                text: "Error encontrado al registrarte, intentalo de nuevo",
                                icon: "error",
                                background: "#2e073f",  // Fondo personalizado                                        
                                color: "#ffffff",       // Texto en color blanco
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Aceptar"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "Modulo-Registro.php";
                                }
                            });
                        </script>');
                                }
                            } else {
                                #contras no coinciden
                                echo ('<script>
                        Swal.fire({
                            title: "Las contraseñas no coinciden",
                            text: "Verifica las constraseñas y vuelve a intentar",
                            icon: "error",
                            background: "#2e073f",  // Fondo personalizado                                        
                            color: "#ffffff",       // Texto en color blanco
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "Aceptar"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "Modulo-Registro.php";
                            }
                        });
                    </script>');
                            }
                        }

                    }
                }
            } else {
                $SQL = "SELECT telefono FROM Usuario WHERE telefono=?";
                $sentencia = $conexion->prepare($SQL);
                $sentencia->execute([$this->telefono]);
                if ($sentencia->rowCount() >= 1) {
                    echo ('<script>
                    Swal.fire({
                        title: "Teléfono ya registrado",
                        text: "El teléfono ' . $this->telefono . ' ya se encuentra registrado, intente nuevamente con otro teléfono.",
                        icon: "error",
                        background: "#2e073f",  // Fondo personalizado                                        
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",                        
                        confirmButtonText: "Aceptar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-Registro.php";
                        }
                    });
                </script>');
                } else {
                    $SQL = "SELECT correo FROM Usuario WHERE correo = ?";
                    $sentencia = $conexion->prepare($SQL);
                    $sentencia->execute([$this->correo]);
                    if ($sentencia->rowCount() >= 1) {
                        echo ('<script>
                    Swal.fire({
                        title: "Correo ya registrado",
                        text: "El correo ' . $this->correo . ' ya se encuentra registrado, intente nuevamente con otro correo.",
                        icon: "error",
                        background: "#2e073f",  // Fondo personalizado                                        
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-Registro.php";
                        }
                    });
                </script>');
                    } else {
                        $SQL = "SELECT nombre_usuario FROM Usuario WHERE nombre_usuario = ?";
                        $sentencia = $conexion->prepare($SQL);
                        $sentencia->execute([$this->nombre]);
                        if ($sentencia->rowCount() >= 1) {
                            echo ('<script>
                        Swal.fire({
                            title: "Nombre ya registrado",
                            text: "El nombre ' . $this->nombre . ' ya se encuentra registrado, intente nuevamente con otro nombre.",
                            icon: "error",
                            background: "#2e073f",  // Fondo personalizado                                        
                            color: "#ffffff",       // Texto en color blanco
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "Aceptar"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "Modulo-Registro.php";
                            }
                        });
                    </script>');
                        } else {
                            if ($this->contrasena == $this->confirmar_contrasena) {
                                $SQL = "INSERT INTO Usuario (nombre_usuario, telefono, contraseña, correo, rol, puntos, promocion_activa)values (?, ?, ?, ?, ?, ?, ?)";
                                $sentencia = $conexion->prepare($SQL);
                                $rol = 'Cliente';
                                $puntos = 0;
                                $promocion_activa = '';
                                $resultado = $sentencia->execute([$this->nombre, $this->telefono, $this->confirmar_contrasena, $this->correo, $rol, $puntos, $promocion_activa]);
                                if ($resultado) {
                                    echo ('<script>
                                    Swal.fire({
                                        title: "¡Registro Exitoso!",
                                        text: "' . $this->nombre . ' te has registrado en nuestro sistema, guarda tus credenciales en un lugar seguro.",
                                        icon: "success",
                                        iconColor: "#00ff00",  // Icono verde para indicar éxito
                                        background: "#2e073f",  // Fondo personalizado                                        
                                        color: "#ffffff",       // Texto en color blanco
                                        confirmButtonColor: "#3085d6",
                                        confirmButtonText: "Aceptar"
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = "Modulo-InicioSesion.php?";                                            
                                        }
                                    });
                                </script>');
                                } else {
                                    echo ('<script>
                                    Swal.fire({
                                        title: "¡Ha ocurrido un error!",
                                        text: "Error encontrado al registrarte, intentalo de nuevo",
                                        icon: "error",
                                        background: "#2e073f",  // Fondo personalizado                                        
                                        color: "#ffffff",       // Texto en color blanco
                                        confirmButtonColor: "#3085d6",
                                        confirmButtonText: "Aceptar"
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = "Modulo-Registro.php";
                                        }
                                    });
                                </script>');
                                }
                            } else {
                                echo ('<script>
                        Swal.fire({
                            title: "Las contraseñas no coinciden",
                            text: "Verifica las constraseñas y vuelve a intentar",
                            icon: "error",
                            background: "#2e073f",  // Fondo personalizado                                        
                            color: "#ffffff",       // Texto en color blanco
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "Aceptar"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "Modulo-Registro.php";
                            }
                        });
                    </script>');
                            }
                        }
                    }
                }

            }
        } catch (PDOException $e) {
            echo ('<script>
                    Swal.fire({
                        title: "Error encontrado",
                        text: "Ha ocurrido un error fatal en la comunicación con la base de datos, regresando al inicio...",
                        icon: "error",
                        background: "#2e073f",  // Fon1do personalizado 
                        color: "#ffffff",       // Texto en color blanco
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {           
                        if (result.isConfirmed) {
                            window.location.href = "Modulo-InicioSesion.php";
                        }
                    });
                </script>');
        } finally {
            $conexion = null;
        }
    }
}
class crearConexion
{
    private $host = 'localhost';
    private $dbname = 'laBliblioteka';
    private $username = 'root';
    private $password = '';
    private $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8", $this->username, $this->password);
            // Configurar PDO para manejar errores como excepciones
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    public function getConexion()
    {
        return $this->pdo;
    }
}
?>