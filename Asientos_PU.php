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

    $stmt = $mysqli->prepare("SELECT nombre, asientos_reservados, creditos FROM usuarios WHERE ID_usuario=?");
    $stmt->bind_param("i",$ID_Usuario);

    $stmt->execute();
    $stmt->bind_result($nombre, $asientos_reservados, $creditos);
    $stmt->fetch();
    $stmt->close();

    }

    if(isset($_POST["submit"])){

        $opcion = $_POST["submit"];

        if($opcion == "EditarAsiento"){

            $ID_asiento = $_POST["IdEditar"];
            $nombreA = $_POST["E_validationNombre"];
            $membresia = $_POST["E_validationMembresia"];
            
            if(strlen($nombreA) <= 2 || strlen($nombreA) > 50){
                if(strlen($nombreA) <= 2){
                    $respuesta = " Usuario invalido | demasiado corto";
                }
                else{
                    $respuesta = " Usuario invalido | demasiado largo";
                }
                $opcion = "rechazado";
            }else{
                
                $pago = 0;
                $agregar = 0;
                $creditos = "";
                $membresiaVIEJA = "";

                $stmt = $mysqli->prepare("SELECT creditos FROM usuarios WHERE ID_usuario = ?");
                $stmt->bind_param("i",$ID_Usuario);
                $stmt->execute();
                $stmt->bind_result($creditos);
                $stmt->fetch();
                $stmt->close();
                
                $stmt = $mysqli->prepare("SELECT membresia FROM asientos WHERE ID_asiento = ?");
                $stmt->bind_param("i",$ID_asiento);
                $stmt->execute();
                $stmt->bind_result($membresiaVIEJA);
                $stmt->fetch();
                $stmt->close();


                if($membresia == $membresiaVIEJA){
                    $pago = 0;
                }else if($membresiaVIEJA == "Bronze" && $membresia == "Silver"){
                    $pago = 1000;
                }else if($membresiaVIEJA == "Bronze" && $membresia == "Gold"){
                    $pago = 9000;
                }else if($membresiaVIEJA == "Silver" && $membresia == "Bronze"){
                    $agregar = 1000;
                }else if($membresiaVIEJA == "Silver" && $membresia == "Gold"){
                    $pago = 8000;
                }else if($membresiaVIEJA == "Gold" && $membresia == "Bronze"){
                    $agregar = 9000;
                }else if($membresiaVIEJA == "Gold" && $membresia == "Silver"){
                    $agregar = 8000;
                }else{
                    $pago = 99999;
                    $opcion = "rechazado";
                    $respuesta = "Ocurrio algo";
                }

                if($pago == 0)
                {
                    $opcion = "aceptado";
                    $creditos_plus = $creditos + $agregar;
                } else if($pago <= $creditos)
                {
                    $opcion = "aceptado";
                    $creditos_plus = $creditos - $pago;
                }
                else{
                    $respuesta ="No tienes creditos suficientes, ve a conseguir más";
                    $opcion = "rechazado";
                }
            }
            if($opcion == "aceptado"){

                $stmt = $mysqli->prepare("UPDATE usuarios SET creditos = ? WHERE ID_usuario = ?");
                $stmt->bind_param("ii",$creditos_plus,$ID_Usuario);
                $stmt->execute();
                $stmt->close();

                $stmt = $mysqli->prepare("UPDATE asientos SET nombre_usuario = ?, membresia = ? WHERE ID_asiento = ?");
                $stmt->bind_param("ssi",$nombreA,$membresia,$ID_asiento);
                $stmt->execute();
                $stmt->close();
            }
        }
        else if($opcion == "EliminarAsiento"){

            $ID_asiento = $_POST["idBorrar"];
            $membresia = $_POST["BMembresia"];

            $pago = "";
            $asientos_reservados = "";
            $creditos = "";

            $stmt = $mysqli->prepare("SELECT asientos_reservados, creditos FROM usuarios WHERE ID_usuario = ?");
            $stmt->bind_param("i",$ID_Usuario);

            $stmt->execute();
            $stmt->bind_result($asientos_reservados, $creditos);
            $stmt->fetch();
            $stmt->close();
            
            if($membresia == "Bronze"){
                $pago = 1000;
            }else if($membresia == "Silver"){
                $pago = 2000;
            }else if($membresia == "Gold"){
                $pago = 10000;
            }else{
                $opcion = "rechazado";
                $respuesta = "Ocurrio algo";
            }

            if($opcion == "aceptado"){

                $asientos_plus = $asientos_reservados - 1;
                $creditos_plus = $creditos + $pago;

                $stmt = $mysqli->prepare("UPDATE usuarios SET asientos_reservados = ?, creditos = ? WHERE ID_usuario = ?");
                $stmt->bind_param("iii",$asientos_plus,$creditos_plus,$ID_Usuario);
                $stmt->execute();
                $stmt->close();
                
                $stmt = $mysqli->prepare("DELETE FROM asientos WHERE ID_asiento = ?");
                $stmt->bind_param("i",$ID_asiento);
                $stmt->execute();
                $stmt->close();
            }
        }

        unset($_POST);
        unset($_REQUEST);
        header('Location: Asientos_PU.php');
    }

?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Asientos</title>
    <link rel="stylesheet" href="css/ediciones.css?1.0" media="all">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/jquery-3.6.0.js"></script>
</head>

<body  class="back_color_1">
    
    <?php
    $resultado = $mysqli->query("SELECT * FROM asientos WHERE ID_usuario_FOR = $ID_Usuario");
    ?>

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

        <div class="back_color_2">
            <div class="p-5">
                <h1 class="display-3 text-center">Asientos de <?php echo $nombre; ?></h1>
                <a class="btn btn-lg boton_fuerte" href="Asientos_ALL.php">Vista global -> </a>
                <table class="table table-striped">
                    <thead class="text-center">
                        <th>No.</th>
                        <th>Nombre de Usuario</th>
                        <th>Membresia</th>
                        <th>No. de Ticket</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody>
                        <?php
                            $Num = 0;
                            while($fila = $resultado ->fetch_assoc()){
                            $Num = $Num + 1;
                        ?>
                            <tr>
                                <td class="text-center"><?php echo $Num?></td>
                                <td class="text-center"><?php echo $fila[nombre_usuario];?></td>
                                <td class="text-center"><?php echo $fila[membresia];?></td>
                                <td class="text-center"><?php echo $fila[No_ticket];?></td>
                                <td>
                                    <!-- Button trigger modal MODIFICAR-->
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#ModalEdit-<?php echo $Num;?>">
                                    <i class="fas fa-pencil-alt"></i></button>
                                    
                                    <!-- Modal -->
                                    <div class="modal fade" id="ModalEdit-<?php echo $Num;?>" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">

                                            <form class="needs-validation" action="Asientos_PU.php" method="POST" novalidate>
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Editar Asiento</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <input type="hidden" name="IdEditar" value="<?php echo $fila[ID_asiento];?>">
                                                    <div class="mb-3">
                                                        <label for="E_validationNombre" class="form-label">*Nombre de Beneficiario</label>
                                                        <input type="text" name="E_validationNombre" value="<?php echo $fila[nombre_usuario];?>" class="form-control" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="E_validationMembresia" class="form-label">*Tipo de Membresia</label>                   
                                                        <div class="input-group mb-3">
                                                            <select class="form-select" name="E_validationMembresia" required>
                                                            <option value="<?php echo $fila[membresia];?>"><?php echo $fila[membresia];?></option>
                                                            <option value="Bronze">Bronze - 1000 creditos</option>
                                                            <option value="Silver">Silver - 2000 creditos</option>
                                                            <option value="Gold">Gold - 10000 creditos</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <p name="text-danger feedback_R1"></p>
                                                    <p name="text-success feedback_R2"></p>

                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Regresar</button>
                                                    <button class="btn btn-primary" name="submit" value="EditarAsiento" title="Editar Asiento">Guardar Cambios</button>
                                                </div>
                                            </form>

                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Button trigger modal ELIMINAR-->
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#ModalElim-<?php echo $Num;?>">
                                    <i class="far fa-trash-alt"></i></button>
                                    
                                    <!-- Modal -->
                                    <div class="modal fade" id="ModalElim-<?php echo $Num;?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-footer">
                                            <h5 class="modal-title">¿Borrar a <?php echo $fila[nombre_usuario];?>? </h5>
                                            
                                            <div class="d-flex">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                                
                                                <form action="Asientos_PU.php" method="POST">
                                                    <input type="hidden" name="BMembresia" value="<?php echo $fila[membresia];?>">
                                                    <input type="hidden" name="idBorrar" value="<?php echo $fila[ID_asiento];?>">
                                                    <button class="btn btn-danger" name="submit" value="EliminarAsiento" title="Eliminar Asiento">Borrar</button>
                                                </form>

                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                </td>
                            </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
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

        $("#btnReservar").on("click",function(evento){

        var vAsientos = $("#Asientos").val();
        if(vAsientos < 1){
            event.preventDefault();
        }
        });

        /*
        $(".Editar").on("click",function(evento){
            
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

            var vEDIT = $(".Editar").val();

            console.log(vEDIT);

            var vID_Asiento = $(".EdidEditar").val();
            var vNombre = $(".E_validationNombre").val();
            var vMembresia = $(".E_validationMembresia").val();
            var vAccion = "EditarAsientos";

            console.log(vID_Asiento, vNombre, vMembresia, vAccion);

            $.ajax({
                url:"procesar_datos.php",
                method:"POST",
                dataType: "json",
                data:{
                    id_asiento: vID_Asiento,
                    nombreE: vNombre,
                    membresiaE: vMembresia,
                    accion: vAccion
                }
            }).done(function(datos){
                var json = JSON.parse(datos);
                
                if(json.clave == 0){
                    $(".feedback_R1").text(json.texto);
                    $(".feedback_R2").text("");
                }
                else if (json.clave == 1){
                    $(".feedback_R1").text("");
                    $(".feedback_R2").text(json.texto);
                    
                    var $element = $("button");
                    $element.prop('disabled', true);
                    $element.attr('disabled', true);

                    setTimeout(BorrarForms, 1000);
                    function BorrarForms(){
                        console.log("Ha pasado 1 segundo");
                        document.location.href = "Asientos_PU.php";
                    };
                }
                console.log(json);
            });

        });

        $(".Eliminar").on("click",function(evento){
            event.preventDefault();

            var vId_Asiento = $(".idBorrar").val();
            var vMembresia = $(".BMembresia").val();
            var vAccion = "EliminarAsiento";

            console.log(vId_Asiento, vMembresia, vAccion);

            $.ajax({
                url:"procesar_datos.php",
                method:"POST",
                dataType: "json",
                data:{
                    Id_asiento: vId_Asiento,
                    membresiaB: vMembresia,
                    accion: vAccion
                }
            }).done(function(datos){
                var json = JSON.parse(datos);
                var $element = $("button");
                    $element.prop('disabled', true);
                    $element.attr('disabled', true);

                    setTimeout(BorrarForms, 1500);
                    function BorrarForms(){
                        console.log("Ha pasado 1 segundo");
                        document.location.href = "Asientos_PU.php";
                    };
                console.log(json);
            });
        });
        */
    </script>

</body>
</html>