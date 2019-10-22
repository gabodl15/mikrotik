<?php
session_start();
if($_SESSION['Authenticated']!="1"){
header('Location: index');
}
sleep(1);
require("../includes/variables.php");
require('../functions/funciones.php');
include("../action/security.php");
include("../layouts/menu.php");
require('../apimikrotik.php');
$API = new routeros_api();
$API->debug = false;
if ($API->connect(IP_MIKROTIK, USER, PASS)) {

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $user = strtolower($_POST['user']);
    $password = $_POST['password'];
    $plan = $_POST['plan'];
  	$identification = $_POST['identification'];
  	$email = $_POST['email'];
  	$address = $_POST['address'];
  	$dayp = $_POST['day'];
  	$datep = $_POST['date'];
  	$ipalias = $_POST['ipalias'];
    $monto = $_POST['monto'];
    $comentarios = $_POST['comentarios'];
    $fecha_activacion = date('d-m-Y');

    $info = $dayp."/ "."[CLIENTE: $name]"."[RIF_CI: $identification]"."[DIRECCION: $address]"."[CORREO: $email]"."[TELF: $phone]"."[FECHA DE ACTIVACION: $fecha_activacion]"."[DIA DE PAGO: $datep]"."[MONTO: $monto]"."[COMENTARIO: $comentarios]"."[IP ALIAS: $ipalias]";
        if(isset($user) || isset($password) || isset($plan)){
            //valido nombre usuario
            $API->write("/ppp/secret/getall",false);
            $API->write('?name='.$user,true);
            $READ = $API->read(false);
            $ARRAY = $API->parse_response($READ);

            if(count($ARRAY)>0){ // si el nombre de usuario "ya existe" lo edito
                echo "Error: El nombre no puede estar duplicado, el proceso no termino.";
            }else{
                $API->write("/ppp/secret/add",false);
                $API->write("=name=".$user,false);
                $API->write("=password=".$password,false);
                $API->write("=service=pppoe",false);
                $API->write("=profile=".$plan,false);
                $API->write("=comment=".$info,true);
                $READ = $API->read(false);
                // Final Inserción
                $creado = "si";
                if ($creado== "si") {

                    $conexiondb = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_DB);                    
                    $query = mysqli_query($conexiondb, "INSERT INTO clients(name_client, password_client, profile, comment_client) VALUES('$user', '$password', '$plan', '$info');");
                    mysqli_close($conexiondb);

                    echo 1;
                } else {
                    echo "No se asigno plan";
                }
            }
        }else{
            echo("Hay datos sin definir");
            $creado = "no";
        }
}else{
        echo "No hay conexion";
    }
?>
