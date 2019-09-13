<?php
//llamar a storedprocedure que devuelva un string de las actividades
require_once "config.php";
$codigo=0;
$fechaact;
$fechafin;
date_default_timezone_set('Europe/Istanbul');
$rs=$_consulta_sistema->query("select * from seguimiento_despacho_entrega.ssd_registro_seguimiento a where a.ese_codigo in(2) ");
for($i=0;$i<count($rs);$i++){
    //echo "registro".$i;

        $codigo=$rs[$i]['rse_codigo'];

        //validar si las 2 fechas son null pone la fecha de creacion de la actividad

            $fechaact=new DateTime(date('Y-m-d'));
            $fechaact=$fechaact->format('Y-m-d');
    $fechafin=new DateTime($rs[$i]['rse_fecha_fin']);
    $fechafin=$fechafin->format('Y-m-d');

    //echo $fechaact.','.$fechafin.'<br>';

        //echo $date1->format('Y-m-d').','.$date2->format('Y-m-d').','.$diff->format("%a").'<br>';
        //aqui hay que sacar dinamicamente los dias
        if($fechafin<$fechaact){
            $_consulta_sistema->query("update seguimiento_despacho_entrega.ssd_registro_seguimiento set ese_codigo=9 where rse_codigo={$codigo}");
            $_consulta_sistema->query("INSERT INTO seguimiento_despacho_entrega.ssd_cambioestado_registro_seguimiento( crs_codigo, rse_codigo, ese_codigo, crs_fecha_cambio, per_codigo_cambio) VALUES (default,'{$codigo}', '{$rs[$i]['ese_codigo']}', now(), '1'); ");
            $sql1=$_consulta_sistema->query("SELECT a.rse_codigo,a.rse_nombre,a.rse_fecha_fin,b.ese_codigo,b.ese_nombre,c.ise_nombre,d.ase_nombre,a.ise_codigo,a.per_codigo_responsable,a.per_codigo_monitor
                FROM seguimiento_despacho_entrega.ssd_registro_seguimiento a
                left join seguimiento_despacho_entrega.ssd_estado_seguimiento b on a.ese_codigo=b.ese_codigo
                left join seguimiento_despacho_entrega.ssd_impacto_seguimiento c on a.ise_codigo=c.ise_codigo
                left join seguimiento_despacho_entrega.ssd_avance_seguimiento d on a.ase_codigo=d.ase_codigo
                where a.rse_codigo='".$codigo."' limit 1");

            $responsable= $sql1[0][7];
            $monitor= $sql1[0][8];


            $imagen='<img  src="http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata/seguimiento_despacho/img/star_seguimiento.png">';
            $antiguo_estado=$_consulta_sistema->query("SELECT ese_nombre from seguimiento_despacho_entrega.ssd_estado_seguimiento where ese_codigo='".$rs[$i]['ese_codigo']."' limit 1");
            $nuevo_estado=$_consulta_sistema->query("SELECT ese_nombre from seguimiento_despacho_entrega.ssd_estado_seguimiento where ese_codigo='".$sql1[0]['ese_codigo']."' limit 1");
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
            $información= "<table cellpadding=\"2\" cellspacing=\"2\" align=\"center\" style=\"font-size:13px; border:1px solid #000;width:400px; max-width:600px;text-transform:uppercase\" >
                        <tr>
                        <td align='center' colspan='2'><img  width=\"180px\" src=\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata/admin/images/mdg1.png\"/></td>
                        </tr>
                        <tr>
                        <td>CÓDIGO DE BÚSQUEDA</td><td>".$sql1[0][0]."</td>
                        </tr>
                        <tr>
                        <td>NOMBRE</td><td>".$sql1[0][1]."</td>
                        </tr>
                        <tr>
                        <td>ESTADO ACTUAL</td><td>".$sql1[0][3]."</td>
                        </tr>
                        <tr>
                        <td>IMPACTO</td><td>".$sql1[0][5]."</td>
                        </tr>
                        <tr>
                        <td>AVANCE</td><td>".$sql1[0][6]." %</td>
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




            $rsqlpersona1=$_consulta_sistema->query(" select per_mail,(a.per_nombres::text || ' '::text) || a.per_apellidos::text AS nombre from aplicativo_web.aaw_persona a where  a.per_codigo='".$monitor."'  limit 1 ");


            if($responsable!=NULL){
                $rsqlpersona=$_consulta_sistema->query(" select per_mail,(a.per_nombres::text || ' '::text) || a.per_apellidos::text AS nombre from aplicativo_web.aaw_persona a where  a.per_codigo='".$responsable."' limit 1 ");
            }else{
                $rsqlpersona[0][0]=$rsqlpersona1[0][0];
                $rsqlpersona[0][1]=$rsqlpersona1[0][1];
            }


            $envio_mail=new envio_mail;
            $mensajeConfirmacion ="<p style='font-size:13px!important; color:#000!important'>Estimad@ ". $rsqlpersona[0][1].",</p>";
            $mensajeConfirmacion.="<p style='font-size:13px!important; color:#000!important'>Se ha realizado un cambio de ESTADO sobre una actividad, la información respectiva se presenta a continuación</p>";
            $mensajeConfirmacion.=$información;
            $mensajeConfirmacion.="<p align=\"center\" style='font-size:15px!important; color:#000!important;'><br /><b>PROCESO AUTOMATIZADO DE SEGUIMIENTO - MDI <br/>2017</b></p>";


            $rs3 = $_consulta_sistema->query("SELECT a.per_mail FROM aplicativo_web.aaw_persona a,aplicativo_web.aaw_persona_perfil b where a.per_codigo=b.per_codigo and b.pus_codigo=41
                                                union
                                            select per_mail FROM aplicativo_web.aaw_persona_correos WHERE per_codigo={$responsable};");
            for($k=0;$k<count($rs3);$k++){
                $mail_copia[$k]=$rs3[$k][0];
            }
            $envio_mail->envio_copia("seguimiento@mdi.gob.ec","SEGUIMIENTO MDI",$rsqlpersona[0][0],$rsqlpersona[0][1],"NUEVO CAMBIO DE ESTADO SOBRE ACTIVIDAD",$mensajeConfirmacion,$mail_copia);

        }


}
?>