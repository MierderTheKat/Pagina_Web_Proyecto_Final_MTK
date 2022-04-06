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

        $stmt = $mysqli->prepare("SELECT nombre, asientos_reservados, asientos_agregar, creditos FROM usuarios WHERE ID_usuario=?");
        $stmt->bind_param("i",$ID_Usuario);

        $stmt->execute();
        $stmt->bind_result($nombre, $asientos_reservados, $Asientos, $creditos);
        $stmt->fetch();
        $stmt->close();

        if($Asientos < 1)
        {
            $Asientos = $_POST["Asientos"];
        }
    }
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar Asientos</title>
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
                    <button class="btn btn-lg boton_fuerte dropdown-toggle" type="button">
                    <i class="fas fa-chair"></i> Asientos reservados: <strong><?php echo $asientos_reservados; ?></strong>
                    </button>
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

        <div class="back_color_2">
            <div class="p-5">
                <div class="container">
                    <h1 class="display-3 text-center">Vas a reservar <?php echo $Asientos; ?> Asientos</h1>
                    <form id="limpiarRegistro" class="needs-validation" novalidate>
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="R_validationNombre" class="form-label">*Nombre de beneficiado</label>
                                    <input type="text" name="R_nombre" class="form-control" id="R_validationNombre" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="R_validationMembresia" class="form-label">*Tipo de Membresia</label>                   
                                    <div class="input-group mb-3">
                                        <select class="form-select" id="TipoMembresia" required>
                                            <option value="Bronze">Bronze - 1,000 creditos</option>
                                            <option value="Silver">Silver - 2,000 creditos</option>
                                            <option value="Gold">Gold - 10,000 creditos</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <p class="text-danger text-center" id="feedback_R1"></p>
                            <p class="text-success text-center" id="feedback_R2"></p>

                        </div>
                        <div class="modal-footer">
                            <button class="btn"><a class="btn btn-secondary" href="Menu.php" role="button">Regresar</a></button>
                            <button class="btn btn-success" id="btnAsiento" name="btnAsiento" value="asiento" type="submit">Agregar asiento</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="container">
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
            </div>
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
    $("#btnAsiento").on("click",function(evento){
        
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
        var vMembresia = $("#TipoMembresia").val();
        var vAsientos = "<?php echo $Asientos; ?>";
        var vAccion = "AgregarAsientos";

        console.log(vNombre, vMembresia, vAsientos, vAccion);

        $.ajax({
            url:"procesar_datos.php",
            method:"POST",
            dataType: "json",
            data:{
                nombreA: vNombre,
                membresia: vMembresia,
                no_asientos: vAsientos,
                accion: vAccion
            }
        }).done(function(datos){
            var json = JSON.parse(datos);
            
            if(json.clave == 0){
                $("#feedback_R1").text(json.texto);
                $("#feedback_R2").text("");
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
                    document.location.href = "agregar_asientos.php";
                };
            }
            else if (json.clave == 3){
                $("#feedback_R1").text("");
                $("#feedback_R2").text(json.texto);          

                var $element = $("button");
                $element.prop('disabled', true);
                $element.attr('disabled', true);

                setTimeout(CambiarPag, 1000);

                function CambiarPag(){
                    console.log("Ha pasado 1 segundo");
                    document.location.href = "Menu.php";
                };
            }
            console.log(json);
        });

    });
</script>

</body>
</html>