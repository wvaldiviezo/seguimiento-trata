<?php
require_once dirname(dirname(dirname(dirname(__FILE__))))."/config.php";
//$_id=2;
if(isset($_SESSION['logueado'])){
    $_id= $_SESSION['Usuid'] ;
}

//$url='%5B%7B%22field%22%3A%22cmp4VisorBusqueda_seguimiento_despacho%22%2C%22op%22%3A%22equal%22%2C%22value%22%3A%228%22%7D%5D';
/*$data='[{"field":"cmp4VisorBusquedaAvanzada_seguimiento_despacho","op":"equal","value":"8"}]';
$url=urlencode($data);*/
$url="";
if(isset($_REQUEST["filterRules"]))
	$url=urlencode($_REQUEST["filterRules"]);

   $respuesta='<table url="'.DIR_LOCAL_DATAGRID_SEGUIMIENTO_DESPACHO.'dtg_Busqueda.php?filterRules='.$url.'" id="tblVisorBusquedaAvanzada_seguimiento_despacho" style="width:100%;height:100%" 
	data-options="singleSelect:true,pagination:false, rownumbers:false, fitColumns:true,remoteFilter:true,view:scrollview,
	onClickRow:function(){ abrirBusqueda();},

	 ">
		<thead>
			<tr >
				<th data-options="field:\'cmp0VisorBusquedaAvanzada_seguimiento_despacho\'" style="width:12%"><b>Código</b></th>
				<th data-options="field:\'cmp1VisorBusquedaAvanzada_seguimiento_despacho\'" style="width:14%"><b>Nombre</b></th>
				<th data-options="field:\'cmp2VisorBusquedaAvanzada_seguimiento_despacho\'" style="width:20%"><b>Responsable</b></th>
				<th data-options="field:\'cmp3VisorBusquedaAvanzada_seguimiento_despacho\'" style="width:15%"><b>Fec. Fin</b></th>
				<th data-options="field:\'cmp4VisorBusquedaAvanzada_seguimiento_despacho\'" style="width:15%"><b>Estado</b></th>
				<th data-options="field:\'cmp5VisorBusquedaAvanzada_seguimiento_despacho\'" style="width:15%"><b>Impacto</b></th>
				<th data-options="field:\'cmp6VisorBusquedaAvanzada_seguimiento_despacho\'" style="width:13%"><b>Avance</b></th>
				<th data-options="field:\'cmp7VisorBusquedaAvanzada_seguimiento_despacho\',hidden:true" style="width:13%"><b>Opción Avance</b></th>
				<th data-options="field:\'cmp8VisorBusquedaAvanzada_seguimiento_despacho\',hidden:true" style="width:13%"><b>Opción Mensaje</b></th>
				<th data-options="field:\'cmp9VisorBusquedaAvanzada_seguimiento_despacho\',hidden:true" style="width:13%"><b>Opción Archivo</b></th>
				<th data-options="field:\'cmp10VisorBusquedaAvanzada_seguimiento_despacho\',hidden:true" style="width:13%"><b>Opción Estado</b></th>
				<th data-options="field:\'cmp11VisorBusquedaAvanzada_seguimiento_despacho\',hidden:true" style="width:13%"><b>Opción Impacto</b></th>
			</tr>
		</thead>
	   
	</table>
	
	
	';
	echo $respuesta;
   ?>
         
         
  
         
         
         
         <script>
        var cardview = $.extend({}, $.fn.datagrid.defaults.view, {
            renderRow: function(target, fields, frozen, rowIndex, rowData){
                var cc = [];
                cc.push('<td colspan=' + fields.length + ' style="padding:0px 0px;border:0;">');
                if (!frozen && rowData.cmp0VisorBusquedaAvanzada_seguimiento_despacho){
                    var aa = rowData.cmp0VisorBusquedaAvanzada_seguimiento_despacho.split('-');
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
            $('#tblVisorBusquedaAvanzada_seguimiento_despacho').datagrid({
                view: cardview
            });
        });
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
				$('#tblVisorBusquedaAvanzada_seguimiento_despacho').datagrid({striped:$(this)});
				//$('#tblVisorBusquedaAvanzada_seguimiento_despacho').datagrid('regionSelect');
				$('#tblVisorBusquedaAvanzada_seguimiento_despacho').datagrid('getPanel').removeClass('lines-both lines-no lines-right lines-bottom').addClass("lines-no");
				$("[name=cmp0VisorBusquedaAvanzada_seguimiento_despacho]").attr("placeholder", "DIGITE");
				$("[name=cmp1VisorBusquedaAvanzada_seguimiento_despacho]").attr("placeholder", "DIGITE");
				$("[name=cmp2VisorBusquedaAvanzada_seguimiento_despacho]").attr("placeholder", "DIGITE");
				$("[name=cmp3VisorBusquedaAvanzada_seguimiento_despacho]").attr("placeholder", "DIGITE");
				$("[name=cmp4VisorBusquedaAvanzada_seguimiento_despacho]").attr("placeholder", "DIGITE");
				$("[name=cmp5VisorBusquedaAvanzada_seguimiento_despacho]").attr("placeholder", "DIGITE");
			});
			
			function abrirBusqueda(){
				var row = $('#tblVisorBusquedaAvanzada_seguimiento_despacho').datagrid('getSelected');
				if (row){
						var p = $('#layoutResponsable_busqueda_seguimiento_despacho').layout('panel','center');
						p.panel('refresh','<?php echo DIR_LOCAL_RESPONSABLE_SEGUIMIENTO_DESPACHO ?>Formulario.php?_id_registro_seguimiento='+row.cmp0VisorBusquedaAvanzada_seguimiento_despacho);
				}else{
					$.messager.alert('Mensaje','Primero debe seleccionar un documento.','warning');
				}
			}
			
			
			</script>
