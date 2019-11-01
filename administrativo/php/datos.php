<?php

function getDatos($id){
    require_once('conn.php');
    $qry=$pdo->prepare('SELECT * FROM empleo WHERE egresadoId = ?');
    $qry->execute(array($id));
    //$result = $qry->fetch(PDO::FETCH_ASSOC);
    $result = $qry->fetchAll();
   
    return json_encode($result);

   
    
}



if(isset($_POST['action']) && !empty($_POST['action'])) {
   $action = $_POST['action'];
   switch($action) {
       case 'getDatos' : 
           header('Content-Type: application/json');
           echo getDatos($_POST['egre_Id']);
            
           break;
   }
}else{
   header('Location: panel.php');
}



/* require_once('conexion.php');
$qry = $pdo->prepare('SELECT * FROM empleo WHERE egresadoId = 38');
$qry->execute();
$result = $qry->fetchAll();
print_r($result); */








?>