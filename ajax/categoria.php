<?php
//llamo a la conexion de la base de datos 
require_once("../config/conexion.php");
//llamo al modelo Categorías
require_once("../modelos/Categorias.php");
//llamo al modelo Producto
require_once("../modelos/Productos.php");

$productos = new Producto();
$categorias = new Categoria();

//declaramos las variables de los valores que se envian por el formulario y que recibimos por ajax y decimos que si existe el parametro que estamos recibiendo
//los valores vienen del atributo name de los campos del formulario
/*el valor id_usuario y id_categoria se carga en el campo hidden cuando se edita un registro*/
//se copian los campos de la tabla categoria
$id_categoria = isset($_POST["id_categoria"]);
$id_usuario = isset($_POST["id_usuario"]);
$categoria = isset($_POST["categoria"]);
$estado = isset($_POST["estado"]);


switch ($_GET["op"]) {
	case "guardaryeditar":
		/*si el id no existe entonces lo registra
	           importante: se debe poner el $_POST sino no funciona*/
		if (empty($_POST["id_categoria"])) {
			/*verificamos si existe la categoria en la base de datos, si ya existe un registro con la categoria entonces no se registra*/
			//importante: se debe poner el $_POST sino no funciona
			$datos = $categorias->get_nombre_categoria($_POST["categoria"]);

			if (is_array($datos) == true and count($datos) == 0) {
				//no existe la categoria por lo tanto hacemos el registros
				$categorias->registrar_categoria($categoria, $estado, $id_usuario);
				$messages[] = "La categoría se registró correctamente";
			} //cierre de validacion de $datos 
			/*si ya existes la categoria entonces aparece el mensaje*/ else {
				$errors[] = "La categoría ya existe";
			}
		} //cierre de empty

		else {
			/*si ya existe entonces editamos la categoria*/
			$categorias->editar_categoria($id_categoria, $categoria, $estado, $id_usuario);
			$messages[] = "La categoría se editó correctamente";
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

		//selecciona el id de la categoria

		//el parametro id_categoria se envia por AJAX cuando se edita la categoria
		$datos = $categorias->get_categoria_por_id($_POST["id_categoria"]);


		//verifica si el id_categoria tiene registro asociado a compras
		$categoria_compras = $categorias->get_categoria_por_id_compras($_POST["id_categoria"]);


		//verifica si el id_categoria tiene registro asociado a detalle_compras
		$categoria_detalle_compras = $categorias->get_categoria_por_id_detalle_compras($_POST["id_categoria"]);


		//valida si el id_categoria  tiene registros asociados en la tabla compras y detalle_compras
		if (is_array($categoria_compras) == true and count($categoria_compras) == 0 and is_array($categoria_detalle_compras) == true and count($categoria_detalle_compras) == 0) {


			foreach ($datos as $row) {
				$output["categoria"] = $row["categoria"];
				$output["estado"] = $row["estado"];
				$output["id_usuario"] = $row["id_usuario"];
			}
		} else {

			//si el id_categoria tiene relacion con la tabla compras y detalle_compras entonces se deshabilita la categoria


			foreach ($datos as $row) {

				$output["categoria_id"] = $row["id_categoria"];
				$output["categoria"] = $row["categoria"];
				$output["estado"] = $row["estado"];
				$output["id_usuario"] = $row["id_usuario"];
			}
		} //cierre el else

		echo json_encode($output);


		break;

	case "activarydesactivar":

		//los parametros id_categoria y est vienen por via ajax
		$datos = $categorias->get_categoria_por_id($_POST["id_categoria"]);

		// si existe el id de la categoria entonces recorre el array
		if (is_array($datos) == true and count($datos) > 0) {

			//edita el estado de la categoria
			$categorias->editar_estado($_POST["id_categoria"], $_POST["est"]);

			//edita el estado del producto

			$productos->editar_estado_producto_por_categoria($_POST["id_categoria"], $_POST["est"]);
		}

		break;


	case "listar":

		$datos = $categorias->get_categorias();

		//Vamos a declarar un array
		$data = array();

		foreach ($datos as $row) {
			$sub_array = array();

			//ESTADO
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


			$sub_array[] = $row["categoria"];



			$sub_array[] = '<button type="button" onClick="cambiarEstado(' . $row["id_categoria"] . ',' . $row["estado"] . ');" name="estado" id="' . $row["id_categoria"] . '" class="' . $atrib . '">' . $est . '</button>';




			$sub_array[] = '<button type="button" onClick="mostrar(' . $row["id_categoria"] . ');"  id="' . $row["id_categoria"] . '" class="btn btn-warning btn-md update"><i class="glyphicon glyphicon-edit"></i> Editar</button>';

			$sub_array[] = '<button type="button" onClick="eliminar(' . $row["id_categoria"] . ');"  id="' . $row["id_categoria"] . '" class="btn btn-danger btn-md"><i class="glyphicon glyphicon-edit"></i> Eliminar</button>';

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

	case "eliminar_categoria":

		//verificamos si la categoria existe en la tabla producto

		$datos = $productos->get_prod_por_id_cat($_POST["id_categoria"]);


		if (is_array($datos) == true and count($datos) > 0) {


			//si existe la categoria en productos, no lo elimina

			$errors[] = "La categoría existe en productos";
		} //fin

		else {

			//verificamos si la categoria existe en la base de datos en la tabla categoria, si existe entonces lo elimina

			$datos = $categorias->get_categoria_por_id($_POST["id_categoria"]);


			if (is_array($datos) == true and count($datos) > 0) {

				$categorias->eliminar_categoria($_POST["id_categoria"]);

				$messages[] = "La categoría se eliminó exitosamente";
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