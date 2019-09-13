<?php
require_once dirname(dirname(dirname(dirname(__FILE__))))."/config.php";
//$_id=2;
if(isset($_SESSION['logueado'])){
    $_id= $_SESSION['Usuid'] ;
}

?>
  <div id="layoutResponsable_busqueda_seguimiento_despacho" class="easyui-layout" data-options="fit:true" style="width:100%; height:100%">
  
  
  <div data-options="region:'west',title:'Búsquedas:',split:true,border:false,striped:true" style="min-width:460px;width:480px; max-width:540px; height:100%; background-color:rgba(187, 187, 187, 0.01)">
  
  
    <div id="layoutResponsable_busqueda_resultado_seguimiento_despacho" class="easyui-layout" data-options="fit:true" style="width:100%; height:100%">
    
       <div data-options="region:'north',border:false" style="padding:0px; width:100px; height:40%">
            

       <form name="frm_fichabusqueda_seguimientoDespacho" id="frm_fichabusqueda_seguimientoDespacho" style="padding:10px; border:1px solid #ccc; width:100%; overflow:scroll">
	 <table width="90%" cellpadding="3" cellspacing="3">
     <tr>
     <td colspan="2"><a onclick="abrirBusquedaAvanzada_busqueda()" class="easyui-linkbutton" data-options="iconCls:'icon-search'" style="width:100%">Buscar</a>
     
    <script>
			 function abrirBusquedaAvanzada_busqueda(){
						$.messager.confirm('Confirmación','Está seguro que desea realizar esta búsqueda?.',function(r){
						if (r){
								$.ajax( "<?php echo DIR_REL ?>class/validador.php")
								  .done(function(result) {
									  if(result==1){
											xajax_procesar_frm_fichabusqueda_seguimientoDespacho(xajax.getFormValues('frm_fichabusqueda_seguimientoDespacho', true));
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
      <tr>
     <td>Código</td><td><input name="campo_busqueda_seguimientoDespacho_0" style="width:98%" /></td>
     </tr>
     <tr>
     	<td width="30%">Tipo</td>
     	<td>
        <select name="campo_busqueda_seguimientoDespacho_1" style="width:100%">
<option></option>
        <?php
        	$sql=$_consulta_sistema->query("select tse_codigo,tse_nombre from seguimiento_despacho_entrega.ssd_tipo_seguimiento order by tse_nombre");
			for($i=0;$i<count($sql);$i++){
				echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].'</option>';
			}
		?>
        </select>
        </td>
     </tr>
 <tr>
         <td >Origen</td>
         <td>
         <select  name="campo_busqueda_seguimientoDespacho_2" style="width:100%">
<option></option>
            <?php
               $sql=$_consulta_sistema->query("select ose_codigo,ose_nombre from seguimiento_despacho_entrega.ssd_origen_seguimiento order by ose_nombre");
						for($i=0;$i<count($sql);$i++){
							echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].'</option>';
						}
            ?>
          </select>
          </td>
     </tr>    
     <tr>
     <td>Fecha Término</td><td><input id="campo_busqueda_seguimientoDespacho_3" name="campo_busqueda_seguimientoDespacho_3" style="width:98%" />
     <script>
			$(function() {
				$("#campo_busqueda_seguimientoDespacho_3").datepicker({
				   yearRange: "c-1:c+1",
				  /* beforeShowDay: $.datepicker.noWeekends,*/
				   changeMonth: true,
				   /*numberOfMonths: 2,*/
				   /*changeYear: true,*/
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
     </td>
     </tr>
     <tr>
     <td>Nombre Actividad</td><td><input name="campo_busqueda_seguimientoDespacho_4" style="width:98%" /></td>
     </tr>
     <tr>
         <td >Monitor</td>
         <td>
         <select name="campo_busqueda_seguimientoDespacho_5" style="width:100%">
<option></option>
            <?php
                $sql=$_consulta_login->query("select a.per_codigo,b.per_nombres from aplicativo_web.aaw_persona_perfil a left join aplicativo_web.vw_informacion_persona b on a.per_codigo=b.per_codigo where a.pus_codigo=41 order by b.per_nombres");
						for($i=0;$i<count($sql);$i++){
							echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].'</option>';
						}
            ?>
          </select>
          </td>
     </tr>
         <tr>
             <td >Responsable</td>
             <td>
                 <select name="campo_busqueda_seguimientoDespacho_14" style="width:100%">
                     <option></option>
                     <?php
                     $sql=$_consulta_login->query("select a.per_codigo,b.per_nombres from aplicativo_web.aaw_persona_perfil a left join aplicativo_web.vw_informacion_persona b on a.per_codigo=b.per_codigo where (a.pus_codigo=41 or a.pus_codigo=42 or a.pus_codigo=43) order by b.per_nombres");
                     for($i=0;$i<count($sql);$i++){
                         echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].'</option>';
                     }
                     ?>
                 </select>
             </td>
         </tr>
    <tr>
         <td >Estado de Gestión</td>
         <td>
         <select name="campo_busqueda_seguimientoDespacho_6" style="width:100%">
<option></option>
            <?php
               $sql=$_consulta_sistema->query(" select ese_codigo,ese_nombre,ese_icono from seguimiento_despacho_entrega.ssd_estado_seguimiento order by ese_nombre ");
						for($i=0;$i<count($sql);$i++){
							echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].'</option>';
						}
            ?>
          </select>
          </td>
     </tr>
     <tr>
         <td >Impacto</td>
         <td>
         <select name="campo_busqueda_seguimientoDespacho_7" style="width:100%">
<option></option>
            <?php
                $sql=$_consulta_sistema->query(" select ise_codigo,ise_nombre from seguimiento_despacho_entrega.ssd_impacto_seguimiento order by ise_nombre ");
						for($i=0;$i<count($sql);$i++){
							echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].'</option>';
						}
            ?>
          </select>
          </td>
     </tr>
     <tr>
         <td >Avance</td>
         <td>
         <select name="campo_busqueda_seguimientoDespacho_8" style="width:100%">
<option></option>
            <?php
                $sql=$_consulta_sistema->query(" select ase_codigo,ase_nombre from seguimiento_despacho_entrega.ssd_avance_seguimiento order by ase_nombre ");
						for($i=0;$i<count($sql);$i++){
							echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].'</option>';
						}
            ?>
          </select>
          </td>
     </tr>
     <tr>
     <td>Detalle</td><td><input name="campo_busqueda_seguimientoDespacho_9" style="width:98%" /></td>
     </tr>
     <tr>
     <td>Avance</td><td><input name="campo_busqueda_seguimientoDespacho_10" style="width:98%" /></td>
     </tr>
     <tr>
     <td>Notas</td><td><input name="campo_busqueda_seguimientoDespacho_11" style="width:98%" /></td>
     </tr>
     <tr>
     <td>Priorizado</td><td><input name="campo_busqueda_seguimientoDespacho_12" style="width:98%" type="checkbox" /></td>
     </tr>
     <tr>
     <td>Estratégico</td><td><input name="campo_busqueda_seguimientoDespacho_13" style="width:98%" type="checkbox" /></td>
     </tr>
     </table>
     </form>
   </div>
   <div data-options="region:'center',border:false" style="padding:0px">
               
<?php 
require_once DIR_ABS_SEGUIMIENTO_DESPACHO."src/contenido/responsable/visorBusqueda.php"; 
?>
    </div>

  
             </div>   
         </div>       
                <div data-options="region:'center',border:false" style="padding:10px">           
                
  </div>

