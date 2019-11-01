<?php

 	session_start();
	if(!isset($_SESSION['usuarioId'])){
        session_destroy();
        header("Location: ../index.php");
    }

 	function agregar($nombre, $tipo){
 		require_once('conn.php');
 		$qry=$pdo->prepare('INSERT INTO carreras (carreras, tipo) VALUES (?, ?);');
 		$qry->execute(array($nombre, $tipo));
		$rows = $qry -> rowCount();
        return $rows;
	}

    function eliminar($id){
 		require_once('conn.php');
 		$qry=$pdo->prepare('DELETE FROM carreras WHERE id_carreras=?;');
 		$qry->execute(array($id));
		$rows = $qry -> rowCount();
        return $rows;
	}

	if(isset($_POST['action']) && !empty($_POST['action'])) {
	    $action = $_POST['action'];
	    switch($action) {
	        case 'agregar' :
	        	echo agregar($_POST['nomCar'], $_POST['tipoCar']);
        		break;
            case 'eliminar' : 
	        	echo eliminar($_POST['id_carreras']);
        		break;
	    }
	}else{
		header('Location: ../profile');
	}
?>
