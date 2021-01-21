<?php
session_start();
	class Conectar {
		protected $dbh;
		protected function conexion(){
			try {
				$conectar = $this->dbh = new PDO("mysql:local=localhost;dbname=dbproyecto","root","");
				$conectar->query("SET NAMES 'utf8'");
				return $conectar;
			} catch (Exception $e) {
				print "¡Error!: " . $e->getMessage() . "<br/>";
				die();  
			}
		}

		public function set_names(){
			return $this->dbh->query("SET NAMES 'utf8'");
		}

		public function ruta(){
			return "http://localhost:80/ProyectoMySQL/";
		}

		public static function convertir($string){
			$string = str_replace(
				array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'),
				array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', ' DICIEMBRE'),
				$string
			);

			return $string;
		}

	}
?>