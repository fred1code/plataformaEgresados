<?php


$buscar = $_POST['data'];

//if (!empty($buscar)) {
    buscar($buscar);
//}

function buscar($b)
{
    require_once('conn.php');
$consulta = "SELECT * FROM egresado   ";
$sql = $pdo->prepare($consulta);
$sql->execute();
    $result = $qry->fetch(PDO::FETCH_ASSOC);

return json_encode($result);
}

