<?php

//conexión a la base de datos

require_once("../config/conexion.php");

class Perfil extends Conectar
{
   //método para mostrar los datos de un registro a modificar
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


   public function get_usuario_nombre($cedula, $email)
   {
      $conectar = parent::conexion();
      $sql = "select * from usuarios where cedula=? or correo=?";
      $sql = $conectar->prepare($sql);
      $sql->bindValue(1, $cedula);
      $sql->bindValue(2, $email);
      $sql->execute();
      //print_r($cedula); exit();
      return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
   }

   public function editar_perfil($id_usuario_perfil, $nombre_perfil, $apellido_perfil, $cedula_perfil, $telefono_perfil, $email_perfil, $direccion_perfil, $usuario_perfil, $password1_perfil, $password2_perfil)
   {

      $conectar = parent::conexion();


      $sql = "update usuarios set 
               
                 nombres=?,
                 apellidos=?,
                 cedula=?,
                 telefono=?,
                 correo=?,
                 direccion=?,
                
                 usuario=?,
                 password=?,
                 password2=?
                
                 where 
                 id_usuario=?
          ";

      //echo $sql;

      $sql = $conectar->prepare($sql);

      $sql->bindValue(1, $_POST["nombre_perfil"]);
      $sql->bindValue(2, $_POST["apellido_perfil"]);
      $sql->bindValue(3, $_POST["cedula_perfil"]);
      $sql->bindValue(4, $_POST["telefono_perfil"]);
      $sql->bindValue(5, $_POST["email_perfil"]);
      $sql->bindValue(6, $_POST["direccion_perfil"]);
      $sql->bindValue(7, $_POST["usuario_perfil"]);
      $sql->bindValue(8, $_POST["password1_perfil"]);
      $sql->bindValue(9, $_POST["password2_perfil"]);

      $sql->bindValue(10, $_POST["id_usuario_perfil"]);
      $sql->execute();
   }
}
