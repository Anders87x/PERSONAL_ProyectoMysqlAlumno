<?php
require_once("../config/conexion.php");
if (isset($_SESSION["correo"])) {
  /*Se llaman los modelos y se crean los objetos para llamar el numero de registros en el menu lateral izquierdo y en el home*/

  require_once("../modelos/Proveedores.php");
  require_once("../modelos/Compras.php");
  require_once("../modelos/Clientes.php");
  require_once("../modelos/Ventas.php");
  $proveedor = new Proveedor();
  $compra = new Compras();
  $cliente = new Cliente();
  $venta = new Ventas();
  $datos = $compra->get_compras_anio_actual();
  $datos_venta = $venta->get_ventas_anio_actual();

?>

  <?php require_once("header.php"); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Inicio
      </h1>

    </section>



    <!-- Main content -->
    <section class="content">

      <div class="row panel_modulos">

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">

              <a href="<?php echo Conectar::ruta() ?>vistas/clientes.php">

                <h3><?php echo $cliente->get_filas_cliente(); ?></h3>

                <h2>CLIENTES</h2>
              </a>

            </div>
            <div class="icon">
              <i class="fa fa-users" aria-hidden="true""></i>
            </div>
            
          </div>
        </div>
        <!-- ./col -->


         <div class=" col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                  <div class="inner">

                    <a href="<?php echo Conectar::ruta() ?>vistas/ventas.php">
                      <h3><?php echo $venta->get_filas_venta(); ?></h3>

                      <h2>VENTAS</h2>
                    </a>

                  </div>
                  <div class="icon">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                  </div>

                </div>
            </div>
            <!-- ./col -->

            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">

                  <a href="<?php echo Conectar::ruta() ?>vistas/proveedores.php">
                    <h3><?php echo $proveedor->get_filas_proveedor(); ?></h3>

                    <h2>PROVEEDORES</h2>
                  </a>

                </div>
                <div class="icon">
                  <i class="fa fa-truck" aria-hidden="true"></i>
                </div>

              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">

                  <a href="<?php echo Conectar::ruta() ?>vistas/compras.php">
                    <h3><?php echo $compra->get_filas_compra(); ?></h3>

                    <h2>COMPRAS</h2>
                  </a>

                </div>
                <div class="icon">
                  <i class="fa fa-cart-plus" aria-hidden="true"></i>
                </div>

              </div>
            </div>
            <!-- ./col -->

          </div>
          <!--ROW-->




          <!--INICIO CONTENIDO-->

          <h2 class="container-fluid bg-primary text-white text-center mh-50">

            RESUMEN DE COMPRAS DEL AÑO <?php echo date("Y"); ?>
          </h2>

          <!--COMPRAS ACTUAL-->
          <div class="row">

            <div class="">

              <div class="box">

                <div class="box-body">


                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="width: 10%">AÑO</th>
                        <th style="width: 10%">MES</th>
                        <th style="width: 10%">PORCENTAJE(%)</th>
                        <th style="width: 10%">TOTAL</th>
                        <th style="width: 30%" class="hidden-xs">BARRA PROGRESO DE COMPRAS MENSUALES</th>
                      </tr>
                    </thead>

                    <tbody>


                      <?php

                      $arregloReg = array();

                      for ($i = 0; $i < count($datos); $i++) {



                        array_push($arregloReg, array(

                          "ano" => $datos[$i]["ano"],
                          "mes" => $datos[$i]["mes"],
                          "total_compra_mes" => $datos[$i]["total_compra_mes"],
                          "moneda" => $datos[$i]["moneda"]

                        ));
                      }

                      ?>

                      <?php

                      $sumaTotal = 0;

                      for ($i = 0; $i < count($arregloReg); $i++) {

                        //sumo el total de los años

                        $sumaTotal = $sumaTotal + $datos[$i]["total_compra_mes"];
                      }

                      ?>


                      <?php

                      for ($i = 0; $i < count($arregloReg); $i++) {


                        //imprime la fecha por separado ejemplo: dia, mes y año
                        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

                        $fecha = $arregloReg[$i]["mes"];

                        $fecha_mes = $meses[date("n", strtotime($fecha)) - 1];


                        //calculo de porcentaje

                        $porcentaje = round($arregloReg[$i]["total_compra_mes"] / $sumaTotal * 100, 2);


                      ?>


                        <tr>
                          <td><?php echo $arregloReg[$i]["ano"] ?></td>
                          <td><?php echo $fecha_mes ?></td>
                          <td><?php echo $porcentaje ?></td>
                          <td><?php echo $arregloReg[$i]["moneda"] . " " . $arregloReg[$i]["total_compra_mes"] ?></td>


                          <td class="hidden-xs">
                            <div class="progress progress-xs">

                              <?php

                              /*poner los colores de la barra de acuerdo al %*/

                              if ($porcentaje > 24) {

                                $clase = "progress-bar progress-bar-primary";
                              } else if ($porcentaje > 10 or $porcentaje < 24) {

                                $clase = "progress-bar progress-bar-yellow";
                              } else if ($porcentaje <= 10) {

                                $clase = "progress-bar progress-bar-danger";
                              }

                              ?>


                              <div class="<?php echo $clase; ?>" style="width: <?php echo $porcentaje; ?>%">
                                <?php echo $porcentaje; ?>%
                              </div>
                            </div>
                          </td>
                        </tr>

                      <?php


                      } //cierre del for


                      ?>

                      <td></td>
                      <td><strong>IMPORTE TOTAL (<?php echo date("Y"); ?>)</strong></td>
                      <td><strong>100%</strong></td>
                      <td><strong><?php echo "$ " . $sumaTotal ?></strong></td>

                    </tbody>


                  </table>

                </div>
                <!--fin box-body-->
              </div>
              <!--fin box-->

            </div>
            <!--fin col-sm-6-->


          </div>
          <!--row-->


          <h2 class="container-fluid bg-red text-white text-center mh-50">

            RESUMEN DE VENTAS DEL AÑO <?php echo date("Y"); ?>
          </h2>

          <!--VENTAS ACTUAL-->


          <div class="row">

            <div class="">

              <div class="box">

                <div class="box-body">


                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="width: 10%">AÑO</th>
                        <th style="width: 10%">MES</th>
                        <th style="width: 10%">PORCENTAJE(%)</th>
                        <th style="width: 20%">TOTAL</th>
                        <th style="width:30%" class="hidden-xs">BARRA PROGRESO DE VENTAS MENSUALES</th>
                      </tr>
                    </thead>

                    <tbody>


                      <?php

                      $arregloReg = array();

                      for ($i = 0; $i < count($datos_venta); $i++) {



                        array_push($arregloReg, array(

                          "ano" => $datos_venta[$i]["ano"],
                          "mes" => $datos_venta[$i]["mes"],
                          "total_venta_mes" => $datos_venta[$i]["total_venta_mes"],
                          "moneda" => $datos_venta[$i]["moneda"]

                        ));
                      }

                      ?>

                      <?php

                      $sumaTotal = 0;

                      for ($i = 0; $i < count($arregloReg); $i++) {

                        //sumo el total de los años

                        $sumaTotal = $sumaTotal + $datos_venta[$i]["total_venta_mes"];
                      }

                      ?>


                      <?php

                      for ($i = 0; $i < count($arregloReg); $i++) {


                        //imprime la fecha por separado ejemplo: dia, mes y año
                        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

                        $fecha = $arregloReg[$i]["mes"];

                        $fecha_mes = $meses[date("n", strtotime($fecha)) - 1];


                        //calculo de porcentaje

                        $porcentaje = round($arregloReg[$i]["total_venta_mes"] / $sumaTotal * 100, 2);


                      ?>


                        <tr>
                          <td><?php echo $arregloReg[$i]["ano"] ?></td>
                          <td><?php echo $fecha_mes ?></td>
                          <td><?php echo $porcentaje ?></td>
                          <td><?php echo $arregloReg[$i]["moneda"] . " " . $arregloReg[$i]["total_venta_mes"] ?></td>
                          <td class="hidden-xs">
                            <div class="progress progress-xs">

                              <?php

                              /*poner los colores de la barra de acuerdo al %*/

                              if ($porcentaje > 24) {

                                $clase = "progress-bar progress-bar-primary";
                              } else if ($porcentaje > 10 or $porcentaje < 24) {

                                $clase = "progress-bar progress-bar-yellow";
                              } else if ($porcentaje <= 10) {

                                $clase = "progress-bar progress-bar-danger";
                              }

                              ?>


                              <div class="<?php echo $clase; ?>" style="width: <?php echo $porcentaje; ?>%">
                                <?php echo $porcentaje; ?>%
                              </div>
                            </div>
                          </td>
                        </tr>

                      <?php


                      } //cierre del for


                      ?>

                      <td></td>
                      <td><strong>IMPORTE TOTAL (<?php echo date("Y"); ?>)</strong></td>
                      <td><strong>100%</strong></td>
                      <td><strong><?php echo "$ " . $sumaTotal ?></strong></td>

                    </tbody>


                  </table>

                </div>
                <!--fin box-body-->
              </div>
              <!--fin box-->

            </div>
            <!--fin col-sm-6-->


          </div>
          <!--row-->




          <!--GRAFICA COMPRAS-->
          <div class="row">

            <div class="col-lg-6 col-xs-12">

              <div class="box">

                <div class="box-body">

                  <h2 class="bg-primary text-white col-lg-12 text-center">RESUMEN DE COMPRAS DEL AÑO <?php echo date("Y"); ?></h2>


                  <!--GRAFICA-->

                  <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>


                </div>
                <!--fin box-body-->
              </div>
              <!--fin box-->
            </div>
            <!--col-sm-->


            <!--GRAFICA VENTAS-->
            <div class="col-lg-6 col-xs-12">

              <div class="box">

                <div class="box-body">

                  <h2 class="bg-red text-white col-lg-12 text-center">RESUMEN DE VENTAS DEL AÑO <?php echo date("Y"); ?></h2>


                  <!--GRAFICA-->
                  <div id="container_ventas" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>



                </div>
                <!--fin box-body-->
              </div>
              <!--fin box-->
            </div>
            <!--col-sm-->

          </div>
          <!--fin row-->



          <!--FIN CONTENIDO-->


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <?php require_once("footer.php"); ?>



  <script type="text/javascript">
    /*GRAFICA COMPRAS*/
    $(document).ready(function() {

      //Highcharts.chart('container', {

      var chart = new Highcharts.Chart({
        //$('#container').highcharts({

        chart: {

          renderTo: 'container',
          plotBackgroundColor: null,
          plotBorderWidth: null,
          plotShadow: false,
          type: 'pie'
        },

        exporting: {
          url: 'http://export.highcharts.com/',
          enabled: false

        },

        title: {
          text: ''
        },
        tooltip: {
          pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
          pie: {
            showInLegend: true,
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
              enabled: true,
              format: '<b>{point.name}</b>: {point.percentage:.1f} %',
              style: {
                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',

                fontSize: '20px'
              }
            }
          }
        },
        legend: {
          symbolWidth: 12,
          symbolHeight: 18,
          padding: 0,
          margin: 15,
          symbolPadding: 5,
          itemDistance: 40,
          itemStyle: {
            "fontSize": "17px",
            "fontWeight": "normal"
          }
        },

        series: [

          {
            name: 'Brands',
            colorByPoint: true,
            data: [

              <?php echo $datos_grafica = $compra->get_compras_anio_actual_grafica(); ?>

            ]

          }
        ],

        exporting: {
          enabled: false
        }

      });


    });



    /*GRAFICA VENTAS*/
    $(document).ready(function() {

      //Highcharts.chart('container', {

      var chart = new Highcharts.Chart({
        //$('#container').highcharts({

        chart: {

          renderTo: 'container_ventas',
          plotBackgroundColor: null,
          plotBorderWidth: null,
          plotShadow: false,
          type: 'pie'
        },

        exporting: {
          url: 'http://export.highcharts.com/',
          enabled: false

        },

        title: {
          text: ''
        },
        tooltip: {
          pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
          pie: {
            showInLegend: true,
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
              enabled: true,
              format: '<b>{point.name}</b>: {point.percentage:.1f} %',
              style: {
                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',

                fontSize: '20px'
              }
            }
          }
        },
        legend: {
          symbolWidth: 12,
          symbolHeight: 18,
          padding: 0,
          margin: 15,
          symbolPadding: 5,
          itemDistance: 40,
          itemStyle: {
            "fontSize": "17px",
            "fontWeight": "normal"
          }
        },

        series: [

          {
            name: 'Brands',
            colorByPoint: true,
            data: [

              <?php echo $datos_grafica = $venta->get_ventas_anio_actual_grafica(); ?>
            ]

          }
        ],

        exporting: {
          enabled: false
        }

      });


    });
  </script>


<?php

} else {

  header("Location:" . Conectar::ruta() . "index.php");
  exit();
}
?>