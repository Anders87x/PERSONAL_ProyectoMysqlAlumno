<?php

	//llamo a la conexion de la base de datos 
	require_once("../config/conexion.php");
	//llamo al modelo Proveedores
	require_once("../modelos/Proveedores.php");
	//llamo al modelo Compras
	require_once("../modelos/Compras.php");
	$proveedores = new Proveedor();
	//declaramos las variables de los valores que se envian por el formulario y que recibimos por ajax y decimos que si existe el parametro que estamos recibiendo
	//los valores vienen del atributo name de los campos del formulario
	/*el valor id_usuario y cedula_proveedor se carga en el campo hidden cuando se edita un registro*/
	//se copian los campos de la tabla categoria
	$id_usuario = isset($_POST["id_usuario"]);
	$cedula_proveedor = isset($_POST["cedula_proveedor"]);
	$cedula = isset($_POST["cedula"]);
	$proveedor = isset($_POST["razon"]);
	$telefono = isset($_POST["telefono"]);
	$correo = isset($_POST["email"]);
	$direccion = isset($_POST["direccion"]);
	$estado = isset($_POST["estado"]);
	switch ($_GET["op"]) {
		case "guardaryeditar":
			/*si la cedula_proveedor no existe entonces lo registra
				importante: se debe poner el $_POST sino no funciona*/
			if (empty($_POST["cedula_proveedor"])) {
				/*verificamos si la cedula del proveedor en la base de datos, si ya existe un registro con el proveedor entonces no se registra*/
				//importante: se debe poner el $_POST sino no funciona
				$datos = $proveedores->get_datos_proveedor($_POST["cedula"], $_POST["razon"], $_POST["email"]);
				if (is_array($datos) == true and count($datos) == 0) {
					//no existe el proveedor por lo tanto hacemos el registros
					$proveedores->registrar_proveedor($cedula, $proveedor, $telefono, $correo, $direccion, $estado, $id_usuario);
					$messages[] = "El Proveedor se registró correctamente";
				} //cierre de validacion de $datos 
				/*si ya existes el proveedor entonces aparece el mensaje*/ else {
					$errors[] = "El Proveedor ya existe";
				}
			} //cierre de empty
			else {
				/*si ya existe entonces editamos el proveedor*/
				$proveedores->editar_proveedor($cedula, $proveedor, $telefono, $correo, $direccion, $estado, $id_usuario);
				$messages[] = "El proveedor se editó correctamente";
			}

			//mensaje success
			if (isset($messages)) {

			?>
				<div class="alert alert-success" role="alert">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>¡Bien hecho!</strong>
					<?php
					foreach ($messages as $message) {
						echo $message;
					}
					?>
				</div>
			<?php
			}
			//fin success

			//mensaje error
			if (isset($errors)) {
			?>
				<div class="alert alert-danger" role="alert">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error!</strong>
					<?php
					foreach ($errors as $error) {
						echo $error;
					}
					?>
				</div>
			<?php
			}
			//fin mensaje error
			break;

		case 'mostrar':
			//el parametro cedula se envia por AJAX cuando se edita el proveedor
			$datos = $proveedores->get_proveedor_por_cedula($_POST["cedula_proveedor"]);
			//verifica si la cedula_proveedor tiene registro asociado a compras
			$proveedor_compras = $proveedores->get_proveedor_por_cedula_compras($_POST["cedula_proveedor"]);
			//verifica si la cedula_proveedor tiene registro asociado a detalle_compras
			$proveedor_detalle_compras = $proveedores->get_proveedor_por_cedula_detalle_compras($_POST["cedula_proveedor"]);
			//si la cedula del proveedor NO tiene registros asociados en las tablas detalle_compras entonces se puede editar el pro
			if (is_array($proveedor_compras) == true and count($proveedor_compras) == 0 and is_array($proveedor_detalle_compras) == true and count($proveedor_detalle_compras) == 0) {
				foreach ($datos as $row) {
					$output["cedula_proveedor"] = $row["cedula"];
					$output["proveedor"] = $row["razon_social"];
					$output["telefono"] = $row["telefono"];
					$output["correo"] = $row["correo"];
					$output["direccion"] = $row["direccion"];
					$output["fecha"] = $row["fecha"];
					$output["estado"] = $row["estado"];
				}
			} else {
				//si la cedula tiene relacion con la tabla compras y detalle_compras entonces se deshabilita el proveedor
				foreach ($datos as $row) {
					$output["cedula_relacion"] = $row["cedula"];
					$output["proveedor"] = $row["razon_social"];
					$output["telefono"] = $row["telefono"];
					$output["correo"] = $row["correo"];
					$output["direccion"] = $row["direccion"];
					$output["fecha"] = $row["fecha"];
					$output["estado"] = $row["estado"];
				}
			} //cierre del else 
			echo json_encode($output);

			break;

		case "activarydesactivar":

			//los parametros id_proveedor y est vienen por via ajax
			$datos = $proveedores->get_proveedor_por_id($_POST["id_proveedor"]);

			// si existe el id del proveedpr entonces recorre el array
			if (is_array($datos) == true and count($datos) > 0) {

				//edita el estado del proveedor
				$proveedores->editar_estado($_POST["id_proveedor"], $_POST["est"]);
			}

			break;


		case "listar":

			$datos = $proveedores->get_proveedores();

			//Vamos a declarar un array
			$data = array();

			foreach ($datos as $row) {
				$sub_array = array();

				$est = '';

				$atrib = "btn btn-success btn-md estado";
				if ($row["estado"] == 0) {
					$est = 'INACTIVO';
					$atrib = "btn btn-warning btn-md estado";
				} else {
					if ($row["estado"] == 1) {
						$est = 'ACTIVO';
					}
				}


				$sub_array[] = $row["cedula"];
				$sub_array[] = $row["razon_social"];
				$sub_array[] = $row["telefono"];
				$sub_array[] = $row["correo"];
				$sub_array[] = $row["direccion"];
				$sub_array[] = date("d-m-Y", strtotime($row["fecha"]));


				$sub_array[] = '<button type="button" onClick="cambiarEstado(' . $row["id_proveedor"] . ',' . $row["estado"] . ');" name="estado" id="' . $row["id_proveedor"] . '" class="' . $atrib . '">' . $est . '</button>';


				$sub_array[] = '<button type="button"  onClick="mostrar(' . $row["cedula"] . ');" id="' . $row["id_proveedor"] . '" class="btn btn-warning btn-md"><i class="glyphicon glyphicon-edit"></i> Editar</button>';


				$sub_array[] = '<button type="button" onClick="eliminar(' . $row["id_proveedor"] . ');" id="' . $row["id_proveedor"] . '" class="btn btn-danger btn-md"><i class="glyphicon glyphicon-edit"></i> Eliminar</button>';

				$data[] = $sub_array;
			}

			$results = array(
				"sEcho" => 1, //Información para el datatables
				"iTotalRecords" => count($data), //enviamos el total registros al datatable
				"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
				"aaData" => $data
			);
			echo json_encode($results);


			break;

			/*se muestran en ventana modal el datatable de los proveedores en compras para seleccionar luego los proveedores activos y luego se autocomplementa los campos desde un formulario*/
		case "listar_en_compras":

			$datos = $proveedores->get_proveedores();

			//Vamos a declarar un array
			$data = array();

			foreach ($datos as $row) {
				$sub_array = array();

				$est = '';

				$atrib = "btn btn-success btn-md estado";
				if ($row["estado"] == 0) {
					$est = 'INACTIVO';
					$atrib = "btn btn-warning btn-md estado";
				} else {
					if ($row["estado"] == 1) {
						$est = 'ACTIVO';
					}
				}

				//$sub_array = array();
				$sub_array[] = $row["cedula"];
				$sub_array[] = $row["razon_social"];
				$sub_array[] = date("d-m-Y", strtotime($row["fecha"]));



				$sub_array[] = '<button type="button"  name="estado" id="' . $row["id_proveedor"] . '" class="' . $atrib . '">' . $est . '</button>';



				$sub_array[] = '<button type="button" onClick="agregar_registro(' . $row["id_proveedor"] . ',' . $row["estado"] . ');" id="' . $row["id_proveedor"] . '" class="btn btn-primary btn-md"><i class="fa fa-plus" aria-hidden="true"></i> Agregar</button>';

				$data[] = $sub_array;
			}

			$results = array(
				"sEcho" => 1, //Información para el datatables
				"iTotalRecords" => count($data), //enviamos el total registros al datatable
				"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
				"aaData" => $data
			);
			echo json_encode($results);


			break;


			/*valida los proveedores activos y se muestran en un formulario*/
		case "buscar_proveedor";


			$datos = $proveedores->get_proveedor_por_id_estado($_POST["id_proveedor"], $_POST["est"]);


			// comprobamos que el proveedor esté activo, de lo contrario no lo agrega
			if (is_array($datos) == true and count($datos) > 0) {

				foreach ($datos as $row) {
					$output["cedula"] = $row["cedula"];
					$output["razon_social"] = $row["razon_social"];
					$output["direccion"] = $row["direccion"];
					$output["fecha"] = $row["fecha"];
					$output["estado"] = $row["estado"];
				}
			} else {

				//si no existe el registro entonces no recorre el array

				$output["error"] = "El proveedor seleccionado está inactivo, intenta con otro";
			}

			echo json_encode($output);

			break;


		case "eliminar_proveedor":


			//IMPORTANTE:normalmente las compras y ventas no se pude eliminar pero aqui le estamos aplicando seguridad en PHP para tener mas seguridad con los haquers
			//verificamos si el proveedor existe en la tabla compras y detalle_compras, si existe entonces no se puede eliminar el proveedor

			$compras = new Compras();

			$comp = $compras->get_compras_por_id_proveedor($_POST["id_proveedor"]);

			$detalle_comp = $compras->get_detalle_compras_por_id_proveedor($_POST["id_proveedor"]);


			//inicio
			if (is_array($comp) == true and count($comp) > 0 && is_array($detalle_comp) == true and count($detalle_comp) > 0) {


				//si existe el proveedor en compras y detalle_compras entonces no lo elimina

				$errors[] = "El proveedor existe en compras y/0 en detalle compras, no se puede eliminar";
			} //fin

			else {


				//si existe el registro entonces lo elimina
				$datos = $proveedores->get_proveedor_por_id($_POST["id_proveedor"]);


				if (is_array($datos) == true and count($datos) > 0) {

					$proveedores->eliminar_proveedor($_POST["id_proveedor"]);

					$messages[] = "El Proveedor se eliminó exitosamente";
				}
			}



			//prueba mensaje de success

			if (isset($messages)) {

			?>
				<div class="alert alert-success" role="alert">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>¡Bien hecho!</strong>
					<?php
					foreach ($messages as $message) {
						echo $message;
					}
					?>
				</div>
			<?php
			}


			//fin mensaje success


			//inicio de mensaje de error

			if (isset($errors)) {

			?>
				<div class="alert alert-danger" role="alert">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error!</strong>
					<?php
					foreach ($errors as $error) {
						echo $error;
					}
					?>
				</div>
	<?php
			}
			//fin de mensaje de error

			break;
	}
?>