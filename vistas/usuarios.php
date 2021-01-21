<?php
require_once("../config/conexion.php");
if (isset($_SESSION["id_usuario"])) {
?>

  <?php
  require_once("header.php");
  ?>

  <?php if ($_SESSION["usuarios"] == 1) {

  ?>

    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">

        <div id="resultados_ajax"></div>

        <h2>Listado de Usuarios</h2>

        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <h1 class="box-title">
                  <button class="btn btn-primary btn-lg" id="add_button" onclick="limpiar()" data-toggle="modal" data-target="#usuarioModal"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo Usuario</button></h1>
                <div class="box-tools pull-right">
                </div>
              </div>
              <!-- /.box-header -->
              <!-- centro -->
              <div class="panel-body table-responsive">

                <table id="usuario_data" class="table table-bordered table-striped">

                  <thead>

                    <tr>

                      <th>Cédula</th>
                      <th>Nombres</th>
                      <th>Apellidos</th>
                      <th>Usuario</th>
                      <th>Cargo</th>
                      <th>Teléfono</th>
                      <th>Correo</th>
                      <th>Dirección</th>
                      <th>Fecha Ingreso</th>
                      <th>Estado</th>
                      <th width="10%">Editar</th>
                      <th width="10%">Eliminar</th>
                    </tr>
                  </thead>

                  <tbody>

                  </tbody>


                </table>

              </div>

              <!--Fin centro -->
            </div><!-- /.box -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
    <!--Fin-Contenido-->

    <!--FORMULARIO VENTANA MODAL-->

    <div id="usuarioModal" class="modal fade">
      <div class="modal-dialog">
        <form method="post" id="usuario_form">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Agregar Usuario</h4>
            </div>

            <div class="modal-body">

              <label>Cédula</label>
              <input type="text" name="cedula" id="cedula" class="form-control" placeholder="Cédula" required pattern="[0-9]{0,15}" />

              <br />

              <label>Nombres</label>
              <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombres" required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$" />
              <br />

              <label>Apellidos</label>
              <input type="text" name="apellido" id="apellido" class="form-control" placeholder="Apellidos" required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$" />
              <br />

              <label>Cargo</label>
              <select class="form-control" id="cargo" name="cargo" required>
                <option value="">-- Selecciona cargo --</option>
                <option value="1" selected>Administrador</option>
                <option value="0">Empleado</option>
              </select>
              <br />

              <label>Usuario</label>
              <input type="text" name="usuario" id="usuario" class="form-control" placeholder="Usuario" required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$" />
              <br />

              <label>Password</label>
              <input type="password" name="password1" id="password1" class="form-control" placeholder="Password" required />
              <br />

              <label>Repita Password</label>
              <input type="password" name="password2" id="password2" class="form-control" placeholder="Repita Password" required />
              <br />

              <label>Teléfono</label>
              <input type="text" name="telefono" id="telefono" class="form-control" placeholder="Teléfono" required pattern="[0-9]{0,15}" />
              <br />

              <label>Correo</label>
              <input type="email" name="email" id="email" class="form-control" placeholder="Correo" required="required" />
              <br />

              <label>Dirección</label>
              <textarea cols="90" rows="3" id="direccion" name="direccion" placeholder="Direccion ..." required pattern="^[a-zA-Z0-9_áéíóúñ°\s]{0,200}$">
          </textarea>
              <br />

              <label>Estado</label>
              <select class="form-control" id="estado" name="estado" required>
                <option value="">-- Selecciona estado --</option>
                <option value="1" selected>Activo</option>
                <option value="0">Inactivo</option>
              </select>



              <br /><br />

              <!--LISTA DE PERMISOS-->

              <div class="form-group">
                <label for="" class="col-lg-1 control-label">Permisos</label>

                <div class="col-lg-6">

                  <ul style="list-style:none;" id="permisos">


                  </ul>

                </div>

              </div>

              <!--FIN LISTA DE PERMISOS-->


            </div>


            <div class="modal-footer">

              <input type="hidden" name="id_usuario" id="id_usuario" />

              <button type="submit" name="action" id="btnGuardar" class="btn btn-success pull-left" value="Add"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>

              <button type="button" onclick="limpiar()" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cerrar</button>

            </div>

          </div>

        </form>

      </div>

    </div>

    <?php  } else {

    require("noacceso.php");
  }
    ?>-->
    <!--CIERRE DE SESSION DE PERMISO -->
    <?php

    require_once("footer.php");
    ?>
    <script type="text/javascript" src="js/usuarios.js"></script>



  <?php

} else {

  header("Location:" . Conectar::ruta() . "index.php");
}



  ?>