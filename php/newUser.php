<?php
    require_once('conn.php');
    require_once('recaptchalib.php');
    $secret = "g";
    $resp = null;
    $error = null;
    $reCaptcha = new ReCaptcha($secret);
    // Was there a reCAPTCHA response?
    if (isset($_POST["g-recaptcha-response"])) {
        $resp = $reCaptcha->verifyResponse(
            $_SERVER["REMOTE_ADDR"],
            $_POST["g-recaptcha-response"]
        );
    }else{
        header('Location: ../user');
    }
    if ($resp == null || !$resp->success) {
        header('Location: ../user');
    }

    if (isset($_POST['usuario'])) {
        $nombre = $_POST['nombre'] . ' ' . $_POST['apaterno'] . ' ' . (isset($_POST['apaterno']) ? $_POST['amaterno'] : '');
        $nombre = ucwords($nombre);
        $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
        $conf = md5($_POST['usuario']);
        try{
            $qry = $pdo->prepare('SELECT usuario FROM egresado WHERE usuario = ?;');
            $qry -> execute(array($_POST['usuario']));
            $rows = $qry -> rowCount();
            if($rows  == 0){
                $qry = $pdo->prepare('SELECT email FROM egresado WHERE email = ?;');
                $qry -> execute(array($_POST['email']));
                $rows = $qry -> rowCount();
                if($rows == 0){
                    $qry = $pdo->prepare('INSERT INTO egresado (nombre, codigo, carrera, usuario, email, password, estatusEgreso, num_conf, cicloIngreso, cicloEgreso) VALUES (?,?,?,?,?,?,?,?,?,?);');
                    $qry -> execute(array($nombre, $_POST['codigo'], $_POST['carrera'], $_POST['usuario'], $_POST['email'], $pass, 'Egresado', $conf, 'A', 'A'));
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
                    $mail->setFrom('egresados@gmail.com', "Seguimiento de Egresados");
                    $mail->Subject = "Seguimiento de egresados, Validacion de correo.";
                    $link='http://'.$_SERVER['SERVER_NAME'].'/egresados/php/validate';
                    $im='iVBORw0KGgoAAAANSUhEUgAAAgIAAABkCAYAAAD0d1iiAAAACXBIWXMAAAsTAAALEwEAmpwYAAAHCWlUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS42LWMxNDIgNzkuMTYwOTI0LCAyMDE3LzA3LzEzLTAxOjA2OjM5ICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdEV2dD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlRXZlbnQjIiB4bWxuczpwaG90b3Nob3A9Imh0dHA6Ly9ucy5hZG9iZS5jb20vcGhvdG9zaG9wLzEuMC8iIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ0MgMjAxOCAoV2luZG93cykiIHhtcDpDcmVhdGVEYXRlPSIyMDE4LTExLTE2VDA5OjUzOjI5LTA2OjAwIiB4bXA6TWV0YWRhdGFEYXRlPSIyMDE4LTExLTE2VDA5OjUzOjI5LTA2OjAwIiB4bXA6TW9kaWZ5RGF0ZT0iMjAxOC0xMS0xNlQwOTo1MzoyOS0wNjowMCIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDo5ODc0ZmIxMy1hYzlhLWQzNDgtYWQxMi05M2I3Yzg2N2JlNzMiIHhtcE1NOkRvY3VtZW50SUQ9ImFkb2JlOmRvY2lkOnBob3Rvc2hvcDowMTc4YTZlNS0xOWRmLTAxNGYtYTFkMi03YmU1OGUwZTlhMTAiIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDoyOGMxODIxZC1kMjYxLTAxNDUtOTVlZS0yZGQ5Mzk2YWUyMzIiIHBob3Rvc2hvcDpDb2xvck1vZGU9IjMiIGRjOmZvcm1hdD0iaW1hZ2UvcG5nIj4gPHhtcE1NOkhpc3Rvcnk+IDxyZGY6U2VxPiA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0iY3JlYXRlZCIgc3RFdnQ6aW5zdGFuY2VJRD0ieG1wLmlpZDoyOGMxODIxZC1kMjYxLTAxNDUtOTVlZS0yZGQ5Mzk2YWUyMzIiIHN0RXZ0OndoZW49IjIwMTgtMTEtMTZUMDk6NTM6MjktMDY6MDAiIHN0RXZ0OnNvZnR3YXJlQWdlbnQ9IkFkb2JlIFBob3Rvc2hvcCBDQyAyMDE4IChXaW5kb3dzKSIvPiA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0ic2F2ZWQiIHN0RXZ0Omluc3RhbmNlSUQ9InhtcC5paWQ6OTg3NGZiMTMtYWM5YS1kMzQ4LWFkMTItOTNiN2M4NjdiZTczIiBzdEV2dDp3aGVuPSIyMDE4LTExLTE2VDA5OjUzOjI5LTA2OjAwIiBzdEV2dDpzb2Z0d2FyZUFnZW50PSJBZG9iZSBQaG90b3Nob3AgQ0MgMjAxOCAoV2luZG93cykiIHN0RXZ0OmNoYW5nZWQ9Ii8iLz4gPC9yZGY6U2VxPiA8L3htcE1NOkhpc3Rvcnk+IDxwaG90b3Nob3A6VGV4dExheWVycz4gPHJkZjpCYWc+IDxyZGY6bGkgcGhvdG9zaG9wOkxheWVyTmFtZT0iZWNvbW1lcmNlIFNJQ0FSIiBwaG90b3Nob3A6TGF5ZXJUZXh0PSJlY29tbWVyY2UgU0lDQVIiLz4gPC9yZGY6QmFnPiA8L3Bob3Rvc2hvcDpUZXh0TGF5ZXJzPiA8cGhvdG9zaG9wOkRvY3VtZW50QW5jZXN0b3JzPiA8cmRmOkJhZz4gPHJkZjpsaT5hZG9iZTpkb2NpZDpwaG90b3Nob3A6MjMzZGQ5ZTgtYTg5Ni1jMzRlLTg2YzEtYjM5ZDBiNmFlZmQ0PC9yZGY6bGk+IDwvcmRmOkJhZz4gPC9waG90b3Nob3A6RG9jdW1lbnRBbmNlc3RvcnM+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';
                    $mail->Body='  
                                <html>  
                                    <title>Enviado </title> <style type="text/css">body,html{width:100%}body{background-repeat:repeat;height:100%;margin:0;padding:0;-webkit-font-smoothing:antialiased}h1,h2,h3,h4,p{margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0}table{font-size:30px;border:0}.nav{width:350px}.logo{width:300px;margin-left:30px;height:600px}.logo2{margin:auto;display:inline-block;text-align:center;width:400px}@media only screen and (max-width:640px){.header-bg,.logo{width:440px!important}.logo2,.nav{text-align:center}.header-bg{height:10px!important}.banner,.feature-img,.logo,.main-image,.nav,.section-img,.top-bottom-bg{height:auto!important}.main-header{line-height:15px!important}.main-subheader{line-height:28px!important}.logo2{width:350px}.nav{width:500px!important;font-size:25px!important;margin-left:0!important;border:none!important}.name,.name2{font-size:25px;line-height:35px}.name{text-align:left;padding-top:15px}.name2{text-align:center}.feature{width:420px!important}.feature-middle{width:400px!important;text-align:center!important}.feature-img{width:400px!important}.container{width:440px!important}.container-middle{width:420px!important}.banner,.main-image,.mainContent,.section-img,.section-item{width:400px!important}.prefooter-header,.prefooter-subheader{padding:0 10px!important;line-height:24px!important}.top-bottom-bg{width:420px!important}}@media only screen and (max-width:479px){.main-header,.main-subheader,.top-header-left{text-align:center!important}.header-bg{width:280px!important;height:10px!important}.top-header-left,.top-header-right{width:260px!important}.banner,.feature-img,.logo,.main-image,.nav,.section-img,.top-bottom-bg{height:auto!important}.main-header{line-height:2px!important}.main-subheader{line-height:28px!important}.logo2,.nav{text-align:center}.logo{width:300px!important}.logo2{width:200px}.nav{width:360px!important;font-size:20px!important;margin-left:0!important;border:none!important}.name,.name2{font-size:20px;line-height:25px}.name{text-align:left;padding-top:15px}.name2{text-align:center}.feature{width:260px!important}.feature-middle{width:240px!important;text-align:center!important}.feature-img{width:240px!important}.container{width:280px!important}.container-middle{width:260px!important}.banner,.main-image,.mainContent,.section-img,.section-item{width:240px!important}.prefooter-header,.prefooter-subheader{padding:0 10px!important;line-height:28px!important}.top-bottom-bg{width:260px!important}}</style> <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet"> <title>Correo SICAR</title></head><body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="background-color: #FFFFFF;"><table border="0" width="100%" cellpadding="0" cellspacing="0"> <tr> <td width="100%" align="center" valign="top"> <table width="700" border="0" cellpadding="0" cellspacing="0" align="center" class="container" bgcolor="F9F9F9"> <tr bgcolor="F9F9F9"> <td height="20"></td></tr><tr> <td> <table border="0" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; height: 150px; " class="logo"> <tr> <td style="padding: 10px 0;"> <img class="logo2" editable="true" mc:edit="logo" border="0" style="display: block; " src="http://subirimagen.me/uploads/20181214132053.png"  alt=""/> </td></tr></table> </td></tr><tr bgcolor="F9F9F9"> <td height="20"></td></tr><tr bgcolor="F7F7F7"> <td> <table border="0" width="560" align="center" cellpadding="0" cellspacing="0" class="container-middle"> <tr bgcolor="F7F7F7"> <td height="20"></td></tr><tr bgcolor="F7F7F7"> <td> <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="mainContent"> <tr> <td mc:edit="title1" class="main-header" style="color: #484848; font-size: 16px; font-weight: normal; font-family: Roboto, sans-serif;"> <multiline> <h2 class="name" style="color: #808080">Hola tu direccion para entrar al panel administrativo de ecommerce sicar es la siguiente <a href="http://pruebafinal39.com/admin521pfsorm/">http://pruebafinal39.com/admin521pfsorm/</a></h2> <div style="color: #909090;font-family: Roboto, sans-serif;line-height: 2em; text-align: left;font-size: 15px;margin-left: 10px;margin-right: 10px;padding-bottom: 10px;padding-top: 10px;"> <p style="text-align: justify; font-family: \'Roboto\', sans-serif; line-height: 16px;"> Por favor recuerda este link ya que es el de el panel administrativo de ecommerce sicar donde podras administrat toda tu tienda en linea. </p></div><div style="color: #909090;display: block;font-family: Roboto, sans-serif;font-size: 16px;font-weight: normal;text-align: center;margin-bottom: 20px;"> <h2 class="name2">Gracias por su preferencia</h2> </div></multiline> </td></tr><tr> <td mc:edit="subtitle1" class="main-subheader" style="color: #a4a4a4; font-size: 12px; font-weight: normal; font-family: Roboto, sans-serif;text-align: center;"> <multiline> <h2 style="color: #808080;"><a href="https://sicar.mx">Copyright(R) SICAR SOLUTIONS SA DE CV</a></h2> </multiline> </td></tr></table> </td></tr><tr bgcolor="F7F7F7"> <td height="25"></td></tr><tr bgcolor="F7F7F7"> <td align="center" style="line-height: 6px;"></td></tr></table> </td></tr></table> </td></tr></table></body>
 
                                </html>  
                                ';
                    $mail->addAddress($_POST['email'], $nombre);
                    if(!$mail->Send()) {
                        header('Location: ../user.php?message=Ha+ocurrido+un+error,+vuelve+a+intentarlo.');
                        // echo "Mailer Error: " . $mail->ErrorInfo;
                    } else {
                        session_destroy();
                        header('Location: ../index.php?message=Usuario+creado,+valida+tu+correo+para+poder+ingresar.');
                    }
                }else{
                    header('Location: ../user.php?message=El+email+ingresado+ya+esta+en+uso+por+otro+usuario.');
                }
            }else{
                header('Location: ../user.php?message=El+usuario+ingresado+ya+esta+en+uso.');
            }
        }catch(Exception $e){
            header('Location: ../user.php?message=Ha+ocurrido+un+error,+vuelve+a+intentarlo.');
        }
    }else{
        header('Location: ../user.php');
    }
?>