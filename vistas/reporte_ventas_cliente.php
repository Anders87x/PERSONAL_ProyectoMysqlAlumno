<?php
require_once("../config/conexion.php");
if (isset($_SESSION["id_usuario"])) {

  require_once("../modelos/Clientes.php");

  $cliente = new Cliente();

  $clientes = $cliente->get_clientes();


?>


  <!-- INICIO DEL HEADER - LIBRERIAS -->
  <?php require_once("header.php"); ?>

  <!-- FIN DEL HEADER - LIBRERIAS -->



  <?php if ($_SESSION["reporte_ventas"] == 1) {

  ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


      <div class="container-fluid bg-red text-white text-center mh-50">

        REPORTE DE VENTAS A CLIENTES
      </div>



      <div class="panel panel-default">

        <div class="panel-body">

          <div class="row  col-sm-5 col-sm-offset-3">

            <div class="">

              <form action="reporte_ventas_cliente_pdf.php" method="post">


                <div class="form-group">
                  <label for="staticEmail">Fecha Inicial</label>

                  <input type="text" class="form-control" id="datepicker" name="datepicker" placeholder="Fecha Inicial">

                </div>

                <div class="form-group">
                  <label for="inputPassword">Fecha Final</label>

                  <input type="text" class="form-control" id="datepicker2" name="datepicker2" placeholder="Fecha Final">

                </div>


                <div class="form-group">

                  <label for="inputPassword" class="col-sm-2 col-form-label">Cliente</label>

                  <select name="cedula" class="form-control">

                    <option value="0">SELECCIONE</option>


                    <?php

                    for ($i = 0; $i < sizeof($clientes); $i++) {

                    ?>

                      <option value="<?php echo $clientes[$i]["cedula_cliente"] ?>"><?php echo $clientes[$i]["nombre_cliente"] ?></option>

                    <?php


                    }


                    ?>



                  </select>
                </div>

                <button type="submit" class="btn btn-primary">CONSULTAR</button>


              </form>

            </div>
          </div>

        </div>
      </div>


    </div>
    <!-- /.content-wrapper -->


  <?php  } else {

    require("noacceso.php");
  }

  ?>
  <!--CIERRE DE SESSION DE PERMISO -->


  <?php require_once("footer.php"); ?>


<?php
}

?>