<?php 
    session_start();
    if(isset($_SESSION['nombre'])|| !empty($_SESSION['nombre'])){
        header("Location: profile.php");
    }else{
        session_destroy();
    }
?>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Inicio de sesión</title>
    <link rel="shortcut icon" href="img/logo.png">

    <!-- BootStrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

    <!-- CSS -->
    <link href="css/main.css" rel="stylesheet">

    <style>
        html,
        body {
            background-color: #FFFFFF;
            background-image: url(img/back-imagen.jpg);
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }

        .card-container.card {
            max-width: 370px;
            padding: 20px 20px 10px;
        }

        .card {
            background-color: #F7F7F7;
            /* just in case there no content*/
            padding: 20px 25px 30px;
            margin: 70px auto;
            /* shadows and rounded borders */
            -moz-border-radius: 4px;
            -webkit-border-radius: 4px;
            border-radius: 4px;
            opacity: 0.93;
        }

        .profile-img-card {
            height: 96px;
            margin: 0 auto 10px;
            display: block;
        }

    </style>

</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand logo" href=""><img height="40" src="img/logo.png"> </a>
                <a class="navbar-brand texto" href="">Seguimiento de egresados</a>
            </div>
        </div>
    </nav>

    <!-- LogIn -->
    <div class="container">
        <div class="card card-container">
            <img id="profile-img" class="profile-img-card" src="img/logo.png" />
            <p class="tilte">egresados</p>
            <p class="subtilte">Inicio de sesión</p>
            <form method="post" accept-charset="utf-8" action="php/logIn.php" style="margin: 0;">
                <input class="form-control form-input" type="text" placeholder="Usuario" name="user" required id="nombre">
                <input class="form-control form-input" type="password" placeholder="Contraseña" name="pass" required>
                <p style="text-align: right; font-size: 12px; margin: 0; padding:2px 0 3px;"><a href="forgotPass.php">¿Olvidaste tu contraseña?</a></p>
                <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
            </form>
            <p style="text-align: right; font-size: 15px; margin: 0; padding-top: 5px;">Si aún no tienes una cuenta regístrate <a href="user.php">click aquí</a></p>
        </div>
    </div>

    <div id="help" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">¿Necesitas ayuda?</h4>
                </div>
                <div class="modal-body">
                    <p>Si tienes algún problema para registrarte, iniciar sesión, o recuperar tu contraseña, envía un correo a: <b>egresados@gmail.com.</b></p>
                    <br>
                    <p>Envía tu nombre, y el correo registrado, comentanos tu problema y nos pondremos en contacto contigo.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div id="messagem" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Información</h4>
                </div>
                <div class="modal-body">
                    <p id="menssage">Mesaje</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script>
        function open() {
            $("#help").modal();
        }

        function openMessage(sms) {
            document.getElementById("menssage").innerHTML = sms;
            window.history.replaceState({}, document.title, "/egresados/");
            $("#messagem").modal();
        }
    </script>

    <?php 
        if(isset($_GET['message'])){
            echo '<script>
                openMessage("'.$_GET['message'].'");
            </script>';
        }else{
            echo '<script>open();</script>';
        }
    ?>
    
</body>

</html>
