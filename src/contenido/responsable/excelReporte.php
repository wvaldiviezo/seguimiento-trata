<?php
require_once (dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/configGlobal.php");
$fila=6;
$filaaux=0;
$prov='';
$provaux='';
$fecha='';
$periodo='';
//and af.id_estado=1
$where="";
$where2="";
if (isset($_GET['fechaini'])&&isset($_GET['fechafin'])){
    $where .=" and a.rse_fecha_fin between '{$_GET['fechaini']}' and '{$_GET['fechafin']}' ";
    $where2 .=" and a.rse_fecha_fin between '{$_GET['fechaini']}' and '{$_GET['fechafin']}' ";
    $periodo='del '.FechaFormateada2(strtotime($_GET['fechaini'])).' al '.FechaFormateada2(strtotime($_GET['fechafin']));
}

if (isset($_GET['resp'])){
    $where .= " and a.per_codigo_responsable={$_GET['resp']} ";
    $where2 .= " and e.per_codigo_corresponsable={$_GET['resp']} ";
}

/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2011 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2011 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.7.6, 2011-02-27
 */


/** Error reporting */
error_reporting(E_ALL);

date_default_timezone_set('Europe/London');

/** PHPExcel */

require_once (dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/src/lib/PHPExcel_1.8.0/Classes/PHPExcel.php');
//include (dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/includes/conexion.php");






// Create new PHPExcel object
//echo date('H:i:s') . " Create new PHPExcel object\n";
$objPHPExcel = new PHPExcel();

// Set properties
//echo date('H:i:s') . " Set properties\n";
$objPHPExcel->getProperties()->setCreator("MDG-DDITI")
							 ->setLastModifiedBy("MDG-DDITI")
							 ->setTitle("REPORTE DE ACTIVIDADES")
							 ->setSubject("REPORTE DE ACTIVIDADES")
							 ->setDescription("REPORTE DE ACTIVIDADES DEL SISTEMA DE SEGUIMIENTO")
							 ->setKeywords("reporte actividades seguimiento")
							 ->setCategory("Reporte");
							 
							 
$objPHPExcel->setActiveSheetIndex(0);

// estilos para cabecera de la tabla
//echo date('H:i:s') . " Set style for header row using alternative method\n";


$styleThinLightBlueTitle = array(
			'font'    => array(
				'color'   => array(
					'argb'		=>	'FFFFFFFF'
				),
				'bold'      => true
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			),
			'borders' => array(
				'top'     => array(
 					'style' => PHPExcel_Style_Border::BORDER_THIN
 				)
			),
			'fill' => array(
	 			//'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 			'startcolor' => array(
	 				'argb' => 'FF337ab7'
	 			),
	 			'endcolor'   => array(
	 				'argb' => 'FF337ab7'
	 			)
	 		)
		);

$objPHPExcel->getActiveSheet()->getStyle('A4:J5')->applyFromArray($styleThinLightBlueTitle);


//$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Resumen de albergues por Provincia y Cantón');
$objRichText = new PHPExcel_RichText();
//$objRichText->createText('Resumen de albergues por Provincia y Cantón');
$objPHPExcel->getActiveSheet()->setCellValue('A4', 'REPORTE DE ACTIVIDADES');
$objPHPExcel->getActiveSheet()->mergeCells('A1:J1');
$objPHPExcel->getActiveSheet()->mergeCells('A2:J2');
$objPHPExcel->getActiveSheet()->mergeCells('A3:J3');
$objPHPExcel->getActiveSheet()->mergeCells('A4:J4');
$objPHPExcel->getActiveSheet()->getStyle('A4:J4')->applyFromArray($styleThinLightBlueTitle);

// ESTILOS DE LA CEBECERA
//echo date('H:i:s') . " Set fills\n";
$objPHPExcel->getActiveSheet()->getStyle('A4:J4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A4:J4')->getFill()->getStartColor()->setARGB('FF337ab7');


/*$objPHPExcel->getActiveSheet()->setCellValue('D1', PHPExcel_Shared_Date::PHPToExcel( gmmktime(0,0,0,date('m'),date('d'),date('Y')) ));
$objPHPExcel->getActiveSheet()->getStyle('D1')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_XLSX15);*/
/*$objPHPExcel->getActiveSheet()->setCellValue('E1', '#12566');*/

$objPHPExcel->getActiveSheet()->setCellValue('A5', 'CÓDIGO');
$objPHPExcel->getActiveSheet()->setCellValue('B5', 'NOMBRE');
$objPHPExcel->getActiveSheet()->setCellValue('C5', 'RESPONSABLE');
$objPHPExcel->getActiveSheet()->setCellValue('D5', 'CORRESPONSABLE');
$objPHPExcel->getActiveSheet()->setCellValue('E5', 'FECHA DE TÉRMINO');
$objPHPExcel->getActiveSheet()->setCellValue('F5', 'ESTADO');
$objPHPExcel->getActiveSheet()->setCellValue('G5', 'IMPORTANCIA');
$objPHPExcel->getActiveSheet()->setCellValue('H5', 'AVANCE');
$objPHPExcel->getActiveSheet()->setCellValue('I5', 'DETALLE AVANCE');
$objPHPExcel->getActiveSheet()->setCellValue('J5', 'ÚLTIMA ACTUALIZACIÓN');

/*$objRichText = new PHPExcel_RichText();
$objPayable = $objRichText->createTextRun('POBLACIÓN ACTUAL');
$objPHPExcel->getActiveSheet()->getCell('D4')->setValue($objRichText);
$objPHPExcel->getActiveSheet()->mergeCells('A4:A5');
$objPHPExcel->getActiveSheet()->mergeCells('B4:B5');
$objPHPExcel->getActiveSheet()->mergeCells('C4:C5');
$objPHPExcel->getActiveSheet()->mergeCells('D4:E4');*/


$styleThinLightBlue = array(
			'font'    => array(
				'color'   => array(
					'argb'		=>	'FFFFFFFF'
				),
				'bold'      => true
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			),
			'borders' => array(
				'top'     => array(
 					'style' => PHPExcel_Style_Border::BORDER_THIN
 				)
			),
			'fill' => array(
	 			//'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 			'startcolor' => array(
	 				'argb' => 'FF5A9AD0'
	 			),
	 			'endcolor'   => array(
	 				'argb' => 'FF5A9AD0'
	 			)
	 		)
);

$styleThinLightBlueCenter = array(
			'font'    => array(
				'color'   => array(
					'argb'		=>	'FFFFFFFF'
				),
				'bold'      => true
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			),
			'borders' => array(
				'top'     => array(
 					'style' => PHPExcel_Style_Border::BORDER_THIN
 				)
			),
			'fill' => array(
	 			//'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 			'startcolor' => array(
	 				'argb' => 'FF5A9AD0'
	 			),
	 			'endcolor'   => array(
	 				'argb' => 'FF5A9AD0'
	 			)
	 		)
);



/*echo date('H:i:s') . " Set cell number formats\n";
$objPHPExcel->getActiveSheet()->getStyle('E4:E13')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED3);*/

// Set column widths
//echo date('H:i:s') . " Set column widths\n";
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(50);
$objPHPExcel->getActiveSheet()->setAutoFilter('A5:J5');

/*echo "SELECT a.rse_codigo,a.rse_nombre,a.per_codigo_responsable,a.rse_fecha_fin,b.ese_nombre,c.ise_nombre,d.ase_nombre
  FROM seguimiento_despacho_entrega.ssd_registro_seguimiento a
  left join seguimiento_despacho_entrega.ssd_estado_seguimiento b on a.ese_codigo=b.ese_codigo
  left join seguimiento_despacho_entrega.ssd_impacto_seguimiento c on a.ise_codigo=c.ise_codigo
  left join seguimiento_despacho_entrega.ssd_avance_seguimiento d on a.ase_codigo=d.ase_codigo
  WHERE a.rse_codigo=a.rse_codigo {$where} order by a.rse_codigo  desc";*/



$rs = $_consulta_sistema->query("SELECT a.rse_codigo,a.rse_nombre,a.per_codigo_responsable,a.rse_fecha_fin,b.ese_nombre,c.ise_nombre,d.ase_nombre
  FROM seguimiento_despacho_entrega.ssd_registro_seguimiento a
  left join seguimiento_despacho_entrega.ssd_estado_seguimiento b on a.ese_codigo=b.ese_codigo
  left join seguimiento_despacho_entrega.ssd_impacto_seguimiento c on a.ise_codigo=c.ise_codigo
  left join seguimiento_despacho_entrega.ssd_avance_seguimiento d on a.ase_codigo=d.ase_codigo
  WHERE a.rse_codigo=a.rse_codigo and b.ese_codigo not in (8) {$where}
  union
  SELECT a.rse_codigo,a.rse_nombre,a.per_codigo_responsable,a.rse_fecha_fin,b.ese_nombre,c.ise_nombre,d.ase_nombre
  FROM seguimiento_despacho_entrega.ssd_registro_seguimiento a
  left join seguimiento_despacho_entrega.ssd_estado_seguimiento b on a.ese_codigo=b.ese_codigo
  left join seguimiento_despacho_entrega.ssd_impacto_seguimiento c on a.ise_codigo=c.ise_codigo
  left join seguimiento_despacho_entrega.ssd_avance_seguimiento d on a.ase_codigo=d.ase_codigo
  left join seguimiento_despacho_entrega.ssd_corresponsable_seguimiento e on e.rse_codigo=a.rse_codigo
  WHERE a.rse_codigo=a.rse_codigo and b.ese_codigo not in (8) {$where2}
  order by rse_codigo  desc");

for($i=0;$i<count($rs);$i++){

    $objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $rs[$i]['rse_codigo']);
    $objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $rs[$i]['rse_nombre']);
    if($rs[$i]['per_codigo_responsable']!=""){
        $rs2 = $_consulta_sistema->query("select (per_apellidos::text||' '||per_nombres::text)as nombres from aplicativo_web.aaw_persona where per_codigo={$rs[$i]['per_codigo_responsable']} limit 1");
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $rs2[0][0]);
    }else{
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, "");
    }
    $varcores='';
    $rsco = $_consulta_login->query("select (trim(per_apellidos)||' '||trim(per_nombres))as nombres from seguimiento_despacho_entrega.ssd_corresponsable_seguimiento sc,aplicativo_web.aaw_persona p
                                          where sc.per_codigo_corresponsable=p.per_codigo and rse_codigo={$rs[$i]['rse_codigo']} order by nombres ");
    for($l=0;$l<count($rsco);$l++){
        $varcores.=$rsco[$l][0];
        if($l<(count($rsco)-1)){
            $varcores.=PHP_EOL;
        }
    }
    $objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, "{$varcores}");
    $objPHPExcel->getActiveSheet()->getStyle('D'.$fila)->getAlignment()->setWrapText(true);
    $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, FechaFormateada2(strtotime($rs[$i]['rse_fecha_fin'])));
    $objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $rs[$i]['ese_nombre']);
    $objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $rs[$i]['ise_nombre']);
    $objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, $rs[$i]['ase_nombre']."%");
    $rs2 = $_consulta_login->query("select * from seguimiento_despacho_entrega.ssd_avances_registro_seguimiento
                  where rse_codigo={$rs[$i]['rse_codigo']} order by avr_fecha_escrito desc limit 1");
    if(isset($rs2[0][2])){
        $objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, $rs2[0][2]);
        $objPHPExcel->getActiveSheet()->getStyle('I'.$fila)->getAlignment()->setWrapText(true);
    }else{
        $objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, "");
    }
    //sacar el ultimo movimiento
    $rs2 = $_consulta_login->query("select rse_codigo,'Mensaje' as tipo,mrs_mensaje as detalle,mrs_fecha_escrito as fecharegistro,mrs_fecha_revision as fecharevision from seguimiento_despacho_entrega.ssd_mensaje_registro_seguimiento where rse_codigo={$rs[$i]['rse_codigo']}
union
select rse_codigo,'Avance' as tipo,avr_avance as detalle,avr_fecha_escrito as fecharegistro,avr_fecha_revision as fecharevision from seguimiento_despacho_entrega.ssd_avances_registro_seguimiento where rse_codigo={$rs[$i]['rse_codigo']}
union
select rse_codigo,'Archivo' as tipo,arr_nombre as detalle,arr_fecha_cargado as fecharegistro,arr_fecha_revision as fecharevision from seguimiento_despacho_entrega.ssd_archivo_registro_seguimiento where rse_codigo={$rs[$i]['rse_codigo']}
order by fecharegistro desc limit 1");
    $ult='';
    $desc='';
    if(isset($rs2[0][3])){
        $ult=$rs2[0][3];
        $desc="Fecha: ".substr($ult,0,19).PHP_EOL.$rs2[0][1].": ".$rs2[0][2];
    }
    $fecha1=new DateTime($ult);
    $fecha1=$fecha1->format('Y-m-d H:i:s');

    $rs2 = $_consulta_login->query("select rse_codigo,'Mensaje' as tipo,mrs_mensaje as detalle,mrs_fecha_escrito as fecharegistro,mrs_fecha_revision as fecharevision from seguimiento_despacho_entrega.ssd_mensaje_registro_seguimiento where rse_codigo={$rs[$i]['rse_codigo']}
and not mrs_fecha_revision is null
union
select rse_codigo,'Avance' as tipo,avr_avance as detalle,avr_fecha_escrito as fecharegistro,avr_fecha_revision as fecharevision from seguimiento_despacho_entrega.ssd_avances_registro_seguimiento where rse_codigo={$rs[$i]['rse_codigo']}
and not avr_fecha_revision is null
union
select rse_codigo,'Archivo' as tipo,arr_nombre as detalle,arr_fecha_cargado as fecharegistro,arr_fecha_revision as fecharevision from seguimiento_despacho_entrega.ssd_archivo_registro_seguimiento where rse_codigo={$rs[$i]['rse_codigo']}
and not arr_fecha_revision is null
order by fecharevision desc limit 1");
    $ult2='';
    $desc2='';
    if(isset($rs2[0][4])){
        $ult2=$rs2[0][4];
        $desc2="Fecha: ".substr($ult2,0,19).PHP_EOL.$rs2[0][1].": ".$rs2[0][2];
    }
    $fecha2=new DateTime($ult2);
    $fecha2=$fecha2->format('Y-m-d H:i:s');
    $descripcion='';
    if ($fecha1>$fecha2){
        $objPHPExcel->getActiveSheet()->setCellValue('J'.$fila, $desc);
    }elseif($fecha1<$fecha2){
        $objPHPExcel->getActiveSheet()->setCellValue('J'.$fila, $desc2);
    }else{
        if($desc==$desc2){
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$fila, $desc);
        }else{
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$fila, $desc.PHP_EOL.$desc2);
        }

    }

    $objPHPExcel->getActiveSheet()->getStyle('J'.$fila)->getAlignment()->setWrapText(true);





    //$objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':E'.$fila)->applyFromArray($styleThinLightBlueCenter);
    $fila=$fila+1;
}

$objPHPExcel->getActiveSheet()->getStyle('A6:I'.$fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$date=new DateTime();
$fecha=$date->format('d-m-Y');
$filaaux=$fila-1;
/*$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, 'TOTAL');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, '=SUM(B6:B'.$filaaux.')');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, '=SUM(C6:C'.$filaaux.')');
$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, '=SUM(D6:D'.$filaaux.')');
$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, '=SUM(E6:E'.$filaaux.')');
$objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':E'.$fila)->applyFromArray($styleThinLightBlueTitle);*/


/*$objPHPExcel->getActiveSheet()->setCellValue('D13', 'Total incl.:');
$objPHPExcel->getActiveSheet()->setCellValue('E13', '=E11+E12');*/

/* Add comment
echo date('H:i:s') . " Add comments\n";

$objPHPExcel->getActiveSheet()->getComment('E11')->setAuthor('PHPExcel');
$objCommentRichText = $objPHPExcel->getActiveSheet()->getComment('E11')->getText()->createTextRun('PHPExcel:');
$objCommentRichText->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getComment('E11')->getText()->createTextRun("\r\n");
$objPHPExcel->getActiveSheet()->getComment('E11')->getText()->createTextRun('Total amount on the current invoice, excluding VAT.');

$objPHPExcel->getActiveSheet()->getComment('E12')->setAuthor('PHPExcel');
$objCommentRichText = $objPHPExcel->getActiveSheet()->getComment('E12')->getText()->createTextRun('PHPExcel:');
$objCommentRichText->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getComment('E12')->getText()->createTextRun("\r\n");
$objPHPExcel->getActiveSheet()->getComment('E12')->getText()->createTextRun('Total amount of VAT on the current invoice.');

$objPHPExcel->getActiveSheet()->getComment('E13')->setAuthor('PHPExcel');
$objCommentRichText = $objPHPExcel->getActiveSheet()->getComment('E13')->getText()->createTextRun('PHPExcel:');
$objCommentRichText->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getComment('E13')->getText()->createTextRun("\r\n");
$objPHPExcel->getActiveSheet()->getComment('E13')->getText()->createTextRun('Total amount on the current invoice, including VAT.');
$objPHPExcel->getActiveSheet()->getComment('E13')->setWidth('100pt');
$objPHPExcel->getActiveSheet()->getComment('E13')->setHeight('100pt');
$objPHPExcel->getActiveSheet()->getComment('E13')->setMarginLeft('150pt');
$objPHPExcel->getActiveSheet()->getComment('E13')->getFillColor()->setRGB('EEEEEE');*/


/* Add rich-text string
echo date('H:i:s') . " Add rich-text string\n";
$objRichText = new PHPExcel_RichText();
$objRichText->createText('This invoice is ');

$objPayable = $objRichText->createTextRun('payable within thirty days after the end of the month');
$objPayable->getFont()->setBold(true);
$objPayable->getFont()->setItalic(true);
$objPayable->getFont()->setColor( new PHPExcel_Style_Color( PHPExcel_Style_Color::COLOR_DARKGREEN ) );

$objRichText->createText(', unless specified otherwise on the invoice.');

$objPHPExcel->getActiveSheet()->getCell('A18')->setValue($objRichText);

// Merge cells
echo date('H:i:s') . " Merge cells\n";
$objPHPExcel->getActiveSheet()->mergeCells('A18:E22');
$objPHPExcel->getActiveSheet()->mergeCells('A28:B28');		// Just to test...
$objPHPExcel->getActiveSheet()->unmergeCells('A28:B28');	// Just to test...

 Protect cells
echo date('H:i:s') . " Protect cells\n";
$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);	// Needs to be set to true in order to enable any worksheet protection!
$objPHPExcel->getActiveSheet()->protectCells('A3:E13', 'PHPExcel');*/

// Set cell number formats



// Set fonts
//echo date('H:i:s') . " Set fonts\n";
/*$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setName('Candara');
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(20);
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);

$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);

$objPHPExcel->getActiveSheet()->getStyle('D13')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('E13')->getFont()->setBold(true);*/

/*// Set alignments
echo date('H:i:s') . " Set alignments\n";
$objPHPExcel->getActiveSheet()->getStyle('D11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('D12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('D13')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

$objPHPExcel->getActiveSheet()->getStyle('A18')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
$objPHPExcel->getActiveSheet()->getStyle('A18')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$objPHPExcel->getActiveSheet()->getStyle('B5')->getAlignment()->setShrinkToFit(true);*/

// Set thin black border outline around column
//echo date('H:i:s') . " Set thin black border outline around column\n";
$styleThinBlackBorderOutline = array(
	'borders' => array(
		'outline' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('argb' => 'FF000000'),
		),
	),
);
$objPHPExcel->getActiveSheet()->getStyle('A4:J5')->applyFromArray($styleThinBlackBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle('A4:J'.$filaaux)->applyFromArray($styleThinBlackBorderOutline);
//$objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':G'.$fila)->applyFromArray($styleThinBlackBorderOutline);


/*// Set thick brown border outline around "Total"
echo date('H:i:s') . " Set thick brown border outline around Total\n";
$styleThickBrownBorderOutline = array(
	'borders' => array(
		'outline' => array(
			'style' => PHPExcel_Style_Border::BORDER_THICK,
			'color' => array('argb' => '00000000'),
		),
	),
);
$objPHPExcel->getActiveSheet()->getStyle('A4:E5')->applyFromArray($styleThickBrownBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle('A4:E'.$fila)->applyFromArray($styleThickBrownBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':E'.$fila)->applyFromArray($styleThickBrownBorderOutline);*/





/*$objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray(
		array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			),
			'borders' => array(
				'left'     => array(
 					'style' => PHPExcel_Style_Border::BORDER_THIN
 				)
			)
		)
);

$objPHPExcel->getActiveSheet()->getStyle('B3')->applyFromArray(
		array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			)
		)
);

$objPHPExcel->getActiveSheet()->getStyle('E3')->applyFromArray(
		array(
			'borders' => array(
				'right'     => array(
 					'style' => PHPExcel_Style_Border::BORDER_THIN
 				)
			)
		)
);

// Unprotect a cell
echo date('H:i:s') . " Unprotect a cell\n";
$objPHPExcel->getActiveSheet()->getStyle('B1')->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

// Add a hyperlink to the sheet
echo date('H:i:s') . " Add a hyperlink to the sheet\n";
$objPHPExcel->getActiveSheet()->setCellValue('E26', 'www.phpexcel.net');
$objPHPExcel->getActiveSheet()->getCell('E26')->getHyperlink()->setUrl('http://www.phpexcel.net');
$objPHPExcel->getActiveSheet()->getCell('E26')->getHyperlink()->setTooltip('Navigate to website');
$objPHPExcel->getActiveSheet()->getStyle('E26')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

$objPHPExcel->getActiveSheet()->setCellValue('E27', 'Terms and conditions');
$objPHPExcel->getActiveSheet()->getCell('E27')->getHyperlink()->setUrl("sheet://'Terms and conditions'!A1");
$objPHPExcel->getActiveSheet()->getCell('E27')->getHyperlink()->setTooltip('Review terms and conditions');
$objPHPExcel->getActiveSheet()->getStyle('E27')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

// Add a drawing to the worksheet
echo date('H:i:s') . " Add a drawing to the worksheet\n";
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo');
$objDrawing->setDescription('Logo');
$objDrawing->setPath('../images/mics2.png');
$objDrawing->setHeight(36);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());*/

// Add a drawing to the worksheet
//echo date('H:i:s') . " Add a drawing to the worksheet\n";
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo');
$objDrawing->setDescription('Logo');
$objDrawing->setPath(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/admin/images/mdg1.png');
$objDrawing->setCoordinates('A1');
$objDrawing->setOffsetX(10);
$objDrawing->setRotation(0);
$objDrawing->setHeight(45);
/*$objDrawing->getShadow()->setVisible(true);
$objDrawing->getShadow()->setDirection(45);*/
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

/*// Add a drawing to the worksheet
echo date('H:i:s') . " Add a drawing to the worksheet\n";
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('PHPExcel logo');
$objDrawing->setDescription('PHPExcel logo');
$objDrawing->setPath('../images/mics2.png');
$objDrawing->setHeight(36);
$objDrawing->setCoordinates('D24');
$objDrawing->setOffsetX(10);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

// Play around with inserting and removing rows and columns
echo date('H:i:s') . " Play around with inserting and removing rows and columns\n";
$objPHPExcel->getActiveSheet()->insertNewRowBefore(6, 10);
$objPHPExcel->getActiveSheet()->removeRow(6, 10);
$objPHPExcel->getActiveSheet()->insertNewColumnBefore('E', 5);
$objPHPExcel->getActiveSheet()->removeColumn('E', 5);*/

//poner fuente
if(strlen($periodo)>0){
    $fila=$fila+1;
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, 'Período:');
    $objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $periodo);
}

$fila=$fila+1;
$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, 'Fecha de Corte:');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, FechaFormateada2(strtotime($fecha)));


// Set header and footer. When no different headers for odd/even are used, odd header is assumed.
//echo date('H:i:s') . " Set header/footer\n";
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&BInvoice&RPrinted on &D');
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

// Set page orientation and size
//echo date('H:i:s') . " Set page orientation and size\n";
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

// Rename sheet
//echo date('H:i:s') . " Rename sheet\n";
$objPHPExcel->getActiveSheet()->setTitle('REPORTE');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

//require_once '../Classes/PHPExcel/IOFactory.php';
require_once (dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/src/lib/PHPExcel_1.8.0/Classes/PHPExcel/IOFactory.php');

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="REPORTE DE SEGUIMIENTO '.$fecha.'.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
