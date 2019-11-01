$(document).ready(function () {

    var consulta;

    //hacemos focus al campo de búsqueda
    $("#busquedaa").focus();

    //comprobamos si se pulsa una tecla
    $("#busquedaa").keyup(function (e) {

        //obtenemos el texto introducido en el campo de búsqueda
        consulta = $("#busquedaa").val();
        console.log(consulta);
        //hace la búsqueda

        $.ajax({
            type: "POST",
            url: "php/buscar.php",
            data: consulta,
            dataType: "json",

            error: function () {
                alert("error petición ajax");
            },
            success: function (data) {

                console.log(data);
                var valor = '';

                for (var key in data) {

                    if (data[key].trabaja == 1) {
                        data[key].trabaja = 'SI';
                    }
                    else {
                        data[key].trabaja = 'NO';
                    }
                    valor += `<tr>
    <td style ="display:none">${ data[key].egre_Id}</td>
     <td>${data[key].codigo}</td>
     <td>${data[key].nombre}</td>
     <td>${data[key].sexo}</td>
     <td>${data[key].telefono}</td>
     <td>${data[key].email}</td>
     <td>${data[key].carrera}</td>
     <td>${data[key].trabaja}</td>
        </tr>
     `;

                }
                $("#jobTable2").html(valor);
            }

        });


    });

});





/* function buscar(){
  
  var textoBusqueda = $("input#busquedaa").val();

console.log(textoBusqueda);

 
$.ajax({
   type: 'POST',
   url: 'php/buscar.php',
               data: 
             /  {
                   action: 'getDatos',
                    busqueda:$("input#busquedaa").val()
                   } 
                   ,
               
               
               
               success: function(output) {
                   console.log(output);
                      var valor='';

for (var key in output) {

 if(output[key].trabaja==1){
       output[key].trabaja='SI';
   }
   else{
       output[key].trabaja='NO';
   }
    valor += `<tr>
   <td style ="display:none">${ output[key].egre_Id}</td>
    <td>${output[key].codigo}</td>
    <td>${output[key].nombre}</td>
    <td>${output[key].sexo}</td>
    <td>${output[key].telefono}</td>
    <td>${output[key].email}</td>
    <td>${output[key].carrera}</td>
    <td>${output[key].trabaja}</td>
       </tr>
    `;  

   } 
    $("#jobTable2").html(valor);
              }
});
 
};  */

/* var textoBusqueda =$("input#busqueda").val();
if (textoBusqueda!="") {
    $.post("buscar.php",{valorBusqueda:textoBusqueda},function(mensaje) {
$("#resultadoBusqueda").html(mensaje);
}

    }); */







function llenar() {


    var valor = '<tr><td>fierro alv</td></tr>';


    $("#jobTable2").html(valor);


};
