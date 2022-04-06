<!DOCTYPE html>
<html lang="en">

<?php
    include "conexion.php";
    session_start();
    if(!isset($_SESSION["autenticado"])){
        header ('Location:index.php');
        exit;
    }
    else{
    
    $ID_Usuario = $_SESSION["autenticado"];

    $stmt = $mysqli->prepare("UPDATE usuarios SET asientos_agregar = 0 WHERE ID_usuario = ?");
    $stmt->bind_param("i",$ID_Usuario);
    $stmt->execute();
    $stmt->close();


    $stmt = $mysqli->prepare("SELECT nombre, apellido_paterno, apellido_materno, correo, asientos_reservados, asientos_agregar, creditos FROM usuarios WHERE ID_usuario=?");
    $stmt->bind_param("i",$ID_Usuario);

    $stmt->execute();
    $stmt->bind_result($nombre, $apellido_P, $apellido_M, $correo, $asientos_reservados, $asientos_agregar, $creditos);
    $stmt->fetch();
    $stmt->close();

    }
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zona Premium Gradución</title>
    <link rel="stylesheet" href="css/ediciones.css?1.0" media="all">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/jquery-3.6.0.js"></script>
</head>

<body class="back_color_1">
    
    <div class="container">

        <nav class="navbar navbar-light fondonav">
            <div class="container-fluid">

            <button class="btn btn-sm btnlogo"><a href="Menu.php"><img class="img-edits" src="img/Logo.png"></a></button>

                <div class="dropdown espacio">
                    <button class="btn btn-lg boton_fuerte dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-chair"></i> Asientos reservados: <strong><?php echo $asientos_reservados; ?></strong>
                    </button>
                    <ul class="dropdown-menu  text-center" aria-labelledby="">
                        <form action="agregar_asientos.php" method="POST">
                            <div class="modal-body">

                                <div class="mb-3">
                                    <label class="form-label">Asientos a reservar:</label>
                                    <input type="number" name="Asientos" id="Asientos" class="form-control" aria-describedby="helpId">
                                </div>

                                <button class="btn btn-success" id="btnReservar" name="btnReservar" type="submit">Ir a reservar</button>
                            </div>
                        </form>

                        <li><a class="btn btn-sm btn-warning" href="Asientos_PU.php">Ver asientos reservados</a></li>
                    </ul>
                </div>
                
                <div class="d-flex margen">

                    <div class="container d-flex">

                        <div class="dropdown espacio">
                        <button class="btn btn-lg boton_fuerte dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fab fa-bitcoin"></i>
                        <?php echo $creditos; ?></button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="Obtener_creditos.php">Obtener creditos</a></li>
                        </ul>
                        </div>

                        <div class="dropdown espacio">
                        <button class="btn btn-lg boton_fuerte dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item"><?php echo $nombre; ?></a></li>
                            <li><a class="dropdown-item" href="Editar_info.php"><i class="fas fa-edit"></i> Editar perfil</a></li>
                            <li><a class="btn dropdown-item btn-danger" href="index.php" role="button"><i class="fas fa-power-off"></i> <strong>Cerrar Sesión</strong></a></li>
                        </ul>
                        </div>


                    </div>
                </div>
        </nav>

        <div class="p-3 ">
            <div class="container text-center">
                <h1 class="display-1">Bienvenido(a) <?php echo $nombre; ?></h1>
                <p class="display-4">Esta es la zona para usuarios registrados</p>
                <p class="display-6">Puedes reservar tus asientos y ver tu lista</p>
                <h2>¡Explora todas las opciones!</h2>

            </div>
        </div>
        
        <div class="p-3"></div>
        
        <div class="back_color_2">

            <div class="container">
                <h2 class="titulo text-center">Informacion relevante</h2>
                <div class="row">
                    <div class="col-sm-4">
                        <h5 class="card-title text-center subtitulo"><strong>¿Dónde sera el evento?</strong></h5>
                        <div class="card colorpreguntas">
                            <div class="card-body">
                                <p class="card-text text-center"> Se realizará dentro de la institución<br><br>
                                Universidad Politécnica de Durango <br> Carretera Durango-México Km. 9.5</p><br>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <h5 class="card-title text-center subtitulo"><strong>¿Cuándo sera el evento?</strong></h5>
                        <div class="card colorpreguntas">
                            <div class="card-body">
                                <p class="card-text text-center">Se realizará el 06 de diciembre del 2021 <br> <br> <br> <br></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <h5 class="card-title text-center subtitulo "><strong>¿Cómo puedo contactar?</strong></h5>
                        <div class="card colorpreguntas">
                            <div class="card-body">
                                <p class="card-text text-center">Puedes llamarnos al <strong>618 456 4260</strong> <br><br>
                                O escribenos a cualquiera de nuestras redes sociales, que se encuentran en la parte inferior</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <h2 class="titulo text-center">Membresias</h2>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="accordion-item" id="accordionMembresia">
                            <h2 class="accordion-header" id="headingMembOne">
                                <button class="accordion-button collapsed colorbronze botones" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMembOne" aria-expanded="false" aria-controls="collapseMembOne">
                                <strong class="membresias">BRONZE</strong></button>
                            </h2>
                            <div id="collapseMembOne" class="accordion-collapse collapse colorbronze" aria-labelledby="headingMembOne" data-bs-parent="#accordionMembresia">
                                <div class="accordion-body text-center">
                                    <strong text-center>COSTO -> 1,000 creditos</strong><br><br>
                                
                                    - Podras acceder al evento<br>
                                    <strong>- Es la membresia más barata.</strong><br>
                                    - Te asignaran un asiento con prioridad <strong>inferior</strong>.<br>
                                    - Se te dara un vaso con agua.<br>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingMembTwo">
                                <button class="accordion-button collapsed colorsilver botones" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMembTwo" aria-expanded="false" aria-controls="collapseMembTwo">
                                <strong class="membresias">SILVER</strong></button>
                            </h2>
                            <div id="collapseMembTwo" class="accordion-collapse collapse colorsilver" aria-labelledby="headingMembTwo" data-bs-parent="#accordionMembresia">
                                <div class="accordion-body text-center">
                                    <strong text-center>COSTO -> 2,000 creditos</strong><br><br>
                                    
                                    - Podras acceder al evento<br>
                                    <strong>- Es la membresia más equilibrada.</strong><br>
                                    - Te asignaran un asiento con prioridad <strong>media</strong>.<br>
                                    - Se te daran un vaso con agua fresca.<br>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingMembThree">
                                <button class="accordion-button collapsed colorgold botones" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMembThree" aria-expanded="false" aria-controls="collapseMembThree">
                                <strong class="membresias">GOLD</strong></button>
                            </h2>
                            <div id="collapseMembThree" class="accordion-collapse collapse colorgold" aria-labelledby="headingMembThree" data-bs-parent="#accordionMembresia">
                                <div class="accordion-body text-center">
                                    <strong text-center>COSTO -> 10,000 creditos</strong><br><br>
                                    
                                    - Podras acceder al evento<br>
                                    <strong>- Es la membresia premium.</strong><br>
                                    - Te asignaran un asiento con prioridad <strong>alta</strong>.<br>
                                    - Se te dara una copa con vino.<br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-3 "></div>

                <div class="row">
                    <div class="col-sm-4">
                        <h5 class="card-title text-center subtitulo">¿Que són las membresias?</h5>
                        <div class="card colorbronze">
                            <div class="card-body">
                                <p class="card-text text-center">
                                    Es una manera de representar el estatus en el evento de graduación.<br><br>
                                    Con ella podras acceder a varios beneficios distintos.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <h5 class="card-title text-center subtitulo">¿Como puedo obtener una?</h5>
                        <div class="card colorsilver">
                            <div class="card-body">
                                <p class="card-text text-center">
                                    Tienes que registrarte en la plataforma y reservar un asiento.<br><br>
                                    <strong> - a cada asiento se le asigna una membresia.</strong><br>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <h5 class="card-title text-center subtitulo">¿Comó puedo pagarla?</h5>
                        <div class="card colorgold">
                            <div class="card-body">
                                <p class="card-text text-center">
                                    Se te regalaran una cantidad de creditos con lo que puedes reservar asientos. <br><br>
                                    Si estos creditos se terminan, puedes obtener más utilizando tu tarjeta.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="p-4"></div>
        </div>

        <footer class="container">
            <div class="d-flex">
                <section class="footer_text">
                    <p class="F_text">El contenido de esta página web se plantea de manera incluyente y libre de estereotipos de género por lo que al referirse a una persona como él “podrá ser él o ella”.</p>
                </section>
                <section>
                    <a href="http://intranet.unipolidgo.edu.mx" target="_blank" class="foot_links">INTRANET</a>
                    <a href="http://www.unipolidgo.edu.mx/sitio/archivos/Aviso_de_Privacidad_Integral_Alumnos.pdf" target="_blank" class="foot_links">AVISO DE PRIVACIDAD INTEGRAL</a>
                    <a href="http://www.unipolidgo.edu.mx/sitio/archivos/Aviso_de_Privacidad_Simplificado_Alumnos.pdf" target="_blank" class="foot_links">AVISO DE PRIVACIDAD SIMPLIFICADO</a>
                </section>
                <section>
                    <a href="https://www.facebook.com/unipolidgo" target="_blank"><img class="img-edits_links" src="img/Logo_FB.png"></a>
                    <a href="https://twitter.com/unipolidgo" target="_blank"><img class="img-edits_links" src="img/Logo_TW.jpg"></a>
                    <a href="https://www.instagram.com/unipolidgo/" target="_blank"><img class="img-edits_links" src="img/Logo_IT.png"></a>
                    <a href="https://www.youtube.com/channel/UCXW2k_bWEVDaBEAvL8dl_fw" target="_blank"><img class="img-edits_links" src="img/Logo_YT.png"></a>
                    <a href="https://mail.google.com/a/unipolidgo.edu.mx" target="_blank"><img class="img-edits_links" src="img/Logo_CR.png"></a>
                </section>
            </div>
            <p class="copyright">© 2021 Universidad Politécnica de Durango — Carretera Durango-México Km. 9.5 C.P. 34300 — Teléfono 4564260</p>
        </footer>
    </div>

    <script>
    $("#btnReservar").on("click",function(evento){

        var vAsientos = $("#Asientos").val();
        if(vAsientos < 1){
            event.preventDefault();
        }
    });
</script>

</body>
</html>