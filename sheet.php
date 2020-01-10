<?php
session_start();
if($_SESSION['Authenticated']!="1"){
header('Location: index.php');
}
require("includes/variables.php");
require('functions/funciones.php');
include("action/security.php");
include("layouts/menu.php");
require('apimikrotik.php');
$API = new routeros_api();
$API->debug = false;
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <!-- META SECTION -->
        <meta name="description" content="SISTEMA DE GESTION - WIFICOLOMBIA">
        <title>Sistema de Gesti&oacute;n <?php echo $xdentidad_Mikrotik ;?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="author" content="<?php echo $Autor ?>">
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->

        <!-- CSS INCLUDE -->
        <link rel="stylesheet" type="text/css" id="theme" href="css/theme-default.css"/>
        <!-- EOF CSS INCLUDE -->
    </head>
    <body>
        <!-- START PAGE CONTAINER -->
        <div class="page-container">

            <?= $menu; ?>

            <!-- PAGE CONTENT -->
            <div class="page-content">

                <!-- START X-NAVIGATION VERTICAL -->
                <ul class="x-navigation x-navigation-horizontal x-navigation-panel">
                    <!-- TOGGLE NAVIGATION -->
                    <!-- END TOGGLE NAVIGATION -->
                    <!-- SEARCH -->
                    <li class="xn-search">
                        <form role="form">
                            <input type="text" name="search" placeholder="Search..."/>
                        </form>
                    </li>
                    <!-- END SEARCH -->
                    <!-- SIGN OUT -->
                    <li class="xn-icon-button pull-right">
                        <a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span></a>
                    </li>
                    <!-- END SIGN OUT -->
                </ul>
                <!-- END X-NAVIGATION VERTICAL -->

                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">Inicio</a></li>
                    <li class="active">Panel</li>
                    <li class="">Bienvenido <?=$nombre;?></li>
                </ul>
                <!-- END BREADCRUMB -->

                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    <div class="row">
                        <div class="col-md-2">
                          <?php 
				
			 $array_mikrotik = [];
			 $array_database = [];
			 // $conexiondb = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_DB);
                         // $query = mysqli_query($conexiondb, "SELECT name_client FROM clients where name_client NOT LIKE 'prueba%';");
                          $new_array = [];
                          if ($API->connect(IP_MIKROTIK, USER, PASS)) {
                             $API->write("/ppp/secret/getall",true);
                             $READ = $API->read(false);
                             $variable = $API->parse_response($READ);
                          }
                          $name_array = [];
                          for ($i=0; $i < count($variable); $i++) {
				 

				  if($variable[$i]['disabled'] == "false" && $variable[$i]['profile'] !== "CORTADOS" && stripos($variable[$i]['name'], 'prueba') === false  ){ //FILTRA SOLO LOS USUARIOS ACTIVOS
					if(stripos($variable[$i]['comment'], 'CONVENIO') === false){	
						$array_mikrotik[] = $variable[$i]['name'];
					}
				  }//FIN DEL IF
				  
                          }
/*
                          if ($query->num_rows > 0) {
                              while ($datos = $query->fetch_assoc()) {
                                  //echo $datos['name_client']."<br>";
                                  array_push($new_array, $datos['name_client']);
                                }
			  }*/                         
			    ?>
                        </div>
                        <div class="col-md-4">
                          <?php
                          // var_dump($name_array);
			  //var_dump($new_array);
			  
			  $conexiondb = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DB);
			  $query = mysqli_query($conexiondb, "SELECT name_client FROM clients WHERE comment_client NOT LIKE '%CONVENIO%' AND profile != 'default' AND profile != 'CORTADOS' AND name_client NOT LIKE 'prueba%';");

			  if($query->num_rows > 0){
				  while($datos = $query->fetch_assoc()){
						
					  $array_database[] = $datos['name_client'];
					
				  }
			  }

			  mysqli_close($conexiondb);


			  $resultado = array_diff($array_mikrotik, $array_database);

			  print_r($resultado);

                             ?>
                        </div>
                    </div>
                  </div>
                </div>
                <!-- END PAGE CONTENT WRAPPER -->
            </div>
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->

        <!-- MESSAGE BOX-->
        <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out">&iquest;</span>Cerrar <strong>Sesi&oacute;n</strong> ?</div>
                    <div class="mb-content">
                        <p>&iquest;Esta seguro que desea salir?</p>
                        <p>Presione No si desea continuar trabajando. Presione Si para salir del sistema de forma segura.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a href="<?=$salir;?>" class="btn btn-success btn-lg">Si</a>
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MESSAGE BOX-->

        <!-- START PRELOADS -->
        <audio id="audio-alert" src="audio/alert.mp3" preload="auto"></audio>
        <audio id="audio-fail" src="audio/fail.mp3" preload="auto"></audio>
        <!-- END PRELOADS -->

    <!-- START SCRIPTS -->

        <!-- START PLUGINS -->
        <script type="text/javascript" src="js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap.min.js"></script>
        <!-- END PLUGINS -->

        <!-- START TEMPLATE -->
        <script type="text/javascript" src="js/plugins.js"></script>
        <script type="text/javascript" src="js/actions.js"></script>
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->
    </body>
</html>
