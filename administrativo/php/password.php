<?php

    session_start();

    if(!isset($_SESSION['usuarioId'])){
        session_destroy();

        header("Location: ../index.php");
    }

    require_once('conn.php');

    if(isset($_POST['uPass'])){

        echo  '<script>
                alert(\"soy domingo\"'.$_SESSION['usuarioId'].');
                </script>';
        $qry = $pdo->prepare('SELECT * FROM usuario WHERE usuarioId = ?;');
        $qry->execute(array($_SESSION['usuarioId']));
        $rows = $qry->rowCount();
        if($rows > 0){
            $result = $qry->fetch(PDO::FETCH_ASSOC);
            if(md5($_POST['uPass']) == $result['password']){
                $qry = $pdo->prepare('UPDATE usuario SET password=? WHERE usuarioId = ?;');
                $qry->execute(array(md5($_POST['uPassNew']), $_SESSION['usuarioId']));
             //   session_destroy();
              //  header("Location: ../index.php");
            }else{
                echo '<script>
                alert("Contraseña incorrecta");
                window.location.href = \'../dashboard.php\';
                </script>';
            }    
        }else{
           header('Location: ../index'); 
        }
    }else{
        session_destroy();
        header('Location: ../index');
    }

?>
