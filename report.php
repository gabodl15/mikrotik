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
        <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="../morris.js-0.5.1./libs/morris.min.js" charset="utf-8"></script> -->

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
                    <div class="row">
                        <div class="col-md-8">

                            <?php

                            define('DB_HOST', '127.0.0.1');
                            define('DB_USER', 'internautas');
                            define('DB_PASS', 'int65');
                            define('DB_DB', 'mikrotiks');
                            $conexiondb = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_DB);

                            //$query = mysqli_query($conexiondb,"INSERT INTO reports(id_client, report) VALUES('1','Esto es una prueba')");
                            $query = mysqli_query($conexiondb, "SELECT name_client, report FROM clients, reports  WHERE reports.id_client = clients.id AND reports.resolved = 'no';");

                            // var_dump($query);
                            if ($query->num_rows > 0) {
                                //$datos = $query->fetch_assoc();
                                while ($datos = $query->fetch_assoc()) {
                                    print "<div class='panel panel-default'>";
                                    print "<div class='panel-heading'>".$datos['name_client']."</div>";
                                    print "<div class='panel-body'>".$datos['report']."</div>";
                                    print "</div>";
                                }
                            }else {
                              print "<div class='panel panel-default'>";
                              print "<div class='panel-heading'>No se tiene ningun caso abierto</div>";
                              print "<div class='panel-body'>...</div>";
                              print "</div>";
                            }
                            ?>

                        </div>

                          <!-- PLUSS -->
                          <div class="col-md-4">
                            <div class="col-md-offset-5">
                              <i class="fa fa-plus-circle fa-5x" aria-hidden="true" data-toggle="modal" data-target="#myModal"></i>
                              <!-- <button type="button" class="btn btn-success" aria-hidden="true" data-toggle="modal" data-target="#myModal">Crear</button> -->
                            </div>
                          </div>
                          <!-- PLUSS -->

                          <!-- Button trigger modal -->
                          <!-- <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
                            Launch demo modal
                          </button> -->

                          <!-- MODAL -->
                          <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                  <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                                </div>
                                <div class="modal-body">

                                  <form class="" action="index.html" method="post">

                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Usuario</label>
                                            <div class="col-md-8">
                                                <!-- <input type="text" id="name" name="name" class="form-control" placeholder="Nombre Completo de Cliente" required> -->
                                                <select name="Usuario" id="Usuario" class="control-select select-definido">
                                                    <option value="" selected disabled hidden>Seleccione</option>
        		                                        <!-- Traemos los Usuarios de los Queues y los imprimimos en cada option -->
        		                                        <?php
                                                      if($API->connect(IP_MIKROTIK, USER, PASS)) {
                                                          $API->write("/ppp/secret/getall",true);
                                                          $READ = $API->read(false);
                                                          $users = $API->parse_response($READ);

                                                          foreach ($users as $key => $row) {
                                                              $aux[$key] = $row['name'];
                                                          }
                                                          array_multisort($aux, SORT_ASC, $users);

                                                          if(count($users)>0){   // si hay mas de 1 queue.
                                                              for($x=0;$x<count($users);$x++){
                                                                  $name = sanear_string($users[$x]['name']);
                                                                  $id_umkt = ($users[$x]['.id']);
                                                                  $datos_pppoe = "<option value="."$id_umkt".">".$name."</option>";
                                                                  echo $datos_pppoe;
                                                                  //var_dump($users);
                                                              } 
                                                              }else{ // si no hay ningun binding
                                                                  echo "<option value=''>No hay ningún usuario en Queue Simple</option>";
                                                              }
                                                        }
                                                    ?>
        		                                        <!-- -->
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Comentarios</label>
                                            <div class="col-md-8">
                                                <textarea name="comentarios" class="form-control" style="resize: none"></textarea>
                                            </div>
                                        </div>
                                   <!-- <div class="form-group">
                                            <label class="col-md-4 control-label">Identificaci&oacute;n</label>
                                            <div class="col-md-8">
                                                <input type="text" name="no_id" id="no_id" class="form-control" placeholder="Ingrese n&uacute;mero identificaci&oacute;n">
                                            </div>
                                        </div> -->
                                    </div>


                                  </form>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                  <button type="button" class="btn btn-primary">Save changes</button>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- /MODAL -->




                    </div>
                    <div class="row">

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

        <!-- Script Grafica -->
        <!-- <script src="js/graphs.js" charset="utf-8"></script> -->

        <!-- START PLUGINS -->
        <script type="text/javascript" src="js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap.min.js"></script>
        <!-- END PLUGINS -->

        <!-- START THIS PAGE PLUGINS-->
        <!-- <script type='text/javascript' src='js/plugins/icheck/icheck.min.js'></script>
        <script type="text/javascript" src="js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
        <script type="text/javascript" src="js/plugins/scrolltotop/scrolltopcontrol.js"></script> -->

        <!-- <script type="text/javascript" src="js/plugins/morris/raphael-min.js"></script>
        <script type="text/javascript" src="js/plugins/morris/morris.min.js"></script> -->
        <!-- <script type="text/javascript" src="js/plugins/rickshaw/d3.v3.js"></script>
        <script type="text/javascript" src="js/plugins/rickshaw/rickshaw.min.js"></script>
        <script type='text/javascript' src='js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js'></script>
        <script type='text/javascript' src='js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js'></script>
        <script type='text/javascript' src='js/plugins/bootstrap/bootstrap-datepicker.js'></script>
        <script type="text/javascript" src="js/plugins/owl/owl.carousel.min.js"></script> -->

        <!-- <script type="text/javascript" src="js/plugins/moment.min.js"></script>
        <script type="text/javascript" src="js/plugins/daterangepicker/daterangepicker.js"></script> -->
        <!-- END THIS PAGE PLUGINS-->

        <!-- START TEMPLATE -->
        <script type="text/javascript" src="js/plugins.js"></script>
        <script type="text/javascript" src="js/actions.js"></script>

        <!-- <script type="text/javascript" src="js/demo_dashboard.js"></script> -->
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->
    </body>
</html>
