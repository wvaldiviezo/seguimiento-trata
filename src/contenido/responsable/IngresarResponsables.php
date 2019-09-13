<?php
require_once dirname(dirname(dirname(dirname(__FILE__))))."/config.php";
//$_id=2;
if(isset($_SESSION['logueado'])){
    $_id= $_SESSION['Usuid'] ;
}
echo "<script>
if (!window.jQuery) {
	document.write(\"<script src='".DIR_REL_JS."jquery-1.10.2.js'><\/script>\");
	document.write(\"<script type='text/javascript'>$.ajax({type: 'POST',data:{'tipo':1},url: '".DIR_REL."class/monitoreo.php' }); <\/script>\");
	window.location.assign('/');
}
</script>";
$solicitud=FechaFormateada2(strtotime(date("Y-m-d"))).'   '.date('H:i:s');
?>
<div id="tab_actualizarresponsablespersonal" class="easyui-layout" data-options="fit:true">
	<div data-options="region:'center',border:false" style="width:75%">
    <form  id="frm_eliminarresponsables_seguimiento_despacho" name="frm_eliminarresponsables_seguimiento_despacho" style="padding:1px;">
        <table width="100%"  id="tbl_eliminarresponsables_seguimiento_despacho" align="center" cellpadding="6" cellspacing="5" >
        	<tbody>
            <tr>
            <td colspan="2">
            <a onClick="ingresar_eliminarresponsables_seguimiento_despacho();" class="easyui-linkbutton" data-options="iconCls:'icon-reload-cloud'" style="width:280px">Eliminar Responsable</a>
			<script>
            function ingresar_eliminarresponsables_seguimiento_despacho(){
                $.messager.confirm('Confirmación','Está seguro que desea ingresar este responsable?.',function(r){
                if (r){
                        $.ajax( "<?php echo DIR_REL ?>class/validador.php")
                          .done(function(result) {
                              if(result==1){
                                    xajax_procesar_frm_eliminarresponsables_seguimiento_despacho(xajax.getFormValues('frm_eliminarresponsables_seguimiento_despacho', true));
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
           	<tr align="center"  >
                    <td width="20%" style="text-align:left"  >
                        <b>SERVIDOR A ELIMINAR COMO RESPONSABLE</b>
                    </td>
                    <td width="80%" align="center" >
                        <select id="campo_eliminarparticipantes_seguimientoDespacho_1" name="campo_eliminarparticipantes_seguimientoDespacho_1" style="width:95%">
                        <option></option>
                <?php
				
						//$sql=$_consulta_login->query("select a.per_codigo,b.nombre,b.cargo from aplicativo_web.aaw_persona_perfil a left join aplicativo_web.vw_class_visorpermiso_permiso_0 b on a.per_codigo=b.per_codigo where (a.pus_codigo=42 or a.pus_codigo=43 )");
                        $sql=$_consulta_login->query("select a.per_codigo,b.per_apellidos||' '||b.per_nombres,b.per_cargo_laboral from aplicativo_web.aaw_persona_perfil a left join aplicativo_web.aaw_persona b on a.per_codigo=b.per_codigo where (a.pus_codigo=42 or a.pus_codigo=43 )");
						for($i=0;$i<count($sql);$i++){
							echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].' >>> '.$sql[$i][2].'</option>';
						}
				?>
                </select>
                  <script>
						$(function() {
							$("#campo_eliminarparticipantes_seguimientoDespacho_1").select2({  placeholder: "ESCOJA UNA OPCIÓN",allowClear: true});
						});
						</script>

                        <a href="#" title="Ingrese un nuevo tipo." class="easyui-tooltip"><img src="<?php echo DIR_REL_IMG; ?>help-16.png" /></a>
                    </td>
			</tr>
			</tbody>
		</table>
	</form>
    <form  id="frm_adicionarresponsables_seguimiento_despacho" name="frm_adicionarresponsables_seguimiento_despacho" style="padding:1px; border-top:1px groove #ccc">
        <table width="100%"  id="tbl_adicionarresponsables_seguimiento_despacho" align="center" cellpadding="6" cellspacing="5" >
        	<tbody>
            <tr>
            <td colspan="2">
            <a onClick="ingresar_adicionarresponsables_seguimiento_despacho();" class="easyui-linkbutton" data-options="iconCls:'icon-reload-cloud'" style="width:280px">Adicionar Responsable</a>
			<script>
            function ingresar_adicionarresponsables_seguimiento_despacho(){
                $.messager.confirm('Confirmación','Está seguro que desea adicionar este responsable?.',function(r){
                if (r){
                        $.ajax( "<?php echo DIR_REL ?>class/validador.php")
                          .done(function(result) {
                              if(result==1){
                                    xajax_procesar_frm_adicionarresponsables_seguimiento_despacho(xajax.getFormValues('frm_adicionarresponsables_seguimiento_despacho', true));
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
           	<tr align="center"  >
                    <td width="20%" style="text-align:left"  >
                        <b>SERVIDOR A INGRESAR COMO RESPONSABLE</b>
                    </td>
                    <td width="80%" align="center" >
                        <select id="campo_adicionarrparticipantes_seguimientoDespacho_1" name="campo_adicionarrparticipantes_seguimientoDespacho_1" style="width:95%">
                         <option></option>
                <?php
				
						//$sql=$_consulta_login->query("select distinct(a.per_codigo),b.nombre,b.cargo from aplicativo_web.aaw_persona_perfil a left join aplicativo_web.vw_class_visorpermiso_permiso_0 b on a.per_codigo=b.per_codigo");
                        $sql=$_consulta_login->query("select distinct(a.per_codigo),b.per_apellidos||' '||b.per_nombres,b.per_cargo_laboral from aplicativo_web.aaw_persona_perfil a left join aplicativo_web.aaw_persona b on a.per_codigo=b.per_codigo");
						for($i=0;$i<count($sql);$i++){
							echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].' >>> '.$sql[$i][2].'</option>';
						}
				?>
                </select>
                  <script>
						$(function() {
							$("#campo_adicionarrparticipantes_seguimientoDespacho_1").select2({  placeholder: "ESCOJA UNA OPCIÓN",allowClear: true});
						});
						</script>
                       

                        <a href="#" title="Ingrese un nuevo tipo." class="easyui-tooltip"><img src="<?php echo DIR_REL_IMG; ?>help-16.png" /></a>
                    </td>
			</tr>
			</tbody>
		</table>
	</form>
    <form  id="frm_eliminarmonitores_seguimiento_despacho" name="frm_eliminarmonitores_seguimiento_despacho" style="padding:1px; border-top:1px groove #ccc">
        <table width="100%"  id="tbl_eliminarmonitores_seguimiento_despacho" align="center" cellpadding="6" cellspacing="5" >
        	<tbody>
            <tr>
            <td colspan="2">
            <a onClick="ingresar_eliminarmonitores_seguimiento_despacho();" class="easyui-linkbutton" data-options="iconCls:'icon-reload-cloud'" style="width:280px">Eliminar Monitor</a>
			<script>
            function ingresar_eliminarmonitores_seguimiento_despacho(){
                $.messager.confirm('Confirmación','Está seguro que desea eliminar este monitor?.',function(r){
                if (r){
                        $.ajax( "<?php echo DIR_REL ?>class/validador.php")
                          .done(function(result) {
                              if(result==1){
                                    xajax_procesar_frm_eliminarmonitores_seguimiento_despacho(xajax.getFormValues('frm_eliminarmonitores_seguimiento_despacho', true));
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
           	<tr align="center"  >
                    <td width="20%" style="text-align:left"  >
                        <b>SERVIDOR A ELIMINAR COMO MONITOR</b>
                    </td>
                    <td width="80%" align="center" >
                        <select id="campo_eliminarmonitores_seguimientoDespacho_1" name="campo_eliminarmonitores_seguimientoDespacho_1" style="width:95%">
                         <option></option>
                <?php
				
						//$sql=$_consulta_login->query("select a.per_codigo,b.nombre,b.cargo from aplicativo_web.aaw_persona_perfil a left join aplicativo_web.vw_class_visorpermiso_permiso_0 b on a.per_codigo=b.per_codigo where a.pus_codigo=41");
                        $sql=$_consulta_login->query("select a.per_codigo,b.per_apellidos||' '||b.per_nombres,b.per_cargo_laboral from aplicativo_web.aaw_persona_perfil a left join aplicativo_web.aaw_persona b on a.per_codigo=b.per_codigo where a.pus_codigo=41");
						for($i=0;$i<count($sql);$i++){
							echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].' >>> '.$sql[$i][2].'</option>';
						}
				?>
                </select>
                  <script>
						$(function() {
							$("#campo_eliminarmonitores_seguimientoDespacho_1").select2({  placeholder: "ESCOJA UNA OPCIÓN",allowClear: true});
						});
						</script>

                        <a href="#" title="Ingrese un nuevo tipo." class="easyui-tooltip"><img src="<?php echo DIR_REL_IMG; ?>help-16.png" /></a>
                    </td>
			</tr>
			</tbody>
		</table>
	</form>
    <form  id="frm_adicionarmonitores_seguimiento_despacho" name="frm_adicionarmonitores_seguimiento_despacho" style="padding:1px; border-top:1px groove #ccc">
        <table width="100%"  id="tbl_adicionarmonitores_seguimiento_despacho" align="center" cellpadding="6" cellspacing="5" >
        	<tbody>
            <tr>
            <td colspan="2">
            <a onClick="ingresar_adicionarmonitores_seguimiento_despacho();" class="easyui-linkbutton" data-options="iconCls:'icon-reload-cloud'" style="width:280px">Adicionar Monitor</a>
			<script>
            function ingresar_adicionarmonitores_seguimiento_despacho(){
                $.messager.confirm('Confirmación','Está seguro que desea adicionar este monitor?.',function(r){
                if (r){
                        $.ajax( "<?php echo DIR_REL ?>class/validador.php")
                          .done(function(result) {
                              if(result==1){
                                    xajax_procesar_frm_adicionarmonitores_seguimiento_despacho(xajax.getFormValues('frm_adicionarmonitores_seguimiento_despacho', true));
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
           	<tr align="center"  >
                    <td width="20%" style="text-align:left"  >
                         <b>SERVIDOR A INGRESAR COMO MONITOR</b>
                    </td>
                    <td width="80%" align="center" >
                        <select id="campo_adicionarrmonitores_seguimientoDespacho_1" name="campo_adicionarrmonitores_seguimientoDespacho_1" style="width:95%">
                         <option></option>
                <?php
				
						//$sql=$_consulta_login->query("select distinct(a.per_codigo),b.nombre,b.cargo from aplicativo_web.aaw_persona_perfil a left join aplicativo_web.vw_class_visorpermiso_permiso_0 b on a.per_codigo=b.per_codigo");
                        $sql=$_consulta_login->query("select distinct(a.per_codigo),b.per_apellidos||' '||b.per_nombres,b.per_cargo_laboral from aplicativo_web.aaw_persona_perfil a left join aplicativo_web.aaw_persona b on a.per_codigo=b.per_codigo");
						for($i=0;$i<count($sql);$i++){
							echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].' >>> '.$sql[$i][2].'</option>';
						}
				?>
                </select>
                  <script>
						$(function() {
							$("#campo_adicionarrmonitores_seguimientoDespacho_1").select2({  placeholder: "ESCOJA UNA OPCIÓN",allowClear: true});
						});
						</script>
                       

                        <a href="#" title="Ingrese un nuevo tipo." class="easyui-tooltip"><img src="<?php echo DIR_REL_IMG; ?>help-16.png" /></a>
                    </td>
			</tr>
			</tbody>
		</table>
	</form>
    
    <form  id="frm_adicionarseguimiento_seguimiento_despacho" name="frm_adicionarseguimiento_seguimiento_despacho" style="padding:1px; border-top:1px groove #ccc">
        <table width="100%"  id="tbl_adicionarseguimiento_seguimiento_despacho" align="center" cellpadding="6" cellspacing="5" >
        	<tbody>
            <tr>
            <td colspan="2">
            <a onClick="ingresar_adicionarseguimiento_seguimiento_despacho();" class="easyui-linkbutton" data-options="iconCls:'icon-reload-cloud'" style="width:280px">Adicionar Visualizador</a>
			<script>
            function ingresar_adicionarseguimiento_seguimiento_despacho(){
                $.messager.confirm('Confirmación','Está seguro que desea adicionar este monitor?.',function(r){
                if (r){
                        $.ajax( "<?php echo DIR_REL ?>class/validador.php")
                          .done(function(result) {
                              if(result==1){
                                    xajax_procesar_frm_adicionarseguimiento_seguimiento_despacho(xajax.getFormValues('frm_adicionarseguimiento_seguimiento_despacho', true));
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
           	<tr align="center"  >
                    <td width="20%" style="text-align:left"  >
                         <b>SERVIDOR A INGRESAR COMO VISUALIZADOR DE ACTIVIDADES</b>
                    </td>
                    <td width="80%" align="center" >
                        <select id="campo_adicionarseguimiento_seguimientoDespacho_1" name="campo_adicionarseguimiento_seguimientoDespacho_1" style="width:95%">
                         <option></option>
                <?php
				
						//$sql=$_consulta_login->query("select distinct(a.per_codigo),b.nombre,b.cargo from aplicativo_web.aaw_persona_perfil a left join aplicativo_web.vw_class_visorpermiso_permiso_0 b on a.per_codigo=b.per_codigo");
                        $sql=$_consulta_login->query("select distinct(a.per_codigo),b.per_apellidos||' '||b.per_nombres,b.per_cargo_laboral from aplicativo_web.aaw_persona_perfil a left join aplicativo_web.aaw_persona b on a.per_codigo=b.per_codigo");
						for($i=0;$i<count($sql);$i++){
							echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].' >>> '.$sql[$i][2].'</option>';
						}
				?>
                </select>
                  <script>
						$(function() {
							$("#campo_adicionarseguimiento_seguimientoDespacho_1").select2({  placeholder: "ESCOJA UNA OPCIÓN",allowClear: true});
						});
						</script>
                       

                        <a href="#" title="Ingrese un nuevo tipo." class="easyui-tooltip"><img src="<?php echo DIR_REL_IMG; ?>help-16.png" /></a>
                    </td>
			</tr>
			</tbody>
		</table>
	</form>
    
    <form  id="frm_eliminarseguimiento_seguimiento_despacho" name="frm_eliminarseguimiento_seguimiento_despacho" style="padding:1px; border-top:1px groove #ccc">
        <table width="100%"  id="tbl_eliminarseguimiento_seguimiento_despacho" align="center" cellpadding="6" cellspacing="5" >
        	<tbody>
            <tr>
            <td colspan="2">
            <a onClick="ingresar_eliminarseguimiento_seguimiento_despacho();" class="easyui-linkbutton" data-options="iconCls:'icon-reload-cloud'" style="width:280px">Eliminar Visualizador</a>
			<script>
            function ingresar_eliminarseguimiento_seguimiento_despacho(){
                $.messager.confirm('Confirmación','Está seguro que desea adicionar este monitor?.',function(r){
                if (r){
                        $.ajax( "<?php echo DIR_REL ?>class/validador.php")
                          .done(function(result) {
                              if(result==1){
                                    xajax_procesar_frm_eliminarseguimiento_seguimiento_despacho(xajax.getFormValues('frm_eliminarseguimiento_seguimiento_despacho', true));
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
           	<tr align="center"  >
                    <td width="20%" style="text-align:left"  >
                         <b>SERVIDOR A ELIMINAR COMO VISUALIZADOR DE ACTIVIDADES</b>
                    </td>
                    <td width="80%" align="center" >
                        <select id="campo_eliminarseguimiento_seguimientoDespacho_1" name="campo_eliminarseguimiento_seguimientoDespacho_1" style="width:95%">
                         <option></option>
                   <?php
				
						//$sql=$_consulta_login->query("select a.per_codigo,b.nombre,b.cargo from aplicativo_web.aaw_persona_perfil a left join aplicativo_web.vw_class_visorpermiso_permiso_0 b on a.per_codigo=b.per_codigo where a.pus_codigo=44 ");
                        $sql=$_consulta_login->query("select a.per_codigo,b.per_apellidos||' '||b.per_nombres,b.per_cargo_laboral from aplicativo_web.aaw_persona_perfil a left join aplicativo_web.aaw_persona b on a.per_codigo=b.per_codigo where a.pus_codigo=44 ");
						for($i=0;$i<count($sql);$i++){
							echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].' >>> '.$sql[$i][2].'</option>';
						}
				?>
                </select>
                  <script>
						$(function() {
							$("#campo_eliminarseguimiento_seguimientoDespacho_1").select2({  placeholder: "ESCOJA UNA OPCIÓN",allowClear: true});
						});
						</script>
                       

                        <a href="#" title="Ingrese un nuevo tipo." class="easyui-tooltip"><img src="<?php echo DIR_REL_IMG; ?>help-16.png" /></a>
                    </td>
			</tr>
			</tbody>
		</table>
	</form>
    
    
    <style>
#tbl_actualizarresponsables_seguimiento_despacho *{
font-size:11px !important;
letter-spacing: 0.1px;
}
#tbl_actualizarresponsables_seguimiento_despacho input{
border:0px;
}
#tbl_actualizarresponsables_seguimiento_despacho select{
border:0px;
border-bottom:1px solid #CCC;
}
</style>
    </div>
</div>