<?php
	//session_start();
include_once('../class/mail.class.php');
    if(isset($_SESSION['logueado']) and $_SESSION['logueado']){
        $nombre = $_SESSION['Usuario'];
		$perfil = $_SESSION['Perid'] ;
        $usuid = $_SESSION['Usuid'] ;
    }else{
        //Si el usuario no está logueado redireccionamos al login.
        echo "Debe estar logueado para ingresar a este sector...";
        header('Location: ../login.php');
        exit;
    }

	include_once('../includes/conexion.php');
	include_once('../includes/funciones.php');


	$validar=validaPerfil($conexion,1,0);
	if($validar){
		echo "<script languaje='javascript'>alert('Este usuario no existe.')</script>";
	}
	if(!$validar){

        $result = pg_query($conexion, "SELECT a.rse_codigo,a.rse_nombre,a.rse_fecha_fin,b.ese_codigo,b.ese_nombre,c.ise_nombre,d.ase_nombre,a.ise_codigo,a.per_codigo_monitor,a.per_codigo_responsable
  FROM seguimiento_despacho_entrega.ssd_registro_seguimiento a
  left join seguimiento_despacho_entrega.ssd_estado_seguimiento b on a.ese_codigo=b.ese_codigo
  left join seguimiento_despacho_entrega.ssd_impacto_seguimiento c on a.ise_codigo=c.ise_codigo
  left join seguimiento_despacho_entrega.ssd_avance_seguimiento d on a.ase_codigo=d.ase_codigo
 where rse_fecha_fin=current_date");
        while($perf = pg_fetch_array ($result)){
            $val=$perf[2].''.$perf[3];
        }







        $correo=traeCorreo($conexion,pg_escape_string ($_POST['usuario']));
        $ccorreo=traeCorreo($conexion,292);
        $destinatario=traeNombre($conexion,pg_escape_string ($_POST['usuario']));
        $logincorreo=traeLogin($conexion,pg_escape_string ($_POST['usuario']));
        $passcorreo=traePassword($conexion,pg_escape_string ($_POST['usuario']));
		if ($bol){
            echo "<script languaje='javascript'>alert($correo,$destinatario,$logincorreo,$passcorreo)</script>";
            $información= "<table cellpadding=\"2\" cellspacing=\"2\" align=\"center\" style=\"font-size:13px; border:1px solid #000; width:400px; max-width:600px;\" >
					<tr>
		 			<td align='center' colspan='2'><img  width=\"180px\" src=\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata/admin/images/mdg1.png\"/></td>
					</tr>
					<tr>
		 			<td>LINK DE ACCESO</td><td><a href=\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata\">\"http://servicios.ministeriodelinterior.gob.ec/seguimiento-trata\"</A></td>
					</tr>
					<tr>
					<td>USUARIO</td><td>".$logincorreo."</td>
					</tr>
					<tr>
					<td>CONTRASEÑA</td><td>".$passcorreo."</td>
					</tr>
		 		</table>";
            $mensajeConfirmacion ="<p style='font-size:13px!important; color:#000!important'>Estimad@ ". $destinatario.",</p>";
            $mensajeConfirmacion.="<p style='font-size:13px!important; color:#000!important'>Se procedió a otorgarle acceso al Sistema de Seguimiento de Disposiciones Internas, con las credenciales a continuación</p>";
            $mensajeConfirmacion.=$información;
            $envio_mail=new envio_mail;
            $envio_mail->envio("seguimiento@mdi.gob.ec","SEGUIMIENTO MDI",$correo,$destinatario,"CREACIÓN ACCESO SISTEMA DE SEGUIMIENTO DE DISPOSICIONES INTERNAS",$mensajeConfirmacion,"","",$ccorreo,""," ","","","");
			echo "<script languaje='javascript'>alert('Datos guardados.')</script>";
			$varOnLoad="javascript:llamarasincrono('perfiles', 'Contenedor','$tipo','$varconex','var')";
		}else{
			echo "<script languaje='javascript'>alert('No se ha realizado ninguna operación.')</script>";
			$varOnLoad="javascript:llamarasincrono('perfiles', 'Contenedor','$tipo','$varconex','var')";
		}
	}else{
		echo "<script languaje='javascript'>alert('No se ha realizado ninguna operación')</script>";
		$varOnLoad="javascript:llamarasincrono('perfiles', 'Contenedor','$tipo','$varconex','var')";
	}


?>

