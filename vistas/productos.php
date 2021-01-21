<?php

require_once("../config/conexion.php");

if (isset($_SESSION["id_usuario"])) {

  require_once("../modelos/Categorias.php");

  $categoria = new Categoria();

  $cat = $categoria->get_categorias();


?>



  <?php

  require_once("header.php");

  ?>


  <?php if ($_SESSION["productos"] == 1) {

  ?>

    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">

        <div id="resultados_ajax"></div>

        <h2>Listado de Productos</h2>

        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <h1 class="box-title">
                  <button class="btn btn-primary btn-lg" id="add_button" onclick="limpiar()" data-toggle="modal" data-target="#productoModal"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo Producto</button></h1>
                <div class="box-tools pull-right">
                </div>
              </div>
              <!-- /.box-header -->
              <!-- centro -->
              <div class="panel-body table-responsive">

                <table id="producto_data" class="table table-bordered table-striped">

                  <thead>

                    <tr>

                      <th width="10%">Categoría</th>
                      <th width="12%">Producto</th>
                      <th width="10%">Presentación</th>
                      <!--<th width="5%">Unid. Medida</th>-->
                      <th width="10%">Precio Compra</th>
                      <th width="10%">Precio Venta</th>
                      <th width="5%">Stock</th>
                      <th width="10%">Estado</th>
                      <th width="10%">Editar</th>
                      <th width="10%">Eliminar</th>
                      <th>Ver Foto </th>



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

    <div id="productoModal" class="modal fade">
      <div class="modal-dialog tamanoModal">
        <form class="form-horizontal" method="post" id="producto_form" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Agregar Producto</h4>
            </div>
            <div class="modal-body">

              <section class="formulario-agregar_producto">


                <div class="row">

                  <!--PRIMERA COLUMNA-->
                  <!--column-12 -->
                  <div class="col-lg-6">
                    <!-- Horizontal Form -->
                    <div class="box">

                      <div class="box-body">

                        <div class="form-group">
                          <label for="" class="col-lg-1 control-label">Categoría</label>

                          <div class="col-lg-9 col-lg-offset-1">
                            <!--<input type="text" class="form-control" id="categoria" name="categoria" placeholder="Categoria">-->

                            <select class="form-control" name="categoria" id="categoria">

                              <option value="0">Seleccione</option>

                              <?php

                              for ($i = 0; $i < sizeof($cat); $i++) {

                              ?>
                                <option value="<?php echo $cat[$i]["id_categoria"] ?>"><?php echo $cat[$i]["categoria"]; ?></option>
                              <?php
                              }
                              ?>

                            </select>
                          </div>
                        </div>


                        <div class="form-group">
                          <label for="" class="col-lg-1 control-label">Producto</label>

                          <div class="col-lg-9 col-lg-offset-1">


                            <input type="text" class="form-control" id="producto" name="producto" placeholder="Descripción Producto" required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$">



                          </div>
                        </div>

                        <div class="form-group">
                          <label for="" class="col-lg-1 control-label">Presentación</label>

                          <div class="col-lg-9 col-lg-offset-1">

                            <select class="form-control" name="presentacion" id="presentacion">

                              <option value="0">Seleccione</option>

                              <option value="unidad">unidad</option>
                              <option value="Caja">Caja</option>

                            </select>
                          </div>
                        </div>

                      <!-- <div class="form-group">
                          <label for="" class="col-lg-1 control-label">Unid. Medida</label>

                          <div class="col-lg-9 col-lg-offset-1">

                            <select class="selectpicker form-control" id="unidad" name="unidad" required>
                              <option value="">-- Seleccione unidad --</option>
                              <option value="hidden">kilo</option>
                              <option value="Gramo">Gramo</option>

                            </select>


                          </div>
                        </div>-->

                        <div class="form-group">
                          <label for="" class="col-lg-1 control-label">Precio Compra</label>

                          <div class="col-lg-9 col-lg-offset-1">


                            <select class="selectpicker form-control" id="moneda" name="moneda" required>
                              <option value="">-- Seleccione moneda --</option>
                              <option value="USD$">USD$</option>
                              <option value="COP$">COP$</option>

                            </select>

                            <input type="text" class="form-control" id="precio_compra" name="precio_compra" placeholder="Precio Compra" required pattern="[0-9]{0,15}">

                          </div>
                        </div>

                        <div class="form-group">
                          <label for="" class="col-lg-1 control-label">Precio Venta</label>

                          <div class="col-lg-9 col-lg-offset-1">

                            <input type="text" class="form-control" id="precio_venta" name="precio_venta" placeholder="Precio Venta" required pattern="[0-9]{0,15}">

                          </div>
                        </div>

                        <div class="form-group">
                          <label for="" class="col-lg-1 control-label">Stock</label>

                          <div class="col-lg-9 col-lg-offset-1">
                            <input type="text" class="form-control" id="stock" name="stock" disabled>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="" class="col-lg-1 control-label">Estado</label>

                          <div class="col-lg-9 col-lg-offset-1">

                            <select class="form-control" id="estado" name="estado" required>
                              <option value="">-- Selecciona estado --</option>
                              <option value="1" selected>Activo</option>
                              <option value="0">Inactivo</option>
                            </select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="" class="col-lg-1 control-label">Fecha Vencimiento</label>

                          <div class="col-lg-9 col-lg-offset-1">
                            <input type="text" class="form-control" id="datepicker" name="datepicker" placeholder="Fecha Vencimiento">
                          </div>
                        </div>

                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!--/box-->

                  </div>
                  <!--/.col (6) -->


                  <!--SEGUNDA COLUMNA-->
                  <!--column-12 -->
                  <div class="col-lg-4">


                    <div class="form-group">

                      <div class="col-sm-7 col-lg-offset-3 col-sm-offset-3">

                        <!--producto_imagen-->



                        <input type="file" id="producto_imagen" name="producto_imagen">



                        <span id="producto_uploaded_image"></span>

                      </div>

                    </div>
                    <!--/form-group-->



                  </div>
                  <!--/.col (4) -->
                </div>
                <!-- /.row -->


              </section>
              <!--section formulario - agregar- producto -->


            </div>
            <!--modal-body-->

            <div class="row">

              <div class="col-lg-4 col-lg-offset-3 col-sm-8">

                <div class="modal-footer">
                  <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION["id_usuario"]; ?>" />
                  <input type="hidden" name="id_producto" id="id_producto" />

                  <button type="submit" name="action" id="#" class="btn btn-success pull-left" value="Add"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar </button>

                  <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cerrar</button>
                </div>
                <!--modal-footer-->

              </div>
            </div>
            <!--row-->

          </div>
        </form>
      </div>
    </div>
    <!--FIN FORMULARIO VENTANA MODAL-->


  <?php  } else {

    require_once("noacceso.php");
  }

  ?>
  <!--CIERRE DE SESSION DE PERMISO -->


  <?php

  require_once("footer.php");
  ?>

  <script type="text/javascript" src="js/productos.js"></script>



<?php

} else {

  header("Location:" . Conectar::ruta() . "index.php");
}



?>