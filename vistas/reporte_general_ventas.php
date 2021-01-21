<?php

require_once("../config/conexion.php");
if (isset($_SESSION["id_usuario"])) {
	require_once("../modelos/Ventas.php");
	$ventas = new Ventas();
	$datos = $ventas->get_ventas_reporte_general();
	$datos_ano = $ventas->suma_ventas_total_ano();

?>
	<!-- INICIO DEL HEADER - LIBRERIAS -->
	<?php require_once("header.php"); ?>
	<!-- FIN DEL HEADER - LIBRERIAS -->

	<?php if ($_SESSION["reporte_ventas"] == 1) {

	?>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">

			<h2 class="reporte_compras_general container-fluid bg-red text-white col-lg-12 text-center mh-50">

				REPORTE DE VENTAS MES Y AÑO
			</h2>

			<div class="panel panel-default">

				<div class="panel-body">

					<div class="btn-group text-center">
						<button type='button' id="buttonExport" class="btn btn-primary btn-lg"><i class="fa fa-print" aria-hidden="true"></i> Imprimir</button>
					</div>

				</div>
			</div>


			<div class="row">

				<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">

					<div class="box">

						<div class="">

							<h2 class="reporte_compras_general container-fluid bg-primary text-white col-lg-12 text-center mh-50">REPORTE GENERAL DE VENTAS</h2>

							<table class="table table-bordered">
								<thead>
									<tr>
										<th>AÑO</th>
										<th>N° MES</th>
										<th>NOMBRE MES</th>
										<th>TOTAL</th>
									</tr>
								</thead>
								<tbody>
									<?php
									for ($i = 0; $i < count($datos); $i++) {
										//imprime la fecha por separado ejemplo: dia, mes y año
										$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
										$fecha = $datos[$i]["mes"];
										$fecha_mes = $meses[date("n", strtotime($fecha)) - 1];

									?>
										<tr>
											<td><?php echo $datos[$i]["ano"] ?></td>
											<td><?php echo $datos[$i]["numero_mes"] ?></td>
											<td><?php echo $fecha_mes ?></td>

											<td><?php echo $datos[$i]["moneda"] . " " . $datos[$i]["total_venta"] ?></td>
										</tr>

									<?php
									} //cierre del for
									?>
								</tbody>
							</table>
						</div>
						<!--fin box-body-->
					</div>
					<!--fin box-->
				</div>
				<!--fin col-xs-12-->

				<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
					<div class="box">

						<div class="">

							<h2 class="reporte_compras_general container-fluid bg-red text-white col-lg-12 text-center mh-50">PORCENTAJE POR AÑO</h2>


							<table class="table table-bordered">
								<thead>

									<th>AÑO</th>
									<th>TOTAL</th>
									<th>PORCENTAJE %</th>

								</thead>

								<tbody>

									<?php
									$arregloReg = array();

									?>

									<?php for ($i = 0; $i < count($datos_ano); $i++) {


										array_push(
											$arregloReg,
											array(


												'ano' => $datos_ano[$i]["ano"],

												'total_venta_ano' => $datos_ano[$i]["total_venta_ano"]

											)
										);
									} //cierre del primer ciclo for


									//segundo for
									$sumaTotal = 0;

									for ($j = 0; $j < count($arregloReg); $j++) {

										//sumo el total de los años
										$sumaTotal = $sumaTotal + $datos_ano[$j]["total_venta_ano"];
									}


									$porcentaje_total = 0;

									for ($i = 0; $i < count($arregloReg); $i++) {

										//CALCULO DEL PORCENTAJE
										$dato_por_ano = $arregloReg[$i]["total_venta_ano"];


										$porcentaje_por_ano = round(($dato_por_ano / $sumaTotal) * 100, 2);

										$porcentaje_total = $porcentaje_total + $porcentaje_por_ano;



									?>

										<tr>
											<td><?php echo $arregloReg[$i]["ano"]; ?></td>
											<td><?php echo $arregloReg[$i]["total_venta_ano"]; ?></td>
											<td><?php echo $porcentaje_por_ano ?></td>
										</tr>

									<?php

									}


									?>

									<tr>
										<td><strong>Total:</strong> </td>
										<td><strong> <?php echo $sumaTotal ?> </strong></td>
										<td> <strong> <?php echo $porcentaje_total ?> </strong></td>
									</tr>



								</tbody>

							</table>


						</div>
						<!--fin box-body-->
					</div>
					<!--fin box-->
				</div>
				<!--fin col-xs-6-->

			</div>
			<!--fin row-->

			<!--SEGUNDA FILA DE LA GRAFIA-->
			<div class="row">

				<!--VENTAS HECHAS-->

				<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">

					<div class="box">

						<div class="">

							<h2 class="reporte_compras_general container-fluid bg-red text-white col-lg-12 text-center mh-50">REPORTE GENERAL DE VENTAS</h2>


							<!--GRAFICA-->
							<div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>



						</div>
						<!--fin box-body-->
					</div>
					<!--fin box-->
				</div>
				<!--fin col-lg-6-->


				<!--VENTAS CANCELADAS-->

				<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">

					<div class="box">

						<div class="">

							<h2 class="reporte_compras_general container-fluid bg-primary text-white col-lg-12 text-center mh-50">REPORTE GENERAL DE VENTAS CANCELADAS</h2>


							<!--GRAFICA-->
							<div id="container_cancelada" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>



						</div>
						<!--fin box-body-->
					</div>
					<!--fin box-->
				</div>
				<!--fin col-lg-6-->





			</div>
			<!--fin row-->



		</div>
		<!-- /.content-wrapper -->



	<?php  } else {

		require("noacceso.php");
	}

	?>
	<!--CIERRE DE SESSION DE PERMISO -->


	<?php require_once("footer.php"); ?>


	<script type="text/javascript">
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

							<?php echo $datos_grafica = $ventas->suma_ventas_total_grafica(); ?>
						]

					}
				],

				exporting: {
					enabled: false
				}

			});

			//VENTAS CANCELADAS

			var chart = new Highcharts.Chart({
				//$('#container').highcharts({

				chart: {

					renderTo: 'container_cancelada',
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

							<?php echo $datos_grafica = $ventas->suma_ventas_cancelada_total_grafica(); ?>
						]

					}
				],

				exporting: {
					enabled: false
				}

			});



			/*****FIN VENTAS CANCELADAS************************************/

			//si se le da click al boton entonces se envia la imagen al archivo PDF por ajax
			$('#buttonExport').click(function() {


				//alert("clic");
				printHTML()
				document.addEventListener("DOMContentLoaded", function(event) {
					printHTML();
				});


			});
			//fin prueba

		});

		//function

		function printHTML() {
			if (window.print) {
				window.print();
			}
		}
	</script>
<?php
}
?>