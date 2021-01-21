<div id="empresaModal" class="modal fade">
  <div class="modal-dialog">
    <form action="" class="form-horizontal" method="post" id="empresa_form">
      <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar Datos de Empresa</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="inputText3" class="col-lg-1 control-label">Nit_Empresa</label>
            <div class="col-lg-9 col-lg-offset-1">
              <input type="text" class="form-control" id="cedula_empresa" name="cedula_empresa" placeholder="Cédula" required pattern="[0-9]{0,15}">
            </div>
          </div>

          <div class="form-group">
            <label for="inputText1" class="col-lg-1 control-label">Nombre</label>

            <div class="col-lg-9 col-lg-offset-1">
              <input type="text" class="form-control" id="nombre_empresa" name="nombre_empresa" placeholder="Nombres" required pattern="{0,30}$">
            </div>
          </div>

          <div class="form-group">
            <label for="inputText4" class="col-lg-1 control-label">Teléfono</label>

            <div class="col-lg-9 col-lg-offset-1">
              <input type="text" class="form-control" id="telefono_empresa" name="telefono_empresa" placeholder="Teléfono" required pattern="[0-9]{0,15}">
            </div>
          </div>

          <div class="form-group">
            <label for="inputText4" class="col-lg-1 control-label">Correo</label>

            <div class="col-lg-9 col-lg-offset-1">
              <input type="email" class="form-control" id="email_empresa" name="email_empresa" placeholder="Correo" required="required">
            </div>
          </div>

          <div class="form-group">
            <label for="inputText5" class="col-lg-1 control-label">Dirección</label>

            <div class="col-lg-9 col-lg-offset-1">
              <textarea class="form-control  col-lg-5" rows="3" id="direccion_empresa" name="direccion_empresa" placeholder="Direccion ..." required pattern="^[a-zA-Z0-9_áéíóúñ°\s]{0,200}$"></textarea>
            </div>

          </div>




        </div>
        <!--modal-body-->

        <div class="modal-footer">
          <input type="hidden" name="id_usuario_empresa" id="id_usuario_empresa" />

          <button type="submit" name="action" class="btn btn-success pull-left" value="Add"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar </button>

          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cerrar</button>
        </div>
      </div>
    </form>
  </div>
</div>