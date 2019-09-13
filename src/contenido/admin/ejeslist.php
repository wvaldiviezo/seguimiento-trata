<?php
require_once dirname(dirname(dirname(dirname(__FILE__))))."/config.php";
//$_id=965;
if(isset($_SESSION['logueado'])){
    $_id= $_SESSION['Usuid'] ;
}

?>



<div id="layoutBusquedaNormal_seguimiento_despacho6" class="easyui-layout" data-options="fit:true">
              <div data-options="region:'west',title:'Búsquedas:',split:true,border:false,striped:true" style="min-width:460px;width:600px; max-width:600px; height:100%; background-color:rgba(187, 187, 187, 0.05)">
 <?php
   $respuesta='<table url="'.DIR_LOCAL_DATAGRID_SEGUIMIENTO_DESPACHO.'dtg_Ejes.php" id="tblVisorBusqueda_seguimiento_despacho6" style="width:100%;height:100%"
	data-options="singleSelect:true,pagination:false, rownumbers:false, fitColumns:true,remoteFilter:true,view:scrollview,
	onClickRow:function(){ abrirFormulario();},

	 ">
		<thead>
			<tr >
				<th data-options="field:\'cmp0VisorBusqueda_seguimiento_despacho\'" style="width:30%"><b>Código</b></th>
				<th data-options="field:\'cmp1VisorBusqueda_seguimiento_despacho\'" style="width:75%"><b>Eje</b></th>
			</tr>
		</thead>
	   
	</table>
	
	
	';
	echo $respuesta;
   ?>
         
         
  
         
         
         
         <script>
        /*var cardview = $.extend({}, $.fn.datagrid.defaults.view, {
            renderRow: function(target, fields, frozen, rowIndex, rowData){
                var cc = [];
                cc.push('<td colspan=' + fields.length + ' style="padding:0px 0px;border:0;">');
                if (!frozen && rowData.cmp0VisorBusqueda_seguimiento_despacho){
                    var aa = rowData.cmp0VisorBusqueda_seguimiento_despacho.split('-');
                     var total="";
                     if(rowIndex==0){
                     var total="<b><em style='padding-bottom:5px'>" + $(target).datagrid('getData').total  + " Registros Encontrados</em></b><br/> ";
                     }
                    //var img = 'shirt' + aa[1] + '.gif';
                    //cc.push('<img src="images/' + img + '" style="width:150px;float:left">');
					var total="";
					if(rowIndex==0){
						var total="<b><em style='padding-bottom:5px'>" + $(target).datagrid('getData').total  + " Registros Encontrados</em></b><br/> ";
					}
                    cc.push('<div style="width:100%;float:left;margin-left:5px;margin-right:5px; word-break:break-all; border-bottom:1px solid #CCC">'+ total  +'<br /><table rules="all" style="width:98%; border: 0px!important">');
					var estado_avance="";
					var estado_mensaje="";
					var estado_archivo="";
					var imagen='<img src="<?php echo DIR_LOCAL_IMG_SEGUIMIENTO_DESPACHO ?>star_seguimiento.png">';
					switch(parseInt(rowData[fields[10]])){
						case 1:
							rowData[fields[10]]='<img width="16px" src="<?php echo DIR_LOCAL_IMG_SEGUIMIENTO_DESPACHO ?>estado/1.png">';
						break;
						case 2:
							rowData[fields[10]]='<img width="16px" src="<?php echo DIR_LOCAL_IMG_SEGUIMIENTO_DESPACHO ?>estado/2.png">';
						break;
						case 3:
							rowData[fields[10]]='<img width="16px" src="<?php echo DIR_LOCAL_IMG_SEGUIMIENTO_DESPACHO ?>estado/3.png">';
						break;
						case 4:
							rowData[fields[10]]='<img width="16px" src="<?php echo DIR_LOCAL_IMG_SEGUIMIENTO_DESPACHO ?>estado/4.png">';
						break;
						case 5:
							rowData[fields[10]]='<img width="16px" src="<?php echo DIR_LOCAL_IMG_SEGUIMIENTO_DESPACHO ?>estado/5.png">';
						break;
						case 6:
							rowData[fields[10]]='<img width="16px" src="<?php echo DIR_LOCAL_IMG_SEGUIMIENTO_DESPACHO ?>estado/6.png">';
						break;
						case 7:
							rowData[fields[10]]='<img width="16px" src="<?php echo DIR_LOCAL_IMG_SEGUIMIENTO_DESPACHO ?>estado/7.png">';
						break;
						case 8:
							rowData[fields[10]]='<img width="16px" src="<?php echo DIR_LOCAL_IMG_SEGUIMIENTO_DESPACHO ?>estado/8.png">';
						break;
						case 9:
							rowData[fields[10]]='<img width="16px" src="<?php echo DIR_LOCAL_IMG_SEGUIMIENTO_DESPACHO ?>estado/9.png">';
						break;
						case 10:
							rowData[fields[10]]='<img width="16px" src="<?php echo DIR_LOCAL_IMG_SEGUIMIENTO_DESPACHO ?>estado/10.png">';
						break;
					}
					switch(parseInt(rowData[fields[11]])){
						case 1:
							rowData[fields[11]]=imagen;
						break;
						case 2:
							rowData[fields[11]]=imagen+imagen;
						break;
						case 3:
							rowData[fields[11]]=imagen+imagen+imagen;
						break;
						case 4:
							rowData[fields[11]]=imagen+imagen+imagen+imagen;
						break;
						case 5:
							rowData[fields[11]]=imagen+imagen+imagen+imagen+imagen;
						break;
					}
					if(rowData[fields[7]]=="avance_1")
						estado_avance='<img src="<?php echo DIR_LOCAL_IMG_SEGUIMIENTO_DESPACHO ?>avance_20.png">';
					if(rowData[fields[8]]=="mensaje_1")
						estado_mensaje='<img src="<?php echo DIR_LOCAL_IMG_SEGUIMIENTO_DESPACHO ?>mensaje_20.png">';
					if(rowData[fields[9]]=="archivo_1")
						estado_archivo='<img src="<?php echo DIR_LOCAL_IMG_SEGUIMIENTO_DESPACHO ?>archivo_20.png">';
					
					cc.push('<tbody><tr><td align="left" style="border: 0px!important; width:10%">'+ rowData[fields[0]] +'</td><td align="left" style="border: 0px!important; width:10%">'+ rowData[fields[10]] +'</td><td align="left" style="border: 0px!important;width:30%">' + rowData[fields[11]] + '</td><td style="border: 0px!important;width:15%" align="left">' + rowData[fields[6]] + '%</td><td align="right" style="border: 0px!important; width:30%">' +  estado_avance+ estado_mensaje + estado_archivo  + '</td></tr><tr ><td align="left" colspan="5" style="text-align:justify;border: 0px!important">' + rowData[fields[1]] + '</td></tr><tr><td align="left" colspan="2" style="border: 0px!important">' + rowData[fields[3]] + '</td><td align="left" style="border: 0px!important" colspan="3">' + rowData[fields[2]] + '</td></tr>');
                    cc.push('</tbody></table></div>');
                }
                cc.push('</td>');
				
                return cc.join('');
            }
        });
        $(function(){
            $('#tblVisorBusqueda_seguimiento_despacho').datagrid({
                view: cardview
            });
        });*/
    </script>
    <style type="text/css">
        .c-label{
            display:inline-block;
            width:100px;
            font-weight:bold;
        }
    </style>
    <style>
	.datagrid-btable{
		width:100%;
	}
	</style>
         
         
         <script>

			$(function (){
				$('#tblVisorBusqueda_seguimiento_despacho6').datagrid({striped:$(this)});
				//$('#tblVisorBusqueda_seguimiento_despacho').datagrid('regionSelect');
				$('#tblVisorBusqueda_seguimiento_despacho6').datagrid('getPanel').removeClass('lines-both lines-no lines-right lines-bottom').addClass("lines-no");
				$('#tblVisorBusqueda_seguimiento_despacho6').datagrid('enableFilter', [


				]

				);
				$("[name=cmp0VisorBusqueda_seguimiento_despacho]").attr("placeholder", "DIGITE");
				$("[name=cmp1VisorBusqueda_seguimiento_despacho]").attr("placeholder", "DIGITE");
			});
			
			function abrirFormulario(){
				var row = $('#tblVisorBusqueda_seguimiento_despacho6').datagrid('getSelected');
				if (row){
						var p = $('#layoutBusquedaNormal_seguimiento_despacho6').layout('panel','center');
						p.panel('refresh','seguimiento_despacho/src/contenido/admin/ejesadd.php?_id_registro_seguimiento='+row.cmp0VisorBusqueda_seguimiento_despacho);
				}else{
					$.messager.alert('Mensaje','Primero debe seleccionar un documento.','warning');
				}
			}
			
			
			</script>
         

   </div>
 
 
 <div data-options="region:'center',border:false">
            </div>
</div>