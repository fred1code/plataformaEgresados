<?php
require_once 'Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();


    $objPHPExcel->getProperties()
        ->setCreator("hjk h")
        ->setLastModifiedBy("iu")
        ->setTitle("Excel en PHP")
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
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(30);//
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);//
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(42);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(35);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(10);
//presta shop
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
$objPHPExcel->getActiveSheet()->setCellValue('K1', 'Ciudad Actual');
$objPHPExcel->getActiveSheet()->setCellValue('L1', 'CP Actual');
$objPHPExcel->getActiveSheet()->setCellValue('M1', 'Estado Actual');
$objPHPExcel->getActiveSheet()->setCellValue('N1', 'Pais Actual');
$objPHPExcel->getActiveSheet()->setCellValue('O1', 'Telefono');
$objPHPExcel->getActiveSheet()->setCellValue('P1', 'Email');
$objPHPExcel->getActiveSheet()->setCellValue('Q1', 'Carrera');
$objPHPExcel->getActiveSheet()->setCellValue('R1', 'Año Ingreso');
$objPHPExcel->getActiveSheet()->setCellValue('S1', 'Ciclo Ingreso');
$objPHPExcel->getActiveSheet()->setCellValue('T1', 'Año Egreso');
$objPHPExcel->getActiveSheet()->setCellValue('U1', 'Ciclo Egreso');
$objPHPExcel->getActiveSheet()->setCellValue('V1', 'Estatus Egreso');
$objPHPExcel->getActiveSheet()->setCellValue('W1', 'Trabaja');
    
  

    $boldArray = array('font' => array('bold' => true, ), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));

    $objPHPExcel->getActiveSheet()->getStyle('A1:Z1')->applyFromArray($boldArray);


    

   





    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Reporte Egresados.xls"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output'); 

