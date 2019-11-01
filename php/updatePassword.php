<?php
session_start();
if(!isset($_SESSION['egre_id'])){
    header("Location: ../index");
    session_destroy();
}
require_once('conn.php');
if(isset($_POST['pass'])){
    $pass = $_POST['pass'];
    $newpass = $_POST['newpass'];
    if(password_verify($pass, $_SESSION['pass'])){
        try{
            $pass_cifrado=password_hash($newpass, PASSWORD_DEFAULT);
            $qry = $pdo->prepare('UPDATE egresado SET password =? WHERE egre_Id =?;');        
            $qry->execute(array($pass_cifrado, $_SESSION['egre_id']));
            header('Location: ../profile?message=La+contraseña+se+actualizo+correctamente.');
        }catch (Exception $e){
          header('Location: ../profile?message=No+se+pudo+guardar+la+informacion,+vuelve+a+intentarlo.');
        }
    }else{
        header('Location: ../profile?message=La+contraseña+no+es+correcta.');
    }
}else{
    header('Location: ../profile');
}
?>