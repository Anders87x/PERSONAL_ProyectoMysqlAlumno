var tabla;

//Función que se ejecuta al inicio
function init() {
  listar();

  //cuando se da click al boton submit entonces se ejecuta la funcion guardaryeditar(e);
  $("#categoria_form").on("submit", function (e) {
    guardaryeditar(e);
  });

  //cambia el titulo de la ventana modal cuando se da click al boton
  $("#add_button").click(function () {
    //habilita los campos cuando se agrega un registro nuevo ya que cuando se editaba un registro asociado entonces aparecia deshabilitado los campos
    $("#categoria").attr("disabled", false);

    $(".modal-title").text("Agregar Categoría");
  });
}

//Función limpiar
/*IMPORTANTE: no limpiar el campo oculto del id_usuario, sino no se registra
la categoria*/
function limpiar() {
  $("#categoria").val("");
  $("#estado").val("");
  $("#id_categoria").val("");
}

//Función Listar
function listar() {
  tabla = $("#categoria_data")
    .dataTable({
      aProcessing: true, //Activamos el procesamiento del datatables
      aServerSide: true, //Paginación y filtrado realizados por el servidor
      dom: "Bfrtip", //Definimos los elementos del control de tabla
      buttons: ["copyHtml5", "excelHtml5", "csvHtml5", "pdf"],
      ajax: {
        url: "../ajax/categoria.php?op=listar",
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

//Mostrar datos de la categoria en la ventana modal
function mostrar(id_categoria) {
  $.post(
    "../ajax/categoria.php?op=mostrar",
    { id_categoria: id_categoria },
    function (data, status) {
      data = JSON.parse(data);

      //alert(data.cedula);

      //si existe la categoria_id entonces tiene relacion con otras tablas
      if (data.categoria_id) {
        $("#categoriaModal").modal("show");
        $("#categoria").val(data.categoria);

        //desactiva el campo
        $("#categoria").attr("disabled", "disabled");

        $("#estado").val(data.estado);
        $(".modal-title").text("Editar Categoría");
        $("#id_categoria").val(id_categoria);
      } else {
        $("#categoriaModal").modal("show");
        $("#categoria").val(data.categoria);

        //desactiva el campo
        $("#categoria").attr("disabled", false);

        $("#estado").val(data.estado);
        $(".modal-title").text("Editar Categoría");
        $("#id_categoria").val(id_categoria);
      }
    }
  );
}

//la funcion guardaryeditar(e); se llama cuando se da click al boton submit
function guardaryeditar(e) {
  e.preventDefault(); //No se activará la acción predeterminada del evento
  var formData = new FormData($("#categoria_form")[0]);

  $.ajax({
    url: "../ajax/categoria.php?op=guardaryeditar",
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

      $("#categoria_form")[0].reset();
      $("#categoriaModal").modal("hide");

      $("#resultados_ajax").html(datos);
      $("#categoria_data").DataTable().ajax.reload();

      limpiar();
    },
  });
}

//EDITAR ESTADO DE LA CATEGORIA
//importante:id_categoria, est se envia por post via ajax

function cambiarEstado(id_categoria, est) {
  bootbox.confirm("¿Está Seguro de cambiar de estado?", function (result) {
    if (result) {
      $.ajax({
        url: "../ajax/categoria.php?op=activarydesactivar",
        method: "POST",
        //data:dataString,
        //toma el valor del id y del estado
        data: { id_categoria: id_categoria, est: est },
        //cache: false,
        //dataType:"html",
        success: function (data) {
          $("#categoria_data").DataTable().ajax.reload();
        },
      });
    }
  }); //bootbox
}

//ELIMINAR CATEGORIA

function eliminar(id_categoria) {
  //IMPORTANTE: asi se imprime el valor de una funcion

  //alert(categoria_id);

  bootbox.confirm("¿Está Seguro de eliminar la categoría?", function (result) {
    if (result) {
      $.ajax({
        url: "../ajax/categoria.php?op=eliminar_categoria",
        method: "POST",
        data: { id_categoria: id_categoria },

        success: function (data) {
          //alert(data);
          $("#resultados_ajax").html(data);
          $("#categoria_data").DataTable().ajax.reload();
        },
      });
    }
  }); //bootbox
}

init();
