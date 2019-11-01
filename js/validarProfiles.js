function validarP() {
    let nombres = document.getElementById('nombres').valueOf();

    if (nombres === "") {
        alert("porfavor completa el formulario");
        return false;
    }
}
document.getElementById("nombres").onkeypress = function (e) {
    var chr = String.fromCharCode(e.which);
    if ("1234567890qwertyuioplkjhgfdsazxcvbnmQWERTYUIOPLKJHGFDSAZXCVBNM".indexOf(chr) < 0)
        return false;
};