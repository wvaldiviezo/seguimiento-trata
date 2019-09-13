<?php
require_once dirname(dirname(dirname(dirname(__FILE__))))."/config.php";
//$_id=2;
if(isset($_SESSION['logueado'])){
    $_id= $_SESSION['Usuid'] ;
}
$parametros='';
$where="";
$where2="";
$inicio="";
$fin="";
$titulo="ESTADÍSTICAS DE ACTIVIDADES POR ESTADOS";
$titulo1="CONTEO DE ACTIVIDADES POR ESTADOS";
	if(isset($_REQUEST["_id_inicioreporte_seguimiento_despacho"]) && $_REQUEST["_id_inicioreporte_seguimiento_despacho"]!=NULL && isset($_REQUEST["_id_finreporte_seguimiento_despacho"]) && $_REQUEST["_id_finreporte_seguimiento_despacho"]!=NULL){
		$where.=" where rse_fecha_fin between '{$_REQUEST['_id_inicioreporte_seguimiento_despacho']}'  and '{$_REQUEST['_id_finreporte_seguimiento_despacho']}' ";
        $where2.=" where rse_fecha_fin between '{$_REQUEST['_id_inicioreporte_seguimiento_despacho']}'  and '{$_REQUEST['_id_finreporte_seguimiento_despacho']}' ";
		$inicio=$_REQUEST["_id_inicioreporte_seguimiento_despacho"];
		$fin=$_REQUEST["_id_finreporte_seguimiento_despacho"];
		$titulo="ESTADÍSTICAS DE ACTIVIDADES POR ESTADOS DESDE ".FechaFormateada2(strtotime($_REQUEST["_id_inicioreporte_seguimiento_despacho"]))." HASTA ".FechaFormateada2(strtotime($_REQUEST["_id_finreporte_seguimiento_despacho"]))."";
		$titulo1="CONTEO DE ACTIVIDADES POR ESTADOS DESDE ".FechaFormateada2(strtotime($_REQUEST["_id_inicioreporte_seguimiento_despacho"]))." HASTA ".FechaFormateada2(strtotime($_REQUEST["_id_finreporte_seguimiento_despacho"]))."";
		
			if ( in_array(42, $perfil,true) || in_array(43, $perfil,true)  ) {
				$where .= " and per_codigo_responsable = '{$_id}' and b.ese_codigo not in (8) ";
                $where2 .= " and e.per_codigo_corresponsable = '{$_id}' and b.ese_codigo not in (8) ";
                $parametros="?fechaini={$_REQUEST['_id_inicioreporte_seguimiento_despacho']}&fechafin={$_REQUEST['_id_finreporte_seguimiento_despacho']}&resp={$_id}";
			}else if( in_array(40, $perfil,true) || in_array(41, $perfil,true)){
				$where .= " ";
                $where2 .= " ";
                $parametros="?fechaini={$_REQUEST['_id_inicioreporte_seguimiento_despacho']}&fechafin={$_REQUEST['_id_finreporte_seguimiento_despacho']}";
			}

	}else{
	
			if ( in_array(42, $perfil,true) || in_array(43, $perfil,true)  ) {
				$where .= " where per_codigo_responsable = '{$_id}' and b.ese_codigo not in (8) ";
                $where2 .= " where e.per_codigo_corresponsable = '{$_id}' and  b.ese_codigo not in (8) ";
                $parametros="?resp={$_id}";
			}else if( in_array(41, $perfil,true) ){
				$where .= " ";
                $where2 .= " ";
			}
	
	}
	
	/*if(isset($_REQUEST["_id_finreporte_seguimiento_despacho"]) && $_REQUEST["_id_finreporte_seguimiento_despacho"]!=NULL){
		echo $_REQUEST["_id_finreporte_seguimiento_despacho"];
	}
	if(isset($_REQUEST["_id_tiporeporte_seguimiento_despacho"]) && $_REQUEST["_id_tiporeporte_seguimiento_despacho"]!=NULL){
		echo $_REQUEST["_id_tiporeporte_seguimiento_despacho"];
	
	}*/
ini_set('error_reporting',E_ALL);
ini_set('display_errors', 1);
//DEFINE DIRECTORIOS BASE PHP

//$rsql_maestro=$_consulta_sistema->query( "SELECT * FROM seguimiento_despacho_entrega.ssd_registro_seguimiento where rse_codigo='1' limit 1;" );
//print_r($rsql_maestro);
	
		$html= "
		<script>
		$(function () {
    $('#container').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: '<b>{$titulo}</b>'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                     format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                }
            }
        },
        series: [
		
		
		{
            type: 'pie',
            name: 'Browser share',
            data: [";
			
           
       	$sql=$_consulta_sistema->query("SELECT distinct(ese_codigo) FROM seguimiento_despacho_entrega.ssd_registro_seguimiento b {$where} order by ese_codigo;");
						for($i=0;$i<count($sql);$i++){
							$nombre=$_consulta_sistema->query("select ese_nombre from seguimiento_despacho_entrega.ssd_estado_seguimiento where ese_codigo='{$sql[$i][0]}'");
							$total=$_consulta_sistema->query("select count(*) from seguimiento_despacho_entrega.ssd_registro_seguimiento where ese_codigo='{$sql[$i][0]}'");
							$html.=" ['".$nombre[0][0]."',".$total[0][0]."],";
						
						}
		$html = trim($html, ',');
		
		$html.= " ]
		
		}]
    });
});
		</script>		
		";
	
	
	
	$html1= "
		<script>
		$(function () {
    $('#container1').highcharts({
       chart: {
            type: 'column',
            options3d: {
                enabled: true,
                alpha: 10,
                beta: 10,
                viewDistance: 25,
                depth: 40
            }
        },
        title: {
            text: '<b>{$titulo1}</b>'
        },
        tooltip: {
            headerFormat: '<b>{point.key}</b><br>',
            pointFormat: '<span style=\"color:{series.color}\">\u25CF</span> {series.name}: {point.y} / {point.stackTotal}'
        },
		 xAxis: {
            categories: [";
			
			$sql=$_consulta_sistema->query("SELECT distinct(ese_codigo) FROM seguimiento_despacho_entrega.ssd_registro_seguimiento b {$where}  order by ese_codigo;");
						for($i=0;$i<count($sql);$i++){
							$nombre=$_consulta_sistema->query("select ese_nombre from seguimiento_despacho_entrega.ssd_estado_seguimiento where ese_codigo='{$sql[$i][0]}'");
							$html1.='\''.$nombre[0][0].'\',';
						}
			$html1 = trim($html1, ',');
	
			$html1.="]
        },

        yAxis: {
            allowDecimals: false,
            min: 0,
            title: {
                text: 'Número de Actividades'
            }
        },
		
		
       plotOptions: {
            column: {
                stacking: 'normal',
                depth: 40
            }
        },

        series: [{
            name: 'Actividades Registradas',
            data: [";
			
			
			$sql=$_consulta_sistema->query("SELECT distinct(ese_codigo) FROM seguimiento_despacho_entrega.ssd_registro_seguimiento b {$where}  order by ese_codigo;");
						for($i=0;$i<count($sql);$i++){
							$total=$_consulta_sistema->query("select count(*) from seguimiento_despacho_entrega.ssd_registro_seguimiento where ese_codigo='{$sql[$i][0]}' ");
							$html1.=$total[0][0].",";
						}
		$html1 = trim($html1, ',');
			
			
			$html1.="],
            stack: 'male'
        }]
    });
});
		</script>	
	
	";

	
?>

  <div id="layoutResponsable_reporte_seguimiento_despacho" class="easyui-layout" data-options="fit:true" style="width:100%; height:100%">
  
  
   <div data-options="region:'west',title:'Gráfica Personalizada:',split:true,border:false,hideCollapsedContent:false"
     style="min-width:210px;width:230px; max-width:250px; height:100%; ">
               <form name="frm_fichareporte_seguimientoDespacho" id="frm_fichareporte_seguimientoDespacho"  style="padding:10px; border:1px solid #ccc; height:90%; widows:90%">
               <table width="98%" align="center">
               <tr>
               <td><b>DESDE:</b></td>
               <td>
               	<input id="campo_reporte_seguimientoDespacho_1" name="campo_reporte_seguimientoDespacho_1" value="<?php echo $inicio ?>">
                </td>
                </tr>
                 <tr>
                 <td>
                 <b>HASTA:</b>
                 </td>
               <td>
               	<input id="campo_reporte_seguimientoDespacho_2" name="campo_reporte_seguimientoDespacho_2" value="<?php echo $fin ?>">
                </td>
                </tr>
               <!-- <tr>
                <td>
                 <b>ESTADO:</b>
                 </td>
                <td>
                <select name="campo_reporte_seguimientoDespacho_3" style="width:100%">
                <option value="">TODOS</option>
                <?php
					
						$sql=$_consulta_sistema->query(" select ese_codigo,ese_nombre from seguimiento_despacho_entrega.ssd_estado_seguimiento order by ese_nombre ");
						for($i=0;$i<count($sql);$i++){
							echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].'</option>';
						}
				?>
                </select>
                
                </td>
                </tr>-->
                <tr>
                <td align="center" colspan="2">
                <a onclick="actualizarGrafica_seguimientoDespacho()" class="easyui-linkbutton" data-options="iconCls:'icon-cloud'" style="width:100px">Graficar</a>
            <script>
			 function actualizarGrafica_seguimientoDespacho(){
						$.messager.confirm('Confirmación','Está seguro que desea reporter?.',function(r){
						if (r){
								$.ajax( "<?php echo DIR_REL ?>class/validador.php")
								  .done(function(result) {
									  if(result==1){
											xajax_procesar_frm_fichareporte_seguimientoDespacho(xajax.getFormValues('frm_fichareporte_seguimientoDespacho', true));
									  }else if(result==0){
										location.reload();
									  }
								  });
								  
						}
						});
       				 }
			</script>
                </td>
                </tr>
               </table>
               <script>
			$(function() {
				$("#campo_reporte_seguimientoDespacho_2,#campo_reporte_seguimientoDespacho_1").datepicker({
				   yearRange: "c-5:c+5",
				  /* beforeShowDay: $.datepicker.noWeekends,*/
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
            
               </form>
             </div>

                
                <div data-options="region:'center',border:false" style="padding:10px">
                <?php
                    if(strlen($parametros)>0){
                        echo '<a href="seguimiento_despacho/src/contenido/responsable/excelReporte.php'.$parametros.'" target="_blank" class="easyui-linkbutton" style="width:10%" >Exportar a Excel</a>';
                    }else{
                        echo '<a href="seguimiento_despacho/src/contenido/responsable/excelReporte.php" target="_blank"   class="easyui-linkbutton" style="width:10%" >Exportar a Excel</a>';
                    }

                ?>
                <table align="center" rules="all" style="border:1px solid #CCC" width="80%" cellpadding="3" cellspacing="3">
                <tbody>
                <tr>
                <td colspan="10" style="background:#0072C6 ; color:#fff; text-align: center">REPORTE DE ACTIVIDADES</td>
                </tr>
                <tr align="center">
                <td><b>CÓDIGO</b></td>
                <td><b>NOMBRE</b></td>
                <td><b>RESPONSABLE</b></td>
                <td><b>CORRESPONSABLE</b></td>
                <td><b>FECHA DE TÉRMINO</b></td>
                <td><b>ESTADO</b></td>
                <td><b>IMPORTANCIA</b></td>
                <td><b>AVANCE</b></td>
                <td><b>DETALLE AVANCE</b></td>
                <td width="50px"><b>ÚLTIMA ACTUALIZACIÓN</b></td>
                </tr>
                
                <?php
                if(strlen($where)==0){
                    $where=' where b.ese_codigo not in (8)';
                    $where2=' where b.ese_codigo not in (8)';
                }

				$sql=$_consulta_sistema->query("SELECT a.rse_codigo,a.rse_nombre,a.per_codigo_responsable,a.rse_fecha_fin,b.ese_nombre,c.ise_nombre,d.ase_nombre
  FROM seguimiento_despacho_entrega.ssd_registro_seguimiento a 
  left join seguimiento_despacho_entrega.ssd_estado_seguimiento b on a.ese_codigo=b.ese_codigo 
  left join seguimiento_despacho_entrega.ssd_impacto_seguimiento c on a.ise_codigo=c.ise_codigo
  left join seguimiento_despacho_entrega.ssd_avance_seguimiento d on a.ase_codigo=d.ase_codigo
  {$where}
  union
  SELECT a.rse_codigo,a.rse_nombre,a.per_codigo_responsable,a.rse_fecha_fin,b.ese_nombre,c.ise_nombre,d.ase_nombre
  FROM seguimiento_despacho_entrega.ssd_registro_seguimiento a
  left join seguimiento_despacho_entrega.ssd_estado_seguimiento b on a.ese_codigo=b.ese_codigo
  left join seguimiento_despacho_entrega.ssd_impacto_seguimiento c on a.ise_codigo=c.ise_codigo
  left join seguimiento_despacho_entrega.ssd_avance_seguimiento d on a.ase_codigo=d.ase_codigo
  left join seguimiento_despacho_entrega.ssd_corresponsable_seguimiento e on e.rse_codigo=a.rse_codigo
  {$where2}
  order by rse_codigo  desc");

	  for($i=0;$i<count($sql);$i++){
	    if(isset($sql[$i][2])){
	        $rs = $_consulta_login->query(" SELECT * FROM aplicativo_web.vw_class_visorpermiso_permiso_7 where per_codigo={$sql[$i][2]} ");
        }else{
			$rs[0][0]="";
        }
        $rs2 = $_consulta_login->query("select * from seguimiento_despacho_entrega.ssd_avances_registro_seguimiento
               where rse_codigo={$sql[$i][0]} order by avr_fecha_escrito desc limit 1");
          $detalle='';
        if(isset($rs2[0][2])){
            $detalle=$rs2[0][2];
        }else{
            $detalle="";
        }
        //sacar el ultimo movimiento
          $rs2 = $_consulta_login->query("select rse_codigo,'Mensaje' as tipo,mrs_mensaje as detalle,mrs_fecha_escrito as fecharegistro,mrs_fecha_revision as fecharevision from seguimiento_despacho_entrega.ssd_mensaje_registro_seguimiento where rse_codigo={$sql[$i][0]}
union
select rse_codigo,'Avance' as tipo,avr_avance as detalle,avr_fecha_escrito as fecharegistro,avr_fecha_revision as fecharevision from seguimiento_despacho_entrega.ssd_avances_registro_seguimiento where rse_codigo={$sql[$i][0]}
union
select rse_codigo,'Archivo' as tipo,arr_nombre as detalle,arr_fecha_cargado as fecharegistro,arr_fecha_revision as fecharevision from seguimiento_despacho_entrega.ssd_archivo_registro_seguimiento where rse_codigo={$sql[$i][0]}
order by fecharegistro desc limit 1");
          $ult='';
          $desc='';
          if(isset($rs2[0][3])){
              $ult=$rs2[0][3];
              $desc="<b>Fecha: </b>".substr($ult,0,19)."<br><b>".$rs2[0][1].": </b>".$rs2[0][2];
          }
          $fecha1=new DateTime($ult);
          $fecha1=$fecha1->format('Y-m-d H:i:s');

          $rs2 = $_consulta_login->query("select rse_codigo,'Mensaje' as tipo,mrs_mensaje as detalle,mrs_fecha_escrito as fecharegistro,mrs_fecha_revision as fecharevision from seguimiento_despacho_entrega.ssd_mensaje_registro_seguimiento where rse_codigo={$sql[$i][0]}
and not mrs_fecha_revision is null
union
select rse_codigo,'Avance' as tipo,avr_avance as detalle,avr_fecha_escrito as fecharegistro,avr_fecha_revision as fecharevision from seguimiento_despacho_entrega.ssd_avances_registro_seguimiento where rse_codigo={$sql[$i][0]}
and not avr_fecha_revision is null
union
select rse_codigo,'Archivo' as tipo,arr_nombre as detalle,arr_fecha_cargado as fecharegistro,arr_fecha_revision as fecharevision from seguimiento_despacho_entrega.ssd_archivo_registro_seguimiento where rse_codigo={$sql[$i][0]}
and not arr_fecha_revision is null
order by fecharevision desc limit 1");
          $ult2='';
          $desc2='';
          if(isset($rs2[0][4])){
              $ult2=$rs2[0][4];
              $desc2="<b>Fecha: </b>".substr($ult2,0,19)."<br><b>".$rs2[0][1].": </b>".$rs2[0][2];
          }
          $fecha2=new DateTime($ult2);
          $fecha2=$fecha2->format('Y-m-d H:i:s');
          $descripcion='';
          if ($fecha1>$fecha2){
              $descripcion=$desc;
          }elseif($fecha1<$fecha2){
              $descripcion=$desc2;
          }else{
              if($desc==$desc2){
                  $descripcion=$desc;
              }else{
                  $descripcion=$desc."<br>".$desc2;
              }

          }
          $varcores='';
          $rsco = $_consulta_login->query("select (per_nombres||' '||per_apellidos)as nombres from seguimiento_despacho_entrega.ssd_corresponsable_seguimiento sc,aplicativo_web.aaw_persona p
                                          where sc.per_codigo_corresponsable=p.per_codigo and rse_codigo={$sql[$i][0]} order by nombres ");
                for($l=0;$l<count($rsco);$l++){
                    $varcores.=$rsco[$l][0];
                    if($l<(count($rsco)-1)){
                        $varcores.='<br>';
                    }
                }
          $tabla='';
          $tabla= "<tr>
		 			<td>{$sql[$i][0]}</td>
					<td>{$sql[$i][1]}</td>
					<td>{$rs[0][0]}</td>
					<td>".$varcores."</td>
					<td>".FechaFormateada2(strtotime($sql[$i][3]))."</td>
					<td>{$sql[$i][4]}</td>
					<td>{$sql[$i][5]}</td>
					<td>{$sql[$i][6]} %</td>
					<td>{$detalle}</td>
					<td>{$descripcion}</td>
		 	</tr>";
          echo $tabla;
          }
				
				
				?>
                
                
              
               
               
               
                </tbody>
                </table>
                
                
                
                
                 <?php 
			   //$reporte=new CrearGrafico();
			   //echo $reporte->reporte();
			   //echo $html;
			   //echo $html1;
			    ?>
            </div>
                
  </div>

