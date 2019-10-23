<?php
session_start();
if($_SESSION['Authenticated']!="1"){
header('Location: index');
}
sleep(1);
require("../includes/variables.php");
require('../functions/funciones.php');
include("../action/security.php");

$id_report = $_POST['id_report'];

$conexiondb = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_DB);

$query = mysqli_query($conexiondb, "UPDATE reports SET resolved = 'yes' where id = '$id_report' ;");
mysqli_close($conexiondb);
