<?php

session_start();
if(isset($_SESSION['nombre'])|| !empty($_SESSION['nombre'])){
    header('Location: ../profile');
}else{
    session_destroy();
}

require_once('conn.php');

if(isset($_POST['email'])){
    try{
        $qry = $pdo->prepare('SELECT egre_Id, num_conf, nombre, usuario FROM egresado WHERE email =?;');
        $qry->execute(array($_POST['email']));
        $rows = $qry->rowCount();
        if($rows > 0){
            $result=$qry->fetch(PDO::FETCH_ASSOC);
            $conf=md5($result['num_conf']);
            $qry=$pdo->prepare('UPDATE egresado SET num_conf =? WHERE egre_Id =?;'); 
            $qry->execute(array($conf, $result['egre_Id']));
            require 'phpmailer/PHPMailerAutoload.php';
            $mail = new PHPMailer();
            $mail->CharSet='UTF-8';
            $mail->IsSMTP();
            $mail->SMTPDebug = 0;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'ssl';
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 465;
            $mail->IsHTML(true);
            $mail->Username=$mailUser;
            $mail->Password=$mailPass;
            $mail->setFrom('egresados@gmail.com', "Seguimiento de Egresados");
            $mail->Subject = "Seguimiento de egresados, Recuperacion de contraseña.";
            $link='http://'.$_SERVER['SERVER_NAME'].'/egresados/resetPass';
            $mail->Body='  
                        <html>  
                            <head>  
                                <title>Egresados</title>  
                            </head>  
                            <body>  
                                <h2>Recuperar contraseña de perfil de egresado </h2>  
                                <p>  
                                    <b>Hola: '.$result['nombre'].' .</b>
                                    <br>
                                    Los datos de acceso a tu cuenta son los siguientes:
                                    <br>
                                    Usuario: '.$result['usuario'].'
                                    <br>
                                    Correo: '.$_POST['email'].'
                                    <br>
                                    <br>
                                    Para cambiar tu contraseña has click <a href="'.$link.'?codigo='.$conf.'">aqui</a> o en la sigueinte liga: <a href="'.$link.'?codigo='.$conf.'">'.$link.'
                                </p>                       
                            </body>  
                        </html>  
                        ';
            $mail->addAddress($_POST['email'], $result['nombre']);
            if(!$mail->Send()) {
                header('Location: ../forgotPass?message=Ha+ocurrido+un+error,+vuelve+a+intentarlo.');
                //echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
                header('Location: ../index?message=Se+ha+enviado+un+correo+de+recuperacion.');
            }
        }else{
            header('Location: ../forgotPass?message=El+correo+electronico:+<b>'.$_POST['email'].'</b>+no+se+encuentra+registrado.');    
        }
    }catch(Exception $e){
        header('Location: ../forgotPass?message=Ocurrio+un+error,+vuelve+a+intentarlo.');    
    }
}else{
    header('Location: ../index');
}
?>