var tabla;
var tabla_ventas;
var tabla_ventas_mes;

//Función que se ejecuta al inicio
function init() {
  listar();
}

//Función Listar
function listar() {
  tabla = $("#ventas_data")
    .dataTable({
      aProcessing: true, //Activamos el procesamiento del datatables
      aServerSide: true, //Paginación y filtrado realizados por el servidor
      dom: "Bfrtip", //Definimos los elementos del control de tabla
      buttons: ["copyHtml5", "excelHtml5", "csvHtml5", "pdf"],
      ajax: {
        url: "../ajax/ventas.php?op=buscar_ventas",
        type: "get",
        dataType: "json",
        error: function (e) {
          console.log(e.responseText);
        },
      },
      bDestroy: true,
      responsive: true,
      bInfo: true,
      iDisplayLength: 10, //Por cada 10 registros hace una paginación
      order: [[0, "desc"]], //Ordenar (columna,orden)
      language: {
        sProcessing: "Procesando...",
        sLengthMenu: "Mostrar _MENU_ registros",
        sZeroRecords: "No se encontraron resultados",
        sEmptyTable: "Ningún dato disponible en esta tabla",
        sInfo: "Mostrando un total de _TOTAL_ registros",
        sInfoEmpty: "Mostrando un total de 0 registros",
        sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
        sInfoPostFix: "",
        sSearch: "Buscar:",
        sUrl: "",
        sInfoThousands: ",",
        sLoadingRecords: "Cargando...",
        oPaginate: {
          sFirst: "Primero",
          sLast: "Último",
          sNext: "Siguiente",
          sPrevious: "Anterior",
        },

        oAria: {
          sSortAscending:
            ": Activar para ordenar la columna de manera ascendente",
          sSortDescending:
            ": Activar para ordenar la columna de manera descendente",
        },
      }, //cerrando language
    })
    .DataTable();
}

$(document).on("click", ".detalle", function () {
  var numero_venta = $(this).attr("id");
  //Aqui hay que mandar el ID de la VENTA AL BOTON que creaste///////
  console.log(numero_venta);
  $('#btnimprimir').attr('href',"../fpdf182/tutorial/tuto1.php?id="+ numero_venta +"");
  /////////////////////////////////
  $.ajax({
    url: "../ajax/ventas.php?op=ver_detalle_cliente_venta",
    method: "POST",
    data: { numero_venta: numero_venta },
    cache: false,
    dataType: "json",
    success: function (data) {
      $("#cliente").html(data.cliente);
      $("#numero_venta").html(data.numero_venta);
      $("#cedula_cliente").html(data.cedula_cliente);
      $("#direccion").html(data.direccion);
      $("#fecha_venta").html(data.fecha_venta);
    },
  });
});

$(document).on("click", ".detalle", function () {
  //toma el valor del id
  var numero_venta = $(this).attr("id");

  $.ajax({
    url: "../ajax/ventas.php?op=ver_detalle_venta",
    method: "POST",
    data: { numero_venta: numero_venta },
    cache: false,
    //dataType:"json",
    success: function (data) {
      $("#detalles").html(data);
    },
  });
});

function cambiarEstado(id_ventas, numero_venta, est) {
  //alert(numero_compra);
  bootbox.confirm(
    "¿Estas seguro que quieres anular esta compra?",
    function (result) {
      if (result) {
        $.ajax({
          url: "../ajax/ventas.php?op=cambiar_estado_venta",
          method: "POST",
          //data:dataString,
          //toma el valor del id y del estado
          data: { id_ventas: id_ventas, numero_venta: numero_venta, est: est },
          cache: false,
          success: function (data) {
            //alert(data);
            $("#ventas_data").DataTable().ajax.reload();
            //refresca el datatable de ventas por fecha
            $("#ventas_fecha_data").DataTable().ajax.reload();
            //refresca el datatable de ventas por fecha - mes
            $("#ventas_fecha_mes_data").DataTable().ajax.reload();
          },
        });
      }
    }
  ); //bootbox
}

//CONSULTA VENTAS-FECHA
$(document).on("click", "#btn_venta_fecha", function () {
  var fecha_inicial = $("#datepicker").val();
  var fecha_final = $("#datepicker2").val();
  //alert(fecha_inicial);
  //alert(fecha_final);
  //validamos si existe las fechas entonces se ejecuta el ajax
  if (fecha_inicial != "" && fecha_final != "") {
    //BUSCA LAS COMPRAS POR FECHA
    tabla_ventas = $("#ventas_fecha_data").DataTable({
      aProcessing: true, //Activamos el procesamiento del datatables
      aServerSide: true, //Paginación y filtrado realizados por el servidor
      dom: "Bfrtip", //Definimos los elementos del control de tabla
      buttons: ["copyHtml5", "excelHtml5", "csvHtml5", "pdf"],
      ajax: {
        url: "../ajax/ventas.php?op=buscar_ventas_fecha",
        type: "post",
        //dataType : "json",
        data: { fecha_inicial: fecha_inicial, fecha_final: fecha_final },
        error: function (e) {
          console.log(e.responseText);
        },
      },
      bDestroy: true,
      responsive: true,
      bInfo: true,
      iDisplayLength: 10, //Por cada 10 registros hace una paginación
      order: [[0, "desc"]], //Ordenar (columna,orden)
      language: {
        sProcessing: "Procesando...",
        sLengthMenu: "Mostrar _MENU_ registros",
        sZeroRecords: "No se encontraron resultados",
        sEmptyTable: "Ningún dato disponible en esta tabla",
        sInfo:
          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
        sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
        sInfoPostFix: "",
        sSearch: "Buscar:",
        sUrl: "",
        sInfoThousands: ",",
        sLoadingRecords: "Cargando...",
        oPaginate: {
          sFirst: "Primero",
          sLast: "Último",
          sNext: "Siguiente",
          sPrevious: "Anterior",
        },
        oAria: {
          sSortAscending:
            ": Activar para ordenar la columna de manera ascendente",
          sSortDescending:
            ": Activar para ordenar la columna de manera descendente",
        },
      }, //cerrando language
    });
  } //cerrando condicional de las fechas
});

//FECHA VENTA POR MES
$(document).on("click", "#btn_venta_fecha_mes", function () {
  //var proveedor= $("#proveedor").val();
  var mes = $("#mes").val();
  var ano = $("#ano").val();
  //alert(mes);
  //alert(ano);
  //validamos si existe las fechas entonces se ejecuta el ajax
  if (mes != "" && ano != "") {
    // BUSCA LAS COMPRAS POR FECHA
    var tabla_ventas_mes = $("#ventas_fecha_mes_data").DataTable({
      aProcessing: true, //Activamos el procesamiento del datatables
      aServerSide: true, //Paginación y filtrado realizados por el servidor
      dom: "Bfrtip", //Definimos los elementos del control de tabla
      buttons: ["copyHtml5", "excelHtml5", "csvHtml5", "pdf"],
      ajax: {
        url: "../ajax/ventas.php?op=buscar_ventas_fecha_mes",
        type: "post",
        //dataType : "json",
        data: { mes: mes, ano: ano },
        error: function (e) {
          console.log(e.responseText);
        },
      },
      bDestroy: true,
      responsive: true,
      bInfo: true,
      iDisplayLength: 10, //Por cada 10 registros hace una paginación
      order: [[0, "desc"]], //Ordenar (columna,orden)
      language: {
        sProcessing: "Procesando...",
        sLengthMenu: "Mostrar _MENU_ registros",
        sZeroRecords: "No se encontraron resultados",
        sEmptyTable: "Ningún dato disponible en esta tabla",
        sInfo:
          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
        sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
        sInfoPostFix: "",
        sSearch: "Buscar:",
        sUrl: "",
        sInfoThousands: ",",
        sLoadingRecords: "Cargando...",
        oPaginate: {
          sFirst: "Primero",
          sLast: "Último",
          sNext: "Siguiente",
          sPrevious: "Anterior",
        },
        oAria: {
          sSortAscending:
            ": Activar para ordenar la columna de manera ascendente",
          sSortDescending:
            ": Activar para ordenar la columna de manera descendente",
        },
      },
    });
  } //cerrando condicional de las fechas
});

init();
