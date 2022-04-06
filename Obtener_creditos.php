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
    <title>Obtener Creditos</title>
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
            <h1 class="display-3 text-center">20$ = 1000 creditos</h1>
            <form class="needs-validation" method="POST" novalidate>
                <div class="ajustar_form">
                    <div class="row"> 
                        <div class="col-sm-6">
                            <label for="E_validationNumTarjeta" class="form-label">*Número de tarjeta</label>
                            <input type="number" class="form-control" id="E_validationNumTarjeta" required>
                            
                            <label for="E_validationNombApe" class="form-label">*Nombre y apellido</label>
                            <input type="text" class="form-control" id="E_validationNombApe" required>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="E_validationFecha" class="form-label">*Fecha de expiración</label>
                                    <input type="text" class="form-control" id="E_validationFecha" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="E_validationCodigo" class="form-label">*Código de seguridad</label>
                                    <input type="number" class="form-control" id="E_validationCodigo" required>
                                </div>
                            </div>   
                        </div>
                        <div class="col-sm-6">
                            <img class="img-edits_tarjet" src="img/Tarjeta.png">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="E_validationCreditos" class="form-label">*Creditos a ingresar</label>
                            <input type="number" class="form-control" id="E_validationCreditos" required>
                        </div>
                        <div class="col-sm-6">
                            <br>
                            <p class="text-danger text-center" id="feedback_R1"></p>
                            <p class="text-success text-center" id="feedback_R2"></p>
                        </div>
                    </div>

                </div>
            
                <div class="modal-footer">
                    <button class="btn"><a class="btn btn-secondary" href="Menu.php" role="button">Regresar</a></button>
                    <button class="btn btn-success" id="btnAgregarCredito" type="submit">Agregar Creditos</button>
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

        $("#btnAgregarCredito").on("click",function(evento){    

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

            var vCreditos = $("#E_validationCreditos").val();
            var vNumTarjeta = $("#E_validationNumTarjeta").val();
            var vNombreApellido = $("#E_validationNombApe").val();
            var vFechaVen = $("#E_validationFecha").val();
            var vCodigo = $("#E_validationCodigo").val();
            var vAccion = "AgregarCreditos";

            console.log(vCreditos, vNumTarjeta, vNombreApellido, vFechaVen, vCodigo, vAccion);

            $.ajax({
                url:"procesar_datos.php",
                method:"POST",
                dataType: "json",
                data:{
                    Acreditos: vCreditos,
                    tarjeta: vNumTarjeta,
                    nom_ape: vNombreApellido,
                    fecha_ven: vFechaVen,
                    codigo_seg: vCodigo,
                    accion: vAccion
                }
            }).done(function(datos){
                var json = JSON.parse(datos);
                
                if(json.clave == 0){
                    $("#feedback_R2").text("");
                    $("#feedback_R1").text(json.texto);
                }
                else if (json.clave == 1){
                    $("#feedback_R1").text("");
                    $("#feedback_R2").text(json.texto);

                    var $element = $("button");
                    $element.prop('disabled', true);
                    $element.attr('disabled', true);

                    setTimeout(BorrarForms, 1000);
                        function BorrarForms(){
                            console.log("Ha pasado 1 segundo");
                            document.location.href = "Obtener_creditos.php";
                        };
                }
                console.log(json);
            });

        });
    </script>

</body>
</html>