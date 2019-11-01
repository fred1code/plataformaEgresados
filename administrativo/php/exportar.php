<?php
$_FILES['excelD']['tmp_name'];
$tipo = $_FILES['excelD']['type'];
$destino = "bak_" . $archivo; //lugar donde se copiara el archivo




if (copy($_FILES['excel']['tmp_name'], $destino)) //si dese copiar la variable excel (archivo).nombreTemporal a destino (bak_.archivo) (si se ha dejado copiar)
{
    echo "Archivo Cargado Con Exito";
} else {
    echo "Error Al Cargar el Archivo";
}
 
////////////////////////////////////////////////////////
if (file_exists("bak_" . $archivo)) //validacion para saber si el archivo ya existe previamente
{
/*INVOCACION DE CLASES Y CONEXION A BASE DE DATOS*/
    /** Invocacion de Clases necesarias */
    require_once('Classes/PHPExcel.php');
    require_once('Classes/PHPExcel/Reader/Excel2007.php');
//DATOS DE CONEXION A LA BASE DE DATOS
    require_once('conn.php');
 
// Cargando la hoja de calculo
    $objReader = new PHPExcel_Reader_Excel2007(); //instancio un objeto como PHPExcelReader(objeto de captura de datos de excel)
    $objPHPExcel = $objReader->load("bak_" . $archivo); //carga en objphpExcel por medio de objReader,el nombre del archivo
    $objFecha = new PHPExcel_Shared_Date();
 
// Asignar hoja de excel activa
    $objPHPExcel->setActiveSheetIndex(0); //objPHPExcel tomara la posicion de hoja (en esta caso 0 o 1) con el setActiveSheetIndex(numeroHoja)
 
// Llenamos un arreglo con los datos del archivo xlsx
    $i = 1; //celda inicial en la cual empezara a realizar el barrido de la grilla de excel
    $param = 0;
    $contador = 0;
    while ($param == 0) //mientras el parametro siga en 0 (iniciado antes) que quiere decir que no ha encontrado un NULL entonces siga metiendo datos
    {

        $codigo = $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue();
        $nombre = $objPHPExcel->getActiveSheet()->getCell('B' . $i)->getCalculatedValue();
        $fechaN = $objPHPExcel->getActiveSheet()->getCell('C' . $i)->getCalculatedValue();
        $sexo = $objPHPExcel->getActiveSheet()->getCell('D' . $i)->getCalculatedValue();
        $domicilioO = $objPHPExcel->getActiveSheet()->getCell('F' . $i)->getCalculatedValue();
        $ciudadO = $objPHPExcel->getActiveSheet()->getCell('G' . $i)->getCalculatedValue();
        $cpO = $objPHPExcel->getActiveSheet()->getCell('H' . $i)->getCalculatedValue();
        $estadoO = $objPHPExcel->getActiveSheet()->getCell('I' . $i)->getCalculatedValue();
        $paisO = $objPHPExcel->getActiveSheet()->getCell('J' . $i)->getCalculatedValue();
        $domicilioA = $objPHPExcel->getActiveSheet()->getCell('K' . $i)->getCalculatedValue();
        $cpA = $objPHPExcel->getActiveSheet()->getCell('L' . $i)->getCalculatedValue();
        $nombre = $objPHPExcel->getActiveSheet()->getCell('M' . $i)->getCalculatedValue();
        $nombre = $objPHPExcel->getActiveSheet()->getCell('N' . $i)->getCalculatedValue();
        $nombre = $objPHPExcel->getActiveSheet()->getCell('O' . $i)->getCalculatedValue();
        $nombre = $objPHPExcel->getActiveSheet()->getCell('P' . $i)->getCalculatedValue();
        $num_op = $objPHPExcel->getActiveSheet()->getCell('Q' . $i)->getCalculatedValue();
        $no_rep = $objPHPExcel->getActiveSheet()->getCell('R' . $i)->getCalculatedValue();
        $nombre = $objPHPExcel->getActiveSheet()->getCell('S' . $i)->getCalculatedValue();
        $nombre = $objPHPExcel->getActiveSheet()->getCell('T' . $i)->getCalculatedValue();
        $nombre = $objPHPExcel->getActiveSheet()->getCell('U' . $i)->getCalculatedValue();
        $nombre = $objPHPExcel->getActiveSheet()->getCell('V' . $i)->getCalculatedValue();
        $nombre = $objPHPExcel->getActiveSheet()->getCell('W' . $i)->getCalculatedValue();
        $nombre = $objPHPExcel->getActiveSheet()->getCell('X' . $i)->getCalculatedValue();
        $nombre = $objPHPExcel->getActiveSheet()->getCell('Y' . $i)->getCalculatedValue();
        $nombre = $objPHPExcel->getActiveSheet()->getCell('Z' . $i)->getCalculatedValue();
        $fecha_rep = $objPHPExcel->getActiveSheet()->getCell('E' . $i)->getCalculatedValue();
        $ot = $objPHPExcel->getActiveSheet()->getCell('F' . $i)->getCalculatedValue();
        $fecha_pago = $objPHPExcel->getActiveSheet()->getCell('G' . $i)->getCalculatedValue();
        $bfact = $objPHPExcel->getActiveSheet()->getCell('H' . $i)->getCalculatedValue();
        $id_notaria = $objPHPExcel->getActiveSheet()->getCell('I' . $i)->getCalculatedValue();
        $valor = $objPHPExcel->getActiveSheet()->getCell('J' . $i)->getCalculatedValue();
        $pagada = $objPHPExcel->getActiveSheet()->getCell('K' . $i)->getCalculatedValue();
        $fecha = $objPHPExcel->getActiveSheet()->getCell('L' . $i)->getCalculatedValue();

        $c = ("insert into notaria2 values($i,'$nombre','$num_op','$no_rep','$fecha_re p','$ot','$fecha_pago','$bfact','$id_notaria','$va lor','$pagada','$fecha')");
        mysql_query($c);

        if ($objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue() == null) //pregunto que si ha encontrado un valor null en una columna inicie un parametro en 1 que indicaria el fin del ciclo while
        {
            $param = 1; //para detener el ciclo cuando haya encontrado un valor NULL
        }
        $i++;
        $contador = $contador + 1;
    }
    $totalIngresados = $contador - 1; //(porque se se para con un NULL y le esta registrando como que tambien un dato)
    echo "- Total elementos subidos: $totalIngresados ";
} else//si no se ha cargado el bak
{
    echo "Necesitas primero importar el archivo";
}
unlink($destino); //desenlazar a destino el lugar donde salen los datos(archivo)


