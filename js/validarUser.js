alert("js al 100");
function validar() {
    let nombre = document.getElementById('nombre').valueOf();
    let apellido = document.getElementById('apellidp').value();
    let apellido2 = document.getElementById('apellido2').value();
    let codigo = document.getElementById('codigo').value();
    let usuario = document.getElementById('usuario').value();
    let correo = document.getElementById('correo').value();
    var correos= /\w+@\w+\.+\[a-z]/;
    var nombres= /\w/;
    if (nombre === "" || apellido === "" || apellido2 === "" || usuario === "" || correo === "") {
        alert("porfavor completa el formulario");
        return false;
    }
    else if (nombre.length > 30) {
        alert("el nombre es muy largo");
        return false;
    }
    else if (apellido2.length > 30) {
        alert("apellido demasiado largo");
        return false;
    }
    else if (apellido.length > 30) {
        alert("apellido demasiado largo");
        return false;
    }
    else if (codigo.length > 20) {
        alert("el codigo es muy largo");
        return false;
    }
    else if (usuario.length > 45) {
        alert("el nombre de usuario es muy largo");
        return false;
    }
    else if (correo.length > 100) {
        alert("el correo es muy largo ");
        return false;
    }
    else if (!correos.test(correo)) {
        alert("Porfavor ingresa un correo valido");
        return false;
    }
}
/*
document.getElementById("nombre").onkeypress = function (e) {
    var chr = String.fromCharCode(e.which);
    var key = e.keyCode || e.charCode;
    if (key == 8 || key == 46)
        return false;

    else if ("1234567890qwertyuioplkjhgfdsazxcvbnmQWERTYUIOPLKJHGFDSAZXCVBNM".indexOf(chr) < 0)
        return false;
};

document.getElementById("apellidp").onkeypress = function (e) {
    var chr2 = String.fromCharCode(e.which);
    if ("1234567890qwertyuioplkjhgfdsazxcvbnmQWERTYUIOPLKJHGFDSAZXCVBNM".indexOf(chr2) < 0)
        return false;
};

document.getElementById("apellido2").onkeypress = function (e) {
    var chr3 = String.fromCharCode(e.which);
    if ("1234567890qwertyuioplkjhgfdsazxcvbnmQWERTYUIOPLKJHGFDSAZXCVBNM".indexOf(chr3) < 0)
        return false;
};

document.getElementById("codigo").onkeypress = function (e) {
    var chr4 = String.fromCharCode(e.which);
    if ("1234567890qwertyuioplkjhgfdsazxcvbnmQWERTYUIOPLKJHGFDSAZXCVBNM".indexOf(chr4) < 0)
        return false;
};

document.getElementById("correo").onkeypress = function (e) {
    var chr4 = String.fromCharCode(e.which);
    if ("1234567890qwertyuioplkjhgfdsazxcvbnmQWERTYUIOPLKJHGFDSAZXCVBNM.-_@".indexOf(chr4) < 0)
        return false;
};




document.getElementById("usuario").onkeypress = function (e) {
    var chr4 = String.fromCharCode(e.which);
    if ("1234567890qwertyuioplkjhgfdsazxcvbnmQWERTYUIOPLKJHGFDSAZXCVBNM.-_@;:?~!#$%&".indexOf(chr4) < 0)
        return false;
};
*/

