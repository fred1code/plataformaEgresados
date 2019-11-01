<?php
session_start();
if(!isset($_SESSION['egre_id'])){
    header("Location: ../index");
    session_destroy();
}
require_once('conn.php');
if (isset($_POST["txt"])) {
    if (file_exists($_FILES['image']['tmp_name']) || is_uploaded_file($_FILES['image']['tmp_name'])) {
        if ($_FILES["image"]["type"] == "image/jpg" || $_FILES["image"]["type"] == "image/jpeg" || $_FILES["image"]["type"] == "image/png") {
            try {
                $img = base64_encode(stripslashes(addslashes(file_get_contents($_FILES['image']['tmp_name']))));
                $vali2 = $pdo->prepare('UPDATE egresado SET img = ? WHERE egre_Id = ?');
                $vali2->execute(array($img,$_SESSION['egre_id']));
                header('Location: ../profile?message=Se+actualizo+la+información+con+exito');
            } catch (Exception $e) {
                header('Location: ../profile?message=No+se+pudo+guardar+la+informacion,+vuelve+a+intentarlo.'); 
            }
        }else{
            header('Location: ../profile?message=Formato+de+imagen+incorrecto.'); 
        }
    }else{
        header('Location: ../profile?message=No+se+cargo+ninguna+imagen.');;     
    }
}else{
    header('Location: ../profile');
}
?>