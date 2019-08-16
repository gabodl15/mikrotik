<?php
function sanear_string($string)
{

    $string = trim($string);

    $string = str_replace(
        array('<', '>',),
        array('', '',),
        $string
    );
  return $string;
}

function sanear_mac($mac){
	$mac = trim($mac);

	$mac = str_replace(
		array('','0.0.0.0','null'),
		array('00:00:00:00:00:00', '00:00:00:00:00:00', '00:00:00:00:00:00'),
		$mac
		);
	return $mac;
}

function segmento($segmento_comercial){
	if ($segmento_comercial=="8/8" ||  $segmento_comercial=="7/7") {
		$segmento_comercial = "Residencial";
	}
	else if($segmento_comercial=="6/6") {
		$segmento_comercial = "Comercial";
	}
	else if($segmento_comercial=="4/4" || $segmento_comercial=="3/3") {
		$segmento_comercial = "Corporativo";
	}
	else if($segmento_comercial=="2/2") {
		$segmento_comercial = "Pruebas o Bloqueos";
	}
	else if($segmento_comercial=="1/1") {
		$segmento_comercial = "Dedicado";
	}
	return $segmento_comercial;
}

function bandwith($ancho_banda){

	$ancho_banda = str_replace(
		array('/'),
		array('</span>/<span class="DownloadAsignado">'),
		$ancho_banda
		);
	return $ancho_banda;
}

function getSecret($total_clientes_ppp){


  if(count($total_clientes_ppp)>0){   // si hay mas de 1 queue.
        //OBTENER LA CANTIDAD DE MEGAS TOTALES VENDIDOS
        for($x=0;$x<count($total_clientes_ppp);$x++){
            if($total_clientes_ppp[$x]['disabled'] == "false" && $total_clientes_ppp[$x]['profile'] !== "CORTADOS" && $total_clientes_ppp[$x]['profile'] !== "default"){ //FILTRA SOLO LOS USUARIOS ACTIVOS
                $dato = $total_clientes_ppp[$x]['profile'];
                $resultado = intval(preg_replace('/[^0-9]+/', '', $dato));//OBTENER SOLO LOS NUMEROS DENTRO DEL NOMBRE DE EL PLAN. EJEMPLO: EMPRESARIAL-2-MEGAS, SE OBTIENE EL 2
                $total_megas_vendidos += $resultado;
                $clientes_activos++;
                //echo $datos_interface;
                //var_dump($total_clientes_ppp);
            }//FIN DEL IF
          }//FIN DEL FOR

          return array($total_megas_vendidos, $clientes_activos);

  }else{ // si no hay ningun binding
          return "No hay Clientes.";
  }//FIN ELSE

}//FIN FUNCTION getSecret()

function filter($variable){
	
  	$client_enable = 0;
    $client_disable = 0;
    $client_agreement = 0;
  
  	for($i=0;$x<count($variable);$i++){
            
      	if($variable[$i]['disabled'] == "false" && $variable[$i]['profile'] !== "CORTADOS" && $total_clientes_ppp[$x]['profile'] !== "default"){ //FILTRA SOLO LOS USUARIOS ACTIVOS
                
          	$comment = strpos($variable[$i]['comment'], 'CONVENIO');
          
          	if($comment !== FALSE){            
              	$client_enable++;	//AUMENTO EN 1 LA CANTIDAD DE CLIENTES ACTIVOS QUE HAY
            }//FIN DEL IF
        	else{
            	$client_agreement++; //AUMENTO EN 1 LA CANTIDAD DE CLIENTES POR CONVENIO QUE HAY
            }//FIN DEL ELSE
              
        }//FIN DEL IF
    }//FIN DEL FOR
      
}

?>
