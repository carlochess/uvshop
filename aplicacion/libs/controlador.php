<?php

include_once  'bd.php';
/**
 * Clase base controladores
 */
class Controlador
{
	/* no implmentado */
	protected $login;
	private $oMySQL;
    function __construct(){
		
		$this->oMySQL = MySQL::getBD();
	}
    /**
     * Carga el modelo según el nombre.
     * @param string $model_name El nombre del modelo
     * @return objeto del modelo
     */
    public function loadModel($model_name)
    {
        require 'aplicacion/modelo/' . strtolower($model_name) . '.php';
        return new $model_name($this->oMySQL);
    }
}