<?php
require_once("../config/conexion.php");
if (isset($_SESSION["id_usuario"])) {
  require_once("../modelos/Compras.php");
  $compra = new Compras();
?>

  <!-- INICIO DEL HEADER - LIBRERIAS -->
  <?php require_once("header.php"); ?>
  <!-- FIN DEL HEADER - LIBRERIAS -->

  <?php if ($_SESSION["compras"] == 1) {

  ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Realizar Compras de Productos a Proveedores

        </h1>

      </section>

      <!-- Main content -->
      <section class="content">

        <div class="panel panel-default">

          <div class="panel-body">

            <div class="btn-group text-center">
              <a href="consultar_compras.php" class="btn btn-primary btn-lg"><i class="fa fa-search" aria-hidden="true"></i> Consultar Compras</a>
            </div>

          </div>
        </div>

        <section class="formulario-compra">

          <form class="form-horizontal" id="form_compra">

            <!--FILA PROVEEDOR - COMPROBANTE DE PAGO-->
            <div class="row">


              <div class="col-lg-8">

                <div class="box">

                  <div class="box-body">

                    <div class="form-group">

                      <!--IMPORTANTE PONER EL ID de data-target="#modalProveedor" debe ser DIFERENTE AL DE ventas.php ya que eran iguales y ocurra un error, es importante que el id sea unico y diferente en todas las ventanas modales-->
                      <div class="col-lg-6 col-lg-offset-3">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalProveedor"><i class="fa fa-search" aria-hidden="true"></i> Buscar Proveedor</button>
                      </div>

                    </div>


                    <div class="form-group">
                      <label for="" class="col-lg-3 control-label">Número Compra</label>

                      <div class="col-lg-9">
                        <input type="text" class="form-control" id="numero_compra" name="numero_compra" value="<?php $codigo = $compra->numero_compra(); ?>" readonly>
                      </div>
                    </div>



                    <div class="form-group">
                      <label for="" class="col-lg-3 control-label">Cédula</label>

                      <div class="col-lg-9">
                        <input type="text" class="form-control" id="cedula" name="cedula" placeholder="Cedula" required pattern="[0-9]{0,15}" readonly>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="" class="col-lg-3 control-label">Razón Social</label>

                      <div class="col-lg-9">
                        <input type="text" class="form-control" id="razon" name="razon" placeholder="Razón Social" required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$" readonly>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="" class="col-lg-3 control-label">Dirección</label>

                      <div class="col-lg-9">
                        <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Direccion" required pattern="^[a-zA-Z0-9_áéíóúñ°\s]{0,200}$" readonly>
                      </div>
                    </div>

                  </div>
                  <!-- /.box-body -->

                  <!--</form>-->
                </div>
                <!-- /.box -->

              </div>
              <!--fin col-lg-12-->


            </div>
            <!--fin row-->

            <!--FILA CATEGORIA - PRODUCTO-->
            <div class="row">

              <div class="col-sm-12">

                <div class="box">

                  <div class="box-body">

                    <div class="row">


                      <div class="col-lg-3">
                        <div class="col-lg-5 text-center">
                          <button type="button" id="#" class="btn btn-primary" data-toggle="modal" data-target="#lista_productosModal"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Productos</button>
                        </div>
                      </div>


                      <div class="col-lg-3">
                        <div class="col-lg-5">
                          <label for="">Comprador: </label>
                          <h4 id="comprador" name="comprador"><?php echo $_SESSION["nombre"]; ?></h4>
                        </div>
                      </div>




                      <div class="col-lg-3">
                        <div class="">

                          <!--<label for=""><strong>Tipo de Pago:</strong> </label>-->
                          <h4 class="text-center"><strong>Tipo de Pago</strong></h4>

                          <select name="tipo_pago" class="col-lg-offset-3 col-xs-offset-2" id="tipo_pago" class="select" maxlength="10">
                            <option value="">SELECCIONE TIPO DE PAGO</option>
                            <option value="CHEQUE">PAGAR CON CHEQUE</option>
                            <option value="EFECTIVO">PAGAR CON EFECTIVO</option>
                            <option value="TRANSFERENCIA">PAGAR CON TRANSFERENCIA</option>
                          </select>
                        </div>
                      </div>






                    </div>
                    <!--fin row-->


                  </div>
                  <!-- /.box-body -->


                </div>
                <!-- /.box -->

              </div>
              <!--fin col-sm-6-->


            </div>
            <!--fin row-->


            <div class="container box">

              <div class="row">

                <div class="col-lg-12">

                  <div class="table-responsive">

                    <!--<div class="box">-->
                    <div class="box-header">
                      <h3 class="box-title">Lista de Compras a Proveedores</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <table id="detalles" class="table table-striped">
                        <thead>
                          <tr class="bg-success">


                            <th class="all">Item</th>
                            <th class="all">Producto</th>
                            <th class="all">Precio Compra</th>
                            <th class="min-desktop">Stock</th>
                            <th class="min-desktop">Cantidad</th>
                            <th class="min-desktop">Descuento %</th>
                            <th class="min-desktop">Importe</th>
                            <th class="min-desktop">Acciones</th>

                          </tr>
                        </thead>

                        <tbody id="listProdCompras">

                        </tbody>


                      </table>
                    </div>
                    <!-- /.box-body -->

                  </div>
                  <!-- /.table responsive -->
                </div>
                <!-- /.col -->

              </div>
              <!-- /row -->
            </div>
            <!-- /container -->

            <!--TABLA SUBTOTAL - TOTAL -->

            <div class="row">
              <div class="col-xs-12">

                <div class="table-responsive">

                  <div class="box-body">
                    <table id="resultados_footer" class="table table-striped">
                      <thead>
                        <tr class="row bg-success">



                          <th class="col-lg-4">TOTAL</th>

                          <th class="col-lg-4"></th>

                          <th class="col-lg-4"></th>




                        </tr>
                      </thead>


                      <tbody>
                        <tr class="row bg-gray">
                          <!--<td></td>
                  <td></td>
                  <td></td>-->
                          <td class="col-lg-4">
                            <h4 id="subtotal"> 0.00</h4><input type="hidden" name="subtotal_compra" id="subtotal_compra">
                          </td>

                          <td class="col-lg-4">
                            
                          </td>
                          <!--<td></td>-->
                          <!--IMPORTANTE: hay que poner el name=total en el h4 para que lo pueda enviar, NO se envia si lo pones en el input hidden-->
                          <td class="col-lg-4">
                            
                          </td>
                          <!--<td></td>-->


                        </tr>

                        <tr class="">



                          <input type="hidden" name="grabar" value="si">
                          <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION["id_usuario"]; ?>" />

                          <input type="hidden" name="id_proveedor" id="id_proveedor" />


                        </tr>
                      </tbody>


                    </table>

                    <div class="boton_registrar">
                      <button type="button" onClick="registrarCompra()" class="btn btn-primary col-lg-offset-10 col-xs-offset-3" id="btn"><i class="fa fa-save" aria-hidden="true"></i> Registrar Compra</button>

                    </div>

                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /.box -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

          </form>
          <!--formulario-pedido-->

        </section>
        <!--section formulario - pedido -->

      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!--FIN DE CONTENIDO-->

    <!--VISTA MODAL PARA AGREGAR PROVEEDOR-->
    <?php require_once("modal/lista_proveedores_modal.php"); ?>
    <!--VISTA MODAL PARA AGREGAR PROVEEDOR-->

    <!--VISTA MODAL PARA AGREGAR PRODUCTO-->
    <?php require_once("modal/lista_productos_modal.php"); ?>



  <?php  } else {

    require("noacceso.php");
  }


  ?>
  <!--CIERRE DE SESSION DE PERMISO -->

  <?php require_once("footer.php"); ?>



  <!--AJAX PROVEEDORES-->
  <script type="text/javascript" src="js/proveedores.js"></script>

  <!--AJAX PRODUCTOS-->
  <script type="text/javascript" src="js/productos.js"></script>


<?php

} else {

  header("Location:" . Conectar::ruta() . "index.php");
}

?>