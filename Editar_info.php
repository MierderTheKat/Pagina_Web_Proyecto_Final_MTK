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

    $stmt = $mysqli->prepare("SELECT nombre, apellido_paterno, apellido_materno, contrasena, correo, edad, asientos_reservados, creditos FROM usuarios WHERE ID_usuario=?");
    $stmt->bind_param("i",$ID_Usuario);

    $stmt->execute();
    $stmt->bind_result($nombre, $apellido_P, $apellido_M, $contrasena, $correo, $edad, $asientos_reservados, $creditos);
    $stmt->fetch();
    $stmt->close();
    }
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
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

        <div class="p-5 back_color_2">
            <form class="needs-validation" method="POST" novalidate>
                    
                <div class="ajustar_form">
                    <label for="E_validationNombre" class="form-label">*Nombre</label>
                    <input type="text" name="R_nombre" class="form-control" value="<?php echo $nombre; ?>" id="E_validationNombre" required>

                    <div class="row">
                        <div class="col-sm-6">
                            <label for="E_validationApellidos_P" class="form-label">*Apellido Paterno</label>
                            <input type="text" name="R_apellidos_P" class="form-control" value="<?php echo $apellido_P; ?>" id="E_validationApellidos_P" required>
                        </div>
                        <div class="col-sm-6">
                            <label for="" class="form-label">Apellido Materno</label>
                            <input type="text" name="R_apellidos_M" class="form-control" value="<?php echo $apellido_M; ?>" id="E_validationApellidos_M">
                        </div>
                    </div>

                    <label for="E_validationContrasena" class="form-label">*Contraseña</label>
                    <input type="password" name="R_contrasena" class="form-control" value="<?php echo $contrasena; ?>" id="E_validationContrasena" required>
                    
                    <div class="row">
                        <div class="col-sm-9">
                            <label for="E_validationCorreo" class="form-label">*Correo Eletronico</label>
                            <input type="email" name="R_correo" class="form-control" value="<?php echo $correo; ?>" id="E_validationCorreo" required>
                        </div>
                        <div class="col-sm-3">
                            <label for="E_validationEdad" class="form-label">*Edad</label>
                            <input type="number" name="R_edad" class="form-control" value="<?php echo $edad; ?>" id="E_validationEdad" required>
                        </div>
                    </div>

                    <p class="text-danger text-center" id="feedback_R1"></p>
                    <p class="text-success text-center" id="feedback_R2"></p>
                </div>
            
                <div class="modal-footer">
                    <a type="button" class="btn btn-secondary" href="Menu.php"> Regresar</a>
                    <button class="btn btn-success" id="btnEditar" name="btnEditar" value="editar" type="submit">Guardar cambios</button>
                </div>
            </form>
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

        $("#btnEditar").on("click",function(evento){    

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

            var vNombre = $("#E_validationNombre").val();
            var vApellido_P = $("#E_validationApellidos_P").val();
            var vApellido_M = $("#E_validationApellidos_M").val();
            var vContrasena = $("#E_validationContrasena").val();
            var vCorreo = $("#E_validationCorreo").val();
            var vEdad = $("#E_validationEdad").val();
            var vAccion = "Editar";

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
                }
                console.log(json);
            });

        });
    </script>

</body>
</html>