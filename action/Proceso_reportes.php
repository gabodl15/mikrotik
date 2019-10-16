<?php

session_start();
if($_SESSION['Authenticated']!="1"){
header('Location: index');
}
require("../includes/variables.php");
require('../functions/funciones.php');
require('../apimikrotik.php');
include("security.php");

$arrayResponse = array();

$id_client = $_POST['Usuario'];
$report = $_POST['comentarios'];
$dia = date('Y-m-d');

$conexiondb = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_DB);

$query = mysqli_query($conexiondb,"INSERT INTO reports(id_client, report, fecha) VALUES('$id_client','$report','$dia')");

$arrayResponse[] = array('id' => $id_client, 'rp' => $report );

// if ($query) {
//   echo 1;
// }else {
//   echo 0;
// }
header('Content-type: application/json; charset=utf-8');
echo json_encode($arrayResponse);
?>
