<?php
	require_once dirname(dirname(dirname(dirname(__FILE__)))).'/config.php';
	//require_once FUN_FORMATEAR_FECHA;
	//$CIFRADO->setDecifrado($GLOBALS["id_portal"],$GLOBALS["sis_permisos"]);
	//$_id=$CIFRADO->getDecifrado($GLOBALS["sis_permisos"]);
if(isset($_SESSION['logueado'])){
    $_id= $_SESSION['Usuid'] ;
}

	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
	
	$filterRules = isset($_POST['filterRules']) ? ($_POST['filterRules']) : '';
	$where=" ";
	
	
		if (!empty($filterRules)){
		$filterRules = json_decode($filterRules);
		foreach($filterRules as $rule){
			$rule = get_object_vars($rule);
			$field = $rule['field'];
			$op = $rule['op'];
			$value = $rule['value'];
			if (!empty($value)){
				if ($op == 'contains'){
					switch($field){
						case "cmp0VisorBusqueda_seguimiento_despacho":
							$where .= " and a.ans_codigo = '$value' ";
						break;
						case "cmp1VisorBusqueda_seguimiento_despacho":
							$where .= " and a.ans_nombre=$value ";
						break;
					}
				}
			}
		}
	}

	if ( in_array(42, $perfil,true) || in_array(43, $perfil,true)  ) {
		$where .= " and a.per_codigo_responsable = '{$_id}' ";
	}else if( in_array(41, $perfil,true) ){
		$where .= " ";
	}
	
	
	$offset = ($page-1)*$rows;
	$result = array();
	

	$rs1 = $_consulta_sistema->query("SELECT count(a.*) FROM seguimiento_despacho_entrega.ssd_anios_seguimmiento a where a.ans_codigo=a.ans_codigo  {$where} ");
	$json="";
	$json.= '{"total":"'.$rs1[0][0].'","rows":[ ';
	$rs = $_consulta_sistema->query(" SELECT a.ans_codigo,a.ans_nombre
  FROM seguimiento_despacho_entrega.ssd_anios_seguimmiento a
  where  a.ans_codigo=a.ans_codigo {$where} order by a.ans_nombre asc
  limit $rows offset $offset");

	for($i=0;$i<count($rs);$i++){
		
		$json.='{"cmp0VisorBusqueda_seguimiento_despacho":"'.$rs[$i][0].'","cmp1VisorBusqueda_seguimiento_despacho":"'.$rs[$i][1].'"}';
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