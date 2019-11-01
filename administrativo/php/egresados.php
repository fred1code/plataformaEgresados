 <?php

 	session_start();
	if(!isset($_SESSION['usuarioId'])){
        session_destroy();
        header("Location: ../index.php");
    }

 	function getInfo($id){
 		require_once('conn.php');
 		$qry=$pdo->prepare('SELECT * FROM egresado WHERE egre_Id=?');
 		$qry->execute(array($id));
 		$result = $qry->fetch(PDO::FETCH_ASSOC);
		return json_encode($result);
	}

	if(isset($_POST['action']) && !empty($_POST['action'])) {
	    $action = $_POST['action'];
	    switch($action) {
	        case 'getInfo' : 
	        	header('Content-Type: application/json');
	        	echo getInfo($_POST['egreId']);
        		break;
	    }
	}else{
		header('Location: ../profile');
	}
?>