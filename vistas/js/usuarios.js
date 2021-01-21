var tabla;

//Función que se ejecuta al inicio
function init() {
  listar();

  //cuando se da click al boton submit entonces se ejecuta la funcion guardaryeditar(e);
  $("#usuario_form").on("submit", function (e) {
    guardaryeditar(e);
  });

  //cambia el titulo de la ventana modal cuando se da click al boton
  $("#add_button").click(function () {
    //habilita los campos cuando se agrega un registro nuevo ya que cuando se editaba un registro asociado entonces aparecia deshabilitado los campos
    $("#cedula").attr("disabled", false);
    $("#nombre").attr("disabled", false);
    $("#apellido").attr("disabled", false);

    $(".modal-title").text("Agregar Usuario");
  });

  //Mostramos los permisos
  /*en este caso NO se envia un id_usuario ya que se va agregar un 
	   usuario nuevo, solo se enviaría cuando se edita y ahí se enviaría el id_usuario
	   que se está editando*/
  $.post("../ajax/usuario.php?op=permisos&id_usuario=", function (r) {
    $("#permisos").html(r);
  });
}

//funcion que limpia los campos del formulario

function limpiar() {
  $("#cedula").val("");
  $("#nombre").val("");
  $("#apellido").val("");
  $("#cargo").val("");
  $("#usuario").val("");
  $("#password1").val("");
  $("#password2").val("");
  $("#telefono").val("");
  $("#email").val("");
  $("#direccion").val("");
  $("#estado").val("");
  $("#id_usuario").val("");
  //limpia los checkbox
  $("input:checkbox").removeAttr("checked");
}

//function listar

function listar() {
  tabla = $("#usuario_data")
    .dataTable({
      aProcessing: true, //Activamos el procesamiento del datatables
      aServerSide: true, //Paginación y filtrado realizados por el servidor
      dom: "Bfrtip", //Definimos los elementos del control de tabla
      buttons: ["copyHtml5", "excelHtml5", "csvHtml5", "pdf"],

      ajax: {
        url: "../ajax/usuario.php?op=listar",
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

//Mostrar datos del usuario en la ventana modal del formulario

function mostrar(id_usuario) {
  $.post(
    "../ajax/usuario.php?op=mostrar",
    { id_usuario: id_usuario },
    function (data, status) {
      data = JSON.parse(data);

      //si existe la cedula_relacion entonces tiene relacion con otras tablas
      if (data.cedula_relacion) {
        $("#usuarioModal").modal("show");

        $("#cedula").val(data.cedula_relacion);

        //desactiva el campo
        $("#cedula").attr("disabled", "disabled");

        $("#nombre").val(data.nombre);

        //desactiva el campo
        $("#nombre").attr("disabled", "disabled");

        $("#apellido").val(data.apellido);

        //desactiva el campo
        $("#apellido").attr("disabled", "disabled");

        $("#cargo").val(data.cargo);
        $("#usuario").val(data.usuario);
        $("#password1").val(data.password1);
        $("#password2").val(data.password2);
        $("#telefono").val(data.telefono);
        $("#email").val(data.correo);
        $("#direccion").val(data.direccion);
        $("#estado").val(data.estado);
        $(".modal-title").text("Editar Usuario");
        $("#id_usuario").val(id_usuario);
      } else {
        $("#usuarioModal").modal("show");
        $("#cedula").val(data.cedula);
        $("#cedula").attr("disabled", false);
        $("#nombre").val(data.nombre);
        $("#nombre").attr("disabled", false);
        $("#apellido").val(data.apellido);
        $("#apellido").attr("disabled", false);
        $("#cargo").val(data.cargo);
        $("#usuario").val(data.usuario);
        $("#password1").val(data.password1);
        $("#password2").val(data.password2);
        $("#telefono").val(data.telefono);
        $("#email").val(data.correo);
        $("#direccion").val(data.direccion);
        $("#estado").val(data.estado);
        $(".modal-title").text("Editar Usuario");
        $("#id_usuario").val(id_usuario);
      }
    }
  );

  //muestra los checkbox en la ventana modal de usuarios
  $.post(
    "../ajax/usuario.php?op=permisos&id_usuario=" + id_usuario,
    function (r) {
      $("#permisos").html(r);
    }
  );
}

//la funcion guardaryeditar(e); se llama cuando se da click al boton submit

function guardaryeditar(e) {
  e.preventDefault(); //No se activará la acción predeterminada del evento
  var formData = new FormData($("#usuario_form")[0]);

  var password1 = $("#password1").val();
  var password2 = $("#password2").val();

  //si el password conincide entonces se envia el formulario
  if (password1 == password2) {
    $.ajax({
      url: "../ajax/usuario.php?op=guardaryeditar",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,

      success: function (datos) {
        console.log(datos);

        $("#usuario_form")[0].reset();
        $("#usuarioModal").modal("hide");

        $("#resultados_ajax").html(datos);
        $("#usuario_data").DataTable().ajax.reload();

        limpiar();
      },
    });
  } //cierre de la validacion
  else {
    bootbox.alert("No coincide el password");
  }
}

//EDITAR ESTADO DEL USUARIO
//importante:id_usuario, est se envia por post via ajax
function cambiarEstado(id_usuario, est) {
  bootbox.confirm("¿Está Seguro de cambiar de estado?", function (result) {
    if (result) {
      $.ajax({
        url: "../ajax/usuario.php?op=activarydesactivar",
        method: "POST",

        //toma el valor del id y del estado
        data: { id_usuario: id_usuario, est: est },

        success: function (data) {
          $("#usuario_data").DataTable().ajax.reload();
        },
      });
    }
  }); //bootbox
}

//ELIMINAR USUARIO

function eliminar(id_usuario) {
  bootbox.confirm("¿Está Seguro de eliminar el usuario?", function (result) {
    if (result) {
      $.ajax({
        url: "../ajax/usuario.php?op=eliminar_usuario",
        method: "POST",
        data: { id_usuario: id_usuario },

        success: function (data) {
          //alert(data);
          $("#resultados_ajax").html(data);
          $("#usuario_data").DataTable().ajax.reload();
        },
      });
    }
  }); //bootbox
}

init();
