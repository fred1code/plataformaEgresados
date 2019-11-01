<?php
session_start();
if(!isset($_SESSION['egre_id'])){
    header("Location: ../index");
    session_destroy();
}

require_once('conn.php');

if(isset($_POST['usuario'])){
    
    if($_POST['usuario'] == $_SESSION['usuario']){
        header('Location: ../profile?message=No+sé+encontraron+cambios+en+el+usuario.');
    }else{
        $qry = $pdo->prepare('SELECT usuario FROM egresado WHERE usuario = ?;');
        $qry -> execute(array($_POST['usuario']));
        $egresado = $qry->fetch(PDO::FETCH_ASSOC);
        $rows = $qry -> rowCount();
        if($rows == 0){
            $qry = $pdo->prepare('UPDATE egresado SET usuario =? WHERE egre_Id =?;');
            $qry -> execute(array($_POST['usuario'], $_SESSION['egre_id']));
            header('Location: ../profile?message=Nombre+de+usuario+actualizado+correctamente.');
        }else{
            header('Location: ../profile?message=El+nombre+de+usuario+ya+existe.');
        }
    }
}else{
    header('Location: ../profile');
}

?>
