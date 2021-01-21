<div class="modal fade" id="detalle_compra">
  <div class="modal-dialog tamanoModal">
    <!--antes tenia un class="modal-content" y lo cambié por bg-warning para que tuviera fondo blanco, deberia haber sido un color naranja claro pero me salió un color blanco de casualidad-->
    <div class="bg-warning">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-user-circle" aria-hidden="true"></i> DETALLE DE COMPRA</h4>
      </div>
      <div class="modal-body">

        <div class="container box">

          <!--column-12 -->
          <div class="table-responsive">

            <div class="box-body">


              <table id="detalle_proveedor" class="table table-striped table-bordered table-condensed table-hover">

                <thead style="background-color:#A9D0F5">
                  <tr>
                    <th>Proveedor</th>
                    <th>Número Compra</th>
                    <th>Cédula Proveedor</th>
                    <th>Dirección</th>
                    <th>Fecha Compra</th>
                  </tr>
                </thead>

                <tbody>

                  <td>
                    <h4 id="proveedor"></h4><input type="hidden" name="proveedor" id="proveedor">
                  </td>
                  <td>
                    <h4 id="numero_compra"></h4><input type="hidden" name="numero_compra" id="numero_compra">
                  </td>
                  <td>
                    <h4 id="cedula_proveedor"></h4><input type="hidden" name="cedula_proveedor" id="cedula_proveedor">
                  </td>
                  <td>
                    <h4 id="direccion"></h4><input type="hidden" name="direccion" id="direccion">
                  </td>
                  <td>
                    <h4 id="fecha_compra"></h4><input type="hidden" name="fecha_compra" id="fecha_compra">
                  </td>

                </tbody>

              </table>


              <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                  <thead style="background-color:#A9D0F5">
                    <th>Cantidad</th>
                    <th>Producto</th>
                    <th>Precio Compra</th>
                    <th>Descuento</th>
                    <th>Importe</th>
                  </thead>


                </table>
              </div>


            </div>
            <!-- /.box-body -->

            <!--BOTON CERRAR DE LA VENTANA MODAL-->
            <div class="modal-footer">
              <button type="button" class="btn btn-danger pull-right" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cerrar</button>

            </div>
            <!--modal-footer-->
            <!--</div>-->
            <!-- /.box -->

          </div>
          <!--/.col (12) -->
        </div>
        <!-- /.row -->


      </div>
      <!--modal body-->
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->