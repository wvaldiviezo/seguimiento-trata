<?php
require_once dirname(dirname(dirname(dirname(__FILE__))))."/config.php";
//$_id=2;
if(isset($_SESSION['logueado'])){
    $_id= $_SESSION['Usuid'] ;
}
?>	
	
  <div id="layoutResponsable_opciones_seguimiento_despacho" class="easyui-layout" data-options="fit:true" style="width:100%; height:100%">
  
  
   <div data-options="region:'west',title:'Opciones:',split:true,border:false,hideCollapsedContent:false"
     style="min-width:210px;width:230px; max-width:250px; height:100%; ">
            
               <script type="text/javascript">
    $(function(){
        $("#tree_fn_res_seguimiento_despacho").fancytree({
        click: function(event, data) {
            $.ajax( "class/validador.php")
                .done(function(result) {
					//if(result==1){  				
					if(result==1){  				
                        var node = data.node;
						var p = $('#layoutResponsable_opciones_seguimiento_despacho').layout('panel','center');
						p.panel('refresh',node.data.href);
						//$('#layoutResponsable_opciones_seguimiento_despacho').layout();
						//$('#layoutResponsable_opciones_seguimiento_despacho').layout('collapse','west');
                    }else if(result==0){
                    }
                });
        }
        });
    });
    </script>
    
    <div id="tree_fn_res_seguimiento_despacho" title="Tipos">
                    <ul>
                  
                    
						<li title="Incrementar Responsables" data-icon="<?php echo DIR_REL_SALIDA; ?>img/vacaciones-16.png" ><a style="color:#000 !important" href="<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO."IngresarResponsables.php" ?>">Actualizar Responsables</a></li>
                        
                        
               
                        
                    </ul>
                </div>
    
    
   
    
    
    
    
               
             </div>   
                
                <div data-options="region:'center',border:false" style="padding:10px">
                 
            </div>
                
  </div>

