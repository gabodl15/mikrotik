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
    //Creacion Usuarios PPPoE Usermanager
    //$customer = "admin";
<<<<<<< HEAD:action/Procesos_EDIT_PPPoE.php
    $user = $_POST["id_user_mkt"];
    $plan = $_POST["edit_Segmento"];

    if (isset($user)) {
      $API->write("/ppp/secret/set", false);
      $API->write("=.id=".$user, false);
      $API->write("=profile=".$plan, true);
      $READ = $API->read(false);
      $ARRAY = $API->parse_response($READ);
      }
    }
=======

    $API->write("/ppp/secret/getall",false);

>>>>>>> 15b7a1d00628d71dd378cf370b018d3cbe5e61f6:action/Procesos_EDIT_PPPoE.php
/*
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $user = strtolower($_POST['user']);
    $password = $_POST['password'];
    $plan = $_POST['plan'];
    //$perfil = "5 minutos";
  	$identification = $_POST['identification'];
  	$email = $_POST['email'];
  	$address = $_POST['address'];
  	$dayp = $_POST['day'];
  	$datep = $_POST['date'];
  	$ipalias = $_POST['ipalias'];
    $comentarios = $_POST['comentarios'];
    $fecha_activacion = date('d-m-Y');
        if(isset($user) || isset($password) || isset($plan)){
            //valido nombre usuario
            $API->write("/ppp/secret/getall",false);
            $API->write('?name='.$user,true);
            $READ = $API->read(false);
            $ARRAY = $API->parse_response($READ);
            //Crea usuario, customer y password
            if(count($ARRAY)>0){ // si el nombre de usuario "ya existe" lo edito
                echo "Error: El nombre no puede estar duplicado, el proceso no termino.";
            }else{
            $API->write("/ppp/secret/add",false);
            //$API->write("=customer=".$customer,false);
            $API->write("=name=".$user,false);
            //$API->write("=first-name=".$name,false);
            //$API->write("=phone=".$phone,false);
            $API->write("=password=".$password,false);
            $API->write("=service=pppoe",false);
            $API->write("=profile=".$plan,false);
*/
/*
              if($iplocal){
                  $API->write("=local-address=".$iplocal,false);
              }
              if($ipremote){
              	  $API->write("=remote-address=".$ipremote,false);
              }
*/
/*
            $API->write("=comment=".$dayp."/ "."[CLIENTE: $name]"."[RIF_CI: $identification]"."[DIRECCION: $address]"."[CORREO: $email]"."[TELF: $phone]"."[FECHA DE ACTIVACION: $fecha_activacion]"."[DIA DE PAGO: $datep]"."[COMENTARIO: $comentarios]"."[IP ALIAS: $ipalias]",true);
            $READ = $API->read(false);
            // Final Inserción
            $creado = "si";
            if ($creado== "si") {
                // Asigna perfil
*/
/*
                $API->write("/tool/user-manager/user/create-and-activate-profile",false);
                $API->write("=numbers="."\"".$user."\"",false);
                $API->write("=customer=".$customer,false);
                $API->write("=profile=".$plan,true);
                $READ = $API->read(false);
*/
/*
                echo 1;
            } else {
                echo "No se asigno plan";
            }
            }
        }else{
            echo("Hay datos sin definir");
            $creado = "no";
        }
*/
else{
        echo "No hay conexion";
    }
?>
