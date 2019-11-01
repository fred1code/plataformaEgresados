<?php

 	session_start();
	if(!isset($_SESSION['usuarioId'])){
        session_destroy();
        header("Location: ../index.php");
    }

 	function agregar($nombre, $usuario, $pass, $puesto, $carrera){
        session_start();
        if($_SESSION['puesto']!=0){
            session_destroy();
            header("Location: ../index.php");
        }
        
 		require_once('conn.php');
        $qry=$pdo->prepare('SELECT usuarioId FROM usuario WHERE usuario=?');
        $qry->execute(array($usuario));
        $rows = $qry -> rowCount();
        if($rows > 0){
            return -1;
        }
        
 		$qry=$pdo->prepare('INSERT INTO usuario (nombre, usuario, password, puesto, carrera) VALUES (?, ?, ?, ?, ?);');
 		$qry->execute(array($nombre, $usuario, md5($pass), $puesto, $carrera));
		$rows = $qry -> rowCount();
        return $rows;
	}

    function eliminar($id){
 		require_once('conn.php');
 		$qry=$pdo->prepare('DELETE FROM usuario WHERE usuarioId=?;');
 		$qry->execute(array($id));
		$rows = $qry -> rowCount();
        return $rows;
	}

    function getInfo($id){
 		require_once('conn.php');
 		$qry=$pdo->prepare('SELECT * FROM usuario WHERE usuarioId=?');
 		$qry->execute(array($id));
 		$result = $qry->fetch(PDO::FETCH_ASSOC);
		return json_encode($result);
	}

	if(isset($_POST['action']) && !empty($_POST['action'])) {
	    $action = $_POST['action'];
	    switch($action) {
            case 'getInfo' :
                header('Content-Type: application/json');
	        	echo getInfo($_POST['usuarioId']);
        		break;
	        case 'agregar' :
	        	echo agregar($_POST['nombre'], $_POST['usuario'], $_POST['pass'], $_POST['puesto'], $_POST['carrera']);
        		break;
            case 'eliminar' : 
	        	echo eliminar($_POST['usuarioId']);
        		break;
	    }
	}else{
		header('Location: ../profile');
	}
?>
