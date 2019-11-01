<?php
session_start();
if (isset($_SESSION['egre_id'])) {
    header("Location: profile.php");
} else {
    session_destroy();
}
require_once('php/conn.php');
?>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registro de usuario</title>
    <link rel="shortcut icon" href="img/logo.png">

    <!-- BootStrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

    <!-- CSS -->
    <link href="css/main.css" rel="stylesheet">
    <script src="js/validarUser.js"></script>
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
            max-width: 600px;
            padding: 20px 20px 5px;
        }

        .card {
            background-color: #F7F7F7;
            /* just in case there no content*/
            padding: 20px 25px 30px;
            margin: 70px auto 0;
            /* shadows and rounded borders */
            -moz-border-radius: 4px;
            -webkit-border-radius: 4px;
            border-radius: 4px;
        }

        .profile-img-card {
            height: 60px;
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
        <p class="tilte">Seguimiento de egresados</p>
        <p class="subtilte">Registro de usuario</p>
        <form onsubmit="return (validar() && check_if_capcha_is_filled())" action="php/newUser.php" method="post"
              accept-charset="utf-8">
            <div class="row">
                <div class="col-sm-4">
                    <label class="input-title">Nombre(s)</label>
                    <input class="form-control form-input" type="text" placeholder="Nombre" name="nombre" id="nombre"
                           maxlength="30" required>
                </div>

                <div class="col-sm-4">
                    <label class="input-title">Apellido paterno</label>
                    <input class="form-control form-input" type="text" placeholder="Apellido paterno" name="apaterno"
                           id="apellidp" maxlength="30" required>
                </div>

                <div class="col-sm-4">
                    <label for="usuario" class="input-title">Apellido materno</label>
                    <input class="form-control form-input" type="text" placeholder="Apellido materno" name="amaterno"
                           id="apellido2" maxlength="30">
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <label for="usuario" class="input-title">Código (Opcional)</label>
                    <input class="form-control form-input" type="text" placeholder="Código" name="codigo" id="codigo"
                           maxlength="20">
                </div>
                <div class="col-sm-8">
                    <label class="form-title">Carrera</label>
                    <select class="form-control  form-input" name="carrera">
                        <optgroup label="Licenciaturas">
                            <?php
                            $sql = $pdo->prepare('SELECT `carreras` FROM `carreras` WHERE tipo = "Licenciatura";');
                            $sql->execute();
                            while ($datos = $sql->fetch()) {
                                echo '<option value="' . $datos[carreras] . '">' . $datos[carreras] . '</option>';
                            }
                            ?>
                        </optgroup>
                        <optgroup label="Ingenerias">
                            <?php
                            $sql = $pdo->prepare('SELECT `carreras` FROM `carreras` WHERE tipo = "Ingeniería";');
                            $sql->execute();
                            while ($datos = $sql->fetch()) {
                                echo '<option value="' . $datos[carreras] . '">' . $datos[carreras] . '</option>';
                            }
                            ?>
                        </optgroup>
                        <optgroup label="Técnico Superior Universitario">
                            <?php
                            $sql = $pdo->prepare('SELECT `carreras` FROM `carreras` WHERE tipo = "Técnico Superior Universitario";');
                            $sql->execute();
                            while ($datos = $sql->fetch()) {
                                echo '<option value="' . $datos[carreras] . '">' . $datos[carreras] . '</option>';
                            }
                            ?>
                        </optgroup>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <label class="input-title">Usuario:</label>
                    <input class="form-control form-input" type="text" placeholder="Usuario" name="usuario" id="usuario"
                           required maxlength="45">
                </div>
                <div class="col-sm-8">
                    <label class="input-title">Correo:</label>
                    <input class="form-control form-input" type="email" placeholder="j@.mx" name="email"
                           id="correo" required maxlength="100">
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <label class="input-title">Contraseña:</label>
                    <input id="pass" class="form-control form-input" type="password" placeholder="Contraseña"
                           name="pass" required>
                </div>
                <div class="col-sm-6">
                    <label class="input-title">Confirmación:</label>
                    <input id="confir" class="form-control form-input" type="password" placeholder="Confirmación"
                           id="confir" required oninput="validatePassword()">
                </div>
            </div>

            <div class="row">
                <div class="col-sm-7">
                    <div id="captcha" class="g-recaptcha" data-callback="capcha_filled"
                         data-expired-callback="capcha_expired"
                         data-sitekey="6LeD4V0UAAAAAOc4PmlFnoD4oEmnwRjhbJ0rmqbB"></div>
                </div>
                <div class="col-sm-5">
                    <label class="checkbox-inline" style="padding:10px 20px;"><input type="checkbox" value=""
                                                                                     name="deacuerdo" required>He leído
                        el aviso y estoy de acuerdo <a
                                href="http://transparencia" target="_blank">Aviso
                            de confidencialidad</a></label>
                </div>

            </div>
            <button type="submit" class="btn btn-primary btn-block" onclick="validatePassword()">Registrar</button>
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

<script src='https://www.google.com/recaptcha/api.js?hl=es'></script>

<script>
    function openMessage(sms) {
        document.getElementById("menssage").innerHTML = sms;
        window.history.replaceState({}, document.title, '/egresados/user');
        $("#messagem").modal();
    }

    var password = document.getElementById("pass")
    var confirm_password = document.getElementById("confir");

    function validatePassword() {
        if (password.value != confirm_password.value) {
            confirm_password.setCustomValidity("Las contraseñas no coinciden");
        } else {
            var secure = password.value.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/);
            console.log('Secure=' + secure);
            if (secure) {
                confirm_password.setCustomValidity("");
            } else {
                confirm_password.setCustomValidity("Ingresa mayúsculas, minúsculas, números, mínimo 8 caracteres.(No se permiten caracteres especiales)");
            }
        }
    }

    var allowSubmit = false;

    function capcha_filled() {
        allowSubmit = true;
    }

    function capcha_expired() {
        allowSubmit = false;
    }

    function check_if_capcha_is_filled() {
        if (allowSubmit) return true;
        alert('Completa el CAPTCHA');
        return false;
    }

</script>

<?php
if (isset($_GET['message'])) {
    echo '<script>
                openMessage("' . $_GET['message'] . '");
            </script>';
}
?>

</body>

</html>
