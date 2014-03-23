<?php

class MySQL {
	
	var $lastError; // El último error
	var $lastQuery;	// Mantiene la última consulta
	var $filasAfectadas; // número de filas afectadas en un Ins
	
	var $hostname;	// dirección BD
	var $username;	// usuario BD
	var $password;	// Clave BD
	var $database;	// Nombre de la BD a conectar
	
	var $db;
	
	/* *******************
	 * Constructor       *
	 * *******************/
	
	function __construct($database='uvshop', $username= 'root', $password= 'Univalle', $hostname='localhost', $port=3306){
		$this->database = $database;
		$this->username = $username;
		$this->password = $password;
		$this->hostname = $hostname.':'.$port;
		
		$this->conectar();
	}
	
	/* *******************
	 * Funciones privadas *
	 * *******************/
	
	// Conecta a la BD
	private function conectar(){
		$options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
		try{
			$this->db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, $options);
		}catch(PDOException $e)
		{
			return false;
		}
		return true;
	}
	
	/* ******************
	 * Funciones públicas *
	 * ******************/
	
	// Ejecuta una consulta en Mysql
	function ejecutarConsultaSelect($query){
		$query = $this->db->prepare($query);
        $query->execute();
		$this->filasAfectadas = $query->rowCount();
		return $query->fetchAll();
	}
	function ejecutarConsultaI($q){
		try 
		{
			$query = $this->db->prepare($q);
			$query->execute();
			$this->filasAfectadas = $query->rowCount();
		} catch(PDOException $ex) {
			echo "<br/> Error al ejecutar consulta ".$ex->getMessage();
		}
	}
	
	// Consulta de insercion 
	function insertar($query){
		$filasAfectadas = $this->db->exec($query);
	}
	
	// Retorna el número de filas del resultado de una
	// consulta.
	function contarFilasAfectadas(){
		return $this->filasAfectadas;
	}
	
	// Cierra la conexión
	function cerrarConexion(){
		$this->db = null;
	}
}

?>