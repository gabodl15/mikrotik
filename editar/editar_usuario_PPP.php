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
            <?php if ($API->connect(IP_MIKROTIK, USER, PASS)) { ;?>
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
                    <li><a href="#">Edici&oacute;n Usuarios</a></li>
                    <li><a href="#">Usuarios Queue Simple</a></li>
                </ul>
                <!-- END BREADCRUMB -->

                    <div class="page-title">
                        <h2 style="margin: 20px;">Informaci&oacute;n General</h2>
                    </div>

                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                <div class="row"><!-- Inicia Fila Row -->
                	 <div class="col-md-5">
                		   <form role="form" id="Get_Info" action="../action/get_clients_ppp.php" method="POST">
                			 <div class="form-horizontal">
                			      <div class="form-group"><!-- Inicia Grupo Control -->
                				          <label class="col-md-4 control-label">Escoja el Usuario</label>
                				          <div class="col-md-8"><!--Inicia Columna md-8-->
                				                <select name="Usuario" id="Usuario" class="control-select select-definido">
                                            <option value="" selected disabled hidden>Seleccione</option>
		                                        <!-- Traemos los Usuarios de los Queues y los imprimimos en cada option -->
		                                        <?php
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
                                            ?>
		                                        <!-- -->
                                        </select>
                                  </div><!-- Termina  Columna md-8-->
                            </div><!-- Termina Grupo Control -->
                      </div>
                      </form>
                  </div>
                </div><!-- Termina Fila Row -->

                <div class="row" id="Info_Form"> <!-- Inicia Preloader de Formulario -->
                </div> <!-- Termina Preloader de Formulario -->

                <!-- Formulario-->
                <div class="row" id="Get_Form"><!-- Inicia Fila Row-->
                    <div class="block">
                        <h3 style="text-align: center; color:#13B21B">Datos Actuales</h3>
                        <br>
                        <div class="col-md-5"><!-- Inicio Columna md-5 -->
                        <form role="form" id="DatosTraidos"  method="POST">
                            <div class="form-horizontal"><!-- Inicia Div Formulario Horizontal-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Usuario Actual</label>
                                    <div class="col-md-8">
                                    <input type="text" class="form-control" name="actual_user" id="actual_user" readonly="yes">
                                    </div>
                                </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Plan Actual</label>
                                <div class="col-md-8">
                                <input type="text" name="plan_actual" id="plan_actual" class="form-control" readonly="yes">
                                </div>
                            </div>
                            </div><!--  Div Formulario Horizontal -->
                            </div><!-- Termina Columna md-5 -->
                            <div class="col-md-5"> <!-- Inicio Columna md-5-->
                            <div class="form-horizontal"><!-- Inicio Div formulario Horizontal -->
                                <div class="form-group">
                                  <label class="col-md-4 control-label">Comentario</label>
                                  <div class="col-md-8">
                                  <textarea class="form-control" rows="7" readonly="yes" id="comment_actual" style="resize: none"></textarea>
                                  </div>
                                </div>
                                <div class="form-group">
                                <label class="col-md-8 control-label">&iquest;Editar Valores?</label>
                                    <div class="col-md-2">
                                    <label class="switch">
                                        <input type="checkbox" id="Editar_Valores" >
                                        <span></span>
                                    </label>
                                    </div>
                                </div>
                            </div><!-- Termina Div Formulario Horizontal-->
                            </div><!-- Termina Columna md-5 -->
                        </form>
                    </div>
                </div><!-- Termina Fila Row -->
		        <!-- Termina Formulario -->

                <div class="row" id="Edicion_ppp"><!-- Inicia Fila Row Formulario De Edicion-->
                  <form role="form" id="Editar_ppp" action="../action/Procesos_EDIT_PPPoE.php" method="POST">
                    <h3 style="text-align: center; color:#13B21B">Formulario de edicion</h3>
                    <br>
                    <div class="col-md-5">
                      <div class="form-horizontal">
                        <input type="hidden" name="ID_Usuario_MKT" id="ID_Usuario_MKT">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Comentario</label>
                            <div class="col-md-8">
                                <textarea class="form-control" id="new-comment" rows="7" style="resize: none"></textarea>
                            </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-5">
                    <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Plan</label>
                                <div class="col-md-8">
                                    <select name="edit_Segment" id="edit_Segment" class="control-select select">

                                        <?php
                                            $API->write("/ppp/profile/getall", true);
                                            $READ = $API->read(false);
                                            $ARRAY = $API->parse_response($READ);
                                            for ($x = 0 ; $x < count($ARRAY) ; $x++){
                                                echo "<option value='".$ARRAY[$x]['name']."'>".$ARRAY[$x]['name']."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="">
                                    <button type="submit" class="btn btn-primary pull-right">Agregar</button>
                                </div>
                            </div>

                    </div>
                    </div>
                </form>
                </div> <!-- Termina Formulario de edicion-->
              </div>
              <!-- END PAGE CONTENT WRAPPER -->
            </div>
            <!-- END PAGE CONTENT -->
            <?php
                }else{
                    echo "No hay conexion";
                }

            ?>
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

        <!-- THIS PAGE PLUGINS -->

        <script type="text/javascript" src="../js/plugins/bootstrap/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="../js/plugins/bootstrap/bootstrap-file-input.js"></script>
        <script type="text/javascript" src="../js/plugins/bootstrap/bootstrap-select.js"></script>
        <script type="text/javascript" src="../js/plugins/tagsinput/jquery.tagsinput.min.js"></script>
        <!-- END THIS PAGE PLUGINS -->

        <!-- START TEMPLATE -->
        <script type="text/javascript" src="../js/plugins.js"></script>
        <script type="text/javascript" src="../js/actions.js"></script>
        <!-- END TEMPLATE -->
        <script type="text/javascript">
            jQuery(document).ready(function() {
            	$("#Get_Form").hide();
            	$("#Edicion_ppp").hide();
            	$('#edit_no_id').blur(function(){
            		var user_name = $('#edit_name').val();
            		var user = user_name.replace(/\s+/g, '');
            		var user_id = $('#edit_no_id').val();
            		$('#edit_user').val(user_id+"-"+user);
            	});
            	$("#Usuario").change(function(){
                $("#Edicion_ppp").slideUp();
                $("#Editar_Valores").prop('checked', false);
              	var dato_usuario = $('#Usuario').val(); // Tomamos el ID del campo Usuario para ejecutar la consulta
              	//Ejecutamos la consulta por medio de Ajax
            		$.ajax({
            			type: "POST",
                		url: '../action/get_clients_ppp.php',
                		data: "Usuario="+dato_usuario, //
                		dataType: "JSON",
                		success: function(data){
                        var plan_actual = data[0].Plan;
                    		$("#Get_Form").fadeIn();
                        $("#Info_Form").empty();
                       	$("#actual_user").val(data[0].nombre)
                       	$("#comment_actual").val(data[0].comment); //Traemos Solo valor de descarga
                        $("#plan_actual").val(plan_actual);

                    },
                    beforeSend: function(){
                        $("#Info_Form").html('<i class="fa fa-spinner fa-spin"></i> Enviando datos, por favor espere');
                    },
                      error: function(data){
                          console.log("error:",data);
                    }
                  });
                //Evitamos cambios en el formulario
                return false;
              	});
              $("#Editar_ppp").submit(function(){
                  $.ajax({
                      type: "POST",
                      url: "../action/Procesos_EDIT_PPPoE.php",
                      data: $("#Editar_ppp").serialize() +"&id_user_mkt="+$('#Usuario').val() +"&secret_user_mkt="+$('#actual_user').val() +"&comment="+$("#new-comment").val(),
                      success: function(data){
                          $("#Editar_Valores").prop('checked', false);
                          $("#Get_Form").slideUp();
                          $("#Edicion_ppp").slideUp();
                          $("#Usuario").val("");
                      },
                      error: function(data){
                          console.log("error:",data);
                      }
                  });
                  return false;
              });
          	  $('.Kbytes').blur(function(){
          		    if( this.value.indexOf('K') == -1 ){
          			       this.value = this.value + 'K';
          		    }
          	  });
          	  $("#Editar_Valores").click(function(){
          		    var check_editar = $("#Editar_Valores").prop('checked', true);
                  //$("ul .dropdown-menu inner selectpicker").removeAtt("selected")
                  $("#new-comment").val($("#comment_actual").val());

                  if(check_editar){
          			       $("#Edicion_ppp").fadeIn();
          		    }else{
          			       $("#Edicion_ppp").fadeOut();
          		    }

<<<<<<< HEAD

=======
                  console.log($("#edit_Segmento").val());
                  console.log($("#plan_actual").val());

                  //$("#edit_Segmento select").val($("#plan_actual").val());
                  console.log($("ul .dropdown-menu .inner .selectpicker li"));

                  //$("select #edit_Segmento option[value="+$("#plan_actual").val()+"]").attr('selected', 'selected');
>>>>>>> 160bdef7a1287466ac73e0f8f5a917f4059183f9
          	  });
            	$('#Notificacion').click(function(){
            		$(this).fadeOut();
            	});
            	});
        </script>
    <!-- END SCRIPTS -->
    <!-- Notificacion -->
    <ul id="Notificacion">
    <li>
    <div class="info_noty">
    <span class="noty_text"></span></div></li></ul>
    </body>
</html>
