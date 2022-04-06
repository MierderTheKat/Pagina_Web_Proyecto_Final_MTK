<?php
$mysqli = new mysqli("localhost","root","lidiaoro.com","registros");

if($mysqli->connect_error){
    echo "Ocurrió un error en al conexión: " . $mysqli->connect_error;
    echo "error no. " . $mysqli->connect_errno;
}
//else{
//    echo "Conexión exitosa a la BD";
//}
?>