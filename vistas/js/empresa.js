//Función que se ejecuta al inicio (se llama al final de este archivo)
function init() {
  //ventana modal de la empresa

  $("#empresa_form").on("submit", function (e) {
    editar_empresa(e);
  });
}

//MOSTRAR DATOS DE EMPRESA
function mostrar_empresa(id_usuario_empresa) {
  $.post(
    "../ajax/empresa.php?op=empresa",
    { id_usuario_empresa: id_usuario_empresa },
    function (data, status) {
      data = JSON.parse(data);

      $("#empresaModal").modal("show");
      $("#cedula_empresa").val(data.cedula);
      $("#nombre_empresa").val(data.nombre);

      $("#telefono_empresa").val(data.telefono);
      $("#email_empresa").val(data.correo);
      $("#direccion_empresa").val(data.direccion);

      $(".modal-title").text("Editar Empresa");
      $("#id_usuario_empresa").val(id_usuario_empresa);
    }
  );
}

//EDITAR EMPRESA

//la funcion guardaryeditar(e); se llama cuando se da click al boton submit
function editar_empresa(e) {
  e.preventDefault(); //No se activará la acción predeterminada del evento
  //$("#btnGuardar").prop("disabled",true);
  var formData = new FormData($("#empresa_form")[0]);

  $.ajax({
    url: "../ajax/empresa.php?op=editar_empresa",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,

    success: function (datos) {
      //alert(datos);

      $("#empresaModal").modal("hide");

      $("#resultados_ajax").html(datos);
    },
  });
}

init();
