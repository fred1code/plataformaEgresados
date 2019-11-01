<?php
session_start();
session_destroy();
require_once('php/conn.php');
if(isset($_GET['codigo'])){
    $qry = $pdo->prepare('SELECT egre_Id, nombre FROM egresado WHERE num_conf = ?;');
    $qry->execute(array($_GET['codigo']));
    $count = $qry -> rowCount();
    if($count > 0){
        session_start();
        $result = $qry->fetch(PDO::FETCH_ASSOC);
        $_SESSION['egre_id'] = $result['egre_Id'];
    }else{
        header('Location: index?message=El+codigo+ha+expirado,+o+es+invalido.');
    }
}else{
    header('Location: index');
}
?>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cambiar contraseña</title>
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
                <a class="navbar-brand texto" href="index">Seguimiento de Egresados</a>
            </div>
        </div>
    </nav>

    <!-- LogIn -->
    <div class="container">
        <div class="card card-container">
            <img id="profile-img" class="profile-img-card" src="img/user.png" />
            <p class="tilte">Cambiar Contraseña</p>
            <p class="subtilte"><?php echo $result['nombre']; ?></p>
            <form method="post" accept-charset="utf-8" action="php/changePass">
                <label class="input-title">Nueva Contraseña:</label>
                <input id="pass" class="form-control form-input" type="password" placeholder="Contraseña" name="pass" required>
                <label class="input-title">Confirmacion:</label>
                <input id="confir" class="form-control form-input" type="password" placeholder="Confirmacion" id="confir" required oninput="validatePassword()">
                <button type="submit" class="btn btn-primary btn-block">Aceptar</button>
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
            window.history.replaceState({}, document.title, '/egresados/resetPass');
            $("#messagem").modal();
        }

        var password = document.getElementById("pass")
        var confirm_password = document.getElementById("confir");

        function validatePassword() {
            if (password.value != confirm_password.value) {
                confirm_password.setCustomValidity("Las contraseñas no coinciden");
            } else {
                var secure = password.value.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/);
                console.log('Secure='+secure);
                if (secure) {
                    confirm_password.setCustomValidity("");
                } else {
                    confirm_password.setCustomValidity("Ingresa mayúsculas, minúsculas, números, mínimo 8 caracteres.(No se permiten caracteres especiales)");
                }
            }
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

