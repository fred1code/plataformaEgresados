<?php


function getDatos(){
require_once('conn.php');
$qry = $pdo->prepare('SELECT *FROM egresado');
$qry->execute();
    $result = $qry->fetchAll(PDO::FETCH_ASSOC);
   // $result = $qry->fetch(PDO::FETCH_ASSOC);
    return json_encode($result);


}

header('Content-Type: application/json');
echo getDatos();
















/* foreach ($rows as $row) {

    if ($row['trabaja'] == 1) {
        $row['trabaja'] = "Si";
    } else {
        $row['trabaja'] = "No";
    }
    echo '<tr>' .
        '<td style="display:none">' . $row['egre_Id'] . '</td>' .
        '<td>' . $row['codigo'] . '</td>' .
        '<td>' . $row['nombre'] . '</td>' .

        '<td>' . $row['sexo'] . '</td>' .
        '<td>' . $row['telefono'] . '</td>' .
        '<td>' . $row['email'] . '</td>' .
        '<td>' . $row['carrera'] . '</td>' .


        '<td>' . $row['trabaja'] . '</td>' .

        '</tr>';
} */