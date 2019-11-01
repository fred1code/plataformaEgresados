function openMessage(sms) {
    document.getElementById("menssage").innerHTML = sms;
    window.history.replaceState({}, document.title, "dashboard.php");
    $("#messagem").modal();
}
function openAdd() {
    $("#agregarEmpleo").modal();
}
var table = document.getElementById('jobTable');

var anioInicio = $("#anioInicio");
var anioFin = $("#anioFin");
for (var i = 1; i < table.rows.length; i++) {
    // console.log(entro);
    table.rows[i].onclick = function () {
        console.log(this.rowIndex);
        $.ajax({
            url: 'php/datos.php',
            data: {
                action: 'getDatos',
                egre_Id: this.cells[0].innerHTML
            },
            type: 'POST',
            success: function (output) {

                if (output != false) {
                    var valor = '';
                    for (var key in output) {
                        valor += `<tr>
     <td>${output[key].nombreEmpresa}</td>
     <td>${output[key].puesto}</td>
     <td>${output[key].direccion}</td>
     <td>${output[key].ciudad}</td>
     <td>${output[key].estado}</td>
     <td>${output[key].pais}</td>
     <td>${output[key].telefono}</td>
     <td>${output[key].jefeInmediato}</td>
     <td>${output[key].anioInicio}</td>
     <td>${output[key].anioFin} </td>
          </tr>`;
                    }
                }
                else {
                    valor += "<tr>" +
                        "<td>" + "No tiene trabajos registrados" + "</td>" +
                        "<tr>";
                }
                $("#empleoTa").html(valor);
                $("#editarEmpleo").modal();
            }
        });
    }
}; 