<?php
session_start();
if(!isset($_SESSION['egre_id'])){
    header("Location: ../index");
    session_destroy();
}

require_once('conn.php');

if(isset($_POST['nombre'])){
    try {
        $qry = $pdo->prepare('UPDATE egresado SET nombre =?, domicilioOrigen =?, ciudadOrigen =?, cpOrigen =?, estadoOrigen =?, paisOrigen =?, domicilioActual =?, ciudadActual =?,cpActual =?,  estadoActual =?,  paisActual =?, fecha_nacimiento =?, sexo =?, telefono =? WHERE egre_Id = ?;'); 
        $qry->execute(array(ucwords($_POST['nombre']), $_POST["dOrigen"], $_POST['cOrigen'], $_POST['cpOrigen'], $_POST['eOrigen'], $_POST['pOrigen'], $_POST["dActual"], $_POST['cActual'], $_POST['cpActual'], $_POST['eActual'], $_POST['pActual'], $_POST['fechaN'], $_POST['sexo'], $_POST['tel'], $_SESSION['egre_id']));
        header('Location: ../profile?message=Se+actualizo+la+información+con+exito');
    } catch (Exception $e) {
        header('Location: ../profile?message=No+se+pudo+guardar+la+informacion,+vuelve+a+intentarlo.');
    }
    
}else{
    header('Location: ../profile');
}

?>