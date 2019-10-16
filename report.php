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
            <div id="page-content" class="page-content">

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
                            $query = mysqli_query($conexiondb, "SELECT name_client, report, fecha FROM clients, reports  WHERE reports.id_client = clients.id AND reports.resolved = 'no';");

                            // var_dump($query);
                            if ($query->num_rows > 0) {
                                //$datos = $query->fetch_assoc();
                                while ($datos = $query->fetch_assoc()) {
                                    $new_date = date("d-m-Y", strtotime($datos['fecha']));
                                    print "<div class='panel panel-default'>";
                                    print "<div class='panel-heading'><strong>".strtoupper($datos['name_client'])."</strong><spam> - ".$new_date."</spam><button type='button' class='close' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                                    print "<div class='panel-body'>".$datos['report']."</div>";
                                    print "</div>";
                                }
                            }else {
                              print "<div class='panel panel-default'>";
                              print "<div class='panel-heading'>No se tiene ningun caso abierto</div>";
                              print "<div class='panel-body'>...</div>";
                              print "</div>";
                            }
                            mysqli_close($conexiondb);
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

<!-- ////////////////////////// MODAL ///////////////////////////////// -->
                          <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                  <h4 class="modal-title" id="myModalLabel">Reporte</h4>
                                </div>
                                <div class="modal-body">

        <!-- //////////////////////////////////// INICIO DE FROMLARIO DENTRO DEL MUDAL /////////////////////////////////////////// -->
                                  <form id="form-modal" class="" action="action/Proceso_reportes.php" method="post">

                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Usuario</label>
                                            <div class="col-md-8">
                                                <!-- <input type="text" id="name" name="name" class="form-control" placeholder="Nombre Completo de Cliente" required> -->
                                                <select name="Usuario" id="Usuario" class="control-select select-definido">
                                                    <option value="" selected disabled hidden>Seleccione</option>
        		                                        <!-- Traemos los Usuarios de los Queues y los imprimimos en cada option -->
        		                                        <?php

                                                        $conexiondb = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_DB);
                                                        $query = mysqli_query($conexiondb, "SELECT id, name_client FROM clients;");

                                                        // var_dump($query);
                                                        if ($query->num_rows > 0) {
                                                            //$datos = $query->fetch_assoc();
                                                            while ($datos = $query->fetch_assoc()) {
                                                                //print "<div class='panel panel-default'>";
                                                                $id_client_ = $datos['id'];
                                                                $name_client_ = $datos['name_client'];
                                                                //$report_client_ = $datos['report'];
                                                                $option = "<option value="."$id_client_".">"."$name_client_"."</option>";
                                                                echo $option;

                                                              }
                                                        }
                                                        mysqli_close($conexiondb);
                                                    ?>
        		                                        <!-- -->
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Comentarios</label>
                                            <div class="col-md-8">
                                                <textarea id="text-comment" name="comentarios" class="form-control" style="resize: none"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                  </form>
      <!-- ///////////////////////////// FIN DEL FROMULARIO DENTRO DEL MODAL ///////////////////////////////////////// -->
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                  <button type="submit" id="bt-submit" class="btn btn-primary">Save changes</button>
                                </div>
                              </div>
                            </div>
                          </div>
<!-- /////////////////////////////////////// /MODAL ////////////////////////////////////////////// -->




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

        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap-file-input.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap-select.js"></script>
        <script type="text/javascript" src="js/plugins/tagsinput/jquery.tagsinput.min.js"></script>

        <!-- START TEMPLATE -->
        <script type="text/javascript" src="js/plugins.js"></script>
        <script type="text/javascript" src="js/actions.js"></script>

        <!-- <script type="text/javascript" src="js/demo_dashboard.js"></script> -->
        <!-- END TEMPLATE -->

        <script type="text/javascript">
            jQuery(document).ready(function() {

                $('#bt-submit').click(function() {


                    console.log($("#form-modal").serialize());
                    $.ajax({
                        type: "POST",
                        url: "action/Proceso_reportes.php",
                        data: $("#form-modal").serialize(),
                        success: function(data){

                          $("#text-comment").val("");
                          $('#myModal').modal('toggle');

                          location.reload();
                        },
                        error: function(data){
                            console.log("error:",data);
                        }
                    });

                    return false;
                });
            });
        </script>
    <!-- END SCRIPTS -->
    </body>
</html>
