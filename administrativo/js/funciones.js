function agregarCarrera() {
    document.getElementById('tipoCar').disabled = false;
    document.getElementById('nomCar').disabled = false;
    document.getElementById('nomCar').value = '';
    document.getElementById('tipoCar').value = 'Licenciatura';
    document.getElementById('guardarCar').style.display = '';
    document.getElementById('eliminarCar').style.display = 'none';
    $('#datos-carrera').modal();
}

function addCar() {
    $.ajax({
        url: 'php/carrera.php',
        data: {
            action: 'agregar',
            nomCar: document.getElementById('nomCar').value,
            tipoCar: document.getElementById('tipoCar').value
        },
        type: 'POST',
        success: function (output) {
            console.log(output);
            if (output > 0) {
                location.reload();
            }
        }
    });
}

function deleteCar() {
    $.ajax({
        url: 'php/carrera.php',
        data: {
            action: 'eliminar',
            id_carreras: document.getElementById('id_carreras').value
        },
        type: 'POST',
        success: function (output) {
            console.log(output);
            if (output > 0) {
                location.reload();
            }
        }
    });
}

function agregarUsuario() {
    document.getElementById('nombreUsu').value = '';
    document.getElementById('usuario').value = '';
    document.getElementById('pass').value = '';
    document.getElementById('conf').value = '';

    document.getElementById('guardarUsu').style.display = '';
    document.getElementById('eliminarUsu').style.display = 'none';
    document.getElementById('puesto').value = '0';
    puestoChange();
    $('#datos-usuario').modal();
}

function addUsu() {

    var pass = document.getElementById('pass');
    var conf = document.getElementById('conf');

    if (pass.value != conf.value) {
        alert('Las contraseñas no coinciden');
        return;
    }

    var secure = pass.value.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/);
    if (!secure) {
        alert('Ingresa mayúsculas, minúsculas, números, mínimo 8 caracteres.(No se permiten caracteres especiales)');
        return;
    }

    $.ajax({
        url: 'php/usuario.php',
        data: {
            action: 'agregar',
            nombre: document.getElementById('nombreUsu').value,
            usuario: document.getElementById('usuario').value,
            pass: document.getElementById('pass').value,
            puesto: document.getElementById('puesto').value,
            carrera: document.getElementById('carreraUsu').value
        },
        type: 'POST',
        success: function (output) {
            console.log(output);
            if (output > 0) {
                location.reload();
            } else if (output == -1) {
                alert('El usuario ya existe');
            }
        }
    });
}

function deleteUsu() {
    $.ajax({
        url: 'php/usuario.php',
        data: {
            action: 'eliminar',
            usuarioId: document.getElementById('usuarioId').value
        },
        type: 'POST',
        success: function (output) {
            console.log(output);
            if (output > 0) {
                location.reload();
            }
        }
    });
}

var egreTable = document.getElementById('egreTable');

for (var i = 1; i < egreTable.rows.length; i++) {
    egreTable.rows[i].onclick = function () {
        console.log(this.rowIndex);
        $.ajax({
            url: 'php/egresados.php',
            data: {
                action: 'getInfo',
                egreId: this.cells[0].innerHTML
            },
            type: 'POST',
            success: function (output) {
                console.log(output);
                document.getElementById('egresadoId').value = output.egre_Id;
                document.getElementById('nombre').value = output.nombre;
                document.getElementById('codigo').value = output.codigo + "";
                document.getElementById('dOrigen').value = output.domicilioOrigen;
                document.getElementById('cOrigen').value = output.ciudadOrigen;
                document.getElementById('eOrigen').value = output.estadoOrigen;
                document.getElementById('pOrigen').value = output.paisOrigen;
                document.getElementById('cpOrigen').value = output.cpOrigen;
                document.getElementById('dActual').value = output.domicilioActual;
                document.getElementById('cActual').value = output.ciudadActual;
                document.getElementById('eActual').value = output.estadoActual;
                document.getElementById('pActual').value = output.paisActual;
                document.getElementById('cpActual').value = output.cpActual;
                document.getElementById('fechaN').value = output.fecha_nacimiento;
                document.getElementById('sexo').value = output.sexo;
                document.getElementById('usuarioEgre').value = output.usuario;
                document.getElementById('email').value = output.email;
                document.getElementById('tel').value = output.telefono;
                document.getElementById('carrera').value = output.carrera;
                document.getElementById('estatus').value = output.estatusEgreso;
                document.getElementById('anioI').value = output.anioIngreso;
                document.getElementById('cicloI').value = output.cicloIngreso;
                document.getElementById('anioE').value = output.anioEgreso;
                document.getElementById('cicloE').value = output.cicloEgreso;

                if (output.img == null) {
                    document.getElementById("img-egre").src = "img/user.png";
                } else {
                    document.getElementById("img-egre").src = "data:image/png;base64," + output.img;
                }

                $("#datos-egresado").modal();
            }
        });
    }
};

var carTable = document.getElementById('carTable');

for (var i = 1; i < carTable.rows.length; i++) {
    carTable.rows[i].onclick = function () {
        document.getElementById('tipoCar').disabled = true;
        document.getElementById('nomCar').disabled = true;
        document.getElementById('id_carreras').value = this.cells[0].innerHTML;
        document.getElementById('nomCar').value = this.cells[1].innerHTML;
        document.getElementById('tipoCar').value = this.cells[2].innerHTML;
        document.getElementById('guardarCar').style.display = 'none';
        document.getElementById('eliminarCar').style.display = '';
        $('#datos-carrera').modal();
    }
};

var usuTable = document.getElementById('usuTable');

for (var i = 1; i < usuTable.rows.length; i++) {
    usuTable.rows[i].onclick = function () {
        $.ajax({
            url: 'php/usuario.php',
            data: {
                action: 'getInfo',
                usuarioId: this.cells[0].innerHTML
            },
            type: 'POST',
            success: function (output) {
                console.log(output);
                document.getElementById('usuarioId').value = output.usuarioId;
                document.getElementById('nombreUsu').value = output.nombre;
                document.getElementById('usuario').value = output.usuario;
                document.getElementById('puesto').value = output.puesto;
                document.getElementById('carreraUsu').value = output.carrera;

                document.getElementById('guardarUsu').style.display = 'none';
                document.getElementById('eliminarUsu').style.display = '';
                puestoChange();
                $('#datos-usuario').modal();
            }
        });
    }
};

function validatePassword() {
    var password = document.getElementById("uPassNew")
    var confirm_password = document.getElementById("uPassCon");

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

puestoChange();