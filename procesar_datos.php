<?php
    require "conexion.php";
    session_start();

    $ID_Usuario = $_SESSION["autenticado"];
    $accion = $_POST["accion"];
    $respuesta = "";
    $opcion = "aceptado";

    if($accion == "Ingresar"){

        $resultado="";

        $correo = $_POST["correo"];
        $contrasena = $_POST["contrasena"];

        if(strlen($correo) <= 5 || strlen($correo) > 100){
            if(strlen($correo) <= 5){
                $respuesta = " Correo invalido | demasiado corto";
            }
            else{
                $respuesta = " Correo invalido | demasiado largo";
            }
            $opcion = "rechazado";
        }else if(strlen($contrasena) <= 9 || strlen($contrasena) > 100){
            if(strlen($contrasena) <= 9){
                $respuesta = " Contraseña invalida | demasiado corta";
            }
            else{
                $respuesta = " Contraseña invalida | demasiado larga";
            }
            $opcion = "rechazado";
        }
    
        if($opcion == "aceptado"){
            $stmt = $mysqli->prepare("SELECT ID_usuario FROM usuarios WHERE correo=? AND contrasena=?");
            $stmt->bind_param("ss",$correo,$contrasena);
        
            $stmt->execute();
            $stmt->bind_result($resultado);
            $stmt->fetch();
            $stmt->close();

            if($resultado == null){
                echo json_encode("{\"clave\":\"0\",\"texto\":\"Correo o contraseña incorrectos\"}");
            }
            else{
                $_SESSION["autenticado"] = $resultado;
                echo json_encode("{\"clave\":\"1\",\"texto\":\"Las credenciales son correctas, Bienvenida(o) $nombre\"}");
            }
        }
        else
        {
            echo json_encode("{\"clave\":\"0\",\"texto\":\"$respuesta\"}");
        }
        console.log($resultado);
    }

    else if($accion == "Registrar" || $accion == "Editar"){
        
        $nombre = $_POST["nombre"];
        $contrasena = $_POST["contrasena"];
        $apellido_P = $_POST["apellido_paterno"];
        $apellido_M = $_POST["apellido_materno"];
        $correo = $_POST["correo"];
        $edad = $_POST["edad"];
        
        $buscarcorreo = $mysqli->query("SELECT correo FROM usuarios");

        while($fila = $buscarcorreo ->fetch_assoc()){
            if($correo == $fila[correo]){
                $respuesta = "Ingresa un correo no utilizado";
                $opcion = "rechazado";
            }
        }

        $stmt = $mysqli->prepare("SELECT correo FROM usuarios WHERE ID_usuario=?");
        $stmt->bind_param("i",$ID_Usuario,);
    
        $stmt->execute();
        $stmt->bind_result($correoviejo);
        $stmt->fetch();
        $stmt->close();

        if($correoviejo == $correo){
            $opcion = "aceptado";
        }

        if(strlen($nombre) <= 2 || strlen($nombre) > 50){
            if(strlen($nombre) <= 2){
                $respuesta = " Nombre invalido | demasiado corto";
            }
            else{
                $respuesta = " Nombre invalido | demasiado largo";
            }
            $opcion = "rechazado";
        }else if(strlen($contrasena) <= 9 || strlen($contrasena) > 100){
            if(strlen($contrasena) <= 9){
                $respuesta = " Contraseña invalida | demasiado corta";
            }
            else{
                $respuesta = " Contraseña invalida | demasiado larga";
            }
            $opcion = "rechazado";
        }else if(strlen($apellido_P) <= 2 || strlen($apellido_P) > 50){
            if(strlen($apellido_P) <= 2){
                $respuesta = " Apellido paterno invalido | demasiado corto";
            }
            else{
                $respuesta = " Apellido paterno invalido | demasiado largo";
            }
            $opcion = "rechazado";
        }else if(strlen($correo) <= 5 || strlen($correo) > 100){
            if(strlen($correo) <= 5){
                $respuesta = " Correo invalido | demasiado corto";
            }
            else{
                $respuesta = " Correo invalido | demasiado largo";
            }
            $opcion = "rechazado";
        }else if($edad < 18 || $edad > 120){
            if(strlen($edad) <= 18){
                $respuesta = " Edad invalida | minimo de 18 años";
            }
            else{
                $respuesta = " Edad invalida | maximo de 120 años";
            }
            $opcion = "rechazado";
        }

        if($accion == "Registrar"){

            if($opcion == "aceptado"){

                echo json_encode("{\"clave\":\"1\",\"texto\":\" $nombre se a registrado correctamente\"}");
        
                $stmt = $mysqli->prepare("INSERT INTO usuarios(nombre, apellido_paterno, apellido_materno, contrasena, correo, edad, asientos_reservados, asientos_agregar, creditos) VALUES(?,?,?,?,?,?,0,0,10000)");
                $stmt->bind_param("sssssi",$nombre,$apellido_P,$apellido_M,$contrasena,$correo,$edad);
                
                $stmt->execute();
                $stmt->close();
            }
            else
            {
                echo json_encode("{\"clave\":\"0\",\"texto\":\"$respuesta\"}");
            }
        }
        else if($accion == "Editar"){

            if($opcion == "aceptado"){

                echo json_encode("{\"clave\":\"1\",\"texto\":\" Se actualizó correctamente\"}");

                $stmt = $mysqli->prepare("UPDATE usuarios SET nombre = ?, apellido_paterno = ?, apellido_materno = ?, contrasena = ?, correo = ?, edad = ? WHERE ID_usuario = ?");
                $stmt->bind_param("sssssii",$nombre,$apellido_P,$apellido_M,$contrasena,$correo,$edad,$ID_Usuario);
                
                $stmt->execute();
                $stmt->close();
            }
            else
            {
                echo json_encode("{\"clave\":\"0\",\"texto\":\"$respuesta\"}");
            }

        }
    }

    else if($accion == "AgregarAsientos"){
        $nombreA = $_POST["nombreA"];
        $membresia = $_POST["membresia"];
        $asientos = $_POST["no_asientos"];
        
        if(strlen($nombreA) <= 2 || strlen($nombreA) > 100){

            if(strlen($nombreA) <= 2){
                $respuesta = " Nombre invalido | demasiado corto";
            }
            else{
                $respuesta = " Nombre invalido | demasiado largo";
            }
            $opcion = "rechazado";
        }else{
            
            $stmt = $mysqli->prepare("UPDATE usuarios SET asientos_agregar = ? WHERE ID_usuario = ?");
            $stmt->bind_param("ii",$asientos,$ID_Usuario);
            $stmt->execute();
            $stmt->close();

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
                $pago = 99999;
                $opcion = "rechazado";
                $respuesta = "Ocurrio algo";
            }

            if($pago <= $creditos){
                $opcion = "aceptado";
                $asientos_plus = $asientos_reservados + 1;
                $creditos_plus = $creditos - $pago;
            }
            else{
                $respuesta ="No tienes creditos suficientes, ve a conseguir más";
                $opcion = "rechazado";
            }
        }
        if($opcion == "aceptado"){

            $asientos_minus = $asientos - 1;
            $stmt = $mysqli->prepare("UPDATE usuarios SET asientos_reservados = ?, asientos_agregar = ?, creditos = ? WHERE ID_usuario = ?");
            $stmt->bind_param("iiii",$asientos_plus,$asientos_minus,$creditos_plus,$ID_Usuario);
            $stmt->execute();
            $stmt->close();
            
            $_tk = "_tk";
            $_name = strlen($nombreA);

            $No_Ticket = "$ID_Usuario$_tk$asientos_reservados$asientos";

            $stmt = $mysqli->prepare("INSERT INTO asientos(nombre_usuario, membresia, No_ticket, ID_usuario_FOR) VALUES(?,?,?,?)");
            $stmt->bind_param("sssi",$nombreA,$membresia,$No_Ticket,$ID_Usuario);
            $stmt->execute();
            $stmt->close();

            if($asientos_minus > 0){
                echo json_encode("{\"clave\":\"1\",\"texto\":\" El asiento de $nombreA se agregó correctamente\"}");
            }else{
                echo json_encode("{\"clave\":\"3\",\"texto\":\" Todos los asientos fueron agregados\"}");
            }
        }
        else
        {
            echo json_encode("{\"clave\":\"0\",\"texto\":\"$respuesta\"}");
        }
    }
    
    else if($accion == "AgregarCreditos"){
        $creditos = $_POST["Acreditos"];
        $nomb_apell = $_POST["nom_ape"];
        $tarjeta = $_POST["tarjeta"];
        $fecha_venc = $_POST["fecha_ven"];
        $codigo_segu = $_POST["codigo_seg"];
        
        if(strlen($tarjeta) <= 15 || strlen($tarjeta) > 20){

            if(strlen($tarjeta) <= 15){
                $respuesta = " Número de tarjeta invalido | demasiado corto minimo 16";
            }
            else{
                $respuesta = " Número de tarjeta invalido | demasiado largo maximo 20";
            }
            $opcion = "rechazado";
        }else if(strlen($nomb_apell) <= 5 || strlen($nomb_apell) > 100){

            if(strlen($nomb_apell) <= 5){
                $respuesta = " Nombre y apellido invalidos | demasiado cortos";
            }
            else{
                $respuesta = " Nombre y apellido invalidos | demasiado largos";
            }
            $opcion = "rechazado";
        }else if(strlen($fecha_venc) <= 3 || strlen($fecha_venc) > 5){

            if(strlen($fecha_venc) <= 3){
                $respuesta = " Fecha de expiración invalida | demasiado corta";
            }
            else{
                $respuesta = " Fecha de expiración invalida | demasiado larga";
            }
            $opcion = "rechazado";
        }else if(strlen($codigo_segu) <= 2 || strlen($codigo_segu) >= 4){

            if(strlen($codigo_segu) <= 2){
                $respuesta = " Código de seguridad invalido | demasiado corto";
            }
            else{
                $respuesta = " Código de seguridad invalido | demasiado largo";
            }
            $opcion = "rechazado";
        }else if($creditos <= 0 || $creditos > 99999){
            if($creditos <= 0){
                $respuesta = " Creditos a ingresar invalidos | debes ingresar algo";
            }
            else{
                $respuesta = " Creditos a ingresar invalidos | son demasiados creditos";
            }
            $opcion = "rechazado";
        }
        
        if($opcion == "aceptado"){

            $creditos_viejos = "";

            $stmt = $mysqli->prepare("SELECT creditos FROM usuarios WHERE ID_usuario = ?");
            $stmt->bind_param("i",$ID_Usuario);

            $stmt->execute();
            $stmt->bind_result($creditos_viejos);
            $stmt->fetch();
            $stmt->close();

            $creditos_plus = $creditos + $creditos_viejos;

            $stmt = $mysqli->prepare("UPDATE usuarios SET creditos = ? WHERE ID_usuario = ?");
            $stmt->bind_param("ii",$creditos_plus,$ID_Usuario);
            
            $stmt->execute();
            $stmt->close();
            
            echo json_encode("{\"clave\":\"1\",\"texto\":\" Se agregaron correctamente los creditos\"}");
        }
        else
        {
            echo json_encode("{\"clave\":\"0\",\"texto\":\"$respuesta\"}");
        }

    }
    /*
    else if($accion == "EditarAsientos"){

        $ID_asiento = $_POST["id_asiento"];
        $nombreA = $_POST["nombreE"];
        $membresia = $_POST["membresiaE"];
        
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

            echo json_encode("{\"clave\":\"1\",\"texto\":\" El asiento de $nombreA se edito correctamente\"}");
        }
        else
        {
            echo json_encode("{\"clave\":\"0\",\"texto\":\"$respuesta\"}");
        }
    }
    else if($accion == "EliminarAsiento"){
        
        $ID_asiento = $_POST["Id_asiento"];
        $membresia = $_POST["membresiaB"];

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
            $pago = 99999;
            $opcion = "rechazado";
            $respuesta = "Ocurrio algo";
        }

        $asientos_plus = $asientos_reservados - 1;
        $creditos_plus = $creditos + $pago;

        if($opcion == "aceptado"){
            $stmt = $mysqli->prepare("UPDATE usuarios SET asientos_reservados = ?, creditos = ? WHERE ID_usuario = ?");
            $stmt->bind_param("iii",$asientos_plus,$creditos_plus,$ID_Usuario);
            $stmt->execute();
            $stmt->close();
            
            $stmt = $mysqli->prepare("DELETE FROM asientos WHERE ID_asiento = ?");
            $stmt->bind_param("i",$ID_asiento);
            $stmt->execute();
            $stmt->close();
    
            echo json_encode("{\"clave\":\"1\",\"texto\":\" El asiento se elimino correctamente\"}");
        }
        else
        {
            echo json_encode("{\"clave\":\"0\",\"texto\":\"$respuesta\"}");
        }

    }*/
    else{
        echo json_encode("{\"clave\":\"0\",\"texto\":\"EN NINGUNA $accion\"}");
    }
?>