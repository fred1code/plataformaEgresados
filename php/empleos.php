<?php
session_start();
if (!isset($_SESSION['egre_id'])) {
    header("Location: ../index");
    session_destroy();
}
function getEmpleo($id)
{
    require_once('conn.php');
    $qry = $pdo->prepare('SELECT * FROM empleo WHERE empleoId=?');
    $qry->execute(array($id));
    $result = $qry->fetch(PDO::FETCH_ASSOC);
    return json_encode($result);
}

if (isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'getEmpleo' :
            header('Content-Type: application/json');
            echo getEmpleo($_POST['empleoId']);
            break;
    }
} else {
    header('Location: ../profile');
}
?>