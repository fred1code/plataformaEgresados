<?php

	session_start();
	if(!isset($_SESSION['egre_id'])){
	    header("Location: ../index");
	    session_destroy();
	}

	require_once('conn.php');

	if (isset($_POST['trabaja'])) {
        try{
        	$qry=$pdo->prepare('UPDATE egresado SET trabaja=? WHERE egre_Id=?');
            $qry->execute(array($_POST['trabaja'], $_SESSION['egre_id']));
            header('Location: ../profile?message=Se+actualizo+la+información+con+exito');
        }catch(Exception $e){
            header('Location: ../profile?message=Ha+ocurrido+un+error,+vuelve+a+intentarlo.');
        }
    }else{
        header('Location: ../profile');
    }
?>