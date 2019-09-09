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
        /* 
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
         */
    
    	$client_enable = filter_enable($total_clientes_ppp);
		
    	$client_suspended = filter_suspended($total_clientes_ppp);
    
    	$client_megabytes = megabytes($total_clientes_ppp);
    
        //return array($total_megas_vendidos, $clientes_activos);
        	
    	return array(
          'client_enable' => $client_enable, 
          'client_suspended' => $client_suspended,
          'client_megabytes' => $client_megabytes
        );

  }else{ // si no hay ningun binding
          return "No hay Clientes.";
  }//FIN ELSE

}//FIN FUNCTION getSecret()



function filter_enable($variable){
	$count_client_enable = 0;
  
  	for($i=0;$i<count($variable);$i++){
            
      	if($variable[$i]['disabled'] == "false" && $variable[$i]['profile'] !== "CORTADOS" && $variable[$i]['profile'] !== "default" && stripos($variable[$i]['name'], 'prueba') === false ){ //FILTRA SOLO LOS USUARIOS ACTIVOS
                                                    
          	if(strpos($variable[$i]['comment'], 'CONVENIO') == FALSE){
              
            	$count_client_enable++;	//AUMENTO EN 1 LA CANTIDAD DE CLIENTES ACTIVOS QUE HAY                          
              	
            }//FIN IF
          
        }//FIN DEL IF
      
    }//FIN DEL FOR
  
      return $count_client_enable;
  
}//FIN FILTER_ENABLE



function filter_suspended($variable2){

  	$count_client_suspended = 0;
  	
  	for($j=0; $j<count($variable2);$j++){
    	
      	if($variable2[$j]['profile'] == 'CORTADOS'){
          	$count_client_suspended++;
        }//FIN DEL IF
      
    }//FIN DEL FOR
  	
  	return $count_client_suspended;
}//FIN FILTER_SUSPENDED



function megabytes($variable3){
	$count_megabytes = 0; 

  	for($f=0; $f<count($variable3); $f++){
        if($variable3[$f]['profile'] !== 'CORTADOS' && $variable3[$f]['disabled'] == "false"){
            $dato = $variable3[$f]['profile'];
            $resultado = intval(preg_replace('/[^0-9]+/', '', $dato));//OBTENER SOLO LOS NUMEROS DENTRO DEL NOMBRE DE EL PLAN. EJEMPLO: EMPRESARIAL-2-MEGAS, SE OBTIENE EL 2
            $count_megabytes += $resultado;
        }
    }
  	return $count_megabytes;
}//FIN FMEGABYTES

?>
