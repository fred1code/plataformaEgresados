<?php 
    session_start();
    if(isset($_SESSION['nombre'])|| !empty($_SESSION['nombre'])){
        header("Location: profile");
    }else{
        session_destroy();
    }
?>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Recuperar contraseña</title>
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
            max-width: 360px;
            padding: 20px 20px 1px;
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
                <a class="navbar-brand logo" href="index"><img height="40" src="img/logo.png"> </a>
                <a class="navbar-brand texto" href="index">Seguimiento de egresados</a>
            </div>
        </div>
    </nav>

    <!-- LogIn -->
    <div class="container">
        <div class="card card-container">
            <img id="profile-img" class="profile-img-card" src="img/user.png"/>
            <p class="tilte">Recuperar contraseña</p>
            <p>Para recuperar contraseña ingresa el correo con el que te registraste, te enviaremos un correo, con el link de recuperación de contraseña.</p>
            <form method="post" accept-charset="utf-8" action="php/sendMailPass">
                <input class="form-control form-input" type="email" placeholder="Correo electrónico" name="email" required>
                <button type="submit" class="btn btn-primary btn-block">Recuperar</button>
            </form>
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
        function openMessage(sms) {
            document.getElementById("menssage").innerHTML = sms;
            window.history.replaceState({}, document.title, "/egresados/forgotPass");
            $("#messagem").modal();
        }
    </script>

    <?php 
        if(isset($_GET['message'])){
            echo '<script>
                openMessage("'.$_GET['message'].'");
            </script>';
        }
    ?>
    
</body>

</html>
