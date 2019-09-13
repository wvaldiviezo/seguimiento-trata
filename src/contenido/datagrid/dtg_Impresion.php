<?php
	require_once dirname(dirname(dirname(dirname(__FILE__)))).'/config.php';
	//require_once FUN_FORMATEAR_FECHA;

	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
	
	$filterRules = isset($_POST['filterRules']) ? ($_POST['filterRules']) : '';
	$where = '';
	
	
	/*if (!empty($filterRules)){
		$filterRules = json_decode($filterRules);
		//print_r ($filterRules);
		foreach($filterRules as $rule){
			$rule = get_object_vars($rule);
			$field = $rule['field'];
			$op = $rule['op'];
			$value = $rule['value'];
			if (!empty($value)){
				if ($op == 'contains'){
					switch($field){
						case "cmp1Impresion_salida":
							$where .= " and cedula like '%$value%' ";
						break;
						case "cmp2Impresion_salida":
							$where .= " and translate (nombre, 'áéíóúÁÉÍÓÚäëïöüÄËÏÖÜñ', 'aeiouAEIOUaeiouAEIOUÑ') like translate (upper('%$value%'), 'áéíóúÁÉÍÓÚäëïöüÄËÏÖÜñ', 'aeiouAEIOUaeiouAEIOUÑ') ";
						break;
						case "cmp3Impresion_salida":
							$where .= " and translate (area_laboral, 'áéíóúÁÉÍÓÚäëïöüÄËÏÖÜñ', 'aeiouAEIOUaeiouAEIOUÑ')like translate (upper('%$value%'), 'áéíóúÁÉÍÓÚäëïöüÄËÏÖÜñ', 'aeiouAEIOUaeiouAEIOUÑ') ";
						break;
					}
				}
			}
		}
	}*/
	
	$offset = ($page-1)*$rows;
	$result = array();
	
	$rs1 = $_consulta_sistema->query("SELECT count(*) FROM salida_personal.ssp_codigo_salida where eho_codigo=4 ");
	$json="";
	$json.= '{"total":"'.$rs1[0][0].'","rows":[ ';
	$rs = $_consulta_sistema->query(" SELECT csa_codigo, per_codigo_usuario, per_codigo_jefe, csa_fecha_registro
  FROM salida_personal.ssp_codigo_salida where eho_codigo=4 limit $rows offset $offset");
	for($i=0;$i<count($rs);$i++){
		$rs2 = $_consulta_login->query(" SELECT * FROM aplicativo_web.vw_class_visorpermiso_permiso_7 where per_codigo={$rs[$i][1]} ");
		if(isset($rs[$i][2]))
			$rs3 = $_consulta_login->query(" SELECT * FROM aplicativo_web.vw_class_visorpermiso_permiso_7 where per_codigo={$rs[$i][2]} ");
		else
			$rs3[0][0]="";
		/*$CIFRADO->setCifrado($rs[$i][0],$GLOBALS["sis_permisos"]);
		$codigo=$CIFRADO->getCifrado($GLOBALS["sis_permisos"]);	*/
		//$json.='{"cmp0Impresion_salida":"'.urlencode($codigo).'","cmp1Impresion_salida":"'.$rs2[0][0].'","cmp2Impresion_salida":"'.$rs3[0][0].'","cmp3Impresion_salida":"'.FechaFormateada2(strtotime($rs[$i][3])).'","cmp4Impresion_salida":"'.$rs[$i][4].'","cmp5Impresion_salida":"'.$rs[$i][5].'","cmp6Impresion_salida":"'.$rs[$i][6].'","cmp7Impresion_salida":"'.$rs[$i][7].'","cmp8Impresion_salida":"'.$rs[$i][8].'"}';
		$json.='{"cmp0Impresion_salida":"'.$rs[$i][0].'","cmp1Impresion_salida":"'.$rs2[0][0].'","cmp2Impresion_salida":"'.$rs3[0][0].'","cmp3Impresion_salida":"'.interval_date($rs[$i][3])." - ".FechaFormateada2(strtotime($rs[$i][3])).'"}';		
		if($i<count($rs)-1){
			$json.=",";
		}
	}
	$json.="]}";
	echo $json;
	
//FechaFormateada2(strtotime($rs[$i][3]))
function interval_date($init)
{
	$finish=date("Y-m-d H:i:s");
    $diferencia = strtotime($finish) - strtotime($init);
    if(!is_numeric($diferencia) || $diferencia<0){
        $tiempo = "Error";
    }else{
        //comprobamos el tiempo que ha pasado en segundos entre las dos fechas
        //floor devuelve el número entero anterior, si es 5.7 devuelve 5
        if($diferencia < 60){
            $tiempo = "Hace hace " . floor($diferencia) . " segundo (s)";
        }else if($diferencia < 3600){
            $tiempo = "Hace hace " . floor($diferencia/60) . " minuto(s)";
        }else if($diferencia < 86400){
            $tiempo = "Hace hace " . floor($diferencia/3600) . " hora (s)";
        }else if( $diferencia >= 86400 && $diferencia < 172800 ){
		 	$tiempo = "Hace hace " . floor($diferencia/86400) . " día";
		}else if($diferencia < 31470526){
            $tiempo = "Hace hace " . floor($diferencia/86400) . " días";
        }else if($diferencia > 31104000){
            $tiempo = "Hace hace " . floor($diferencia/31104000) . " año (s)";
        }else{
            $tiempo = $diferencia."Error";
        }
	}
        return $tiempo;
}
?>