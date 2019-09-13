<?php
require_once dirname(dirname(dirname(dirname(__FILE__)))).'/config.php';
//require_once FUN_FORMATEAR_FECHA;
//$CIFRADO->setDecifrado($GLOBALS["id_portal"],$GLOBALS["sis_permisos"]);
//$_id=$CIFRADO->getDecifrado($GLOBALS["sis_permisos"]);
if(isset($_SESSION['logueado'])){
    $_id= $_SESSION['Usuid'] ;
}

$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$filas = $_consulta_sistema->query(" SELECT count(rse_codigo) from seguimiento_despacho_entrega.ssd_registro_seguimiento");
if ($filas[0][0]>0){
    //$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 100;
    $rows = $filas[0][0];
}else{
    $rows = 0;100;
}

$filterRules = isset($_POST['filterRules']) ? ($_POST['filterRules']) : '';
$where=" ";
$where2=" ";
$where3=" ";


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
                        $where .= " and a.rse_codigo = '$value' ";
                        $where2 .= " and a.rse_codigo = '$value' ";
                        $where3 .= " and a.rse_codigo = '$value' ";
                        break;
                    case "cmp1VisorBusqueda_seguimiento_despacho":
                        $where .= " and translate (upper(a.rse_nombre), 'áéíóúÁÉÍÓÚäëïöüÄËÏÖÜñ', 'aeiouAEIOUaeiouAEIOUÑ') like translate (upper('%$value%'), 'áéíóúÁÉÍÓÚäëïöüÄËÏÖÜñ', 'aeiouAEIOUaeiouAEIOUÑ') ";
                        $where2 .= " and translate (upper(a.rse_nombre), 'áéíóúÁÉÍÓÚäëïöüÄËÏÖÜñ', 'aeiouAEIOUaeiouAEIOUÑ') like translate (upper('%$value%'), 'áéíóúÁÉÍÓÚäëïöüÄËÏÖÜñ', 'aeiouAEIOUaeiouAEIOUÑ') ";
                        $where3 .= " and translate (upper(a.rse_nombre), 'áéíóúÁÉÍÓÚäëïöüÄËÏÖÜñ', 'aeiouAEIOUaeiouAEIOUÑ') like translate (upper('%$value%'), 'áéíóúÁÉÍÓÚäëïöüÄËÏÖÜñ', 'aeiouAEIOUaeiouAEIOUÑ') ";
                        break;
                    case "cmp2VisorBusqueda_seguimiento_despacho":
                        $jefe = $_consulta_login->query(" SELECT per_codigo FROM aplicativo_web.vw_class_visorpermiso_permiso_7 where translate (nombre, 'áéíóúÁÉÍÓÚäëïöüÄËÏÖÜñ', 'aeiouAEIOUaeiouAEIOUÑ') like  translate(upper('%$value%'), 'áéíóúÁÉÍÓÚäëïöüÄËÏÖÜñ', 'aeiouAEIOUaeiouAEIOUÑ') ");
                        $where .=" and (";
                        $where2 .=" and (";
                        $where3 .=" and (";
                        for($i=0;$i<count($jefe);$i++){
                            $where .= " a.per_codigo_responsable = '{$jefe[$i][0]}'";
                            $where2 .= " a.per_codigo_responsable = '{$jefe[$i][0]}'";
                            $where3 .= " a.per_codigo_responsable = '{$jefe[$i][0]}'";
                            if($i<count($jefe)-1){
                                $where .=" or ";
                                $where2 .=" or ";
                                $where3 .=" or ";
                            }
                        }
                        $where .=" )";
                        $where2 .=" )";
                        $where3 .=" )";
                        //echo "<script languaje='javascript'>alert('".$where."')</script>";
                        ///$archivo=$_consulta_sistema->query(" SELECT count(*)  FROM seguimiento_despacho_entrega.ssd_archivo_registro_seguimiento where era_codigo=9 and rse_codigo='{$rs[$i][0]}'; ");
                        break;
                }
            }
            if ($op == 'equal'){
                switch($field){

                    case "cmp3VisorBusqueda_seguimiento_despacho":
                        $value = date("Y-m-d",strtotime($rule['value']));
                        $where .= " and a.rse_fecha_fin::date = '$value' ";
                        $where2 .= " and a.rse_fecha_fin::date = '$value' ";
                        $where3 .= " and a.rse_fecha_fin::date = '$value' ";
                        break;
                    case "cmp4VisorBusqueda_seguimiento_despacho":
                        $where .= " and a.ese_codigo = '$value' ";
                        $where2 .= " and a.ese_codigo = '$value' ";
                        $where3 .= " and a.ese_codigo = '$value' ";
                        break;
                    case "cmp5VisorBusqueda_seguimiento_despacho":
                        $where .= " and a.ise_codigo = '$value' ";
                        $where2 .= " and a.ise_codigo = '$value' ";
                        $where3 .= " and a.ise_codigo = '$value' ";
                        break;
                    case "cmp6VisorBusqueda_seguimiento_despacho":
                        $where .= " and a.ase_codigo = '$value' ";
                        $where2 .= " and a.ase_codigo = '$value' ";
                        $where3 .= " and a.ase_codigo = '$value' ";
                        break;
                }
            }
            if ($op == 'notequal'){
                switch($field){
                    case "cmp3VisorBusqueda_seguimiento_despacho":
                        $value = date("Y-m-d",strtotime($rule['value']));
                        $where .= " and a.rse_fecha_fin::date != '$value' ";
                        $where2 .= " and a.rse_fecha_fin::date != '$value' ";
                        $where3 .= " and a.rse_fecha_fin::date != '$value' ";
                        break;
                }
            }
            if ($op == 'less'){
                switch($field){
                    case "cmp3VisorBusqueda_seguimiento_despacho":
                        $value = date("Y-m-d",strtotime($rule['value']));
                        $where .= " and a.rse_fecha_fin::date < '$value' ";
                        $where2 .= " and a.rse_fecha_fin::date < '$value' ";
                        $where3 .= " and a.rse_fecha_fin::date < '$value' ";
                        break;
                }
            }
            if ($op == 'greater'){
                switch($field){
                    case "cmp3VisorBusqueda_seguimiento_despacho":
                        $value = date("Y-m-d",strtotime($rule['value']));
                        $where .= " and a.rse_fecha_fin::date > '$value' ";
                        $where2 .= " and a.rse_fecha_fin::date > '$value' ";
                        $where3 .= " and a.rse_fecha_fin::date > '$value' ";
                        break;
                }
            }
        }
    }
}

if ( in_array(42, $perfil,true) || in_array(43, $perfil,true)  ) {
    $where .= " and a.per_codigo_responsable = '{$_id}' ";
    $where2 .= " and e.per_codigo_corresponsable = '{$_id}' ";
    $where3 .= " and e.per_codigo_participante = '{$_id}' ";
}else if( in_array(41, $perfil,true) ){
    $where .= " ";
    $where2 .= " ";
    $where3 .= " ";
}


$offset = ($page-1)*$rows;
$result = array();


$rs1 = $_consulta_sistema->query("SELECT count(a.*) FROM seguimiento_despacho_entrega.ssd_registro_seguimiento a where a.rse_codigo=a.rse_codigo and (a.ese_codigo!=7 and a.ese_codigo!=8 ) {$where} ");
$rs2 = $_consulta_sistema->query("SELECT count(a.*) FROM seguimiento_despacho_entrega.ssd_registro_seguimiento a
        right join seguimiento_despacho_entrega.ssd_corresponsable_seguimiento e on a.rse_codigo=e.rse_codigo
        where a.rse_codigo=a.rse_codigo and (a.ese_codigo!=7 and a.ese_codigo!=8 ) {$where2} ");
$rs3 = $_consulta_sistema->query("SELECT count(a.*) FROM seguimiento_despacho_entrega.ssd_registro_seguimiento a
        right join seguimiento_despacho_entrega.ssd_participante_seguimiento e on a.rse_codigo=e.rse_codigo
        where a.rse_codigo=a.rse_codigo and (a.ese_codigo!=7 and a.ese_codigo!=8 ) {$where3} ");
$reg=$rs1[0][0]+$rs2[0][0]+$rs3[0][0];
//echo "SELECT count(a.*) FROM seguimiento_despacho_entrega.ssd_registro_seguimiento a where a.rse_codigo=a.rse_codigo and (a.ese_codigo!=7 and a.ese_codigo!=8 ) {$where} ";
$json="";
if($reg>0){
    $json.= '{"total":"'.$rs1[0][0].'","rows":[ ';
    $rs = $_consulta_sistema->query(" SELECT a.rse_codigo,a.rse_nombre,a.per_codigo_responsable,a.rse_fecha_fin,b.ese_nombre,c.ise_nombre,d.ase_nombre,a.ese_codigo,a.ise_codigo
          FROM seguimiento_despacho_entrega.ssd_registro_seguimiento a
          left join seguimiento_despacho_entrega.ssd_estado_seguimiento b on a.ese_codigo=b.ese_codigo
          left join seguimiento_despacho_entrega.ssd_impacto_seguimiento c on a.ise_codigo=c.ise_codigo
          left join seguimiento_despacho_entrega.ssd_avance_seguimiento d on a.ase_codigo=d.ase_codigo
          where  a.rse_codigo=a.rse_codigo and (a.ese_codigo!=7 and a.ese_codigo!=8 ) {$where}
		  union
		  SELECT a.rse_codigo,a.rse_nombre,a.per_codigo_responsable,a.rse_fecha_fin,b.ese_nombre,c.ise_nombre,d.ase_nombre,a.ese_codigo,a.ise_codigo
          FROM seguimiento_despacho_entrega.ssd_registro_seguimiento a
          left join seguimiento_despacho_entrega.ssd_estado_seguimiento b on a.ese_codigo=b.ese_codigo
          left join seguimiento_despacho_entrega.ssd_impacto_seguimiento c on a.ise_codigo=c.ise_codigo
          left join seguimiento_despacho_entrega.ssd_avance_seguimiento d on a.ase_codigo=d.ase_codigo
          left join seguimiento_despacho_entrega.ssd_corresponsable_seguimiento e on a.rse_codigo=e.rse_codigo
          where  (a.ese_codigo!=7 and a.ese_codigo!=8 ) {$where2}
		  union
		  SELECT a.rse_codigo,a.rse_nombre,a.per_codigo_responsable,a.rse_fecha_fin,b.ese_nombre,c.ise_nombre,d.ase_nombre,a.ese_codigo,a.ise_codigo
          FROM seguimiento_despacho_entrega.ssd_registro_seguimiento a
          left join seguimiento_despacho_entrega.ssd_estado_seguimiento b on a.ese_codigo=b.ese_codigo
          left join seguimiento_despacho_entrega.ssd_impacto_seguimiento c on a.ise_codigo=c.ise_codigo
          left join seguimiento_despacho_entrega.ssd_avance_seguimiento d on a.ase_codigo=d.ase_codigo
          left join seguimiento_despacho_entrega.ssd_participante_seguimiento e on a.rse_codigo=e.rse_codigo
          where  (a.ese_codigo!=7 and a.ese_codigo!=8 ) {$where3}
		  order by rse_codigo  desc
          limit $rows offset $offset");
    for($i=0;$i<count($rs);$i++){
        if(isset($rs[$i][2]) && $rs[$i][2]!=NULL )
            $rs3 = $_consulta_login->query(" SELECT * FROM aplicativo_web.vw_class_visorpermiso_permiso_7 where per_codigo={$rs[$i][2]} ");
        else
            $rs3[0][0]="";

        /*$CIFRADO->setCifrado($rs[$i][0],$GLOBALS["sis_permisos"]);
        $codigo=$CIFRADO->getCifrado($GLOBALS["sis_permisos"]);	*/
        //$json.='{"cmp0VisorBusqueda_seguimiento_despacho":"'.urlencode($codigo).'","cmp1VisorBusqueda_seguimiento_despacho":"'.$rs2[0][0].'","cmp2VisorBusqueda_seguimiento_despacho":"'.$rs3[0][0].'","cmp3VisorBusqueda_seguimiento_despacho":"'.FechaFormateada2(strtotime($rs[$i][3])).'","cmp4VisorBusqueda_seguimiento_despacho":"'.$rs[$i][4].'","cmp5VisorBusqueda_seguimiento_despacho":"'.$rs[$i][5].'","cmp6VisorBusqueda_seguimiento_despacho":"'.$rs[$i][6].'","cmp7VisorBusqueda_seguimiento_despacho":"'.$rs[$i][7].'","cmp8VisorBusqueda_seguimiento_despacho":"'.$rs[$i][8].'"}';
        //$avance=$_consulta_sistema->query(" SELECT count(*)  FROM seguimiento_despacho_entrega.ssd_avances_registro_seguimiento where era_codigo=1 and rse_codigo='{$rs[$i][0]}'; ");
        $avance=$_consulta_sistema->query(" SELECT count(*)  FROM seguimiento_despacho_entrega.ssd_avances_registro_seguimiento where era_codigo=1 and rse_codigo='{$rs[$i][0]}'; ");
        ($avance[0][0]>0) ? $avance="avance_1": $avance="" ;

        //$mensaje=$_consulta_sistema->query(" SELECT count(*)  FROM seguimiento_despacho_entrega.ssd_mensaje_registro_seguimiento where era_codigo=5 and rse_codigo='{$rs[$i][0]}'; ");
        $mensaje=$_consulta_sistema->query(" SELECT count(*)  FROM seguimiento_despacho_entrega.ssd_mensaje_registro_seguimiento where era_codigo=5 and rse_codigo='{$rs[$i][0]}'; ");
        ($mensaje[0][0]>0) ? $mensaje="mensaje_1": $mensaje="" ;

        //$archivo=$_consulta_sistema->query(" SELECT count(*)  FROM seguimiento_despacho_entrega.ssd_archivo_registro_seguimiento where era_codigo=9 and rse_codigo='{$rs[$i][0]}'; ");
        $archivo=$_consulta_sistema->query(" SELECT count(*)  FROM seguimiento_despacho_entrega.ssd_archivo_registro_seguimiento where era_codigo=9 and rse_codigo='{$rs[$i][0]}'; ");
        ($archivo[0][0]>0) ? $archivo="archivo_1": $archivo="" ;

        $json.='{"cmp0VisorBusqueda_seguimiento_despacho":"'.$rs[$i][0].'","cmp1VisorBusqueda_seguimiento_despacho":"'.$rs[$i][1].'","cmp2VisorBusqueda_seguimiento_despacho":"'.$rs3[0][0].'","cmp3VisorBusqueda_seguimiento_despacho":"'.$rs[$i][3].'","cmp4VisorBusqueda_seguimiento_despacho":"'.$rs[$i][4].'","cmp5VisorBusqueda_seguimiento_despacho":"'.$rs[$i][5].'","cmp6VisorBusqueda_seguimiento_despacho":"'.$rs[$i][6].'","cmp7VisorBusqueda_seguimiento_despacho":"'.$avance.'","cmp8VisorBusqueda_seguimiento_despacho":"'.$mensaje.'","cmp9VisorBusqueda_seguimiento_despacho":"'.$archivo.'","cmp10VisorBusqueda_seguimiento_despacho":"'.$rs[$i][7].'","cmp11VisorBusqueda_seguimiento_despacho":"'.$rs[$i][8].'"}';
        if($i<count($rs)-1){
            $json.=",";
        }
    }
    $json.="]}";
    echo $json;
}else{
    $json.= '{"total":"0","rows":[ ';


    $json.='{"cmp0VisorBusqueda_seguimiento_despacho":"","cmp1VisorBusqueda_seguimiento_despacho":"","cmp2VisorBusqueda_seguimiento_despacho":"","cmp3VisorBusqueda_seguimiento_despacho":"","cmp4VisorBusqueda_seguimiento_despacho":"","cmp5VisorBusqueda_seguimiento_despacho":"","cmp6VisorBusqueda_seguimiento_despacho":"","cmp7VisorBusqueda_seguimiento_despacho":"","cmp8VisorBusqueda_seguimiento_despacho":"","cmp9VisorBusqueda_seguimiento_despacho":"","cmp10VisorBusqueda_seguimiento_despacho":"","cmp11VisorBusqueda_seguimiento_despacho":""}';


    $json.="]}";
    echo $json;
}

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