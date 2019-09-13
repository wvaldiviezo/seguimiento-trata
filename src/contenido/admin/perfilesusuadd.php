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
if(isset($_REQUEST["_id_registro_seguimiento"]) && $_REQUEST["_id_registro_seguimiento"]!=NULL){
    $avance=1;

    $rsql_maestro=$_consulta_sistema->query( "SELECT a.*,b.* FROM aplicativo_web.aaw_persona a, aplicativo_web.aaw_persona_perfil b
    where  a.per_codigo=b.per_codigo and b.ppe_codigo=".$_REQUEST["_id_registro_seguimiento"]." limit 1;" );



    if(isset($_REQUEST["_id_plantilla_seguimiento"]) && $_REQUEST["_id_plantilla_seguimiento"]!=NULL ){
        $_REQUEST["_id_plantilla_seguimiento"];



    }else{
        $_REQUEST["_id_plantilla_seguimiento"]="Visor";
    }
}
if(isset($_REQUEST["_id_registro_persona"]) && $_REQUEST["_id_registro_persona"]!=NULL ){
    $avance=0;
    $rsql_maestro=$_consulta_sistema->query( "SELECT * FROM aplicativo_web.aaw_persona where per_codigo='{$_REQUEST['_id_registro_persona']}' limit 1;" );
    if(isset($_REQUEST["_id_plantilla_seguimiento"]) && $_REQUEST["_id_plantilla_seguimiento"]!=NULL ){
        $_REQUEST["_id_plantilla_seguimiento"];



    }else{
        $_REQUEST["_id_plantilla_seguimiento"]="Visor";
    }
}

if($avance==1){
    $btn="Actualizar";
    $height="97%";
   // echo '<div style="padding:1px"><b>Nombre de la Actividad: </b>'.$rsql_maestro[0]['rse_nombre'].'</div>';

    //$estado_actividad=$_consulta_sistema->query( "select ese_codigo from seguimiento_despacho_entrega.ssd_registro_seguimiento where rse_codigo='{$_REQUEST['_id_registro_seguimiento']}' limit 1; ");


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


<div title="Ficha General" style="padding:10px; background:rgba(187, 187, 187, 0.0170588)">
    <form  name="frm_insertarperilusuario_seguimiento_despacho" id="frm_insertarperilusuario_seguimiento_despacho" style="width:100%; height:auto; border:1px solid #CCC">
    <table align="center" id="tableFichaGeneral_seguimiento_despacho" width="99%" cellpadding="5" cellspacing="5">
    <tbody>
    <tr>
        <td colspan="6" style="background:#0072C6; color:#fff">INFORMACIÓN PERFIL DE USUARIO</td>
    </tr>
    <tr style="display:none; visibility:hidden">
        <td colspan="6">
            <?php
            if($avance==1){
                echo '<input name="campo_ingreso_seguimientoDespacho_0" readonly="readonly" value="'.$_REQUEST["_id_registro_seguimiento"].'"/>';
                echo '<input name="campo_ingreso_seguimientoDespacho_0_0" readonly="readonly" value="'.$_REQUEST["_id_plantilla_seguimiento"].'"/>';
                //auxiliar para codigo de persona
                echo '<input name="campo_ingreso_seguimientoDespacho_1" readonly="readonly" value="'.$rsql_maestro[0]['per_codigo'].'"/>';
                //auxiliar para codigo de perfil
                echo '<input name="campo_ingreso_seguimientoDespacho_2" readonly="readonly" value="'.$rsql_maestro[0]['pus_codigo'].'"/>';
            }else
                echo '<input name="campo_ingreso_seguimientoDespacho_0" readonly="readonly"/>';
                echo '<input name="campo_ingreso_seguimientoDespacho_1" readonly="readonly" value="'.$_REQUEST["_id_registro_persona"].'"/>';
                echo '<input name="campo_ingreso_seguimientoDespacho_2" readonly="readonly"/>';
            ?>
        </td>
    </tr>


    <tr>
        <td width="10%">
            <?php
            if ( in_array(40, $perfil,true) || in_array(41, $perfil,true)  ) :
                ?>
                <a onclick="actualizarUsuario_seguimientoDespacho()" class="easyui-linkbutton" data-options="iconCls:'icon-cloud'" style="width:100px"><?php echo $btn; ?></a>
                <script>
                    function actualizarUsuario_seguimientoDespacho(){
                        $.messager.confirm('Confirmación','Está seguro que desea actualizar el usuario?.',function(r){
                            if (r){
                                $.ajax( "<?php echo DIR_REL ?>class/validador.php")
                                    .done(function(result) {
                                        if(result==1){
                                            xajax_procesar_frm_insertarperilusuario_seguimiento_despacho(xajax.getFormValues('frm_insertarperilusuario_seguimiento_despacho', true));
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

    </tr>
    <tr>
        <td width="10%"><b>NOMBRES</b></td>
        <td width="27%">
            <?php
            if($avance==1){
                echo '<input id="campo_ingreso_seguimientoDespacho_3" name="campo_ingreso_seguimientoDespacho_3" readonly="readonly" style="width:100%" value="'.$rsql_maestro[0]['per_nombres'].'" />';
            }else if($avance==0){
                echo '<input id="campo_ingreso_seguimientoDespacho_3" name="campo_ingreso_seguimientoDespacho_3" readonly="readonly" style="width:100%" value="'.$rsql_maestro[0]['per_nombres'].'" />';
            }
            ?>
        </td>
        <td width="10%"><b>APELLIDOS</b></td>
        <td width="27%">
            <?php
            if($avance==1){
                echo '<input id="campo_ingreso_seguimientoDespacho_4" name="campo_ingreso_seguimientoDespacho_4" readonly="readonly" style="width:100%" value="'.$rsql_maestro[0]['per_apellidos'].'" />';
            }else if($avance==0){
                echo '<input id="campo_ingreso_seguimientoDespacho_4" name="campo_ingreso_seguimientoDespacho_4" readonly="readonly" style="width:100%" value="'.$rsql_maestro[0]['per_apellidos'].'" />';
            }
            ?>
        </td>
    </tr>
    <tr>
        <td><b>Perfil</b></td>
        <td>

            <select id="campo_ingreso_seguimientoDespacho_5" name="campo_ingreso_seguimientoDespacho_5" style="width:100%">
                <?php
                if($avance==1){
                    $auxfilas=0;
                    $sql=$_consulta_sistema->query("select c.pus_codigo,c.pus_nombre from aplicativo_web.aaw_persona a,aplicativo_web.aaw_persona_perfil b,aplicativo_web.awe_perfil_usuario c  where a.per_codigo=b.per_codigo and b.pus_codigo=c.pus_codigo and b.ppe_codigo=".$_REQUEST["_id_registro_seguimiento"]);
                    for($i=0;$i<count($sql);$i++){

                        $sql2=$_consulta_sistema->query("select pus_codigo,pus_nombre from aplicativo_web.awe_perfil_usuario order by pus_codigo");
                        for($j=0;$j<count($sql2);$j++){
                            $auxfilas=$auxfilas+1;
                            if($sql[$i][0]==$sql2[$j][0]){
                                echo '<option value="'.$sql2[$j][0].'" selected>'.$sql2[$j][1].'</option>';
                            }else{
                                echo '<option value="'.$sql2[$j][0].'">'.$sql2[$j][1].'</option>';
                            }
                        };

                    }






                }else if($avance==0){
                    $sql=$_consulta_sistema->query(" select pus_codigo,pus_nombre from aplicativo_web.awe_perfil_usuario order by pus_codigo ");
                    for($i=0;$i<count($sql);$i++){
                        echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].'</option>';
                    }
                }
                ?>
            </select>
        </td>
    </tr>


    </tbody>
    </table>
    </form
</div>
