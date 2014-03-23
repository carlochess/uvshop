	
<?php
	/**
	* Clase encargada de las validaciones de los datos
	* que entran a la aplicación
	* TODO: validaciones de tipo
	* TODO: validaciones de formato
	*/
	class validador
	{
		/**
		* Función que remueve espacios y caracteres no deseados
		* @param string $data cadena a analizar.
		*/
		function /*string*/ test_input($data)
		{
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}
	}
?>