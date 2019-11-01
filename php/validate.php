<?php
session_start();
session_destroy();
require_once('conn.php');
if($_GET){
    $qry = $pdo->prepare('SELECT validado FROM egresado WHERE num_conf = ?;');
    $qry->execute(array($_GET['codigo']));
    $count = $qry -> rowCount();
    if($count > 0){
        $result = $qry->fetch(PDO::FETCH_ASSOC);
        if($result['validado'] == 0){
            $qry = $pdo->prepare('UPDATE egresado SET validado=?, num_conf = ? WHERE num_conf = ?;');
            $qry->execute(array('1', md5($_GET['codigo']), $_GET['codigo']));
            header('Location: ../index?message=Usuario+validado+correctamente.');
        }else{
            header('Location: ../index?message=El+usuario+ya+se+encuentra+validado.');
        }
    }else{
        header('Location: ../index?message=El+codigo+ha+expirado,+o+es+invalido.');
    }
}else{
    header('Location: ../index');
}
?>