<?php
session_start();
if(!isset($_SESSION['egre_id'])){
    header("Location: index");
    session_destroy();
}

require_once('php/conn.php');
    
$query = $pdo->prepare('SELECT * FROM egresado WHERE egre_Id =?;');
$query->execute(array($_SESSION['egre_id']));
$egresado = $query->fetch(PDO::FETCH_ASSOC);

$query = $pdo->prepare('SELECT * FROM empleo e WHERE e.egresadoId =? ORDER BY empleoId DESC LIMIT 1;');
$query->execute(array($_SESSION['egre_id']));
$count = $query -> rowCount();

if($count == 1){
   $empleo = $query->fetch(PDO::FETCH_ASSOC);
}

echo '<script>console.log("'.$_SERVER['SERVER_NAME'].'");</script>';

?>

    <!DOCTYPE HTML>
    <html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Perfil de egresado</title>
        <link rel="shortcut icon" href="img/logo.png">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

        <link rel="stylesheet" href="css/main.css">

        <style>
            .mini-img {
                border-radius: 10px;
                display: block;
                margin: 10px auto 10px;
                ;
            }

            .nombre {
                text-align: center;
                display: block;
                color: #808080;
            }

        </style>
    </head>

    <body>

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
                        <li><a><span class="glyphicon glyphicon-user"></span><?php echo ' ' . $_SESSION['usuario']; ?></a></li>
                        <li><a href="php/logOut"><span class="glyphicon glyphicon-log-out"></span> Cerrar sesión</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid" style="margin-top: 70px; padding: 15px;">
            <div class="row">
                <div class="col-sm-3" style="padding-top: 10px;">
                    <div class="row" style="margin: 10px auto 5px;">
                        <?php
                            if($egresado['img'] == null) {
                                echo '<img height="100" class="mini-img" src="img/user.png">';
                            }else{
                                echo '<img height="100" class="mini-img" src="data:image/png;base64,' . $egresado['img'] . '" alt=""/>';
                            }
                        ?>

                            <label class="nombre"><?php echo $egresado['nombre'] ?></label>
                    </div>
                    <div class="row" style="margin: 10px auto 5px;">
                        <ul class="nav nav-pills nav-stacked">
                            <li id="bPersonal" onclick="hideForm('personales', 'bPersonal')" class="active"><a>Información personal</a></li>
                            <li id="bAcademicos" onclick="hideForm('academicos', 'bAcademicos')"><a>Información académica</a></li>
                            <li id="bLaboral" onclick="hideForm('laboral', 'bLaboral')"><a>Información laboral</a></li>
                            <li id="bConfiguracion" onclick="hideForm('configuracion', 'bConfiguracion')"><a>Configuración de cuenta</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-9" style="border-left-style: solid; border-width:1px; border-color:#C7C7C7;">
                    <div id="personales" style="display: block;">
                        <h3>Información personal</h3>
                        <form action="php/updatePersonal.php" method="POST">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label class="form-title">Nombre</label>
                                    <input class="form-control form-input" type="text" id="nombres" placeholder="Nombre"  name="nombre" maxlength="90" value="<?php echo $egresado['nombre'];?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <label class="form-title">Domicilio de origen</label>
                                    <input class="form-control form-input" type="text" name="dOrigen" placeholder="Domicilio origen" maxlength="100" value="<?php echo $egresado['domicilioOrigen'];?>">
                                </div>
                                <div class="col-sm-3">
                                    <label class="form-title">Ciudad de origen</label>
                                    <input class="form-control form-input" type="text" name="cOrigen" placeholder="Ciudad de origen " maxlength="100" value="<?php echo $egresado['ciudadOrigen'];?>">
                                </div>
                                <div class="col-sm-2">
                                    <label class="form-title">Estado de origen</label>
                                    <input class="form-control form-input" type="text" name="eOrigen" placeholder="Estado origen" maxlength="100" value="<?php echo $egresado['estadoOrigen'];?>">
                                </div>
                                <div class="col-sm-2">
                                    <label class="form-title">País de origen</label>
                                    <input class="form-control form-input" type="text" name="pOrigen" placeholder="País de origen" maxlength="45" value="<?php echo $egresado['paisOrigen'];?>">
                                </div>
                                <div class="col-sm-2">
                                    <label class="form-title">C.P. Origen</label>
                                    <input class="form-control form-input" type="text" name="cpOrigen" size="15" placeholder="C.P. origen" maxlength="15" value="<?php echo $egresado['cpOrigen'];?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <label class="form-title">Domicilio actual</label>
                                    <input class="form-control form-input" type="tex" name="dActual" placeholder="Domicilio actual" maxlength="100" value="<?php echo $egresado['domicilioActual'];?>">
                                </div>
                                <div class="col-sm-3">
                                    <label class="form-title">Ciudad actual</label>
                                    <input class="form-control form-input" type="text" name="cActual" placeholder="Ciudad actual" maxlength="100" value="<?php echo $egresado['ciudadActual'];?>">
                                </div>
                                <div class="col-sm-2">
                                    <label class="form-title">Estado actual</label>
                                    <input class="form-control form-input" type="text" name="eActual" placeholder="Estado actual" maxlength="100" value="<?php echo $egresado['estadoActual'];?>">
                                </div>
                                <div class="col-sm-2">
                                    <label class="form-title">País actual</label>
                                    <input class="form-control form-input" type="text" name="pActual" placeholder="País actual" maxlength="45" value="<?php echo $egresado['paisActual'];?>">
                                </div>
                                <div class="col-sm-2">
                                    <label class="form-title">C.P. Actual</label>
                                    <input class="form-control form-input" type="text" name="cpActual" size="10" placeholder="C.P. actual" maxlength="15" value="<?php echo $egresado['cpActual'];?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <label class="form-title">Fecha de nacimiento</label>
                                    <input class="form-control" type="date" name="fechaN" value="<?php echo $egresado['fecha_nacimiento'];?>">
                                </div>
                                <div class="col-sm-3">
                                    <label class="form-title">Sexo</label>
                                    <select class="form-control form-input" name="sexo">
                                    <?php
                                        if($egresado['sexo'] == 'Masculino'){
                                            $masculino = 'selected';
                                        }else{
                                            $femenino = 'selected';
                                        }
                                         echo '<option value="Masculino"'.$masculino.'>Masculino</option>
                                            <option value="Femenino"'.$femenino.'>Femenino</option>';
                                    ?>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-title">Teléfono</label>
                                    <input class="form-control form-input" type="tel" name="tel" placeholder="Teléfono" maxlength="20" value="<?php echo $egresado['telefono'];?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-3" style="padding-top:10px;">
                                    <button class="btn btn-primary" type="submit">Actualizar información personal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="academicos" style="display: none;">
                        <h3 class="t3">Información académica</h3>
                        <form action="php/updateSchool.php" method="POST">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label class="form-title">Código de estudiante</label>
                                    <input type="text" class="form-control  form-input" name="cod" placeholder="Código de estudiante" maxlength="20" value="<?php echo $egresado['codigo'];?>">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-title">Carrera</label><br>
                                    <select class="form-control  form-input" name="carrera">
                                        <optgroup label="Licenciaturas">
                                            <?php
                                                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                                $sql = $pdo->prepare('SELECT `carreras` FROM `carreras` WHERE tipo = "Licenciatura";');
                                                $sql->execute();;
                                                while( $valor = $sql->fetch() ){
                                                    if($egresado['carrera'] != $valor['carreras']){
                                                        echo '<option value="'.$valor[carreras].'">'.$valor[carreras].'</option>';
                                                    }else{
                                                        echo '<option value="'.$valor[carreras].'" selected>'.$valor[carreras].'</option>';
                                                    }
                                                }                      
                                            ?>
                                        </optgroup>
                                        <optgroup label="Ingenerias">
                                            <?php
                                                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                                $sql = $pdo->prepare('SELECT `carreras` FROM `carreras` WHERE tipo = "Ingeniería";');
                                                $sql->execute();;
                                                while( $valor = $sql->fetch() ){
                                                    if($egresado['carrera'] != $valor['carreras']){
                                                        echo '<option value="'.$valor[carreras].'">'.$valor[carreras].'</option>';
                                                    }else{
                                                        echo '<option value="'.$valor[carreras].'" selected>'.$valor[carreras].'</option>';
                                                    }
                                                }                      
                                            ?>
                                        </optgroup>
                                        <optgroup label="Técnico Superior Universitario">
                                            <?php
                                                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                                $sql = $pdo->prepare('SELECT `carreras` FROM `carreras` WHERE tipo = "Técnico Superior Universitario";');
                                                $sql->execute();;
                                                while( $valor = $sql->fetch() ){
                                                    if($egresado['carrera'] != $valor['carreras']){
                                                        echo '<option value="'.$valor[carreras].'">'.$valor[carreras].'</option>';
                                                    }else{
                                                        echo '<option value="'.$valor[carreras].'" selected>'.$valor[carreras].'</option>';
                                                    }
                                                   }                      
                                            ?>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <label class="form-title">Estatus de egreso </label>
                                    <select class="form-control form-input" name="estatus">
                                        <?php
                                            if($egresado['estatusEgreso'] == 'Egresado'){
                                                $estatusEgresado = 'selected';
                                            }else if($egresado['estatusEgreso'] == 'Pasante'){
                                                $estatusPasante = 'selected';
                                            }else if($egresado['estatusEgreso'] == 'Titulado'){
                                                $estatusTitulado = 'selected';
                                            }else if($egresado['estatusEgreso'] == 'Graduado'){
                                                $estatusGraduado = 'selected';
                                            }
                                            echo '<option value="Egresado"'.$estatusEgresado.'>Egresado</option>
                                                    <option value="Graduado"'.$estatusGraduado.'>Graduado</option>
                                                    <option value="Pasante"'.$estatusPasante.'>Pasante</option>
                                                    <option value="Titulado"'.$estatusTitulado.'>Titulado</option>';
                                        ?> 
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-2">
                                    <label class="form-title">Año de ingreso</label>
                                    <select class="form-control  form-input" name="anioI">
                                        <?php
                                            $hoy = date("Y");
                                            for ($i = $hoy ; $i >= 1994 ; $i--) {
                                                if ( $i == $egresado['anioIngreso']) {
                                                    $selected='selected';	
                                                }else{
                                                    $selected='';
                                                }
                                                echo '<option '. $selected .'  value = "'.$i.'" > '.$i.' </option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <label class="form-title">Ciclo de ingreso</label>
                                    <select class="form-control  form-input" name="cicloI">
                                        <?php
                                            if($egresado['cicloIngreso'] == 'A'){
                                                $cicloA = 'selected';
                                            }else if($egresado['cicloIngreso'] == 'B'){
                                                $cicloB = 'selected';
                                            }
                                            echo '<option value="A"'.$cicloA.'>A</option>
                                                <option value="B"'.$cicloB.'>B</option>';
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-2">
                                    <label class="form-title">Año de egreso</label>
                                    <select class="form-control  form-input" name="anioE">
                                        <?php
                                            $hoy = date("Y");
                                            for ($i = $hoy ; $i >= 1994 ; $i--) {
                                                if ( $i == $egresado['anioEgreso']) {
                                                    $selected='selected';	
                                                }else{
                                                    $selected='';
                                                }
                                                echo '<option '. $selected .'  value = "'.$i.'" > '.$i.' </option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <label class="form-title">Ciclo de egreso</label>
                                    <select class="form-control  form-input" name="cicloE">
                                        <?php 
                                            if($egresado['cicloEgreso'] == 'A'){
                                                $cicloA = 'selected';
                                            }else if($egresado['cicloEgreso'] == 'B'){
                                                $cicloB = 'selected';
                                            }
                                            echo '<option value="A"'.$cicloA.'>A</option>
                                                <option value="B"'.$cicloB.'>B</option>';
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-3" style="padding-top:10px;">
                                    <button type="submit" class="btn btn-primary">Actualizar información escolar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="laboral" style="display: none;">
                        <h3 class="t3">Información laboral</h3>
                            <form action="php/updateTrabajo" method="POST">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <label class="form-title" style="padding-top:10px;">¿Trabajas?</label>
                                        <select class="form-control form-input" name="trabaja">
                                            <?php
                                                if($egresado['trabaja'] == 1){
                                                    echo '<option value="0">NO</option>
                                                    <option selected value="1">SI</option>';
                                                }else if($egresado['trabaja'] == 0){
                                                    echo '<option selected value="0">NO</option>
                                                    <option value="1" >SI</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="submit" class="btn btn-primary" style="margin-top: 35px;">Actualizar información</button>
                                    </div>
                                </div>
                            </form>
                        <div class="row">
                            <div class="col-sm-2" style="margin: 15px 0 10px;">
                                <button type="submit" class="btn btn-primary" onclick="openAdd()">Agregar Empleo</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="form-title" style="padding-top:10px;">Historial de Empleos</label>
                                <div class="table-responsive">
                                    <table id="jobTable" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Empresa</th>
                                                <th>Puesto</th>
                                                <th>Año de inicio</th>
                                                <th>Fin del empleo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $qry = $pdo->prepare('SELECT empleoId ,nombreEmpresa, puesto, anioInicio, anioFin FROM empleo e WHERE e.egresadoId =? ORDER BY empleoId;');
                                            $qry->execute(array($_SESSION['egre_id']));
                                            $rows = $qry->fetchall(PDO::FETCH_ASSOC);

                                            foreach($rows as $row){
                                                echo "<tr>".
                                                   "<td>".$row["empleoId"]."</td>".
                                                   "<td>".$row["nombreEmpresa"]."</td>".
                                                   "<td>".$row["puesto"]."</td>".
                                                   "<td>".$row["anioInicio"]."</td>".
                                                   "<td>".($row["anioFin"] == 0 ? "Actual" : $row["anioFin"])."</td>".
                                                   "</tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="configuracion" style="display: none;">
                        <h3 class="t3">Configuración de cuenta</h3>
                        <form action="php/updateMail.php" method="POST">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="form-title">Correo electrónico</label>
                                    <input type="text" class="form-control  form-input" name="email" placeholder="Correo electrónico" maxlength="100" value="<?php echo $egresado['email'];?>" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3" style="padding-bottom:20px;">
                                    <button type="submit" class="btn btn-primary">Actualizar correo</button>
                                </div>
                            </div>
                        </form>

                        <form action="php/updateUser.php" method="POST">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label class="form-title">Usuario</label>
                                    <input type="text" class="form-control  form-input" name="usuario" placeholder="Código del estudiante" maxlength="100" value="<?php echo $egresado['usuario'];?>" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3" style="padding-bottom:20px;">
                                    <button type="submit" class="btn btn-primary">Actualizar usuario</button>
                                </div>
                            </div>
                        </form>

                        <form action="php/updatePassword.php" method="POST">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label class="form-title"required>Contraseña</label>
                                    <input type="password" class="form-control  form-input" name="pass" placeholder="Contraseña" maxlength="100" required>
                                </div>
                                <div class="col-sm-3">
                                    <label class="form-title"required> Nueva contraseña</label>
                                    <input type="password" class="form-control  form-input" id="newpass" name="newpass" placeholder="Nueva contraseña" maxlength="100" required>
                                </div>
                                <div class="col-sm-3">
                                    <label class="form-title" required> Confirmación</label>
                                    <input type="password" class="form-control  form-input" id="confir" name="confir" placeholder="Confirmación" maxlength="100" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3" style="padding-bottom:20px;">
                                    <button type="submit" class="btn btn-primary">Cambiar contraseña</button>
                                </div>
                            </div>
                        </form>

                        <form action="php/updateImagen.php" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-sm-5" style="padding-bottom: 5px;">
                                    <label class="form-title">Foto de perfil</label>
                                    <input type="file" class="form-control" name="image" accept=".png, .jpg, .jpeg" required="requerida">
                                    <input type="text" name="txt" style="display: none;">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <button type="submit" class="btn btn-primary">Subir imágen</button>
                                </div>
                            </div>
                        </form>

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

        <div id="agregarEmpleo" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Agregar empleo</h4>
                    </div>
                    <div class="modal-body">
                    <form action="php/addJop.php" method="POST">
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="form-title">Nombre de la empresa</label>
                                <input class="form-control form-input" type="text" name="nombreEmpresa" placeholder="Nombre de la empresa" maxlength="80" required>
                            </div>                            
                        </div>
                        <div class="row">
                            <div class="col-sm-7">
                                <label class="form-title">Dirección de la empresa</label>
                                <input class="form-control form-input" type="text" name="direccion" placeholder="Dirección de la empresa" maxlength="80">
                            </div>
                            <div class="col-sm-5">
                                <label class="form-title">Teléfono de la empresa </label>
                                <input class="form-control form-input" type="tel" name="telefono" placeholder="Teléfono de la empresa" maxlength="20">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label class="form-title">Puesto desempeñado</label>
                                <input class="form-control form-input" type="text" name="puesto" placeholder="Puesto de trabajo" maxlength="45" required>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-title">Jefe inmediato</label>
                                <input class="form-control form-input" type="text" name="jefeInmediato" placeholder="Jefe inmediato" maxlength="45">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="form-title">Ciudad donde trabajas</label>
                                <input class="form-control form-input" type="text" name="ciudad" placeholder="Ciudad donde trabaja" maxlength="80" required>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-title">Estado donde trabajas</label>
                                <input class="form-control form-input" type="text" name="estado" placeholder="Estado donde trabajas" maxlength="80" required>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-title">País donde trabajas</label>
                                <input class="form-control form-input" type="text" name="pais" placeholder="País donde trabajas" maxlength="45" required>
                            </div>
                        </div>
                        <div class="row">
                             <div class="col-sm-4">
                                <label class="form-title">Año de inicio</label>
                                <select class="form-control form-input" name="anioInicio">
                                        <?php
                                            $hoy = date("Y");
                                            for ($i = $hoy ; $i >= 1994 ; $i--) {
                                                echo '<option value = "'.$i.'" > '.$i.' </option>';
                                            }
                                        ?>          
                                    </select>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-title">Fin del empleo</label>
                                <select class="form-control form-input" name="anioFin">
                                        <?php
                                            $hoy = date("Y");
                                            echo '<option value="0" >Actual</option>';
                                            for ($i = $hoy ; $i >= 1994 ; $i--) {
                                                echo '<option value="'.$i.'" >' . $i . '</option>';
                                            }
                                        ?>
                                    </select>
                            </div>
                            <div class="col-sm-4" style="padding-top: 25px;">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                    </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="editarEmpleo" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Editar empleo</h4>
                    </div>
                    <div class="modal-body">
                    <form action="php/editJop.php" method="POST">
                        <input id="empleoId" type="hidden" name="empleoId" value=""/>
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="form-title">Nombre de la empresa</label>
                                <input id="nombreEmpresa" class="form-control form-input" type="text" name="nombreEmpresa" placeholder="Nombre de la empresa" maxlength="80" required>
                            </div>                            
                        </div>
                        <div class="row">
                            <div class="col-sm-7">
                                <label class="form-title">Dirección de la empresa</label>
                                <input id="direccion" class="form-control form-input" type="text" name="direccion" placeholder="Dirección de la empresa" maxlength="80">
                            </div>
                            <div class="col-sm-5">
                                <label class="form-title">Teléfono de la empresa </label>
                                <input id="telefono"class="form-control form-input" type="tel" name="telefono" placeholder="Teléfono de la empresa" maxlength="20">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label class="form-title">Puesto desempeñado</label>
                                <input id="puesto" class="form-control form-input" type="text" name="puesto" placeholder="Puesto de trabajo" maxlength="45" required>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-title">Jefe inmediato</label>
                                <input id="jefe" class="form-control form-input" type="text" name="jefeInmediato" placeholder="Jefe inmediato" maxlength="45">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="form-title">Ciudad donde trabajas</label>
                                <input id="ciudad" class="form-control form-input" type="text" name="ciudad" placeholder="Ciudad donde trabaja" maxlength="80" required>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-title">Estado donde trabajas</label>
                                <input id="estado" class="form-control form-input" type="text" name="estado" placeholder="Estado donde trabajas" maxlength="80" required>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-title">País donde trabajas</label>
                                <input id="pais" class="form-control form-input" type="text" name="pais" placeholder="País donde trabajas" maxlength="45" required>
                            </div>
                        </div>
                        <div class="row">
                             <div class="col-sm-4">
                                <label class="form-title">Año de inicio</label>
                                <select id="anioInicio" class="form-control form-input" name="anioInicio">
                                    <?php
                                        $hoy = date("Y");
                                        for ($i = $hoy ; $i >= 1994 ; $i--) {
                                            echo '<option value = "'.$i.'" > '.$i.' </option>';
                                        }
                                    ?>          
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-title">Fin del empleo</label>
                                <select id="anioFin" class="form-control form-input" name="anioFin">
                                    <?php
                                        $hoy = date("Y");
                                        echo '<option value="0" >Actual</option>';
                                        for ($i = $hoy ; $i >= 1994 ; $i--) {
                                            echo '<option value="'.$i.'" >' . $i . '</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-4" style="padding-top: 25px;">
                                <button type="submit" class="btn btn-primary">Editar</button>
                            </div>
                        </div>
                    </form>
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
            function hideForm(idForm, idButton) {
                document.getElementById('personales').style.display = "none";
                document.getElementById('academicos').style.display = "none";
                document.getElementById('laboral').style.display = "none";
                document.getElementById('configuracion').style.display = "none";

                document.getElementById('bPersonal').classList.remove('active');
                document.getElementById('bAcademicos').classList.remove('active');
                document.getElementById('bLaboral').classList.remove('active');
                document.getElementById('bConfiguracion').classList.remove('active');

                document.getElementById(idForm).style.display = "";
                document.getElementById(idButton).classList.add('active');
            }


            var password = document.getElementById("newpass"),
                confirm_password = document.getElementById("confir");

            function validatePassword() {
                if (password.value != confirm_password.value) {
                    confirm_password.setCustomValidity("Las contraseñas no coinciden ");
                } else {
                    var secure = password.value.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/);
                    if (secure) {
                        confirm_password.setCustomValidity("");
                    } else {
                        confirm_password.setCustomValidity("Ingresa mayúsculas, minúsculas, números, mínimo 8 caracteres.(No se permiten caracteres especiales)");
                    }
                }
            }

            password.onchange = validatePassword;
            confirm_password.onkeyup = validatePassword;

            function openMessage(sms) {
                document.getElementById("menssage").innerHTML = sms;
                window.history.replaceState({}, document.title, "/egresados/profile");
                $("#messagem").modal();
            }

            function openAdd() {
                $("#agregarEmpleo").modal();
            }

            var table = document.getElementById('jobTable');
            var anioInicio = $("#anioInicio");
            var anioFin = $("#anioFin");

            for (var i = 1; i < table.rows.length; i++) {
                table.rows[i].onclick = function(){
                    console.log(this.rowIndex);
                    $.ajax({url: 'php/empleos.php',
                        data: {action: 'getEmpleo', empleoId: this.cells[0].innerHTML},
                        type: 'POST',
                        success: function(output) {
                            document.getElementById('empleoId').value = output.empleoId;
                            document.getElementById('nombreEmpresa').value = output.nombreEmpresa;
                            document.getElementById('direccion').value = output.direccion;
                            document.getElementById('telefono').value = output.telefono;
                            document.getElementById('puesto').value = output.puesto;
                            document.getElementById('jefe').value = output.jefeInmediato;
                            document.getElementById('ciudad').value = output.ciudad;
                            document.getElementById('estado').value = output.estado;
                            document.getElementById('pais').value = output.pais;
                            anioInicio.val(output.anioInicio);
                            anioFin.val(output.anioFin);
                            $("#editarEmpleo").modal();
                        }   
                    });
                }
            };

        </script>

        <?php 
        if(isset($_GET['message'])){
            echo '<script>
                openMessage("'.$_GET['message'].'");
            </script>';
        }
        ?>
        <script src="js/validarProfiles.js"></script>
    </body>

    </html>
