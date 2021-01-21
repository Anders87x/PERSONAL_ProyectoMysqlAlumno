var tabla;

var tabla_en_ventas;

//Función que se ejecuta al inicio
function init() {
  listar();

  //llama la lista de clientes en ventana modal en ventas.php
  listar_en_ventas();

  //cuando se da click al boton submit entonces se ejecuta la funcion guardaryeditar(e);
  $("#cliente_form").on("submit", function (e) {
    guardaryeditar(e);
  });

  //cambia el titulo de la ventana modal cuando se da click al boton
  $("#add_button").click(function () {
    //habilita los campos cuando se agrega un registro nuevo
    $("#cedula").attr("disabled", false);
    $("#nombre").attr("disabled", false);
    $("#apellido").attr("disabled", false);

    $(".modal-title").text("Agregar Cliente");
  });
}

//Función limpiar
/*IMPORTANTE: no limpiar el campo oculto del id_usuario, sino no se registra
el cliente*/
function limpiar() {
  $("#cedula").val("");
  $("#nombre").val("");
  $("#apellido").val("");
  $("#telefono").val("");
  $("#email").val("");
  $("#direccion").val("");
  $("#estado").val("");
  $("#cedula_cliente").val("");
}

//Función Listar
function listar() {
  tabla = $("#cliente_data")
    .dataTable({
      aProcessing: true, //Activamos el procesamiento del datatables
      aServerSide: true, //Paginación y filtrado realizados por el servidor
      dom: "Bfrtip", //Definimos los elementos del control de tabla
      buttons: ["copyHtml5", "excelHtml5", "csvHtml5", "pdf"],
      ajax: {
        url: "../ajax/cliente.php?op=listar",
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

//Mostrar datos del cliente en la ventana modal
function mostrar(cedula_cliente) {
  $.post(
    "../ajax/cliente.php?op=mostrar",
    { cedula_cliente: cedula_cliente },
    function (data, status) {
      data = JSON.parse(data);

      //alert(data.cedula);

      console.log(data);

      //si existe la cedula_relacion entonces tiene relacion con otras tablas
      if (data.cedula_relacion) {
        $("#clienteModal").modal("show");
        $("#cedula").val(cedula_cliente);

        //desactiva el campo
        $("#cedula").attr("disabled", "disabled");

        $("#nombre").val(data.nombre);

        //desactiva el campo
        $("#nombre").attr("disabled", "disabled");

        $("#apellido").val(data.apellido);

        //desactiva el campo
        $("#apellido").attr("disabled", "disabled");

        $("#telefono").val(data.telefono);
        $("#email").val(data.correo);
        $("#direccion").val(data.direccion);
        $("#estado").val(data.estado);
        $(".modal-title").text("Editar Cliente");
        $("#cedula_cliente").val(cedula_cliente);
      } else {
        $("#clienteModal").modal("show");
        $("#cedula").val(cedula_cliente);

        $("#cedula").attr("disabled", false);
        $("#nombre").val(data.nombre);

        $("#nombre").attr("disabled", false);

        $("#apellido").val(data.apellido);
        $("#apellido").attr("disabled", false);

        $("#telefono").val(data.telefono);
        $("#email").val(data.correo);
        $("#direccion").val(data.direccion);
        $("#estado").val(data.estado);
        $(".modal-title").text("Editar Cliente");
        $("#cedula_cliente").val(cedula_cliente);
      }
    }
  );
}

//la funcion guardaryeditar(e); se llama cuando se da click al boton submit
function guardaryeditar(e) {
  e.preventDefault(); //No se activará la acción predeterminada del evento
  var formData = new FormData($("#cliente_form")[0]);

  $.ajax({
    url: "../ajax/cliente.php?op=guardaryeditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,

    success: function (datos) {
      /*bootbox.alert(datos);	          
		          mostrarform(false);
		          tabla.ajax.reload();*/

      //alert(datos);

      /*imprimir consulta en la consola debes hacer un print_r($_POST) al final del metodo 
                    y si se muestran los valores es que esta bien, y se puede imprimir la consulta desde el metodo
                    y se puede ver en la consola o desde el mensaje de alerta luego pegar la consulta en phpmyadmin*/
      console.log(datos);

      $("#cliente_form")[0].reset();
      $("#clienteModal").modal("hide");

      $("#resultados_ajax").html(datos);
      $("#cliente_data").DataTable().ajax.reload();

      limpiar();
    },
  });
}

//EDITAR ESTADO DEL CLIENTE
//importante:id_cliente, est se envia por post via ajax

function cambiarEstado(id_cliente, est) {
  bootbox.confirm("¿Está Seguro de cambiar de estado?", function (result) {
    if (result) {
      $.ajax({
        url: "../ajax/cliente.php?op=activarydesactivar",
        method: "POST",
        //data:dataString,
        //toma el valor del id y del estado
        data: { id_cliente: id_cliente, est: est },
        //cache: false,
        //dataType:"html",
        success: function (data) {
          $("#cliente_data").DataTable().ajax.reload();
        },
      });
    }
  }); //bootbox
}

//Función Listar
function listar_en_ventas() {
  tabla_en_ventas = $("#lista_clientes_data")
    .dataTable({
      aProcessing: true, //Activamos el procesamiento del datatables
      aServerSide: true, //Paginación y filtrado realizados por el servidor
      dom: "Bfrtip", //Definimos los elementos del control de tabla
      buttons: ["copyHtml5", "excelHtml5", "csvHtml5", "pdf"],
      ajax: {
        url: "../ajax/cliente.php?op=listar_en_ventas",
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

//AUTOCOMPLETAR DATOS DEL CLIENTE EN VENTAS

function agregar_registro(id_cliente, est) {
  $.ajax({
    url: "../ajax/cliente.php?op=buscar_cliente",
    method: "POST",
    data: { id_cliente: id_cliente, est: est },
    dataType: "json",
    success: function (data) {
      /*si el cliente esta activo entonces se ejecuta, de lo contrario 
            el formulario no se envia y aparecerá un mensaje */
      if (data.estado) {
        $("#modalCliente").modal("hide");
        $("#cedula").val(data.cedula_cliente);
        $("#nombre").val(data.nombre);
        $("#apellido").val(data.apellido);
        $("#direccion").val(data.direccion);
        $("#id_cliente").val(id_cliente);
      } else {
        bootbox.alert(data.error);
      } //cierre condicional error
    },
  });
}

//ELIMINAR CLIENTE

function eliminar(id_cliente) {
  bootbox.confirm("¿Está Seguro de eliminar el cliente?", function (result) {
    if (result) {
      $.ajax({
        url: "../ajax/cliente.php?op=eliminar_cliente",
        method: "POST",
        data: { id_cliente: id_cliente },

        success: function (data) {
          //alert(data);
          $("#resultados_ajax").html(data);
          $("#cliente_data").DataTable().ajax.reload();
        },
      });
    }
  }); //bootbox
}

init();
