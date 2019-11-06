<?php
/*
Variables de Identidad
 */
$Identidad_Mikrotik = "Mikrotik_Name";
$Marca_Licenciada = "";
$copyright = "Servicios Corporativos en Telecomunicaciones S.A.S. E.S.P. &copy; <br>".date('Y')." Todos los derechos reservados";
$Autor = "Joan Salom&oacute;n Nieto L&oacute;pez. & Gabriel D&iacute;az";

/*
Variables de Conexion MySQL
 */
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'USER_NAME');
define('DB_PASS', 'PASSWORD');
define('DB_DB', 'DATABASE');
$conexiondb = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_DB);

/*
Variables de Conexion Mikrotik
 */
$id_mkt = $_SESSION['id_mkt'];

//Consultamos el ID de la sesion para que concuerde con los datos en la BD
$conexiondbmkt = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_DB);
$resultado=mysqli_query($conexiondbmkt,"SELECT * FROM mikrotiks WHERE id_mkt=".$id_mkt.";");
$conteo=mysqli_num_rows($resultado);
//ejecutamos la sentencia para traer los datos
$ref=mysqli_fetch_array($resultado,MYSQLI_ASSOC);
//asignamos las variables desde la BD
$user_mkt = $ref['user_mkt'];
$pass_mkt = $ref['pass_mkt'];
$ip_mkt = $ref['ip_mkt'];
//Definimos las variables de conexión de la consola mikrotik
define('USER', $user_mkt);
define('PASS', $pass_mkt);
define('IP_MIKROTIK', $ip_mkt);
?>
