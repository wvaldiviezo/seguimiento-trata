<?php
/**
 * Created by PhpStorm.
 * User: fquilumba
 * Date: 28/07/17
 * Time: 08:53 AM
 */
require_once dirname(dirname(dirname(dirname(__FILE__)))).'/config.php';
$id_actividad=0;
$id_persona=0;
$id_tipoper=0;
if(isset($_GET['actividad'])){
    $id_actividad=$_GET['actividad'];
}
if(isset($_GET['persona'])){
    $id_persona=$_GET['persona'];
}
if(isset($_GET['tipoper'])){
    $id_tipoper=$_GET['tipoper'];
}
if($id_tipoper==1){
    $rsqlpersona=$_consulta_login->query("update seguimiento_despacho_entrega.ssd_registro_seguimiento set per_codigo_responsable=null where  rse_codigo=".$id_actividad);
    echo 1;
}elseif($id_tipoper==2){
    $rsqlpersona=$_consulta_login->query("delete from seguimiento_despacho_entrega.ssd_corresponsable_seguimiento where per_codigo_corresponsable=".$id_persona." and  rse_codigo=".$id_actividad);
    echo 1;
}elseif($id_tipoper==3){
    $rsqlpersona=$_consulta_login->query("delete from seguimiento_despacho_entrega.ssd_participante_seguimiento where per_codigo_participante=".$id_persona." and  rse_codigo=".$id_actividad);
    echo 1;
}else{
    echo 0;
}



?>