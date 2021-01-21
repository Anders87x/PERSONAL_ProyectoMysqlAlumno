<?php
require_once("../config/conexion.php");
if (isset($_SESSION["id_usuario"])) {
?>

  <?php
  require_once("header.php");
  ?>


  <?php if ($_SESSION["categoria"] == 1) {

  ?>


    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">

        <div id="resultados_ajax"></div>

        <h2>Listado de Categorías</h2>

        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <h1 class="box-title">
                  <button class="btn btn-primary btn-lg" id="add_button" onclick="limpiar()" data-toggle="modal" data-target="#categoriaModal"><i class="fa fa-plus" aria-hidden="true"></i> Nueva Categoría</button></h1>
                <div class="box-tools pull-right">
                </div>
              </div>
              <!-- /.box-header -->
              <!-- centro -->
              <div class="panel-body table-responsive">

                <table id="categoria_data" class="table table-bordered table-striped">

                  <thead>

                    <tr>

                      <th width="8%">Categoría</th>
                      <th width="5%">Estado</th>
                      <th width="5%">Editar</th>
                      <th width="5%">Eliminar</th>



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
    <div id="categoriaModal" class="modal fade">
      <div class="modal-dialog">
        <form method="post" id="categoria_form">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Agregar Categoría</h4>
            </div>
            <div class="modal-body">

              <label>Categoría</label>
              <input type="text" name="categoria" id="categoria" class="form-control" placeholder="Categoria" required pattern="^[a-zA-Z_áéíóúñ]{0,15}$" />
              <br />


              <label>Estado</label>
              <select class="form-control" id="estado" name="estado" required>
                <option value="">-- Selecciona estado --</option>
                <option value="1" selected>Activo</option>
                <option value="0">Inactivo</option>
              </select>

            </div>
            <div class="modal-footer">
              <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION["id_usuario"]; ?>" />

              <input type="hidden" name="id_categoria" id="id_categoria" />


              <button type="submit" name="action" id="btnGuardar" class="btn btn-success pull-left" value="Add"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>

              <button type="button" onclick="limpiar()" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cerrar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!--FIN FORMULARIO VENTANA MODAL-->



  <?php  } else {

    require("noacceso.php");
  }

  ?>
  <!--CIERRE DE SESSION DE PERMISO -->

  <?php

  require_once("footer.php");
  ?>

  <script type="text/javascript" src="js/categorias.js"></script>



<?php

} else {

  header("Location:" . Conectar::ruta() . "index.php");
}



?>