<?php
	require_once dirname(dirname(dirname(dirname(__FILE__)))).'/config.php';
		
	require_once CONEXION_SISTEMA;
	$_consulta=new conexion_sistema();
	//$_REQUEST["_id"]=base64_encode(2);
	//$id=base64_decode($_REQUEST["_id"]);
	//$id=2;
    if(isset($_SESSION['logueado'])){
        $_id= $_SESSION['Usuid'] ;
    }
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
	$offset = ($page-1)*$rows;
	$result = array();
	
	$rs1 = $_consulta->query("select count(*) from permisos.vw_informacion_permiso_vacacion where per_codigo='".$id."'");
	$json="";
	$json.= '{"total":"'.$rs1[0][0].'","rows":[ ';
	$rs = $_consulta->query(" SELECT  tpe_nombre,epe_codigo,epe_nombre,pva_fecha_inicio,pva_hora_inicio,pva_fecha_solicitud,pva_fecha_revision FROM permisos.vw_informacion_permiso_vacacion where per_codigo='".$id."' limit $rows offset $offset");
	for($i=0;$i<count($rs);$i++){
		$json.='{"campo1":"'.$rs[$i][0].'","campo2":"'.$rs[$i][1].'","campo3":"'.$rs[$i][2].'","campo4":"'.$rs[$i][3].'","campo5":"'.$rs[$i][4].'","campo6":"'.date("Y-m-d H:i:s",strtotime($rs[$i][5])).'","campo7":"'.( $rs[$i][6]!=NULL ? date("Y-m-d H:i:s",strtotime($rs[$i][6])) : interval_date($rs[$i][5]) ).'"}';
		
		if($i<count($rs)-1){
			$json.=",";
		}
	}
	$json.="]}";
	echo $json;

function interval_date($init)
{
	$finish=date("Y-m-d H:i:s");
    //formateamos las fechas a segundos tipo 1374998435
    $diferencia = strtotime($finish) - strtotime($init);
 
    if(!is_numeric($diferencia) || $diferencia<0){
        $tiempo = "Error";
    }else{
        //comprobamos el tiempo que ha pasado en segundos entre las dos fechas
        //floor devuelve el número entero anterior, si es 5.7 devuelve 5
        if($diferencia < 60){
            $tiempo = "Enviado hace " . floor($diferencia) . " segundo (s)";
        }else if($diferencia < 3600){
            $tiempo = "Enviado hace " . floor($diferencia/60) . " minuto(s)";
        }else if($diferencia < 86400){
            $tiempo = "Enviado hace " . floor($diferencia/3600) . " hora (s)";
        }else if( $diferencia >= 86400 && $diferencia < 172800 ){
		 	$tiempo = "Enviado hace " . floor($diferencia/86400) . " día";
		}else if($diferencia < 31470526){
            $tiempo = "Enviado hace " . floor($diferencia/86400) . " días";
        }else if($diferencia > 31104000){
            $tiempo = "Enviado hace " . floor($diferencia/31104000) . " año (s)";
        }else{
            $tiempo = $diferencia."Error";
        }
	}
        return $tiempo;
}
?>