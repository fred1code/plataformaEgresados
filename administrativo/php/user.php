<?php 
    require_once('conn.php');
    
    if(isset($_POST['user'])){
        $qry = $pdo->prepare('SELECT * FROM usuario WHERE usuario = ?;');
        $qry->execute(array($_POST['user']));
        $rows = $qry->rowCount();
        if($rows > 0){
            $result = $qry->fetch(PDO::FETCH_ASSOC);
            if(md5($_POST['pass']) == $result['password']){
                session_start();
                $_SESSION['usuarioId'] = $result['usuarioId'];
                $_SESSION['nombre'] = $result['nombre'];
                $_SESSION['usuario'] = $result['usuario'];
                $_SESSION['puesto'] = $result['puesto'];
                $_SESSION['carrera'] = $result['carrera'];
                header('Location: ../dashboard.php');
            }else{
               session_destroy();
               header('Location: ../index');
            }
        }else{
            session_destroy();
            header('Location: ../index');    
        }
        
    }else{
        session_destroy();
        header('Location: ../index');
    }
?>
