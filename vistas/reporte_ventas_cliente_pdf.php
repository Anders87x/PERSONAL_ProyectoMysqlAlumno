<?php
/*IMPORTANTE:ESTE ARCHIVO DE PDF NO ACEPTA LOS ESTILOS DE LIBRERIAS EXTERNAS NI BOOTSTRAP, HAY QUE USAR STYLE COMO ATRIBUTO Y LA ETIQUETA STYLE DEBAJO DE HEAD*/

require_once("../config/conexion.php");

if (isset($_SESSION["nombre"]) and isset($_SESSION["correo"])) {

  require_once("../modelos/Clientes.php");
  require_once("../modelos/Ventas.php");
  require_once("../modelos/Empresa.php");

  $clientes = new Cliente();
  $vent = new Ventas();
  $informacion_empresa = new Empresa();


  $datos = $clientes->get_cliente_por_cedula($_POST["cedula"]);
  $venta = $vent->get_venta_por_fecha($_POST["cedula"], $_POST["datepicker"], $_POST["datepicker2"]);

  $total_productos = $vent->get_cant_productos_por_fecha($_POST["cedula"], $_POST["datepicker"], $_POST["datepicker2"]);

  $datos_empresa = $informacion_empresa->get_empresa();



  ob_start();


?>

  <link type="text/css" rel="stylesheet" href="dompdf/css/print_static.css" />
  <style type="text/css">
    .Estilo1 {
      font-size: 13px;
      font-weight: bold;
    }

    .Estilo2 {
      font-size: 13px
    }

    .Estilo3 {
      font-size: 13px;
      font-weight: bold;
    }

    .Estilo4 {
      color: #FFFFFF
    }
  </style>


  <table style="width: 100%;" class="header">
    <tr>
      <td width="54%" height="111">
        <h1 style="text-align: left; margin-right:20px;"><img src="../public/images/logo_mercado.jpg" width="340" height="200" /></h1>
      </td>


      <td width="46%" height="111">
        <table style="width: 100%; font-size: 10pt;">

          <tr>
            <td><strong>DATOS DE LA EMPRESA</strong></td>
          </tr>

          <tr>
            <td><strong>CEDULA EMPRESA: </strong> <?php echo $datos_empresa[0]["cedula_empresa"]; ?></td>
          </tr>
          <tr>
            <td><strong>EMPRESA: </strong> <?php echo $datos_empresa[0]["nombre_empresa"]; ?></td>
          </tr>

          <tr>
            <td width="43%"><strong>DATOS DEL VENDEDOR</strong></td>
          </tr>
          <tr>
            <td><strong>NOMBRE: </strong><?php echo $_SESSION["nombre"]; ?></td>
          </tr>
          <tr>
            <td><strong>RIF/CEDULA: </strong><?php echo $_SESSION["cedula"]; ?></td>
          </tr>
          <tr>
            <td><strong>FECHA-HORA IMPRESO: </strong>
              <?php echo $fecha = date("d-m-Y h:i:s A"); ?></td>
          </tr>
          <tr></tr>
        </table>
        <!--fin segunda tabla-->
      </td>
      <!--fin segunda columna-->

    </tr>
  </table>




  <div align="center" style="color:black; font-weight:bolder; font-size:20px;">CUENTAS DE PRODUCTOS A CLIENTES </div>
  <table width="101%" class="change_order_items">

    <tr>
      <th colspan="5" style="font-size:15pt">DATOS PERSONALES DEL CLIENTE </th>
    </tr>
    <tr>
      <th width="5%" bgcolor="#317eac"><span class="Estilo11">CEDULA</span></th>
      <th width="15%" bgcolor="#317eac"><span class="Estilo11">NOMBRES</span></th>
      <th width="12%" bgcolor="#317eac"><span class="Estilo11">TELEFONO</span></th>
      <th width="38%" bgcolor="#317eac"><span class="Estilo11">DIRECCIÓN</span></th>
      <th width="30%" bgcolor="#317eac"><span class="Estilo11">CORREO</span></th>


      <?php

      if (empty($_POST["cedula"])) {

        echo "<span style='font-size:20px; color:red'>SELECCIONA UN PROVEEDOR</span>";
      }


      ?>

    </tr>


    <?php

    for ($i = 0; $i < sizeof($datos); $i++) {

    ?>

      <tr style="font-size:10pt" class="even_row">
        <td>
          <div align="center"><span class=""><?php echo $datos[$i]["cedula_cliente"]; ?></span></div>
        </td>
        <td style="text-align: center">
          <div align="center"><span class=""><?php echo $datos[$i]["nombre_cliente"]; ?></span></div>
        </td>
        <td style="text-align: center">
          <div align="center"><span class=""><?php echo $datos[$i]["telefono_cliente"]; ?></span></div>
        </td>
        <td style="text-align: right">
          <div align="center"><span class=""><?php echo $datos[$i]["direccion_cliente"]; ?></span></div>
        </td>
        <td style="text-align:center">
          <div align="center"><span class=""><?php echo $datos[$i]["correo_cliente"]; ?></span></div>
        </td>
      </tr>

    <?php
    }
    ?>

  </table>
  </div>


  <div style="font-size: 7pt">

    <table width="102%" class="change_order_items">
      <tr>
        <td colspan="5" style="font-size:15pt">
          <div align="center"><strong>LISTA DE VENTAS DE PRODUCTOS </strong></div>
        </td>
      </tr>

      <tr>
        <th width="15%" bgcolor="#317eac"><span class="Estilo1">PRODUCTO </span></th>
        <th width="10%" bgcolor="#317eac"><span class="Estilo11">PRECIO VENTA</span></th>
        <th width="5%" bgcolor="#317eac"><span class="Estilo11">CANTIDAD</span></th>
        <th width="10%" bgcolor="#317eac"><span class="Estilo11">CANTIDAD * PRECIO VENTA</span>
        <th width="10%" bgcolor="#317eac"><span class="Estilo11">FECHA VENTA </span></th>

        <?php

        if (is_array($venta) == true and count($venta) == 0) {

          echo "<span style='font-size:20px; color:red'>EL CLIENTE NO TIENE PRODUCTOS ASOCIADOS EN LA FECHA INDICADA</span>";
        }


        ?>

      </tr>

      <?php


      $pagoTotal = 0;

      for ($j = 0; $j < count($venta); $j++) {

        $decision = $venta[$j]["precio_venta"] * $venta[$j]["cantidad_venta"];

        $pagoTotal = $pagoTotal + $decision;

      ?>
        <tr class="even_row" style="font-size:10pt">

          <td style="text-align: center"><span><?php echo $venta[$j]["producto"]; ?></span></td>
          <td style="text-align: center"><span><?php echo $venta[$j]["moneda"] . " " . $venta[$j]["precio_venta"]; ?></span></td>
          <td style="text-align: center"><span><?php echo $venta[$j]["cantidad_venta"]; ?></span></td>
          <td style="text-align: center"><span class=""><?php echo $venta[$j]["moneda"] . " " . $venta[$j]["cantidad_venta"] * $venta[$j]["precio_venta"]; ?></span></td>
          <td style="text-align: center"><span><?php echo $fecha = date("d-m-Y", strtotime($venta[$j]["fecha_venta"])); ?></span></td>

        </tr>
      <?php } ?>


      <!--comienzo de la suma de productos y monto total-->
      <tr class="even_row">
        <td colspan="5" style="text-align: center">
          <table style="width: 100%; font-size: 8pt;">

            <tr>
              <td class="even_row" style="text-align: center">&nbsp;</td>
              <td class="odd_row" style="text-align: right; border-right-style: none;">&nbsp;</td>
            </tr>

            <tr>
              <td width="84%" class="even_row" style="font-size:10pt; text-align: center">
                <div align="right"><strong><span style="text-align: right;">TOTAL VENTA:</span></strong></div>
              </td>
              <td width="16%" class="odd_row" style="font-size:12pt" text-align: right; border-right-style: none;">
                <div align="center">
                  <strong>
                    <?php

                    if ($pagoTotal != 0) {

                      echo $venta[0]["moneda"] . " " . $pagoTotal;
                    } else {

                      //echo "US$ ".$pagoTotal;

                      echo "US$ " . $pagoTotal;
                    }



                    ?>
                  </strong>

                </div>
              </td>
            </tr>

            <tr>
              <td class="even_row" style="font-size:10pt; text-align: center">
                <div align="right"><strong><span style="text-align:right;">TOTAL PRODUCTOS VENDIDOS:</span></strong></div>
              </td>
              <td class="odd_row" style="font-size:12pt;text-align: right; border-right-style: none;">
                <div align="center"><strong>
                    <?php


                    if ($pagoTotal != 0) {

                      echo $total_productos["total"];
                    } else {

                      echo "0";
                    }


                    ?>
                  </strong></div>
              </td>
            </tr>

        </td>
      </tr>
      <!--termina la suma de productos y monto total-->

    </table>




    <table style="border-top: 1px solid black; padding-top: 2em; margin-top: 2em;">
      <tr>
        <td style="padding-top: 0em"><span class="Estilo2"><strong>REVISADO POR :</strong></span></td>
        <td style="text-align: center; padding-top: 0em;">&nbsp;</td>
      </tr>
      <tr>
        <td style="padding-top: 0em"><span class="Estilo3"><span id="result_box" lang="es" xml:lang="es">ESTE REPORTE NO TENDRÁ FUERZA O EFECTO HASTA QUE SEA REVISADO Y FIRMADO POR UN FUNCIONARIO DE LA EMPRESA </span></span></td>
        <td style="text-align: center; padding-top: 0em;">&nbsp;</td>
      </tr>
      <tr>
        <td style="padding-top: 0em">&nbsp;</td>
        <td style="text-align: center; padding-top: 0em;">&nbsp;</td>
      </tr>
      <tr>
        <td style="padding-top: 0em"><span class="Estilo1">REALIZADO EL DIA <?php echo date("d") ?> DE <?php echo Conectar::convertir(date('m')) ?> DEL <?php echo date("Y") ?></span></td>
        <td style="text-align: center; padding-top: 0em;">&nbsp;</td>
      </tr>
    </table>


  </div>


<?php

  $salida_html = ob_get_contents();
  ob_end_clean();

  require_once("dompdf/dompdf_config.inc.php");
  $dompdf = new DOMPDF();
  $dompdf->load_html($salida_html);
  $dompdf->render();
  $dompdf->stream("Listado de Productos.pdf", array('Attachment' => '0'));
} else {

  header("Location:" . Conectar::ruta() . "index.php");
}

?>