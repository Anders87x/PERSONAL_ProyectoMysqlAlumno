<?php
require_once("../config/conexion.php");
if (isset($_SESSION["id_usuario"])) {
	require_once("../modelos/Compras.php");
	$compras = new Compras();
	$datos = $compras->get_compras_reporte_general();
	$datos_ano = $compras->suma_compras_total_ano();

?>
	<!-- INICIO DEL HEADER - LIBRERIAS -->
	<?php require_once("header.php"); ?>
	<!-- FIN DEL HEADER - LIBRERIAS -->
	<?php if ($_SESSION["reporte_compras"] == 1) {

	?>
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">

			<h2 class="reporte_compras_general container-fluid bg-red text-white col-lg-12 text-center mh-50">


				REPORTE DE COMPRAS MES Y AÑO
			</h2>

			<div class="panel panel-default">

				<div class="panel-body">

					<div class="btn-group text-center">
						<button type='button' id="buttonExport" class="btn btn-primary btn-lg"><i class="fa fa-print" aria-hidden="true"></i> Imprimir</button>
					</div>


				</div>
			</div>



			<div class="row">

				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

					<div class="box">

						<div class="">

							<h2 class="reporte_compras_general container-fluid bg-red text-white col-lg-12 text-center mh-50">REPORTE GENERAL DE COMPRAS REALIZADAS</h2>

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


										//para traducir el nombre del mes ya que si lo traemos desde phpmyadmin lo traerá en ingles
										$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

										//trae el nombre del mes
										$fecha = $datos[$i]["mes"];

										//aqui se imprime el nombre del mes en español
										$fecha_mes = $meses[date("n", strtotime($fecha)) - 1];


									?>


										<tr>
											<td><?php echo $datos[$i]["ano"] ?></td>
											<td><?php echo $datos[$i]["numero_mes"] ?></td>
											<td><?php echo $fecha_mes ?></td>

											<td><?php echo $datos[$i]["moneda"] . " " . $datos[$i]["total_compra"] ?></td>
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

				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="box">

						<div class="">

							<h2 class="reporte_compras_general container-fluid bg-primary text-white col-lg-12 text-center mh-50">PORCENTAJE POR AÑO</h2>


							<table class="table table-bordered">
								<thead>

									<th>AÑO</th>
									<th>TOTAL</th>
									<th>PORCENTAJE %</th>

								</thead>

								<tbody>

									<?php

									//DEBEMOS HACER TRES CICLO FOR PARA OBTENER LA SUMA TOTAL POR Año para calcular el porcentaje del campo total de todos los registros que se tenga en la tabla compras
									//se declara un array vacio
									$arregloReg = array();

									?>

									<!--recorremos el array para luego usarlo en un segundo ciclo for para luego obtener la suma total por año-->

									<!--PRIMER CICLO FOR-->
									<?php for ($i = 0; $i < count($datos_ano); $i++) {


										array_push(
											$arregloReg,
											array(


												'ano' => $datos_ano[$i]["ano"],

												'total_compra_ano' => $datos_ano[$i]["total_compra_ano"],

												'moneda' => $datos_ano[$i]["moneda"]

											)
										);
									} //cierre del primer ciclo for


									//SEGUNDO CICLO for para obtener la suma total del total_compra_ano dependiendo del numero de registros que se tenga en la tabla compras, esto es para obtener ese datos para calcular el porcentaje
									$sumaTotal = 0;

									for ($j = 0; $j < count($arregloReg); $j++) {

										//sumo el total de los años
										$sumaTotal = $sumaTotal + $datos_ano[$j]["total_compra_ano"];
									}


									/*TERCER CICLO FOR*/
									$porcentaje_total = 0;

									for ($i = 0; $i < count($arregloReg); $i++) {

										//CALCULO DEL PORCENTAJE
										$dato_por_ano = $arregloReg[$i]["total_compra_ano"];


										$porcentaje_por_ano = round(($dato_por_ano / $sumaTotal) * 100, 2);
										/*suma el porcentaje del campo total de todos los registros de la tabla compras dependiendo del numero total de los registros de la tabla compras y eso se obtiene por el count($arregloReg)*/
										$porcentaje_total = $porcentaje_total + $porcentaje_por_ano;



									?>

										<tr>
											<td><?php echo $arregloReg[$i]["ano"]; ?></td>
											<td><?php echo $arregloReg[$i]["moneda"] . " " . $arregloReg[$i]["total_compra_ano"]; ?></td>
											<td><?php echo $porcentaje_por_ano ?></td>
										</tr>

									<?php

									}


									?>

									<tr>
										<td><strong>Total:</strong> </td>
										<td><strong> <?php echo $arregloReg[0]["moneda"] . " " . $sumaTotal ?> </strong></td>
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

				<!--COMPRAS HECHAS-->
				<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">

					<div class="box">

						<div class="">

							<h2 class="reporte_compras_general container-fluid bg-red text-white col-lg-12 text-center mh-50">REPORTE GENERAL DE COMPRAS REALIZADAS</h2>


							<!--GRAFICA-->
							<div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>


						</div>
						<!--fin box-body-->
					</div>
					<!--fin box-->
				</div>
				<!--fin col-lg-6-->


				<!--COMPRAS CANCELADAS-->
				<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">

					<div class="box">

						<div class="">

							<h2 class="reporte_compras_general container-fluid bg-primary text-white col-lg-12 text-center mh-50">REPORTE GENERAL DE COMPRAS CANCELADAS</h2>


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


			//COMPRAS HECHAS

			var chart = new Highcharts.Chart({


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

							<?php echo $datos_grafica = $compras->suma_compras_total_grafica(); ?>
						]

					}
				],

				exporting: {
					enabled: false
				}

			});


			//COMPRAS CANCELADAS

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

							<?php echo $datos_grafica = $compras->suma_compras_canceladas_total_grafica(); ?>
						]

					}
				],

				exporting: {
					enabled: false
				}

			});



			/*****FIN COMPRAS CANCELADAS************************************/



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
} else {

	header("Location:" . Conectar::ruta() . "index.php");
}
?>