<div class="modal fade" id="detalle_venta">
  <div class="modal-dialog tamanoModal">
    <!--antes tenia un class="modal-content" y lo cambié por bg-warning para que tuviera fondo blanco, deberia haber sido un color naranja claro pero me salió un color blanco de casualidad-->
    <div class="bg-warning">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-user-circle" aria-hidden="true"></i> DETALLE DE VENTA </h4>
      </div>
      <div class="modal-body">
        <div class="container box">
          <!--column-12 -->
          <div class="table-responsive">
            <div class="box-body">
              <table id="detalle_cliente" class="table table-striped table-bordered table-condensed table-hover">
                <thead style="background-color:#A9D0F5">
                  <tr>
                    <th>Cliente</th>
                    <th>Número Venta</th>
                    <th>Cédula Cliente</th>
                    <th>Dirección</th>
                    <th>Fecha Venta</th>
                  </tr>
                </thead>

                <tbody>
                  <td>
                    <h4 id="cliente"></h4><input type="hidden" name="cliente" id="cliente">
                  </td>
                  <td>
                    <h4 id="numero_venta"></h4><input type="hidden" name="numero_venta" id="numero_venta">
                  </td>
                  <td>
                    <h4 id="cedula_cliente"></h4><input type="hidden" name="cedula_cliente" id="cedula_cliente">
                  </td>
                  <td>
                    <h4 id="direccion"></h4><input type="hidden" name="direccion" id="direccion">
                  </td>
                  <td>
                    <h4 id="fecha_venta"></h4><input type="hidden" name="fecha_venta" id="fecha_venta">
                  </td>
                </tbody>
              </table>

              <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                  <thead style="background-color:#A9D0F5">
                    <th>Cantidad</th>
                    <th>Producto</th>
                    <th>Precio Venta</th>
                    <th>Descuento</th>
                    <th>Importe</th>
                  </thead>

                </table>
              </div>
            </div>
            <!-- /.box-body -->

            <!--BOTON CERRAR DE LA VENTANA MODAL-->
            <div class="modal-footer">
              <a href="../fpdf182/tutorial/tuto1.php?id="+  +"" class="btn btn-danger" id="btnimprimir" class="btn btn-primary btn-lg"><i aria-hidden="true"></i>Imprimir Factura</a>
              <button type="button" class="btn btn-danger pull-right" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cerrar</button>
            </div>

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