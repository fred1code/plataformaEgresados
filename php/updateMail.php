<?php
session_start();
if(!isset($_SESSION['egre_id'])){
    header("Location: ../index");
    session_destroy();
}
require_once('conn.php');
if(isset($_POST['email'])){
    
    if($_SESSION['email'] == $_POST['email']){
        header('Location: ../profile?message=No+se+encontraron+cambios+en+el+correo.');
    }else{
        $qry = $pdo->prepare('SELECT email FROM egresado WHERE email=?;');
        $qry->execute(array($_POST['email']));
        $num_rows = $qry->rowCount();
        if($num_rows==0){
                try {
                    $conf = md5($_POST['email']);
                    $qry = $pdo->prepare('UPDATE egresado SET email=?, num_conf=?, validado=0 WHERE egre_Id =?;'); 
                    $qry->execute(array($_POST['email'], $conf, $_SESSION['egre_id']));
                    require 'phpmailer/PHPMailerAutoload.php';
                    $mail = new PHPMailer();
                    $mail->IsSMTP();
                    $mail->SMTPDebug = 0;
                    $mail->SMTPAuth = true;
                    $mail->SMTPSecure = 'ssl';
                    $mail->Host = "smtp.gmail.com";
                    $mail->Port = 465;
                    $mail->IsHTML(true);
                    $mail->Username=$mailUser;
                    $mail->Password=$mailPass;
                    $mail->setFrom('egre@gmail.com', "Seguimiento de Egresados ");
                    $mail->Subject = "Seguimiento de egresados  Validacion de correo.";
                    $link='http://'.$_SERVER['SERVER_NAME'].'/egresados/php/validate';
                    $mail->Body='  
                                <html>  
                                    <head>  
                                        <title>Seguimineto de Egresados</title>  
                                    </head>  
                                    <body>  
                                        <h2>Confirmación de correo electrónico, Seguimiento de egresado.</h2>  
                                        <p>  
                                            <b>Hola: '.$_SESSION['nombre'].' .</b>
                                           agradece tu registro y te invita a que a que continúes complementando el formulario; lo anterior permitirá a tu "Alma mater" realizar estudios que permitan identificar las fortalezas y debilidades de la formación académica de los egresados y por ende implementar acciones que contribuyan a la calidad del procedo de formación.<br>
                                            Para continuar con el proceso, confirma tu correo electrónico dando click <a href="'.$link.'?codigo='.$conf.'">aquí</a> o en la siguiente liga: <a href="'.$link.'?codigo='.$conf.'">'.$link.'
                                        </p>                     
                                    </body>  
                                </html>  
                                ';
                    $mail->addAddress($_POST['email'], $_SESSION['nombre']);
                    if(!$mail->Send()) {
                        header('Location: ../profile?message=No+se+pudo+guardar+la+informacion,+vuelve+a+intentarlo.');
                        // echo "Mailer Error: " . $mail->ErrorInfo;
                    } else {
                        session_destroy();
                        header('Location: ../index?message=Se+actualizo+la+informacion+con+exito,+valida+tu+correo+nuevamente.');
                    }
                } catch (Exception $e) {
                    header('Location: ../profile?message=No+se+pudo+guardar+la+informacion,+vuelve+a+intentarlo.'); 
                }
        }else{
            header('Location: ../profile?message=El+correo+ya+se+encuentra+configurado+con+otra+cuenta.'); 
        }    
    }
}else{
    header('Location: ../profile');
}
?>