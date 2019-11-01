<?php
require_once 'Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();
require_once('conn.php');


$radio = $_POST['radio'];
$carrera = $_POST['carrera'];
$sexo = $_POST['sexo2'];

if ($sexo != 'Ambos' and $carrera == 'Todas') {
    $consulta = "SELECT * FROM egresado WHERE sexo = ? order by nombre  ;";
    $sql = $pdo->prepare($consulta);
    $sql->execute(array($sexo));
} else if ($carrera != 'Todas' and $sexo == 'Ambos') {
    $consulta = "SELECT * FROM egresado WHERE  carrera = ? order by nombre ;";
    $sql = $pdo->prepare($consulta);
    $sql->execute(array($carrera));
} else if ($sexo == 'Ambos' and $carrera == 'Todas') {
    $consulta = "SELECT * FROM egresado order by nombre";
    $sql = $pdo->prepare($consulta);
    $sql->execute(array());
} else if ($carrera != 'Todas' and $sexo != 'Ambos') {
    $consulta = "SELECT * FROM egresado WHERE sexo = ?  AND carrera = ? order by nombre;";
    $sql = $pdo->prepare($consulta);
    $sql->execute(array($sexo, $carrera));
}


if ($radio == 'excel') {

    $objPHPExcel->getProperties()
        ->setCreator("egre")
        ->setLastModifiedBy("sad")
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
    $contador = 2;
 while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
 $newDate = date("d/m/Y", strtotime($row['fecha_nacimiento']));

 if($row['trabaja']==1){
            $row['trabaja'] = 'SI'; 
 }
 else{
            $row['trabaja'] = 'NO';
 }
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $contador, $row['codigo']);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $contador, $row['nombre']);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $contador, $newDate);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $contador, $row['sexo']);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $contador, $row['domicilioOrigen']);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $contador, $row['ciudadOrigen']);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $contador, $row['cpOrigen']);
        $objPHPExcel->getActiveSheet()->setCellValue('H' . $contador, $row['estadoOrigen']);
        $objPHPExcel->getActiveSheet()->setCellValue('I' . $contador, $row['paisOrigen']);
        $objPHPExcel->getActiveSheet()->setCellValue('J' . $contador, $row['domicilioActual']);
        $objPHPExcel->getActiveSheet()->setCellValue('K' . $contador, $row['ciudadActual']);
        $objPHPExcel->getActiveSheet()->setCellValue('L' . $contador, $row['cpActual']);
        $objPHPExcel->getActiveSheet()->setCellValue('M' . $contador, $row['estadoActual']);
        $objPHPExcel->getActiveSheet()->setCellValue('N' . $contador, $row['paisActual']);
        $objPHPExcel->getActiveSheet()->setCellValue('O' . $contador, $row['telefono']);
        $objPHPExcel->getActiveSheet()->setCellValue('P' . $contador, $row['email']);
        $objPHPExcel->getActiveSheet()->setCellValue('Q' . $contador, $row['carrera']);
        $objPHPExcel->getActiveSheet()->setCellValue('R' . $contador, $row['anioIngreso']);
        $objPHPExcel->getActiveSheet()->setCellValue('S' . $contador, $row['cicloIngreso']);
        $objPHPExcel->getActiveSheet()->setCellValue('T' . $contador, $row['anioEgreso']);
        $objPHPExcel->getActiveSheet()->setCellValue('U' . $contador, $row['cicloEgreso']);
        $objPHPExcel->getActiveSheet()->setCellValue('V' . $contador, $row['estatusEgreso']);
        $objPHPExcel->getActiveSheet()->setCellValue('W' . $contador, $row['trabaja']);
      


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
}



else {

    include 'plantilla.php';
    $pdf = new PDF('L', 'mm', 'A4');
    $pdf->AliasNbPages();
    $pdf->AddPage();

    $pdf->SetFillColor(232, 232, 232);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(18, 6, 'Codigo', 1, 0, 'C', 1);
    $pdf->Cell(61, 6, 'Nombre', 1, 0, 'C', 1);
    $pdf->Cell(16, 6, 'Sexo', 1, 0, 'C', 1);
    $pdf->Cell(15, 6, 'CP Origen', 1, 0, 'C', 1);
    $pdf->Cell(15, 6, 'CP Actual', 1, 0, 'C', 1);
    $pdf->Cell(25, 6, 'Estado Actual', 1, 0, 'C', 1);
    $pdf->Cell(17, 6, 'Pais Actual', 1, 0, 'C', 1);
    $pdf->Cell(20, 6, 'Telefono', 1, 0, 'C', 1);
    $pdf->Cell(50, 6, 'Carrera', 1, 0, 'C', 1);
    $pdf->Cell(20, 6, utf8_decode('Año Egreso'), 1, 0, 'C', 1);
    $pdf->Cell(22, 6, 'Estatus Egreso', 1, 1, 'C', 1);
    $pdf->SetFont('Arial', '', 8);

    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        
        $pdf->Cell(18, 6, utf8_decode($row['codigo']), 1, 0, 'l');
        $pdf->Cell(61, 6, utf8_decode($row['nombre']), 1, 0, 'l');
        $pdf->Cell(16, 6, utf8_decode($row['sexo']), 1, 0, 'l');
        $pdf->Cell(15, 6, utf8_decode($row['cpOrigen']), 1, 0, 'l');
        $pdf->Cell(15, 6, utf8_decode($row['cpActual']), 1, 0, 'l');
        $pdf->Cell(25, 6, utf8_decode($row['estadoActual']), 1, 0, 'l');
        $pdf->Cell(17, 6, utf8_decode($row['paisActual']), 1, 0, 'l');
        $pdf->Cell(20, 6, utf8_decode($row['telefono']), 1, 0, 'l');
        $pdf->Cell(50, 6, utf8_decode($row['carrera']), 1, 0, 'l');
        $pdf->Cell(20, 6, utf8_decode($row['anioEgreso']), 1, 0, 'l');
        $pdf->Cell(22, 6, utf8_decode($row['estatusEgreso']), 1, 1, 'l');
    }
    $pdf->Output();
} 