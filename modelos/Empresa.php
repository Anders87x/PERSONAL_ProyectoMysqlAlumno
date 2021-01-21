<?php

require_once("../config/conexion.php");

class Empresa extends Conectar
{
  public function get_empresa()
  {
    $conectar = parent::conexion();
    parent::set_names();
    $sql = "select * from empresa;";
    $sql = $conectar->prepare($sql);
    $sql->execute();
    return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
  }

  //metodo muestra la informacion de la empresa
  public function get_empresa_por_id_usuario($id_usuario_empresa)
  {
    $conectar = parent::conexion();
    $sql = "select * from empresa where id_usuario=?";
    $sql = $conectar->prepare($sql);
    $sql->bindValue(1, $id_usuario_empresa);
    $sql->execute();
    return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
  }

  public function get_datos_empresa($cedula, $cliente, $correo)
  {
    $conectar = parent::conexion();
    $sql = "select * from empresa where cedula_empresa=? or nombre_empresa=? or correo_empresa=?";
    $sql = $conectar->prepare($sql);
    $sql->bindValue(1, $cedula);
    $sql->bindValue(2, $cliente);
    $sql->bindValue(3, $correo);
    $sql->execute();
    return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
  }

  public function editar_empresa($id_usuario_empresa, $nombre, $cedula, $telefono, $email, $direccion)
  {
    $conectar = parent::conexion();
    $sql = "update empresa set 
                 cedula_empresa=?,
                 nombre_empresa=?,
                 direccion_empresa=?,
                 correo_empresa=?,
                 telefono_empresa=?

                 where 
                 id_usuario=?
          ";
    $sql = $conectar->prepare($sql);
    $sql->bindValue(1, $_POST["cedula_empresa"]);
    $sql->bindValue(2, $_POST["nombre_empresa"]);
    $sql->bindValue(3, $_POST["direccion_empresa"]);
    $sql->bindValue(4, $_POST["email_empresa"]);
    $sql->bindValue(5, $_POST["telefono_empresa"]);
    $sql->bindValue(6, $_POST["id_usuario_empresa"]);
    $sql->execute();
    $resultado = $sql->fetch(PDO::FETCH_ASSOC);
  }
}
