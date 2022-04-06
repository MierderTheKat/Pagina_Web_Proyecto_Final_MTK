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
    $nombre ="Todos los asientos";

    $stmt = $mysqli->prepare("SELECT sum(asientos_reservados) FROM usuarios");
    $stmt->execute();
    $stmt->bind_result($asientos_reservados);
    $stmt->fetch();
    $stmt->close();
    $creditos ="+∞";

    }
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos los Asientos</title>
    <link rel="stylesheet" href="css/ediciones.css?1.0" media="all">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/jquery-3.6.0.js"></script>
</head>

<body  class="back_color_1">
    
    <?php
    $resultado = $mysqli->query("SELECT * FROM asientos");
    ?>

    <div class="container">
        <nav class="navbar navbar-light fondonav">
            <div class="container-fluid">

            <button class="btn btn-sm btnlogo"><img class="img-edits" src="img/Logo.png"></button>

                <div class="dropdown espacio">
                    <button class="btn btn-lg boton_fuerte dropdown-toggle">
                    <i class="fas fa-chair"></i> Asientos reservados: <strong><?php echo $asientos_reservados; ?></strong>
                    </button>
                </div>
                
                <div class="d-flex margen">
                    <div class="container d-flex">
                        <div class="dropdown espacio">
                        <button class="btn btn-lg boton_fuerte dropdown-toggle">
                        <i class="fab fa-bitcoin"></i> <?php echo $creditos; ?></button>
                        </div>

                        <div class="dropdown espacio">
                        <button class="btn btn-lg boton_fuerte dropdown-toggle" >
                        <i class="fas fa-user"></i>
                        </button>
                        </div>
                    </div>
                </div>
        </nav>

        <div class="back_color_2">
            <div class="p-5">
                <h1 class="display-3 text-center"><?php echo $nombre; ?></h1>
                <a class="btn btn-lg boton_fuerte" href="Asientos_PU.php"><- Vista personal</a>
                <table class="table table-striped">
                    <thead class="text-center">
                        <th>No.</th>
                        <th>Nombre de Usuario</th>
                        <th>Membresia</th>
                        <th>No. de Ticket</th>
                    </thead>
                    <tbody>
                        <?php
                        $Num = 0;
                        while($fila = $resultado ->fetch_assoc()){
                            
                            $Num = $Num + 1;
                            $fila[ID_asiento];
                            echo "<tr>
                                <td class=\"text-center\">$Num</td>
                                <td class=\"text-center\">$fila[nombre_usuario]</td>
                                <td class=\"text-center\">$fila[membresia]</td>
                                <td class=\"text-center\">$fila[No_ticket]</td>
                            </tr>";
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

</body>
</html>