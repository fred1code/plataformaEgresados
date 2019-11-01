<?php 
    require_once('conn.php');





    require_once('conn.php');

    if(isset($_POST['user'])){
        $qry = $pdo->prepare('SELECT egre_Id, nombre, password, email, validado FROM egresado WHERE usuario = ?;');
        $qry->execute(array($_POST['user']));
        $rows = $qry->rowCount();
        if($rows > 0){
            $result = $qry->fetch(PDO::FETCH_ASSOC);
            if(password_verify($_POST['pass'], $result['password'])){
                if($result['validado'] == 1){
                    session_start();
                    $_SESSION['egre_id'] = $result['egre_Id'];
                    $_SESSION['usuario'] = $_POST['user'];
                    $_SESSION['nombre'] = $result['nombre'];
                    $_SESSION['email'] = $result['email'];
                    $_SESSION['pass'] = $result['password'];

                    header('Location: ../profile');
                }else{
                    header('Location: ../index?message=Es+necesario+que+valides+tu+correo+para+poder+ingresar.');
                }
            }else{
               header('Location: ../index?message=La+contraseña+es+incorrecta,+vuelve+a+intentarlo.');
            }
        }else{
            header('Location: ../index?message=El+nombre+de+usuario+no+existe,+vuelve+a+intentarlo.');
        }

    }else{
        header('Location: ../index');
    }



    if(isset($_POST['user'])){
        $qry = $pdo->prepare('SELECT egre_Id, nombre, password, email, validado FROM egresado WHERE usuario = ?;');
        $qry->execute(array($_POST['user']));
        $rows = $qry->rowCount();
        if($rows > 0){
            $result = $qry->fetch(PDO::FETCH_ASSOC);
            if(password_verify($_POST['pass'], $result['password'])){
                if($result['validado'] == 1){
                    session_start();
                    $_SESSION['egre_id'] = $result['egre_Id'];
                    $_SESSION['egre_id'] = $result['egre_Id'];
                    $_SESSION['usuario'] = $_POST['user'];
                    $_SESSION['nombre'] = $result['nombre'];
                    $_SESSION['email'] = $result['email'];
                    $_SESSION['pass'] = $result['password'];
                    
                    header('Location: ../profile.php');
                }else{
                    header('Location: ../index.php?message=Es+necesario+que+valides+tu+correo+para+poder+ingresar.');
                }
            }else{
               header('Location: ../index.php?message=La+contraseña+es+incorrecta,+vuelve+a+intentarlo.');
            }
        }else{
            header('Location: ../index.php?message=El+nombre+de+usuario+no+existe,+vuelve+a+intentarlo.');
        }
        
    }else{
        header('Location: ../index.php');
    }
?>
