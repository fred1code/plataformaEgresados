<?php
session_start();
if (!isset($_SESSION['usuarioId'])) {
    session_destroy();
    header("Location: index.php");
}
require_once('php/conn.php');
?>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Administracion de egresados</title>
    <link rel="shortcut icon" href="img/logo.png">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

    <link rel="stylesheet" href="css/main.css">

    <style>
        .mini-img {
            border-radius: 10px;
            display: block;
            margin: 10px auto 10px;;
        }

        .nombre {
            text-align: center;
            display: block;
            color: #808080;
        }
    </style>
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand logo" href=""><img height="40" src="img/logo.png"></a>
            <a class="navbar-brand texto" href="">Egresados</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a>
                        <span class="glyphicon glyphicon-user"></span>
                        <?php echo ' ' . $_SESSION['usuario']; ?>
                    </a>
                </li>
                <li><a href="php/logOut.php"><span class="glyphicon glyphicon-log-out"></span> Cerrar sesión</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid" style="margin-top: 70px; padding: 15px;">
    <div class="row">
        <div class="col-sm-2" style="padding-top: 0px;">
            <div class="row" style="margin: 10px auto 5px;">
                <label class="nombre">
                    <?php echo '' . $_SESSION['nombre']; ?>
                </label>
                <label class="nombre">
                    <?php
                    if ($_SESSION['puesto'] == 0) {
                        echo 'Administrador';
                    } else {
                        echo 'Cordinacion';
                    }
                    ?>
                </label>
                <label class="nombre">
                    <?php
                    if ($_SESSION['puesto'] == 1) {
                        echo '' . $_SESSION['carrera'];
                    }
                    ?>
                </label>
            </div>
            <div class="row" style="margin: 10px auto 5px;">
                <ul class="nav nav-pills nav-stacked">
                    <li id="bEgresados" onclick="hideForm('egresados', 'bEgresados')" class="active"><a>Información de
                            egresados</a></li>
                    <li id="bEmpleos" onclick="hideForm('empleos', 'bEmpleos')"><a>Información de empleos</a></li>
                    <li id="bReportes" onclick="hideForm('reportes', 'bReportes')"><a>Reportes</a></li>
                    <li id="bCuenta" onclick="hideForm('cuenta', 'bCuenta')"><a>Mi cuenta</a></li>
                    <?php
                    if ($_SESSION['puesto'] == 0) {
                        echo '<li id="bCarreras" onclick="hideForm(\'carreras\', \'bCarreras\')"><a>Carreras</a></li>
                        <li id="bCuentas" onclick="hideForm(\'cuentas\', \'bCuentas\')"><a>Configuracion de cuentas</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
        <div class="col-sm-10" style="border-left-style: solid; border-width:1px; border-color:#C7C7C7;">

            <div id="egresados" style="display: block;">
                <h3 class="t3">Información de egresados</h3>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table id="egreTable" class="table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Codigo</th>
                                    <th>Nombre</th>
                                    <th>Sexo</th>
                                    <th>Carrera</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $sql = 'SELECT egre_id, codigo, nombre, sexo, carrera FROM egresado e WHERE e.validado = 1 AND e.nombre IS NOT NULL' . ($_SESSION['puesto'] == 1 ? (' AND e.carrera = ?') : '') . ';';
                                $qry = $pdo->prepare($sql);
                                $qry->execute(array($_SESSION['carrera']));
                                $rows = $qry->fetchall(PDO::FETCH_ASSOC);
                                foreach ($rows as $row) {
                                    echo "<tr>" .
                                        "<td>" . str_replace("display:none","", $row["egre_id"]) . "</td>" .
                                        "<td>" . str_replace("display:none","", $row["codigo"]) . "</td>" .
                                        "<td>" . str_replace("display:none","", $row["nombre"]) . "</td>" .
                                        "<td>" . str_replace("display:none","", $row["sexo"]) . "</td>" .
                                        "<td>" . str_replace("display:none","", $row['carrera']) . "</td>" .
                                        "</tr>";
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div id="empleos" style="display: none;">
                <h3 class="t3">Información de empleos</h3>
                <div class="row">


                    <table id="jobTable" class="table table-hover">
                        <thead>
                        <tr>
                            <th style="display:none">Idegresados</th>
                            <th>Codigo</th>
                            <th>Nombre</th>

                            <th>Sexo</th>
                            <th>Telefono</th>
                            <th>Email</th>
                            <th>Carrera</th>

                            <th>Trabaja</th>


                        </tr>
                        </thead>
                        <tbody id="jobTable2">

                        <?php


                        $qry = $pdo->prepare('SELECT *FROM egresado');
                        $qry->execute();
                        $rows = $qry->fetchall(PDO::FETCH_ASSOC);
                        foreach ($rows as $row) {

                            if ($row['trabaja'] == 1) {
                                $row['trabaja'] = "Si";
                            } else {
                                $row['trabaja'] = "No";
                            }
                            echo '<tr>' .
                                '<td style="display:none">' . $row['egre_Id'] . '</td>' .
                                '<td>' . $row['codigo'] . '</td>' .
                                "<td>" . str_replace("display:none","", $row["nombre"]) . '</td>'.
                                '<td>' . $row['sexo'] . '</td>' .
                                '<td>' . $row['telefono'] . '</td>' .
                                '<td>' . $row['email'] . '</td>' .
                                '<td>' . $row['carrera'] . '</td>' .


                                '<td>' . $row['trabaja'] . '</td>' .




                                '</tr>';
                        }

                        ?>


                        <!--- ///////////////////////////////////////////////////////////////////////////  -->

                        </tbody>
                    </table>
                </div>
            </div>


            <div id="reportes" style="display: none;">
                <h2 class="t3">Reportes</h2>

                <h3>Generar reporte</h3>
                <form method="POST" action="php/reporte.php" enctype="multipart/form-data">

                    <div class="row">

                        <div class="col-sm-1">

                            <img src="img/excel.png" alt="">
                            <label for="radio-1">Excel</label>
                            <input type="radio" name="radio" value="excel" id="radio-1" class="option-input radio"
                                   checked>

                        </div>

                        <div class="col-sm-1">

                            <img src="img/pdf.png" alt="">
                            <label for="radio-2">PDF</label>

                            <input type="radio" name="radio" value="pdf" id="radio-2" class="option-input radio">

                        </div>

                    </div>


                    <div class="row">
                        <div class="col-sm-2">
                            <label for="sexo2">Sexo</label>
                            <select name="sexo2" id="sexo2" class="form-control form-input">
                                <option value="Ambos">Ambos</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                            </select>

                        </div>


                        <div class="col-sm-2">

                            <label class="form-title">Carrera</label>
                            <select class="form-control  form-input" name="carrera">
                                <option value="Todas" checked>Todas</option>
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

                    <div class='row'>
                        <div class="col-sm-10">
                            <br>
                            <input type="submit" class="btn btn-primary" formtarget="_blank" value="Generar Reporte">
                        </div>
                    </div>

                </form>

                <div class='row'>
                    <h3>Plantilla EXCEL</h3>
                    <div class="col-sm-10">
                        <br>
                        <input type="button" name="plantilla" value="Generar Plantilla" class="btn btn-primary"
                               formtarget="_blank" onclick="platilla()">
                    </div>
                </div>


                <div class='row'>

                    <h3>Importar Datos de EXCEL</h3>
                    <div class="col-sm-10">
                        <br>
                        <form action="php/exportar.php" method="POST" enctype="multipart/form-data">
                            <input type="file" class="form-control" name="excelD" accept=".xls, .xlsx"
                                   required="requerida">
                            <input type='submit' value='Importar' class="btn btn-primary">
                        </form>
                    </div>
                </div>

            </div>


            <div id="cuenta" style="display: none;">
                <h3 class="t3">Mi cuenta</h3>
                <div class="row">
                    <div class="col-sm-7">
                        <label class="form-title">Nombre</label>
                        <input class="form-control form-input" type="text" value="<?php echo $_SESSION['nombre'] ?>"
                               disabled>
                    </div>
                    <div class="col-sm-5">
                        <label class="form-title">Usuario</label>
                        <input class="form-control form-input" type="text" value="<?php echo $_SESSION['usuario'] ?>"
                               disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <label class="form-title">Puesto</label>
                        <input class="form-control form-input" type="text"
                               value="<?php echo($_SESSION['puesto'] == 0 ? 'Administrador' : 'Cordinacion') ?>"
                               disabled>
                    </div>
                    <?php
                    if ($_SESSION['puesto'] != 0) {
                        echo '<div class="col-sm-6">
                                        <label class="form-title">Carrera</label>
                                        <input class="form-control form-input" type="text" ' . $_SESSION['carrera'] . ' disabled>
                                    </div>';
                    }
                    ?>
                </div>

                <form method="post" accept-charset="utf-8" action="php/password.php">
                    <div class="row">
                        <div class="col-sm-4">
                            <label class="form-title">Contraseña actual</label>
                            <input class="form-control form-input" type="password" id="uPass" name="uPass" required>
                        </div>
                        <div class="col-sm-4">
                            <label class="form-title">Nueva contraseña</label>
                            <input class="form-control form-input" type="password" id="uPassNew" name="uPassNew"
                                   required>
                        </div>
                        <div class="col-sm-4">
                            <label class="form-title">Confirmación</label>
                            <input class="form-control form-input" type="password" id="uPassCon" name="uPassCon"
                                   required oninput="validatePassword()">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" onclick="validatePassword()">Cambiar contraseña
                    </button>
                </form>
            </div>

            <div id="carreras" style="display: none;">
                <h3 class="t3">Carreras</h3>
                <button type="submit" class="btn btn-primary" style="margin-bottom: 5px;" onclick="agregarCarrera()">
                    Agregar carrera
                </button>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table id="carTable" class="table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Carrera</th>
                                    <th>Tipo</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $sql = 'SELECT * FROM carreras';
                                $qry = $pdo->prepare($sql);
                                $qry->execute();
                                $rows = $qry->fetchall(PDO::FETCH_ASSOC);
                                foreach ($rows as $row) {
                                    echo "<tr>" .
                                        "<td>" . $row["id_carreras"] . "</td>" .
                                        "<td>" . $row["carreras"] . "</td>" .
                                        "<td>" . $row["tipo"] . "</td>" .
                                        "</tr>";
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div id="cuentas" style="display: none;">
                <h3 class="t3">Cuentas de usuario</h3>
                <button type="submit" class="btn btn-primary" style="margin-bottom: 5px;" onclick="agregarUsuario()">
                    Agregar usuario
                </button>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table id="usuTable" class="table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Usuario</th>
                                    <th>Puesto</th>
                                    <th>Carrera</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if ($_SESSION['puesto'] == 0) {
                                    $sql = 'SELECT * FROM usuario';
                                    $qry = $pdo->prepare($sql);
                                    $qry->execute();
                                    $rows = $qry->fetchall(PDO::FETCH_ASSOC);
                                    foreach ($rows as $row) {
                                        echo "<tr>" .
                                            "<td>" . $row["usuarioId"] . "</td>" .
                                            "<td>" . $row["nombre"] . "</td>" .
                                            "<td>" . $row["usuario"] . "</td>" .
                                            "<td>" . ($row["puesto"] == 0 ? 'Administrador' : 'Coordinador') . "</td>" .
                                            "<td>" . ($row["carrera"] == null ? '' : $row["carrera"]) . "</td>" .
                                            "</tr>";
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div id="datos-egresado" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Información del egresado</h4>
            </div>
            <div class="modal-body">
                <input id="egresadoId" type="hidden" name="egresadoId" value=""/>
                <div class="row">
                    <div class="col-sm-3">
                        <img id="img-egre" width="120" height="120" class="mini-img" src="img/user.png">
                    </div>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="form-title">Codigo</label>
                                <input class="form-control form-input" type="tex" id="codigo" disabled>
                            </div>
                            <div class="col-sm-8">
                                <label class="form-title">Nombre</label>
                                <input class="form-control form-input" type="tex" id="nombre" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label class="form-title">Domicilio de origen</label>
                                <input class="form-control form-input" type="tex" id="dOrigen" disabled>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-title">Ciudad de origen</label>
                                <input class="form-control form-input" type="tex" id="cOrigen" disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <label class="form-title">C.P. Origen</label>
                        <input class="form-control form-input" type="text" id="cpOrigen" size="15" disabled>
                    </div>
                    <div class="col-sm-4">
                        <label class="form-title">Estado de origen</label>
                        <input class="form-control form-input" type="text" id="eOrigen" disabled>
                    </div>
                    <div class="col-sm-4">
                        <label class="form-title">País de origen</label>
                        <input class="form-control form-input" type="text" id="pOrigen" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <label class="form-title">Domicilio actual</label>
                        <input class="form-control form-input" type="tex" id="dActual" disabled>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-title">Ciudad actual</label>
                        <input class="form-control form-input" type="text" id="cActual" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <label class="form-title">Estado actual</label>
                        <input class="form-control form-input" type="text" id="eActual" disabled>
                    </div>
                    <div class="col-sm-4">
                        <label class="form-title">País actual</label>
                        <input class="form-control form-input" type="text" id="pActual" disabled>
                    </div>
                    <div class="col-sm-4">
                        <label class="form-title">C.P. Actual</label>
                        <input class="form-control form-input" type="text" id="cpActual" name="cpActual" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <label class="form-title">Fecha de nacimiento</label>
                        <input class="form-control" type="date" id="fechaN" disabled>
                    </div>
                    <div class="col-sm-4">
                        <label class="form-title">Sexo</label>
                        <input class="form-control" type="text" id="sexo" disabled>
                    </div>
                    <div class="col-sm-4">
                        <label class="form-title">Teléfono</label>
                        <input class="form-control form-input" type="tel" id="tel" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-5">
                        <label class="form-title">Usuario</label>
                        <input class="form-control form-input" type="text" id="usuarioEgre" disabled>
                    </div>
                    <div class="col-sm-7">
                        <label class="form-title">E-Mail</label>
                        <input class="form-control form-input" type="text" id="email" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-7">
                        <label class="form-title">Carrera</label><br>
                        <input class="form-control form-input" type="text" id="carrera" disabled>
                    </div>
                    <div class="col-sm-5">
                        <label class="form-title">Estatus de egreso </label>
                        <input class="form-control form-input" type="text" id="estatus" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <label class="form-title">Año de ingreso</label>
                        <input class="form-control form-input" type="text" id="anioI" disabled>
                    </div>
                    <div class="col-sm-3">
                        <label class="form-title">Ciclo de ingreso</label>
                        <input class="form-control form-input" type="text" id="cicloI" disabled>
                    </div>
                    <div class="col-sm-3">
                        <label class="form-title">Año de egreso</label>
                        <input class="form-control form-input" type="text" id="anioE" disabled>
                    </div>
                    <div class="col-sm-3">
                        <label class="form-title">Ciclo de egreso</label>
                        <input class="form-control form-input" type="text" id="cicloE" disabled>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div id="datos-carrera" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Datos de carrera</h4>
            </div>
            <div class="modal-body">
                <input id="id_carreras" type="hidden" name="id_carreras" value=""/>
                <div class="row">
                    <div class="col-sm-8">
                        <label class="form-title">Nombre</label>
                        <input class="form-control form-input" type="text" id="nomCar" placeholder="Nombre">
                    </div>
                    <div class="col-sm-4">
                        <label class="form-title">Tipo</label>
                        <select class="form-control form-input" id="tipoCar">
                            <option value="Licenciatura">Licenciatura</option>
                            <option value="Ingeniería">Ingeniería</option>
                            <option value="Técnico Superior Universitario">Técnico Superior Universitario</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="eliminarCar" type="submit" class="btn btn-danger" onclick="deleteCar()">Eliminar</button>
                <button id="guardarCar" type="submit" class="btn btn-primary" onclick="addCar()">Guardar</button>
                <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div id="datos-usuario" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Datos de Usuario</h4>
            </div>
            <div class="modal-body">
                <input id="usuarioId" type="hidden" name="usuarioId" value=""/>
                <div class="row">
                    <div class="col-sm-7">
                        <label class="form-title">Nombre</label>
                        <input class="form-control form-input" type="text" id="nombreUsu" placeholder="Nombre">
                    </div>
                    <div class="col-sm-5">
                        <label class="form-title">Usuario</label>
                        <input class="form-control form-input" type="text" id="usuario" placeholder="Usuario">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <label class="form-title">Contraseña</label>
                        <input class="form-control form-input" type="password" id="pass" placeholder="Contraseña">
                    </div>
                    <div class="col-sm-6">
                        <label class="form-title">Confirmación</label>
                        <input class="form-control form-input" type="password" id="conf" placeholder="Confirmación">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-5">
                        <label class="form-title">Puesto</label>
                        <select id="puesto" class="form-control  form-input">
                            <option value="0">Administrador</option>
                            <option value="1">Cordinador</option>
                        </select>
                    </div>
                    <div class="col-sm-7">
                        <label class="form-title" id="carreraUsuL">Carrera</label>
                        <select class="form-control  form-input" id="carreraUsu">>
                            <optgroup label="Licenciaturas">
                                <?php
                                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $sql = $pdo->prepare('SELECT `carreras` FROM `carreras` WHERE tipo = "Licenciatura";');
                                $sql->execute();;
                                while ($valor = $sql->fetch()) {
                                    if ($egresado['carrera'] != $valor['carreras']) {
                                        echo '<option value="' . $valor[carreras] . '">' . $valor[carreras] . '</option>';
                                    } else {
                                        echo '<option value="' . $valor[carreras] . '" selected>' . $valor[carreras] . '</option>';
                                    }
                                }
                                ?>
                            </optgroup>
                            <optgroup label="Ingenerias">
                                <?php
                                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $sql = $pdo->prepare('SELECT `carreras` FROM `carreras` WHERE tipo = "Ingeniería";');
                                $sql->execute();;
                                while ($valor = $sql->fetch()) {
                                    if ($egresado['carrera'] != $valor['carreras']) {
                                        echo '<option value="' . $valor[carreras] . '">' . $valor[carreras] . '</option>';
                                    } else {
                                        echo '<option value="' . $valor[carreras] . '" selected>' . $valor[carreras] . '</option>';
                                    }
                                }
                                ?>
                            </optgroup>
                            <optgroup label="Técnico Superior Universitario">
                                <?php
                                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $sql = $pdo->prepare('SELECT `carreras` FROM `carreras` WHERE tipo = "Técnico Superior Universitario";');
                                $sql->execute();;
                                while ($valor = $sql->fetch()) {
                                    if ($egresado['carrera'] != $valor['carreras']) {
                                        echo '<option value="' . $valor[carreras] . '">' . $valor[carreras] . '</option>';
                                    } else {
                                        echo '<option value="' . $valor[carreras] . '" selected>' . $valor[carreras] . '</option>';
                                    }
                                }
                                ?>
                            </optgroup>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="eliminarUsu" type="submit" class="btn btn-danger" onclick="deleteUsu()">Eliminar</button>
                <button id="guardarUsu" type="submit" class="btn btn-primary" onclick="addUsu()">Guardar</button>
                <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- modal dialog -->
<div id="editarEmpleo" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width: 1200px;">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Empleos</h4>

            </div>
            <div class="modal-body">


                <div class="row">

                    <div class="col-sm-12">

                        <label class="form-title" style="padding-top:5px;">Historial de Empleos</label>
                        <div class="table-responsive">
                            <table id="jobTable" class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Empresa</th>
                                    <th>Puesto</th>
                                    <th>Direccion</th>
                                    <th>Ciudad</th>
                                    <th>Estado</th>
                                    <th>Pais</th>
                                    <th>Telefono</th>
                                    <th>Jefe inmediato</th>
                                    <th>Año de inicio</th>
                                    <th>Fin del empleo</th>
                                </tr>
                                </thead>
                                <tbody id="empleoTa">
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<script>
    function puestoChange() {
        if (puesto.value == 0) {
            document.getElementById('carreraUsuL').style.display = 'none';
            document.getElementById('carreraUsu').style.display = 'none';
            document.getElementById('carreraUsu').value = null;
        } else {
            document.getElementById('carreraUsuL').style.display = '';
            document.getElementById('carreraUsu').style.display = '';
        }
    }

    var puesto = document.getElementById('puesto');
    puesto.onchange = function () {
        puestoChange()
    };

    function hideForm(idForm, idButton) {
        document.getElementById('egresados').style.display = "none";
        document.getElementById('empleos').style.display = "none";
        document.getElementById('reportes').style.display = "none";
        document.getElementById('cuenta').style.display = "none";

        <?php
        if ($_SESSION['puesto'] == 0) {
            echo 'document.getElementById(\'carreras\').style.display = "none";
            document.getElementById(\'cuentas\').style.display = "none";';
        }
        ?>

        document.getElementById('bEgresados').classList.remove('active');
        document.getElementById('bEmpleos').classList.remove('active');
        document.getElementById('bReportes').classList.remove('active');
        document.getElementById('bCuenta').classList.remove('active');

        <?php
        if ($_SESSION['puesto'] == 0) {
            echo 'document.getElementById(\'bCarreras\').classList.remove(\'active\');
            document.getElementById(\'bCuentas\').classList.remove(\'active\');';
        }
        ?>


        document.getElementById(idForm).style.display = "block";
        document.getElementById(idButton).classList.add('active');
    }


</script>

<script src="js/funciones.js"></script>


<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script src='https://www.google.com/recaptcha/api.js?hl=es'></script>

<script src='js/trabajos.js'></script>
<script src='js/buscarTrabajo.js'></script>
<script src='js/plantilla.js'></script>

</body>

</html>
