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
            if($total_clientes_ppp[$x]['disabled'] == "false" && $total_clientes_ppp[$x]['profile'] !== "CORTADOS"){ //FILTRA SOLO LOS USUARIOS ACTIVOS
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

?>
