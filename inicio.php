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
        <title>Sistema de Gesti&oacute;n <?php echo $Identidad_Mikrotik ;?></title>
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
                    <li class="">Bienvenido <?=$nombre?></li>
                </ul>
                <!-- END BREADCRUMB -->

                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                  <?php if ($API->connect(IP_MIKROTIK, USER, PASS)) { ;?>
                    <!-- START WIDGETS -->
                    <div class="row">
                       <div class="col-md-8">
                           <div class="panel panel-default">
                               <div class="panel-heading">
                                   <div class="panel-title-box">
                                       <h3>Interfaces</h3>
                                       <span>Estado de interfaces f&iacute;sicas</span>
                                   </div>
                                   <ul class="panel-controls" style="margin-top: 2px;">
                                       <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                                       <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                                       <li class="dropdown">
                                           <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>
                                           <ul class="dropdown-menu">
                                               <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Collapse</a></li>
                                               <li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
                                           </ul>
                                       </li>
                                   </ul>
                               </div>
                               <div class="panel-body panel-body-table">

                                   <div class="table-responsive">
                                       <table class="table table-bordered table-striped">
                                           <thead>
                                               <tr>
                                                   <th width="50%">Nombre Interfaz</th>
                                                   <th width="20%">Estado</th>
                                                   <th width="30%">Velocidad LAN</th>
                                               </tr>
                                           </thead>
                                           <tbody>
                                           <?php
                                               $API->write("/interface/ethernet/getall",true);
                                               $READ = $API->read(false);
                                               $ARRAY = $API->parse_response($READ);
                                               if(count($ARRAY)>0){   // si hay mas de 1 queue.
                                                   for($x=0;$x<count($ARRAY);$x++){
                                                       $name=sanear_string($ARRAY[$x]['name']);
                                                       $speed=sanear_string($ARRAY[$x]['speed']);
                                                       if($ARRAY[$x]['running']=="true"){
                                                           $estado = "<span class='ok'>conectado</span>";
                                                       }else{
                                                           $estado = "<span class='fail'>desconectado</span>";
                                                       }
                                                       $datos_interface = '<tr>';
                                                       $datos_interface.= '<td>'.$name.'</td>';
                                                       $datos_interface.= '<td>'.$estado.'</td>';
                                                       $datos_interface.= '<td>'.$speed.'</td>';
                                                       $datos_interface.= '</tr>';
                                                       echo $datos_interface;
                                                       //var_dump($ARRAY);
                                                   }
                                                   }else{ // si no hay ningun binding
                                                       echo "No hay ningun IP-Bindings. //<br/>";
                                                   }
                                                   ?>
                                           </tbody>
                                       </table>
                                   </div>

                               </div>
                           </div>

                           <!-- START PROJECTS BLOCK -->
                           <div class="panel panel-default">
                               <div class="panel-heading">
                                   <div class="panel-title-box">
                                       <h3>Estado General</h3>
                                       <span>Estado de General RouterBoard</span>
                                   </div>
                                   <ul class="panel-controls" style="margin-top: 2px;">
                                       <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                                       <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                                       <li class="dropdown">
                                           <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>
                                           <ul class="dropdown-menu">
                                               <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Collapse</a></li>
                                               <li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
                                           </ul>
                                       </li>
                                   </ul>
                               </div>
                               <div class="panel-body panel-body-table">

                                   <div class="table-responsive">
                                       <table class="table table-bordered table-striped">
                                           <thead>
                                               <tr>
                                                   <th width="50%">Item</th>
                                                   <th width="50%">Valor</th>
                                               </tr>
                                           </thead>
                                           <tbody>
                                               <tr>
                                                   <td>Nombre Equipo</td>
                                                   <?php
                                                   $API->write("/system/identity/getall",true);
                                                   $READ = $API->read(false);
                                                   $ARRAY = $API->parse_response($READ);
                                                   if(count($ARRAY)>0){   // si hay mas de 1 queue.
                                                       for($x=0;$x<count($ARRAY);$x++){
                                                           $datos_interface = '<td>'.$ARRAY[$x]['name'].'</td>';
                                                           echo $datos_interface;
                                                           //var_dump($ARRAY);
                                                       }
                                                       }else{ // si no hay ningun binding
                                                           echo "No hay ningun IP-Bindings. //<br/>";
                                                       }
                                                   ?>
                                               </tr>
                                               <tr>
                                               <td>Temperatura Mikrotik</td>
                                               <?php
                                                   $API->write("/system/health/getall",true);
                                                   $READ = $API->read(false);
                                                   $ARRAY = $API->parse_response($READ);
                                                   if(count($ARRAY)>0){   // si hay mas de 1 queue.
                                                       for($x=0;$x<count($ARRAY);$x++){
                                                           $temperature=($ARRAY[$x]['temperature']);
                                                           if($temperature >= "56"){
                                                               $temperatura = "<span class='fail'>".$temperature."&ordm;C</span>";
                                                           }else{
                                                               $temperatura = "<span class='ok'>".$temperature."&ordm;C</span>";
                                                           }
                                                           $datos_interface = '<td>'.$temperatura.'</td>';
                                                           echo $datos_interface;
                                                       }
                                                       }else{ // si no hay ningun binding
                                                           echo "No hay ningun IP-Bindings. //<br/>";
                                                       }
                                                   ?>
                                                   </tr>
                                                   <?php
                                                   $API->write("/system/routerboard/getall",true);
                                                   $READ = $API->read(false);
                                                   $ARRAY = $API->parse_response($READ);
                                                   if(count($ARRAY)>0){   // si hay mas de 1 queue.
                                                       for($x=0;$x<count($ARRAY);$x++){
                                                           $datos_routerboard =  '<tr>';
                                                           $datos_routerboard .= '<td>Serial</td>';
                                                           $datos_routerboard .= '<td>'.$ARRAY[$x]['serial-number'].'</td>';
                                                           $datos_routerboard .= '</tr>';
                                                           $datos_routerboard =  '<tr>';
                                                           $datos_routerboard .= '<td>Modelo</td>';
                                                           $datos_routerboard .= '<td>RB '.$ARRAY[$x]['model'].'</td>';
                                                           $datos_routerboard .= '</tr>';
                                                           echo $datos_routerboard;
                                                       }
                                                       }else{ // si no hay ningun binding
                                                           echo "No hay ningun IP-Bindings. //<br/>";
                                                       }
                                                   ?>
                                                   <?php
                                                   $API->write("/system/resource/getall",true);
                                                   $READ = $API->read(false);
                                                   $ARRAY = $API->parse_response($READ);
                                                   if(count($ARRAY)>0){   // si hay mas de 1 queue.
                                                       for($x=0;$x<count($ARRAY);$x++){
                                                           if (!empty($ARRAY[$x]['bad-blocks'])=="") {
                                                               $bad_blocks = "<span class='fail'>No Aplica para esta versi&oacute;n de Mikrotik</span>";
                                                           }else if ($ARRAY[$x]['bad-blocks']>="6") {
                                                               $bad_blocks = ("<span class='fail'>".$ARRAY[$x]['bad-blocks']."</span>");
                                                           } else {
                                                               $bad_blocks = ("<span class='ok'>".$ARRAY[$x]['bad-blocks']."</span>");
                                                           }
                                                           $datos_resource =  '<tr>';
                                                           $datos_resource .= '<td>Uso CPU</td>';
                                                           $datos_resource .= '<td>'.$ARRAY[$x]['cpu-load'].'</td>';
                                                           $datos_resource .= '</tr>';
                                                           $datos_resource =  '<tr>';
                                                           $datos_resource .= '<td>Bloques dañados</td>';
                                                           $datos_resource .= '<td>'.$bad_blocks.'</td>';
                                                           $datos_resource .= '</tr>';
                                                           echo $datos_resource;
                                                       }
                                                       }else{ // si no hay ningun binding
                                                           echo "No hay ningun IP-Bindings. //<br/>";
                                                       }
                                                   ?>
                                           </tbody>
                                       </table>
                                   </div>
                               </div>
                           </div>
                           <!-- END PROJECTS BLOCK -->

                        </div>
                        <div class="col-md-4">
                            <div class="panel panel-default">
                              <?php
                                  $clientes_activos;
                                  $total_megas_vendidos; //Esta variable la usare para tomar el total de los megas de todos los clientes

                                  $API->write("/ppp/secret/getall",true);
                                  $READ = $API->read(false);
                                  $ARRAY = $API->parse_response($READ);
                                  $result = getSecret($ARRAY);
                                  extract($result);
                              ?>
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                      <b>Clientes Activos</b>
                                      <span class="badge badge-primary badge-pill"><?php print $client_enable?></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                      <b>Clientes Cortados</b>
                                      <span class="badge badge-primary badge-pill"><?php print $client_suspended?></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                      <b>Total Megas Vendidos</b>
                                      <span class="badge badge-primary badge-pill"><?php print $client_megabytes?></span>
                                    </li>
                                </ul>
                            </div>


<!-- ////////////////////////////////////// COMPARACION //////////////////////////////////////////// -->
                            <div class="panel panel-default">
                                <ul class="list-group">

                                    <?php

                                        $conexiondb = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_DB);
                                        $query = mysqli_query($conexiondb, "SELECT count(*) FROM clients WHERE comment_client NOT LIKE '%CONVENIO%' AND profile != 'default' AND profile != 'CORTADOS' AND name_client NOT LIKE 'prueba%';");

                                        $data_base_count = "";
                                        if ($query->num_rows > 0) {
                                            //$datos = $query->fetch_assoc();
                                            while ($datos = $query->fetch_assoc()) {
                                                $data_base_count = $datos['count(*)'];
                                                //echo $data_base_count;
                                              }
                                        }
                                        mysqli_close($conexiondb);
                                    ?>

                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                      <b>Mikrotik | Base de Datos</b>
                                      <?php
                                      if ($data_base_count == $client_enable) {
                                        echo '<span class="badge badge-success badge-pill">OK</span>';
                                      }else{
                                        echo '<span class="badge badge-danger badge-pill">WRONG</span>';
                                      }
                                      ?>

                                    </li>
                                </ul>
                            </div>
<!-- ////////////////////////////////////// /COMPARACION /////////////////////////////////////////// -->

                            <!-- END WIDGET CLOCK -->
                        </div>

                    </div>

                    <!-- END WIDGETS -->
                    <?php
                      }else{
                          echo "No hay conexion";
                      }
                    ?>

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

        <!-- Script Grafica -->

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
