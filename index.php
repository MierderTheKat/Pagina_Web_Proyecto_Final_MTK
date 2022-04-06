<!DOCTYPE html>
<html lang="en">

<?php
    include "conexion.php";
    session_start();
    session_destroy();
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Graduación</title>
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
                <button class="btn btn-sm btnlogo"><a href="index.php"><img class="img-edits" src="img/Logo.png"></a></button>
                
                <div class="d-flex margen">

                    <div class="container">
                        <!-- Button Login-->
                        <button type="button" class="btn btn-lg boton_fuerte" data-bs-toggle="modal" data-bs-target="#MyModal-Login">
                        <i class="fas fa-user"></i> Login</button>
                        
                        <!-- Modal -->
                        <div class="modal fade" id="MyModal-Login" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Login</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                        
                                    <form class="needs-validation" novalidate>
                                        <div class="modal-body">

                                            <div class="mb-3">
                                                <label for="validationCorreo" class="form-label">Correo</label>
                                                <input type="text" name="correo"  class="form-control" aria-describedby="helpId" id="validationCorreo" required>
                                                <small id="helpId" class="text-muted">Escribe tu correo</small>
                                                <div class="invalid-feedback">
                                                    Porfavor escribe tu correo.
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="validationContrasena" class="form-label">Contraseña</label>
                                                <input type="password" name="contrasena" class="form-control" aria-describedby="helpId" id="validationContrasena" required>
                                                <small id="helpId" class="text-muted">Escribe tu contraseña</small>
                                                <div class="invalid-feedback">
                                                    Porfavor escribe tu contraseña.
                                                </div>
                                            </div>

                                            <p class="text-danger" id="feedback"></p>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Regresar</button>
                                            <button class="btn btn-primary" id="btnIngresar" name="btnIngresar" value="login" type="submit">Ingresar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Button Registro-->
                        <button type="button" class="btn btn-lg boton_fuerte" data-bs-toggle="modal" data-bs-target="#MyModalRegistro">
                        <i class="fas fa-user-plus"></i> Regístrate</button>
                        
                        <!-- Modal -->
                        <div class="modal fade" id="MyModalRegistro" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Registrar Usuario</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="procesar_datos.php" id="limpiarRegistro" method="POST" class="needs-validation" novalidate>
                                        <div class="modal-body">
                                            
                                            <label for="R_validationNombre" class="form-label">*Nombre</label>
                                            <input type="text" name="R_nombre" class="form-control" id="R_validationNombre" required>

                                            <label for="R_validationApellidos_P" class="form-label">*Apellido Paterno</label>
                                            <input type="text" name="R_apellidos_P" class="form-control" id="R_validationApellidos_P" required>
                                            
                                            <label for="" class="form-label">Apellido Materno</label>
                                            <input type="text" name="R_apellidos_M" class="form-control" id="R_validationApellidos_M">
                                            
                                            <label for="R_validationContrasena" class="form-label">*Contraseña</label>
                                            <input type="password" name="R_contrasena" class="form-control" id="R_validationContrasena" required>
                                            
                                            <label for="R_validationCorreo" class="form-label">*Correo Eletronico</label>
                                            <input type="email" name="R_correo" class="form-control" id="R_validationCorreo" required>
                                            
                                            <label for="R_validationEdad" class="form-label">*Edad</label>
                                            <input type="number" name="R_edad" class="form-control" id="R_validationEdad" required>

                                            <p class="text-danger" id="feedback_R1"></p>
                                            <p class="text-success" id="feedback_R2"></p>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Regresar</button>
                                            <button class="btn btn-success" id="btnRegistro" name="btnRegistro" value="registro" type="submit">Registrarte</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </nav>

        <div class="container">
            <div id="carouselId" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselId" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselId" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselId" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="img/Carrousel_1.png" class="d-block w-100" alt="First slide">
                    </div>
                    <div class="carousel-item">
                        <img src="img/Carrousel_2.png" class="d-block w-100" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <img src="img/Carrousel_3.png" class="d-block w-100" alt="Third slide">
                    </div>
                </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Anterior</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Siguiente</span>
                    </button>
                </div>
            </div>
        </div>
        
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
                
                <div class="p-3"></div>

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
            
            <h2 class="titulo"></h2>
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
    $("#btnIngresar").on("click",function(evento){

        (function () {
        'use strict'

        var forms = document.querySelectorAll('.needs-validation')

        Array.prototype.slice.call(forms)
            .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
                }
                event.preventDefault()
                form.classList.add('was-validated')
            }, false)
            })
        })()

        var vCorreo = $("#validationCorreo").val();
        var vContrasena = $("#validationContrasena").val();
        var vAccion = "Ingresar";
        console.log(vCorreo, vContrasena, vAccion);

        $.ajax({
            url:"procesar_datos.php",
            method:"POST",
            dataType: "json",
            data:{
                correo: vCorreo,
                contrasena: vContrasena,
                accion: vAccion
            }
        }).done(function(datos){
            var json = JSON.parse(datos);
            
            if(json.clave == 0){
                $("#feedback").text(json.texto);
            }
            else if (json.clave == 1){
                $("#feedback").text("");
                document.location.href = "Menu.php";
            }
            console.log(json);
        });

    });

    $("#btnRegistro").on("click",function(evento){
        
        (function () {
        'use strict'

        var forms = document.querySelectorAll('.needs-validation')

        Array.prototype.slice.call(forms)
            .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
                }
                event.preventDefault()
                form.classList.add('was-validated')
            }, false)
            })
        })()

        var vNombre = $("#R_validationNombre").val();
        var vApellido_P = $("#R_validationApellidos_P").val();
        var vApellido_M = $("#R_validationApellidos_M").val();
        var vContrasena = $("#R_validationContrasena").val();
        var vCorreo = $("#R_validationCorreo").val();
        var vEdad = $("#R_validationEdad").val();
        var vAccion = "Registrar";

        console.log(vNombre, vApellido_P, vApellido_M, vContrasena, vCorreo, vEdad, vAccion);

        $.ajax({
            url:"procesar_datos.php",
            method:"POST",
            dataType: "json",
            data:{
                nombre: vNombre,
                apellido_paterno: vApellido_P,
                apellido_materno: vApellido_M,
                contrasena: vContrasena,
                correo: vCorreo,
                edad: vEdad,
                accion: vAccion
            }
        }).done(function(datos){
            var json = JSON.parse(datos);
            
            if(json.clave == 0){
                $("#feedback_R1").text(json.texto);
                $("#feedback_R2").text("");
            }
            else if (json.clave == 1){
                $("#feedback_R2").text(json.texto);
                $("#feedback_R1").text("");

                var $element = $("button");
                $element.prop('disabled', true);
                $element.attr('disabled', true);
                setTimeout(BorrarForms, 1500);

                function BorrarForms(){
                    console.log("Ha pasado 1 segundo");
                    $element.prop('disabled', false);
                    $element.attr('disabled', false);
                    document.getElementById("limpiarRegistro").reset();
                };
            }
            console.log(json);
        });

    });
</script>

</body>
</html>