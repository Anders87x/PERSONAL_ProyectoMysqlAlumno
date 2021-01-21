<?php
class Usuarios extends Conectar
{

  public function get_filas_usuario()
  {
    $conectar = parent::conexion();
    $sql = "select * from usuarios";
    $sql = $conectar->prepare($sql);
    $sql->execute();
    $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    return $sql->rowCount();
  }

  public function login()
  {
    $conectar = parent::conexion();
    parent::set_names();
    if (isset($_POST["enviar"])) {
      //INICIO DE VALIDACIONES
      $password = $_POST["password"];
      $correo = $_POST["correo"];
      $estado = "1";
      if (empty($correo) and empty($password)) {
        header("Location:" . Conectar::ruta() . "index.php?m=2");
        exit();
    /*  } else if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){12,15}$/", $password)) {
        header("Location:" . Conectar::ruta() . "index.php?m=1");
        exit();*/
      } else {

        $sql = "select * from usuarios where correo=? and password=? and estado=?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $correo);
        $sql->bindValue(2, $password);
        $sql->bindValue(3, $estado);
        $sql->execute();
        $resultado = $sql->fetch();
        //si existe el registro entonces se conecta en session
        if (is_array($resultado) and count($resultado) > 0) {
          /*IMPORTANTE: la session guarda los valores de los campos de la tabla de la bd*/
          $_SESSION["id_usuario"] = $resultado["id_usuario"];
          $_SESSION["correo"] = $resultado["correo"];
          $_SESSION["cedula"] = $resultado["cedula"];
          $_SESSION["nombre"] = $resultado["nombres"];
          //PERMISOS DEL USUARIO PARA ACCEDER A LOS MODULOS
          require_once("Usuarios.php");
          $usuario = new Usuarios();
          //VERIFICAMOS SI EL USUARIO TIENE PERMISOS A CIERTOS MODULOS
          $marcados = $usuario->listar_permisos_por_usuario($resultado["id_usuario"]);
          //print_r($marcados);
          //declaramos el array para almacenar todos los registros marcados
          $valores = array();
          //Almacenamos los permisos marcados en el array
          foreach ($marcados as $row) {
            $valores[] = $row["id_permiso"];
          }
          ////Determinamos los accesos del usuario
          //si los id_permiso estan en el array $valores entonces se ejecuta la session=1, en caso contrario el usuario no tendria acceso al modulo
          in_array(1, $valores) ? $_SESSION['categoria'] = 1 : $_SESSION['categoria'] = 0;
          in_array(2, $valores) ? $_SESSION['productos'] = 1 : $_SESSION['productos'] = 0;
          in_array(3, $valores) ? $_SESSION['proveedores'] = 1 : $_SESSION['proveedores'] = 0;
          in_array(4, $valores) ? $_SESSION['compras'] = 1 : $_SESSION['compras'] = 0;
          in_array(5, $valores) ? $_SESSION['clientes'] = 1 : $_SESSION['clientes'] = 0;
          in_array(6, $valores) ? $_SESSION['ventas'] = 1 : $_SESSION['ventas'] = 0;
          in_array(7, $valores) ? $_SESSION['reporte_compras'] = 1 : $_SESSION['reporte_compras'] = 0;
          in_array(8, $valores) ? $_SESSION['reporte_ventas'] = 1 : $_SESSION['reporte_ventas'] = 0;
          in_array(9, $valores) ? $_SESSION['usuarios'] = 1 : $_SESSION['usuarios'] = 0;
          in_array(10, $valores) ? $_SESSION['empresa'] = 1 : $_SESSION['empresa'] = 0;
          //FIN PERMISOS DEL USUARIO   
          header("Location:" . Conectar::ruta() . "vistas/home.php");
          exit();
        } else {
          //si no existe el registro entonces le aparece un mensaje
          header("Location:" . Conectar::ruta() . "index.php?m=1");
          exit();
        }
      } //cierre del else
    } //condicion enviar
  }

  //listar los usuarios
  public function get_usuarios()
  {
    $conectar = parent::conexion();
    parent::set_names();
    $sql = "select * from usuarios";
    $sql = $conectar->prepare($sql);
    $sql->execute();
    return $resultado = $sql->fetchAll();
  }

  //metodo para registrar usuario
  public function registrar_usuario($nombre, $apellido, $cedula, $telefono, $email, $direccion, $cargo, $usuario, $password1, $password2, $estado, $permisos)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $sql = "insert into usuarios 
             values(null,?,?,?,?,?,?,?,?,?,?,now(),?);";
    $sql = $conectar->prepare($sql);
    $sql->bindValue(1, $_POST["nombre"]);
    $sql->bindValue(2, $_POST["apellido"]);
    $sql->bindValue(3, $_POST["cedula"]);
    $sql->bindValue(4, $_POST["telefono"]);
    $sql->bindValue(5, $_POST["email"]);
    $sql->bindValue(6, $_POST["direccion"]);
    $sql->bindValue(7, $_POST["cargo"]);
    $sql->bindValue(8, $_POST["usuario"]);
    $sql->bindValue(9, $_POST["password1"]);
    $sql->bindValue(10, $_POST["password2"]);
    $sql->bindValue(11, $_POST["estado"]);
    $sql->execute();
    //obtenemos el valor del id del usuario
    $id_usuario = $conectar->lastInsertId();
    //insertamos los permisos
    //almacena todos los checkbox que han sido marcados
    //este es un array tiene un name=permiso[]
    $permisos = $_POST["permiso"];
    // print_r($_POST);
    $num_elementos = 0;
    while ($num_elementos < count($permisos)) {
      $sql_detalle = "insert into usuario_permiso
                values(null,?,?)";
      $sql_detalle = $conectar->prepare($sql_detalle);
      $sql_detalle->bindValue(1, $id_usuario);
      $sql_detalle->bindValue(2, $permisos[$num_elementos]);
      $sql_detalle->execute();
      //recorremos los permisos con este contador
      $num_elementos = $num_elementos + 1;
    }
  }
  //metodo para editar usuario
  public function editar_usuario($id_usuario, $nombre, $apellido, $cedula, $telefono, $email, $direccion, $cargo, $usuario, $password1, $password2, $estado, $permisos)
  {

    $conectar = parent::conexion();
    parent::set_names();
    require_once("Usuarios.php");
    $usuarios = new Usuarios();
    //verifica si el id_usuario tiene registro asociado a compras
    $usuario_compras = $usuarios->get_usuario_por_id_compras($_POST["id_usuario"]);
    //verifica si el id_usuario tiene registro asociado a ventas
    $usuario_ventas = $usuarios->get_usuario_por_id_ventas($_POST["id_usuario"]);
    //si el id_usuario NO tiene registros asociados en las tablas compras y ventas entonces se puede editar todos los campos de la tabla usuarios
    if (is_array($usuario_compras) == true and count($usuario_compras) == 0 and is_array($usuario_ventas) == true and count($usuario_ventas) == 0) {
      $sql = "update usuarios set 
                  nombres=?,
                  apellidos=?,
                  cedula=?,
                  telefono=?,
                  correo=?,
                  direccion=?,
                  cargo=?,
                  usuario=?,
                  password=?,
                  password2=?,
                  estado=?
                  where 
                  id_usuario=?
                ";
      $sql = $conectar->prepare($sql);
      $sql->bindValue(1, $_POST["nombre"]);
      $sql->bindValue(2, $_POST["apellido"]);
      $sql->bindValue(3, $_POST["cedula"]);
      $sql->bindValue(4, $_POST["telefono"]);
      $sql->bindValue(5, $_POST["email"]);
      $sql->bindValue(6, $_POST["direccion"]);
      $sql->bindValue(7, $_POST["cargo"]);
      $sql->bindValue(8, $_POST["usuario"]);
      $sql->bindValue(9, $_POST["password1"]);
      $sql->bindValue(10, $_POST["password2"]);
      $sql->bindValue(11, $_POST["estado"]);
      $sql->bindValue(12, $_POST["id_usuario"]);
      $sql->execute();
      //SE ELIMINAN LOS PERMISOS SOLO CUANDO SE ENVIE EL FORMULARIO CON SUBMIT
      //Eliminamos todos los permisos asignados para volverlos a registrar
      $sql_delete = "delete from usuario_permiso where id_usuario=?";
      $sql_delete = $conectar->prepare($sql_delete);
      $sql_delete->bindValue(1, $_POST["id_usuario"]);
      $sql_delete->execute();
      //$resultado=$sql_delete->fetchAll();
      //insertamos los permisos
      //almacena todos los checkbox que han sido marcados
      //este es un array tiene un name=permiso[]
      $permisos = $_POST["permiso"];
      // print_r($_POST);
      $num_elementos = 0;
      while ($num_elementos < count($permisos)) {
        $sql_detalle = "insert into usuario_permiso
                            values(null,?,?)";
        $sql_detalle = $conectar->prepare($sql_detalle);
        $sql_detalle->bindValue(1, $_POST["id_usuario"]);
        $sql_detalle->bindValue(2, $permisos[$num_elementos]);
        $sql_detalle->execute();
        //recorremos los permisos con este contador
        $num_elementos = $num_elementos + 1;
      }
    } else {
      //si el usuario tiene registros asociados en compras y ventas entonces no se edita el nombre, apellido y cedula
      $sql = "update usuarios set 
                  telefono=?,
                  correo=?,
                  direccion=?,
                  cargo=?,
                  usuario=?,
                  password=?,
                  password2=?,
                  estado=?
                  where 
                  id_usuario=?
                ";
      //echo $sql; exit();
      $sql = $conectar->prepare($sql);
      $sql->bindValue(1, $_POST["telefono"]);
      $sql->bindValue(2, $_POST["email"]);
      $sql->bindValue(3, $_POST["direccion"]);
      $sql->bindValue(4, $_POST["cargo"]);
      $sql->bindValue(5, $_POST["usuario"]);
      $sql->bindValue(6, $_POST["password1"]);
      $sql->bindValue(7, $_POST["password2"]);
      $sql->bindValue(8, $_POST["estado"]);
      $sql->bindValue(9, $_POST["id_usuario"]);
      $sql->execute();
      //SE ELIMINAN LOS PERMISOS SOLO CUANDO SE ENVIE EL FORMULARIO CON SUBMIT
      //Eliminamos todos los permisos asignados para volverlos a registrar
      $sql_delete = "delete from usuario_permiso where id_usuario=?";
      $sql_delete = $conectar->prepare($sql_delete);
      $sql_delete->bindValue(1, $_POST["id_usuario"]);
      $sql_delete->execute();
      //$resultado=$sql_delete->fetchAll();
      //insertamos los permisos
      //almacena todos los checkbox que han sido marcados
      //este es un array tiene un name=permiso[]
      if (isset($_POST["permiso"])) {
        $permisos = $_POST["permiso"];
      }
      //print_r($_POST);
      $num_elementos = 0;

      while ($num_elementos < count($permisos)) {

        $sql_detalle = "insert into usuario_permiso
                            values(null,?,?)";

        $sql_detalle = $conectar->prepare($sql_detalle);
        $sql_detalle->bindValue(1, $_POST["id_usuario"]);
        $sql_detalle->bindValue(2, $permisos[$num_elementos]);
        $sql_detalle->execute();


        //recorremos los permisos con este contador
        $num_elementos = $num_elementos + 1;
      }  //fin while


    } // fin else


  } //fin de function



  //mostrar los datos del usuario por el id
  public function get_usuario_por_id($id_usuario)
  {

    $conectar = parent::conexion();
    parent::set_names();

    $sql = "select * from usuarios where id_usuario=?";

    $sql = $conectar->prepare($sql);

    $sql->bindValue(1, $id_usuario);
    $sql->execute();

    return $resultado = $sql->fetchAll();
  }

  //editar el estado del usuario, activar y desactiva el estado

  public function editar_estado($id_usuario, $estado)
  {


    $conectar = parent::conexion();
    parent::set_names();

    //el parametro est se envia por via ajax
    if ($_POST["est"] == "0") {

      $estado = 1;
    } else {

      $estado = 0;
    }

    $sql = "update usuarios set 
            
            estado=?

            where 
            id_usuario=?


   	    	";

    $sql = $conectar->prepare($sql);


    $sql->bindValue(1, $estado);
    $sql->bindValue(2, $id_usuario);
    $sql->execute();
  }


  //valida correo y cedula del usuario

  public function get_cedula_correo_del_usuario($cedula, $email)
  {

    $conectar = parent::conexion();
    parent::set_names();

    $sql = "select * from usuarios where cedula=? or correo=?";

    $sql = $conectar->prepare($sql);

    $sql->bindValue(1, $cedula);
    $sql->bindValue(2, $email);
    $sql->execute();

    return $resultado = $sql->fetchAll();
  }


  //método para eliminar un registro
  public function eliminar_usuario($id_usuario)
  {

    $conectar = parent::conexion();


    $sql = "delete from usuarios where id_usuario=?";

    $sql = $conectar->prepare($sql);
    $sql->bindValue(1, $id_usuario);
    $sql->execute();

    return $resultado = $sql->fetch();
  }


  //consulta si el id_usuario tiene una compra asociada
  public function get_usuario_por_id_compras($id_usuario)
  {


    $conectar = parent::conexion();
    parent::set_names();


    $sql = "select u.id_usuario,c.id_usuario
                 
              from usuarios u 
              
              INNER JOIN compras c ON u.id_usuario=c.id_usuario


              where u.id_usuario=?

              ";

    $sql = $conectar->prepare($sql);
    $sql->bindValue(1, $id_usuario);
    $sql->execute();

    return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
  }


  //consulta si el id_usuario tiene una venta asociada
  public function get_usuario_por_id_ventas($id_usuario)
  {


    $conectar = parent::conexion();
    parent::set_names();


    $sql = "select u.id_usuario,v.id_usuario
                 
             from usuarios u 
              
              INNER JOIN ventas v ON u.id_usuario=v.id_usuario


              where u.id_usuario=?

              ";

    $sql = $conectar->prepare($sql);
    $sql->bindValue(1, $id_usuario);
    $sql->execute();

    return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
  }



  // esta function alista los permisos (NO MARCADOS)
  public function permisos()
  {

    $conectar = parent::conexion();

    $sql = "select * from permisos;";

    $sql = $conectar->prepare($sql);
    $sql->execute();
    return $resultado = $sql->fetchAll();
  }


  //listamos los permisos asignados al usuario 

  //tambien se usa para verificar para que modulos tiene acceso 

  public function listar_permisos_por_usuario($id_usuario)
  {
    $conectar = parent::conexion();
    $sql = "select * from usuario_permiso where id_usuario=?";
    $sql = $conectar->prepare($sql);
    $sql->bindValue(1, $id_usuario);
    $sql->execute();
    return $resultado = $sql->fetchAll();
  }

  public function get_usuario_permiso_por_id_usuario($id_usuario)
  {
    $conectar = parent::conexion();
    $sql = "select * from usuario_permiso where id_usuario=?";
    $sql = $conectar->prepare($sql);
    $sql->bindValue(1, $id_usuario);
    $sql->execute();
    return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
  }
}
