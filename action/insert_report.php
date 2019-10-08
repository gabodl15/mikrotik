<?php
session_start();
include("../includes/variables.php");

if(isset($_POST['id_client']) && isset($_POST['report'])){
    $reporte=$_POST['report'];
    $connection = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_DB);
    $query = mysqli_query($connection,"INSERT INTO report(id_client, report) VALUES('1',$reporte) ");
}
