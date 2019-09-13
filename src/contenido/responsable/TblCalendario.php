<?php
require_once dirname(dirname(dirname(dirname(__FILE__))))."/config.php";
//$_id=965;
if(!isset($_REQUEST["_id_fecha_consulta"])){
	$_REQUEST["_id_fecha_consulta"]=date("Y-m-d");
	$year=date("Y");
	$month=date("m");
	$day=date("d");
}
else{
	$year=date("Y",strtotime($_REQUEST["_id_fecha_consulta"]));
	$month=date("m",strtotime($_REQUEST["_id_fecha_consulta"]));
	$day=date("d",strtotime($_REQUEST["_id_fecha_consulta"]));
}
if(isset($_SESSION['logueado'])){
    $_id= $_SESSION['Usuid'] ;
}
/*$year=date("Y");
$month=date("m");
$day=date("d");*/
 
# Obtenemos el numero de la semana
$semana=date("W",mktime(0,0,0,$month,$day,$year));
 
# Obtenemos el día de la semana de la fecha dada
$diaSemana=date("w",mktime(0,0,0,$month,$day,$year));
 
# el 0 equivale al domingo...
if($diaSemana==0)
    $diaSemana=7;
 
# A la fecha recibida, le restamos el dia de la semana y obtendremos el lunes
$primerDia=date("d-m-Y",mktime(0,0,0,$month,$day-$diaSemana+1,$year));
 
# A la fecha recibida, le sumamos el dia de la semana menos siete y obtendremos el domingo
$ultimoDia=date("d-m-Y",mktime(0,0,0,$month,$day+(7-$diaSemana),$year));
 
/*echo "<br>Semana: ".$semana." - año: ".$year;
echo "<br>Primer día ".$primerDia;
echo "<br>Ultimo día ".$ultimoDia;*/
echo "<table class=\"calendario_seguimiento_despacho\" rules='all' cellpadding='2' cellspacing='0' style='width:100%; height:100%;  padding 10px;' align='center'>";
	//if(!isset($_REQUEST["_id_fecha_consulta"])){
		echo "<tr>
		<td onclick='atras_semana_seguimiento_despacho()' align='left' colspan=2 style='height:10px'><input style='display:none;visibility:hidden' id='calendario_cambio_seguimiento_despacho_0'><span style='font-size:9px!important;padding-left:5px;'><img src='".DIR_LOCAL_IMG_SEGUIMIENTO_DESPACHO."old_16.png'>Anterior Semana</span></td>
		<td align='center' colspan=3 style='height:10px'><b style='font-size:9px!important'>Hoy: ".FechaFormateada2(strtotime(date("Y-m-d")))."</b></td>
		<td onclick='adelante_semana_seguimiento_despacho()' align='right' colspan=2 style='height:10px'><span style='font-size:9px!important;padding-right:5px;'>Siguiente Semana <img src='".DIR_LOCAL_IMG_SEGUIMIENTO_DESPACHO."next_16.png'> </span><input style='display:none;visibility:hidden' id='calendario_cambio_seguimiento_despacho_1'></td>
		</tr>";
	//}
	$inicial=0;
	echo "<tr style='background:#ddd'>";
	for($i=1;$i<8;$i++){
		echo "<td valign='top' style='width:15%; max-width:15%; min-width:15%; height:20px; text-align:justify'>";
		echo  "<b style='font-size:9px!important'>".FechaFormateada2(strtotime($primerDia) + $inicial)."</b>";
		echo "</td>";
		$inicial=$inicial+86400;
	};
	echo "</tr>";
	echo "<tr>";
	$inicial=0;
	for($i=1;$i<8;$i++){
			$where="";
            $where2="";
            $where3="";
			if ( in_array(42, $perfil,true) || in_array(43, $perfil,true)  ) {
				$where .= " and per_codigo_responsable = '{$_id}' ";
                $where2 .= " and per_codigo_corresponsable = '{$_id}' ";
                $where3 .= " and per_codigo_participante = '{$_id}' ";
			}else if( in_array(41, $perfil,true) ){
				$where .= " ";
                $where2 .= " ";
                $where3 .= " ";
			}

		$sql=$_consulta_sistema->query("SELECT a.rse_codigo,a.rse_nombre,d.ase_nombre
  FROM seguimiento_despacho_entrega.ssd_registro_seguimiento a left join seguimiento_despacho_entrega.ssd_avance_seguimiento d on a.ase_codigo=d.ase_codigo
  where  a.rse_fecha_fin='".date('Y-m-d', strtotime($primerDia) + $inicial)."' and (a.ese_codigo!=7 and a.ese_codigo!=8 ) {$where}
  union
  SELECT a.rse_codigo,a.rse_nombre,d.ase_nombre
  FROM seguimiento_despacho_entrega.ssd_registro_seguimiento a
  left join seguimiento_despacho_entrega.ssd_avance_seguimiento d on a.ase_codigo=d.ase_codigo
  left join seguimiento_despacho_entrega.ssd_corresponsable_seguimiento b on a.rse_codigo=b.rse_codigo
  where  a.rse_fecha_fin='".date('Y-m-d', strtotime($primerDia) + $inicial)."' and (a.ese_codigo!=7 and a.ese_codigo!=8 ) {$where2}
  union
  SELECT a.rse_codigo,a.rse_nombre,d.ase_nombre
  FROM seguimiento_despacho_entrega.ssd_registro_seguimiento a
  left join seguimiento_despacho_entrega.ssd_avance_seguimiento d on a.ase_codigo=d.ase_codigo
  left join seguimiento_despacho_entrega.ssd_participante_seguimiento b on a.rse_codigo=b.rse_codigo
  where  a.rse_fecha_fin='".date('Y-m-d', strtotime($primerDia) + $inicial)."' and (a.ese_codigo!=7 and a.ese_codigo!=8 ) {$where3} order by rse_codigo ");
        if(count($sql)>0){
			echo "<td valign='top'>";
			echo "<table style='width:100%;' cellpadding='3' cellspacing='0' >";
					for($j=0;$j<count($sql);$j++){
						echo "<tr><td style='background-color:#0072C6; color: #fff' onclick='abrirFormulario_busqueda(".$sql[$j][0].")'>".$sql[$j][0]."</td></tr>";
					}
				echo "</table>";
				echo "</td>";
		}else{
			echo "<td></td>";
		}
		$inicial=$inicial+86400;	
	}
echo "</tr></table>";
?> 
               <script>
               function abrirFormulario_busqueda(id){
						var p = $('#layoutResponsable_calendario_seguimiento_despacho').layout('panel','center');
						p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>Formulario.php?_id_registro_seguimiento='+id+'&_id_plantilla_seguimiento=Calendario');
						// var p = $('#layoutResponsable_calendario_seguimiento_despacho').layout('panel','center');
						 //p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>visor.php');
				
			}
			
               
               </script>
               
               <script>
               function atras_semana_seguimiento_despacho(){
					p = $('#layoutResponsable_calendario_seguimiento_despacho').layout('panel','west');
					p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>TblCalendario.php?_id_fecha_consulta=<?php echo date("Y-m-d",strtotime ( '-7 day' , strtotime ($_REQUEST["_id_fecha_consulta"] ) ) ); ?>');
				}
				function adelante_semana_seguimiento_despacho(){
					p = $('#layoutResponsable_calendario_seguimiento_despacho').layout('panel','west');
					p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>TblCalendario.php?_id_fecha_consulta=<?php echo date("Y-m-d",strtotime ( '+7 day' , strtotime ($_REQUEST["_id_fecha_consulta"] ) )  ); ?>');
				}
                </script>
                 <script>
$(function() {
    $('#calendario_cambio_seguimiento_despacho_0,#calendario_cambio_seguimiento_despacho_1').datepicker( {
        onSelect: function(date) {
           p = $('#layoutResponsable_calendario_seguimiento_despacho').layout('panel','west');
					p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>TblCalendario.php?_id_fecha_consulta='+date);
        },
		showOn: "button",
        selectWeek: true,
         buttonImage: "<?php echo DIR_LOCAL_IMG_SEGUIMIENTO_DESPACHO?>calendario_16.png",
		  buttonImageOnly: true,
		  buttonText: "Select date",
		  yearRange: "c-1:c+1",
	   changeMonth: true,
	   /*numberOfMonths: 2,*/
       changeYear: true,
	   dateFormat: "yy-mm-dd",
       firstDay: 1,
       dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
       dayNamesShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
       monthNames: 
            ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
       monthNamesShort: 
            ["Ene", "Feb", "Mar", "Abr", "May", "Jun",
            "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"]
    });
});
</script>
<style>
.calendario_seguimiento_despacho td{
border: 1px solid #ccc!important;
}
</style>
