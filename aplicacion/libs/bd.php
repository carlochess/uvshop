<?php

class MySQL {
	static private $mysql;
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
	
	private function __construct(){
		//$this->database = DB_USER;
		//$this->username = $username;
		//$this->password = $password;
		//$this->hostname = $hostname.':'.$port;
		$this->conectar();
	}
	
	/* *******************
	 * Funciones privadas *
	 * *******************/
	
	// Conecta a la BD
	private function /* bool */ conectar(){
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
	
	public static function getBD(){
		if (self::$mysql == null) {
			self::$mysql = new MySQL();
        }
        return self::$mysql;
	}
	
	// Ejecuta una consulta en Mysql
	function /* array(stdClass) */ ejecutarConsultaSelect($query){
		$query = $this->db->prepare($query);
                $query->execute();
		$this->filasAfectadas = $query->rowCount();
		return $query->fetchAll();
	}
	function /* void */ ejecutarConsultaI($q){
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
	function /* void */ insertar($query){
		$filasAfectadas = $this->db->exec($query);
	}
	
	// Retorna el número de filas del resultado de una
	// consulta.
	function /* int */ contarFilasAfectadas(){
		return $this->filasAfectadas;
	}
	
	// Retorna el id de la última inserción 
	// ver http://es.wikipedia.org/wiki/ACID
	function /* string */ getLastID(){
		return $this->db->lastInsertId();
	}
	
	// Cierra la conexión
	function /* void */ cerrarConexion(){
		$this->db = null;
	}
}

?>