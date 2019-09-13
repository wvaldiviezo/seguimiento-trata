<?php
require_once dirname(dirname(dirname(dirname(__FILE__))))."/config.php";

//$_id=2;
if(isset($_SESSION['logueado'])){
  $_id= $_SESSION['Usuid'] ;
}

?>
<?php
$avance=0;
$height="100%";
$btn="Guardar";

//$_REQUEST["_id_registro_seguimiento"]=1;
if(isset($_REQUEST["_id_registro_seguimiento"]) && $_REQUEST["_id_registro_seguimiento"]!=NULL ){
  $avance=1;
  $rsql_maestro=$_consulta_sistema->query( "SELECT * FROM seguimiento_despacho_entrega.ssd_registro_seguimiento where rse_codigo='{$_REQUEST['_id_registro_seguimiento']}' limit 1;" );
  if(isset($_REQUEST["_id_plantilla_seguimiento"]) && $_REQUEST["_id_plantilla_seguimiento"]!=NULL ){
    $_REQUEST["_id_plantilla_seguimiento"];



  }else{
    $_REQUEST["_id_plantilla_seguimiento"]="Visor";
  }
}
if($avance==1){
  $btn="Actualizar";
  $height="97%";
  echo '<div style="padding:1px"><b>Código: </b>'.$rsql_maestro[0]['rse_codigo'].' <b>Nombre de la Actividad: </b>'.$rsql_maestro[0]['rse_nombre'].'</div>';

  $estado_actividad=$_consulta_sistema->query( "select ese_codigo from seguimiento_despacho_entrega.ssd_registro_seguimiento where rse_codigo='{$_REQUEST['_id_registro_seguimiento']}' limit 1; ");


  /* //buscamevisita
  $visita_responsable=$_consulta_sistema->query("select per_codigo_responsable from seguimiento_despacho_entrega.ssd_registro_seguimiento  where rse_codigo='{$_REQUEST['_id_registro_seguimiento']}' ");

  $visita_primera=$_consulta_sistema->query("select count(*) from seguimiento_despacho_entrega.ssd_visita_registro_seguimiento where per_codigo_visita='{$visita_responsable[0][0]}' ");
  if($visita_primera[0][0]==0){
  //$_consulta_sistema->query("update seguimiento_despacho_entrega.ssd_registro_seguimiento set ese_codigo=4 where rse_codigo='{$_REQUEST['_id_registro_seguimiento']}'; ");
  //echo "$('#tblVisorBusqueda_seguimiento_despacho').datagrid('reload');";
}

$visita=$_consulta_sistema->query("insert into seguimiento_despacho_entrega.ssd_visita_registro_seguimiento (vrs_codigo,rse_codigo,per_codigo_visita) values (default,'{$_REQUEST['_id_registro_seguimiento']}','{$_id}')");
*/

}
?>
<div class="easyui-tabs" style="width:100%;height:<?php echo $height ?>">
  <div title="Ficha General" style="padding:10px; background:rgba(187, 187, 187, 0.0170588)">
    <form  name="frm_fichageneral_seguimientoDespacho" id="frm_fichageneral_seguimientoDespacho" style="width:100%; height:auto; border:1px solid #CCC">
      <table align="center" id="tableFichaGeneral_seguimiento_despacho" width="99%" cellpadding="5" cellspacing="5">
        <tbody>
          <tr>
            <td colspan="6" style="background:#0072C6; color:#fff">INFORMACIÓN</td>
          </tr>
          <tr style="display:none; visibility:hidden">
            <td colspan="6">
              <?php
              if($avance==1){
                echo '<input name="campo_ingreso_seguimientoDespacho_0" readonly="readonly" value="'.$_REQUEST["_id_registro_seguimiento"].'"/>';
                echo '<input name="campo_ingreso_seguimientoDespacho_0_0" readonly="readonly" value="'.$_REQUEST["_id_plantilla_seguimiento"].'"/>';
              }else
              echo '<input name="campo_ingreso_seguimientoDespacho_0" readonly="readonly"/>';
              ?>
            </td>
          </tr>
          <tr>
            <td width="15%">
              <?php
              if ( in_array(40, $perfil,true) || in_array(41, $perfil,true)  ) :
                ?>
                <a onclick="actualizarGeneral_seguimientoDespacho()" class="easyui-linkbutton" data-options="iconCls:'icon-cloud'" style="width:100px"><?php echo $btn; ?></a>
                <script>
                function actualizarGeneral_seguimientoDespacho(){
                  $.messager.confirm('Confirmación','Está seguro que desea actualizar la ficha?.',function(r){
                    if (r){
                      $.ajax( "<?php echo DIR_REL ?>class/validador.php")
                      .done(function(result) {
                        if(result==1){
                          xajax_procesar_frm_fichageneral_seguimientoDespacho(xajax.getFormValues('frm_fichageneral_seguimientoDespacho', true));
                        }else if(result==0){
                          location.reload();
                        }
                      });

                    }
                  });
                }
                </script>
                <?php
              endif;
              ?>
            </td>
            <td colspan="5">
              <?php
              if($avance==1){
                $rsqlespecial=$_consulta_sistema->query("select count(*) from seguimiento_despacho_entrega.ssd_especial_registro_seguimiento where rse_codigo='{$rsql_maestro[0]['rse_codigo']}' and tes_codigo=2 ");
                if($rsqlespecial[0][0]>0)
                echo '<input name="campo_ingreso_seguimientoDespacho_1" type="checkbox" checked="checked" />';
                else
                echo '<input name="campo_ingreso_seguimientoDespacho_1" type="checkbox" />';
              }else if($avance==0){
                echo '<input name="campo_ingreso_seguimientoDespacho_1" type="checkbox" />';
              }
              ?>PRIORIZADO
              <?php
              if($avance==1){
                $rsqlespecial=$_consulta_sistema->query("select count(*) from seguimiento_despacho_entrega.ssd_especial_registro_seguimiento where rse_codigo='{$rsql_maestro[0]['rse_codigo']}' and tes_codigo=1 ");
                if($rsqlespecial[0][0]>0)
                echo '<input name="campo_ingreso_seguimientoDespacho_2" type="checkbox" checked="checked" />';
                else
                echo '<input name="campo_ingreso_seguimientoDespacho_2" type="checkbox" />';
              }else if($avance==0){
                echo '<input name="campo_ingreso_seguimientoDespacho_2"  type="checkbox" />';
              }
              ?>ESTRATÉGICO
            </td>
          </tr>
          <tr>
            <td><b>TIPO</b></td>
            <td>
              <select name="campo_ingreso_seguimientoDespacho_3" style="width:100%">
                <?php
                if($avance==1){
                  $sql=$_consulta_sistema->query("select tse_codigo,tse_nombre from seguimiento_despacho_entrega.ssd_tipo_seguimiento  where tse_codigo='{$rsql_maestro[0]['tse_codigo']}'");
                  for($i=0;$i<count($sql);$i++){
                    echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].'</option>';
                  }
                  $sql=$_consulta_sistema->query("select tse_codigo,tse_nombre from seguimiento_despacho_entrega.ssd_tipo_seguimiento  where tse_codigo!='{$rsql_maestro[0]['tse_codigo']}' order by tse_nombre");
                  for($i=0;$i<count($sql);$i++){
                    echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].'</option>';
                  }

                }else if($avance==0){
                  $sql=$_consulta_sistema->query("select tse_codigo,tse_nombre from seguimiento_despacho_entrega.ssd_tipo_seguimiento order by tse_nombre");
                  for($i=0;$i<count($sql);$i++){
                    echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].'</option>';
                  }
                }
                ?>
              </select>
            </td>
            <td><b>IMPORTANCIA</b></td>
            <td>

              <select name="campo_ingreso_seguimientoDespacho_4" style="width:100%">
                <?php
                if($avance==1){
                  $sql=$_consulta_sistema->query(" select ise_codigo,ise_nombre from seguimiento_despacho_entrega.ssd_impacto_seguimiento  where ise_codigo='{$rsql_maestro[0]['ise_codigo']}' ");
                  for($i=0;$i<count($sql);$i++){
                    echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].'</option>';
                  }
                  $sql=$_consulta_sistema->query(" select ise_codigo,ise_nombre from seguimiento_despacho_entrega.ssd_impacto_seguimiento  where ise_codigo!='{$rsql_maestro[0]['ise_codigo']}' order by ise_nombre ");
                  for($i=0;$i<count($sql);$i++){
                    echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].'</option>';
                  }

                }else if($avance==0){
                  $sql=$_consulta_sistema->query(" select ise_codigo,ise_nombre from seguimiento_despacho_entrega.ssd_impacto_seguimiento order by ise_nombre ");
                  for($i=0;$i<count($sql);$i++){
                    echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].'</option>';
                  }
                }
                ?>
              </select>



            </td>
            <td><b>AVANCE</b></td>
            <td>

              <select name="campo_ingreso_seguimientoDespacho_5" style="width:100%">
                <?php
                if($avance==1){
                  $sql=$_consulta_sistema->query(" select ase_codigo,ase_nombre from seguimiento_despacho_entrega.ssd_avance_seguimiento  where ase_codigo='{$rsql_maestro[0]['ase_codigo']}' ");
                  for($i=0;$i<count($sql);$i++){
                    echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].' %</option>';
                  }
                  $sql=$_consulta_sistema->query(" select ase_codigo,ase_nombre from seguimiento_despacho_entrega.ssd_avance_seguimiento  where ase_codigo!='{$rsql_maestro[0]['ase_codigo']}' order by ase_nombre ");
                  for($i=0;$i<count($sql);$i++){
                    echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].'</option>';
                  }

                }else if($avance==0){
                  $sql=$_consulta_sistema->query(" select ase_codigo,ase_nombre from seguimiento_despacho_entrega.ssd_avance_seguimiento order by ase_nombre ");
                  for($i=0;$i<count($sql);$i++){
                    echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].'</option>';
                  }
                }
                ?>
              </select>

            </td>
          </tr>
          <tr>
            <td><b>EJE</b></td>
            <td colspan="5">
              <select name="campo_ingreso_seguimientoDespacho_6" style="width:100%">
                <?php
                if($avance==1){
                  $sql=$_consulta_sistema->query("select ose_codigo,ose_nombre from seguimiento_despacho_entrega.ssd_origen_seguimiento  where ose_codigo='{$rsql_maestro[0]['ose_codigo']}'");
                  for($i=0;$i<count($sql);$i++){
                    echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].'</option>';
                  }
                  $sql=$_consulta_sistema->query("select ose_codigo,ose_nombre from seguimiento_despacho_entrega.ssd_origen_seguimiento  where ose_codigo!='{$rsql_maestro[0]['ose_codigo']}' order by ose_nombre");
                  for($i=0;$i<count($sql);$i++){
                    echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].'</option>';
                  }

                }else if($avance==0){
                  $sql=$_consulta_sistema->query("select ose_codigo,ose_nombre from seguimiento_despacho_entrega.ssd_origen_seguimiento order by ose_nombre");
                  for($i=0;$i<count($sql);$i++){
                    echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].'</option>';
                  }
                }
                ?>
              </select>
            </td>
          </tr>
          <tr>
            <td><b>OBJETIVO GENERAL</b></td>
            <td colspan="5">
              <select name="campo_ingreso_seguimientoDespacho_15" style="width:100%">
                <?php
                if($avance==1){
                  $sql=$_consulta_sistema->query("select og.ogs_codigo,og.ogs_nombre from	seguimiento_despacho_entrega.ssd_registro_seguimiento rs,seguimiento_despacho_entrega.ssd_objetivosgen_seguimmiento og,seguimiento_despacho_entrega.ssd_objetivosesp_seguimmiento oe where rs.oes_codigo = oe.oes_codigo and oe.ogs_codigo = og.ogs_codigo and	rse_codigo = '{$_REQUEST['_id_registro_seguimiento']}'");
                  for($i=0;$i<count($sql);$i++){
                    echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].'</option>';
                  }
                  $sql=$_consulta_sistema->query("select oes_codigo,oes_nombre from seguimiento_despacho_entrega.ssd_objetivosesp_seguimmiento  where oes_codigo!='{$rsql_maestro[0]['oes_codigo']}' order by oes_nombre");
                  for($i=0;$i<count($sql);$i++){
                    echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].'</option>';
                  }

                }else if($avance==0){
                  $sql=$_consulta_sistema->query("select oes_codigo,oes_nombre from seguimiento_despacho_entrega.ssd_objetivosesp_seguimmiento order by oes_nombre");
                  for($i=0;$i<count($sql);$i++){
                    echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].'</option>';
                  }
                }
                ?>
              </select>
            </td>
          </tr>
          <td><b>OBJETIVO ESPECÍFICO</b></td>
          <td colspan="5">
            <select name="campo_ingreso_seguimientoDespacho_15" style="width:100%">
              <?php
              if($avance==1){
                $sql=$_consulta_sistema->query("select oe.oes_codigo,oe.oes_nombre from	seguimiento_despacho_entrega.ssd_registro_seguimiento rs,seguimiento_despacho_entrega.ssd_objetivosgen_seguimmiento og,seguimiento_despacho_entrega.ssd_objetivosesp_seguimmiento oe where rs.oes_codigo = oe.oes_codigo and oe.ogs_codigo = og.ogs_codigo and	rse_codigo = '{$_REQUEST['_id_registro_seguimiento']}'");
                for($i=0;$i<count($sql);$i++){
                  echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].'</option>';
                }
                $sql=$_consulta_sistema->query("select oes_codigo,oes_nombre from seguimiento_despacho_entrega.ssd_objetivosesp_seguimmiento  where oes_codigo!='{$rsql_maestro[0]['oes_codigo']}' order by oes_nombre");
                for($i=0;$i<count($sql);$i++){
                  echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].'</option>';
                }

              }else if($avance==0){
                $sql=$_consulta_sistema->query("select oes_codigo,oes_nombre from seguimiento_despacho_entrega.ssd_objetivosesp_seguimmiento order by oes_nombre");
                for($i=0;$i<count($sql);$i++){
                  echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].'</option>';
                }
              }
              ?>
            </select>
          </td>
        </tr>
        <tr>
          <td><b>MONITOR</b></td>
          <td colspan="5">
            <select name="campo_ingreso_seguimientoDespacho_7" style="width:100%">
              <?php
              if($avance==1){
                $sql=$_consulta_login->query("select a.per_codigo,b.per_nombres from aplicativo_web.aaw_persona_perfil a left join aplicativo_web.vw_informacion_persona b on a.per_codigo=b.per_codigo where a.pus_codigo=41 and a.per_codigo='{$rsql_maestro[0]['per_codigo_monitor']}' ");
                for($i=0;$i<count($sql);$i++){
                  echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].'</option>';
                }
                $sql=$_consulta_login->query("select a.per_codigo,b.per_nombres from aplicativo_web.aaw_persona_perfil a left join aplicativo_web.vw_informacion_persona b on a.per_codigo=b.per_codigo where a.pus_codigo=41 and a.per_codigo!='{$rsql_maestro[0]['per_codigo_monitor']}' ");
                for($i=0;$i<count($sql);$i++){
                  echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].'</option>';
                }

              }else if($avance==0){
                $sql=$_consulta_login->query("select a.per_codigo,b.per_nombres from aplicativo_web.aaw_persona_perfil a left join aplicativo_web.vw_informacion_persona b on a.per_codigo=b.per_codigo where a.pus_codigo=41");
                for($i=0;$i<count($sql);$i++){
                  echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].'</option>';
                }
              }
              ?>
            </select>
          </td>
        </tr>
        <tr>
          <td><b>FECHA INICIO</b></td><!--wvaldiviezo FECHA INICIO-->
          <td colspan="1">
            <?php
            if($avance==1){
              echo '<input id="campo_ingreso_seguimientoDespacho_8_1" name="campo_ingreso_seguimientoDespacho_8_1" style="width:100%" value="'.$rsql_maestro[0]['rse_fecha_inicio'].'" />';
            }else if($avance==0){
              echo '<input id="campo_ingreso_seguimientoDespacho_8_1" name="campo_ingreso_seguimientoDespacho_8_1" style="width:100%" />';
            }
            ?>
          </td>
          <td><b>FECHA TÉRMINO</b></td>
          <td colspan="1">
            <?php
            if($avance==1){
              echo '<input id="campo_ingreso_seguimientoDespacho_8" name="campo_ingreso_seguimientoDespacho_8" style="width:100%" value="'.$rsql_maestro[0]['rse_fecha_fin'].'" />';
            }else if($avance==0){
              echo '<input id="campo_ingreso_seguimientoDespacho_8" name="campo_ingreso_seguimientoDespacho_8" style="width:100%" />';
            }
            ?>
          </td>
          <td><b>ESTADO DE GESTIÓN</b></td>
          <td colspan="2">
            <select name="campo_ingreso_seguimientoDespacho_9" id="campo_ingreso_seguimientoDespacho_9" style="width:100%">
              <?php
              if($avance==1){
                $sql=$_consulta_sistema->query(" select ese_codigo,ese_nombre,ese_icono from seguimiento_despacho_entrega.ssd_estado_seguimiento  where ese_codigo='{$rsql_maestro[0]['ese_codigo']}' ");
                for($i=0;$i<count($sql);$i++){
                  echo '<option value="'.$sql[$i][0].'" >'.$sql[$i][1].'</option>';
                }
                $sql=$_consulta_sistema->query(" select ese_codigo,ese_nombre from seguimiento_despacho_entrega.ssd_estado_seguimiento  where ese_codigo!='{$rsql_maestro[0]['ese_codigo']}' order by ese_nombre ");
                for($i=0;$i<count($sql);$i++){
                  echo '<option value="'.$sql[$i][0].'" >'.$sql[$i][1].'</option>';
                }

              }else if($avance==0){
                $sql=$_consulta_sistema->query(" select ese_codigo,ese_nombre,ese_icono from seguimiento_despacho_entrega.ssd_estado_seguimiento order by ese_codigo ");
                for($i=0;$i<count($sql);$i++){
                  echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].'</option>';
                }
              }
              ?>
            </select>
            <script>
            $(function() {

              $("#campo_ingreso_seguimientoDespacho_9").select2({
                placeholder: "ESCOJA UNA OPCIÓN",allowClear: true});
              });
              </script>
            </td>
          </tr>
          <tr>
            <td><b>ACCIÓN</b></td>
            <td colspan="5">
              <?php
              if($avance==1){
                echo '<input name="campo_ingreso_seguimientoDespacho_10" style="width:100%" value="'.$rsql_maestro[0]['rse_nombre'].'" />';
              }else if($avance==0){
                echo '<input name="campo_ingreso_seguimientoDespacho_10" style="width:100%" />';
              }
              ?>
            </td>
          </tr>
          <tr>
            <td><b>DETALLE</b></td>
            <td colspan="5">
              <?php
              if($avance==1){
                echo '<textarea name="campo_ingreso_seguimientoDespacho_11" style="width:100%; resize:none" rows="6" >'.$rsql_maestro[0]['rse_detalle'].'</textarea>';
              }else if($avance==0){
                echo '<textarea name="campo_ingreso_seguimientoDespacho_11" style="width:100%; resize:none" rows="6" /></textarea>';
              }
              ?>
            </td>
          </tr>
          <tr>
            <td><b>AVANCE</b></td>
            <td colspan="5">
              <?php
              if($avance==1){
                $rsqlavance=$_consulta_sistema->query("select ars_fecha,ars_avance,ars_codigo from seguimiento_despacho_entrega.ssd_avance_registro_seguimiento where rse_codigo='{$rsql_maestro[0]['rse_codigo']}' order by ars_codigo desc limit 1");
                if(isset($rsqlavance[0][0])){
                  if($rsqlavance[0][0]!=NULL){
                    echo "<em>Fecha de Registro:</em> ".FechaFormateada2(strtotime($rsqlavance[0][0])).' '.date('H:i',strtotime($rsqlavance[0][0]))."<br />";
                  }
                }else{
                  echo "<em>Fecha de Registro:</em> <br />";
                }

                echo '<textarea name="campo_ingreso_seguimientoDespacho_12" style="width:100%; resize:none" rows="6" >';
                //for($k=0;$k<count($rsqlavance);$k++){
                //echo "".FechaFormateada2(strtotime($rsqlavance[$k][0])).' '.date('H:i',strtotime($rsqlavance[$k][0]))." - ".$rsqlavance[$k][1]." \n";
                //}
                if(isset($rsqlavance[0][1])){
                  if($rsqlavance[0][1]!=NULL){
                    echo $rsqlavance[0][1];
                  }
                }else{
                  echo '';
                }

                echo '</textarea>';
                if(isset($rsqlavance[0][2])){
                  if($rsqlavance[0][2]!=NULL){
                    echo '<input style="display:none; visibility:hidden" name="campo_ingreso_seguimientoDespacho_12_1" value="'.$rsqlavance[0][2].'" >';
                  }else{
                    echo '<input style="display:none; visibility:hidden" name="campo_ingreso_seguimientoDespacho_12_1" value="" >';
                  }
                }else{
                  echo '<input style="display:none; visibility:hidden" name="campo_ingreso_seguimientoDespacho_12_1" value="" >';
                }
                if(isset($rsqlavance[0][0])){
                  if($rsqlavance[0][0]!=NULL){
                    echo '<br /><input name="campo_ingreso_seguimientoDespacho_12_2" type="checkbox" >Guardar en el historial?';
                  }
                }else{
                  echo '<br /><input name="campo_ingreso_seguimientoDespacho_12_2" type="checkbox" >Guardar en el historial?';
                }

              }else if($avance==0){
                echo '<textarea name="campo_ingreso_seguimientoDespacho_12" style="width:100%; resize:none" rows="6" /></textarea>';
              }
              ?>
            </td>
          </tr>
          <tr>
            <td><b>NOTAS</b></td>
            <td colspan="5">
              <?php
              if($avance==1){
                if(isset($rsql_maestro[0]['rse_nota'])){
                  echo '<textarea name="campo_ingreso_seguimientoDespacho_13" style="width:100%; resize:none" rows="6" >'.$rsql_maestro[0]['rse_nota'].'</textarea>';
                }else{
                  echo '<textarea name="campo_ingreso_seguimientoDespacho_13" style="width:100%; resize:none" rows="6" ></textarea>';
                }

              }else if($avance==0){
                echo '<textarea name="campo_ingreso_seguimientoDespacho_13" style="width:100%; resize:none" rows="6" /></textarea>';
              }
              ?>

            </td>
          </tr>
        </tbody>
      </table>
    </form>
    <style>
    #tableFichaGeneral_seguimiento_despacho input,select {
      border: none;
      border-bottom: 1px solid #ccc;
      background:#fff;
      padding:0px;
    }
    .ui-datepicker select.ui-datepicker-month, .ui-datepicker select.ui-datepicker-year{
      background:#fff;
    }
    #tableFichaGeneral_seguimiento_despacho textarea{
      border: 1px solid #ccc;
    }
    </style>
    <script>
    $(function() {
      $("#campo_ingreso_seguimientoDespacho_8").datepicker({
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
      $("#campo_ingreso_seguimientoDespacho_8_1").datepicker({
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
  </div>
  <?php
  if($avance==1):
    ?>
    <div title="Antecedentes" data-options="iconCls:'',closable:false" style="padding:10px; background:rgba(187, 187, 187, 0.0170588)">
      <form name="frm_fichaantecedentes_seguimientoDespacho" id="frm_fichaantecedentes_seguimientoDespacho" style="width:100%; height:auto; border:1px solid #CCC">
        <table id="tableFichaAntecedentes_seguimiento_despacho" width="99%" cellpadding="5" cellspacing="5">
          <tbody>
            <tr>
              <td colspan="2" style="background:#0072C6; color:#fff">INFORMACIÓN</td>
            </tr>
            <tr style="display:none; visibility:hidden">
              <td colspan="2">
                <?php
                if($avance==1){
                  echo '<input  name="campo_antecedentes_seguimientoDespacho_0" readonly="readonly" value="'.$_REQUEST["_id_registro_seguimiento"].'"/>';
                  echo '<input name="campo_antecedentes_seguimientoDespacho_0_0" readonly="readonly" value="'.$_REQUEST["_id_plantilla_seguimiento"].'"/>';
                }else
                echo '<input name="campo_antecedentes_seguimientoDespacho_0" readonly="readonly"/>';
                ?>
              </td>
            </tr>
            <tr>
              <td width="15%"><b>INGRESE UN ANTECEDENTE</b></td>
              <td>
                <textarea name="campo_antecedentes_seguimientoDespacho_1" style="width:99%; resize:none" rows="4" />
              </td>
            </tr>

            <tr>
              <td><b>FECHA</b></td>
              <td valign="top" ><input id="campo_antecedentes_seguimientoDespacho_2" name="campo_antecedentes_seguimientoDespacho_2" value="<?php echo date("Y-m-d") ?>" style="width:40%" />
                <?php
                if ( in_array(40, $perfil,true) || in_array(41, $perfil,true)  ) :
                  ?>
                  <a onclick="actualizarAntecedentes_seguimientoDespacho()" class="easyui-linkbutton" data-options="iconCls:'icon-cloud'" style="width:100px">Añadir</a>
                  <script>
                  function actualizarAntecedentes_seguimientoDespacho(){
                    $.messager.confirm('Confirmación','Está seguro que desea actualizar la ficha?.',function(r){
                      if (r){
                        $.ajax( "<?php echo DIR_REL ?>class/validador.php")
                        .done(function(result) {
                          if(result==1){
                            xajax_procesar_frm_fichaantecedentes_seguimientoDespacho(xajax.getFormValues('frm_fichaantecedentes_seguimientoDespacho', true));
                          }else if(result==0){
                            location.reload();
                          }
                        });

                      }
                    });
                  }
                  </script>
                <?php endif; ?>
              </td>
            </tr>

            <tr>
              <td style="border-bottom:1px solid #CCC" colspan="2">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2"  ><b>ANTECEDENTES REGISTRADOS</b></td>
            </tr>

            <tr>


              <td  colspan="2" valign="top">
                <?php
                if($avance==1){
                  $rsqlavance=$_consulta_sistema->query("select count(*) from seguimiento_despacho_entrega.ssd_antecedentes_registro_seguimiento where  rse_codigo='{$rsql_maestro[0]['rse_codigo']}' ");
                  if( count($rsqlavance[0][0]>0) ){
                    $rsql=$_consulta_sistema->query("select anr_fecha,anr_antecedente from seguimiento_despacho_entrega.ssd_antecedentes_registro_seguimiento a where a.rse_codigo='{$rsql_maestro[0]['rse_codigo']}' order by anr_fecha desc");
                    echo '<div style="width:98%; border:1px solid #ccc; padding:5px; background: #fff;"  >';
                    for($k=0;$k<count($rsql);$k++){
                      echo "<b>FECHA REGISTRO: </b>".FechaFormateada2(strtotime($rsql[$k][0]))."<br /><b>ANTECEDENTE: </b>".$rsql[$k][1]."</br><hr color=\"#e2e2e2\">";
                    }
                    echo '</div>';
                  }else{
                    echo '<div style="width:100%;"></div>';
                  }
                }else if($avance==0){
                  echo '<div style="width:100%;"></div>';
                }
                ?>
              </td>


            </tr>
          </tbody>
        </table>
      </form>
      <style>
      #tableFichaAntecedentes_seguimiento_despacho input,select {
        border: none;
        border-bottom: 1px solid #ccc;
        background:#fff;
        padding:0px;
      }
      .ui-datepicker select.ui-datepicker-month, .ui-datepicker select.ui-datepicker-year{
        background:#fff;
      }
      #tableFichaAntecedentes_seguimiento_despacho textarea{
        border: 1px solid #ccc;
      }
      </style>
      <script>
      $(function() {
        $("#campo_antecedentes_seguimientoDespacho_2").datepicker({
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
    </div>
    <div title="Participantes" data-options="iconCls:'',closable:false" style="padding:10px; background:rgba(187, 187, 187, 0.0170588)">
      <form name="frm_fichaparticipantes_seguimientoDespacho" id="frm_fichaparticipantes_seguimientoDespacho" style="width:100%; height:auto; border:1px solid #CCC">
        <table align="center" id="tableFichaParticipantes_seguimiento_despacho" width="99%" cellpadding="5" cellspacing="5">
          <tbody>
            <tr>
              <td colspan="2" style="background:#0072C6; color:#fff">INFORMACIÓN</td>
            </tr>
            <tr style="display:none; visibility:hidden">
              <td colspan="2">
                <?php
                if($avance==1){
                  echo '<input id="campo_participantes_seguimientoDespacho_0" name="campo_participantes_seguimientoDespacho_0" readonly="readonly" value="'.$_REQUEST["_id_registro_seguimiento"].'"/>';
                  echo '<input name="campo_participantes_seguimientoDespacho_0_0" readonly="readonly" value="'.$_REQUEST["_id_plantilla_seguimiento"].'"/>';
                }else
                echo '<input name="campo_participantes_seguimientoDespacho_0" readonly="readonly"/>';
                ?>
              </td>
            </tr>
            <tr>
              <td width="15%"><b>USUARIO</b></td>
              <td>
                <select id="campo_participantes_seguimientoDespacho_1" name="campo_participantes_seguimientoDespacho_1" style="width:100%">
                  <?php
                  if($avance==1){
                    $sql0=$_consulta_sistema->query("SELECT per_codigo_responsable FROM seguimiento_despacho_entrega.ssd_registro_seguimiento where rse_codigo='{$_REQUEST['_id_registro_seguimiento']}' ");
                    $sql1=$_consulta_sistema->query("select per_codigo_corresponsable from seguimiento_despacho_entrega.ssd_corresponsable_seguimiento where rse_codigo='{$_REQUEST['_id_registro_seguimiento']}' ");
                    $sql2=$_consulta_sistema->query("select per_codigo_participante from seguimiento_despacho_entrega.ssd_participante_seguimiento where rse_codigo='{$_REQUEST['_id_registro_seguimiento']}' ");
                    $quitar=" ";
                    for($i=0;$i<count($sql0);$i++){
                      if(isset($sql0[$i][0]) and $sql0[$i][0]!=NULL)
                      $quitar.=" and a.per_codigo!='".$sql0[$i][0]."' ";
                    }
                    for($i=0;$i<count($sql1);$i++){
                      if(isset($sql1[$i][0]) and $sql1[$i][0]!=NULL)
                      $quitar.=" and a.per_codigo!='".$sql1[$i][0]."' ";
                    }
                    for($i=0;$i<count($sql2);$i++){
                      if(isset($sql2[$i][0]) and $sql2[$i][0]!=NULL)
                      $quitar.=" and a.per_codigo!='".$sql2[$i][0]."' ";
                    }
                    //echo $quitar;
                    $sql=$_consulta_login->query(" select a.per_codigo,b.nombre,b.cargo from aplicativo_web.aaw_persona_perfil a left join aplicativo_web.vw_class_visorpermiso_permiso_0 b on a.per_codigo=b.per_codigo where (a.pus_codigo=42 or a.pus_codigo=43)  ".$quitar." ");
                    for($i=0;$i<count($sql);$i++){
                      echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].' >>> '.$sql[$i][2].'</option>';
                    }
                    /*$sql=$_consulta_login->query(" select a.per_codigo,b.nombre,b.cargo from aplicativo_web.aaw_persona_perfil a left join aplicativo_web.vw_class_visorpermiso_permiso_0 b on a.per_codigo=b.per_codigo where a.pus_codigo=43 and a.per_codigo!='{$rsql_maestro[0]['per_codigo_monitor']}' ");
                    for($i=0;$i<count($sql);$i++){
                    echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].' >>> '.$sql[$i][2].'</option>';
                  }*/
                }else if($avance==0){
                  $sql=$_consulta_login->query("select a.per_codigo,b.nombre,b.cargo from aplicativo_web.aaw_persona_perfil a left join aplicativo_web.vw_class_visorpermiso_permiso_0 b on a.per_codigo=b.per_codigo where (a.pus_codigo=42 or a.pus_codigo=43) ");
                  for($i=0;$i<count($sql);$i++){
                    echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].' >>> '.$sql[$i][2].'</option>';
                  }
                }
                ?>
              </select>

              <script>
              $(function() {
                $("#campo_participantes_seguimientoDespacho_1").select2({  placeholder: "ESCOJA UNA OPCIÓN",allowClear: true});
              });
              </script>
            </td>
          </tr>
          <tr>
            <td><b>TIPO</b></td>
            <td>
              <select name="campo_participantes_seguimientoDespacho_2" style="width:40%; height:100%">
                <option value="3">RESPONSABLE</option>
                <option value="1">CORRESPONSABLE</option>
                <option value="2">PARTICIPANTE</option>
              </select>
              <?php
              if ( in_array(40, $perfil,true) || in_array(41, $perfil,true)  ) :
                ?>
                <a onclick="actualizarParticipantes_seguimientoDespacho()" class="easyui-linkbutton" data-options="iconCls:'icon-cloud'" style="width:100px">Añadir</a>
                <script>
                function actualizarParticipantes_seguimientoDespacho(){
                  $.messager.confirm('Confirmación','Está seguro que desea actualizar la ficha?.',function(r){
                    if (r){
                      $.ajax( "<?php echo DIR_REL ?>class/validador.php")
                      .done(function(result) {
                        if(result==1){
                          xajax_procesar_frm_fichaparticipantes_seguimientoDespacho(xajax.getFormValues('frm_fichaparticipantes_seguimientoDespacho', true));
                        }else if(result==0){
                          location.reload();
                        }
                      });

                    }
                  });
                }
                </script>
              <?php endif; ?>

            </td>
          </tr>


          <tr>
            <td style="border-bottom:1px solid #CCC" colspan="2">&nbsp;</td>
          </tr>

          <tr>
            <td colspan="2"><b>RESPONSABLE</b>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <div  style="width: 95%; padding-left: 10px; padding-bottom: 10px">

                <?php

                if($avance==1){
                  if($rsql_maestro[0]['per_codigo_responsable']!=NULL){
                    $rsqlpersona=$_consulta_login->query(" select nombre,cargo from aplicativo_web.vw_class_visorpermiso_permiso_0 where  per_codigo='{$rsql_maestro[0]['per_codigo_responsable']}' ");
                    if ( in_array(40, $perfil,true) || in_array(41, $perfil,true)  ){
                      echo '<div id="camposResp" style="width:99%; border:1px solid #ccc; padding:5px; background: #fff;" >'.
                      '<img id="elimina_resp" name="elimina_resp" onclick="eliminaResp()" src="'.DIR_LOCAL_IMG_SEGUIMIENTO_DESPACHO.'nook_16.png"/>'.
                      '<b>NOMBRE:</b> '.$rsqlpersona[0][0].'<br /><b>CARGO:</b> '.$rsqlpersona[0][1].'</div>';
                    }else{
                      echo '<div id="camposResp" style="width:99%; border:1px solid #ccc; padding:5px; background: #fff;" >'.
                      '<b>NOMBRE:</b> '.$rsqlpersona[0][0].'<br /><b>CARGO:</b> '.$rsqlpersona[0][1].'</div>';
                    }


                  }else{
                    echo '<div style="width:100%; border:1px solid #ccc;" ></div>';
                  }

                }else if($avance==0){
                  echo '<div style="width:100%;" ></div>';
                }
                ?>


              </div>
              <script type="text/javascript">
              function eliminaResp(){
                $.messager.confirm('Confirmación','Está seguro que desea eliminar al responsable?.',function(r){
                  if (r){
                    $.ajax( "<?php echo DIR_REL.'seguimiento_despacho/src/contenido/admin/participantesedit.php?tipoper=1&actividad='.$_REQUEST["_id_registro_seguimiento"]?>")
                    .done(function(result) {
                      $("#camposResp").remove();
                    });

                  }
                });
              }
              </script>

            </td>
          </tr>

          <tr>
            <td colspan="2">

              <table  width="100%" cellpadding="2" cellspacing="2">
                <tr>
                  <td width="50%"><b>CORRESPONSABLES</b></td>
                  <td width="50%"><b>PARTICIPANTES</b></td>
                </tr>
                <tr>
                  <td  colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td valign="top">
                    <?php
                    if($avance==1){
                      $rsqlcorresponsable=$_consulta_sistema->query("select per_codigo_corresponsable from  seguimiento_despacho_entrega.ssd_corresponsable_seguimiento where rse_codigo='{$rsql_maestro[0]['rse_codigo']}'");
                      echo '<div style="width:98%; border:1px solid #ccc; padding:5px; background: #fff;"  >';
                      for($k=0;$k<count($rsqlcorresponsable);$k++){
                        if($rsqlcorresponsable[$k][0]!=NULL){
                          $rsqlpersona=$_consulta_login->query(" select nombre,cargo from aplicativo_web.vw_class_visorpermiso_permiso_0 where  per_codigo='{$rsqlcorresponsable[$k][0]}' ");
                          //echo "<b>NOMBRE: </b>".$rsqlpersona[0][0]."<br/><b>CARGO: </b>".$rsqlpersona[0][1];
                          if ( in_array(40, $perfil,true) || in_array(41, $perfil,true)  ){
                            echo '<div id="camposcoResp_'.$rsqlcorresponsable[$k][0].'" style="width: 95%; padding-left: 10px; padding-bottom: 10px">'.
                            '<div style="width:99%; border:0px; padding:5px; background: #fff;" >'.
                            '<img id="elimina_resp_'.$rsqlcorresponsable[$k][0].'" name="elimina_resp_'.$rsqlcorresponsable[$k][0].'" onclick="eliminacoResp('.$rsqlcorresponsable[$k][0].')" src="'.DIR_LOCAL_IMG_SEGUIMIENTO_DESPACHO.'nook_16.png"/>'.
                            '<b>NOMBRE:</b> '.$rsqlpersona[0][0].'<br /><b>CARGO:</b> '.$rsqlpersona[0][1].
                            '</div></div>';
                          }else{
                            echo '<div id="camposcoResp_'.$rsqlcorresponsable[$k][0].'" style="width: 95%; padding-left: 10px; padding-bottom: 10px">'.
                            '<div style="width:99%; border:0px; padding:5px; background: #fff;" >'.
                            '<b>NOMBRE:</b> '.$rsqlpersona[0][0].'<br /><b>CARGO:</b> '.$rsqlpersona[0][1].
                            '</div></div>';
                          }
                        }
                      }
                      echo "</div>";
                    }else if($avance==0){
                      echo '<div style="width:100%; border:1px solid #ccc;" ></div>';
                    }

                    ?>

                  </td>
                  <td valign="top">
                    <?php
                    if($avance==1){
                      $rsqlparticipante=$_consulta_sistema->query("select per_codigo_participante from  seguimiento_despacho_entrega.ssd_participante_seguimiento where rse_codigo='{$rsql_maestro[0]['rse_codigo']}'");
                      echo '<div style="width:98%; border:1px solid #ccc; padding:5px; background: #fff;"  >';
                      for($k=0;$k<count($rsqlparticipante);$k++){
                        if($rsqlparticipante[$k][0]!=NULL){
                          $rsqlpersona=$_consulta_login->query(" select nombre,cargo from aplicativo_web.vw_class_visorpermiso_permiso_0 where  per_codigo='{$rsqlparticipante[$k][0]}' ");
                          //echo "<b>NOMBRE: </b>".$rsqlpersona[0][0]."<br/><b>CARGO: </b>".$rsqlpersona[0][1];
                          if ( in_array(40, $perfil,true) || in_array(41, $perfil,true)  ){
                            echo '<div id="camposPart_'.$rsqlparticipante[$k][0].'" style="width: 95%; padding-left: 10px; padding-bottom: 10px">'.
                            '<div style="width:99%; border:0px; padding:5px; background: #fff;" >'.
                            '<img id="elimina_part_'.$rsqlparticipante[$k][0].'" name="elimina_part_'.$rsqlparticipante[$k][0].'" onclick="eliminaPart('.$rsqlparticipante[$k][0].')" src="'.DIR_LOCAL_IMG_SEGUIMIENTO_DESPACHO.'nook_16.png"/>'.
                            '<b>NOMBRE:</b> '.$rsqlpersona[0][0].'<br /><b>CARGO:</b> '.$rsqlpersona[0][1].
                            '</div></div>';
                          }else{
                            echo '<div id="camposPart_'.$rsqlparticipante[$k][0].'" style="width: 95%; padding-left: 10px; padding-bottom: 10px">'.
                            '<div style="width:99%; border:0px; padding:5px; background: #fff;" >'.
                            '<b>NOMBRE:</b> '.$rsqlpersona[0][0].'<br /><b>CARGO:</b> '.$rsqlpersona[0][1].
                            '</div></div>';
                          }
                        }
                      }
                      echo "</div>";
                    }else if($avance==0){
                      echo '<div style="width:100%; border:1px solid #ccc;" ></div';
                    }
                    ?>

                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </tbody>
      </table>
      <script type="text/javascript">
      function eliminacoResp(id){
        $.messager.confirm('Confirmación','Está seguro que desea eliminar al coresponsable?.',function(r){
          if (r){
            $.ajax( "<?php echo DIR_REL.'seguimiento_despacho/src/contenido/admin/participantesedit.php?tipoper=2&actividad='.$_REQUEST["_id_registro_seguimiento"].'&persona='?>"+id)
            .done(function(result) {
              $("#camposcoResp_"+id).remove();
            });

          }
        });
      }
      function eliminaPart(id){
        $.messager.confirm('Confirmación','Está seguro que desea eliminar al participantes?.',function(r){
          if (r){
            $.ajax( "<?php echo DIR_REL.'seguimiento_despacho/src/contenido/admin/participantesedit.php?tipoper=3&actividad='.$_REQUEST["_id_registro_seguimiento"].'&persona='?>"+id)
            .done(function(result) {
              $("#camposPart_"+id).remove();
            });

          }
        });
      }
      </script>
    </form>
    <style>
    #tableFichaParticipantes_seguimiento_despacho input,select {
      border: none;
      border-bottom: 1px solid #ccc;
      background:#fff;
      padding:0px;
    }
    .ui-datepicker select.ui-datepicker-month, .ui-datepicker select.ui-datepicker-year{
      background:#fff;
    }
    #tableFichaParticipantes_seguimiento_despacho textarea{
      border: 1px solid #ccc;
    }
    </style>
  </div>

  <div title="Avances" data-options="iconCls:'',closable:false" style="padding:10px; background:rgba(187, 187, 187, 0.0170588)">
    <form name="frm_fichaavances_seguimientoDespacho" id="frm_fichaavances_seguimientoDespacho" style="width:100%; height:auto; border:1px solid #CCC"">
      <table id="tableFichAvances_seguimiento_despacho" width="99%" cellpadding="5" cellspacing="5">
        <tbody>
          <tr>
            <td colspan="2" style="background:#0072C6; color:#fff">INFORMACIÓN</td>
          </tr>
          <tr style="display:none; visibility:hidden">
            <td colspan="2">
              <?php
              if($avance==1){
                echo '<input  name="campo_avances_seguimientoDespacho_0" readonly="readonly" value="'.$_REQUEST["_id_registro_seguimiento"].'"/>';
                echo '<input name="campo_avances_seguimientoDespacho_0_0" readonly="readonly" value="'.$_REQUEST["_id_plantilla_seguimiento"].'"/>';
              }else
              echo '<input name="campo_avances_seguimientoDespacho_0" readonly="readonly"/>';
              ?>
            </td>
          </tr>


          <tr>
            <td width="15%"><b>ESCRIBA UN REPORTE DE AVANCE</b></td>
            <td>
              <textarea maxlength="750" name="campo_avances_seguimientoDespacho_1"  style="width:100%; resize:none" rows="4" />
            </td>
          </tr>

          <tr>
            <td><b>% DE AVANCE</b></td>
            <td valign="top" ><select name="campo_avances_seguimientoDespacho_2" style="width:40%">
              <?php
              $sql=$_consulta_sistema->query("select ase_codigo,ase_nombre from seguimiento_despacho_entrega.ssd_avance_seguimiento order by ase_nombre");
              for($i=0;$i<count($sql);$i++){
                echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].'</option>';
              }
              ?></select>
              <?php
              if ( in_array(40, $perfil,true) || in_array(41, $perfil,true) || in_array(42, $perfil,true)  || in_array(43, $perfil,true)  ) :
                if($estado_actividad[0][0]!=5 || $estado_actividad[0][0]!=7 || $estado_actividad[0][0]!=8 || $estado_actividad[0][0]!=9 || $estado_actividad[0][0]!=10) :
                  ?>

                  <a onclick="actualizarAvances_seguimientoDespacho()" class="easyui-linkbutton" data-options="iconCls:'icon-cloud'" style="width:100px">Enviar</a>
                  <script>
                    function actualizarAvances_seguimientoDespacho(){
                      $.messager.confirm('Confirmación','Está seguro que desea actualizar la ficha?.',function(r){
                        if (r){
                          $.ajax( "<?php echo DIR_REL ?>class/validador.php")
                          .done(function(result) {
                            if(result==1){
                              xajax_procesar_frm_fichaavances_seguimientoDespacho(xajax.getFormValues('frm_fichaavances_seguimientoDespacho', true));
                            }else if(result==0){
                              location.reload();
                            }
                          });

                        }
                      });
                    }
                  </script>
                <?php endif; endif; ?>
              </td>
            </tr>

            <tr>
              <td style="border-bottom:1px solid #CCC" colspan="2">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2"  ><b>HISTORIAL DE REPORTES</b></td>
            </tr>
            <tr>

              <td colspan="2" valign="top">
                <?php
                if($avance==1){
                  $rsqlavances=$_consulta_sistema->query("select count(*) from seguimiento_despacho_entrega.ssd_avances_registro_seguimiento");
                  if( count($rsqlavances[0][0]>0) ){
                    $rsql=$_consulta_sistema->query("select a.avr_fecha_escrito,a.per_codigo_revision,a.avr_fecha_revision,a.per_codigo_escrito,a.avr_avance,era_codigo,avr_codigo,b.ase_nombre from seguimiento_despacho_entrega.ssd_avances_registro_seguimiento a left join seguimiento_despacho_entrega.ssd_avance_seguimiento b on a.ase_codigo=b.ase_codigo where a.rse_codigo='{$rsql_maestro[0]['rse_codigo']}' and era_codigo!=4 order by a.avr_fecha_escrito desc");
                    echo '<div style="width:98%; border:1px solid #ccc; padding:5px; background: #fff;"  >';
                    //$avance=$rsql[$k][6].$rsql[$k][4];
                    //$avance="".FechaFormateada2(strtotime($rsql[$k][0])).' '.date('H:i',strtotime($rsql[$k][0]))." - ".$rsql[$k][4]." \n";
                    for($k=0;$k<count($rsql);$k++){
                      if($rsql[$k][1]!=NULL)
                      $rsqlpersona0=$_consulta_login->query(" select per_nombres from aplicativo_web.vw_informacion_persona where  per_codigo='{$rsql[$k][1]}' ");
                      $rsqlpersona1=$_consulta_login->query(" select per_nombres from aplicativo_web.vw_informacion_persona where  per_codigo='{$rsql[$k][3]}' ");
                      if($rsql[$k][5]==1){
                        if ( in_array(40, $perfil,true) || in_array(41, $perfil,true)  ) :
                          echo '<img onclick="revision_avance_seguimiento_despacho('.$rsql[$k][6].',2)" src="'.DIR_LOCAL_IMG_SEGUIMIENTO_DESPACHO.'ok_16.png"><img onclick="revision_avance_seguimiento_despacho('.$rsql[$k][6].',3)" src="'.DIR_LOCAL_IMG_SEGUIMIENTO_DESPACHO.'nook_16.png">';
                        endif;
                        if ( in_array(40, $perfil,true) || in_array(41, $perfil,true) || in_array(42, $perfil,true) || in_array(43, $perfil,true)  ) :
                          if($rsql[$k][3]==$_id){
                            echo '<img onclick="revision_avance_seguimiento_despacho('.$rsql[$k][6].',4)" src="'.DIR_LOCAL_IMG_SEGUIMIENTO_DESPACHO.'destroy_16.png"><br />';
                          }
                        endif;
                      }

                      if($rsql[$k][1]!=NULL){
                        if($rsql[$k][5]==2){
                          if ( in_array(40, $perfil,true) || in_array(41, $perfil,true)  ) :
                            echo '<img onclick="revision_avance_seguimiento_despacho('.$rsql[$k][6].',1)" src="'.DIR_LOCAL_IMG_SEGUIMIENTO_DESPACHO.'volver_16.png"><br />';
                          endif;
                          echo "<b style=\"color:green\">APROBADO POR: </b> ".$rsqlpersona0[0][0]." <b>EL DÍA </b> ".FechaFormateada2(strtotime($rsql[$k][2])).' '.date('H:i',strtotime($rsql[$k][2]))."<br />";
                        }
                        if($rsql[$k][5]==3){
                          if ( in_array(40, $perfil,true) || in_array(41, $perfil,true)  ) :
                            echo '<img onclick="revision_avance_seguimiento_despacho('.$rsql[$k][6].',1)" src="'.DIR_LOCAL_IMG_SEGUIMIENTO_DESPACHO.'volver_16.png"><br />';
                          endif;
                          echo "<b style=\"color:red\">RECHAZADO POR: </b> ".$rsqlpersona0[0][0]." <b>EL DÍA </b> ".FechaFormateada2(strtotime($rsql[$k][2])).' '.date('H:i',strtotime($rsql[$k][2]))."<br />";
                        }
                      }
                      echo "<b>% DE AVANCE:</b> ".$rsql[$k][7]."<br />";
                      echo "<b>ESCRITO POR: </b> ".$rsqlpersona1[0][0]." <b>EL DÍA </b> ".FechaFormateada2(strtotime($rsql[$k][0])).' '.date('H:i',strtotime($rsql[$k][0]))." <br><b>AVANCE: </b>".$rsql[$k][4]." <br/><hr color=\"#e2e2e2\">";
                    }

                    echo '</div>';
                  }else{
                    echo '<div style="width:100%;" ></div>';
                  }
                }else if($avance==0){
                  echo '<div style="width:100%;"></div>';
                }
                ?>
              </td>

            </td>
          </tr>




        </tbody>
      </table>
    </form>
    <?php
    echo '<form style="display:none; visibility:hidden" name="frm_fichaavance_revision_seguimientoDespacho"  id="frm_fichaavance_revision_seguimientoDespacho"><input name="campo_avance_revision_seguimientoDespacho_0" readonly="readonly" value="'.$_REQUEST["_id_registro_seguimiento"].'"><input readonly="readonly" name="campo_avance_revision_seguimientoDespacho_1" id="campo_avance_revision_seguimientoDespacho_1" ><input readonly="readonly" name="campo_avance_revision_seguimientoDespacho_2" id="campo_avance_revision_seguimientoDespacho_2" ></form>
    <script>
    function revision_avance_seguimiento_despacho(id,opcion){
      $("#campo_avance_revision_seguimientoDespacho_1").val(id);
      $("#campo_avance_revision_seguimientoDespacho_2").val(opcion);
      $.messager.confirm(\'Confirmación\',\'Está seguro que desea actualizar este avance?.\',function(r){
        if (r){
          $.ajax( "'.DIR_REL.'class/validador.php")
          .done(function(result) {
            if(result==1){
              xajax_procesar_frm_fichaavance_revision_seguimientoDespacho(xajax.getFormValues(\'frm_fichaavance_revision_seguimientoDespacho\', true));
            }else if(result==0){
              location.reload();
            }
          });

        }
      });


    }
    </script>
    ';

    ?>
    <style>
      #tableFichAvances_seguimiento_despacho input,select {
        border: none;
        border-bottom: 1px solid #ccc;
        background:#fff;
        padding:0px;
      }
      .ui-datepicker select.ui-datepicker-month, .ui-datepicker select.ui-datepicker-year{
        background:#fff;
      }
      #tableFichAvances_seguimiento_despacho textarea{
        border: 1px solid #ccc;
      }
    </style>

  </div>
  <div title="Mensajes" data-options="iconCls:'',closable:false" style="padding:10px; background:rgba(187, 187, 187, 0.0170588)">
    <form name="frm_fichamensajes_seguimientoDespacho" id="frm_fichamensajes_seguimientoDespacho" style="width:100%; height:auto; border:1px solid #CCC">
      <table id="tableFichaMensajes_seguimiento_despacho" width="99%" cellpadding="5" cellspacing="5">
        <tbody>
          <tr>
            <td colspan="2" style="background:#0072C6; color:#fff">INFORMACIÓN</td>
          </tr>
          <tr style="display:none; visibility:hidden">
            <td colspan="2">
              <?php
              if($avance==1){
                echo '<input  name="campo_mensajes_seguimientoDespacho_0" readonly="readonly" value="'.$_REQUEST["_id_registro_seguimiento"].'"/>';
                echo '<input name="campo_mensajes_seguimientoDespacho_0_0" readonly="readonly" value="'.$_REQUEST["_id_plantilla_seguimiento"].'"/>';
              }else
              echo '<input name="campo_mensajes_seguimientoDespacho_0" readonly="readonly"/>';
              ?>
            </td>
          </tr>



          <tr>
            <td width="15%"><b>ESCRIBA UN MENSAJE</b></td>
            <td>
              <textarea maxlength="750" name="campo_mensajes_seguimientoDespacho_1" style="width:100%; resize:none" rows="4"/>
            </td>
          </tr>

          <tr>
            <td valign="top" align="left" >
              <?php
              if (in_array(41, $perfil,true)  ) {
                ?>
                <a onclick="actualizarMensajes_seguimientoDespacho()" class="easyui-linkbutton" data-options="iconCls:'icon-cloud'" style="width:100px">Enviar</a>

                <?php
              }ELSE{
                if ( in_array(40, $perfil,true) || in_array(42, $perfil,true)  || in_array(43, $perfil,true)  ) :

                  $select=$_consulta_sistema->query("select count(*) from seguimiento_despacho_entrega.ssd_avances_registro_seguimiento where rse_codigo='{$_REQUEST['_id_registro_seguimiento']}'; ");
                  if($select[0][0]>0):
                    if($estado_actividad[0][0]!=5 || $estado_actividad[0][0]!=7 || $estado_actividad[0][0]!=8 || $estado_actividad[0][0]!=9 || $estado_actividad[0][0]!=10) :
                      ?>
                      <a onclick="actualizarMensajes_seguimientoDespacho()" class="easyui-linkbutton" data-options="iconCls:'icon-cloud'" style="width:100px">Enviar</a>

                    <?php       endif;
                  endif;
                endif;
              }?>
              <script>
                function actualizarMensajes_seguimientoDespacho(){
                  $.messager.confirm('Confirmación','Está seguro que desea actualizar la ficha?.',function(r){
                    if (r){
                      $.ajax( "<?php echo DIR_REL ?>class/validador.php")
                      .done(function(result) {
                        if(result==1){
                          xajax_procesar_frm_fichamensajes_seguimientoDespacho(xajax.getFormValues('frm_fichamensajes_seguimientoDespacho', true));
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
            <td style="border-bottom:1px solid #CCC" colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2"  ><b>HISTORIAL DE MENSAJES</b></td>
          </tr>
          <tr>


            <td colspan="2" valign="top">
              <?php
              if($avance==1){
                $rsqlmensaje=$_consulta_sistema->query("select count(*) from seguimiento_despacho_entrega.ssd_mensaje_registro_seguimiento");
                if( count($rsqlmensaje[0][0]>0) ){
                  $rsql=$_consulta_sistema->query("select a.mrs_fecha_escrito,a.per_codigo_revision,a.mrs_fecha_revision,a.per_codigo_escrito,a.mrs_mensaje,a.era_codigo,a.mrs_codigo from seguimiento_despacho_entrega.ssd_mensaje_registro_seguimiento a where a.rse_codigo='{$rsql_maestro[0]['rse_codigo']}' and era_codigo!=8 order by a.mrs_fecha_escrito desc ");
                  echo '<div style="width:98%; border:1px solid #ccc; padding:5px; background: #fff;"  >';
                  //$avance=$rsql[$k][6].$rsql[$k][4];
                  //$avance="".FechaFormateada2(strtotime($rsql[$k][0])).' '.date('H:i',strtotime($rsql[$k][0]))." - ".$rsql[$k][4]." \n";
                  for($k=0;$k<count($rsql);$k++){
                    if($rsql[$k][1]!=NULL)
                    $rsqlpersona0=$_consulta_login->query(" select per_nombres from aplicativo_web.vw_informacion_persona where  per_codigo='{$rsql[$k][1]}' ");
                    $rsqlpersona1=$_consulta_login->query(" select per_nombres from aplicativo_web.vw_informacion_persona where  per_codigo='{$rsql[$k][3]}' ");


                    if($rsql[$k][5]==5){
                      if ( in_array(40, $perfil,true) || in_array(41, $perfil,true)  ) :
                        echo '<img onclick="revision_mensaje_seguimiento_despacho('.$rsql[$k][6].',6)" src="'.DIR_LOCAL_IMG_SEGUIMIENTO_DESPACHO.'ok_16.png"><img onclick="revision_mensaje_seguimiento_despacho('.$rsql[$k][6].',7)" src="'.DIR_LOCAL_IMG_SEGUIMIENTO_DESPACHO.'nook_16.png">';
                      endif;
                      if ( in_array(40, $perfil,true) || in_array(41, $perfil,true) || in_array(42, $perfil,true) || in_array(43, $perfil,true)  ) :
                        if($rsql[$k][3]==$_id){
                          echo '<img onclick="revision_mensaje_seguimiento_despacho('.$rsql[$k][6].',8)" src="'.DIR_LOCAL_IMG_SEGUIMIENTO_DESPACHO.'destroy_16.png"><br />';
                        }
                      endif;

                    }
                    if($rsql[$k][1]!=NULL){
                      if($rsql[$k][5]==6){
                        if ( in_array(40, $perfil,true) || in_array(41, $perfil,true)  ) :
                          echo '<img onclick="revision_mensaje_seguimiento_despacho('.$rsql[$k][6].',5)" src="'.DIR_LOCAL_IMG_SEGUIMIENTO_DESPACHO.'volver_16.png"><br />';
                        endif;
                        echo "<b style=\"color:green\">APROBADO POR: </b> ".$rsqlpersona0[0][0]." <b>EL DÍA </b> ".FechaFormateada2(strtotime($rsql[$k][2])).' '.date('H:i',strtotime($rsql[$k][2]))."<br />";
                      }
                      if($rsql[$k][5]==7){
                        if ( in_array(40, $perfil,true) || in_array(41, $perfil,true)  ) :
                          echo '<img onclick="revision_mensaje_seguimiento_despacho('.$rsql[$k][6].',5)" src="'.DIR_LOCAL_IMG_SEGUIMIENTO_DESPACHO.'volver_16.png"><br />';
                        endif;
                        echo "<b style=\"color:red\">RECHAZADO POR: </b> ".$rsqlpersona0[0][0]." <b>EL DÍA </b> ".FechaFormateada2(strtotime($rsql[$k][2])).' '.date('H:i',strtotime($rsql[$k][2]))."<br />";
                      }
                    }

                    echo "<b>ESCRITO POR: </b> ".$rsqlpersona1[0][0]." <b>EL DÍA </b> ".FechaFormateada2(strtotime($rsql[$k][0])).' '.date('H:i',strtotime($rsql[$k][0]))." <br><b>MENSAJE: </b>".$rsql[$k][4]."<br /><hr color=\"#e2e2e2\">";
                  }
                  echo '</div>';
                }else{
                  echo '<div style="width:100%;"></div>';
                }
              }else if($avance==0){
                echo '<div style="width:100%;"></div>';
              }
              ?>
            </td>

          </tr>




        </tbody>
      </table>
    </form>

    <?php
    echo '<form style="display:none; visibility:hidden" name="frm_fichamensaje_revision_seguimientoDespacho"  id="frm_fichamensaje_revision_seguimientoDespacho"><input name="campo_mensaje_revision_seguimientoDespacho_0" readonly="readonly" value="'.$_REQUEST["_id_registro_seguimiento"].'"><input readonly="readonly" name="campo_mensaje_revision_seguimientoDespacho_1" id="campo_mensaje_revision_seguimientoDespacho_1" ><input readonly="readonly" name="campo_mensaje_revision_seguimientoDespacho_2" id="campo_mensaje_revision_seguimientoDespacho_2" ></form>
    <script>
    function revision_mensaje_seguimiento_despacho(id,opcion){
      $("#campo_mensaje_revision_seguimientoDespacho_1").val(id);
      $("#campo_mensaje_revision_seguimientoDespacho_2").val(opcion);
      $.messager.confirm(\'Confirmación\',\'Está seguro que desea actualizar este avance?.\',function(r){
        if (r){
          $.ajax( "'.DIR_REL.'class/validador.php")
          .done(function(result) {
            if(result==1){
              xajax_procesar_frm_fichamensaje_revision_seguimientoDespacho(xajax.getFormValues(\'frm_fichamensaje_revision_seguimientoDespacho\', true));
            }else if(result==0){
              location.reload();
            }
          });

        }
      });


    }
    </script>
    ';

    ?>
    <style>
      #tableFichaMensajes_seguimiento_despacho input,select {
        border: none;
        border-bottom: 1px solid #ccc;
        background:#fff;
        padding:0px;
      }
      .ui-datepicker select.ui-datepicker-month, .ui-datepicker select.ui-datepicker-year{
        background:#fff;
      }
      #tableFichaMensajes_seguimiento_despacho textarea{
        border: 1px solid #ccc;
      }
    </style>
  </div>
  <!--
    <div title="Clasificadores" data-options="iconCls:'',closable:false" style="padding:10px">
      <form style="width:100%; height:100%">
        <table width="98%" cellpadding="3" cellspacing="3">
          <tbody>
            <tr>
              <td>Clasificadores Generales:</td>
              <td>Clasificadores Asociados:</td>
            </tr>
            <tr>
              <td >
                <ul>
                  <li>CMP Ecuador
                  </li>
                </ul>
              </td>
              <td >
                <textarea style="width:100%; resize:none" rows="20" cols="50" />
              </td>
            </tr>

          </tbody>
        </table>
      </form>
    </div>
  -->
  <div title="Archivos" data-options="iconCls:'',closable:false" style="padding:10px; background:rgba(187, 187, 187, 0.0170588)">
    <form name="frm_fichaarchivos_seguimientoDespacho" id="frm_fichaarchivos_seguimientoDespacho" style="width:100%; height:auto; border:1px solid #CCC">
      <table id="tableFichaArchivos_seguimiento_despacho" width="99%" cellpadding="5" cellspacing="5">
        <tbody>
          <tr>
            <td colspan="2" style="background:#0072C6; color:#fff">INFORMACIÓN</td>
          </tr>
          <tr style="display:none; visibility:hidden">
            <td colspan="2">
              <?php
              if($avance==1){
                echo '<input id="campo_archivos_seguimientoDespacho_0" name="campo_archivos_seguimientoDespacho_0" readonly="readonly" value="'.$_REQUEST["_id_registro_seguimiento"].'"/>';
                echo '<input name="campo_archivos_seguimientoDespacho_0_0" readonly="readonly" value="'.$_REQUEST["_id_plantilla_seguimiento"].'"/>';
              }else
              echo '<input name="campo_archivos_seguimientoDespacho_0" readonly="readonly"/>';
              ?>
            </td>
          </tr>
          <?php
          if ( in_array(40, $perfil,true) || in_array(41, $perfil,true) || in_array(42, $perfil,true)  || in_array(43, $perfil,true)  ) :
            ?>
            <tr>
              <td colspan="2" >
                <div  id="uploader_archivos_seguimiento_despacho">
                  <p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
                </div>
                <pre style="color:green!important; font-size:16px !important;" class="texto_label" id="console1_archivos_seguimiento_despacho"></pre>
                <pre style="color:red!important; font-size:16px !important;" class="texto_label" id="console2_archivos_seguimiento_despacho"></pre>
                <div   id="cargadas_archivos_seguimiento_despacho"></div>
                <div  ><input style="display:none; visibility:hidden" readonly="readonly" id="contadorfoto_archivos_seguimiento_despacho" name="contadorfoto_archivos_seguimiento_despacho" value="0" /></div>
              </td>
            </tr>
            <script type="text/javascript">
              // Initialize the widget when the DOM is ready
              $(function() {
                var maxfiles= 1;
                $("#uploader_archivos_seguimiento_despacho").plupload({
                  // General settings
                  runtimes : 'html5,flash,silverlight,html4',
                  url : '<?php echo DIR_REL_SEGUIMIENTO_DESPACHO ?>upload_adjuntos.php',

                  // User can upload no more then 20 files in one go (sets multiple_queues to false)
                  max_file_count: 1,
                  chunk_size: '10mb',
                  ////edit here the number of max uploads
                  multi_selection: false,
                  multiple_queues :false,
                  // Resize images on clientside if we can
                  resize : {
                    width : 400,
                    //height : 500,
                    quality : 90,
                    //crop: true // crop to exact dimensions
                    crop: false
                  },

                  filters : {
                    // Maximum file size
                    max_file_size : '10mb',
                    // Specify what files to browse for
                    mime_types: [
                    <!--	{title : "Image files", extensions : "pdf"},-->
                    <!--	{title : "Zip files", extensions : "zip"}-->
                    ]
                  },

                  // Rename files by clicking on their titles
                  rename: true,

                  // Sort files
                  sortable: true,

                  // Enable ability to drag'n'drop files onto the widget (currently only HTML5 supports that)
                  dragdrop: true,
                  /*unique_names: true,*/
                  // Views to activate
                  views: {
                    list: true,
                    thumbs: true, // Show thumbs
                    active: 'thumbs'
                  },

                  // Flash settings
                  flash_swf_url : '../../js/Moxie.swf',

                  // Silverlight settings
                  silverlight_xap_url : '../../js/Moxie.xap',

                  init: {
                    FilesAdded: function(up, files) {
                      plupload.each(files, function(file) {
                        if (up.files.length > maxfiles) {
                          up.removeFile(file);
                        }
                        var upa = $('#uploader_archivos_seguimiento_despacho').plupload('getUploader');
                        var i = 0;
                        while (i<=upa.files.length) {
                          ultimo = upa.files.length;
                          if (ultimo > 1) {
                            if (i > 0) {
                              ultimo2 = ultimo - 1;
                              ii = i-1;
                              if (ultimo2 != ii) {
                                if (up.files[ultimo - 1].name == upa.files[i-1].name) {
                                  up.removeFile(file);
                                }
                              }
                            }
                          }
                          i++;
                        }
                      });
                      if (up.files.length >= maxfiles) {
                        $('#uploader_browse_seguimiento_despacho').hide("slow");
                      }
                    },
                    FilesRemoved: function(up, files) {
                      if (up.files.length < maxfiles) {
                        $('#uploader_browse_seguimiento_despacho').fadeIn("slow");
                      }
                    },
                    FileUploaded: function(up, file, response) {
                      // some functions
                      response = jQuery.parseJSON( response.response );
                      if (response.error.code){
                        uploader.trigger('Error', {
                          code : response.error.code,
                          message : response.error.message,
                          name : response.error.name,
                          old : response.error.old,
                          file : file
                        });
                      }

                    }
                  }
                });

              });
            </script>
            <script type="text/javascript">
              var index=1;
              var uploader = new plupload.Uploader();

              uploader.init();

              uploader.bind('UploadProgress', function(up, file) {
                document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
              });

              uploader.bind('Error', function(up, err) {

                if(err.code==2){
                  document.getElementById('console2_archivos_seguimiento_despacho').innerHTML += "\nError " + err.code + ": " + err.message;
                }

                if(err.code==1){
                  document.getElementById('console1_archivos_seguimiento_despacho').innerHTML += "\nEstado: " + err.message;
                  if(err.name!=null && err.name!=""){
                    $("#cargadas_archivos_seguimiento_despacho").append( '<input style="display:none; visibility:hidden" readonly id="foto_archivos_seguimiento_despacho_'+ index+'" name="foto_archivos_seguimiento_despacho_'+ index+'" value="' + err.name +'" /><input readonly style="display:none; visibility:hidden" id="foto_old_seguimiento_despacho_'+ index+'" name="foto_old_seguimiento_despacho_'+ index+'" value="' + err.old +'" />' );
                    $("#contadorfoto_archivos_seguimiento_despacho").val( parseInt(parseInt($("#contadorfoto_archivos_seguimiento_despacho").val()) + 1) );;
                    index++;

                  }
                }
              });

            </script>
          <?php endif; ?>
          <tr>
            <td align="left" colspan="2">
              <?php
              $select=$_consulta_sistema->query("select count(*) from seguimiento_despacho_entrega.ssd_avances_registro_seguimiento where rse_codigo='{$_REQUEST['_id_registro_seguimiento']}'; ");
              if($select[0][0]>0):

                if($estado_actividad[0][0]!=5 || $estado_actividad[0][0]!=7 || $estado_actividad[0][0]!=8 || $estado_actividad[0][0]!=9 || $estado_actividad[0][0]!=10) :
                  ?>

                  <a onclick="actualizarArchivos_seguimientoDespacho()" class="easyui-linkbutton" data-options="iconCls:'icon-cloud'" style="width:100px">Grabar</a>
                  <script>
                  function actualizarArchivos_seguimientoDespacho(){
                    $.messager.confirm('Confirmación','Está seguro que desea actualizar la ficha?.',function(r){
                      if (r){
                        $.ajax( "<?php echo DIR_REL ?>class/validador.php")
                        .done(function(result) {
                          if(result==1){
                            xajax_procesar_frm_fichaarchivos_seguimientoDespacho(xajax.getFormValues('frm_fichaarchivos_seguimientoDespacho', true) );
                          }else if(result==0){
                            location.reload();
                          }
                        });

                      }
                    });
                  }
                  </script>
                <?php endif; endif; ?>
              </td>
            </tr>

            <tr>
              <td style="border-bottom:1px solid #CCC" colspan="2">&nbsp;</td>
            </tr>
            <tr>

              <tr>
                <td colspan="2" ><b>ARCHIVOS ASOCIADOS</b></td>
              </tr>
              <tr>
                <td valign="top" colspan="2">


                  <?php
                  if($avance==1){
                    $rsql=$_consulta_sistema->query("select arr_ruta,per_codigo_cargado,arr_fecha_cargado,per_codigo_revision,arr_fecha_revision, arr_nombre,arr_ruta,era_codigo,arr_codigo from seguimiento_despacho_entrega.ssd_archivo_registro_seguimiento  where rse_codigo='{$rsql_maestro[0]['rse_codigo']}' and era_codigo!=12");
                    echo '<div style="width:98%; border:1px solid #ccc; padding:5px; background: #fff;"  >';
                    //$avance=$rsql[$k][6].$rsql[$k][4];
                    //$avance="".FechaFormateada2(strtotime($rsql[$k][0])).' '.date('H:i',strtotime($rsql[$k][0]))." - ".$rsql[$k][4]." \n";
                    for($k=0;$k<count($rsql);$k++){
                      $rsqlpersona0=$_consulta_login->query(" select per_nombres from aplicativo_web.vw_informacion_persona where  per_codigo='{$rsql[$k][1]}' ");
                      if($rsql[$k][3]!=NULL){
                        $rsqlpersona1=$_consulta_login->query(" select per_nombres from aplicativo_web.vw_informacion_persona where  per_codigo='{$rsql[$k][3]}' ");
                      }


                      if($rsql[$k][7]==9){
                        if ( in_array(40, $perfil,true) || in_array(41, $perfil,true)  ) :
                          echo '<img onclick="revision_archivo_seguimiento_despacho('.$rsql[$k][8].',10)" src="'.DIR_LOCAL_IMG_SEGUIMIENTO_DESPACHO.'ok_16.png"><img onclick="revision_archivo_seguimiento_despacho('.$rsql[$k][8].',11)" src="'.DIR_LOCAL_IMG_SEGUIMIENTO_DESPACHO.'nook_16.png">';
                        endif;
                        if ( in_array(40, $perfil,true) || in_array(41, $perfil,true) || in_array(42, $perfil,true) || in_array(43, $perfil,true)  ) :
                          if($rsql[$k][1]==$_id){
                            echo '<img onclick="revision_archivo_seguimiento_despacho('.$rsql[$k][8].',12)" src="'.DIR_LOCAL_IMG_SEGUIMIENTO_DESPACHO.'destroy_16.png"><br />';
                          }
                        endif;
                      }
                      if($rsql[$k][3]!=NULL){
                        if($rsql[$k][7]==10){
                          if ( in_array(40, $perfil,true) || in_array(41, $perfil,true)  ) :
                            echo '<img onclick="revision_archivo_seguimiento_despacho('.$rsql[$k][8].',9)" src="'.DIR_LOCAL_IMG_SEGUIMIENTO_DESPACHO.'volver_16.png"><br />';
                          endif;
                          echo "<b style=\"color:green\">APROBADO POR: </b> ".$rsqlpersona1[0][0]." <b>EL DÍA </b> ".FechaFormateada2(strtotime($rsql[$k][4])).' '.date('H:i',strtotime($rsql[$k][4]))."<br />";
                        }
                        if($rsql[$k][7]==11){
                          if ( in_array(40, $perfil,true) || in_array(41, $perfil,true)  ) :
                            echo '<img onclick="revision_archivo_seguimiento_despacho('.$rsql[$k][8].',9)" src="'.DIR_LOCAL_IMG_SEGUIMIENTO_DESPACHO.'volver_16.png"><br />';
                          endif;
                          echo "<b style=\"color:red\">RECHAZADO POR: </b> ".$rsqlpersona1[0][0]." <b>EL DÍA </b> ".FechaFormateada2(strtotime($rsql[$k][4])).' '.date('H:i',strtotime($rsql[$k][4]))."<br />";
                        }
                      }



                      echo "<b>CARGADO POR: </b> ".$rsqlpersona0[0][0]." <b>EL DÍA </b> ".FechaFormateada2(strtotime($rsql[$k][2])).' '.date('H:i',strtotime($rsql[$k][2]))."<br>";
                      echo "<b>NOMBRE DEL ARCHIVO: </b> ".$rsql[$k][5]." <br />";
                      echo "<b>VISUALIZAR ARCHIVO: </b><a style='color:#000' href='".$rsql[$k][6]."' target=\"_blank\">Presione  Aquí</a><br><hr color=\"#e2e2e2\">";
                    }
                    echo '</div>';
                  }else if($avance==0){
                    echo '<textarea style="width:100%; resize:none" rows="4" cols="50" /></textarea>';
                  }
                  ?>



                </td>

              </tr>


            </tbody>
          </table>
        </form>
        <?php
        echo '<form style="display:none; visibility:hidden" name="frm_fichaarchivo_revision_seguimientoDespacho"  id="frm_fichaarchivo_revision_seguimientoDespacho"><input name="campo_archivo_revision_seguimientoDespacho_0" readonly="readonly" value="'.$_REQUEST["_id_registro_seguimiento"].'"><input readonly="readonly" name="campo_archivo_revision_seguimientoDespacho_1" id="campo_archivo_revision_seguimientoDespacho_1" ><input readonly="readonly" name="campo_archivo_revision_seguimientoDespacho_2" id="campo_archivo_revision_seguimientoDespacho_2" ></form>
        <script>
        function revision_archivo_seguimiento_despacho(id,opcion){
          $("#campo_archivo_revision_seguimientoDespacho_1").val(id);
          $("#campo_archivo_revision_seguimientoDespacho_2").val(opcion);
          $.messager.confirm(\'Confirmación\',\'Está seguro que desea actualizar este avance?.\',function(r){
            if (r){
              $.ajax( "'.DIR_REL.'class/validador.php")
              .done(function(result) {
                if(result==1){
                  xajax_procesar_frm_fichaarchivo_revision_seguimientoDespacho(xajax.getFormValues(\'frm_fichaarchivo_revision_seguimientoDespacho\', true));
                }else if(result==0){
                  location.reload();
                }
              });

            }
          });


        }
        </script>
        ';

        ?>
        <style>
        #tableFichaArchivos_seguimiento_despacho input,select {
          border: none;
          border-bottom: 1px solid #ccc;
          background:#fff;
          padding:0px;
        }
        .ui-datepicker select.ui-datepicker-month, .ui-datepicker select.ui-datepicker-year{
          background:#fff;
        }
        #tableFichaArchivos_seguimiento_despacho textarea{
          border: 1px solid #ccc;
        }
        </style>




      </div>
      <div title="Histórico" data-options="iconCls:'',closable:false" style="padding:10px; background:rgba(187, 187, 187, 0.0170588)">
        <form  style="width:100%; height:98%; border:1px solid #CCC">
          <table id="tableFichaHistorico_seguimiento_despacho" width="99%" cellpadding="5" cellspacing="5">
            <tbody>
              <tr>
                <td colspan="3" style="background:#0072C6; color:#fff">INFORMACIÓN</td>
              </tr>
              <tr>
                <td><b>CAMBIOS DE FECHA FIN</b></td>
                <td><b>CAMBIOS DE ESTADO</b></td>
                <td><b>FECHAS DE LECTURA</b></td>
              </tr>
              <tr>
                <td  width="33%" valign="top">
                  <?php
                  if($avance==1){
                    $rsql=$_consulta_sistema->query("select frs_fecha_final,frs_fecha_registro,per_codigo_cambio from  seguimiento_despacho_entrega.ssd_fechafin_registro_seguimiento where rse_codigo='{$rsql_maestro[0]['rse_codigo']}'  order by  frs_codigo desc ");
                    echo '<div style="width:98%; border:1px solid #ccc; padding:5px; background: #fff;"  >';
                    //$avance=$rsql[$k][6].$rsql[$k][4];
                    //$avance="".FechaFormateada2(strtotime($rsql[$k][0])).' '.date('H:i',strtotime($rsql[$k][0]))." - ".$rsql[$k][4]." \n";
                    for($k=0;$k<count($rsql);$k++){
                      $rsqlpersona0=$_consulta_login->query(" select per_nombres from aplicativo_web.vw_informacion_persona where  per_codigo='{$rsql[$k][2]}' ");
                      echo "<b>FECHA ANTERIOR</b>: ".FechaFormateada2(strtotime($rsql[$k][0]))."<br />";
                      echo "<b>CAMBIADO POR: </b> ".$rsqlpersona0[0][0]." <b>EL DÍA </b>".FechaFormateada2(strtotime($rsql[$k][1])).' '.date('H:i',strtotime($rsql[$k][1]))."<br /><hr color=\"#e2e2e2\">";
                    }
                    echo '</div>';
                  }else if($avance==0){
                    echo 'div style="width:100%" ></div>';
                  }
                  ?>
                </td>
                <td width="33%" valign="top">
                  <?php
                  if($avance==1){
                    $rsql=$_consulta_sistema->query(" select a.crs_fecha_cambio,a.per_codigo_cambio,b.ese_nombre from  seguimiento_despacho_entrega.ssd_cambioestado_registro_seguimiento a left join seguimiento_despacho_entrega.ssd_estado_seguimiento b on a.ese_codigo=b.ese_codigo where a.rse_codigo='{$rsql_maestro[0]['rse_codigo']}' order by a.crs_fecha_cambio desc  ");
                    echo '<div style="width:98%; border:1px solid #ccc; padding:5px; background: #fff;"  >';
                    //$avance=$rsql[$k][6].$rsql[$k][4];
                    //$avance="".FechaFormateada2(strtotime($rsql[$k][0])).' '.date('H:i',strtotime($rsql[$k][0]))." - ".$rsql[$k][4]." \n";
                    for($k=0;$k<count($rsql);$k++){
                      $rsqlpersona0=$_consulta_login->query(" select per_nombres from aplicativo_web.vw_informacion_persona where  per_codigo='{$rsql[$k][1]}' ");
                      echo "<b>ESTADO ANTERIOR: </b> ".$rsql[$k][2]."<br />";
                      echo "<b>CAMBIADO POR: </b> ".$rsqlpersona0[0][0]." <b>EL DÍA </b>".FechaFormateada2(strtotime($rsql[$k][0])).' '.date('H:i',strtotime($rsql[$k][0]))."<br /><hr color=\"#e2e2e2\">";
                    }
                    echo '</div>';
                  }else if($avance==0){
                    echo 'div style="width:100%" ></div>';
                  }
                  ?>
                </td>
                <td  valign="top" width="33%">
                  <?php
                  if($avance==1){
                    $rsql=$_consulta_sistema->query(" select vrs_fecha,per_codigo_visita from  seguimiento_despacho_entrega.ssd_visita_registro_seguimiento where rse_codigo='{$rsql_maestro[0]['rse_codigo']}' order by vrs_fecha desc  ");
                    echo '<div style="width:98%; border:1px solid #ccc; padding:5px; background: #fff;"  >';
                    //$avance=$rsql[$k][6].$rsql[$k][4];
                    //$avance="".FechaFormateada2(strtotime($rsql[$k][0])).' '.date('H:i',strtotime($rsql[$k][0]))." - ".$rsql[$k][4]." \n";
                    for($k=0;$k<count($rsql);$k++){
                      $rsqlpersona0=$_consulta_login->query(" select per_nombres from aplicativo_web.vw_informacion_persona where  per_codigo='{$rsql[$k][1]}' ");
                      echo "<b>VISITANTE:</b> ".$rsqlpersona0[0][0]."<br/><b>DÍA: </b>".FechaFormateada2(strtotime($rsql[$k][0])).' '.date('H:i',strtotime($rsql[$k][0]))."<br /><hr color=\"#e2e2e2\">";
                    }
                    echo '</div>';
                  }else if($avance==0){
                    echo 'div style="width:100%" ></div>';
                  }
                  ?>
                </td>
              </tr>
            </tbody>
          </table>
        </form>

        <style>
        #tableFichaHistorico_seguimiento_despacho input,select {
          border: none;
          border-bottom: 1px solid #ccc;
          background:#fff;
          padding:0px;
        }
        .ui-datepicker select.ui-datepicker-month, .ui-datepicker select.ui-datepicker-year{
          background:#fff;
        }
        #tableFichaHistorico_seguimiento_despacho textarea{
          border: 1px solid #ccc;
        }
        </style>
      </div>
      <?php
    endif;
    ?>
  </div>
