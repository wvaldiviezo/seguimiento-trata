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
    $rsql_maestro=$_consulta_sistema->query( "SELECT * FROM aplicativo_web.aaw_persona where per_codigo='{$_REQUEST['_id_registro_seguimiento']}' limit 1;" );
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
    <form  name="frm_insertarusuario_seguimiento_despacho" id="frm_insertarusuario_seguimiento_despacho" style="width:100%; height:auto; border:1px solid #CCC">
    <table align="center" id="tableFichaGeneral_seguimiento_despacho" width="99%" cellpadding="5" cellspacing="5">
    <tbody>
    <tr>
        <td colspan="6" style="background:#0072C6; color:#fff">INFORMACIÓN USUARIO</td>
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
                                            xajax_procesar_frm_insertarusuario_seguimiento_despacho(xajax.getFormValues('frm_insertarusuario_seguimiento_despacho', true));
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
        <td width="10%"><b>CÉDULA</b></td>
        <td width="27%">
            <?php
            if($avance==1){
                echo '<input id="campo_ingreso_seguimientoDespacho_1" name="campo_ingreso_seguimientoDespacho_1" maxlength="10" style="width:100%" value="'.$rsql_maestro[0]['per_cedula'].'" />';
            }else if($avance==0){
                echo '<input id="campo_ingreso_seguimientoDespacho_1" name="campo_ingreso_seguimientoDespacho_1" maxlength="10" style="width:100%" />';
            }
            ?>
        </td>
        <td width="10%"><b>CARGO</b></td>
        <td width="27%">
            <?php
            if($avance==1){
                echo '<input id="campo_ingreso_seguimientoDespacho_2" name="campo_ingreso_seguimientoDespacho_2" style="width:100%" value="'.$rsql_maestro[0]['per_cargo_laboral'].'" />';
            }else if($avance==0){
                echo '<input id="campo_ingreso_seguimientoDespacho_2" name="campo_ingreso_seguimientoDespacho_2" style="width:100%" />';
            }
            ?>
        </td>
    </tr>
    <tr>
        <td width="10%"><b>NOMBRES</b></td>
        <td width="27%">
            <?php
            if($avance==1){
                echo '<input id="campo_ingreso_seguimientoDespacho_3" name="campo_ingreso_seguimientoDespacho_3" style="width:100%" value="'.$rsql_maestro[0]['per_nombres'].'" />';
            }else if($avance==0){
                echo '<input id="campo_ingreso_seguimientoDespacho_3" name="campo_ingreso_seguimientoDespacho_3" style="width:100%" />';
            }
            ?>
        </td>
        <td width="10%"><b>APELLIDOS</b></td>
        <td width="27%">
            <?php
            if($avance==1){
                echo '<input id="campo_ingreso_seguimientoDespacho_4" name="campo_ingreso_seguimientoDespacho_4" style="width:100%" value="'.$rsql_maestro[0]['per_apellidos'].'" />';
            }else if($avance==0){
                echo '<input id="campo_ingreso_seguimientoDespacho_4" name="campo_ingreso_seguimientoDespacho_4" style="width:100%" />';
            }
            ?>
        </td>
    </tr>
    <tr>
        <td width="10%"><b>CORREO</b></td>
        <td width="27%">
            <?php
            if($avance==1){
                echo '<input type="email" id="campo_ingreso_seguimientoDespacho_5" name="campo_ingreso_seguimientoDespacho_5" style="width:100%" value="'.$rsql_maestro[0]['per_mail'].'" />';
            }else if($avance==0){
                echo '<input type="email" id="campo_ingreso_seguimientoDespacho_5" name="campo_ingreso_seguimientoDespacho_5" style="width:100%" />';
            }
            ?>
        </td>
        <td width="10%"><b>CELULAR</b></td>
        <td width="27%">
            <?php
            if($avance==1){
                echo '<input id="campo_ingreso_seguimientoDespacho_6" name="campo_ingreso_seguimientoDespacho_6" style="width:100%" value="'.$rsql_maestro[0]['per_celular'].'" />';
            }else if($avance==0){
                echo '<input id="campo_ingreso_seguimientoDespacho_6" name="campo_ingreso_seguimientoDespacho_6" style="width:100%" />';
            }
            ?>
        </td>
    </tr>
    <tr>
        <td width="10%"><b>TELÉFONO</b></td>
        <td width="27%">
            <?php
            if($avance==1){
                echo '<input id="campo_ingreso_seguimientoDespacho_7" name="campo_ingreso_seguimientoDespacho_7" style="width:100%" value="'.$rsql_maestro[0]['per_telefono'].'" />';
            }else if($avance==0){
                echo '<input id="campo_ingreso_seguimientoDespacho_7" name="campo_ingreso_seguimientoDespacho_7" style="width:100%" />';
            }
            ?>
        </td>
        <td width="10%"><b>EXTENSIÓN</b></td>
        <td width="27%">
            <?php
            if($avance==1){
                echo '<input id="campo_ingreso_seguimientoDespacho_8" name="campo_ingreso_seguimientoDespacho_8" style="width:100%" value="'.$rsql_maestro[0]['per_extension'].'" />';
            }else if($avance==0){
                echo '<input id="campo_ingreso_seguimientoDespacho_8" name="campo_ingreso_seguimientoDespacho_8" style="width:100%" />';
            }
            ?>
        </td>
    </tr>
    <tr>
        <td><b>INSTITUCIÓN</b></td>
        <td>

            <select id="campo_ingreso_seguimientoDespacho_11" name="campo_ingreso_seguimientoDespacho_11" style="width:100%">
                <?php
                if($avance==1){
                    $auxfilas=0;
                    $sql=$_consulta_sistema->query("select a.ins_codigo,a.ins_nombre from seguimiento_despacho_entrega.ssd_instituciones_seguimiento a,aplicativo_web.aaw_persona b where a.ins_codigo=b.ins_codigo and b.per_codigo=".$_REQUEST["_id_registro_seguimiento"]);
                    for($i=0;$i<count($sql);$i++){

                        $sql2=$_consulta_sistema->query("select ins_codigo,ins_nombre from seguimiento_despacho_entrega.ssd_instituciones_seguimiento order by ins_nombre");
                        for($j=0;$j<count($sql2);$j++){
                            $auxfilas=$auxfilas+1;
                            if($sql[$i][0]==$sql2[$j][0]){
                                echo '<option value="'.$sql2[$j][0].'" selected>'.$sql2[$j][1].'</option>';
                            }else{
                                echo '<option value="'.$sql2[$j][0].'">'.$sql2[$j][1].'</option>';
                            }
                        };

                    }
                    if(count($sql)==0){
                        $sql2=$_consulta_sistema->query("select ins_codigo,ins_nombre from seguimiento_despacho_entrega.ssd_instituciones_seguimiento order by ins_nombre");
                        echo '<option value="0" selected>SELECCIONE UNA INSTITUCIÓN</option>';
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
                    $sql=$_consulta_sistema->query(" select ins_codigo,ins_nombre from seguimiento_despacho_entrega.ssd_instituciones_seguimiento order by ins_nombre ");
                    echo '<option value="0" selected>SELECCIONE UNA INSTITUCIÓN</option>';
                    for($i=0;$i<count($sql);$i++){
                        echo '<option value="'.$sql[$i][0].'">'.$sql[$i][1].'</option>';
                    }
                }
                ?>
            </select>
        </td>
        <td width="10%"><b></b></td>
        <td width="27%">

        </td>
    </tr>
    <tr>
        <td width="10%"><b>LOGIN</b></td>
        <td width="27%">
            <?php
            if($avance==1){
                echo '<input id="campo_ingreso_seguimientoDespacho_9" name="campo_ingreso_seguimientoDespacho_9" readonly="readonly" style="width:100%" value="'.$rsql_maestro[0]['per_login'].'" />';
            }else if($avance==0){
                echo '<input id="campo_ingreso_seguimientoDespacho_9" name="campo_ingreso_seguimientoDespacho_9" style="width:100%" />';
            }
            ?>
        </td>
        <td width="10%"><b>PASSWORD</b></td>
        <td width="27%">
            <?php
            if($avance==1){
                echo '<input type="password" id="campo_ingreso_seguimientoDespacho_10" name="campo_ingreso_seguimientoDespacho_10" style="width:100%" value="'.$rsql_maestro[0]['per_password'].'" />';
            }else if($avance==0){
                echo '<input type="password" id="campo_ingreso_seguimientoDespacho_10" name="campo_ingreso_seguimientoDespacho_10" style="width:100%" />';
            }
            ?>
        </td>
    </tr>
    <tr>
        <td colspan="6" style="background:#0072C6; color:#fff">CORREOS ADICIONALES</td>
    </tr>
    <tr>
        <td width="10%">

            <?php
            if ( in_array(40, $perfil,true) || in_array(41, $perfil,true)  ){
            ?>
                <a onclick="nuevoCorreo()" class="easyui-linkbutton" data-options="iconCls:'icon-cloud'" style="width:100px">Añadir</a>
            <?php

            };
            ?>
        </td>

    </tr>


    </tbody>
    </table>
        <div style="width: 95%; padding-left: 10px; padding-bottom: 10px">
            <table id="campos">
            <?php
            $auxnumcorreos=0;

            if($avance==1){
                $sql=$_consulta_sistema->query("SELECT * FROM aplicativo_web.aaw_persona_correos where per_codigo=".$_REQUEST['_id_registro_seguimiento']);
                $j=0;
                for($auxnumcorreos=0;$auxnumcorreos<count($sql);$auxnumcorreos++){
                    $j=$auxnumcorreos+1;
                    echo '<tr id="campos_correo_'.$j.'" name="campos_correo_"'.$j.'><td width="6%"><b>CORREO '.$j.'</b></td>
                        <td width="27%">
                        <input type="email" id="campo_correo_seguimientoDespacho_'.$j.'" name="campo_correo_seguimientoDespacho_'.$j.'" style="width:70%; " value="'.$sql[$auxnumcorreos]['per_mail'].'"/>
                        <img id="elimina_correo_'.$j.'" name="elimina_correo_'.$j.'" onclick="eliminaCorreo('.$j.')" src="'.DIR_LOCAL_IMG_SEGUIMIENTO_DESPACHO.'nook_16.png"/>
                        </td></tr>';
                }
                echo '<tr id="campos_num_correo_'.$j.'" name="campos_num_correo_"'.$j.'><td width="6%"><b></b></td>'.
                    '<td width="27%">'.
                    '<input type="hidden" id="num_correo_seguimientoDespacho"  name="num_correo_seguimientoDespacho" style="width:70%; " value='.$j.' />'.
                    '</td></tr>';

            }
            ?>
            </table>

        </div>
    <script type="text/javascript">
        var nextinput = <?php echo $auxnumcorreos?>;
        function nuevoCorreo(){
            nextinput++;


            campo ='<tr id="campos_correo_' + nextinput + '" name="campos_correo_"' + nextinput + '><td width="6%"><b>CORREO ' + nextinput + '</b></td>' +
                '<td width="27%">' +
                '<input type="email" id="campo_correo_seguimientoDespacho_' + nextinput + '" name="campo_correo_seguimientoDespacho_' + nextinput + '" style="width:70%; " /> ' +
                '<img id="elimina_correo_' + nextinput + '" name="elimina_correo_' + nextinput + '" onclick="eliminaCorreo('+nextinput+')" src="<?php echo DIR_LOCAL_IMG_SEGUIMIENTO_DESPACHO ?>nook_16.png"/>' +
                '</td></tr>';

            campo2 ='<tr id="campos_num_correo_' + nextinput + '" name="campos_num_correo_"' + nextinput + '><td width="6%"><b></b></td>' +
                '<td width="27%">' +
                '<input type="hidden" id="num_correo_seguimientoDespacho"  name="num_correo_seguimientoDespacho" style="width:70%; " value=' + nextinput + ' />' +
                '</td></tr>';

            $("#campos").append(campo);
            if(nextinput>0){
                auxnextinput = nextinput-1;
                $("#campos_num_correo_"+ auxnextinput).remove();
                $("#campos").append(campo2);
            }
        }

        function actualizaCorreo(nextinput,correo){
            campo ='<tr id="campos_correo_' + nextinput + '" name="campos_correo_"' + nextinput + '><td width="6%"><b>CORREO ' + nextinput + '</b></td>' +
                '<td width="27%">' +
                '<input type="email" id="campo_correo_seguimientoDespacho_' + nextinput + '" name="campo_correo_seguimientoDespacho_' + nextinput + '" style="width:70%; " value="'+correo+'" />' +
                '<img id="elimina_correo_' + nextinput + '" name="elimina_correo_' + nextinput + '" onclick="eliminaCorreo('+nextinput+')" src="<?php echo DIR_LOCAL_IMG_SEGUIMIENTO_DESPACHO ?>nook_16.png"/>' +
                '</td></tr>';

            campo2 ='<tr id="campos_num_correo_' + nextinput + '" name="campos_num_correo_"' + nextinput + '><td width="6%"><b></b></td>' +
                '<td width="27%">' +
                '<input type="input" id="num_correo_seguimientoDespacho"  name="num_correo_seguimientoDespacho" style="width:70%; " value=' + nextinput + ' />' +
                '</td></tr>';

            $("#campos").append(campo);
            if(nextinput>0){
                auxnextinput = nextinput-1;
                $("#campos_num_correo_"+ auxnextinput).remove();
                $("#campos").append(campo2);
            }
        }

        function eliminaCorreo(id){
            $("#campos_correo_"+id).remove();
        }
    </script>
    </form>
</div>
