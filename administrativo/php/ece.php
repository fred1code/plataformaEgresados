<?php
require_once 'Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();
require_once('conn.php');
$objPHPExcel->getProperties()
    ->setCreator("hjk j")
    ->setLastModifiedBy("j")
    ->setTitle("Excel en PHP")
    ->setSubject("Documento de prueba")
    ->setDescription("Documento generado con PHPExcel")
    ->setKeywords("excel phpexcel php")
    ->setCategory("Ejemplos");
$objPHPExcel->getProperties()
    ->setCreator("hj hj")
    ->setLastModifiedBy("hj")
    ->setTitle("Reporte Egresados")
    ->setSubject("Documento de prueba")
    ->setDescription("Documento generado con PHPExcel")
    ->setKeywords("excel phpexcel php")
    ->setCategory("Ejemplos");
 $objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle('Hoja 1');
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);//..
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);//
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);//
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);//
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);//
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);//
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);//
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(40);//
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);//
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);//
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(35);
$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(15);

// Agregar en celda A1 valor string
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Codigo');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Nombre');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Fecha Nacimiento');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Sexo');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Domicilio Origen');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Ciudad Origen');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'CP Origen');
$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Estado Origen');
$objPHPExcel->getActiveSheet()->setCellValue('I1', 'Pais Origen');
$objPHPExcel->getActiveSheet()->setCellValue('J1', 'Domicilio Actual');
$objPHPExcel->getActiveSheet()->setCellValue('K1', 'CP Actual');
$objPHPExcel->getActiveSheet()->setCellValue('L1', 'Estado Origen');
$objPHPExcel->getActiveSheet()->setCellValue('M1', 'Pais Origen');
$objPHPExcel->getActiveSheet()->setCellValue('N1', 'Domicilio Actual');
$objPHPExcel->getActiveSheet()->setCellValue('O1', 'Ciudad Actual');
$objPHPExcel->getActiveSheet()->setCellValue('P1', 'CP Actual');
$objPHPExcel->getActiveSheet()->setCellValue('Q1', 'Estado Actual');
$objPHPExcel->getActiveSheet()->setCellValue('R1', 'Pais Actual');
$objPHPExcel->getActiveSheet()->setCellValue('S1', 'Telefono');
$objPHPExcel->getActiveSheet()->setCellValue('T1', 'Email');
$objPHPExcel->getActiveSheet()->setCellValue('U1', 'Carrera');
$objPHPExcel->getActiveSheet()->setCellValue('V1', 'Año Ingreso');
$objPHPExcel->getActiveSheet()->setCellValue('W1', 'Ciclo Ingreso');
$objPHPExcel->getActiveSheet()->setCellValue('X1', 'Año Egreso');
$objPHPExcel->getActiveSheet()->setCellValue('Y1', 'Ciclo Egreso');
$objPHPExcel->getActiveSheet()->setCellValue('Z1', 'Estatus de Egreso');

$boldArray = array('font' => array('bold' => true, ), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));

$objPHPExcel->getActiveSheet()->getStyle('A1:Z1')->applyFromArray($boldArray);


$consulta = "SELECT * FROM egresado order by nombre";
$sql = $pdo->prepare($consulta);
$sql->execute(array());
$contador =2;

while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$contador, $row['codigo']);
    $objPHPExcel->getActiveSheet()->setCellValue('B' . $contador, $row['nombre']);
    $objPHPExcel->getActiveSheet()->setCellValue('C' . $contador, $row['fecha_nacimiento']);
    $objPHPExcel->getActiveSheet()->setCellValue('D' . $contador, $row['sexo']);
    $objPHPExcel->getActiveSheet()->setCellValue('E' . $contador, $row['domicilioOrigen']);
    $objPHPExcel->getActiveSheet()->setCellValue('F' . $contador, $row['ciudadOrigen']);
    $objPHPExcel->getActiveSheet()->setCellValue('G' . $contador, $row['cpOrigen']);
    $objPHPExcel->getActiveSheet()->setCellValue('H' . $contador, $row['estadoOrigen']);
    $objPHPExcel->getActiveSheet()->setCellValue('I' . $contador, $row['paisOrigen']);
    $objPHPExcel->getActiveSheet()->setCellValue('J' . $contador, $row['domicilioActual']);
    $objPHPExcel->getActiveSheet()->setCellValue('K' . $contador, $row['cpActual']);
    $objPHPExcel->getActiveSheet()->setCellValue('L' . $contador, $row['estadoOrigen']);
    $objPHPExcel->getActiveSheet()->setCellValue('M' . $contador, $row['paisOrigen']);
    $objPHPExcel->getActiveSheet()->setCellValue('N' . $contador, $row['domicilioActual']);
    $objPHPExcel->getActiveSheet()->setCellValue('O' . $contador, $row['ciudadActual']);
    $objPHPExcel->getActiveSheet()->setCellValue('P' . $contador, $row['cpActual']);
    $objPHPExcel->getActiveSheet()->setCellValue('Q' . $contador, $row['estadoActual']);
    $objPHPExcel->getActiveSheet()->setCellValue('R' . $contador, $row['paisActual']);
    $objPHPExcel->getActiveSheet()->setCellValue('S' . $contador, $row['telefono']);
    $objPHPExcel->getActiveSheet()->setCellValue('T' . $contador, $row['email']);
    $objPHPExcel->getActiveSheet()->setCellValue('U' . $contador, $row['carrera']);
    $objPHPExcel->getActiveSheet()->setCellValue('V' . $contador, $row['anioIngreso']);
    $objPHPExcel->getActiveSheet()->setCellValue('W' . $contador, $row['cicloIngreso']);
    $objPHPExcel->getActiveSheet()->setCellValue('X' . $contador, $row['anioEgreso']);
    $objPHPExcel->getActiveSheet()->setCellValue('Y' . $contador, $row['cicloEgreso']);
    $objPHPExcel->getActiveSheet()->setCellValue('Z' . $contador, $row['estatusEgreso']);
    
    
    $contador++;
}



/* 
$rango = "A2:Z".$contador;
$styleArray = array(
    'font' => array('name' => 'Arial', 'size' => 10),
    'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => 'FFF')))
);
$objPHPExcel->getActiveSheet()->getStyle($rango)->applyFromArray($styleArray); */





    header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Reporte Egresados.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');