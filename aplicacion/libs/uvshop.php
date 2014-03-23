<?php

class Uvshop
{
    /** @var controlador = sustantivo */
    private $url_controlador = null;
    /** @var método del controlador */
    private $url_accion = null;
    /** @var arreglo de parametros */
    private $url_parametros = null;

    public function __construct()
    {
        $this->separarUrl();
		// Verifica si estas logeado
		//$login = new Login();
		//if($login->estaConectado())
		//	echo "Estas logeado";
        // verifica si el controlador existe
        if (file_exists('aplicacion/controlador/' . $this->url_controlador . '.php')) {
			// Si lo hace, entonces carga el contenido
            require 'aplicacion/controlador/' . $this->url_controlador . '.php';
            $this->url_controlador = new $this->url_controlador();

            // verifica si el método, dentro del controlador, existe.
            if (method_exists($this->url_controlador, $this->url_accion)) {
				// Llama al método seleccionado
                if (isset($this->url_parametros)) {
                    $this->url_controlador->{$this->url_accion}($this->url_parametros);
                } else {
                    $this->url_controlador->{$this->url_accion}();
                }
            } else {
                // Vuelve a la página principal
                $this->url_controlador->index();
            }
        } else {
            // Url invalida, redirigir a Home
            require 'aplicacion/controlador/home.php';
            $home = new Home();
            $home->index();
        }
    }

    /**
     * Recibir y separar la URL
     */
    private /* void */ function separarUrl()
    {
        if (isset($_GET['url'])) {
            // separa la url
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
			$numElem = count($url);
            // Colocamos las partes de la URL en sus respectivos atributos
            $this->url_controlador = (isset($url[0]) ? $url[0] : null);
            $this->url_accion = (isset($url[1]) ? $url[1] : null);
			if($numElem>2)
			{
				$this->url_parametros = array_slice($url,2,$numElem);
			}
        }
    }
}
