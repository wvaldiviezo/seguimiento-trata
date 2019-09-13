<?php
require_once DIR_ABS_SEGUIMIENTO_DESPACHO."config.php";
?>
<div id="tabPrincipal_seguimiento_despacho" class="easyui-tabs" data-options="fit:true,plain:true">
	<?php
	if ( in_array(40, $perfil,true)  || in_array(41, $perfil,true)  || in_array(42, $perfil,true) ||  in_array(43, $perfil,true)  || in_array(44, $perfil,true)  ) {
	?>
	
     

	<div title="Actividades"  data-options="iconCls:'icon-responsable'">
        <div id="layoutResponsable_seguimiento_despacho" class="easyui-layout" data-options="fit:true">
            <div data-options="region:'west',title:'Elija una Opción:',split:true,border:false,hideCollapsedContent:false,collapsed:true,
                hideExpandTool: true,
                expandMode: null,
                hideCollapsedContent: false,
                collapsedSize: 68,
                collapsedContent: function(){
                    return $('#titlebar');
                }
                " style="min-width:210px;width:230px; max-width:250px; height:100%; background-color:rgba(187, 187, 187, 0.05)">
            </div>
            <div data-options="region:'center',border:false"></div>
        </div>
    </div>


    
    <div id="titlebar" style="padding:2px">
        <?php
	if ( in_array(40, $perfil,true)  || in_array(41, $perfil,true)   ) {
	?>
        
        <a onclick="nuevaActividad_seguimiento_despacho()" class="easyui-linkbutton" style="width:100%" data-options="iconCls:'icon-nuevo_seguimiento_despacho',size:'large',iconAlign:'top'" style="font-size:2em">Nueva Actividad</a>
          <style>
		  .icon-nuevo_seguimiento_despacho {
				background: url('<?php echo DIR_REL_SEGUIMIENTO_DESPACHO; ?>img/folder-new.png') no-repeat center center;
			}
		  </style>
          
        <script>
		function nuevaActividad_seguimiento_despacho(){
		
		/*$.messager.confirm('Confirmación','Está seguro que desea actualizar la ficha?.',function(r){
						if (r){*/
								$.ajax( "<?php echo DIR_REL ?>class/validador.php")
								  .done(function(result) {
									  if(result==1){
										  
										  var p = $('#layoutResponsable_seguimiento_despacho').layout('panel','center');
										p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>Formulario.php');
										  
									  }else if(result==0){
										location.reload();
									  }
								  });
								  
						/*}
						});*/
		
		}
		</script>
        
         <?php } ?>
        <a onclick="editarActividad_seguimiento_despacho()" class="easyui-linkbutton" style="width:100%" data-options="iconCls:'icon-edit_seguimiento_despacho',size:'large',iconAlign:'top'">Actualizar Actividad</a>
        <a onclick="nuevoReporte_seguimiento_despacho()" class="easyui-linkbutton" style="width:100%" data-options="iconCls:'icon-large-smartart',size:'large',iconAlign:'top'">Exportar Reporte</a>
        <a onclick="nuevaGrafica_seguimiento_despacho()" class="easyui-linkbutton" style="width:100%" data-options="iconCls:'icon-large-chart',size:'large',iconAlign:'top'">Reporte Gráfico</a>
        <a onclick="nuevaCalendario_seguimiento_despacho()" class="easyui-linkbutton" style="width:100%" data-options="iconCls:'icon-calendario_seguimiento_despacho',size:'large',iconAlign:'top'">Calendario</a>
        <a onclick="nuevaBusqueda_seguimiento_despacho()" class="easyui-linkbutton" style="width:100%" data-options="iconCls:'icon-busqueda_seguimiento_despacho',size:'large',iconAlign:'top'">Búsqueda</a>
        <script>
		function nuevaBusqueda_seguimiento_despacho(){
		
		/*$.messager.confirm('Confirmación','Está seguro que desea actualizar la ficha?.',function(r){
						if (r){*/
								$.ajax( "<?php echo DIR_REL ?>class/validador.php")
								  .done(function(result) {
									  if(result==1){
										  
										  var p = $('#layoutResponsable_seguimiento_despacho').layout('panel','center');
										p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>Busqueda.php');
										  
									  }else if(result==0){
										location.reload();
									  }
								  });
								  
						/*}
						});*/
		
		}
		</script>

      <!--  <a href="javascript:void(0)" class="easyui-linkbutton" style="width:100%" data-options="iconCls:'layout-button-right'" onclick="$('#layoutResponsable_seguimiento_despacho').layout('expand','west')"></a>-->
       
        <style>
		
		
		.icon-calendario_seguimiento_despacho {
			background: url('<?php echo DIR_REL_SEGUIMIENTO_DESPACHO; ?>img/calendario_32.png') no-repeat center center;
		}
		.icon-edit_seguimiento_despacho {
			background: url('<?php echo DIR_REL_SEGUIMIENTO_DESPACHO; ?>img/folder-edit.png') no-repeat center center;
		}
		.icon-busqueda_seguimiento_despacho {
			background: url('<?php echo DIR_REL_SEGUIMIENTO_DESPACHO; ?>img/busqueda_32.png') no-repeat center center;
		}
        .icon-salir {
            background: url('<?php echo DIR_REL_SEGUIMIENTO_DESPACHO; ?>img/cancel_32.png') no-repeat center center;
        }
		</style>
        
        
         
        
        <script>
		function nuevaGrafica_seguimiento_despacho(){
		
		/*$.messager.confirm('Confirmación','Está seguro que desea actualizar la ficha?.',function(r){
						if (r){*/
								$.ajax( "<?php echo DIR_REL ?>class/validador.php")
								  .done(function(result) {
									  if(result==1){
										  
										  var p = $('#layoutResponsable_seguimiento_despacho').layout('panel','center');
										p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>Grafica.php');
										  
									  }else if(result==0){
										location.reload();
									  }
								  });
								  
						/*}
						});*/
		
		}
		</script>
        
         
        
        <script>
		function nuevaCalendario_seguimiento_despacho(){
		
		/*$.messager.confirm('Confirmación','Está seguro que desea actualizar la ficha?.',function(r){
						if (r){*/
								$.ajax( "<?php echo DIR_REL ?>class/validador.php")
								  .done(function(result) {
									  if(result==1){
										  
										  var p = $('#layoutResponsable_seguimiento_despacho').layout('panel','center');
										p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>Calendario.php');
										  
									  }else if(result==0){
										location.reload();
									  }
								  });
								  
						/*}
						});*/
		
		}
		</script>
        
         <script>
		function nuevoReporte_seguimiento_despacho(){
		
		/*$.messager.confirm('Confirmación','Está seguro que desea actualizar la ficha?.',function(r){
						if (r){*/
								$.ajax( "<?php echo DIR_REL ?>class/validador.php")
								  .done(function(result) {
									  if(result==1){
										  
										  var p = $('#layoutResponsable_seguimiento_despacho').layout('panel','center');
										p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>Reporte.php');
										  
									  }else if(result==0){
										location.reload();
									  }
								  });
								  
						/*}
						});*/
		
		}
		</script>
        
        <script>
		function editarActividad_seguimiento_despacho(){
		
		/*$.messager.confirm('Confirmación','Está seguro que desea actualizar la ficha?.',function(r){
						if (r){*/
								$.ajax( "<?php echo DIR_REL ?>class/validador.php")
								  .done(function(result) {
									  if(result==1){
										  
										  var p = $('#layoutResponsable_seguimiento_despacho').layout('panel','center');
										p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>visor.php');
										  
									  }else if(result==0){
										location.reload();
									  }
								  });
								  
						/*}
						});*/
		
		}
		</script>
        
        <script>
		 $( function(){
		   var p = $('#layoutResponsable_seguimiento_despacho').layout('panel','center');
		   p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>Calendario.php');
		 });
		 
		  </script>

        <a onclick="salir()" class="easyui-linkbutton" style="width:100%" data-options="iconCls:'icon-salir',size:'large',iconAlign:'top'">Salir</a>


        <script>
            function salir(){

                /*$.messager.confirm('Confirmación','Está seguro que desea actualizar la ficha?.',function(r){
                 if (r){*/
                $.ajax( "<?php echo DIR_REL ?>admin/salirseguimiento.php")
                    .done(function(result) {
                        if(result==1){
                            location.href ="login.php";

                        }else if(result==0){
                            location.reload();
                        }
                    });

                /*}
                 });*/

            }
        </script>
    </div>
        <!- INSTITUCIONES ->
        <?php
        if ( in_array(40, $perfil,true)  || in_array(41, $perfil,true)   ) {
            ?>
            <div title="Instituciones"  data-options="iconCls:'icon-responsable'">
                <div style="width: 650px" id="layoutResponsable_seguimiento_despacho8" class="easyui-layout" data-options="fit:true">
                    <div data-options="region:'west',title:'Elija una Opción:',split:true,border:false,hideCollapsedContent:false,collapsed:true,
                hideExpandTool: true,
                expandMode: null,
                hideCollapsedContent: false,
                collapsedSize: 68,
                collapsedContent: function(){
                    return $('#titlebarinst');
                }
                " style="min-width:210px;width:650px; max-width:650px; height:100%; background-color:rgba(187, 187, 187, 0.05)">
                    </div>
                    <div data-options="region:'center',border:false"></div>
                </div>
            </div>


            <div id="titlebarinst" style="padding:2px">
                <style>

                    .icon-instituciones {
                        background: url('<?php echo DIR_REL_SEGUIMIENTO_DESPACHO; ?>img/edituser_32.png') no-repeat center center;
                    }
                    .icon-salir {
                        background: url('<?php echo DIR_REL_SEGUIMIENTO_DESPACHO; ?>img/cancel_32.png') no-repeat center center;
                    }
                </style>
                <a onclick="crearinstitucion_seguimiento_despacho()" class="easyui-linkbutton" style="width:100%" data-options="iconCls:'icon-instituciones',size:'large',iconAlign:'top'">Nueva Institución</a>
                <script>
                    function crearinstitucion_seguimiento_despacho(){

                        /*$.messager.confirm('Confirmación','Está seguro que desea actualizar la ficha?.',function(r){
                         if (r){*/
                        $.ajax( "<?php echo DIR_REL ?>class/validador.php")
                            .done(function(result) {
                                if(result==1){

                                    var p5 = $('#layoutResponsable_seguimiento_despacho8').layout('panel','center');
                                    //p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>Opciones.php');
                                    //p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>IngresarResponsables.php');
                                    p5.panel('refresh','seguimiento_despacho/src/contenido/admin/institucionadd.php');
                                }else if(result==0){
                                    location.reload();
                                }
                            });

                        /*}
                         });*/

                    }
                </script>
                <a onclick="editarinstitucion_seguimiento_despacho()" class="easyui-linkbutton" style="width:100%" data-options="iconCls:'icon-instituciones',size:'large',iconAlign:'top'">Actualizar Institución</a>
                <script>
                    function editarinstitucion_seguimiento_despacho(){

                        /*$.messager.confirm('Confirmación','Está seguro que desea actualizar la ficha?.',function(r){
                         if (r){*/
                        $.ajax( "<?php echo DIR_REL ?>class/validador.php")
                            .done(function(result) {
                                if(result==1){

                                    var p5 = $('#layoutResponsable_seguimiento_despacho8').layout('panel','center');
                                    //p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>Opciones.php');
                                    //p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>IngresarResponsables.php');
                                    p5.panel('refresh','seguimiento_despacho/src/contenido/admin/institucionlist.php');

                                }else if(result==0){
                                    location.reload();
                                }
                            });

                        /*}
                         });*/

                    }
                </script>


                <a onclick="salir()" class="easyui-linkbutton" style="width:100%" data-options="iconCls:'icon-salir',size:'large',iconAlign:'top'">Salir</a>

                <script>
                    function salir(){

                        /*$.messager.confirm('Confirmación','Está seguro que desea actualizar la ficha?.',function(r){
                         if (r){*/
                        $.ajax( "<?php echo DIR_REL ?>admin/salirseguimiento.php")
                            .done(function(result) {
                                if(result==1){
                                    location.href ="login.php";

                                }else if(result==0){
                                    location.reload();
                                }
                            });

                        /*}
                         });*/

                    }
                </script>
            </div>

        <?php } ?>
    <?php
        if ( in_array(40, $perfil,true)  || in_array(41, $perfil,true)   ) {
    ?>
        <div title="Usuarios"  data-options="iconCls:'icon-responsable'">
            <div style="width: 650px" id="layoutResponsable_seguimiento_despacho2" class="easyui-layout" data-options="fit:true">
                <div data-options="region:'west',title:'Elija una Opción:',split:true,border:false,hideCollapsedContent:false,collapsed:true,
                hideExpandTool: true,
                expandMode: null,
                hideCollapsedContent: false,
                collapsedSize: 68,
                collapsedContent: function(){
                    return $('#titlebaradm');
                }
                " style="min-width:210px;width:650px; max-width:650px; height:100%; background-color:rgba(187, 187, 187, 0.05)">
                </div>
                <div data-options="region:'center',border:false"></div>
            </div>
        </div>


    <div id="titlebaradm" style="padding:2px">
            <style>
                .icon-nuevo_opcion_seguimiento_despacho {
                    background: url('<?php echo DIR_REL_SEGUIMIENTO_DESPACHO; ?>img/opciones_32.png') no-repeat center center;
                }
                .icon-newuser {
                     background: url('<?php echo DIR_REL_SEGUIMIENTO_DESPACHO; ?>img/newuser_32.png') no-repeat center center;
                 }
                .icon-edituser {
                    background: url('<?php echo DIR_REL_SEGUIMIENTO_DESPACHO; ?>img/edituser_32.png') no-repeat center center;
                }
                .icon-salir {
                    background: url('<?php echo DIR_REL_SEGUIMIENTO_DESPACHO; ?>img/cancel_32.png') no-repeat center center;
                }
            </style>
            <a onclick="nuevoUsuario_seguimiento_despacho()" class="easyui-linkbutton" style="width:100%" data-options="iconCls:'icon-newuser',size:'large',iconAlign:'top'">Nuevo Usuario</a>
            <script>
                function nuevoUsuario_seguimiento_despacho(){

                    /*$.messager.confirm('Confirmación','Está seguro que desea actualizar la ficha?.',function(r){
                     if (r){*/
                    $.ajax( "<?php echo DIR_REL ?>class/validador.php")
                        .done(function(result) {
                            if(result==1){

                                var p2 = $('#layoutResponsable_seguimiento_despacho2').layout('panel','center');
                                //p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>Opciones.php');
                                //p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>IngresarResponsables.php');
                                p2.panel('refresh','seguimiento_despacho/src/contenido/admin/usuariosadd.php');
                            }else if(result==0){
                                location.reload();
                            }
                        });

                    /*}
                     });*/

                }
            </script>

            <a onclick="editarUsuario_seguimiento_despacho()" class="easyui-linkbutton" style="width:100%" data-options="iconCls:'icon-edituser',size:'large',iconAlign:'top'">Actualizar Usuario</a>
            <script>
                function editarUsuario_seguimiento_despacho(){

                    /*$.messager.confirm('Confirmación','Está seguro que desea actualizar la ficha?.',function(r){
                     if (r){*/
                    $.ajax( "<?php echo DIR_REL ?>class/validador.php")
                        .done(function(result) {
                            if(result==1){

                                var p2 = $('#layoutResponsable_seguimiento_despacho2').layout('panel','center');
                                //p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>Opciones.php');
                                //p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>IngresarResponsables.php');
                                p2.panel('refresh','seguimiento_despacho/src/contenido/admin/usuarioslist.php');
                            }else if(result==0){
                                location.reload();
                            }
                        });

                    /*}
                     });*/

                }
            </script>


            <a onclick="nuevaOpcion_seguimiento_despacho()" class="easyui-linkbutton" style="width:100%" data-options="iconCls:'icon-nuevo_opcion_seguimiento_despacho',size:'large',iconAlign:'top'">Opciones</a>

            <script>
                function nuevaOpcion_seguimiento_despacho(){

                    /*$.messager.confirm('Confirmación','Está seguro que desea actualizar la ficha?.',function(r){
                     if (r){*/
                    $.ajax( "<?php echo DIR_REL ?>class/validador.php")
                        .done(function(result) {
                            if(result==1){

                                var p2 = $('#layoutResponsable_seguimiento_despacho2').layout('panel','center');
                                //p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>Opciones.php');
                                p2.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>IngresarResponsables.php');

                            }else if(result==0){
                                location.reload();
                            }
                        });

                    /*}
                     });*/

                }
            </script>






        <a onclick="salir()" class="easyui-linkbutton" style="width:100%" data-options="iconCls:'icon-salir',size:'large',iconAlign:'top'">Salir</a>


        <script>
            function salir(){

                /*$.messager.confirm('Confirmación','Está seguro que desea actualizar la ficha?.',function(r){
                 if (r){*/
                $.ajax( "<?php echo DIR_REL ?>admin/salirseguimiento.php")
                    .done(function(result) {
                        if(result==1){
                            location.href ="login.php";

                        }else if(result==0){
                            location.reload();
                        }
                    });

                /*}
                 });*/

            }
        </script>
    </div>

        <?php } ?>
        <!--  <a href="javascript:void(0)" class="easyui-linkbutton" style="width:100%" data-options="iconCls:'layout-button-right'" onclick="$('#layoutResponsable_seguimiento_despacho').layout('expand','west')"></a>-->


        <?php
        if ( in_array(40, $perfil,true)  || in_array(41, $perfil,true)   ) {
            ?>
            <div title="Perfiles de Usuarios"  data-options="iconCls:'icon-responsable'">
                <div style="width: 650px" id="layoutResponsable_seguimiento_despacho3" class="easyui-layout" data-options="fit:true">
                    <div data-options="region:'west',title:'Elija una Opción:',split:true,border:false,hideCollapsedContent:false,collapsed:true,
                hideExpandTool: true,
                expandMode: null,
                hideCollapsedContent: false,
                collapsedSize: 68,
                collapsedContent: function(){
                    return $('#titlebarper');
                }
                " style="min-width:210px;width:650px; max-width:650px; height:100%; background-color:rgba(187, 187, 187, 0.05)">
                    </div>
                    <div data-options="region:'center',border:false"></div>
                </div>
            </div>


            <div id="titlebarper" style="padding:2px">
                <style>
                    .icon-nuevo_opcion_seguimiento_despacho {
                        background: url('<?php echo DIR_REL_SEGUIMIENTO_DESPACHO; ?>img/opciones_32.png') no-repeat center center;
                    }
                    .icon-newuser {
                        background: url('<?php echo DIR_REL_SEGUIMIENTO_DESPACHO; ?>img/newuser_32.png') no-repeat center center;
                    }
                    .icon-edituser {
                        background: url('<?php echo DIR_REL_SEGUIMIENTO_DESPACHO; ?>img/edituser_32.png') no-repeat center center;
                    }
                    .icon-salir {
                        background: url('<?php echo DIR_REL_SEGUIMIENTO_DESPACHO; ?>img/cancel_32.png') no-repeat center center;
                    }
                </style>

                <a onclick="crearPerfilUsuario_seguimiento_despacho()" class="easyui-linkbutton" style="width:100%" data-options="iconCls:'icon-newuser',size:'large',iconAlign:'top'">Asignar Perfil</a>
                <script>
                    function crearPerfilUsuario_seguimiento_despacho(){

                        /*$.messager.confirm('Confirmación','Está seguro que desea actualizar la ficha?.',function(r){
                         if (r){*/
                        $.ajax( "<?php echo DIR_REL ?>class/validador.php")
                            .done(function(result) {
                                if(result==1){

                                    var p3 = $('#layoutResponsable_seguimiento_despacho3').layout('panel','center');
                                    //p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>Opciones.php');
                                    //p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>IngresarResponsables.php');
                                    p3.panel('refresh','seguimiento_despacho/src/contenido/admin/perfilesusulist.php');
                                }else if(result==0){
                                    location.reload();
                                }
                            });

                        /*}
                         });*/

                    }
                </script>

                <a onclick="editarPerfilUsuario_seguimiento_despacho()" class="easyui-linkbutton" style="width:100%" data-options="iconCls:'icon-edituser',size:'large',iconAlign:'top'">Actualizar Perfil</a>
                <script>
                    function editarPerfilUsuario_seguimiento_despacho(){

                        /*$.messager.confirm('Confirmación','Está seguro que desea actualizar la ficha?.',function(r){
                         if (r){*/
                        $.ajax( "<?php echo DIR_REL ?>class/validador.php")
                            .done(function(result) {
                                if(result==1){

                                    var p3 = $('#layoutResponsable_seguimiento_despacho3').layout('panel','center');
                                    //p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>Opciones.php');
                                    //p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>IngresarResponsables.php');
                                    p3.panel('refresh','seguimiento_despacho/src/contenido/admin/perfilesusuedit.php');
                                }else if(result==0){
                                    location.reload();
                                }
                            });

                        /*}
                         });*/

                    }
                </script>










                <a onclick="salir()" class="easyui-linkbutton" style="width:100%" data-options="iconCls:'icon-salir',size:'large',iconAlign:'top'">Salir</a>


                <script>
                    function salir(){

                        /*$.messager.confirm('Confirmación','Está seguro que desea actualizar la ficha?.',function(r){
                         if (r){*/
                        $.ajax( "<?php echo DIR_REL ?>admin/salirseguimiento.php")
                            .done(function(result) {
                                if(result==1){
                                    location.href ="login.php";

                                }else if(result==0){
                                    location.reload();
                                }
                            });

                        /*}
                         });*/

                    }
                </script>
            </div>

        <?php } ?>




        <!- AÑOS ->
        <?php
        if ( in_array(40, $perfil,true)  || in_array(41, $perfil,true)   ) {
            ?>
            <div title="Años"  data-options="iconCls:'icon-responsable'">
                <div style="width: 650px" id="layoutResponsable_seguimiento_despacho4" class="easyui-layout" data-options="fit:true">
                    <div data-options="region:'west',title:'Elija una Opción:',split:true,border:false,hideCollapsedContent:false,collapsed:true,
                hideExpandTool: true,
                expandMode: null,
                hideCollapsedContent: false,
                collapsedSize: 68,
                collapsedContent: function(){
                    return $('#titlebaranio');
                }
                " style="min-width:210px;width:650px; max-width:650px; height:100%; background-color:rgba(187, 187, 187, 0.05)">
                    </div>
                    <div data-options="region:'center',border:false"></div>
                </div>
            </div>



            <div id="titlebaranio" style="padding:2px">
                <style>
                    .icon-calendarv2 {
                        background: url('<?php echo DIR_REL_SEGUIMIENTO_DESPACHO; ?>img/calendarv2.png') no-repeat center center;
                    }
                    .icon-objgen {
                        background: url('<?php echo DIR_REL_SEGUIMIENTO_DESPACHO; ?>img/objgen1.png') no-repeat center center;
                    }
                    .icon-objesp {
                        background: url('<?php echo DIR_REL_SEGUIMIENTO_DESPACHO; ?>img/objespe1.png') no-repeat center center;
                    }
                    .icon-eje {
                        background: url('<?php echo DIR_REL_SEGUIMIENTO_DESPACHO; ?>img/eje1.png') no-repeat center center;
                    }
                    .icon-salir {
                        background: url('<?php echo DIR_REL_SEGUIMIENTO_DESPACHO; ?>img/cancel_32.png') no-repeat center center;
                    }
                </style>
                <a onclick="crearanio_seguimiento_despacho()" class="easyui-linkbutton" style="width:100%" data-options="iconCls:'icon-calendarv2',size:'large',iconAlign:'top'">Nuevo Año</a>
                <script>
                    function crearanio_seguimiento_despacho(){

                        /*$.messager.confirm('Confirmación','Está seguro que desea actualizar la ficha?.',function(r){
                         if (r){*/
                        $.ajax( "<?php echo DIR_REL ?>class/validador.php")
                            .done(function(result) {
                                if(result==1){

                                    var p4 = $('#layoutResponsable_seguimiento_despacho4').layout('panel','center');
                                    //p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>Opciones.php');
                                    //p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>IngresarResponsables.php');
                                    p4.panel('refresh','seguimiento_despacho/src/contenido/admin/aniosadd.php');
                                }else if(result==0){
                                    location.reload();
                                }
                            });

                        /*}
                         });*/

                    }
                </script>
                <a onclick="editaranio_seguimiento_despacho()" class="easyui-linkbutton" style="width:100%" data-options="iconCls:'icon-calendarv2',size:'large',iconAlign:'top'">Actualizar Año</a>
                <script>
                    function editaranio_seguimiento_despacho(){

                        /*$.messager.confirm('Confirmación','Está seguro que desea actualizar la ficha?.',function(r){
                         if (r){*/
                        $.ajax( "<?php echo DIR_REL ?>class/validador.php")
                            .done(function(result) {
                                if(result==1){

                                    var p4 = $('#layoutResponsable_seguimiento_despacho4').layout('panel','center');
                                    //p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>Opciones.php');
                                    //p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>IngresarResponsables.php');
                                    p4.panel('refresh','seguimiento_despacho/src/contenido/admin/anioslist.php');
                                    //p2.panel('refresh','seguimiento_despacho/src/contenido/admin/aniosadd.php?_id_registro_seguimiento=0');
                                }else if(result==0){
                                    location.reload();
                                }
                            });

                        /*}
                         });*/

                    }
                </script>

                <a onclick="salir()" class="easyui-linkbutton" style="width:100%" data-options="iconCls:'icon-salir',size:'large',iconAlign:'top'">Salir</a>

                <script>
                    function salir(){

                        /*$.messager.confirm('Confirmación','Está seguro que desea actualizar la ficha?.',function(r){
                         if (r){*/
                        $.ajax( "<?php echo DIR_REL ?>admin/salirseguimiento.php")
                            .done(function(result) {
                                if(result==1){
                                    location.href ="login.php";

                                }else if(result==0){
                                    location.reload();
                                }
                            });

                        /*}
                         });*/

                    }
                </script>
            </div>

        <?php } ?>
        <!- EJES ->
        <?php
        if ( in_array(40, $perfil,true)  || in_array(41, $perfil,true)   ) {
            ?>
            <div title="Ejes"  data-options="iconCls:'icon-responsable'">
                <div style="width: 650px" id="layoutResponsable_seguimiento_despacho5" class="easyui-layout" data-options="fit:true">
                    <div data-options="region:'west',title:'Elija una Opción:',split:true,border:false,hideCollapsedContent:false,collapsed:true,
                hideExpandTool: true,
                expandMode: null,
                hideCollapsedContent: false,
                collapsedSize: 68,
                collapsedContent: function(){
                    return $('#titlebareje');
                }
                " style="min-width:210px;width:650px; max-width:650px; height:100%; background-color:rgba(187, 187, 187, 0.05)">
                    </div>
                    <div data-options="region:'center',border:false"></div>
                </div>
            </div>


            <div id="titlebareje" style="padding:2px">
                <style>

                    .icon-eje {
                        background: url('<?php echo DIR_REL_SEGUIMIENTO_DESPACHO; ?>img/eje1.png') no-repeat center center;
                    }
                    .icon-salir {
                        background: url('<?php echo DIR_REL_SEGUIMIENTO_DESPACHO; ?>img/cancel_32.png') no-repeat center center;
                    }
                </style>
                <a onclick="crearejes_seguimiento_despacho()" class="easyui-linkbutton" style="width:100%" data-options="iconCls:'icon-eje',size:'large',iconAlign:'top'">Nuevo Eje</a>
                <script>
                    function crearejes_seguimiento_despacho(){

                        /*$.messager.confirm('Confirmación','Está seguro que desea actualizar la ficha?.',function(r){
                         if (r){*/
                        $.ajax( "<?php echo DIR_REL ?>class/validador.php")
                            .done(function(result) {
                                if(result==1){

                                    var p5 = $('#layoutResponsable_seguimiento_despacho5').layout('panel','center');
                                    //p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>Opciones.php');
                                    //p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>IngresarResponsables.php');
                                    p5.panel('refresh','seguimiento_despacho/src/contenido/admin/ejesadd.php');
                                }else if(result==0){
                                    location.reload();
                                }
                            });

                        /*}
                         });*/

                    }
                </script>
                <a onclick="editarejes_seguimiento_despacho()" class="easyui-linkbutton" style="width:100%" data-options="iconCls:'icon-eje',size:'large',iconAlign:'top'">Actualizar Eje</a>
                <script>
                    function editarejes_seguimiento_despacho(){

                        /*$.messager.confirm('Confirmación','Está seguro que desea actualizar la ficha?.',function(r){
                         if (r){*/
                        $.ajax( "<?php echo DIR_REL ?>class/validador.php")
                            .done(function(result) {
                                if(result==1){

                                    var p5 = $('#layoutResponsable_seguimiento_despacho5').layout('panel','center');
                                    //p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>Opciones.php');
                                    //p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>IngresarResponsables.php');
                                    p5.panel('refresh','seguimiento_despacho/src/contenido/admin/ejeslist.php');

                                }else if(result==0){
                                    location.reload();
                                }
                            });

                        /*}
                         });*/

                    }
                </script>


                <a onclick="salir()" class="easyui-linkbutton" style="width:100%" data-options="iconCls:'icon-salir',size:'large',iconAlign:'top'">Salir</a>

                <script>
                    function salir(){

                        /*$.messager.confirm('Confirmación','Está seguro que desea actualizar la ficha?.',function(r){
                         if (r){*/
                        $.ajax( "<?php echo DIR_REL ?>admin/salirseguimiento.php")
                            .done(function(result) {
                                if(result==1){
                                    location.href ="login.php";

                                }else if(result==0){
                                    location.reload();
                                }
                            });

                        /*}
                         });*/

                    }
                </script>
            </div>

        <?php } ?>

        <!- OBJETIVOS GENERALES ->
        <?php
        if ( in_array(40, $perfil,true)  || in_array(41, $perfil,true)   ) {
            ?>
            <div title="Objetivos Generales"  data-options="iconCls:'icon-responsable'">
                <div style="width: 650px" id="layoutResponsable_seguimiento_despacho6" class="easyui-layout" data-options="fit:true">
                    <div data-options="region:'west',title:'Elija una Opción:',split:true,border:false,hideCollapsedContent:false,collapsed:true,
                hideExpandTool: true,
                expandMode: null,
                hideCollapsedContent: false,
                collapsedSize: 68,
                collapsedContent: function(){
                    return $('#titlebarobjgen');
                }
                " style="min-width:210px;width:650px; max-width:650px; height:100%; background-color:rgba(187, 187, 187, 0.05)">
                    </div>
                    <div data-options="region:'center',border:false"></div>
                </div>
            </div>


            <div id="titlebarobjgen" style="padding:2px">
                <style>
                    .icon-objgen {
                        background: url('<?php echo DIR_REL_SEGUIMIENTO_DESPACHO; ?>img/objgen1.png') no-repeat center center;
                    }
                    .icon-salir {
                        background: url('<?php echo DIR_REL_SEGUIMIENTO_DESPACHO; ?>img/cancel_32.png') no-repeat center center;
                    }
                </style>
                <a onclick="creacionobjgen_seguimiento_despacho()" class="easyui-linkbutton" style="width:100%" data-options="iconCls:'icon-objgen',size:'large',iconAlign:'top'">Nuevo Objetivo</a>
                <script>
                    function creacionobjgen_seguimiento_despacho(){

                        /*$.messager.confirm('Confirmación','Está seguro que desea actualizar la ficha?.',function(r){
                         if (r){*/
                        $.ajax( "<?php echo DIR_REL ?>class/validador.php")
                            .done(function(result) {
                                if(result==1){

                                    var p6 = $('#layoutResponsable_seguimiento_despacho6').layout('panel','center');
                                    //p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>Opciones.php');
                                    //p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>IngresarResponsables.php');
                                    p6.panel('refresh','seguimiento_despacho/src/contenido/admin/objgenadd.php');
                                }else if(result==0){
                                    location.reload();
                                }
                            });

                        /*}
                         });*/

                    }
                </script>
                <a onclick="editarobjgen_seguimiento_despacho()" class="easyui-linkbutton" style="width:100%" data-options="iconCls:'icon-objgen',size:'large',iconAlign:'top'">Actualizar Objetivo</a>
                <script>
                    function editarobjgen_seguimiento_despacho(){

                        /*$.messager.confirm('Confirmación','Está seguro que desea actualizar la ficha?.',function(r){
                         if (r){*/
                        $.ajax( "<?php echo DIR_REL ?>class/validador.php")
                            .done(function(result) {
                                if(result==1){

                                    var p6 = $('#layoutResponsable_seguimiento_despacho6').layout('panel','center');
                                    //p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>Opciones.php');
                                    //p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>IngresarResponsables.php');
                                    p6.panel('refresh','seguimiento_despacho/src/contenido/admin/objgenlist.php');
                                }else if(result==0){
                                    location.reload();
                                }
                            });

                        /*}
                         });*/

                    }
                </script>



                <a onclick="salir()" class="easyui-linkbutton" style="width:100%" data-options="iconCls:'icon-salir',size:'large',iconAlign:'top'">Salir</a>

                <script>
                    function salir(){

                        /*$.messager.confirm('Confirmación','Está seguro que desea actualizar la ficha?.',function(r){
                         if (r){*/
                        $.ajax( "<?php echo DIR_REL ?>admin/salirseguimiento.php")
                            .done(function(result) {
                                if(result==1){
                                    location.href ="login.php";

                                }else if(result==0){
                                    location.reload();
                                }
                            });

                        /*}
                         });*/

                    }
                </script>
            </div>

        <?php } ?>
        <!- OBJETIVOS ESPECIFICOS ->
        <?php
        if ( in_array(40, $perfil,true)  || in_array(41, $perfil,true)   ) {
            ?>
            <div title="Objetivos Específicos"  data-options="iconCls:'icon-responsable'">
                <div style="width: 650px" id="layoutResponsable_seguimiento_despacho7" class="easyui-layout" data-options="fit:true">
                    <div data-options="region:'west',title:'Elija una Opción:',split:true,border:false,hideCollapsedContent:false,collapsed:true,
                hideExpandTool: true,
                expandMode: null,
                hideCollapsedContent: false,
                collapsedSize: 68,
                collapsedContent: function(){
                    return $('#titlebarobjesp');
                }
                " style="min-width:210px;width:650px; max-width:650px; height:100%; background-color:rgba(187, 187, 187, 0.05)">
                    </div>
                    <div data-options="region:'center',border:false"></div>
                </div>
            </div>


            <div id="titlebarobjesp" style="padding:2px">
                <style>
                    .icon-objesp {
                        background: url('<?php echo DIR_REL_SEGUIMIENTO_DESPACHO; ?>img/objespe1.png') no-repeat center center;
                    .icon-salir {
                        background: url('<?php echo DIR_REL_SEGUIMIENTO_DESPACHO; ?>img/cancel_32.png') no-repeat center center;
                    }
                </style>
                <a onclick="crearobjesp_seguimiento_despacho()" class="easyui-linkbutton" style="width:100%" data-options="iconCls:'icon-objesp',size:'large',iconAlign:'top'">Nuevo Objetivo</a>
                <script>
                    function crearobjesp_seguimiento_despacho(){

                        /*$.messager.confirm('Confirmación','Está seguro que desea actualizar la ficha?.',function(r){
                         if (r){*/
                        $.ajax( "<?php echo DIR_REL ?>class/validador.php")
                            .done(function(result) {
                                if(result==1){

                                    var p7 = $('#layoutResponsable_seguimiento_despacho7').layout('panel','center');
                                    //p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>Opciones.php');
                                    //p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>IngresarResponsables.php');
                                    p7.panel('refresh','seguimiento_despacho/src/contenido/admin/objespadd.php');
                                }else if(result==0){
                                    location.reload();
                                }
                            });

                        /*}
                         });*/

                    }
                </script>
                <a onclick="editarobjesp_seguimiento_despacho()" class="easyui-linkbutton" style="width:100%" data-options="iconCls:'icon-objesp',size:'large',iconAlign:'top'">Actualizar Objetivo</a>
                <script>
                    function editarobjesp_seguimiento_despacho(){

                        /*$.messager.confirm('Confirmación','Está seguro que desea actualizar la ficha?.',function(r){
                         if (r){*/
                        $.ajax( "<?php echo DIR_REL ?>class/validador.php")
                            .done(function(result) {
                                if(result==1){

                                    var p7 = $('#layoutResponsable_seguimiento_despacho7').layout('panel','center');
                                    //p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>Opciones.php');
                                    //p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>IngresarResponsables.php');
                                    p7.panel('refresh','seguimiento_despacho/src/contenido/admin/objesplist.php');
                                }else if(result==0){
                                    location.reload();
                                }
                            });

                        /*}
                         });*/

                    }
                </script>

                <a onclick="salir()" class="easyui-linkbutton" style="width:100%" data-options="iconCls:'icon-salir',size:'large',iconAlign:'top'">Salir</a>

                <script>
                    function salir(){

                        /*$.messager.confirm('Confirmación','Está seguro que desea actualizar la ficha?.',function(r){
                         if (r){*/
                        $.ajax( "<?php echo DIR_REL ?>admin/salirseguimiento.php")
                            .done(function(result) {
                                if(result==1){
                                    location.href ="login.php";

                                }else if(result==0){
                                    location.reload();
                                }
                            });

                        /*}
                         });*/

                    }
                </script>
            </div>

        <?php } ?>

	<?php
	}
	?>




</div>