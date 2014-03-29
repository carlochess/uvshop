
<?php

class ModelLogin
{
	/* Clase encargada de las consultas a la bd*/
	public $oMySQL;
	
	function __construct(MySQL $db)
	{
		
		$this->oMySQL = $db;
	}
	
	/** Toda la info del producto */
	function login()
	{
			// escape the POST stuff
			$user_name = $_POST['login_ususario'];
			// Inyección SQL a la vista :D
			$sql = "SELECT nombre, password
					FROM login
					WHERE nombre = '" . $user_name ."';";
			
			$resultado = $this->oMySQL->ejecutarConsultaSelect($sql);
			
			// if this user exists
			if ($this->oMySQL->contarFilasAfectadas() == 1) {

				// get result row (as an object)
				$result_row = $resultado[0];

				// using PHP 5.5's password_verify() function to check if the provided password fits
				// the hash of that user's password
				if (strcmp(md5($_POST['pass_ususario']),$result_row->password)==0) {

					// write user data into PHP SESSION (a file on your server)
					$_SESSION['user_name'] = $result_row->nombre;
					$_SESSION['user_email'] = "borrar@borrador.com";
					$_SESSION['user_login_status'] = 1;

				} else {
					echo "Wrong password. Try again. ".$result_row->password." != ". md5($_POST['pass_ususario']);
				}
			} else {
				echo "This user does not exist.";
			}
			$this->terminarConexion();
	}
	
	
	/**
	* Función que termina la conexión con la base de datos
	*/
	function terminarConexion()
	{
		$this->oMySQL->cerrarConexion();
	}
}
?>