<?php
  //llamar a la conexion de la base de datos
  require_once("../config/conexion.php");
  /*llamo a los modelos categoria, cliente, compra, empresa, producto, proveedor y venta para verificar si el usuario tiene registros asociados a las tablas de la base de datos*/
  require_once("../modelos/Categorias.php");
  require_once("../modelos/Clientes.php");
  require_once("../modelos/Compras.php");
  require_once("../modelos/Empresa.php");
  require_once("../modelos/Productos.php");
  require_once("../modelos/Proveedores.php");
  require_once("../modelos/Ventas.php");
  //llamar a el modelo Usuarios 
  require_once("../modelos/Usuarios.php");
  $usuarios = new Usuarios();
  //declaramos las variables de los valores que se envian por el formulario y que recibimos por ajax y decimos que si existe el parametro que estamos recibiendo
  $id_usuario = isset($_POST["id_usuario"]);
  $nombre = isset($_POST["nombre"]);
  $apellido = isset($_POST["apellido"]);
  $cedula = isset($_POST["cedula"]);
  $telefono = isset($_POST["telefono"]);
  $email = isset($_POST["email"]);
  $direccion = isset($_POST["direccion"]);
  $cargo = isset($_POST["cargo"]);
  $usuario = isset($_POST["usuario"]);
  $password1 = isset($_POST["password1"]);
  $password2 = isset($_POST["password2"]);
  //este es el que se envia del formulario
  $estado = isset($_POST["estado"]);
  $permisos = isset($_POST["permiso"]);
  switch ($_GET["op"]) {
    case "guardaryeditar":
      //validacion de password
      if ($password1 == $password2) {

        /*si el id no existe entonces lo registra
                        importante: se debe poner el $_POST sino no funciona*/
        if (empty($_POST["id_usuario"])) {
          /*si coincide password1 y password2 entonces verificamos si existe la cedula y correo en la base de datos, si ya existe un registro con la cedula o correo entonces no se registra el usuario*/
          $datos = $usuarios->get_cedula_correo_del_usuario($_POST["cedula"], $_POST["email"]);
          if (is_array($datos) == true and count($datos) == 0) {
            //no existe el usuario por lo tanto hacemos el registros
            $usuarios->registrar_usuario($nombre, $apellido, $cedula, $telefono, $email, $direccion, $cargo, $usuario, $password1, $password2, $estado, $permisos);
            $messages[] = "El usuario se registró correctamente";

            /*si ya exista el correo y la cedula entonces aparece el mensaje*/
          } else {

            $errors[] = "La cédula o el correo ya existe";
          }
        } //cierre de la validacion empty

        else {

          /*si ya existe entonces editamos el usuario*/

          $usuarios->editar_usuario($id_usuario, $nombre, $apellido, $cedula, $telefono, $email, $direccion, $cargo, $usuario, $password1, $password2, $estado, $permisos);

          $messages[] = "El usuario se editó correctamente";
        }
      } else {

        /*si el password no conincide, entonces se muestra el mensaje de error*/

        $errors[] = "El password no coincide";
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

    case "mostrar":
      //selecciona el id del usuario
      //el parametro id_usuario se envia por AJAX cuando se edita el usuario
      $datos = $usuarios->get_usuario_por_id($_POST["id_usuario"]);
      //verifica si el id_usuario tiene registro asociado a compras
      $usuario_compras = $usuarios->get_usuario_por_id_compras($_POST["id_usuario"]);
      //verifica si el id_usuario tiene registro asociado a ventas
      $usuario_ventas = $usuarios->get_usuario_por_id_ventas($_POST["id_usuario"]);
      //si el id_usuario NO tiene registros asociados en las tablas compras y ventas entonces se puede editar todos los campos de la tabla usuarios
      if (is_array($usuario_compras) == true and count($usuario_compras) == 0 and is_array($usuario_ventas) == true and count($usuario_ventas) == 0) {
        foreach ($datos as $row) {
          $output["cedula"] = $row["cedula"];
          $output["nombre"] = $row["nombres"];
          $output["apellido"] = $row["apellidos"];
          $output["cargo"] = $row["cargo"];
          $output["usuario"] = $row["usuario"];
          $output["password1"] = $row["password"];
          $output["password2"] = $row["password2"];
          $output["telefono"] = $row["telefono"];
          $output["correo"] = $row["correo"];
          $output["direccion"] = $row["direccion"];
          $output["estado"] = $row["estado"];
        }
      } else {
        //si el id_usuario tiene relacion con la tabla compras y tabla ventas entonces se deshabilita el nombre, apellido y cedula
        foreach ($datos as $row) {
          $output["cedula_relacion"] = $row["cedula"];
          $output["nombre"] = $row["nombres"];
          $output["apellido"] = $row["apellidos"];
          $output["cargo"] = $row["cargo"];
          $output["usuario"] = $row["usuario"];
          $output["password1"] = $row["password"];
          $output["password2"] = $row["password2"];
          $output["telefono"] = $row["telefono"];
          $output["correo"] = $row["correo"];
          $output["direccion"] = $row["direccion"];
          $output["estado"] = $row["estado"];
        }
      } //cierre del else
      echo json_encode($output);
      break;

    case "activarydesactivar":
      //los parametros id_usuario y est vienen por via ajax
      $datos = $usuarios->get_usuario_por_id($_POST["id_usuario"]);
      //valida el id del usuario
      if (is_array($datos) == true and count($datos) > 0) {

        //edita el estado del usuario 
        $usuarios->editar_estado($_POST["id_usuario"], $_POST["est"]);
      }
      break;

    case "listar":

      $datos = $usuarios->get_usuarios();

      //declaramos el array

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


        //cargo

        if ($row["cargo"] == 1) {

          $cargo = "ADMINISTRADOR";
        } else {

          if ($row["cargo"] == 0) {

            $cargo = "EMPLEADO";
          }
        }


        $sub_array[] = $row["cedula"];
        $sub_array[] = $row["nombres"];
        $sub_array[] = $row["apellidos"];
        $sub_array[] = $row["usuario"];
        $sub_array[] = $cargo;
        $sub_array[] = $row["telefono"];
        $sub_array[] = $row["correo"];
        $sub_array[] = $row["direccion"];
        $sub_array[] = date("d-m-Y", strtotime($row["fecha_ingreso"]));


        $sub_array[] = '<button type="button" onClick="cambiarEstado(' . $row["id_usuario"] . ',' . $row["estado"] . ');" name="estado" id="' . $row["id_usuario"] . '" class="' . $atrib . '">' . $est . '</button>';


        $sub_array[] = '<button type="button" onClick="mostrar(' . $row["id_usuario"] . ');"  id="' . $row["id_usuario"] . '" class="btn btn-warning btn-md update"><i class="glyphicon glyphicon-edit"></i> Editar</button>';


        $sub_array[] = '<button type="button" onClick="eliminar(' . $row["id_usuario"] . ');"  id="' . $row["id_usuario"] . '" class="btn btn-danger btn-md"><i class="glyphicon glyphicon-edit"></i> Eliminar</button>';



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


    case "eliminar_usuario":

      //verificamos si el usuario existe en las tablas productos, compras, clientes, compras, ventas, categoria, si existe entonces el usuario no se elimina, si no existe entonces se puede eliminar el usuario


      $producto = new Producto();
      $categoria = new Categoria();
      $cliente = new Cliente();
      $compra =  new Compras();
      $empresa = new Empresa();
      $proveedor = new Proveedor();
      $venta = new Ventas();

      $prod = $producto->get_producto_por_id_usuario($_POST["id_usuario"]);

      $cat = $categoria->get_categoria_por_id_usuario($_POST["id_usuario"]);

      $cli = $cliente->get_cliente_por_id_usuario($_POST["id_usuario"]);

      $comp = $compra->get_compras_por_id_usuario($_POST["id_usuario"]);

      $detalle_comp = $compra->get_detalle_compras_por_id_usuario($_POST["id_usuario"]);

      $emp = $empresa->get_empresa_por_id_usuario($_POST["id_usuario"]);

      $prov = $proveedor->get_proveedor_por_id_usuario($_POST["id_usuario"]);

      $vent = $venta->get_ventas_por_id_usuario($_POST["id_usuario"]);

      $detalle_vent = $venta->get_detalle_ventas_por_id_usuario($_POST["id_usuario"]);


      $usuario_permiso = $usuarios->get_usuario_permiso_por_id_usuario($_POST["id_usuario"]);




      if (
        is_array($usuario_permiso) == true and count($usuario_permiso) > 0 or
        is_array($prod) == true and count($prod) > 0 or
        is_array($cat) == true and count($cat) > 0 or
        is_array($cli) == true and count($cli) > 0 or
        is_array($comp) == true and count($comp) > 0 or
        is_array($detalle_comp) == true and count($detalle_comp) > 0 or
        is_array($emp) == true and count($emp) > 0 or
        is_array($prov) == true and count($prov) > 0 or
        is_array($vent) == true and count($vent) > 0 or
        is_array($detalle_vent) == true and count($detalle_vent) > 0
      ) {


        //si existe el usuario en las tablas productos, compras, clientes, compras, ventas, categoria, no lo elimina

        $errors[] = "El usuario existe en los registros, no se puede eliminar";
      } //fin

      else {


        $datos = $usuarios->get_usuario_por_id($_POST["id_usuario"]);

        //si el usuario no existe en las tablas de la bd y que existe en la tabla de usuario entonces se elimina
        if (is_array($datos) == true and count($datos) > 0) {

          $usuarios->eliminar_usuario($_POST["id_usuario"]);

          $messages[] = "El usuario se eliminó exitosamente";
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


    case 'permisos':

      //Obtenemos todos los permisos de la tabla permisos
      $listar_permisos = $usuarios->permisos();


      //Obtener los permisos asignados al usuario
      /*el id_usuario se envía cuando se edita un usuario*/
      $id_usuario = $_GET['id_usuario'];

      //echo $id_usuario;

      $marcados = $usuarios->listar_permisos_por_usuario($id_usuario);

      //print_r($marcados);

      //Declaramos el array para almacenar todos los permisos marcados
      $valores = array();

      //Almacenar los permisos asignados al usuario en el array

      foreach ($marcados as $re) {

        /*NO hay que tratar a $re como si fuera un objeto o un metodo
                  hay que manejarlo como un array como en el siguiente ejemplo*/

        $valores[] = $re["id_permiso"];
      }


      //Mostramos la lista de permisos en la vista y si están o no marcados

      foreach ($listar_permisos as $row) {

        $output["id_permiso"] = $row["id_permiso"];
        $output["nombre"] = $row["nombre"];

        /*verificamos si el $row["id_permiso"] estan dentro del array $valores y y si lo está entonces estaría marcado, en caso contrario no estaría marcado*/

        $sw = in_array($row['id_permiso'], $valores) ? 'checked' : '';

        echo '<li><input type="checkbox" ' . $sw . ' name="permiso[]" value="' . $row["id_permiso"] . '">' . $row["nombre"] . '</li>';
      }

      break;
  }
?>