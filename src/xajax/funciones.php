<?php
function procesar_frm_fichageneral_seguimientoDespacho($form_entrada){
    require_once dirname(dirname(dirname(__FILE__)))."/config.php";
    $mail_copia=Array();
    $respuesta = new xajaxResponse();
    $_consulta_sistema=new conexion_sistema();
    $_consulta_login=new conexion();
    //$CIFRADO=new Cifrador();
    require_once CLA_MAIL;
    $envio_mail=new envio_mail;
    //$_id=2;
    if(isset($_SESSION['logueado'])){
        $_id= $_SESSION['Usuid'] ;
    }
    $update="0";
    if(isset($form_entrada["campo_ingreso_seguimientoDespacho_0"]) && $form_entrada["campo_ingreso_seguimientoDespacho_0"]!=NULL){
        $update="1";
    }

    switch($update){

        case 1:



            $verificacion=0;
            $vacios=array("1"=>0,"2"=>0);
            for($i=3;$i<=11;$i++){
                if($form_entrada['campo_ingreso_seguimientoDespacho_'.$i]=="")
                    $vacios[$i]="1";
                else
                    $vacios[$i]="0";
            }

            if(in_array("1",$vacios) ){
                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'Todos los campos son obligatorios, primero complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                return $respuesta ;
                exit;
            }

            $sql="delete from seguimiento_despacho_entrega.ssd_especial_registro_seguimiento where  rse_codigo='{$form_entrada['campo_ingreso_seguimientoDespacho_0']}'; ";
            $_consulta_sistema->query($sql);

            if(isset($form_entrada['campo_ingreso_seguimientoDespacho_1'])){
                $_consulta_sistema->query("INSERT INTO seguimiento_despacho_entrega.ssd_especial_registro_seguimiento(ers_codigo, rse_codigo, tes_codigo) VALUES (default,'{$form_entrada['campo_ingreso_seguimientoDespacho_0']}',2); ");
            }
            if(isset($form_entrada['campo_ingreso_seguimientoDespacho_2'])){
                $_consulta_sistema->query("INSERT INTO seguimiento_despacho_entrega.ssd_especial_registro_seguimiento(ers_codigo, rse_codigo, tes_codigo) VALUES (default,'{$form_entrada['campo_ingreso_seguimientoDespacho_0']}',1); ");
            }


            if(isset($form_entrada['campo_ingreso_seguimientoDespacho_12_2'])){
                $_consulta_sistema->query("INSERT INTO seguimiento_despacho_entrega.ssd_avance_registro_seguimiento( ars_codigo, rse_codigo, ars_avance, ars_fecha) VALUES (default, '{$form_entrada['campo_ingreso_seguimientoDespacho_0']}', '{$form_entrada['campo_ingreso_seguimientoDespacho_12']}', now() ); ");
            }else{
                if(isset($form_entrada['campo_ingreso_seguimientoDespacho_12_1']) &&  $form_entrada['campo_ingreso_seguimientoDespacho_12_1']!=NULL){
                    $_consulta_sistema->query("UPDATE seguimiento_despacho_entrega.ssd_avance_registro_seguimiento SET ars_avance='{$form_entrada['campo_ingreso_seguimientoDespacho_12']}', ars_fecha=now() WHERE ars_codigo='{$form_entrada['campo_ingreso_seguimientoDespacho_12_1']}' and rse_codigo='{$form_entrada['campo_ingreso_seguimientoDespacho_0']}';");
                }else{
                    if($form_entrada['campo_ingreso_seguimientoDespacho_12']!=NULL)
                        $_consulta_sistema->query("INSERT INTO seguimiento_despacho_entrega.ssd_avance_registro_seguimiento( ars_codigo, rse_codigo, ars_avance, ars_fecha) VALUES (default, '{$form_entrada['campo_ingreso_seguimientoDespacho_0']}', '{$form_entrada['campo_ingreso_seguimientoDespacho_12']}', now() ); ");
                }
            }

            $sql_anterior="select rse_fecha_fin,ese_codigo from seguimiento_despacho_entrega.ssd_registro_seguimiento WHERE  rse_codigo='{$form_entrada['campo_ingreso_seguimientoDespacho_0']}' limit 1;  ";
            $r_anterior=$_consulta_sistema->query($sql_anterior);
            if( $r_anterior[0][0]!=$form_entrada['campo_ingreso_seguimientoDespacho_8'] ){
                $_consulta_sistema->query(" INSERT INTO seguimiento_despacho_entrega.ssd_fechafin_registro_seguimiento(frs_codigo, rse_codigo, frs_fecha_final, frs_fecha_registro, per_codigo_cambio) VALUES (default, '{$form_entrada['campo_ingreso_seguimientoDespacho_0']}', '{$r_anterior[0][0]}', now(), '{$_id}'); ");







                $sql=$_consulta_sistema->query("SELECT a.rse_codigo,a.rse_nombre,a.rse_fecha_fin,b.ese_nombre,c.ise_nombre,d.ase_nombre,a.ise_codigo,a.per_codigo_responsable,a.per_codigo_monitor
  FROM seguimiento_despacho_entrega.ssd_registro_seguimiento a
  left join seguimiento_despacho_entrega.ssd_estado_seguimiento b on a.ese_codigo=b.ese_codigo
  left join seguimiento_despacho_entrega.ssd_impacto_seguimiento c on a.ise_codigo=c.ise_codigo
  left join seguimiento_despacho_entrega.ssd_avance_seguimiento d on a.ase_codigo=d.ase_codigo
 where a.rse_codigo='{$form_entrada['campo_ingreso_seguimientoDespacho_0']}' limit 1");
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
                $informaciÃ³n= "<table cellpadding=\"2\" cellspacing=\"2\" align=\"center\" style=\"font-size:13px; border:1px solid #000;width:400px; max-width:600px;text-transform:uppercase\" >
					<tr>
		 			<td align='center' colspan='2'><img  width=\"180px\" src=\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata/admin/images/mdg1.png\"/></td>
					</tr>
					<tr>
		 			<td>CÃ“DIGO DE BÃšSQUEDA</td><td>".$sql[0][0]."</td>
					</tr>
					<tr>
					<td>NOMBRE</td><td>".$sql[0][1]."</td>
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
					<tr>
					<td colspan=\"2\" style='border-bottom:1px solid #CCC'>&nbsp;</td>
					</tr>
					<tr>
					<td>FECHA DE FINALIZACIÃ“N ANTIGUA</td><td>".FechaFormateada2(strtotime($r_anterior[0][0]))."</td>
					</tr>
					<tr>
					<td>FECHA DE FINALIZACIÃ“N NUEVA</td><td>".FechaFormateada2(strtotime($form_entrada['campo_ingreso_seguimientoDespacho_8']))."</td>
					</tr>
					<tr>
					<td colspan=\"2\" style='border-bottom:1px solid #CCC'>&nbsp;</td>
					</tr>
					<tr>
		 			<td>LINK DE ACCESO AL SISTEMA</td><td><a href=\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata\">\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata\"</A></td>
					</tr>
		 		</table>";
                if($sql[0][7]=="" ){
                    $respuesta->addScript(" $.messager.show({ title:'Error',msg:'No se ha ingresado un reponsable para esta actividad. Por favor ingrese un responsable en la pestaÃ±a participantes.', timeout:20000, showType:'slide'}); ");
                    return $respuesta ;
                    exit;
                }
                $rsqlpersona=$_consulta_login->query(" select per_mail,(a.per_nombres::text || ' '::text) || a.per_apellidos::text AS nombre from aplicativo_web.aaw_persona a where  a.per_codigo='{$sql[0][7]}' limit 1 ");
                $rsqlpersona1=$_consulta_login->query(" select per_mail,(a.per_nombres::text || ' '::text) || a.per_apellidos::text AS nombre from aplicativo_web.aaw_persona a where  a.per_codigo='{$sql[0][8]}'  limit 1 ");

                $mensajeConfirmacion ="<p style='font-size:13px!important; color:#000!important'>Estimad@ ". $rsqlpersona[0][1].",</p>";
                $mensajeConfirmacion.="<p style='font-size:13px!important; color:#000!important'>Se ha realizado un cambio de fecha de finalizaciÃ³n sobre una actividad, la informaciÃ³n respectiva se presenta a continuaciÃ³n</p>";
                $mensajeConfirmacion.=$informaciÃ³n;
                $mensajeConfirmacion.="<p align=\"center\" style='font-size:15px!important; color:#000!important;'><br /><b>PROCESO AUTOMATIZADO DE SEGUIMIENTO - MDI <br/>2017</b></p>";

                $rs = $_consulta_sistema->query("SELECT a.per_mail FROM aplicativo_web.aaw_persona a,aplicativo_web.aaw_persona_perfil b where a.per_codigo=b.per_codigo and b.pus_codigo=41
                                        union
                                        select per_mail FROM aplicativo_web.aaw_persona_correos WHERE per_codigo={$sql[0][7]};");
                for($i=0;$i<count($rs);$i++){
                    $mail_copia[$i]=$rs[$i][0];
                }
                $envio_mail->envio_copia("seguimiento@mdi.gob.ec","SEGUIMIENTO MDI",$rsqlpersona[0][0],$rsqlpersona[0][1],"NUEVO CAMBIO DE FECHA DE FINALIZACIÃ“N SOBRE ACTIVIDAD",$mensajeConfirmacion,$mail_copia);










            }
            if( $r_anterior[0][1]!=$form_entrada['campo_ingreso_seguimientoDespacho_9'] ){
                $_consulta_sistema->query("INSERT INTO seguimiento_despacho_entrega.ssd_cambioestado_registro_seguimiento( crs_codigo, rse_codigo, ese_codigo, crs_fecha_cambio, per_codigo_cambio) VALUES (default,'{$form_entrada['campo_ingreso_seguimientoDespacho_0']}', '{$r_anterior[0][1]}', now(), '{$_id}'); ");





                $sql1=$_consulta_sistema->query("SELECT a.rse_codigo,a.rse_nombre,a.rse_fecha_fin,b.ese_nombre,c.ise_nombre,d.ase_nombre,a.ise_codigo,a.per_codigo_responsable,a.per_codigo_monitor
  FROM seguimiento_despacho_entrega.ssd_registro_seguimiento a
  left join seguimiento_despacho_entrega.ssd_estado_seguimiento b on a.ese_codigo=b.ese_codigo
  left join seguimiento_despacho_entrega.ssd_impacto_seguimiento c on a.ise_codigo=c.ise_codigo
  left join seguimiento_despacho_entrega.ssd_avance_seguimiento d on a.ase_codigo=d.ase_codigo
 where a.rse_codigo='".$form_entrada['campo_ingreso_seguimientoDespacho_0']."' limit 1");



                $responsable= $sql1[0][7];
                $monitor= $sql1[0][8];


                $imagen='<img  src="http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata/seguimiento_despacho/img/star_seguimiento.png">';
                $antiguo_estado=$_consulta_sistema->query("SELECT ese_nombre from seguimiento_despacho_entrega.ssd_estado_seguimiento where ese_codigo='".$r_anterior[0][1]."' limit 1");
                $nuevo_estado=$_consulta_sistema->query("SELECT ese_nombre from seguimiento_despacho_entrega.ssd_estado_seguimiento where ese_codigo='".$form_entrada['campo_ingreso_seguimientoDespacho_9']."' limit 1");
                $nuevo="";
                switch($sql1[0][6]){
                    case 1:
                        $sql1[0][6]=$imagen;
                        break;
                        $sql1[0][6]=$imagen.$imagen;
                    case 2:
                        $sql1[0][6]=$imagen.$imagen.$imagen;
                        break;
                    case 3:
                        $sql1[0][6]=$imagen.$imagen.$imagen.$imagen;
                        break;
                    case 4:
                        $sql1[0][6]=$imagen.$imagen.$imagen.$imagen.$imagen;
                        break;
                    case 5:
                        break;
                }
                $informaciÃ³n= "<table cellpadding=\"2\" cellspacing=\"2\" align=\"center\" style=\"font-size:13px; border:1px solid #000;width:400px; max-width:600px;text-transform:uppercase\" >
					<tr>
		 			<td align='center' colspan='2'><img  width=\"180px\" src=\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata/admin/images/mdg1.png\"/></td>
					</tr>
					<tr>
		 			<td>CÃ“DIGO DE BÃšSQUEDA</td><td>".$sql1[0][0]."</td>
					</tr>
					<tr>
					<td>NOMBRE</td><td>".$sql1[0][1]."</td>
					</tr>
					<tr>
					<td>ESTADO ACTUAL</td><td>".$sql1[0][3]."</td>
					</tr>
					<tr>
					<td>IMPACTO</td><td>".$sql1[0][6]."</td>
					</tr>
					<tr>
					<td>AVANCE</td><td>".$sql1[0][5]." %</td>
					</tr>
					<tr>
					<td colspan=\"2\" style='border-bottom:1px solid #CCC'>&nbsp;</td>
					</tr>
					<tr>
					<td>ESTADO ANTIGUO</td><td>".$antiguo_estado[0][0]."</td>
					</tr>
					<tr>
					<td>ESTADO NUEVO</td><td>".$nuevo_estado[0][0]."</td>
					</tr>
					<tr>
					<td colspan=\"2\" style='border-bottom:1px solid #CCC'>&nbsp;</td>
					</tr>
					<tr>
		 			<td>LINK DE ACCESO AL SISTEMA</td><td><a href=\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata\">\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata\"</A></td>
					</tr>
		 		</table>";




                $rsqlpersona1=$_consulta_login->query(" select per_mail,(a.per_nombres::text || ' '::text) || a.per_apellidos::text AS nombre from aplicativo_web.aaw_persona a where  a.per_codigo='".$monitor."'  limit 1 ");


                if($responsable!=NULL){
                    $rsqlpersona=$_consulta_login->query(" select per_mail,(a.per_nombres::text || ' '::text) || a.per_apellidos::text AS nombre from aplicativo_web.aaw_persona a where  a.per_codigo='".$responsable."' limit 1 ");
                }else{
                    $rsqlpersona[0][0]=$rsqlpersona1[0][0];
                    $rsqlpersona[0][1]=$rsqlpersona1[0][1];
                }



                $mensajeConfirmacion ="<p style='font-size:13px!important; color:#000!important'>Estimad@ ". $rsqlpersona[0][1].",</p>";
                $mensajeConfirmacion.="<p style='font-size:13px!important; color:#000!important'>Se ha realizado un cambio de ESTADO sobre una actividad, la informaciÃ³n respectiva se presenta a continuaciÃ³n</p>";
                $mensajeConfirmacion.=$informaciÃ³n;
                $mensajeConfirmacion.="<p align=\"center\" style='font-size:15px!important; color:#000!important;'><br /><b>PROCESO AUTOMATIZADO DE SEGUIMIENTO - MDI <br/>2017</b></p>";


                $rs = $_consulta_sistema->query("SELECT a.per_mail FROM aplicativo_web.aaw_persona a,aplicativo_web.aaw_persona_perfil b where a.per_codigo=b.per_codigo and b.pus_codigo=41
                                            union
                                        select per_mail FROM aplicativo_web.aaw_persona_correos WHERE per_codigo={$responsable};");
                for($i=0;$i<count($rs);$i++){
                    $mail_copia[$i]=$rs[$i][0];
                }
                $envio_mail->envio_copia("seguimiento@mdi.gob.ec","SEGUIMIENTO MDI",$rsqlpersona[0][0],$rsqlpersona[0][1],"NUEVO CAMBIO DE ESTADO SOBRE ACTIVIDAD",$mensajeConfirmacion,$mail_copia);









            }

            $sql="UPDATE seguimiento_despacho_entrega.ssd_registro_seguimiento
					  SET rse_nombre='{$form_entrada['campo_ingreso_seguimientoDespacho_10']}',
       				  rse_fecha_fin='{$form_entrada['campo_ingreso_seguimientoDespacho_8']}', per_codigo_monitor='{$form_entrada['campo_ingreso_seguimientoDespacho_7']}',
       				  rse_detalle='{$form_entrada['campo_ingreso_seguimientoDespacho_11']}', rse_nota='{$form_entrada['campo_ingreso_seguimientoDespacho_13']}', tse_codigo='{$form_entrada['campo_ingreso_seguimientoDespacho_3']}', ose_codigo='{$form_entrada['campo_ingreso_seguimientoDespacho_6']}', ese_codigo='{$form_entrada['campo_ingreso_seguimientoDespacho_9']}',
       				  ise_codigo='{$form_entrada['campo_ingreso_seguimientoDespacho_4']}', ase_codigo='{$form_entrada['campo_ingreso_seguimientoDespacho_5']}'
 					  WHERE rse_codigo='{$form_entrada['campo_ingreso_seguimientoDespacho_0']}';";
            if($_consulta_sistema->query($sql)){
                /*$respuesta->addScript(" $.messager.show({ title:'ConfirmaciÃ³n',msg:'ActualizaciÃ³n Correcta.', timeout:20000, showType:'slide'}); ");*/

                switch($form_entrada['campo_ingreso_seguimientoDespacho_0_0']){
                    case "Visor":
                        $respuesta->addScript(" var p = $('#layoutBusquedaNormal_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Formulario.php?_id_registro_seguimiento=".$form_entrada['campo_ingreso_seguimientoDespacho_0']."'); ");
                        $respuesta->addScript(" $('#tblVisorBusqueda_seguimiento_despacho').datagrid('reload');  ");
                        break;
                    case "Calendario":
                        /* $respuesta->addScript(" var p = $('#layoutBusquedaNormal_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Formulario.php?_id_registro_seguimiento=".$form_entrada['campo_ingreso_seguimientoDespacho_0']."'); ");*/
                        /*$respuesta->addScript(" var p = $('#layoutResponsable_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Calendario.php'); ");*/
                        $respuesta->addScript(" var p = $('#layoutResponsable_calendario_seguimiento_despacho').layout('panel','west');
						p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."TblCalendario.php'); ");
                        $respuesta->addScript(" var p = $('#layoutResponsable_calendario_seguimiento_despacho').layout('panel','center');
						p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Formulario.php?_id_registro_seguimiento=".$form_entrada['campo_ingreso_seguimientoDespacho_0']."&_id_plantilla_seguimiento=".$form_entrada['campo_ingreso_seguimientoDespacho_0_0']."'); ");

                        break;



                }



                /* $respuesta->addScript(" var p = $('#layoutResponsable_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."visor.php');
                 $('#tblVisorBusqueda_seguimiento_despacho').datagrid('reload');
                  ");
                 $respuesta->addScript(" var p = $('#layoutBusquedaNormal_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Formulario.php?_id_registro_seguimiento=".$form_entrada['campo_ingreso_seguimientoDespacho_0']."'); ");*/

                return $respuesta ;
                exit();
            }
            break;

        case 0:

            $verificacion=0;
            $vacios=array("1"=>0,"2"=>0);
            for($i=3;$i<=11;$i++){
                if($form_entrada['campo_ingreso_seguimientoDespacho_'.$i]=="")
                    $vacios[$i]="1";
            }

            if(in_array("1",$vacios) ){
                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'Todos los campos son obligatorios, primero complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                return $respuesta ;
                exit;
            }



            $sql="insert into seguimiento_despacho_entrega.ssd_registro_seguimiento (rse_codigo,rse_nombre,rse_fecha_fin,per_codigo_monitor,rse_detalle,rse_nota,tse_codigo,ose_codigo,ese_codigo,ise_codigo,ase_codigo) values(default,'{$form_entrada['campo_ingreso_seguimientoDespacho_10']}','{$form_entrada['campo_ingreso_seguimientoDespacho_8']}','{$form_entrada['campo_ingreso_seguimientoDespacho_7']}','{$form_entrada['campo_ingreso_seguimientoDespacho_11']}','{$form_entrada['campo_ingreso_seguimientoDespacho_13']}','{$form_entrada['campo_ingreso_seguimientoDespacho_3']}', '{$form_entrada['campo_ingreso_seguimientoDespacho_6']}','{$form_entrada['campo_ingreso_seguimientoDespacho_9']}','{$form_entrada['campo_ingreso_seguimientoDespacho_4']}', '{$form_entrada['campo_ingreso_seguimientoDespacho_5']}');";
            if($_consulta_sistema->query($sql)){
                $codigo=$_consulta_sistema->query("select max(rse_codigo) from seguimiento_despacho_entrega.ssd_registro_seguimiento");
                $codigo=$codigo[0][0];


            }






            if(isset($form_entrada['campo_ingreso_seguimientoDespacho_1'])){
                $_consulta_sistema->query("INSERT INTO seguimiento_despacho_entrega.ssd_especial_registro_seguimiento(ers_codigo, rse_codigo, tes_codigo) VALUES (default,'{$codigo}',2); ");
            }
            if(isset($form_entrada['campo_ingreso_seguimientoDespacho_2'])){
                $_consulta_sistema->query("INSERT INTO seguimiento_despacho_entrega.ssd_especial_registro_seguimiento(ers_codigo, rse_codigo, tes_codigo) VALUES (default,'{$codigo}',1); ");
            }

            if(isset($form_entrada["campo_ingreso_seguimientoDespacho_12"]) && $form_entrada["campo_ingreso_seguimientoDespacho_12"]!=NULL){

                $_consulta_sistema->query("INSERT INTO seguimiento_despacho_entrega.ssd_avance_registro_seguimiento( ars_codigo, rse_codigo, ars_avance, ars_fecha) VALUES (default, '{$codigo}', '{$form_entrada['campo_ingreso_seguimientoDespacho_12']}', now() ); ");
            }

            $respuesta->addScript(" $.messager.show({ title:'ConfirmaciÃ³n',msg:'Ingreso Correcta.', timeout:20000, showType:'slide'}); ");
            /*$respuesta->addScript(" var p = $('#layoutResponsable_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Formulario.php?_id_registro_seguimiento=".$codigo."'); ");*/
            $respuesta->addScript(" var p = $('#layoutResponsable_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."visor.php'); ");

            return $respuesta ;
            exit;

            break;

    }


}



function procesar_frm_fichaantecedentes_seguimientoDespacho($form_entrada){
    require_once dirname(dirname(dirname(__FILE__)))."/config.php";
    $respuesta = new xajaxResponse();
    $_consulta_sistema=new conexion_sistema();
    $_consulta_login=new conexion();
    $update="0";
    if(isset($form_entrada["campo_antecedentes_seguimientoDespacho_0"]) && $form_entrada["campo_antecedentes_seguimientoDespacho_0"]!=NULL){
        $update="1";
    }

    switch($update){

        case 1:




            $verificacion=0;
            $vacios=array("1"=>0,"2"=>0);
            for($i=1;$i<=2;$i++){
                if($form_entrada['campo_antecedentes_seguimientoDespacho_'.$i]=="")
                    $vacios[$i]="1";
            }

            if(in_array("1",$vacios) ){
                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'Todos los campos son obligatorios, primero complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                return $respuesta ;
                exit;
            }

            $sql="

				INSERT INTO seguimiento_despacho_entrega.ssd_antecedentes_registro_seguimiento(
            anr_codigo, rse_codigo, anr_antecedente, anr_fecha)
    VALUES (default,'{$form_entrada['campo_antecedentes_seguimientoDespacho_0']}' , '{$form_entrada['campo_antecedentes_seguimientoDespacho_1']}' , '{$form_entrada['campo_antecedentes_seguimientoDespacho_2']}' );

				";
            if($_consulta_sistema->query($sql)){
                $respuesta->addScript(" $.messager.show({ title:'ConfirmaciÃ³n',msg:'ActualizaciÃ³n Correcta.', timeout:20000, showType:'slide'}); ");


                switch($form_entrada['campo_antecedentes_seguimientoDespacho_0_0']){
                    case "Visor":
                        $respuesta->addScript(" var p = $('#layoutBusquedaNormal_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Formulario.php?_id_registro_seguimiento=".$form_entrada['campo_antecedentes_seguimientoDespacho_0']."'); ");
                        $respuesta->addScript(" $('#tblVisorBusqueda_seguimiento_despacho').datagrid('reload');  ");
                        break;
                    case "Calendario":
                        /* $respuesta->addScript(" var p = $('#layoutBusquedaNormal_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Formulario.php?_id_registro_seguimiento=".$form_entrada['campo_ingreso_seguimientoDespacho_0']."'); ");*/
                        /*$respuesta->addScript(" var p = $('#layoutResponsable_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Calendario.php'); ");*/
                        $respuesta->addScript(" var p = $('#layoutResponsable_calendario_seguimiento_despacho').layout('panel','west');
						p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."TblCalendario.php'); ");
                        $respuesta->addScript(" var p = $('#layoutResponsable_calendario_seguimiento_despacho').layout('panel','center');
						p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Formulario.php?_id_registro_seguimiento=".$form_entrada['campo_antecedentes_seguimientoDespacho_0']."&_id_plantilla_seguimiento=".$form_entrada['campo_antecedentes_seguimientoDespacho_0_0']."'); ");

                        break;
                }




                /*$respuesta->addScript(" var p = $('#layoutBusquedaNormal_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Formulario.php?_id_registro_seguimiento=".$form_entrada['campo_antecedentes_seguimientoDespacho_0']."');
               $('#tblVisorBusqueda_seguimiento_despacho').datagrid('reload');
                ");*/
                return $respuesta ;
                exit();
            }
            break;

        case 0:

            $verificacion=0;
            $vacios=array("1"=>0,"2"=>0);
            for($i=3;$i<=11;$i++){
                if($form_entrada['campo_ingreso_seguimientoDespacho_'.$i]=="")
                    $vacios[$i]="1";
            }

            if(in_array("1",$vacios) ){
                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'Todos los campos son obligatorios, primero complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                return $respuesta ;
                exit;
            }



            $sql="insert into seguimiento_despacho_entrega.ssd_registro_seguimiento (rse_codigo,rse_nombre,rse_fecha_fin,per_codigo_monitor,rse_detalle,rse_nota,tse_codigo,ose_codigo,ese_codigo,ise_codigo,ase_codigo) values(default,'{$form_entrada['campo_ingreso_seguimientoDespacho_10']}','{$form_entrada['campo_ingreso_seguimientoDespacho_8']}','{$form_entrada['campo_ingreso_seguimientoDespacho_7']}','{$form_entrada['campo_ingreso_seguimientoDespacho_11']}','{$form_entrada['campo_ingreso_seguimientoDespacho_13']}','{$form_entrada['campo_ingreso_seguimientoDespacho_3']}', '{$form_entrada['campo_ingreso_seguimientoDespacho_6']}','{$form_entrada['campo_ingreso_seguimientoDespacho_9']}','{$form_entrada['campo_ingreso_seguimientoDespacho_4']}', '{$form_entrada['campo_ingreso_seguimientoDespacho_5']}');";
            if($_consulta_sistema->query($sql)){
                $codigo=$_consulta_sistema->query("select max(rse_codigo) from seguimiento_despacho_entrega.ssd_registro_seguimiento");
                $codigo=$codigo[0][0];


            }






            if(isset($form_entrada['campo_ingreso_seguimientoDespacho_1'])){
                $_consulta_sistema->query("INSERT INTO seguimiento_despacho_entrega.ssd_especial_registro_seguimiento(ers_codigo, rse_codigo, tes_codigo) VALUES (default,'{$codigo}',2); ");
            }
            if(isset($form_entrada['campo_ingreso_seguimientoDespacho_2'])){
                $_consulta_sistema->query("INSERT INTO seguimiento_despacho_entrega.ssd_especial_registro_seguimiento(ers_codigo, rse_codigo, tes_codigo) VALUES (default,'{$codigo}',1); ");
            }

            if(isset($form_entrada["campo_ingreso_seguimientoDespacho_12"]) && $form_entrada["campo_ingreso_seguimientoDespacho_12"]!=NULL){

                $_consulta_sistema->query("INSERT INTO seguimiento_despacho_entrega.ssd_avance_registro_seguimiento( ars_codigo, rse_codigo, ars_avance, ars_fecha) VALUES (default, '{$codigo}', '{$form_entrada['campo_ingreso_seguimientoDespacho_12']}', now() ); ");
            }

            $respuesta->addScript(" $.messager.show({ title:'ConfirmaciÃ³n',msg:'Ingreso Correcta.', timeout:20000, showType:'slide'}); ");
            $respuesta->addScript(" var p = $('#layoutResponsable_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."visor.php?_id_registro_seguimiento=".$codigo."'); ");


            return $respuesta ;
            exit;

            break;

    }


}



function procesar_frm_fichaavances_seguimientoDespacho($form_entrada){
    require_once dirname(dirname(dirname(__FILE__)))."/config.php";
    //$CIFRADO=new Cifrador();
    //$_id=2;
    if(isset($_SESSION['logueado'])){
        $_id= $_SESSION['Usuid'] ;
        $perfil = $_SESSION['Perid'] ;
    }

    $respuesta = new xajaxResponse();
    $_consulta_sistema=new conexion_sistema();
    $_consulta_login=new conexion();

    require_once CLA_MAIL;
    $envio_mail=new envio_mail;


    $update="0";
    if(isset($form_entrada["campo_avances_seguimientoDespacho_0"]) && $form_entrada["campo_avances_seguimientoDespacho_0"]!=NULL){
        $update="1";
    }

    switch($update){

        case 1:




            $verificacion=0;
            $vacios=array("1"=>0,"2"=>0);
            for($i=1;$i<=2;$i++){
                if($form_entrada['campo_avances_seguimientoDespacho_'.$i]=="")
                    $vacios[$i]="1";
            }

            if(in_array("1",$vacios) ){
                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'Todos los campos son obligatorios, primero complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                return $respuesta ;
                exit;
            }

            /*$validar_avance=$_consulta_sistema->query("select count(*) from seguimiento_despacho_entrega.ssd_avances_registro_seguimiento where rse_codigo='{$form_entrada['campo_avances_seguimientoDespacho_0']}'; ");
            if($validar_avance[0][0]==0){
                $_consulta_sistema->query("update seguimiento_despacho_entrega.ssd_registro_seguimiento set ese_codigo=2 where rse_codigo='{$form_entrada['campo_avances_seguimientoDespacho_0']}'; ");

            }*/


            if ($perfil==40 || $perfil==41 ){
                $sql="INSERT INTO seguimiento_despacho_entrega.ssd_avances_registro_seguimiento(avr_codigo, rse_codigo, avr_avance, ase_codigo, per_codigo_escrito,
                    avr_fecha_escrito,era_codigo,per_codigo_revision,avr_fecha_revision) VALUES (default, '{$form_entrada['campo_avances_seguimientoDespacho_0']}', '{$form_entrada['campo_avances_seguimientoDespacho_1']}',
                     '{$form_entrada['campo_avances_seguimientoDespacho_2']}', '{$_id}',now(),2, '{$_id}',now() );";
                $_consulta_sistema->query("update seguimiento_despacho_entrega.ssd_registro_seguimiento set ese_codigo=2 where rse_codigo='{$form_entrada['campo_avances_seguimientoDespacho_0']}'; ");
            }else{
                $sql="INSERT INTO seguimiento_despacho_entrega.ssd_avances_registro_seguimiento(avr_codigo, rse_codigo, avr_avance, ase_codigo, per_codigo_escrito,
                    avr_fecha_escrito) VALUES (default, '{$form_entrada['campo_avances_seguimientoDespacho_0']}', '{$form_entrada['campo_avances_seguimientoDespacho_1']}',
                     '{$form_entrada['campo_avances_seguimientoDespacho_2']}', '{$_id}',now() );";

            }


            if($_consulta_sistema->query($sql)){
                $respuesta->addScript(" $.messager.show({ title:'ConfirmaciÃ³n',msg:'ActualizaciÃ³n Correcta.', timeout:20000, showType:'slide'}); ");


                switch($form_entrada['campo_avances_seguimientoDespacho_0_0']){
                    case "Visor":
                        $respuesta->addScript(" var p = $('#layoutBusquedaNormal_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Formulario.php?_id_registro_seguimiento=".$form_entrada['campo_avances_seguimientoDespacho_0']."'); ");
                        $respuesta->addScript(" $('#tblVisorBusqueda_seguimiento_despacho').datagrid('reload');  ");
                        break;
                    case "Calendario":
                        /* $respuesta->addScript(" var p = $('#layoutBusquedaNormal_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Formulario.php?_id_registro_seguimiento=".$form_entrada['campo_ingreso_seguimientoDespacho_0']."'); ");*/
                        /*$respuesta->addScript(" var p = $('#layoutResponsable_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Calendario.php'); ");*/
                        $respuesta->addScript(" var p = $('#layoutResponsable_calendario_seguimiento_despacho').layout('panel','west');
						p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."TblCalendario.php'); ");
                        $respuesta->addScript(" var p = $('#layoutResponsable_calendario_seguimiento_despacho').layout('panel','center');
						p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Formulario.php?_id_registro_seguimiento=".$form_entrada['campo_avances_seguimientoDespacho_0']."&_id_plantilla_seguimiento=".$form_entrada['campo_avances_seguimientoDespacho_0_0']."'); ");

                        break;
                }

                /*$respuesta->addScript(" var p = $('#layoutBusquedaNormal_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Formulario.php?_id_registro_seguimiento=".$form_entrada['campo_avances_seguimientoDespacho_0']."');
               $('#tblVisorBusqueda_seguimiento_despacho').datagrid('reload');
                ");*/


                $_consulta_sistema->query("update  seguimiento_despacho_entrega.ssd_registro_seguimiento  set ase_codigo='{$form_entrada['campo_avances_seguimientoDespacho_2']}' where rse_codigo='{$form_entrada['campo_avances_seguimientoDespacho_0']}' ");
                $sql=$_consulta_sistema->query("SELECT a.rse_codigo,a.rse_nombre,a.rse_fecha_fin,b.ese_nombre,c.ise_nombre,d.ase_nombre,a.ise_codigo,a.per_codigo_responsable,a.per_codigo_monitor
  FROM seguimiento_despacho_entrega.ssd_registro_seguimiento a
  left join seguimiento_despacho_entrega.ssd_estado_seguimiento b on a.ese_codigo=b.ese_codigo
  left join seguimiento_despacho_entrega.ssd_impacto_seguimiento c on a.ise_codigo=c.ise_codigo
  left join seguimiento_despacho_entrega.ssd_avance_seguimiento d on a.ase_codigo=d.ase_codigo
 where a.rse_codigo='{$form_entrada['campo_avances_seguimientoDespacho_0']}' limit 1");

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
                if ($perfil==40 || $perfil==41 ){
                    $informaciÃ³n= "<table cellpadding=\"2\" cellspacing=\"2\" align=\"center\" style=\"font-size:13px; border:1px solid #000; width:400px; max-width:600px; text-transform:uppercase\" >
					<tr>
		 			<td align='center' colspan='2'><img  width=\"180px\" src=\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata/admin/images/mdg1.png\"/></td>
					</tr>
					<tr>
		 			<td>CÃ“DIGO DE BÃšSQUEDA</td><td>".$sql[0][0]."</td>
					</tr>
					<tr>
					<td>NOMBRE</td><td>".$sql[0][1]."</td>
					</tr>
					<tr>
					<td>FECHA DE FINALIZACIÃ“N</td><td>".FechaFormateada2(strtotime($sql[0][2]))."</td>
					</tr>
					<tr>
					<td>ESTADO ACTUAL</td><td>".$sql[0][3]."</td>
					</tr>
					<tr>
					<td>IMPACTO</td><td>".$sql[0][6]."</td>
					</tr>
					<tr>
					<td colspan=\"2\" style='border-bottom:1px solid #CCC'>&nbsp;</td>
					</tr>
					<tr>
					<td>AVANCE APROBADO</td><td>".$form_entrada['campo_avances_seguimientoDespacho_1']."</td>
					</tr>
					<tr>
					<td>AVANCE</td><td>".$sql[0][5]." %</td>
					</tr>
					<tr>
					<td colspan=\"2\" style='border-bottom:1px solid #CCC'>&nbsp;</td>
					</tr>
					<tr>
		 			<td>LINK DE ACCESO AL SISTEMA</td><td><a href=\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata\">\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata\"</A></td>
					</tr>
		 		    </table>";
                }else{
                    $informaciÃ³n= "<table cellpadding=\"2\" cellspacing=\"2\" align=\"center\" style=\"font-size:13px; border:1px solid #000; width:400px; max-width:600px; text-transform:uppercase\" >
					<tr>
		 			<td align='center' colspan='2'><img  width=\"180px\" src=\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata/admin/images/mdg1.png\"/></td>
					</tr>
					<tr>
		 			<td>CÃ“DIGO DE BÃšSQUEDA</td><td>".$sql[0][0]."</td>
					</tr>
					<tr>
					<td>NOMBRE</td><td>".$sql[0][1]."</td>
					</tr>
					<tr>
					<td>FECHA DE FINALIZACIÃ“N</td><td>".FechaFormateada2(strtotime($sql[0][2]))."</td>
					</tr>
					<tr>
					<td>ESTADO ACTUAL</td><td>".$sql[0][3]."</td>
					</tr>
					<tr>
					<td>IMPACTO</td><td>".$sql[0][6]."</td>
					</tr>
					<tr>
					<td colspan=\"2\" style='border-bottom:1px solid #CCC'>&nbsp;</td>
					</tr>
					<tr>
					<td>REPORTE DE AVANCE INGRESADO</td><td>".$form_entrada['campo_avances_seguimientoDespacho_2']."</td>
					</tr>
					<tr>
					<td>AVANCE</td><td>".$sql[0][5]." %</td>
					</tr>
					<tr>
					<td colspan=\"2\" style='border-bottom:1px solid #CCC'>&nbsp;</td>
					</tr>
					<tr>
		 			<td>LINK DE ACCESO AL SISTEMA</td><td><a href=\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata\">\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata\"</A></td>
					</tr>
		 		    </table>";
                }
                if($sql[0][7]!=NULL){
                    $rsqlpersona=$_consulta_login->query(" select per_mail,(a.per_nombres::text || ' '::text) || a.per_apellidos::text AS nombre from aplicativo_web.aaw_persona a where  a.per_codigo='{$sql[0][7]}' limit 1 ");
                }else{
                    $rsqlpersona[0][0]="";
                    $rsqlpersona[0][1]="";
                }
                $rsqlpersona1=$_consulta_login->query(" select per_mail,(a.per_nombres::text || ' '::text) || a.per_apellidos::text AS nombre from aplicativo_web.aaw_persona a where  a.per_codigo='{$sql[0][8]}' limit 1 ");

                $mensajeConfirmacion ="<p style='font-size:13px!important; color:#000!important'>Estimad@ ". $rsqlpersona[0][1].",</p>";
                $mensajeConfirmacion.="<p style='font-size:13px!important; color:#000!important'>Se registrÃ³ un nuevo avance sobre una actividad, la informaciÃ³n respectiva se presenta a continuaciÃ³n</p>";
                $mensajeConfirmacion.=$informaciÃ³n;
                $mensajeConfirmacion.="<p align=\"center\" style='font-size:15px!important; color:#000!important;'><br /><b>PROCESO AUTOMATIZADO DE SEGUIMIENTO - MDI <br/>2017</b></p>";
                $rs = $_consulta_sistema->query("SELECT a.per_mail FROM aplicativo_web.aaw_persona a,aplicativo_web.aaw_persona_perfil b where a.per_codigo=b.per_codigo and b.pus_codigo=41
                                        union
                                        select per_mail FROM aplicativo_web.aaw_persona_correos WHERE per_codigo={$sql[0][7]};");
                for($i=0;$i<count($rs);$i++){
                    $mail_copia[$i]=$rs[$i][0];
                }
                if ($perfil==40 || $perfil==41 ){
                    $envio_mail->envio_copia("seguimiento@mdi.gob.ec","SEGUIMIENTO MDI",$rsqlpersona[0][0],$rsqlpersona[0][1],"NUEVO AVANCE APROBADO SOBRE ACTIVIDAD",$mensajeConfirmacion,$mail_copia);
                }else{
                    $envio_mail->envio_copia("seguimiento@mdi.gob.ec","SEGUIMIENTO MDI",$rsqlpersona[0][0],$rsqlpersona[0][1],"NUEVA AVANCE REGISTRADO SOBRE ACTIVIDAD",$mensajeConfirmacion,$mail_copia);
                }

                return $respuesta ;
                exit();
            }
            break;

        case 0:

            $verificacion=0;
            $vacios=array("1"=>0,"2"=>0);
            for($i=3;$i<=11;$i++){
                if($form_entrada['campo_ingreso_seguimientoDespacho_'.$i]=="")
                    $vacios[$i]="1";
            }

            if(in_array("1",$vacios) ){
                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'Todos los campos son obligatorios, primero complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                return $respuesta ;
                exit;
            }



            $sql="insert into seguimiento_despacho_entrega.ssd_registro_seguimiento (rse_codigo,rse_nombre,rse_fecha_fin,per_codigo_monitor,rse_detalle,rse_nota,tse_codigo,ose_codigo,ese_codigo,ise_codigo,ase_codigo) values(default,'{$form_entrada['campo_ingreso_seguimientoDespacho_10']}','{$form_entrada['campo_ingreso_seguimientoDespacho_8']}','{$form_entrada['campo_ingreso_seguimientoDespacho_7']}','{$form_entrada['campo_ingreso_seguimientoDespacho_11']}','{$form_entrada['campo_ingreso_seguimientoDespacho_13']}','{$form_entrada['campo_ingreso_seguimientoDespacho_3']}', '{$form_entrada['campo_ingreso_seguimientoDespacho_6']}','{$form_entrada['campo_ingreso_seguimientoDespacho_9']}','{$form_entrada['campo_ingreso_seguimientoDespacho_4']}', '{$form_entrada['campo_ingreso_seguimientoDespacho_5']}');";
            if($_consulta_sistema->query($sql)){
                $codigo=$_consulta_sistema->query("select max(rse_codigo) from seguimiento_despacho_entrega.ssd_registro_seguimiento");
                $codigo=$codigo[0][0];


            }






            if(isset($form_entrada['campo_ingreso_seguimientoDespacho_1'])){
                $_consulta_sistema->query("INSERT INTO seguimiento_despacho_entrega.ssd_especial_registro_seguimiento(ers_codigo, rse_codigo, tes_codigo) VALUES (default,'{$codigo}',2); ");
            }
            if(isset($form_entrada['campo_ingreso_seguimientoDespacho_2'])){
                $_consulta_sistema->query("INSERT INTO seguimiento_despacho_entrega.ssd_especial_registro_seguimiento(ers_codigo, rse_codigo, tes_codigo) VALUES (default,'{$codigo}',1); ");
            }

            if(isset($form_entrada["campo_ingreso_seguimientoDespacho_12"]) && $form_entrada["campo_ingreso_seguimientoDespacho_12"]!=NULL){

                $_consulta_sistema->query("INSERT INTO seguimiento_despacho_entrega.ssd_avance_registro_seguimiento( ars_codigo, rse_codigo, ars_avance, ars_fecha) VALUES (default, '{$codigo}', '{$form_entrada['campo_ingreso_seguimientoDespacho_12']}', now() ); ");
            }

            $respuesta->addScript(" $.messager.show({ title:'ConfirmaciÃ³n',msg:'Ingreso Correcta.', timeout:20000, showType:'slide'}); ");
            $respuesta->addScript(" var p = $('#layoutResponsable_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."visor.php?_id_registro_seguimiento=".$codigo."'); ");


            return $respuesta ;
            exit;

            break;

    }


}




function procesar_frm_fichamensajes_seguimientoDespacho($form_entrada){
    require_once dirname(dirname(dirname(__FILE__)))."/config.php";
    //$CIFRADO=new Cifrador();
    //$_id=2;
    if(isset($_SESSION['logueado'])){
        $_id= $_SESSION['Usuid'] ;
        $perfil = $_SESSION['Perid'] ;
    }
    $respuesta = new xajaxResponse();
    $_consulta_sistema=new conexion_sistema();
    $_consulta_login=new conexion();
    require_once CLA_MAIL;
    $envio_mail=new envio_mail;
    $update="0";
    if(isset($form_entrada["campo_mensajes_seguimientoDespacho_0"]) && $form_entrada["campo_mensajes_seguimientoDespacho_0"]!=NULL){
        $update="1";
    }

    switch($update){

        case 1:




            $verificacion=0;
            $vacios=array("1"=>0,"2"=>0);
            for($i=1;$i<=1;$i++){
                if($form_entrada['campo_mensajes_seguimientoDespacho_'.$i]=="")
                    $vacios[$i]="1";
            }

            if(in_array("1",$vacios) ){
                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'Todos los campos son obligatorios, primero complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                return $respuesta ;
                exit;
            }
            if ($perfil==40 || $perfil==41 ){
                $sql="INSERT INTO seguimiento_despacho_entrega.ssd_mensaje_registro_seguimiento(mrs_codigo, rse_codigo, mrs_mensaje, per_codigo_escrito, mrs_fecha_escrito,era_codigo,per_codigo_revision,mrs_fecha_revision)
                    VALUES (default, '{$form_entrada['campo_mensajes_seguimientoDespacho_0']}', '{$form_entrada['campo_mensajes_seguimientoDespacho_1']}', '{$_id}', now(),6, '{$_id}',now() );";
            }else{
                $sql="INSERT INTO seguimiento_despacho_entrega.ssd_mensaje_registro_seguimiento(mrs_codigo, rse_codigo, mrs_mensaje, per_codigo_escrito, mrs_fecha_escrito)
                    VALUES (default, '{$form_entrada['campo_mensajes_seguimientoDespacho_0']}', '{$form_entrada['campo_mensajes_seguimientoDespacho_1']}', '{$_id}', now() );";
            }
            if($_consulta_sistema->query($sql)){
                $respuesta->addScript(" $.messager.show({ title:'ConfirmaciÃ³n',msg:'ActualizaciÃ³n Correcta.', timeout:20000, showType:'slide'}); ");


                switch($form_entrada['campo_mensajes_seguimientoDespacho_0_0']){
                    case "Visor":
                        $respuesta->addScript(" var p = $('#layoutBusquedaNormal_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Formulario.php?_id_registro_seguimiento=".$form_entrada['campo_mensajes_seguimientoDespacho_0']."'); ");
                        $respuesta->addScript(" $('#tblVisorBusqueda_seguimiento_despacho').datagrid('reload');  ");
                        break;
                    case "Calendario":
                        /* $respuesta->addScript(" var p = $('#layoutBusquedaNormal_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Formulario.php?_id_registro_seguimiento=".$form_entrada['campo_ingreso_seguimientoDespacho_0']."'); ");*/
                        /*$respuesta->addScript(" var p = $('#layoutResponsable_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Calendario.php'); ");*/
                        $respuesta->addScript(" var p = $('#layoutResponsable_calendario_seguimiento_despacho').layout('panel','west');
						p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."TblCalendario.php'); ");
                        $respuesta->addScript(" var p = $('#layoutResponsable_calendario_seguimiento_despacho').layout('panel','center');
						p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Formulario.php?_id_registro_seguimiento=".$form_entrada['campo_mensajes_seguimientoDespacho_0']."&_id_plantilla_seguimiento=".$form_entrada['campo_mensajes_seguimientoDespacho_0_0']."'); ");

                        break;
                }

                /*$respuesta->addScript(" var p = $('#layoutBusquedaNormal_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Formulario.php?_id_registro_seguimiento=".$form_entrada['campo_mensajes_seguimientoDespacho_0']."');
               $('#tblVisorBusqueda_seguimiento_despacho').datagrid('reload');		");

               */



                $sql=$_consulta_sistema->query("SELECT a.rse_codigo,a.rse_nombre,a.rse_fecha_fin,b.ese_nombre,c.ise_nombre,d.ase_nombre,a.ise_codigo,a.per_codigo_responsable,a.per_codigo_monitor
  FROM seguimiento_despacho_entrega.ssd_registro_seguimiento a
  left join seguimiento_despacho_entrega.ssd_estado_seguimiento b on a.ese_codigo=b.ese_codigo
  left join seguimiento_despacho_entrega.ssd_impacto_seguimiento c on a.ise_codigo=c.ise_codigo
  left join seguimiento_despacho_entrega.ssd_avance_seguimiento d on a.ase_codigo=d.ase_codigo
 where a.rse_codigo='{$form_entrada['campo_mensajes_seguimientoDespacho_0']}' limit 1");
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
                if ($perfil==40 || $perfil==41 ){
                    $informaciÃ³n= "<table cellpadding=\"2\" cellspacing=\"2\" align=\"center\" style=\"font-size:13px; border:1px solid #000; width:400px; max-width:600px; text-transform:uppercase\" >
                        <tr>
                        <td align='center' colspan='2'><img  width=\"180px\" src=\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata/admin/images/mdg1.png\"/></td>
                        </tr>
                        <tr>
                        <td>CÃ“DIGO DE BÃšSQUEDA</td><td>".$sql[0][0]."</td>
                        </tr>
                        <tr>
                        <td>NOMBRE</td><td>".$sql[0][1]."</td>
                        </tr>
                        <tr>
                        <td>FECHA DE FINALIZACIÃ“N</td><td>".FechaFormateada2(strtotime($sql[0][2]))."</td>
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
                        <tr>
                        <td colspan=\"2\" style='border-bottom:1px solid #CCC'>&nbsp;</td>
                        </tr>
                        <tr>
                        <td>MENSAJE</td><td>".$form_entrada['campo_mensajes_seguimientoDespacho_1']."</td>
                        </tr>
                        <tr>
                        <td colspan=\"2\" style='border-bottom:1px solid #CCC'>&nbsp;</td>
                        </tr>
                        <tr>
                        <td>LINK DE ACCESO AL SISTEMA</td><td><a href=\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata\">\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata\"</A></td>
                        </tr>
                        </table>";
                }else{
                    $informaciÃ³n= "<table cellpadding=\"2\" cellspacing=\"2\" align=\"center\" style=\"font-size:13px; border:1px solid #000; width:400px; max-width:600px; text-transform:uppercase\" >
                        <tr>
                        <td align='center' colspan='2'><img  width=\"180px\" src=\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata/admin/images/mdg1.png\"/></td>
                        </tr>
                        <tr>
                        <td>CÃ“DIGO DE BÃšSQUEDA</td><td>".$sql[0][0]."</td>
                        </tr>
                        <tr>
                        <td>NOMBRE</td><td>".$sql[0][1]."</td>
                        </tr>
                        <tr>
                        <td>FECHA DE FINALIZACIÃ“N</td><td>".FechaFormateada2(strtotime($sql[0][2]))."</td>
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
                        <tr>
                        <td colspan=\"2\" style='border-bottom:1px solid #CCC'>&nbsp;</td>
                        </tr>
                        <tr>
                        <td>MENSAJE INGRESADO</td><td>".$form_entrada['campo_mensajes_seguimientoDespacho_1']."</td>
                        </tr>
                        <tr>
                        <td colspan=\"2\" style='border-bottom:1px solid #CCC'>&nbsp;</td>
                        </tr>
                        <tr>
                        <td>LINK DE ACCESO AL SISTEMA</td><td><a href=\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata\">\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata\"</A></td>
                        </tr>
                        </table>";
                }
                if($sql[0][7]!=NULL){
                    $rsqlpersona=$_consulta_login->query(" select per_mail,(a.per_nombres::text || ' '::text) || a.per_apellidos::text AS nombre from aplicativo_web.aaw_persona a where  a.per_codigo='{$sql[0][7]}' limit 1 ");
                }else{
                    $rsqlpersona[0][0]="";
                    $rsqlpersona[0][1]="";
                }
                $rsqlpersona1=$_consulta_login->query(" select per_mail,(a.per_nombres::text || ' '::text) || a.per_apellidos::text AS nombre from aplicativo_web.aaw_persona a where  a.per_codigo='{$sql[0][8]}' limit 1 ");

                $mensajeConfirmacion ="<p style='font-size:13px!important; color:#000!important'>Estimad@ ". $rsqlpersona[0][1].",</p>";
                $mensajeConfirmacion.="<p style='font-size:13px!important; color:#000!important'>Se registrÃ³ un nuevo mensaje sobre una actividad, la informaciÃ³n respectiva se presenta a continuaciÃ³n</p>";
                $mensajeConfirmacion.=$informaciÃ³n;
                $mensajeConfirmacion.="<p align=\"center\" style='font-size:15px!important; color:#000!important;'><br /><b>PROCESO AUTOMATIZADO DE SEGUIMIENTO - MDI <br/>2017</b></p>";
                $rs = $_consulta_sistema->query("SELECT a.per_mail FROM aplicativo_web.aaw_persona a,aplicativo_web.aaw_persona_perfil b where a.per_codigo=b.per_codigo and b.pus_codigo=41
                                        union
                                        select per_mail FROM aplicativo_web.aaw_persona_correos WHERE per_codigo={$sql[0][7]};");
                for($i=0;$i<count($rs);$i++){
                    $mail_copia[$i]=$rs[$i][0];
                }
                if ($perfil==40 || $perfil==41 ){
                    $envio_mail->envio_copia("seguimiento@mdi.gob.ec","SEGUIMIENTO MDI",$rsqlpersona[0][0],$rsqlpersona[0][1],"NUEVO MENSAJE SOBRE ACTIVIDAD",$mensajeConfirmacion,$mail_copia);
                }else{
                    $envio_mail->envio_copia("seguimiento@mdi.gob.ec","SEGUIMIENTO MDI",$rsqlpersona[0][0],$rsqlpersona[0][1],"NUEVO MENSAJE SOBRE ACTIVIDAD",$mensajeConfirmacion,$mail_copia);
                }

                return $respuesta ;
                exit();
            }
            break;

        case 0:

            $verificacion=0;
            $vacios=array("1"=>0,"2"=>0);
            for($i=3;$i<=11;$i++){
                if($form_entrada['campo_ingreso_seguimientoDespacho_'.$i]=="")
                    $vacios[$i]="1";
            }

            if(in_array("1",$vacios) ){
                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'Todos los campos son obligatorios, primero complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                return $respuesta ;
                exit;
            }



            $sql="insert into seguimiento_despacho_entrega.ssd_registro_seguimiento (rse_codigo,rse_nombre,rse_fecha_fin,per_codigo_monitor,rse_detalle,rse_nota,tse_codigo,ose_codigo,ese_codigo,ise_codigo,ase_codigo) values(default,'{$form_entrada['campo_ingreso_seguimientoDespacho_10']}','{$form_entrada['campo_ingreso_seguimientoDespacho_8']}','{$form_entrada['campo_ingreso_seguimientoDespacho_7']}','{$form_entrada['campo_ingreso_seguimientoDespacho_11']}','{$form_entrada['campo_ingreso_seguimientoDespacho_13']}','{$form_entrada['campo_ingreso_seguimientoDespacho_3']}', '{$form_entrada['campo_ingreso_seguimientoDespacho_6']}','{$form_entrada['campo_ingreso_seguimientoDespacho_9']}','{$form_entrada['campo_ingreso_seguimientoDespacho_4']}', '{$form_entrada['campo_ingreso_seguimientoDespacho_5']}');";
            if($_consulta_sistema->query($sql)){
                $codigo=$_consulta_sistema->query("select max(rse_codigo) from seguimiento_despacho_entrega.ssd_registro_seguimiento");
                $codigo=$codigo[0][0];


            }






            if(isset($form_entrada['campo_ingreso_seguimientoDespacho_1'])){
                $_consulta_sistema->query("INSERT INTO seguimiento_despacho_entrega.ssd_especial_registro_seguimiento(ers_codigo, rse_codigo, tes_codigo) VALUES (default,'{$codigo}',2); ");
            }
            if(isset($form_entrada['campo_ingreso_seguimientoDespacho_2'])){
                $_consulta_sistema->query("INSERT INTO seguimiento_despacho_entrega.ssd_especial_registro_seguimiento(ers_codigo, rse_codigo, tes_codigo) VALUES (default,'{$codigo}',1); ");
            }

            if(isset($form_entrada["campo_ingreso_seguimientoDespacho_12"]) && $form_entrada["campo_ingreso_seguimientoDespacho_12"]!=NULL){

                $_consulta_sistema->query("INSERT INTO seguimiento_despacho_entrega.ssd_avance_registro_seguimiento( ars_codigo, rse_codigo, ars_avance, ars_fecha) VALUES (default, '{$codigo}', '{$form_entrada['campo_ingreso_seguimientoDespacho_12']}', now() ); ");
            }

            $respuesta->addScript(" $.messager.show({ title:'ConfirmaciÃ³n',msg:'Ingreso Correcta.', timeout:20000, showType:'slide'}); ");
            $respuesta->addScript(" var p = $('#layoutResponsable_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."visor.php?_id_registro_seguimiento=".$codigo."'); ");


            return $respuesta ;
            exit;

            break;

    }


}

function procesar_frm_fichaarchivos_seguimientoDespacho($form_entrada){
    require_once dirname(dirname(dirname(__FILE__)))."/config.php";
    $respuesta = new xajaxResponse();
    $_consulta_sistema=new conexion_sistema();
    $_consulta_login=new conexion();
    //$CIFRADO=new Cifrador();

    require_once CLA_MAIL;
    $envio_mail=new envio_mail;


    //$_id=2;
    if(isset($_SESSION['logueado'])){
        $_id= $_SESSION['Usuid'] ;
    }

    $update="0";
    if(isset($form_entrada["campo_archivos_seguimientoDespacho_0"]) && $form_entrada["campo_archivos_seguimientoDespacho_0"]!=NULL){
        $update="1";
    }

    switch($update){

        case 1:

            $contador=$form_entrada["contadorfoto_archivos_seguimiento_despacho"];

            for($i=1;$i<=$contador;$i++){
                if(isset($form_entrada['foto_archivos_seguimiento_despacho_'.$i])){
                    $sql="INSERT INTO seguimiento_despacho_entrega.ssd_archivo_registro_seguimiento(
					arr_codigo, rse_codigo, arr_ruta, per_codigo_cargado, arr_fecha_cargado,
					arr_nombre) VALUES (default, '{$form_entrada['campo_archivos_seguimientoDespacho_0']}', '".DIR_REL."src/anexos/seguimiento_despacho/".$form_entrada['foto_archivos_seguimiento_despacho_'.$i]."', '{$_id}', now(), '".$form_entrada['foto_old_seguimiento_despacho_'.$i]."');
		";
                    $_consulta_sistema->query($sql);
                }

            }
            $respuesta->addScript(" $.messager.show({ title:'ConfirmaciÃ³n',msg:'ActualizaciÃ³n Correcta.', timeout:20000, showType:'slide'}); ");


            switch($form_entrada['campo_archivos_seguimientoDespacho_0_0']){
                case "Visor":
                    $respuesta->addScript(" var p = $('#layoutBusquedaNormal_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Formulario.php?_id_registro_seguimiento=".$form_entrada['campo_archivos_seguimientoDespacho_0']."'); ");
                    $respuesta->addScript(" $('#tblVisorBusqueda_seguimiento_despacho').datagrid('reload');  ");
                    break;
                case "Calendario":
                    /* $respuesta->addScript(" var p = $('#layoutBusquedaNormal_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Formulario.php?_id_registro_seguimiento=".$form_entrada['campo_ingreso_seguimientoDespacho_0']."'); ");*/
                    /*$respuesta->addScript(" var p = $('#layoutResponsable_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Calendario.php'); ");*/
                    $respuesta->addScript(" var p = $('#layoutResponsable_calendario_seguimiento_despacho').layout('panel','west');
						p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."TblCalendario.php'); ");
                    $respuesta->addScript(" var p = $('#layoutResponsable_calendario_seguimiento_despacho').layout('panel','center');
						p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Formulario.php?_id_registro_seguimiento=".$form_entrada['campo_archivos_seguimientoDespacho_0']."&_id_plantilla_seguimiento=".$form_entrada['campo_archivos_seguimientoDespacho_0_0']."'); ");

                    break;
            }




            $sql=$_consulta_sistema->query("SELECT a.rse_codigo,a.rse_nombre,a.rse_fecha_fin,b.ese_nombre,c.ise_nombre,d.ase_nombre,a.ise_codigo,a.per_codigo_responsable,a.per_codigo_monitor
  FROM seguimiento_despacho_entrega.ssd_registro_seguimiento a
  left join seguimiento_despacho_entrega.ssd_estado_seguimiento b on a.ese_codigo=b.ese_codigo
  left join seguimiento_despacho_entrega.ssd_impacto_seguimiento c on a.ise_codigo=c.ise_codigo
  left join seguimiento_despacho_entrega.ssd_avance_seguimiento d on a.ase_codigo=d.ase_codigo
 where a.rse_codigo='{$form_entrada['campo_archivos_seguimientoDespacho_0']}' limit 1");
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
            $informaciÃ³n= "<table cellpadding=\"2\" cellspacing=\"2\" align=\"center\" style=\"font-size:13px; border:1px solid #000; width:400px; max-width:600px; text-transform:uppercase\" >
					<tr>
		 			<td align='center' colspan='2'><img  width=\"180px\" src=\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata/admin/images/mdg1.png\"/></td>
					</tr>
					<tr>
		 			<td>CÃ“DIGO DE BÃšSQUEDA</td><td>".$sql[0][0]."</td>
					</tr>
					<tr>
					<td>NOMBRE</td><td>".$sql[0][1]."</td>
					</tr>
					<tr>
					<td>FECHA DE FINALIZACIÃ“N</td><td>".FechaFormateada2(strtotime($sql[0][2]))."</td>
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
					<tr>
					<td colspan=\"2\" style='border-bottom:1px solid #CCC'>&nbsp;</td>
					</tr>
					<tr>
					<td>NOMBRE DEL ARCHIVO</td><td>".$form_entrada['foto_old_seguimiento_despacho_1']."</td>
					</tr>
					<tr>
					<td colspan=\"2\" style='border-bottom:1px solid #CCC'>&nbsp;</td>
					</tr>
					<tr>
		 			<td>LINK DE ACCESO AL SISTEMA</td><td><a href=\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata\">\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata\"</A></td>
					</tr>
		 		</table>";
            if($sql[0][7]!=NULL){
                $rsqlpersona=$_consulta_login->query(" select per_mail,(a.per_nombres::text || ' '::text) || a.per_apellidos::text AS nombre from aplicativo_web.aaw_persona a where  a.per_codigo='{$sql[0][7]}' limit 1 ");
            }else{
                $rsqlpersona[0][0]="";
                $rsqlpersona[0][1]="";
            }
            $rsqlpersona1=$_consulta_login->query(" select per_mail,(a.per_nombres::text || ' '::text) || a.per_apellidos::text AS nombre from aplicativo_web.aaw_persona a where  a.per_codigo='{$sql[0][8]}' limit 1 ");

            $mensajeConfirmacion ="<p style='font-size:13px!important; color:#000!important'>Estimad@ ". $rsqlpersona[0][1].",</p>";
            $mensajeConfirmacion.="<p style='font-size:13px!important; color:#000!important'>Se registrÃ³ un nuevo archivo cargado sobre una actividad, la informaciÃ³n respectiva se presenta a continuaciÃ³n</p>";
            $mensajeConfirmacion.=$informaciÃ³n;
            $mensajeConfirmacion.="<p align=\"center\" style='font-size:15px!important; color:#000!important;'><br /><b>PROCESO AUTOMATIZADO DE SEGUIMIENTO - MDI <br/>2017</b></p>";
            $rs = $_consulta_sistema->query("SELECT a.per_mail FROM aplicativo_web.aaw_persona a,aplicativo_web.aaw_persona_perfil b where a.per_codigo=b.per_codigo and b.pus_codigo=41
                                        union
                                        select per_mail FROM aplicativo_web.aaw_persona_correos WHERE per_codigo={$sql[0][7]};");
            for($i=0;$i<count($rs);$i++){
                $mail_copia[$i]=$rs[$i][0];
            }
            $envio_mail->envio_copia("seguimiento@mdi.gob.ec","SEGUIMIENTO MDI",$rsqlpersona[0][0],$rsqlpersona[0][1],"NUEVO ARCHIVO CARGADO SOBRE ACTIVIDAD",$mensajeConfirmacion,$mail_copia);







            /*
           $respuesta->addScript(" var p = $('#layoutBusquedaNormal_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Formulario.php?_id_registro_seguimiento=".$form_entrada['campo_archivos_seguimientoDespacho_0']."');
         $('#tblVisorBusqueda_seguimiento_despacho').datagrid('reload');		");*/
            return $respuesta ;
            exit();


            break;
        case 0:

            $respuesta->addAlert("no");
            return $respuesta;
            exit;

            break;
    }


}


function procesar_frm_fichaparticipantes_seguimientoDespacho($form_entrada){
    require_once dirname(dirname(dirname(__FILE__)))."/config.php";
    $respuesta = new xajaxResponse();
    $_consulta_sistema=new conexion_sistema();
    $_consulta_login=new conexion();

    require_once CLA_MAIL;
    $envio_mail=new envio_mail;


    $update="0";
    if(isset($form_entrada["campo_participantes_seguimientoDespacho_0"]) && $form_entrada["campo_participantes_seguimientoDespacho_0"]!=NULL){
        $update="1";
    }

    switch($update){

        case 1:




            $verificacion=0;
            $vacios=array("1"=>0,"2"=>0);
            for($i=1;$i<=2;$i++){
                if($form_entrada['campo_participantes_seguimientoDespacho_'.$i]=="")
                    $vacios[$i]="1";
            }

            if(in_array("1",$vacios) ){
                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'Todos los campos son obligatorios, primero complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                return $respuesta ;
                exit;
            }

            switch($form_entrada['campo_participantes_seguimientoDespacho_2']){
                case 1:

                    $sql="
					INSERT INTO seguimiento_despacho_entrega.ssd_corresponsable_seguimiento(
				cse_codigo, rse_codigo, per_codigo_corresponsable)
		VALUES (default, '{$form_entrada['campo_participantes_seguimientoDespacho_0']}', '{$form_entrada['campo_participantes_seguimientoDespacho_1']}');

					";

                    if($_consulta_sistema->query($sql)){
                        $respuesta->addScript(" $.messager.show({ title:'ConfirmaciÃ³n',msg:'ActualizaciÃ³n Correcta.', timeout:20000, showType:'slide'}); ");

                        switch($form_entrada['campo_participantes_seguimientoDespacho_0_0']){
                            case "Visor":
                                $respuesta->addScript(" var p = $('#layoutBusquedaNormal_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Formulario.php?_id_registro_seguimiento=".$form_entrada['campo_participantes_seguimientoDespacho_0']."'); ");
                                $respuesta->addScript(" $('#tblVisorBusqueda_seguimiento_despacho').datagrid('reload');  ");
                                break;
                            case "Calendario":
                                /* $respuesta->addScript(" var p = $('#layoutBusquedaNormal_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Formulario.php?_id_registro_seguimiento=".$form_entrada['campo_ingreso_seguimientoDespacho_0']."'); ");*/
                                /*$respuesta->addScript(" var p = $('#layoutResponsable_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Calendario.php'); ");*/
                                $respuesta->addScript(" var p = $('#layoutResponsable_calendario_seguimiento_despacho').layout('panel','west');
						p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."TblCalendario.php'); ");
                                $respuesta->addScript(" var p = $('#layoutResponsable_calendario_seguimiento_despacho').layout('panel','center');
						p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Formulario.php?_id_registro_seguimiento=".$form_entrada['campo_participantes_seguimientoDespacho_0']."&_id_plantilla_seguimiento=".$form_entrada['campo_participantes_seguimientoDespacho_0_0']."'); ");

                                break;
                        }

                        $sql=$_consulta_sistema->query("SELECT a.rse_codigo,a.rse_nombre,a.rse_fecha_fin,b.ese_nombre,c.ise_nombre,d.ase_nombre,a.ise_codigo
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
                        $informaciÃ³n= "<table cellpadding=\"2\" cellspacing=\"2\" align=\"center\" style=\"font-size:13px; border:1px solid #000;width:400px; max-width:600px;text-transform:uppercase\" >
					<tr>
		 			<td align='center' colspan='2'><img  width=\"180px\" src=\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata/admin/images/mdg1.png\"/></td>
					</tr>
					<tr>
		 			<td>CÃ“DIGO DE BÃšSQUEDA</td><td>".$sql[0][0]."</td>
					</tr>
					<tr>
					<td>NOMBRE</td><td>".$sql[0][1]."</td>
					</tr>
					<tr>
					<td>FECHA DE FINALIZACIÃ“N</td><td>".FechaFormateada2(strtotime($sql[0][2]))."</td>
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
					<tr>
					<td colspan=\"2\" style='border-bottom:1px solid #CCC'>&nbsp;</td>
					</tr>
					<tr>
		 			<td>LINK DE ACCESO AL SISTEMA</td><td><a href=\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata\">\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata\"</A></td>
					</tr>
		 		</table>";

                        $rsqlpersona=$_consulta_login->query(" select per_mail,(a.per_nombres::text || ' '::text) || a.per_apellidos::text AS nombre from aplicativo_web.aaw_persona a where  a.per_codigo='{$form_entrada['campo_participantes_seguimientoDespacho_1']}' limit 1 ");

                        $mensajeConfirmacion ="<p style='font-size:13px!important; color:#000!important'>Estimad@ ". $rsqlpersona[0][1].",</p>";
                        $mensajeConfirmacion.="<p style='font-size:13px!important; color:#000!important'>Se asignÃ³ una nueva actividad como CORRESPONSABLE, la informaciÃ³n respectiva se presenta a continuaciÃ³n</p>";
                        $mensajeConfirmacion.=$informaciÃ³n;
                        $mensajeConfirmacion.="<p align=\"center\" style='font-size:15px!important; color:#000!important;'><br /><b>PROCESO AUTOMATIZADO DE SEGUIMIENTO - MDI <br/>2017</b></p>";


                        $rs = $_consulta_sistema->query("SELECT a.per_mail FROM aplicativo_web.aaw_persona a,aplicativo_web.aaw_persona_perfil b where a.per_codigo=b.per_codigo and b.pus_codigo=41
                                        union
                                        select per_mail FROM aplicativo_web.aaw_persona_correos WHERE per_codigo={$form_entrada['campo_participantes_seguimientoDespacho_1']};");
                        for($i=0;$i<count($rs);$i++){
                            $mail_copia[$i]=$rs[$i][0];
                        }
                        $envio_mail->envio_copia("seguimiento@mdi.gob.ec","SEGUIMIENTO MDI",$rsqlpersona[0][0],$rsqlpersona[0][1],"NUEVA ASIGNACIÃ“N DE CORRESPONSABLE DE ACTIVIDAD",$mensajeConfirmacion,$mail_copia);

                        // $envio_mail->envio("intranet@administracionpublica.gob.ec","INTRANET SNAP","jonatan.diaz@administracionpublica.gob.ec","Jonatan DÃ­az","NUEVA ASIGNACIÃ“N DE RESPONSABLE DE ACTIVIDAD",$mensajeConfirmacion,"","",""," "," ","","");


                        /*$respuesta->addScript(" var p = $('#layoutBusquedaNormal_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Formulario.php?_id_registro_seguimiento=".$form_entrada['campo_participantes_seguimientoDespacho_0']."');
                   $('#tblVisorBusqueda_seguimiento_despacho').datagrid('reload');
                    ");*/
                        return $respuesta ;
                        exit();
                    }

                    break;
                case 2:

                    $sql="
				INSERT INTO seguimiento_despacho_entrega.ssd_participante_seguimiento(
            pse_codigo, rse_codigo, per_codigo_participante)
    VALUES (default, '{$form_entrada['campo_participantes_seguimientoDespacho_0']}', '{$form_entrada['campo_participantes_seguimientoDespacho_1']}');


				";
                    if($_consulta_sistema->query($sql)){
                        $respuesta->addScript(" $.messager.show({ title:'ConfirmaciÃ³n',msg:'ActualizaciÃ³n Correcta.', timeout:20000, showType:'slide'}); ");
                        switch($form_entrada['campo_participantes_seguimientoDespacho_0_0']){
                            case "Visor":
                                $respuesta->addScript(" var p = $('#layoutBusquedaNormal_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Formulario.php?_id_registro_seguimiento=".$form_entrada['campo_participantes_seguimientoDespacho_0']."'); ");
                                $respuesta->addScript(" $('#tblVisorBusqueda_seguimiento_despacho').datagrid('reload');  ");
                                break;
                            case "Calendario":
                                /* $respuesta->addScript(" var p = $('#layoutBusquedaNormal_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Formulario.php?_id_registro_seguimiento=".$form_entrada['campo_ingreso_seguimientoDespacho_0']."'); ");*/
                                /*$respuesta->addScript(" var p = $('#layoutResponsable_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Calendario.php'); ");*/
                                $respuesta->addScript(" var p = $('#layoutResponsable_calendario_seguimiento_despacho').layout('panel','west');
						p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."TblCalendario.php'); ");
                                $respuesta->addScript(" var p = $('#layoutResponsable_calendario_seguimiento_despacho').layout('panel','center');
						p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Formulario.php?_id_registro_seguimiento=".$form_entrada['campo_participantes_seguimientoDespacho_0']."&_id_plantilla_seguimiento=".$form_entrada['campo_participantes_seguimientoDespacho_0_0']."'); ");

                                break;
                        }


                        $sql=$_consulta_sistema->query("SELECT a.rse_codigo,a.rse_nombre,a.rse_fecha_fin,b.ese_nombre,c.ise_nombre,d.ase_nombre,a.ise_codigo
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
                        $informaciÃ³n= "<table cellpadding=\"2\" cellspacing=\"2\" align=\"center\" style=\"font-size:13px; border:1px solid #000; width:400px; max-width:600px; text-transform:uppercase\" >
					<tr>
		 			<td align='center' colspan='2'><img  width=\"180px\" src=\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata/admin/images/mdg1.png\"/></td>
					</tr>
					<tr>
		 			<td>CÃ“DIGO DE BÃšSQUEDA</td><td>".$sql[0][0]."</td>
					</tr>
					<tr>
					<td>NOMBRE</td><td>".$sql[0][1]."</td>
					</tr>
					<tr>
					<td>FECHA DE FINALIZACIÃ“N</td><td>".FechaFormateada2(strtotime($sql[0][2]))."</td>
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
					<tr>
					<td colspan=\"2\" style='border-bottom:1px solid #CCC'>&nbsp;</td>
					</tr>
					<tr>
		 			<td>LINK DE ACCESO AL SISTEMA</td><td><a href=\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata\">\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata\"</A></td>
					</tr>
		 		</table>";

                        $rsqlpersona=$_consulta_login->query(" select per_mail,(a.per_nombres::text || ' '::text) || a.per_apellidos::text AS nombre from aplicativo_web.aaw_persona a where  a.per_codigo='{$form_entrada['campo_participantes_seguimientoDespacho_1']}' limit 1 ");

                        $mensajeConfirmacion ="<p style='font-size:13px!important; color:#000!important'>Estimad@ ". $rsqlpersona[0][1].",</p>";
                        $mensajeConfirmacion.="<p style='font-size:13px!important; color:#000!important'>Se asignÃ³ una nueva actividad como PARTICIPANTE, la informaciÃ³n respectiva se presenta a continuaciÃ³n</p>";
                        $mensajeConfirmacion.=$informaciÃ³n;
                        $mensajeConfirmacion.="<p align=\"center\" style='font-size:15px!important; color:#000!important;'><br /><b>PROCESO AUTOMATIZADO DE SEGUIMIENTO - MDI <br/>2017</b></p>";

                        $rs = $_consulta_sistema->query("SELECT a.per_mail FROM aplicativo_web.aaw_persona a,aplicativo_web.aaw_persona_perfil b where a.per_codigo=b.per_codigo and b.pus_codigo=41
                                        union
                                        select per_mail FROM aplicativo_web.aaw_persona_correos WHERE per_codigo={$form_entrada['campo_participantes_seguimientoDespacho_1']};");
                        for($i=0;$i<count($rs);$i++){
                            $mail_copia[$i]=$rs[$i][0];
                        }
                        $envio_mail->envio_copia("seguimiento@mdi.gob.ec","SEGUIMIENTO MDI",$rsqlpersona[0][0],$rsqlpersona[0][1],"NUEVA ASIGNACIÃ“N DE PARTICIPANTE DE ACTIVIDAD",$mensajeConfirmacion,$mail_copia);

                        // $envio_mail->envio("intranet@administracionpublica.gob.ec","INTRANET SNAP","jonatan.diaz@administracionpublica.gob.ec","Jonatan DÃ­az","NUEVA ASIGNACIÃ“N DE RESPONSABLE DE ACTIVIDAD",$mensajeConfirmacion,"","",""," "," ","","");


                        /*$respuesta->addScript(" var p = $('#layoutBusquedaNormal_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Formulario.php?_id_registro_seguimiento=".$form_entrada['campo_participantes_seguimientoDespacho_0']."');
                   $('#tblVisorBusqueda_seguimiento_despacho').datagrid('reload');
                    ");*/
                        return $respuesta ;
                        exit();
                    }

                    break;
                case 3:

                    $sql="
					UPDATE seguimiento_despacho_entrega.ssd_registro_seguimiento
	   SET per_codigo_responsable='{$form_entrada['campo_participantes_seguimientoDespacho_1']}' WHERE rse_codigo='{$form_entrada['campo_participantes_seguimientoDespacho_0']}';


					";

                    if($_consulta_sistema->query($sql)){
                        $respuesta->addScript(" $.messager.show({ title:'ConfirmaciÃ³n',msg:'ActualizaciÃ³n Correcta.', timeout:20000, showType:'slide'}); ");

                        switch($form_entrada['campo_participantes_seguimientoDespacho_0_0']){
                            case "Visor":
                                $respuesta->addScript(" var p = $('#layoutBusquedaNormal_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Formulario.php?_id_registro_seguimiento=".$form_entrada['campo_participantes_seguimientoDespacho_0']."'); ");
                                $respuesta->addScript(" $('#tblVisorBusqueda_seguimiento_despacho').datagrid('reload');  ");
                                break;
                            case "Calendario":
                                /* $respuesta->addScript(" var p = $('#layoutBusquedaNormal_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Formulario.php?_id_registro_seguimiento=".$form_entrada['campo_ingreso_seguimientoDespacho_0']."'); ");*/
                                /*$respuesta->addScript(" var p = $('#layoutResponsable_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Calendario.php'); ");*/
                                $respuesta->addScript(" var p = $('#layoutResponsable_calendario_seguimiento_despacho').layout('panel','west');
							p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."TblCalendario.php'); ");
                                $respuesta->addScript(" var p = $('#layoutResponsable_calendario_seguimiento_despacho').layout('panel','center');
							p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Formulario.php?_id_registro_seguimiento=".$form_entrada['campo_participantes_seguimientoDespacho_0']."&_id_plantilla_seguimiento=".$form_entrada['campo_participantes_seguimientoDespacho_0_0']."'); ");

                                break;
                        }

                        /*$respuesta->addScript(" var p = $('#layoutBusquedaNormal_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Formulario.php?_id_registro_seguimiento=".$form_entrada['campo_participantes_seguimientoDespacho_0']."');
                   $('#tblVisorBusqueda_seguimiento_despacho').datagrid('reload');
                    ");	*/

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
                        $informaciÃ³n= "<table cellpadding=\"2\" cellspacing=\"2\" align=\"center\" style=\"font-size:13px; border:1px solid #000; width:400px; max-width:600px; text-transform:uppercase\" >
					<tr>
		 			<td align='center' colspan='2'><img  width=\"180px\" src=\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata/admin/images/mdg1.png\"/></td>
					</tr>
					<tr>
		 			<td>CÃ“DIGO DE BÃšSQUEDA</td><td>".$sql[0][0]."</td>
					</tr>
					<tr>
					<td>NOMBRE</td><td>".$sql[0][1]."</td>
					</tr>
					<tr>
					<td>FECHA DE FINALIZACIÃ“N</td><td>".FechaFormateada2(strtotime($sql[0][2]))."</td>
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
					<tr>
					<td colspan=\"2\" style='border-bottom:1px solid #CCC'>&nbsp;</td>
					</tr>
					<tr>
		 			<td>LINK DE ACCESO AL SISTEMA</td><td><a href=\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata\">\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata\"</A></td>
					</tr>
		 		</table>";

                        $rsqlpersona=$_consulta_login->query(" select per_mail,(a.per_nombres::text || ' '::text) || a.per_apellidos::text AS nombre from aplicativo_web.aaw_persona a where  a.per_codigo='{$form_entrada['campo_participantes_seguimientoDespacho_1']}' limit 1 ");

                        $mensajeConfirmacion ="<p style='font-size:13px!important; color:#000!important'>Estimad@ ". $rsqlpersona[0][1].",</p>";
                        $mensajeConfirmacion.="<p style='font-size:13px!important; color:#000!important'>Se asignÃ³ una nueva actividad como RESPONSABLE, la informaciÃ³n respectiva se presenta a continuaciÃ³n</p>";
                        $mensajeConfirmacion.=$informaciÃ³n;
                        $mensajeConfirmacion.="<p align=\"center\" style='font-size:15px!important; color:#000!important;'><br /><b>PROCESO AUTOMATIZADO DE SEGUIMIENTO - MDI <br/>2017</b></p>";

                        $monito=$_consulta_login->query(" select per_mail,(a.per_nombres::text || ' '::text) || a.per_apellidos::text AS nombre from aplicativo_web.aaw_persona a where  a.per_codigo='{$sql[0][7]}' limit 1 ");
                        $rs = $_consulta_sistema->query("SELECT a.per_mail FROM aplicativo_web.aaw_persona a,aplicativo_web.aaw_persona_perfil b where a.per_codigo=b.per_codigo and b.pus_codigo=41
                                        union
                                        select per_mail FROM aplicativo_web.aaw_persona_correos WHERE per_codigo={$form_entrada['campo_participantes_seguimientoDespacho_1']};");
                        for($i=0;$i<count($rs);$i++){
                            $mail_copia[$i]=$rs[$i][0];
                        }
                        $envio_mail->envio_copia("seguimiento@mdi.gob.ec","SEGUIMIENTO MDI",$rsqlpersona[0][0],$rsqlpersona[0][1],"NUEVA ASIGNACIÃ“N DE RESPONSABLE DE ACTIVIDAD # {$sql[0][0]} ",$mensajeConfirmacion,$mail_copia);

                        // $envio_mail->envio("intranet@administracionpublica.gob.ec","INTRANET SNAP","jonatan.diaz@administracionpublica.gob.ec","Jonatan DÃ­az","NUEVA ASIGNACIÃ“N DE RESPONSABLE DE ACTIVIDAD",$mensajeConfirmacion,"","",""," "," ","","");



                        return $respuesta ;
                        exit();
                    }

                    break;
            }









            if($_consulta_sistema->query($sql)){
                $respuesta->addScript(" $.messager.show({ title:'ConfirmaciÃ³n',msg:'ActualizaciÃ³n Correcta.', timeout:20000, showType:'slide'}); ");
                $respuesta->addScript(" var p = $('#layoutResponsable_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."visor.php?_id_registro_seguimiento=1'); ");
                return $respuesta ;
                exit();
            }
            break;

        case 0:

            $verificacion=0;
            $vacios=array("1"=>0,"2"=>0);
            for($i=3;$i<=11;$i++){
                if($form_entrada['campo_ingreso_seguimientoDespacho_'.$i]=="")
                    $vacios[$i]="1";
            }

            if(in_array("1",$vacios) ){
                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'Todos los campos son obligatorios, primero complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                return $respuesta ;
                exit;
            }



            $sql="insert into seguimiento_despacho_entrega.ssd_registro_seguimiento (rse_codigo,rse_nombre,rse_fecha_fin,per_codigo_monitor,rse_detalle,rse_nota,tse_codigo,ose_codigo,ese_codigo,ise_codigo,ase_codigo) values(default,'{$form_entrada['campo_ingreso_seguimientoDespacho_10']}','{$form_entrada['campo_ingreso_seguimientoDespacho_8']}','{$form_entrada['campo_ingreso_seguimientoDespacho_7']}','{$form_entrada['campo_ingreso_seguimientoDespacho_11']}','{$form_entrada['campo_ingreso_seguimientoDespacho_13']}','{$form_entrada['campo_ingreso_seguimientoDespacho_3']}', '{$form_entrada['campo_ingreso_seguimientoDespacho_6']}','{$form_entrada['campo_ingreso_seguimientoDespacho_9']}','{$form_entrada['campo_ingreso_seguimientoDespacho_4']}', '{$form_entrada['campo_ingreso_seguimientoDespacho_5']}');";
            if($_consulta_sistema->query($sql)){
                $codigo=$_consulta_sistema->query("select max(rse_codigo) from seguimiento_despacho_entrega.ssd_registro_seguimiento");
                $codigo=$codigo[0][0];


            }






            if(isset($form_entrada['campo_ingreso_seguimientoDespacho_1'])){
                $_consulta_sistema->query("INSERT INTO seguimiento_despacho_entrega.ssd_especial_registro_seguimiento(ers_codigo, rse_codigo, tes_codigo) VALUES (default,'{$codigo}',2); ");
            }
            if(isset($form_entrada['campo_ingreso_seguimientoDespacho_2'])){
                $_consulta_sistema->query("INSERT INTO seguimiento_despacho_entrega.ssd_especial_registro_seguimiento(ers_codigo, rse_codigo, tes_codigo) VALUES (default,'{$codigo}',1); ");
            }

            if(isset($form_entrada["campo_ingreso_seguimientoDespacho_12"]) && $form_entrada["campo_ingreso_seguimientoDespacho_12"]!=NULL){

                $_consulta_sistema->query("INSERT INTO seguimiento_despacho_entrega.ssd_avance_registro_seguimiento( ars_codigo, rse_codigo, ars_avance, ars_fecha) VALUES (default, '{$codigo}', '{$form_entrada['campo_ingreso_seguimientoDespacho_12']}', now() ); ");
            }

            $respuesta->addScript(" $.messager.show({ title:'ConfirmaciÃ³n',msg:'Ingreso Correcta.', timeout:20000, showType:'slide'}); ");
            $respuesta->addScript(" var p = $('#layoutResponsable_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."visor.php?_id_registro_seguimiento=".$codigo."'); ");


            return $respuesta ;
            exit;

            break;

    }


}



function procesar_frm_fichagrafica_seguimientoDespacho($form_entrada){
    require_once dirname(dirname(dirname(__FILE__)))."/config.php";
    $respuesta = new xajaxResponse();
    $_consulta_sistema=new conexion_sistema();
    $_consulta_login=new conexion();
    $update="0";

    if($form_entrada["campo_grafica_seguimientoDespacho_1"]==NULL && $form_entrada["campo_grafica_seguimientoDespacho_2"]==NULL){
        $respuesta->addScript(" $.messager.show({ title:'Error',msg:'Todos los campos son obligatorios, primero complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
        return $respuesta ;
        exit;
    }
    if($form_entrada["campo_grafica_seguimientoDespacho_1"]>$form_entrada["campo_grafica_seguimientoDespacho_2"]){
        $respuesta->addScript(" $.messager.show({ title:'Error',msg:'Fecha Desde debe ser menor que la Fecha Hasta.', timeout:20000, showType:'slide'}); ");
        return $respuesta ;
        exit;
    }
    $respuesta->addScript(" $.messager.show({ title:'ConfirmaciÃ³n',msg:'GrÃ¡fica Generada.', timeout:20000, showType:'slide'}); ");
    $respuesta->addScript(" var p = $('#layoutResponsable_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Grafica.php?_id_iniciografica_seguimiento_despacho=".$form_entrada["campo_grafica_seguimientoDespacho_1"]."&_id_fingrafica_seguimiento_despacho=".$form_entrada["campo_grafica_seguimientoDespacho_2"]."&_id_tipografica_seguimiento_despacho'); ");


    return $respuesta ;
    exit;

}



function procesar_frm_fichareporte_seguimientoDespacho($form_entrada){
    require_once dirname(dirname(dirname(__FILE__)))."/config.php";
    $respuesta = new xajaxResponse();
    $_consulta_sistema=new conexion_sistema();
    $_consulta_login=new conexion();
    $update="0";

    if($form_entrada["campo_reporte_seguimientoDespacho_1"]==NULL && $form_entrada["campo_reporte_seguimientoDespacho_2"]==NULL){
        $respuesta->addScript(" $.messager.show({ title:'Error',msg:'Todos los campos son obligatorios, primero complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
        return $respuesta ;
        exit;
    }
    if($form_entrada["campo_reporte_seguimientoDespacho_1"]>$form_entrada["campo_reporte_seguimientoDespacho_2"]){
        $respuesta->addScript(" $.messager.show({ title:'Error',msg:'Fecha Desde debe ser menor que la Fecha Hasta.', timeout:20000, showType:'slide'}); ");
        return $respuesta ;
        exit;
    }
    $respuesta->addScript(" $.messager.show({ title:'ConfirmaciÃ³n',msg:'GrÃ¡fica Generada.', timeout:20000, showType:'slide'}); ");
    $respuesta->addScript(" var p = $('#layoutResponsable_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Reporte.php?_id_inicioreporte_seguimiento_despacho=".$form_entrada["campo_reporte_seguimientoDespacho_1"]."&_id_finreporte_seguimiento_despacho=".$form_entrada["campo_reporte_seguimientoDespacho_2"]."&_id_tiporeporte_seguimiento_despacho'); ");


    return $respuesta ;
    exit;

}

function procesar_frm_fichaavance_revision_seguimientoDespacho($form_entrada){
    require_once dirname(dirname(dirname(__FILE__)))."/config.php";
    //$CIFRADO=new Cifrador();
    //$_id=2;
    if(isset($_SESSION['logueado'])){
        $_id= $_SESSION['Usuid'] ;
    }
    $respuesta = new xajaxResponse();
    $_consulta_sistema=new conexion_sistema();
    $_consulta_login=new conexion();
    require_once CLA_MAIL;
    $envio_mail=new envio_mail;



    if($form_entrada["campo_avance_revision_seguimientoDespacho_0"]==NULL && $form_entrada["campo_avance_revision_seguimientoDespacho_1"]==NULL && $form_entrada["campo_avance_revision_seguimientoDespacho_2"]==NULL){
        $respuesta->addScript(" $.messager.show({ title:'Error',msg:'Todos los campos son obligatorios, primero complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
        return $respuesta ;
        exit;
    }

    switch($form_entrada["campo_avance_revision_seguimientoDespacho_2"]){
        case 1:
            $sql="update seguimiento_despacho_entrega.ssd_avances_registro_seguimiento set  era_codigo=1,per_codigo_revision='{$_id}',avr_fecha_revision=now()  where rse_codigo='{$form_entrada['campo_avance_revision_seguimientoDespacho_0']}' and  avr_codigo ='{$form_entrada['campo_avance_revision_seguimientoDespacho_1']}' ";
            break;
        case 2:
            $sql="update seguimiento_despacho_entrega.ssd_avances_registro_seguimiento set  era_codigo=2,per_codigo_revision='{$_id}',avr_fecha_revision=now()  where rse_codigo='{$form_entrada['campo_avance_revision_seguimientoDespacho_0']}' and  avr_codigo ='{$form_entrada['campo_avance_revision_seguimientoDespacho_1']}' ";

            $_consulta_sistema->query("update seguimiento_despacho_entrega.ssd_registro_seguimiento set ese_codigo=2 where (ese_codigo!=7 or ese_codigo!=8 ) and rse_codigo='{$form_entrada['campo_avance_revision_seguimientoDespacho_0']}' ");
            break;
        case 3:
            $sql="update seguimiento_despacho_entrega.ssd_avances_registro_seguimiento set  era_codigo=3,per_codigo_revision='{$_id}',avr_fecha_revision=now()  where rse_codigo='{$form_entrada['campo_avance_revision_seguimientoDespacho_0']}' and  avr_codigo ='{$form_entrada['campo_avance_revision_seguimientoDespacho_1']}' ";
            break;
        case 4:
            $sql="update seguimiento_despacho_entrega.ssd_avances_registro_seguimiento set  era_codigo=4,per_codigo_revision='{$_id}',avr_fecha_revision=now()  where rse_codigo='{$form_entrada['campo_avance_revision_seguimientoDespacho_0']}' and  avr_codigo='{$form_entrada['campo_avance_revision_seguimientoDespacho_1']}'";
            break;
    }


    if($_consulta_sistema->query($sql)){
        $respuesta->addScript(" $.messager.show({ title:'ConfirmaciÃ³n',msg:'ActualizaciÃ³n Correcta.', timeout:20000, showType:'slide'}); ");
        $respuesta->addScript(" var p = $('#layoutBusquedaNormal_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Formulario.php?_id_registro_seguimiento=".$form_entrada['campo_avance_revision_seguimientoDespacho_0']."');
				   $('#tblVisorBusqueda_seguimiento_despacho').datagrid('reload');
				    ");
    }


    switch($form_entrada["campo_avance_revision_seguimientoDespacho_2"]){
        case 1:
            $titulo="SIN REVISAR";
            break;
        case 2:
            $titulo="APROBADO";
            break;
        case 3:
            $titulo="RECHAZADO";
            break;
        case 4:
            $titulo="ELIMINADO";
            break;
    }

    $sql=$_consulta_sistema->query("SELECT a.rse_codigo,a.rse_nombre,a.rse_fecha_fin,b.ese_nombre,c.ise_nombre,d.ase_nombre,a.ise_codigo,a.per_codigo_responsable,a.per_codigo_monitor
  FROM seguimiento_despacho_entrega.ssd_registro_seguimiento a
  left join seguimiento_despacho_entrega.ssd_estado_seguimiento b on a.ese_codigo=b.ese_codigo
  left join seguimiento_despacho_entrega.ssd_impacto_seguimiento c on a.ise_codigo=c.ise_codigo
  left join seguimiento_despacho_entrega.ssd_avance_seguimiento d on a.ase_codigo=d.ase_codigo
 where a.rse_codigo='{$form_entrada['campo_avance_revision_seguimientoDespacho_0']}' limit 1");
    $consulta=$_consulta_sistema->query("select avr_avance from  seguimiento_despacho_entrega.ssd_avances_registro_seguimiento where avr_codigo='{$form_entrada['campo_avance_revision_seguimientoDespacho_1']}' limit 1  ");
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
    $informaciÃ³n= "<table cellpadding=\"2\" cellspacing=\"2\" align=\"center\" style=\"font-size:13px; border:1px solid #000; width:400px; max-width:600px; text-transform:uppercase\" >
					<tr>
		 			<td align='center' colspan='2'><img  width=\"180px\" src=\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata/admin/images/mdg1.png\"/></td>
					</tr>
					<tr>
		 			<td>CÃ“DIGO DE BÃšSQUEDA</td><td>".$sql[0][0]."</td>
					</tr>
					<tr>
					<td>NOMBRE</td><td>".$sql[0][1]."</td>
					</tr>
					<tr>
					<td>FECHA DE FINALIZACIÃ“N</td><td>".FechaFormateada2(strtotime($sql[0][2]))."</td>
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
					<tr>
					<td colspan=\"2\" style='border-bottom:1px solid #CCC'>&nbsp;</td>
					</tr>
					<tr>
					<td>AVANCE ".$titulo."</td><td>".$consulta[0][0]."</td>
					</tr>
					<tr>
					<td colspan=\"2\" style='border-bottom:1px solid #CCC'>&nbsp;</td>
					</tr>
					<tr>
		 			<td>LINK DE ACCESO AL SISTEMA</td><td><a href=\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata\">\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata\"</A></td>
					</tr>
		 		</table>";
    if($sql[0][7]!=NULL){
        $rsqlpersona=$_consulta_login->query(" select per_mail,(a.per_nombres::text || ' '::text) || a.per_apellidos::text AS nombre from aplicativo_web.aaw_persona a where  a.per_codigo='{$sql[0][7]}' limit 1 ");
    }else{
        $rsqlpersona[0][0]="";
        $rsqlpersona[0][1]="";
    }
    $rsqlpersona1=$_consulta_login->query(" select per_mail,(a.per_nombres::text || ' '::text) || a.per_apellidos::text AS nombre from aplicativo_web.aaw_persona a where  a.per_codigo='{$sql[0][8]}' limit 1 ");

    $mensajeConfirmacion ="<p style='font-size:13px!important; color:#000!important'>Estimad@ ". $rsqlpersona[0][1].",</p>";
    $mensajeConfirmacion.="<p style='font-size:13px!important; color:#000!important'>El avance estÃ¡ en estado ".$titulo." de una actividad, la informaciÃ³n respectiva se presenta a continuaciÃ³n</p>";
    $mensajeConfirmacion.=$informaciÃ³n;
    $mensajeConfirmacion.="<p align=\"center\" style='font-size:15px!important; color:#000!important;'><br /><b>PROCESO AUTOMATIZADO DE SEGUIMIENTO - MDI <br/>2017</b></p>";

    $rs = $_consulta_sistema->query("SELECT a.per_mail FROM aplicativo_web.aaw_persona a,aplicativo_web.aaw_persona_perfil b where a.per_codigo=b.per_codigo and b.pus_codigo=41
                                        union
                                        select per_mail FROM aplicativo_web.aaw_persona_correos WHERE per_codigo={$sql[0][7]};");
    for($i=0;$i<count($rs);$i++){
        $mail_copia[$i]=$rs[$i][0];
    }
    $envio_mail->envio_copia("seguimiento@mdi.gob.ec","SEGUIMIENTO MDI",$rsqlpersona[0][0],$rsqlpersona[0][1],"NUEVO AVANCE ".$titulo." SOBRE ACTIVIDAD",$mensajeConfirmacion,$mail_copia);








    return $respuesta;

}


function procesar_frm_fichamensaje_revision_seguimientoDespacho($form_entrada){
    require_once dirname(dirname(dirname(__FILE__)))."/config.php";
    //$CIFRADO=new Cifrador();
    //$_id=2;
    if(isset($_SESSION['logueado'])){
        $_id= $_SESSION['Usuid'] ;
    }
    $respuesta = new xajaxResponse();
    $_consulta_sistema=new conexion_sistema();
    $_consulta_login=new conexion();
    require_once CLA_MAIL;
    $envio_mail=new envio_mail;

    if($form_entrada["campo_mensaje_revision_seguimientoDespacho_0"]==NULL && $form_entrada["campo_mensaje_revision_seguimientoDespacho_1"]==NULL && $form_entrada["campo_mensaje_revision_seguimientoDespacho_2"]==NULL){
        $respuesta->addScript(" $.messager.show({ title:'Error',msg:'Todos los campos son obligatorios, primero complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
        return $respuesta ;
        exit;
    }
    switch($form_entrada["campo_mensaje_revision_seguimientoDespacho_2"]){
        case 5:
            $sql="update seguimiento_despacho_entrega.ssd_mensaje_registro_seguimiento set  era_codigo=5,per_codigo_revision='{$_id}',mrs_fecha_revision=now()  where rse_codigo='{$form_entrada['campo_mensaje_revision_seguimientoDespacho_0']}' and mrs_codigo ='{$form_entrada['campo_mensaje_revision_seguimientoDespacho_1']}' ";
            break;
        case 6:
            $sql="update seguimiento_despacho_entrega.ssd_mensaje_registro_seguimiento set  era_codigo=6,per_codigo_revision='{$_id}',mrs_fecha_revision=now()  where rse_codigo='{$form_entrada['campo_mensaje_revision_seguimientoDespacho_0']}' and mrs_codigo ='{$form_entrada['campo_mensaje_revision_seguimientoDespacho_1']}' ";
            break;
        case 7:
            $sql="update seguimiento_despacho_entrega.ssd_mensaje_registro_seguimiento set  era_codigo=7,per_codigo_revision='{$_id}',mrs_fecha_revision=now()  where rse_codigo='{$form_entrada['campo_mensaje_revision_seguimientoDespacho_0']}' and  mrs_codigo ='{$form_entrada['campo_mensaje_revision_seguimientoDespacho_1']}' ";
            break;
        case 8:
            $sql="update seguimiento_despacho_entrega.ssd_mensaje_registro_seguimiento set  era_codigo=8,per_codigo_revision='{$_id}',mrs_fecha_revision=now()  where rse_codigo='{$form_entrada['campo_mensaje_revision_seguimientoDespacho_0']}' and  mrs_codigo='{$form_entrada['campo_mensaje_revision_seguimientoDespacho_1']}'";
            break;
    }


    if($_consulta_sistema->query($sql)){
        $respuesta->addScript(" $.messager.show({ title:'ConfirmaciÃ³n',msg:'ActualizaciÃ³n Correcta.', timeout:20000, showType:'slide'}); ");
        $respuesta->addScript(" var p = $('#layoutBusquedaNormal_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Formulario.php?_id_registro_seguimiento=".$form_entrada['campo_mensaje_revision_seguimientoDespacho_0']."');
				   $('#tblVisorBusqueda_seguimiento_despacho').datagrid('reload');
				    ");
    }



    switch($form_entrada["campo_mensaje_revision_seguimientoDespacho_2"]){
        case 5:
            $titulo="SIN REVISAR";
            break;
        case 6:
            $titulo="APROBADO";
            break;
        case 7:
            $titulo="RECHAZADO";
            break;
        case 8:
            $titulo="ELIMINADO";
            break;
    }

    $sql=$_consulta_sistema->query("SELECT a.rse_codigo,a.rse_nombre,a.rse_fecha_fin,b.ese_nombre,c.ise_nombre,d.ase_nombre,a.ise_codigo,a.per_codigo_responsable,a.per_codigo_monitor
  FROM seguimiento_despacho_entrega.ssd_registro_seguimiento a
  left join seguimiento_despacho_entrega.ssd_estado_seguimiento b on a.ese_codigo=b.ese_codigo
  left join seguimiento_despacho_entrega.ssd_impacto_seguimiento c on a.ise_codigo=c.ise_codigo
  left join seguimiento_despacho_entrega.ssd_avance_seguimiento d on a.ase_codigo=d.ase_codigo
 where a.rse_codigo='{$form_entrada['campo_mensaje_revision_seguimientoDespacho_0']}' limit 1");
    $consulta=$_consulta_sistema->query("select mrs_mensaje from  seguimiento_despacho_entrega.ssd_mensaje_registro_seguimiento where mrs_codigo='{$form_entrada['campo_mensaje_revision_seguimientoDespacho_1']}' limit 1  ");
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
    $informaciÃ³n= "<table cellpadding=\"2\" cellspacing=\"2\" align=\"center\" style=\"font-size:13px; border:1px solid #000; width:400px; max-width:600px; text-transform:uppercase\" >
					<tr>
		 			<td align='center' colspan='2'><img  width=\"180px\" src=\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata/admin/images/mdg1.png\"/></td>
					</tr>
					<tr>
		 			<td>CÃ“DIGO DE BÃšSQUEDA</td><td>".$sql[0][0]."</td>
					</tr>
					<tr>
					<td>NOMBRE</td><td>".$sql[0][1]."</td>
					</tr>
					<tr>
					<td>FECHA DE FINALIZACIÃ“N</td><td>".FechaFormateada2(strtotime($sql[0][2]))."</td>
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
					<tr>
					<td colspan=\"2\" style='border-bottom:1px solid #CCC'>&nbsp;</td>
					</tr>
					<tr>
					<td>MENSAJE ".$titulo."</td><td>".$consulta[0][0]."</td>
					</tr>
					<tr>
					<td colspan=\"2\" style='border-bottom:1px solid #CCC'>&nbsp;</td>
					</tr>
					<tr>
		 			<td>LINK DE ACCESO AL SISTEMA</td><td><a href=\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata\">\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata\"</A></td>
					</tr>
		 		</table>";
    if($sql[0][7]!=NULL){
        $rsqlpersona=$_consulta_login->query(" select per_mail,(a.per_nombres::text || ' '::text) || a.per_apellidos::text AS nombre from aplicativo_web.aaw_persona a where  a.per_codigo='{$sql[0][7]}' limit 1 ");
    }else{
        $rsqlpersona[0][0]="";
        $rsqlpersona[0][1]="";
    }
    $rsqlpersona1=$_consulta_login->query(" select per_mail,(a.per_nombres::text || ' '::text) || a.per_apellidos::text AS nombre from aplicativo_web.aaw_persona a where  a.per_codigo='{$sql[0][8]}' limit 1 ");

    $mensajeConfirmacion ="<p style='font-size:13px!important; color:#000!important'>Estimad@ ". $rsqlpersona[0][1].",</p>";
    $mensajeConfirmacion.="<p style='font-size:13px!important; color:#000!important'>El mensaje estÃ¡ en estado ".$titulo." de una actividad, la informaciÃ³n respectiva se presenta a continuaciÃ³n</p>";
    $mensajeConfirmacion.=$informaciÃ³n;
    $mensajeConfirmacion.="<p align=\"center\" style='font-size:15px!important; color:#000!important;'><br /><b>PROCESO AUTOMATIZADO DE SEGUIMIENTO - MDI <br/>2017</b></p>";

    $rs = $_consulta_sistema->query("SELECT a.per_mail FROM aplicativo_web.aaw_persona a,aplicativo_web.aaw_persona_perfil b where a.per_codigo=b.per_codigo and b.pus_codigo=41
                                        union
                                        select per_mail FROM aplicativo_web.aaw_persona_correos WHERE per_codigo={$sql[0][7]};");
    for($i=0;$i<count($rs);$i++){
        $mail_copia[$i]=$rs[$i][0];
    }
    if($titulo!="APROBADO"){
        $envio_mail->envio_copia("seguimiento@mdi.gob.ec","SEGUIMIENTO MDI",$rsqlpersona[0][0],$rsqlpersona[0][1],"NUEVO MENSAJE ".$titulo." SOBRE ACTIVIDAD",$mensajeConfirmacion,$mail_copia);
    }






    return $respuesta;

}


function procesar_frm_fichaarchivo_revision_seguimientoDespacho($form_entrada){
    require_once dirname(dirname(dirname(__FILE__)))."/config.php";
    //$CIFRADO=new Cifrador();
    //$_id=2;
    if(isset($_SESSION['logueado'])){
        $_id= $_SESSION['Usuid'] ;
    }
    $respuesta = new xajaxResponse();
    $_consulta_sistema=new conexion_sistema();
    $_consulta_login=new conexion();
    require_once CLA_MAIL;
    $envio_mail=new envio_mail;

    if($form_entrada["campo_archivo_revision_seguimientoDespacho_0"]==NULL && $form_entrada["campo_archivo_revision_seguimientoDespacho_1"]==NULL && $form_entrada["campo_archivo_revision_seguimientoDespacho_2"]==NULL){
        $respuesta->addScript(" $.messager.show({ title:'Error',msg:'Todos los campos son obligatorios, primero complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
        return $respuesta ;
        exit;
    }
    switch($form_entrada["campo_archivo_revision_seguimientoDespacho_2"]){
        case 9:
            $sql="update seguimiento_despacho_entrega.ssd_archivo_registro_seguimiento set  era_codigo=9,per_codigo_revision='{$_id}',arr_fecha_revision=now()  where rse_codigo='{$form_entrada['campo_archivo_revision_seguimientoDespacho_0']}' and arr_codigo ='{$form_entrada['campo_archivo_revision_seguimientoDespacho_1']}' ";
            break;
        case 10:
            $sql="update seguimiento_despacho_entrega.ssd_archivo_registro_seguimiento set  era_codigo=10,per_codigo_revision='{$_id}',arr_fecha_revision=now()  where rse_codigo='{$form_entrada['campo_archivo_revision_seguimientoDespacho_0']}' and arr_codigo ='{$form_entrada['campo_archivo_revision_seguimientoDespacho_1']}' ";
            break;
        case 11:
            $sql="update seguimiento_despacho_entrega.ssd_archivo_registro_seguimiento set  era_codigo=11,per_codigo_revision='{$_id}',arr_fecha_revision=now()  where rse_codigo='{$form_entrada['campo_archivo_revision_seguimientoDespacho_0']}' and  arr_codigo ='{$form_entrada['campo_archivo_revision_seguimientoDespacho_1']}' ";
            break;
        case 12:
            $sql="update seguimiento_despacho_entrega.ssd_archivo_registro_seguimiento set  era_codigo=12,per_codigo_revision='{$_id}',arr_fecha_revision=now()  where rse_codigo='{$form_entrada['campo_archivo_revision_seguimientoDespacho_0']}' and  arr_codigo='{$form_entrada['campo_archivo_revision_seguimientoDespacho_1']}'";
            break;
    }


    if($_consulta_sistema->query($sql)){
        $respuesta->addScript(" $.messager.show({ title:'ConfirmaciÃ³n',msg:'ActualizaciÃ³n Correcta.', timeout:20000, showType:'slide'}); ");
        $respuesta->addScript(" var p = $('#layoutBusquedaNormal_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Formulario.php?_id_registro_seguimiento=".$form_entrada['campo_archivo_revision_seguimientoDespacho_0']."');
				   $('#tblVisorBusqueda_seguimiento_despacho').datagrid('reload');
				    ");
    }


    switch($form_entrada["campo_archivo_revision_seguimientoDespacho_2"]){
        case 9:
            $titulo="SIN REVISAR";
            break;
        case 10:
            $titulo="APROBADO";
            break;
        case 11:
            $titulo="RECHAZADO";
            break;
        case 12:
            $titulo="ELIMINADO";
            break;
    }

    $sql=$_consulta_sistema->query("SELECT a.rse_codigo,a.rse_nombre,a.rse_fecha_fin,b.ese_nombre,c.ise_nombre,d.ase_nombre,a.ise_codigo,a.per_codigo_responsable,a.per_codigo_monitor
  FROM seguimiento_despacho_entrega.ssd_registro_seguimiento a
  left join seguimiento_despacho_entrega.ssd_estado_seguimiento b on a.ese_codigo=b.ese_codigo
  left join seguimiento_despacho_entrega.ssd_impacto_seguimiento c on a.ise_codigo=c.ise_codigo
  left join seguimiento_despacho_entrega.ssd_avance_seguimiento d on a.ase_codigo=d.ase_codigo
 where a.rse_codigo='{$form_entrada['campo_archivo_revision_seguimientoDespacho_0']}' limit 1");
    $consulta=$_consulta_sistema->query("select arr_nombre from  seguimiento_despacho_entrega.ssd_archivo_registro_seguimiento where arr_codigo='{$form_entrada['campo_archivo_revision_seguimientoDespacho_1']}' limit 1  ");
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
    $informaciÃ³n= "<table cellpadding=\"2\" cellspacing=\"2\" align=\"center\" style=\"font-size:13px; border:1px solid #000; width:400px; max-width:600px; text-transform:uppercase\" >
					<tr>
		 			<td align='center' colspan='2'><img  width=\"180px\" src=\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata/admin/images/mdg1.png\"/></td>
					</tr>
					<tr>
		 			<td>CÃ“DIGO DE BÃšSQUEDA</td><td>".$sql[0][0]."</td>
					</tr>
					<tr>
					<td>NOMBRE</td><td>".$sql[0][1]."</td>
					</tr>
					<tr>
					<td>FECHA DE FINALIZACIÃ“N</td><td>".FechaFormateada2(strtotime($sql[0][2]))."</td>
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
					<tr>
					<td colspan=\"2\" style='border-bottom:1px solid #CCC'>&nbsp;</td>
					</tr>
					<tr>
					<td>MENSAJE ".$titulo."</td><td>".$consulta[0][0]."</td>
					</tr>
					<tr>
					<td colspan=\"2\" style='border-bottom:1px solid #CCC'>&nbsp;</td>
					</tr>
					<tr>
		 			<td>LINK DE ACCESO AL SISTEMA</td><td><a href=\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata\">\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata\"</A></td>
					</tr>
		 		</table>";
    if($sql[0][7]!=NULL){
        $rsqlpersona=$_consulta_login->query(" select per_mail,(a.per_nombres::text || ' '::text) || a.per_apellidos::text AS nombre from aplicativo_web.aaw_persona a where  a.per_codigo='{$sql[0][7]}' limit 1 ");
    }else{
        $rsqlpersona[0][0]="";
        $rsqlpersona[0][1]="";
    }
    $rsqlpersona1=$_consulta_login->query(" select per_mail,(a.per_nombres::text || ' '::text) || a.per_apellidos::text AS nombre from aplicativo_web.aaw_persona a where  a.per_codigo='{$sql[0][8]}' limit 1 ");

    $mensajeConfirmacion ="<p style='font-size:13px!important; color:#000!important'>Estimad@ ". $rsqlpersona[0][1].",</p>";
    $mensajeConfirmacion.="<p style='font-size:13px!important; color:#000!important'>El archivo estÃ¡ en estado ".$titulo." de una actividad, la informaciÃ³n respectiva se presenta a continuaciÃ³n</p>";
    $mensajeConfirmacion.=$informaciÃ³n;
    $mensajeConfirmacion.="<p align=\"center\" style='font-size:15px!important; color:#000!important;'><br /><b>PROCESO AUTOMATIZADO DE SEGUIMIENTO - MDI <br/>2017</b></p>";

    $rs = $_consulta_sistema->query("SELECT a.per_mail FROM aplicativo_web.aaw_persona a,aplicativo_web.aaw_persona_perfil b where a.per_codigo=b.per_codigo and b.pus_codigo=41
                                        union
                                        select per_mail FROM aplicativo_web.aaw_persona_correos WHERE per_codigo={$sql[0][7]};");
    for($i=0;$i<count($rs);$i++){
        $mail_copia[$i]=$rs[$i][0];
    }
    $envio_mail->envio_copia("seguimiento@mdi.gob.ec","SEGUIMIENTO MDI",$rsqlpersona[0][0],$rsqlpersona[0][1],"NUEVO ARCHIVO ".$titulo." SOBRE ACTIVIDAD",$mensajeConfirmacion,$mail_copia);








    return $respuesta;

}



function procesar_frm_fichabusqueda_seguimientoDespacho($form_entrada){
    require_once dirname(dirname(dirname(__FILE__)))."/config.php";
    $respuesta = new xajaxResponse();
    $_consulta_sistema=new conexion_sistema();
    $_consulta_login=new conexion();
    $update="0";
    $filterRules="[";
    if($form_entrada["campo_busqueda_seguimientoDespacho_0"]!=NULL){
        $filterRules.='{"field":"cmp0VisorBusquedaAvanzada_seguimiento_despacho","op":"contains","value":"'.$form_entrada["campo_busqueda_seguimientoDespacho_0"].'"},';
    }
    if($form_entrada["campo_busqueda_seguimientoDespacho_1"]!=NULL){
        $filterRules.='{"field":"cmp10VisorBusquedaAvanzada_seguimiento_despacho","op":"equal","value":"'.$form_entrada["campo_busqueda_seguimientoDespacho_1"].'"},';
    }
    if($form_entrada["campo_busqueda_seguimientoDespacho_2"]!=NULL){
        $filterRules.='{"field":"cmp11VisorBusquedaAvanzada_seguimiento_despacho","op":"equal","value":"'.$form_entrada["campo_busqueda_seguimientoDespacho_2"].'"},';
    }
    if($form_entrada["campo_busqueda_seguimientoDespacho_3"]!=NULL){
        $filterRules.='{"field":"cmp3VisorBusquedaAvanzada_seguimiento_despacho","op":"equal","value":"'.$form_entrada["campo_busqueda_seguimientoDespacho_3"].'"},';
    }
    if($form_entrada["campo_busqueda_seguimientoDespacho_4"]!=NULL){
        $filterRules.='{"field":"cmp1VisorBusquedaAvanzada_seguimiento_despacho","op":"contains","value":"'.$form_entrada["campo_busqueda_seguimientoDespacho_4"].'"},';
    }
    if($form_entrada["campo_busqueda_seguimientoDespacho_5"]!=NULL){
        $filterRules.='{"field":"cmp12VisorBusquedaAvanzada_seguimiento_despacho","op":"equal","value":"'.$form_entrada["campo_busqueda_seguimientoDespacho_5"].'"},';
    }
    if($form_entrada["campo_busqueda_seguimientoDespacho_6"]!=NULL){
        $filterRules.='{"field":"cmp4VisorBusquedaAvanzada_seguimiento_despacho","op":"equal","value":"'.$form_entrada["campo_busqueda_seguimientoDespacho_6"].'"},';
    }
    if($form_entrada["campo_busqueda_seguimientoDespacho_7"]!=NULL){
        $filterRules.='{"field":"cmp5VisorBusquedaAvanzada_seguimiento_despacho","op":"equal","value":"'.$form_entrada["campo_busqueda_seguimientoDespacho_7"].'"},';
    }
    if($form_entrada["campo_busqueda_seguimientoDespacho_8"]!=NULL){
        $filterRules.='{"field":"cmp6VisorBusquedaAvanzada_seguimiento_despacho","op":"equal","value":"'.$form_entrada["campo_busqueda_seguimientoDespacho_8"].'"},';
    }
    if($form_entrada["campo_busqueda_seguimientoDespacho_9"]!=NULL){
        $filterRules.='{"field":"cmp13VisorBusquedaAvanzada_seguimiento_despacho","op":"contains","value":"'.$form_entrada["campo_busqueda_seguimientoDespacho_9"].'"},';
    }
    if($form_entrada["campo_busqueda_seguimientoDespacho_10"]!=NULL){
        $filterRules.='{"field":"cmp14VisorBusquedaAvanzada_seguimiento_despacho","op":"contains","value":"'.$form_entrada["campo_busqueda_seguimientoDespacho_10"].'"},';
    }
    if($form_entrada["campo_busqueda_seguimientoDespacho_11"]!=NULL){
        $filterRules.='{"field":"cmp15VisorBusquedaAvanzada_seguimiento_despacho","op":"contains","value":"'.$form_entrada["campo_busqueda_seguimientoDespacho_11"].'"},';
    }
    if($form_entrada["campo_busqueda_seguimientoDespacho_7"]!=NULL){
        $filterRules.='{"field":"cmp5VisorBusquedaAvanzada_seguimiento_despacho","op":"equal","value":"'.$form_entrada["campo_busqueda_seguimientoDespacho_7"].'"},';
    }
    if($form_entrada["campo_busqueda_seguimientoDespacho_14"]!=NULL){
        $filterRules.='{"field":"cmp2VisorBusquedaAvanzada_seguimiento_despacho","op":"equal","value":"'.$form_entrada["campo_busqueda_seguimientoDespacho_14"].'"},';
    }
    /*if($form_entrada["campo_busqueda_seguimientoDespacho_12"]!=NULL){
        $filterRules.='{"field":"cmp0VisorBusquedaAvanzada_seguimiento_despacho","op":"contains","value":"'.$form_entrada["campo_busqueda_seguimientoDespacho_12"].'"},';
    }
    if($form_entrada["campo_busqueda_seguimientoDespacho_13"]!=NULL){
        $filterRules.='{"field":"cmp0VisorBusquedaAvanzada_seguimiento_despacho","op":"contains","value":"'.$form_entrada["campo_busqueda_seguimientoDespacho_13"].'"},';
    }*/


    $filterRules=trim($filterRules,",");
    $filterRules.="]";

    $respuesta->addScript(" $.messager.show({ title:'ConfirmaciÃ³n',msg:'BÃºsqueda Generada.', timeout:20000, showType:'slide'}); ");
    $respuesta->addScript(" var p = $('#layoutResponsable_busqueda_resultado_seguimiento_despacho').layout('panel','center');
						p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."visorBusqueda.php?filterRules=".urlencode($filterRules)."');");


    return $respuesta ;
    exit;

}





function procesar_frm_eliminarresponsables_seguimiento_despacho($form_entrada){
    require_once dirname(dirname(dirname(__FILE__)))."/config.php";
    $respuesta = new xajaxResponse();
    $_consulta_sistema=new conexion_sistema();
    $_consulta_login=new conexion();
    if($form_entrada["campo_eliminarparticipantes_seguimientoDespacho_1"]==NULL){

        $respuesta->addScript(" $.messager.show({ title:'Error',msg:'Todos los campos son obligatorios, primero complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
        return $respuesta ;
        exit;
    }

    $sql=" delete from aplicativo_web.aaw_persona_perfil where per_codigo='".$form_entrada["campo_eliminarparticipantes_seguimientoDespacho_1"]."' and (pus_codigo=42 or pus_codigo=43) ; ";
    $_consulta_login->query($sql);

    $respuesta->addScript(" $.messager.show({ title:'ConfirmaciÃ³n',msg:'ActualizaciÃ³n Correcta.', timeout:20000, showType:'slide'}); ");
    $respuesta->addScript(" var p = $('#layoutResponsable_opciones_seguimiento_despacho').layout('panel','center');
						p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."IngresarResponsables.php');");


    return $respuesta;

}
function procesar_frm_adicionarresponsables_seguimiento_despacho($form_entrada){
    require_once dirname(dirname(dirname(__FILE__)))."/config.php";
    $respuesta = new xajaxResponse();
    $_consulta_sistema=new conexion_sistema();
    $_consulta_login=new conexion();


    if($form_entrada["campo_adicionarrparticipantes_seguimientoDespacho_1"]==NULL){

        $respuesta->addScript(" $.messager.show({ title:'Error',msg:'Todos los campos son obligatorios, primero complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
        return $respuesta ;
        exit;
    }
    $sql=" insert into aplicativo_web.aaw_persona_perfil(ppe_codigo,per_codigo,pus_codigo) values (default,'".$form_entrada["campo_adicionarrparticipantes_seguimientoDespacho_1"]."','42'); ";
    $_consulta_login->query($sql);

    $respuesta->addScript(" $.messager.show({ title:'ConfirmaciÃ³n',msg:'ActualizaciÃ³n Correcta.', timeout:20000, showType:'slide'}); ");
    $respuesta->addScript(" var p = $('#layoutResponsable_opciones_seguimiento_despacho').layout('panel','center');
						p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."IngresarResponsables.php');");

    return $respuesta;

}
function procesar_frm_eliminarmonitores_seguimiento_despacho($form_entrada){
    require_once dirname(dirname(dirname(__FILE__)))."/config.php";
    $respuesta = new xajaxResponse();
    $_consulta_sistema=new conexion_sistema();
    $_consulta_login=new conexion();
    if($form_entrada["campo_eliminarmonitores_seguimientoDespacho_1"]==NULL){

        $respuesta->addScript(" $.messager.show({ title:'Error',msg:'Todos los campos son obligatorios, primero complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
        return $respuesta ;
        exit;
    }

    $sql=" delete from aplicativo_web.aaw_persona_perfil where per_codigo='".$form_entrada["campo_eliminarmonitores_seguimientoDespacho_1"]."' and pus_codigo=41; ";
    $_consulta_login->query($sql);

    $respuesta->addScript(" $.messager.show({ title:'ConfirmaciÃ³n',msg:'ActualizaciÃ³n Correcta.', timeout:20000, showType:'slide'}); ");
    $respuesta->addScript(" var p = $('#layoutResponsable_opciones_seguimiento_despacho').layout('panel','center');
						p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."IngresarResponsables.php');");


    return $respuesta;
}
function procesar_frm_adicionarmonitores_seguimiento_despacho($form_entrada){
    require_once dirname(dirname(dirname(__FILE__)))."/config.php";
    $respuesta = new xajaxResponse();
    $_consulta_sistema=new conexion_sistema();
    $_consulta_login=new conexion();
    if($form_entrada["campo_adicionarrmonitores_seguimientoDespacho_1"]==NULL){

        $respuesta->addScript(" $.messager.show({ title:'Error',msg:'Todos los campos son obligatorios, primero complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
        return $respuesta ;
        exit;
    }
    $sql=" insert into aplicativo_web.aaw_persona_perfil(ppe_codigo,per_codigo,pus_codigo) values (default,'".$form_entrada["campo_adicionarrmonitores_seguimientoDespacho_1"]."','41'); ";
    $_consulta_login->query($sql);

    $respuesta->addScript(" $.messager.show({ title:'ConfirmaciÃ³n',msg:'ActualizaciÃ³n Correcta.', timeout:20000, showType:'slide'}); ");
    $respuesta->addScript(" var p = $('#layoutResponsable_opciones_seguimiento_despacho').layout('panel','center');
						p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."IngresarResponsables.php');");

    return $respuesta;



}

function procesar_frm_adicionarseguimiento_seguimiento_despacho($form_entrada){
    require_once dirname(dirname(dirname(__FILE__)))."/config.php";
    $respuesta = new xajaxResponse();
    $_consulta_sistema=new conexion_sistema();
    $_consulta_login=new conexion();
    if($form_entrada["campo_adicionarseguimiento_seguimientoDespacho_1"]==NULL){

        $respuesta->addScript(" $.messager.show({ title:'Error',msg:'Todos los campos son obligatorios, primero complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
        return $respuesta ;
        exit;
    }
    $sql=" insert into aplicativo_web.aaw_persona_perfil(ppe_codigo,per_codigo,pus_codigo) values (default,'".$form_entrada["campo_adicionarseguimiento_seguimientoDespacho_1"]."','44'); ";
    $_consulta_login->query($sql);

    $respuesta->addScript(" $.messager.show({ title:'ConfirmaciÃ³n',msg:'ActualizaciÃ³n Correcta.', timeout:20000, showType:'slide'}); ");
    $respuesta->addScript(" var p = $('#layoutResponsable_opciones_seguimiento_despacho').layout('panel','center');
						p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."IngresarResponsables.php');");

    return $respuesta;



}

function procesar_frm_eliminarseguimiento_seguimiento_despacho($form_entrada){
    require_once dirname(dirname(dirname(__FILE__)))."/config.php";
    $respuesta = new xajaxResponse();
    $_consulta_sistema=new conexion_sistema();
    $_consulta_login=new conexion();
    if($form_entrada["campo_eliminarseguimiento_seguimientoDespacho_1"]==NULL){

        $respuesta->addScript(" $.messager.show({ title:'Error',msg:'Todos los campos son obligatorios, primero complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
        return $respuesta ;
        exit;
    }
    $sql=" delete from aplicativo_web.aaw_persona_perfil where per_codigo='".$form_entrada["campo_eliminarseguimiento_seguimientoDespacho_1"]."' and pus_codigo=44; ";
    $_consulta_login->query($sql);

    $respuesta->addScript(" $.messager.show({ title:'ConfirmaciÃ³n',msg:'ActualizaciÃ³n Correcta.', timeout:20000, showType:'slide'}); ");
    $respuesta->addScript(" var p = $('#layoutResponsable_opciones_seguimiento_despacho').layout('panel','center');
						p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."IngresarResponsables.php');");

    return $respuesta;



}

//CRUD USUARIOS
function procesar_frm_insertarusuario_seguimiento_despacho($form_entrada){
    require_once dirname(dirname(dirname(__FILE__)))."/config.php";
    $respuesta = new xajaxResponse();
    $_consulta_sistema=new conexion_sistema();
    $_consulta_login=new conexion();
    //$CIFRADO=new Cifrador();
    require_once CLA_MAIL;
    $envio_mail=new envio_mail;
    //$_id=2;
    if(isset($_SESSION['logueado'])){
        $_id= $_SESSION['Usuid'] ;
    }
    $update="0";
    $numCorreos=0;
    if(isset($form_entrada["campo_ingreso_seguimientoDespacho_0"]) && $form_entrada["campo_ingreso_seguimientoDespacho_0"]!=NULL){
        $update="1";
    }
    if(isset($form_entrada["num_correo_seguimientoDespacho"]) && $form_entrada["num_correo_seguimientoDespacho"]!=NULL){
        $numCorreos=$form_entrada["num_correo_seguimientoDespacho"];
    }

    switch($update){
        case 0:

            $verificacion=0;
            //$vacios=array("1"=>0,"2"=>0);
            for($i=1;$i<=11;$i++){
                if($form_entrada['campo_ingreso_seguimientoDespacho_'.$i]==""){
                    if ($i==2 or $i==3 or $i==4 or $i==5 or $i==9 or $i==10){
                        switch($i){
                            case 2:
                                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'El campo cargo se encuentra vacÃ­o, complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                                return $respuesta ;
                                exit;
                                break;
                            case 3:
                                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'El campo nombres se encuentra vacÃ­o, complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                                return $respuesta ;
                                exit;
                                break;
                            case 4:
                                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'El campo apellidos se encuentra vacÃ­o, complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                                return $respuesta ;
                                exit;
                                break;
                            case 5:
                                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'El campo correo se encuentra vacÃ­o, complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                                return $respuesta ;
                                exit;
                                break;
                            case 9:
                                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'El campo login se encuentra vacÃ­o, complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                                return $respuesta ;
                                exit;
                                break;
                            case 10:
                                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'El campo password se encuentra vacÃ­o, complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                                return $respuesta ;
                                exit;
                                break;
                        }
                    }
                }
                if($form_entrada['campo_ingreso_seguimientoDespacho_'.$i]=="0"){
                    if ($i==11){
                        switch($i){
                            case 11:
                                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'El campo instituciÃ³n se encuentra vacÃ­o, complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                                return $respuesta ;
                                exit;
                                break;
                        }
                    }
                }

            }

            //valida correo
            $sql=$_consulta_sistema->query("SELECT count(*) FROM aplicativo_web.aaw_persona where upper(trim(per_mail))=upper(trim('".$form_entrada["campo_ingreso_seguimientoDespacho_5"]."'))");
            if($sql[0][0]>0){
                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'El correo electrÃ³nico ".$form_entrada["campo_ingreso_seguimientoDespacho_5"]." ya se encuentra registrado, por favor comunÃ­quese con el administrador', timeout:20000, showType:'slide'}); ");
                return $respuesta ;
                exit;
            }
            //validar login
            $sql=$_consulta_sistema->query("SELECT count(*) FROM aplicativo_web.aaw_persona where upper(trim(per_login))=upper(trim('".$form_entrada["campo_ingreso_seguimientoDespacho_9"]."'))");
            if($sql[0][0]>0){
                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'El usuario ".$form_entrada["campo_ingreso_seguimientoDespacho_9"]." ya se encuentra registrado, por favor comunÃ­quese con el administrador', timeout:20000, showType:'slide'}); ");
                return $respuesta ;
                exit;
            }
            //insertar datos
            $sql="INSERT INTO aplicativo_web.aaw_persona(per_cedula, per_nombres, per_apellidos, per_celular,
            per_telefono, per_extension, per_mail, per_codigo_creador,per_cargo_laboral, eus_codigo,
            tco_codigo, per_area_laboral, per_login, per_password,ins_codigo)
            VALUES ('{$form_entrada['campo_ingreso_seguimientoDespacho_1']}','{$form_entrada['campo_ingreso_seguimientoDespacho_3']}','{$form_entrada['campo_ingreso_seguimientoDespacho_4']}',
            '{$form_entrada['campo_ingreso_seguimientoDespacho_6']}','{$form_entrada['campo_ingreso_seguimientoDespacho_7']}','{$form_entrada['campo_ingreso_seguimientoDespacho_8']}',
            '{$form_entrada['campo_ingreso_seguimientoDespacho_5']}',{$_id},'{$form_entrada['campo_ingreso_seguimientoDespacho_2']}',1,1,'','{$form_entrada['campo_ingreso_seguimientoDespacho_9']}', '{$form_entrada['campo_ingreso_seguimientoDespacho_10']}','{$form_entrada['campo_ingreso_seguimientoDespacho_11']}');";
            if($_consulta_sistema->query($sql)){

                $sql="select * from aplicativo_web.aaw_persona where per_cedula='{$form_entrada['campo_ingreso_seguimientoDespacho_1']}' and
                    per_nombres='{$form_entrada['campo_ingreso_seguimientoDespacho_3']}' and per_apellidos='{$form_entrada['campo_ingreso_seguimientoDespacho_4']}' and
                    per_celular='{$form_entrada['campo_ingreso_seguimientoDespacho_6']}' and per_telefono='{$form_entrada['campo_ingreso_seguimientoDespacho_7']}' and
                    per_extension='{$form_entrada['campo_ingreso_seguimientoDespacho_8']}' and per_mail='{$form_entrada['campo_ingreso_seguimientoDespacho_5']}' and
                    per_codigo_creador={$_id} and per_cargo_laboral='{$form_entrada['campo_ingreso_seguimientoDespacho_2']}' and eus_codigo=1 and
                    tco_codigo=1 and per_area_laboral='' and per_login='{$form_entrada['campo_ingreso_seguimientoDespacho_9']}' and
                    per_password='{$form_entrada['campo_ingreso_seguimientoDespacho_10']}' and ins_codigo='{$form_entrada['campo_ingreso_seguimientoDespacho_11']}'";

                $aux=$_consulta_sistema->query($sql);
                for($i=1;$i<=$numCorreos;$i++){
                    if(isset($form_entrada['campo_correo_seguimientoDespacho_'.$i]) && $form_entrada['campo_correo_seguimientoDespacho_'.$i]!=NULL){
                        if($form_entrada['campo_correo_seguimientoDespacho_'.$i]!=""){
                            //aqui hay que hacer un select con todos los campos ingresados para sacar el id con esto grabo
                            $sql2="INSERT INTO aplicativo_web.aaw_persona_correos(per_codigo, per_mail)
                        VALUES ('{$aux[0][0]}','{$form_entrada['campo_correo_seguimientoDespacho_'.$i]}');";
                            $_consulta_sistema->query($sql2);

                        }
                    }

                }
                $respuesta->addScript(" $.messager.show({ title:'ConfirmaciÃ³n',msg:'Ingreso Correcto.', timeout:20000, showType:'slide'}); ");
                //aqui reenviar a la consulta o edicion
                return $respuesta ;


            }




            break;
        case 1:

            for($i=1;$i<=11;$i++){
                if($form_entrada['campo_ingreso_seguimientoDespacho_'.$i]==""){
                    if ($i==2 or $i==3 or $i==4 or $i==5 or $i==9 or $i==10){
                        switch($i){
                            case 2:
                                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'El campo cargo se encuentra vacÃ­o, complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                                return $respuesta ;
                                exit;
                                break;
                            case 3:
                                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'El campo nombres se encuentra vacÃ­o, complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                                return $respuesta ;
                                exit;
                                break;
                            case 4:
                                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'El campo apellidos se encuentra vacÃ­o, complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                                return $respuesta ;
                                exit;
                                break;
                            case 5:
                                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'El campo correo se encuentra vacÃ­o, complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                                return $respuesta ;
                                exit;
                                break;
                            case 9:
                                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'El campo login se encuentra vacÃ­o, complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                                return $respuesta ;
                                exit;
                                break;
                            case 10:
                                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'El campo password se encuentra vacÃ­o, complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                                return $respuesta ;
                                exit;
                                break;
                        }
                    }
                }
                if($form_entrada['campo_ingreso_seguimientoDespacho_'.$i]=="0"){
                    if ($i==11){
                        switch($i){
                            case 11:
                                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'El campo instituciÃ³n se encuentra vacÃ­o, complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                                return $respuesta ;
                                exit;
                                break;
                        }
                    }
                }

            }
            //valida correo
            $sql=$_consulta_sistema->query("SELECT count(*) FROM aplicativo_web.aaw_persona where upper(trim(per_mail))=upper(trim('".$form_entrada["campo_ingreso_seguimientoDespacho_5"]."')) and per_codigo<>".$form_entrada["campo_ingreso_seguimientoDespacho_0"]);
            if($sql[0][0]>0){
                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'El correo electrÃ³nico ".$form_entrada["campo_ingreso_seguimientoDespacho_5"]." ya se encuentra registrado, por favor comunÃ­quese con el administrador', timeout:20000, showType:'slide'}); ");
                return $respuesta ;
                exit;
            }

            $sql="update aplicativo_web.aaw_persona set per_cedula='{$form_entrada['campo_ingreso_seguimientoDespacho_1']}',
            per_nombres='{$form_entrada['campo_ingreso_seguimientoDespacho_3']}',per_apellidos='{$form_entrada['campo_ingreso_seguimientoDespacho_4']}',
            per_celular='{$form_entrada['campo_ingreso_seguimientoDespacho_6']}',per_telefono='{$form_entrada['campo_ingreso_seguimientoDespacho_7']}',
            per_extension='{$form_entrada['campo_ingreso_seguimientoDespacho_8']}',per_mail='{$form_entrada['campo_ingreso_seguimientoDespacho_5']}',
            per_cargo_laboral='{$form_entrada['campo_ingreso_seguimientoDespacho_2']}',per_login='{$form_entrada['campo_ingreso_seguimientoDespacho_9']}',
            per_password='{$form_entrada['campo_ingreso_seguimientoDespacho_10']}',ins_codigo='{$form_entrada['campo_ingreso_seguimientoDespacho_11']}' where per_codigo={$form_entrada['campo_ingreso_seguimientoDespacho_0']};";

            if($_consulta_sistema->query($sql)){
                //$codigo=$_consulta_sistema->query("select max(rse_codigo) from seguimiento_despacho_entrega.ssd_registro_seguimiento");
                //$codigo=$codigo[0][0];
                $sql="delete from aplicativo_web.aaw_persona_correos where per_codigo={$form_entrada['campo_ingreso_seguimientoDespacho_0']};";
                $_consulta_sistema->query($sql);
                for($i=1;$i<=$numCorreos;$i++){
                    if(isset($form_entrada['campo_correo_seguimientoDespacho_'.$i]) && $form_entrada['campo_correo_seguimientoDespacho_'.$i]!=NULL){
                        if($form_entrada['campo_correo_seguimientoDespacho_'.$i]!=""){
                            //aqui hay que hacer un select con todos los campos ingresados para sacar el id con esto grabo
                            $sql2="INSERT INTO aplicativo_web.aaw_persona_correos(per_codigo, per_mail)
                        VALUES ('{$form_entrada['campo_ingreso_seguimientoDespacho_0']}','{$form_entrada['campo_correo_seguimientoDespacho_'.$i]}');";
                            $_consulta_sistema->query($sql2);

                        }
                    }

                }
                $respuesta->addScript(" $.messager.show({ title:'ConfirmaciÃ³n',msg:'ActualizaciÃ³n Correcta.', timeout:20000, showType:'slide'}); ");
                //aqui reenviar a la consulta o edicion
                return $respuesta ;

            }

            break;
    }
}




//CRUD PERFILES USUARIOS
function procesar_frm_insertarperilusuario_seguimiento_despacho($form_entrada){
    require_once dirname(dirname(dirname(__FILE__)))."/config.php";
    $mail_copia=Array();
    $respuesta = new xajaxResponse();
    $_consulta_sistema=new conexion_sistema();
    $_consulta_login=new conexion();
    //$CIFRADO=new Cifrador();
    require_once CLA_MAIL;
    $envio_mail=new envio_mail;
    //$_id=2;
    if(isset($_SESSION['logueado'])){
        $_id= $_SESSION['Usuid'] ;
    }
    $update="0";
    if(isset($form_entrada["campo_ingreso_seguimientoDespacho_0"]) && $form_entrada["campo_ingreso_seguimientoDespacho_0"]!=NULL){
        $update="1";
    }

    switch($update){
        case 0:

            $verificacion=0;
            //$vacios=array("1"=>0,"2"=>0);
            for($i=3;$i<=5;$i++){
                if($form_entrada['campo_ingreso_seguimientoDespacho_'.$i]==""){
                    if ($i==3 or $i==4 or $i==5){
                        switch($i){
                            case 3:
                                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'Debe escoger un nombre de la lista de bÃºsquedas, complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                                return $respuesta ;
                                exit;
                                break;
                            case 4:
                                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'Debe escoger un nombre de la lista de bÃºsquedas, complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                                return $respuesta ;
                                exit;
                                break;
                            case 5:
                                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'Debe escoger un perfil para continuar.', timeout:20000, showType:'slide'}); ");
                                return $respuesta ;
                                exit;
                                break;

                        }
                    }
                }

            }

            //valida perfil
            $sql=$_consulta_sistema->query("SELECT count(*) FROM aplicativo_web.aaw_persona_perfil where per_codigo=".$form_entrada["campo_ingreso_seguimientoDespacho_1"]);
            if($sql[0][0]>0){
                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'La persona ya se encuentra registrada con un perfil, si desea cambiarlo seleccione la opciÃ³n actualizar perfil', timeout:20000, showType:'slide'}); ");
                return $respuesta ;
                exit;
            }

            //insertar datos
            $sql="INSERT INTO aplicativo_web.aaw_persona_perfil(per_codigo, pus_codigo)
            VALUES ({$form_entrada['campo_ingreso_seguimientoDespacho_1']},{$form_entrada['campo_ingreso_seguimientoDespacho_5']});";
            if($_consulta_sistema->query($sql)){
                //$codigo=$_consulta_sistema->query("select max(rse_codigo) from seguimiento_despacho_entrega.ssd_registro_seguimiento");
                //$codigo=$codigo[0][0];
                $rsqlpersona=$_consulta_login->query(" select per_mail,(a.per_nombres::text || ' '::text) || a.per_apellidos::text AS nombre,a.per_login,a.per_password from aplicativo_web.aaw_persona a where  a.per_codigo=".$form_entrada['campo_ingreso_seguimientoDespacho_1']." limit 1 ");
                $informaciÃ³n= "<table cellpadding=\"2\" cellspacing=\"2\" align=\"center\" style=\"font-size:13px; border:1px solid #000; width:400px; max-width:600px;\" >
					<tr>
		 			<td align='center' colspan='2'><img  width=\"180px\" src=\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata/admin/images/mdg1.png\"/></td>
					</tr>
					<tr>
		 			<td>LINK DE ACCESO</td><td><a href=\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata\">\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata\"</A></td>
					</tr>
					<tr>
					<td>USUARIO</td><td>".$rsqlpersona[0][2]."</td>
					</tr>
					<tr>
					<td>CONTRASEÃ‘A</td><td>".$rsqlpersona[0][3]."</td>
					</tr>
		 		</table>";
                $rs = $_consulta_sistema->query("SELECT a.per_mail FROM aplicativo_web.aaw_persona a,aplicativo_web.aaw_persona_perfil b where a.per_codigo=b.per_codigo and b.pus_codigo=41;");
                for($i=0;$i<count($rs);$i++){
                    $mail_copia[$i]=$rs[$i][0];
                }
                $mensajeConfirmacion ="<p style='font-size:13px!important; color:#000!important'>Estimad@ ". $rsqlpersona[0][1].",</p>";
                $mensajeConfirmacion.="<p style='font-size:13px!important; color:#000!important'>Se procediÃ³ a otorgarle acceso al Sistema de Seguimiento de Disposiciones Internas, con las credenciales a continuaciÃ³n</p>";
                $mensajeConfirmacion.=$informaciÃ³n;
                $envio_mail=new envio_mail;
                $envio_mail->envio_copia("seguimiento@mdi.gob.ec","SEGUIMIENTO MDI",$rsqlpersona[0][0],$rsqlpersona[0][1],"CREACIÃ“N ACCESO SISTEMA DE SEGUIMIENTO DE DISPOSICIONES INTERNAS",$mensajeConfirmacion,$mail_copia);
                $respuesta->addScript(" $.messager.show({ title:'ConfirmaciÃ³n',msg:'Ingreso Correcto.', timeout:20000, showType:'slide'}); ");
                //aqui reenviar a la consulta o edicion
                return $respuesta ;

            }
            break;

        case 1:

            for($i=3;$i<=5;$i++){
                if($form_entrada['campo_ingreso_seguimientoDespacho_'.$i]==""){
                    if ($i==3 or $i==4 or $i==5){
                        switch($i){
                            case 3:
                                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'Debe escoger un nombre de la lista de bÃºsquedas, complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                                return $respuesta ;
                                exit;
                                break;
                            case 4:
                                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'Debe escoger un nombre de la lista de bÃºsquedas, complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                                return $respuesta ;
                                exit;
                                break;
                            case 5:
                                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'Debe escoger un perfil para continuar.', timeout:20000, showType:'slide'}); ");
                                return $respuesta ;
                                exit;
                                break;

                        }
                    }
                }

            }

            $sql="update aplicativo_web.aaw_persona_perfil set pus_codigo={$form_entrada['campo_ingreso_seguimientoDespacho_5']}
            where ppe_codigo={$form_entrada['campo_ingreso_seguimientoDespacho_0']};";

            if($_consulta_sistema->query($sql)){
                //$codigo=$_consulta_sistema->query("select max(rse_codigo) from seguimiento_despacho_entrega.ssd_registro_seguimiento");
                //$codigo=$codigo[0][0];
                $rsqlpersona=$_consulta_login->query(" select per_mail,(a.per_nombres::text || ' '::text) || a.per_apellidos::text AS nombre,a.per_login,a.per_password from aplicativo_web.aaw_persona a, aplicativo_web.aaw_persona_perfil b where a.per_codigo=b.per_codigo and  b.ppe_codigo=".$form_entrada['campo_ingreso_seguimientoDespacho_0']." limit 1 ");
                $informaciÃ³n= "<table cellpadding=\"2\" cellspacing=\"2\" align=\"center\" style=\"font-size:13px; border:1px solid #000; width:400px; max-width:600px;\" >
					<tr>
		 			<td align='center' colspan='2'><img  width=\"180px\" src=\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata/admin/images/mdg1.png\"/></td>
					</tr>
					<tr>
		 			<td>LINK DE ACCESO</td><td><a href=\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata\">\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata\"</A></td>
					</tr>
					<tr>
					<td>USUARIO</td><td>".$rsqlpersona[0][2]."</td>
					</tr>
					<tr>
					<td>CONTRASEÃ‘A</td><td>".$rsqlpersona[0][3]."</td>
					</tr>
		 		</table>";

                $mensajeConfirmacion ="<p style='font-size:13px!important; color:#000!important'>Estimad@ ". $rsqlpersona[0][1].",</p>";
                $mensajeConfirmacion.="<p style='font-size:13px!important; color:#000!important'>Se procediÃ³ a otorgarle acceso al Sistema de Seguimiento de Disposiciones Internas, con las credenciales a continuaciÃ³n</p>";
                $mensajeConfirmacion.=$informaciÃ³n;
                $envio_mail=new envio_mail;
                $rs = $_consulta_sistema->query("SELECT a.per_mail FROM aplicativo_web.aaw_persona a,aplicativo_web.aaw_persona_perfil b where a.per_codigo=b.per_codigo and b.pus_codigo=41;");
                for($i=0;$i<count($rs);$i++){
                    $mail_copia[$i]=$rs[$i][0];
                }
                $envio_mail->envio_copia("seguimiento@mdi.gob.ec","SEGUIMIENTO MDI",$rsqlpersona[0][0],$rsqlpersona[0][1],"CREACIÃ“N ACCESO SISTEMA DE SEGUIMIENTO DE DISPOSICIONES INTERNAS",$mensajeConfirmacion,$mail_copia);
                $respuesta->addScript(" $.messager.show({ title:'ConfirmaciÃ³n',msg:'ActualizaciÃ³n Correcta.', timeout:20000, showType:'slide'}); ");
                //aqui reenviar a la consulta o edicion
                return $respuesta ;

            }

            break;
    }
}

//CRUD ANIOS
function procesar_frm_insertaranio_seguimiento_despacho($form_entrada){
    require_once dirname(dirname(dirname(__FILE__)))."/config.php";
    $respuesta = new xajaxResponse();
    $_consulta_sistema=new conexion_sistema();
    $_consulta_login=new conexion();
    //$CIFRADO=new Cifrador();
    require_once CLA_MAIL;
    $envio_mail=new envio_mail;
    //$_id=2;
    if(isset($_SESSION['logueado'])){
        $_id= $_SESSION['Usuid'] ;
    }
    $update="0";
    $numCorreos=0;
    if(isset($form_entrada["campo_ingreso_seguimientoDespacho_0"]) && $form_entrada["campo_ingreso_seguimientoDespacho_0"]!=NULL){
        $update="1";
    }
    if(isset($form_entrada["num_correo_seguimientoDespacho"]) && $form_entrada["num_correo_seguimientoDespacho"]!=NULL){
        $numCorreos=$form_entrada["num_correo_seguimientoDespacho"];
    }

    switch($update){
        case 0:

            $verificacion=0;
            //$vacios=array("1"=>0,"2"=>0);
            for($i=1;$i<=1;$i++){
                if($form_entrada['campo_ingreso_seguimientoDespacho_'.$i]==""){
                    if ($i==1 ){
                        switch($i){
                            case 1:
                                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'El campo aÃ±o se encuentra vacÃ­o, complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                                return $respuesta ;
                                exit;
                                break;

                        }
                    }
                }

            }
            //insertar datos
            $sql="INSERT INTO seguimiento_despacho_entrega.ssd_anios_seguimmiento(ans_nombre)
            VALUES ('{$form_entrada['campo_ingreso_seguimientoDespacho_1']}');";
            if($_consulta_sistema->query($sql)){

                $respuesta->addScript(" $.messager.show({ title:'ConfirmaciÃ³n',msg:'Ingreso Correcto.', timeout:20000, showType:'slide'}); ");
                //aqui reenviar a la consulta o edicion
                return $respuesta ;


            }




            break;
        case 1:

            for($i=1;$i<=1;$i++){
                if($form_entrada['campo_ingreso_seguimientoDespacho_'.$i]==""){
                    if ($i==1){
                        switch($i){
                            case 1:
                                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'El campo aÃ±o se encuentra vacÃ­o, complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                                return $respuesta ;
                                exit;
                                break;
                        }
                    }
                }

            }


            $sql="update seguimiento_despacho_entrega.ssd_anios_seguimmiento set ans_nombre='{$form_entrada['campo_ingreso_seguimientoDespacho_1']}'
            where ans_codigo={$form_entrada['campo_ingreso_seguimientoDespacho_0']};";

            if($_consulta_sistema->query($sql)){
                //$codigo=$_consulta_sistema->query("select max(rse_codigo) from seguimiento_despacho_entrega.ssd_registro_seguimiento");
                //$codigo=$codigo[0][0];

                $respuesta->addScript(" $.messager.show({ title:'ConfirmaciÃ³n',msg:'ActualizaciÃ³n Correcta.', timeout:20000, showType:'slide'}); ");
                //aqui reenviar a la consulta o edicion
                return $respuesta ;

            }

            break;
    }
}

//CRUD INSTITUCION
function procesar_frm_insertarinstitucion_seguimiento_despacho($form_entrada){
    require_once dirname(dirname(dirname(__FILE__)))."/config.php";
    $respuesta = new xajaxResponse();
    $_consulta_sistema=new conexion_sistema();
    $_consulta_login=new conexion();
    //$CIFRADO=new Cifrador();
    require_once CLA_MAIL;
    $envio_mail=new envio_mail;
    //$_id=2;
    if(isset($_SESSION['logueado'])){
        $_id= $_SESSION['Usuid'] ;
    }
    $update="0";
    $numCorreos=0;
    if(isset($form_entrada["campo_ingreso_seguimientoDespacho_0"]) && $form_entrada["campo_ingreso_seguimientoDespacho_0"]!=NULL){
        $update="1";
    }
    if(isset($form_entrada["num_correo_seguimientoDespacho"]) && $form_entrada["num_correo_seguimientoDespacho"]!=NULL){
        $numCorreos=$form_entrada["num_correo_seguimientoDespacho"];
    }

    switch($update){
        case 0:

            $verificacion=0;
            //$vacios=array("1"=>0,"2"=>0);
            for($i=1;$i<=1;$i++){
                if($form_entrada['campo_ingreso_seguimientoDespacho_'.$i]==""){
                    if ($i==1 ){
                        switch($i){
                            case 1:
                                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'El campo instituciÃ³n se encuentra vacÃ­o, complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                                return $respuesta ;
                                exit;
                                break;

                        }
                    }
                }

            }
            //insertar datos
            $sql="INSERT INTO seguimiento_despacho_entrega.ssd_instituciones_seguimiento(ins_nombre)
            VALUES ('{$form_entrada['campo_ingreso_seguimientoDespacho_1']}');";
            if($_consulta_sistema->query($sql)){

                $respuesta->addScript(" $.messager.show({ title:'ConfirmaciÃ³n',msg:'Ingreso Correcto.', timeout:20000, showType:'slide'}); ");
                //aqui reenviar a la consulta o edicion
                return $respuesta ;


            }




            break;
        case 1:

            for($i=1;$i<=1;$i++){
                if($form_entrada['campo_ingreso_seguimientoDespacho_'.$i]==""){
                    if ($i==1){
                        switch($i){
                            case 1:
                                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'El campo instituciÃ³n se encuentra vacÃ­o, complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                                return $respuesta ;
                                exit;
                                break;
                        }
                    }
                }

            }


            $sql="update seguimiento_despacho_entrega.ssd_instituciones_seguimiento set ins_nombre='{$form_entrada['campo_ingreso_seguimientoDespacho_1']}'
            where ins_codigo={$form_entrada['campo_ingreso_seguimientoDespacho_0']};";

            if($_consulta_sistema->query($sql)){
                //$codigo=$_consulta_sistema->query("select max(rse_codigo) from seguimiento_despacho_entrega.ssd_registro_seguimiento");
                //$codigo=$codigo[0][0];

                $respuesta->addScript(" $.messager.show({ title:'ConfirmaciÃ³n',msg:'ActualizaciÃ³n Correcta.', timeout:20000, showType:'slide'}); ");
                //aqui reenviar a la consulta o edicion
                return $respuesta ;

            }

            break;
    }
}



//CRUD EJES
function procesar_frm_insertareje_seguimiento_despacho($form_entrada){
    require_once dirname(dirname(dirname(__FILE__)))."/config.php";
    $respuesta = new xajaxResponse();
    $_consulta_sistema=new conexion_sistema();
    $_consulta_login=new conexion();
    //$CIFRADO=new Cifrador();
    require_once CLA_MAIL;
    $envio_mail=new envio_mail;
    //$_id=2;
    if(isset($_SESSION['logueado'])){
        $_id= $_SESSION['Usuid'] ;
    }
    $update="0";
    $numCorreos=0;
    if(isset($form_entrada["campo_ingreso_seguimientoDespacho_0"]) && $form_entrada["campo_ingreso_seguimientoDespacho_0"]!=NULL){
        $update="1";
    }
    if(isset($form_entrada["num_correo_seguimientoDespacho"]) && $form_entrada["num_correo_seguimientoDespacho"]!=NULL){
        $numCorreos=$form_entrada["num_correo_seguimientoDespacho"];
    }

    switch($update){
        case 0:

            $verificacion=0;
            //$vacios=array("1"=>0,"2"=>0);
            for($i=1;$i<=1;$i++){
                if($form_entrada['campo_ingreso_seguimientoDespacho_'.$i]==""){
                    if ($i==1 ){
                        switch($i){
                            case 1:
                                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'El campo eje se encuentra vacÃ­o, complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                                return $respuesta ;
                                exit;
                                break;

                        }
                    }
                }

            }
            //insertar datos
            $sql="INSERT INTO seguimiento_despacho_entrega.ssd_ejes_seguimmiento(ejs_nombre)
            VALUES ('{$form_entrada['campo_ingreso_seguimientoDespacho_1']}');";
            if($_consulta_sistema->query($sql)){

                $respuesta->addScript(" $.messager.show({ title:'ConfirmaciÃ³n',msg:'Ingreso Correcto.', timeout:20000, showType:'slide'}); ");
                //aqui reenviar a la consulta o edicion
                return $respuesta ;


            }




            break;
        case 1:

            for($i=1;$i<=1;$i++){
                if($form_entrada['campo_ingreso_seguimientoDespacho_'.$i]==""){
                    if ($i==1){
                        switch($i){
                            case 1:
                                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'El campo eje se encuentra vacÃ­o, complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                                return $respuesta ;
                                exit;
                                break;
                        }
                    }
                }

            }


            $sql="update seguimiento_despacho_entrega.ssd_ejes_seguimmiento set ejs_nombre='{$form_entrada['campo_ingreso_seguimientoDespacho_1']}'
            where ejs_codigo={$form_entrada['campo_ingreso_seguimientoDespacho_0']};";

            if($_consulta_sistema->query($sql)){
                //$codigo=$_consulta_sistema->query("select max(rse_codigo) from seguimiento_despacho_entrega.ssd_registro_seguimiento");
                //$codigo=$codigo[0][0];

                $respuesta->addScript(" $.messager.show({ title:'ConfirmaciÃ³n',msg:'ActualizaciÃ³n Correcta.', timeout:20000, showType:'slide'}); ");
                //aqui reenviar a la consulta o edicion
                return $respuesta ;

            }

            break;
    }
}


//CRUD OBJETIVOS GENERALES
function procesar_frm_insertarobjgen_seguimiento_despacho($form_entrada){
    require_once dirname(dirname(dirname(__FILE__)))."/config.php";
    $respuesta = new xajaxResponse();
    $_consulta_sistema=new conexion_sistema();
    $_consulta_login=new conexion();
    //$CIFRADO=new Cifrador();
    require_once CLA_MAIL;
    $envio_mail=new envio_mail;
    //$_id=2;
    if(isset($_SESSION['logueado'])){
        $_id= $_SESSION['Usuid'] ;
    }
    $update="0";
    $numCorreos=0;
    if(isset($form_entrada["campo_ingreso_seguimientoDespacho_0"]) && $form_entrada["campo_ingreso_seguimientoDespacho_0"]!=NULL){
        $update="1";
    }
    if(isset($form_entrada["num_correo_seguimientoDespacho"]) && $form_entrada["num_correo_seguimientoDespacho"]!=NULL){
        $numCorreos=$form_entrada["num_correo_seguimientoDespacho"];
    }

    switch($update){
        case 0:

            $verificacion=0;
            //$vacios=array("1"=>0,"2"=>0);
            for($i=1;$i<=3;$i++){
                if($form_entrada['campo_ingreso_seguimientoDespacho_'.$i]==""){
                    if ($i==3 ){
                        switch($i){
                            case 3:
                                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'El campo objetivo se encuentra vacÃ­o, complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                                return $respuesta ;
                                exit;
                                break;

                        }

                    }
                }
                if($form_entrada['campo_ingreso_seguimientoDespacho_'.$i]=="0"){
                    if ($i==2 or $i==1 ){
                        switch($i){
                            case 1:
                                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'El campo aÃ±o se encuentra vacÃ­o, complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                                return $respuesta ;
                                exit;
                                break;
                            case 2:
                                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'El campo eje se encuentra vacÃ­o, complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                                return $respuesta ;
                                exit;
                                break;

                        }

                    }
                }

            }
            //insertar datos
            $sql="INSERT INTO seguimiento_despacho_entrega.ssd_objetivosgen_seguimmiento(ogs_nombre,ejs_codigo,ans_codigo)
            VALUES ('{$form_entrada['campo_ingreso_seguimientoDespacho_3']}',{$form_entrada['campo_ingreso_seguimientoDespacho_2']},{$form_entrada['campo_ingreso_seguimientoDespacho_1']});";
            if($_consulta_sistema->query($sql)){

                $respuesta->addScript(" $.messager.show({ title:'ConfirmaciÃ³n',msg:'Ingreso Correcto.', timeout:20000, showType:'slide'}); ");
                //aqui reenviar a la consulta o edicion
                return $respuesta ;


            }




            break;
        case 1:

            for($i=1;$i<=3;$i++){
                if($form_entrada['campo_ingreso_seguimientoDespacho_'.$i]==""){
                    if ($i==3 ){
                        switch($i){
                            case 3:
                                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'El campo objetivo se encuentra vacÃ­o, complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                                return $respuesta ;
                                exit;
                                break;

                        }

                    }
                }
                if($form_entrada['campo_ingreso_seguimientoDespacho_'.$i]=="0"){
                    if ($i==2 or $i==1 ){
                        switch($i){
                            case 1:
                                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'El campo aÃ±o se encuentra vacÃ­o, complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                                return $respuesta ;
                                exit;
                                break;
                            case 2:
                                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'El campo eje se encuentra vacÃ­o, complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                                return $respuesta ;
                                exit;
                                break;

                        }

                    }
                }

            }


            $sql="update seguimiento_despacho_entrega.ssd_objetivosgen_seguimmiento set ogs_nombre='{$form_entrada['campo_ingreso_seguimientoDespacho_3']}',
            ejs_codigo={$form_entrada['campo_ingreso_seguimientoDespacho_2']},ans_codigo={$form_entrada['campo_ingreso_seguimientoDespacho_1']}
            where ogs_codigo={$form_entrada['campo_ingreso_seguimientoDespacho_0']};";

            if($_consulta_sistema->query($sql)){
                //$codigo=$_consulta_sistema->query("select max(rse_codigo) from seguimiento_despacho_entrega.ssd_registro_seguimiento");
                //$codigo=$codigo[0][0];

                $respuesta->addScript(" $.messager.show({ title:'ConfirmaciÃ³n',msg:'ActualizaciÃ³n Correcta.', timeout:20000, showType:'slide'}); ");
                /* -----------------------ESTO REVISAR DESPUES
                 * $respuesta->addScript(" var p = $('#layoutBusquedaNormal_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Formulario.php?_id_registro_seguimiento=".$form_entrada['campo_archivo_revision_seguimientoDespacho_0']."');
				   $('#tblVisorBusqueda_seguimiento_despacho').datagrid('reload');	    ");
                 *
                 */

                //aqui reenviar a la consulta o edicion
                return $respuesta ;

            }

            break;
    }
}



//CRUD OBJETIVOS ESPECIFICOS
function procesar_frm_insertarobjesp_seguimiento_despacho($form_entrada){
    require_once dirname(dirname(dirname(__FILE__)))."/config.php";
    $respuesta = new xajaxResponse();
    $_consulta_sistema=new conexion_sistema();
    $_consulta_login=new conexion();
    //$CIFRADO=new Cifrador();
    require_once CLA_MAIL;
    $envio_mail=new envio_mail;
    //$_id=2;
    if(isset($_SESSION['logueado'])){
        $_id= $_SESSION['Usuid'] ;
    }
    $update="0";
    $numCorreos=0;
    if(isset($form_entrada["campo_ingreso_seguimientoDespacho_0"]) && $form_entrada["campo_ingreso_seguimientoDespacho_0"]!=NULL){
        $update="1";
    }
    if(isset($form_entrada["num_correo_seguimientoDespacho"]) && $form_entrada["num_correo_seguimientoDespacho"]!=NULL){
        $numCorreos=$form_entrada["num_correo_seguimientoDespacho"];
    }

    switch($update){
        case 0:

            $verificacion=0;
            //$vacios=array("1"=>0,"2"=>0);
            for($i=1;$i<=4;$i++){

                if($form_entrada['campo_ingreso_seguimientoDespacho_'.$i]=="0"){
                    if ($i==3 or $i==2 or $i==1 ){
                        switch($i){
                            case 1:
                                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'El campo aÃ±o se encuentra vacÃ­o, complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                                return $respuesta ;
                                exit;
                                break;
                            case 2:
                                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'El campo eje se encuentra vacÃ­o, complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                                return $respuesta ;
                                exit;
                                break;
                            case 3:
                                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'El campo objetivo general se encuentra vacÃ­o, complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                                return $respuesta ;
                                exit;
                                break;

                        }

                    }
                }
                if($form_entrada['campo_ingreso_seguimientoDespacho_'.$i]==""){
                    if ($i==4 ){
                        switch($i){
                            case 4:
                                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'El campo objetivo especÃ­fico se encuentra vacÃ­o, complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                                return $respuesta ;
                                exit;
                                break;

                        }

                    }
                }

            }
            //insertar datos
            $sql="INSERT INTO seguimiento_despacho_entrega.ssd_objetivosesp_seguimmiento(oes_nombre,ogs_codigo)
            VALUES ('{$form_entrada['campo_ingreso_seguimientoDespacho_4']}',{$form_entrada['campo_ingreso_seguimientoDespacho_3']});";
            if($_consulta_sistema->query($sql)){

                $respuesta->addScript(" $.messager.show({ title:'ConfirmaciÃ³n',msg:'Ingreso Correcto.', timeout:20000, showType:'slide'}); ");
                //aqui reenviar a la consulta o edicion
                return $respuesta ;


            }




            break;
        case 1:

            for($i=1;$i<=4;$i++){

                if($form_entrada['campo_ingreso_seguimientoDespacho_'.$i]=="0"){
                    if ($i==3 or $i==2 or $i==1 ){
                        switch($i){
                            case 1:
                                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'El campo aÃ±o se encuentra vacÃ­o, complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                                return $respuesta ;
                                exit;
                                break;
                            case 2:
                                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'El campo eje se encuentra vacÃ­o, complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                                return $respuesta ;
                                exit;
                                break;
                            case 3:
                                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'El campo objetivo general se encuentra vacÃ­o, complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                                return $respuesta ;
                                exit;
                                break;

                        }

                    }
                }
                if($form_entrada['campo_ingreso_seguimientoDespacho_'.$i]==""){
                    if ($i==4 ){
                        switch($i){
                            case 4:
                                $respuesta->addScript(" $.messager.show({ title:'Error',msg:'El campo objetivo especÃ­fico se encuentra vacÃ­o, complete la informaciÃ³n para continuar.', timeout:20000, showType:'slide'}); ");
                                return $respuesta ;
                                exit;
                                break;

                        }

                    }
                }

            }


            $sql="update seguimiento_despacho_entrega.ssd_objetivosesp_seguimmiento set oes_nombre='{$form_entrada['campo_ingreso_seguimientoDespacho_4']}',
            ogs_codigo={$form_entrada['campo_ingreso_seguimientoDespacho_3']}
            where oes_codigo={$form_entrada['campo_ingreso_seguimientoDespacho_0']};";

            if($_consulta_sistema->query($sql)){
                //$codigo=$_consulta_sistema->query("select max(rse_codigo) from seguimiento_despacho_entrega.ssd_registro_seguimiento");
                //$codigo=$codigo[0][0];

                $respuesta->addScript(" $.messager.show({ title:'ConfirmaciÃ³n',msg:'ActualizaciÃ³n Correcta.', timeout:20000, showType:'slide'}); ");
                /* -----------------------ESTO REVISAR DESPUES
                 * $respuesta->addScript(" var p = $('#layoutBusquedaNormal_seguimiento_despacho').layout('panel','center'); p.panel('refresh','".DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."Formulario.php?_id_registro_seguimiento=".$form_entrada['campo_archivo_revision_seguimientoDespacho_0']."');
				   $('#tblVisorBusqueda_seguimiento_despacho').datagrid('reload');	    ");
                 *
                 */

                //aqui reenviar a la consulta o edicion
                return $respuesta ;

            }

            break;
    }
}

?>