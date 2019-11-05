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

    $user = $_POST["id_user_mkt"];
    $plan = $_POST["edit_Segmento"];
    $secret = $_POST["secret_user_mkt"];
    $comment = utf8_encode($_POST["comment"]);
    if (isset($user)) {
      $API->write("/ppp/secret/set", false);
      $API->write("=.id=".$user, false);
      $API->write("=comment=".$comment, false);
      $API->write("=profile=".$plan, true);
      $READ = $API->read(false);

      //GUARDANDO LOS CAMBIOS EN BASE DE DATOS
      $conexiondb = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_DB);

      $query = mysqli_query($conexiondb, "UPDATE clients SET profile = '$plan', comment_client = '$comment' where name_client = '$secret' ;");
      mysqli_close($conexiondb);
      }

      //ELIMINANDO AL USUARIO DE ACTIVE CONECTION PARA QUE SE APLIQUE EL CAMBIO QUE SE REALICE EN PROFILE

      $API->write("/ppp/active/getall", false);
      $API->write("?name=".$secret, true);
      $READ = $API->read(false);
      $ARRAY = $API->parse_response($READ);

      $active = $ARRAY[0]['.id'];

      $API->write("/ppp/active/remove", false);
      $API->write("=.id=".$active, true);
      $READ = $API->read(false);

    }else{
        echo "No hay conexion";
    }
?>
