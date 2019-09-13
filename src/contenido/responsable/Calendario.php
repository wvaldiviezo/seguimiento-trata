<?php
ini_set('error_reporting',E_ALL);
ini_set('display_errors', 1);
require_once dirname(dirname(dirname(dirname(__FILE__))))."/config.php";
//$_id=2;
if(isset($_SESSION['logueado'])){
    $_id= $_SESSION['Usuid'] ;
}
?>

  <div id="layoutResponsable_calendario_seguimiento_despacho" class="easyui-layout" data-options="fit:true" style="width:100%; height:100%">
  
  
 <div data-options="region:'west',title:'Calendario:',split:true,border:false,striped:true" style="min-width:460px;width:480px; max-width:540px; height:100%; background-color:rgba(187, 187, 187, 0.01)">
               
               
<?php 
require_once DIR_ABS_SEGUIMIENTO_DESPACHO."src/contenido/responsable/TblCalendario.php"; ?>
               
               
             </div>   
                
                <div data-options="region:'center',border:false" style="padding:10px">
           </div>
                
  </div>

