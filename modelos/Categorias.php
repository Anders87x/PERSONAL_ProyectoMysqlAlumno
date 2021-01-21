<?php
require_once("../config/conexion.php");
class Categoria extends Conectar
{

   public function get_filas_categoria()
   {
      $conectar = parent::conexion();
      $sql = "select * from categoria";
      $sql = $conectar->prepare($sql);
      $sql->execute();
      $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
      return $sql->rowCount();
   }

   //método para seleccionar registros
   public function get_categorias()
   {
      $conectar = parent::conexion();
      parent::set_names();
      $sql = "select * from categoria";
      $sql = $conectar->prepare($sql);
      $sql->execute();
      return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
   }

   //método para mostrar los datos de un registro a modificar
   public function get_categoria_por_id($id_categoria)
   {
      $conectar = parent::conexion();
      parent::set_names();
      $sql = "select * from categoria where id_categoria=?";
      $sql = $conectar->prepare($sql);
      $sql->bindValue(1, $id_categoria);
      $sql->execute();
      return $resultado = $sql->fetchAll();
   }

   //método para insertar registros
   public function registrar_categoria($categoria, $estado, $id_usuario)
   {
      $conectar = parent::conexion();
      parent::set_names();
      $sql = "insert into categoria
           values(null,?,?,?);";
      //echo $sql;
      $sql = $conectar->prepare($sql);
      $sql->bindValue(1, $_POST["categoria"]);
      $sql->bindValue(2, $_POST["estado"]);
      $sql->bindValue(3, $_POST["id_usuario"]);
      $sql->execute();
      //print_r($_POST);
   }

   public function editar_categoria($id_categoria, $categoria, $estado, $id_usuario)
   {
      $conectar = parent::conexion();
      parent::set_names();
      require_once("Categorias.php");
      $categorias = new Categoria();
      //verifica si el id_categoria tiene registro asociado a compras
      $categoria_compras = $categorias->get_categoria_por_id_compras($_POST["id_categoria"]);
      //verifica si el id_categoria tiene registro asociado a detalle_compras
      $categoria_detalle_compras = $categorias->get_categoria_por_id_detalle_compras($_POST["id_categoria"]);
      //si el id_categoria NO tiene registros asociados en las tablas detalle_compras entonces se puede editar todos los campos de la categoria
      if (is_array($categoria_compras) == true and count($categoria_compras) == 0 and is_array($categoria_detalle_compras) == true and count($categoria_detalle_compras) == 0) {
         $sql = "update categoria set 
                  categoria=?,
                  estado=?,
                  id_usuario=?
                  where 
                  id_categoria=?";
         //echo $sql; exit();
         $sql = $conectar->prepare($sql);
         $sql->bindValue(1, $_POST["categoria"]);
         $sql->bindValue(2, $_POST["estado"]);
         $sql->bindValue(3, $_POST["id_usuario"]);
         $sql->bindValue(4, $_POST["id_categoria"]);
         $sql->execute();
      } else {
         //si la categoria tiene registros asociados en compras y detalle_compras entonces no se edita la categoria
         $sql = "update categoria set 
                  estado=?,
                  id_usuario=?
                  where 
                  id_categoria=?";
         //echo $sql; exit();
         $sql = $conectar->prepare($sql);
         $sql->bindValue(1, $_POST["estado"]);
         $sql->bindValue(2, $_POST["id_usuario"]);
         $sql->bindValue(3, $_POST["id_categoria"]);
         $sql->execute();
      }
   }
   //método para activar Y/0 desactivar el estado de la categoria
   public function editar_estado($id_categoria, $estado)
   {
      $conectar = parent::conexion();
      //si el estado es igual a 0 entonces el estado cambia a 1
      //el parametro est se envia por via ajax
      if ($_POST["est"] == "0") {
         $estado = 1;
      } else {
         $estado = 0;
      }
      $sql = "update categoria set
              estado=?
              where 
              id_categoria=?
        	 ";
      $sql = $conectar->prepare($sql);
      $sql->bindValue(1, $estado);
      $sql->bindValue(2, $id_categoria);
      $sql->execute();
   }

   //método si la categoria existe en la base de datos
   public function get_nombre_categoria($categoria)
   {
      $conectar = parent::conexion();
      $sql = "select * from categoria where categoria=?";
      //echo $sql; exit();
      $sql = $conectar->prepare($sql);
      $sql->bindValue(1, $categoria);
      $sql->execute();
      //print_r($email); exit();
      return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
   }
   //método para eliminar un registro
   public function eliminar_categoria($id_categoria)
   {
      $conectar = parent::conexion();
      $sql = "delete from categoria where id_categoria=?";
      $sql = $conectar->prepare($sql);
      $sql->bindValue(1, $id_categoria);
      $sql->execute();
      return $resultado = $sql->fetch();
   }

   public function get_categoria_por_id_usuario($id_usuario)
   {
      $conectar = parent::conexion();
      $sql = "select * from categoria where id_usuario=?";
      $sql = $conectar->prepare($sql);
      $sql->bindValue(1, $id_usuario);
      $sql->execute();
      return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
   }
   //consulta si el id_categoria tiene una compra asociada
   public function get_categoria_por_id_compras($id_categoria)
   {
      $conectar = parent::conexion();
      parent::set_names();
      $sql = "select c.id_categoria,comp.id_categoria            
           from categoria c 
              INNER JOIN compras comp ON c.id_categoria=comp.id_categoria
              where c.id_categoria=?";
      $sql = $conectar->prepare($sql);
      $sql->bindValue(1, $id_categoria);
      $sql->execute();
      return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
   }
   //consulta si el id_categoria tiene un detalle_compra asociado
   public function get_categoria_por_id_detalle_compras($id_categoria)
   {
      $conectar = parent::conexion();
      parent::set_names();
      $sql = "select c.id_categoria,d.id_categoria
           from categoria c 
              INNER JOIN detalle_compras d ON c.id_categoria=d.id_categoria
              where c.id_categoria=?";
      $sql = $conectar->prepare($sql);
      $sql->bindValue(1, $id_categoria);
      $sql->execute();
      return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
   }
}
