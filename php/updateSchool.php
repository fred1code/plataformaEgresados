<?php
session_start();
if(!isset($_SESSION['egre_id'])){
    header("Location: ../index");
    session_destroy();
}

require_once('conn.php');

if(isset($_POST["cod"])){
    try {
        $statement_update = $pdo->prepare('UPDATE egresado SET codigo =?, carrera =?, anioIngreso =?, cicloIngreso =?, anioEgreso =?, cicloEgreso =?, estatusEgreso =? WHERE egre_Id =?;'); 
        $statement_update->execute(array($_POST["cod"],$_POST["carrera"],$_POST["anioI"],$_POST["cicloI"], $_POST["anioE"],$_POST["cicloE"],$_POST["estatus"], $_SESSION['egre_id']));
        header('Location: ../profile?message=Se+actualizo+la+información+con+exito');
    } catch (Exception $e) {
        header('Location: ../profile?message=No+se+pudo+guardar+la+informacion,+vuelve+a+intentarlo.'); 
    }
}else{
    header('Location: ../profile');
}
?>