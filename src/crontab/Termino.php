<?php

$sql=$_consulta_sistema->query("SELECT a.rse_codigo,a.rse_nombre,a.rse_fecha_fin,b.ese_nombre,c.ise_nombre,d.ase_nombre,a.ise_codigo,a.per_codigo_monitor
  FROM seguimiento_despacho_entrega.ssd_registro_seguimiento a 
  left join seguimiento_despacho_entrega.ssd_estado_seguimiento b on a.ese_codigo=b.ese_codigo 
  left join seguimiento_despacho_entrega.ssd_impacto_seguimiento c on a.ise_codigo=c.ise_codigo
  left join seguimiento_despacho_entrega.ssd_avance_seguimiento d on a.ase_codigo=d.ase_codigo
 where a.rse_codigo='{$form_entrada['campo_participantes_seguimientoDespacho_0']}' limit 1");			
					$imagen='<img  src="http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata/seguimiento_despacho/img/star_seguimiento.png">';
					switch($sql[0][6]){
						case 1:
							$sql[0][6]=$imagen;
						break;	
						case 2:
							$sql[0][6]=$imagen.$imagen;
						break;
						case 3:
							$sql[0][6]=$imagen.$imagen.$imagen;
						break;
						case 4:
							$sql[0][6]=$imagen.$imagen.$imagen.$imagen;
						break;
						case 5:
							$sql[0][6]=$imagen.$imagen.$imagen.$imagen.$imagen;
						break;
					}
					$información= "<table cellpadding=\"2\" cellspacing=\"2\" align=\"center\" style=\"font-size:13px; border:1px solid #000; width:400px; max-width:600px; text-transform:uppercase\" > 
					<tr>
		 			<td align='center' colspan='2'><img  width=\"180px\" src=\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata/admin/images/mdg1.png\"/></td>
					</tr>
					<tr>
		 			<td>CÓDIGO DE BÚSQUEDA</td><td>".$sql[0][0]."</td>
					</tr>
					<tr>
					<td>NOMBRE</td><td>".$sql[0][1]."</td>
					</tr>
					<tr>
					<td>FECHA DE FINALIZACIÓN</td><td>".FechaFormateada2(strtotime($sql[0][2]))."</td>
					</tr>
					<tr>
					<td>ESTADO ACTUAL</td><td>".$sql[0][3]."</td>
					</tr>
					<tr>
					<td>IMPACTO</td><td>".$sql[0][6]."</td>
					</tr>
					<tr>
					<td>AVANCE</td><td>".$sql[0][5]." %</td>
					</tr>
		 		</table>";

 	$rsqlpersona=$_consulta_login->query(" select per_mail,(a.per_nombres::text || ' '::text) || a.per_apellidos::text AS nombre from aplicativo_web.aaw_persona a where  a.per_codigo='{$form_entrada['campo_participantes_seguimientoDespacho_1']}' limit 1 ");
 
	$mensajeConfirmacion ="<p style='font-size:13px!important; color:#000!important'>Estimad@ ". $rsqlpersona[0][1].",</p>";
	$mensajeConfirmacion.="<p style='font-size:13px!important; color:#000!important'>Se asignó una nueva actividad como RESPONSABLE, la información respectiva se presenta a continuación</p>";
		$mensajeConfirmacion.=$información;
		$mensajeConfirmacion.="<p align=\"center\" style='font-size:15px!important; color:#000!important;'><br /><b>PROCESO AUTOMATIZADO DE SEGUIMIENTO - MDI <br/>2017</b></p>";
		
$monito=$_consulta_login->query(" select per_mail,(a.per_nombres::text || ' '::text) || a.per_apellidos::text AS nombre from aplicativo_web.aaw_persona a where  a.per_codigo='{$sql[0][7]}' limit 1 ");

 $envio_mail->envio("seguimiento@mdi.gob.ec","SEGUIMIENTO MDI",$rsqlpersona[0][0],$rsqlpersona[0][1],"NUEVA ASIGNACIÓN DE RESPONSABLE DE ACTIVIDAD # {$sql[0][0]} ",$mensajeConfirmacion,"","","",$monito[0][0],$monito[0][1],"","");
 
 ?>
 
 
 
 <?php
$GLOBALS["id_portal"]=2;
require_once dirname(dirname(dirname(__FILE__))).'/config.php';
require_once CLA_MAIL;
require_once CONEXION_LOGIN;
require_once CONEXION_SISTEMA;
require_once CLA_VISORPERMISO;
require_once CLA_PERMISOS_TOKEN;
$TOKEN= new TokenPermiso();
$VISOR= new VisorPermiso();
$_consulta_sistema=new conexion_sistema();
$_consulta_login=new conexion();
$envio_mail=new envio_mail;
$codigo=$_consulta_sistema->query(" 
SELECT a.pva_codigo,a.per_codigo_aprueba,c.per_codigo,a.epe_codigo FROM permisos.scp_permiso_vacacion a
left join permisos.vw_informacion_todas_persona_modulologin b on a.per_codigo_aprueba=b.per_codigo
left join permisos.vw_informacion_todas_persona_modulologin c on a.per_codigo=c.per_codigo
 WHERE pva_notificacion_revisado=FALSE and (epe_codigo=1 or epe_codigo=2)  limit 10 ");
if(isset($codigo)){
	for($i=0;$i<count($codigo);$i++){
		$usuario=$_consulta_sistema->query(" select per_mail,per_nombres from permisos.vw_informacion_todas_persona_modulologin where per_codigo='".$codigo[$i][2]."' limit 1 ");
		$usuario_jefe=$_consulta_sistema->query(" select per_mail,per_nombres from permisos.vw_informacion_todas_persona_modulologin where per_codigo='".$codigo[$i][1]."' limit 1 ");
		$mensajeConfirmacion ="<p style='font-size:12px!important; color=#1D537D!important'>Estimad@ ".$usuario[0][1].",</p>";
		$mensajeConfirmacion.="<p style='font-size:12px!important; color=#1D537D!important'>Se ha revisado su permiso por parte de su jefe inmediato. El permiso revisado es:</p>";
		$mensajeConfirmacion.=$VISOR->visor($codigo[$i][0]);
		$mensajeConfirmacion.="<p align=\"center\" style='font-size:15px!important; color:#000!important;'><br /><b>PROCESO AUTOMATIZADO DE PERMISOS Y VACACIONES - DTIC´s SNAP <br/>© 2014 - 2016 Soluciones Informáticas</b></p>";
		switch($codigo[$i][3]){
			case 1:
				$envio_mail->envio($usuario_jefe[0][0],$usuario_jefe[0][1],$usuario[0][0],$usuario[0][1],"Permiso Aprobado",$mensajeConfirmacion,"","","","","","","");
				$envio_mail->envio($usuario_jefe[0][0],$usuario_jefe[0][1],"jorge.martinez@administracionpublica.gob.ec","Jorge Martínez","Permiso Aprobado",$mensajeConfirmacion,"","","","","","","");	
			break;
			case 2:
				$envio_mail->envio($usuario_jefe[0][0],$usuario_jefe[0][1],$usuario[0][0],$usuario[0][1],"Permiso Rechazado",$mensajeConfirmacion,"","","","","","","");
			break;
		}
		$update=$_consulta_sistema->query(" update permisos.scp_permiso_vacacion set pva_notificacion_revisado=TRUE where pva_codigo='".$codigo[$i][0]."' ");
	}
}
unset($GLOBALS["id_portal"]);
?>


