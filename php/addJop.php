<?php

	session_start();
    if(!isset($_SESSION['egre_id'])){
        header("Location: ../index");
        session_destroy();
    }

	require_once('conn.php');

	if (isset($_POST['nombreEmpresa'])) {
        try{
        	$qry = $pdo->prepare('INSERT INTO empleo (nombreEmpresa, puesto, direccion, ciudad, estado, pais, telefono, jefeInmediato, anioInicio, anioFin, egresadoId) VALUES (?,?,?,?,?,?,?,?,?,?,?);');
            $qry->execute(array($_POST['nombreEmpresa'], $_POST['puesto'], $_POST['direccion'], $_POST['ciudad'], $_POST['estado'], $_POST['pais'], $_POST['telefono'], $_POST['jefeInmediato'], $_POST['anioInicio'], $_POST['anioFin'], $_SESSION['egre_id']));
        	if ($qry->rowCount() > 0) {
        		header('Location: ../profile?message=Se+actualizo+la+informacion+con+exito.');
        	}else{
        		header('Location: ../profile?message=Ha+ocurrido+un+error,+vuelve+a+intentarlo.');
        	}
        }catch(Exception $e){
            header('Location: ../profile?message=Ha+ocurrido+un+error,+vuelve+a+intentarlo.');
        }
    }else{
        header('Location: ../profile');
    }
?>