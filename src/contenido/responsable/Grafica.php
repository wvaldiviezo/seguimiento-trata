<?php
require_once dirname(dirname(dirname(dirname(__FILE__))))."/config.php";
//$_id=2;
if(isset($_SESSION['logueado'])){
    $_id= $_SESSION['Usuid'] ;
}

$where="";
$inicio="";
$fin="";
$titulo="ESTADÍSTICAS DE ACTIVIDADES POR ESTADOS";
$titulo1="CONTEO DE ACTIVIDADES POR ESTADOS";
	if(isset($_REQUEST["_id_iniciografica_seguimiento_despacho"]) && $_REQUEST["_id_iniciografica_seguimiento_despacho"]!=NULL && isset($_REQUEST["_id_fingrafica_seguimiento_despacho"]) && $_REQUEST["_id_fingrafica_seguimiento_despacho"]!=NULL){
		$where.=" where rse_fecha_fin between '{$_REQUEST['_id_iniciografica_seguimiento_despacho']}'  and '{$_REQUEST['_id_fingrafica_seguimiento_despacho']}' ";
		$inicio=$_REQUEST["_id_iniciografica_seguimiento_despacho"];
		$fin=$_REQUEST["_id_fingrafica_seguimiento_despacho"];
		$titulo="ESTADÍSTICAS DE ACTIVIDADES POR ESTADOS DESDE ".FechaFormateada2(strtotime($_REQUEST["_id_iniciografica_seguimiento_despacho"]))." HASTA ".FechaFormateada2(strtotime($_REQUEST["_id_fingrafica_seguimiento_despacho"]))."";
		$titulo1="CONTEO DE ACTIVIDADES POR ESTADOS DESDE ".FechaFormateada2(strtotime($_REQUEST["_id_iniciografica_seguimiento_despacho"]))." HASTA ".FechaFormateada2(strtotime($_REQUEST["_id_fingrafica_seguimiento_despacho"]))."";
	
	
			if ( in_array(42, $perfil,true) || in_array(43, $perfil,true)  ) {
				$where .= " and per_codigo_responsable = '{$_id}' ";
			}else if( in_array(41, $perfil,true) ){
				$where .= " ";
			}
	
	}
	else{
	
			if ( in_array(42, $perfil,true) || in_array(43, $perfil,true)  ) {
				$where .= " where per_codigo_responsable = '{$_id}' ";
			}else if( in_array(41, $perfil,true) ){
				$where .= " ";
			}
	
	}
	
	
	/*if(isset($_REQUEST["_id_fingrafica_seguimiento_despacho"]) && $_REQUEST["_id_fingrafica_seguimiento_despacho"]!=NULL){
		echo $_REQUEST["_id_fingrafica_seguimiento_despacho"];
	}
	if(isset($_REQUEST["_id_tipografica_seguimiento_despacho"]) && $_REQUEST["_id_tipografica_seguimiento_despacho"]!=NULL){
		echo $_REQUEST["_id_tipografica_seguimiento_despacho"];
	
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
            name: 'Porcentaje de Actividades',
            data: [";
			
           
       	$sql=$_consulta_sistema->query("SELECT distinct(ese_codigo) FROM seguimiento_despacho_entrega.ssd_registro_seguimiento {$where} order by ese_codigo;");
						for($i=0;$i<count($sql);$i++){
							$nombre=$_consulta_sistema->query("select ese_nombre from seguimiento_despacho_entrega.ssd_estado_seguimiento where ese_codigo='{$sql[$i][0]}'");
							$total=$_consulta_sistema->query("select count(*) from seguimiento_despacho_entrega.ssd_registro_seguimiento where ese_codigo='{$sql[$i][0]}'");
							$html.=" {name:'".$nombre[0][0]."',y:".$total[0][0].",";
							switch($sql[$i][0]){
								case 1:
								$html.="color: '#f2f9fd'},";
								break;
								case 2:
								$html.="color: '#9ddf00'},";
								break;
								case 3:
								$html.="color: '#bfdbff'},";
								break;
								case 4:
								$html.="color: '#d0d0d0'},";
								break;
								case 5:
								$html.="color: '#cc66ff'},";
								break;
								case 6:
								$html.="color: '#fff01f'},";
								break;
								case 7:
								$html.="color: '#5f67ff'},";
								break;
								case 8:
								$html.="color: '#565656'},";
								break;
								case 9:
								$html.="color: '#ff4900'},";
								break;
								case 10:
								$html.="color: '#fa9fff'},";
								break;
							}
							
							
							
						
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
			
			$sql=$_consulta_sistema->query("SELECT distinct(ese_codigo) FROM seguimiento_despacho_entrega.ssd_registro_seguimiento {$where}  order by ese_codigo;");
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
                depth: 40,
				 dataLabels: {
                    enabled: true,
					color: '#000',
                },
				 color: '#90ed7d',
				 enableMouseTracking: false
            },
			
        },

        series: [{
            name: 'Actividades Registradas',
			 colorByPoint: true,
			  /*colors: [
        '#ff0000',
        '#00ff00',
        '#0000ff'
    ],*/
            data: [";
			
			
			$sql=$_consulta_sistema->query("SELECT distinct(ese_codigo) FROM seguimiento_despacho_entrega.ssd_registro_seguimiento {$where}  order by ese_codigo;");
						for($i=0;$i<count($sql);$i++){
							
							$whereespecial="";
							
								if ( in_array(42, $perfil,true) || in_array(43, $perfil,true)  ) {
									$whereespecial .= " and per_codigo_responsable = '{$_id}' ";
								}else if( in_array(41, $perfil,true) ){
									$whereespecial .= " ";
								}
							$total=$_consulta_sistema->query("select count(*) from seguimiento_despacho_entrega.ssd_registro_seguimiento where ese_codigo='{$sql[$i][0]}' {$whereespecial} ");
							$html1.="{y:".$total[0][0].",";
							switch($sql[$i][0]){
								case 1:
								$html1.="color: '#f2f9fd'},";
								break;
								case 2:
								$html1.="color: '#9ddf00'},";
								break;
								case 3:
								$html1.="color: '#bfdbff'},";
								break;
								case 4:
								$html1.="color: '#d0d0d0'},";
								break;
								case 5:
								$html1.="color: '#cc66ff'},";
								break;
								case 6:
								$html1.="color: '#fff01f'},";
								break;
								case 7:
								$html1.="color: '#5f67ff'},";
								break;
								case 8:
								$html1.="color: '#565656'},";
								break;
								case 9:
								$html1.="color: '#ff4900'},";
								break;
								case 10:
								$html1.="color: '#fa9fff'},";
								break;
							}
						}
		$html1 = trim($html1, ',');
			
			
			$html1.="],
            stack: 'male',
			
        }]
    });
});
		</script>	
	
	";

	
?>

  <div id="layoutResponsable_grafica_seguimiento_despacho" class="easyui-layout" data-options="fit:true" style="width:100%; height:100%">
  
  
   <div data-options="region:'west',title:'Gráfica Personalizada:',split:true,border:false,hideCollapsedContent:false"
     style="min-width:210px;width:230px; max-width:250px; height:100%; ">
               <form name="frm_fichagrafica_seguimientoDespacho" id="frm_fichagrafica_seguimientoDespacho"  style="padding:10px; border:1px solid #ccc; height:90%; widows:90%">
               <table width="98%" align="center">
               <tr>
               <td><b>DESDE:</b></td>
               <td>
               	<input id="campo_grafica_seguimientoDespacho_1" name="campo_grafica_seguimientoDespacho_1" value="<?php echo $inicio ?>">
                </td>
                </tr>
                 <tr>
                 <td>
                 <b>HASTA:</b>
                 </td>
               <td>
               	<input id="campo_grafica_seguimientoDespacho_2" name="campo_grafica_seguimientoDespacho_2" value="<?php echo $fin ?>">
                </td>
                </tr>
               <!-- <tr>
                <td>
                 <b>ESTADO:</b>
                 </td>
                <td>
                <select name="campo_grafica_seguimientoDespacho_3" style="width:100%">
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
						$.messager.confirm('Confirmación','Está seguro que desea graficar?.',function(r){
						if (r){
								$.ajax( "<?php echo DIR_REL ?>class/validador.php")
								  .done(function(result) {
									  if(result==1){
											xajax_procesar_frm_fichagrafica_seguimientoDespacho(xajax.getFormValues('frm_fichagrafica_seguimientoDespacho', true));
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
				$("#campo_grafica_seguimientoDespacho_2,#campo_grafica_seguimientoDespacho_1").datepicker({
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
                <table align="center" rules="all" style="border:1px solid #CCC" width="80%" cellpadding="3" cellspacing="3">
                <tbody>
                <tr>
                <td style="background:#0072C6 ; color:#fff;">ESTADÍSTICAS DE TODAS LAS ACTIVIDADES REGISTRADAS (PORCENTAJE)</td>
                </tr>
                <tr>
                <td>
                <div align="center" id="container" style="height: 400px"></div>
                </td>
                </tr>
                <tr>
                <td style="background:#0072C6 ;color:#fff;">ESTADÍSTICAS DE TODAS LAS ACTIVIDADES REGISTRADAS (CONTEO)</td>
                </tr>
                <tr>
                <td width="200px">
                <div align="center" id="container1" style="height: 400px"></div>
                </td>
                </tr>
                </tbody>
                </table>
                 <?php 
			   //$grafica=new CrearGrafico();
			   //echo $grafica->grafica();
			   echo $html;
			   echo $html1;
			    ?>
            </div>
                
  </div>

