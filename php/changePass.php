<?php
session_start();
if(!isset($_SESSION['egre_id'])){
    header("Location: ../index");
    session_destroy();
}

require_once('conn.php');

if(isset($_POST['pass'])){
    $pass = $_POST['pass'];
    try{
        $pass_cifrado=password_hash($pass, PASSWORD_DEFAULT);
        $qry = $pdo->prepare('UPDATE egresado SET password =?, num_conf =? WHERE egre_Id =?;');       
        $qry->execute(array($pass_cifrado, md5($pass_cifrado), $_SESSION['egre_id']));
        session_destroy();
        header('Location: ../index?message=La+contraseña+se+actualizo+correctamente.');
    }catch (Exception $e){
      header('Location: ../index?message=No+se+pudo+guardar+la+informacion,+vuelve+a+intentarlo.');
    }
}else{
    header('Location: ../index');
}
?>