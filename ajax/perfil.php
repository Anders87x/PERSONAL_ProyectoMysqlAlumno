<?php

//llamo a la conexion de la base de datos 
require_once("../config/conexion.php");
//llamo al modelo Perfil
require_once("../modelos/Perfil.php");
$perfil = new Perfil();
//declaramos las variables de los valores que se envian por el formulario y que recibimos por ajax y decimos que si existe el parametro que estamos recibiendo
//los valores vienen del atributo name de los campos del formulario
/*el valor id_usuario_perfil se carga en el campo hidden cuando se edita un registro*/

//declaracion de variables que vienen del formulario del perfil usuario

$id_usuario_perfil = isset($_POST["id_usuario_perfil"]);
$nombre_perfil = isset($_POST["nombre_perfil"]);
$apellido_perfil = isset($_POST["apellido_perfil"]);
$cedula_perfil = isset($_POST["cedula_perfil"]);
$telefono_perfil = isset($_POST["telefono_perfil"]);
$email_perfil = isset($_POST["email_perfil"]);
$direccion_perfil = isset($_POST["direccion_perfil"]);

$usuario_perfil = isset($_POST["usuario_perfil"]);
$password1_perfil = isset($_POST["password1_perfil"]);
$password2_perfil = isset($_POST["password2_perfil"]);


switch ($_GET["op"]) {

  case 'mostrar_perfil':

    //selecciona el id del usuario

    $datos = $perfil->get_usuario_por_id($_POST["id_usuario_perfil"]);

    // si existe el id del usuario entonces recorre el array
    if (is_array($datos) == true and count($datos) > 0) {


      foreach ($datos as $row) {
        $output["cedula"] = $row["cedula"];
        $output["nombre"] = $row["nombres"];
        $output["apellido"] = $row["apellidos"];

        $output["usuario_perfil"] = $row["usuario"];
        $output["password1"] = $row["password"];
        $output["password2"] = $row["password2"];
        $output["telefono"] = $row["telefono"];
        $output["correo"] = $row["correo"];
        $output["direccion"] = $row["direccion"];
      }


      echo json_encode($output);
    } else {

      //si no existe el registro entonces no recorre el array
      $errors[] = "El usuario no existe";
    }


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


  case 'editar_perfil':

    //verificamos si el usuario existe en la base de datos, si ya existe un registro con la cedula, nombre o correo entonces no lo registra

    $datos = $perfil->get_usuario_nombre($_POST["cedula_perfil"], $_POST["email_perfil"]);

    //verificamos si el password1 coincide con el password2, si se cumple entonces verificamos si existe un registro con los datos enviados y en caso que no existe entonces se registra el usuario

    if ($_POST["password1_perfil"] == $_POST["password2_perfil"]) {


      if (is_array($datos) == true and count($datos) > 0) {


        //si ya existe entonces editamos el usuario y sus permisos

        $perfil->editar_perfil($id_usuario_perfil, $nombre_perfil, $apellido_perfil, $cedula_perfil, $telefono_perfil, $email_perfil, $direccion_perfil, $usuario_perfil, $password1_perfil, $password2_perfil);


        $messages[] = "El usuario se editó correctamente";
      } //cierre condicional $datos
    } //cierre de condicional del password
    else {
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
}




?>