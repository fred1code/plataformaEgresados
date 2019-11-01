<?php 
    session_start();
    if(isset($_SESSION['nombre'])|| !empty($_SESSION['nombre'])){
        header("Location: dashboard");
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
                <a class="navbar-brand texto" href="">Administracion de egresados</a>
            </div>
        </div>
    </nav>

    <!-- LogIn -->
    <div class="container">
        <div class="card card-container">
            <img id="profile-img" class="profile-img-card" src="img/logo.png" />
            <p class="tilte">Administracion de egresados</p>
            <p class="subtilte">Inicio de sesión</p>
            <form method="post" accept-charset="utf-8" action="php/user.php" style="margin: 0;">
                <input class="form-control form-input" type="text" placeholder="Usuario" name="user" required>
                <input class="form-control form-input" type="password" placeholder="Contraseña" name="pass" required>
                <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
            </form>
        </div>
    </div>


    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


</body>

</html>
