<?php

session_start();
if($_SESSION['Authenticated']!="1"){
header('Location: ../index.php');
}
require("../includes/variables.php");
require('../functions/funciones.php');
include("../action/security.php");
include("../layouts/menu.php");
require('../apimikrotik.php');
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

        <link rel="icon" href="../favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->

        <!-- CSS INCLUDE -->
        <link rel="stylesheet" type="text/css" id="theme" href="../css/theme-default.css"/>
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
                    <li><a href="#">Reportes</a></li>
                    <li class="active">Colas Simples</li>
                </ul>
                <!-- END BREADCRUMB -->

                <!-- PAGE TITLE -->
                <div class="page-title">
                    <h2><span class="fa fa-arrow-circle-o-left"></span> Listado Usuarios Activos</h2>
                </div>
                <!-- END PAGE TITLE -->

                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">

                    <div class="row">
                    <!-- empieza IF-->
                    <?php if ($API->connect(IP_MIKROTIK, USER, PASS)) { ;?>
                        <div class="col-md-12">
                            <!-- START DATATABLE EXPORT -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Usuarios Creados</h3>
                                    <div class="btn-group pull-right">
                                        <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Exportar Info</button>
                                        <ul class="dropdown-menu">
                                            <li><a href="#" onClick ="$('#customers2').tableExport({type:'xml',escape:'false'});"><img src='../img/icons/xml.png' width="24"/> XML</a></li>
                                            <li><a href="#" onClick ="$('#customers2').tableExport({type:'sql'});"><img src='../img/icons/sql.png' width="24"/> SQL</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#" onClick ="$('#customers2').tableExport({type:'csv',escape:'false'});"><img src='../img/icons/csv.png' width="24"/> CSV</a></li>
                                            <li><a href="#" onClick ="$('#customers2').tableExport({type:'txt',escape:'false'});"><img src='../img/icons/txt.png' width="24"/> TXT</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#" onClick ="$('#customers2').tableExport({type:'excel',escape:'false'});"><img src='../img/icons/xls.png' width="24"/> XLS</a></li>
                                            <li><a href="#" onClick ="$('#customers2').tableExport({type:'doc',escape:'false'});"><img src='../img/icons/word.png' width="24"/> Word</a></li>
                                            <li><a href="#" onClick ="$('#customers2').tableExport({type:'powerpoint',escape:'false'});"><img src='../img/icons/ppt.png' width="24"/> PowerPoint</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#" onClick ="$('#customers2').tableExport({type:'png',escape:'false'});"><img src='../img/icons/png.png' width="24"/> PNG</a></li>
                                            <li><a href="#" onClick ="$('#customers2').tableExport({type:'pdf',escape:'false'});"><img src='../img/icons/pdf.png' width="24"/> PDF</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <table id="customers2" class="table datatable">
                                        <thead>
                                          <tr>
                                            <th>Usuario</th>
                                            <th>Plan</th>
                                            <th>Fecha de pago</th>
                                            <!-- <th>Tiempo Conexi&oacute;n</th> -->
                                          </tr>
                                        </thead>
                                        <tbody>
                                         <?php
                                            $API->write("/ppp/secret/getall",true);
                                            $READ = $API->read(false);
                                            $ARRAY = $API->parse_response($READ);

                                            if(count($ARRAY)>0){   // si hay mas de 1 secret.
                                                for($x=0;$x<count($ARRAY);$x++){
                                                    if($ARRAY[$x]['disabled'] == "false"){
                                                        $name=sanear_string($ARRAY[$x]['name']);
                                                        $datos_pppoe = '<tr>';
                                                        $datos_pppoe.= '<td id="'.$ARRAY[$x]['.id'].'"><a href="#" data-toggle="modal" onClick="searchUser(jQuery(this));" data-target="#info_user_modal">'.$name.'</a></td>';
                                                        $datos_pppoe.= '<td>'.$ARRAY[$x]['profile'].'</td>';
                                                        $datos_pppoe.= '<td>'.substr($ARRAY[$x]['comment'],0,2).'</td>';
                                                        $datos_pppoe.= '</tr>';
                                                        echo $datos_pppoe;
                                                    }
                                                }
                                                }else{ // si no hay ningun secret
                                                    echo "No hay ningun IP-Bindings. //<br/>";
                                                }
                                            ?>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            <!-- END DATATABLE EXPORT -->
                            <div class="modal fade" id="info_user_modal" tabindex="-1" role="dialog" aria-labelledby="info_user_modalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <center><h5 class="modal-title" id="info_user_modalLabel">Informacion del Usuario</h5></center>
                                  </div>
                                  <div class="modal-body">
                                    <div id="parrafo">
                                        <!-- INSERCION JQUERY -->
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">ok</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                        <!--Termina IF-->
                         <?php
                            }else{
                                echo "No hay conexion";
                            }
                        ?>
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
        <audio id="audio-alert" src="../audio/alert.mp3" preload="auto"></audio>
        <audio id="audio-fail" src="../audio/fail.mp3" preload="auto"></audio>
        <!-- END PRELOADS -->

    <!-- START SCRIPTS -->
        <!-- START PLUGINS -->

        <script type="text/javascript" src="../js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="../js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="../js/plugins/bootstrap/bootstrap.min.js"></script>
        <!-- END PLUGINS -->

        <script type="text/javascript" src="../js/plugins/datatables/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="../js/plugins/tableexport/tableExport.js"></script>
        <script type="text/javascript" src="../js/plugins/tableexport/jquery.base64.js"></script>
        <script type="text/javascript" src="../js/plugins/tableexport/html2canvas.js"></script>
        <script type="text/javascript" src="../js/plugins/tableexport/jspdf/libs/sprintf.js"></script>
        <script type="text/javascript" src="../js/plugins/tableexport/jspdf/jspdf.js"></script>
        <script type="text/javascript" src="../js/plugins/tableexport/jspdf/libs/base64.js"></script>
        <!-- END THIS PAGE PLUGINS-->

        <!-- START TEMPLATE -->
        <script type="text/javascript" src="../js/plugins.js"></script>
        <script type="text/javascript" src="../js/actions.js"></script>

        <script>

            function searchUser(user){
              $("#parrafo").empty();
              var id = jQuery(user).parent().attr('id');
              $.ajax({
                type: "POST",
                url: "../action/get_clients_ppp.php",
                data: "Usuario="+id,
                success: function (response){
                    var comment = response[0].comment;
                    var regex = /\[([^\]]+)]/g,
                        match,
                        resultado = [];
                        while ((match = regex.exec(comment)) !== null) {
                            resultado.push(match[1]);
                        }

                    resultado.forEach(function (elemento, indice, array){
                        var bold = elemento.substring(0,elemento.indexOf(":")+1);
                        var rest = elemento.substring(elemento.indexOf(":")+1, elemento.length -1) ;
                        $("#parrafo").append("<p>" + "<strong>" + bold + "</strong>" + rest + "</p>");
                    });
                }
              });
              return false;
            }
        </script>
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->
    </body>
</html>
