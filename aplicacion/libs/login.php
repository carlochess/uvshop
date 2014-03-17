<?php

/**
 * Clase login
 * maneja el log-in y el log-out del usuario
 */
class Login
{
    public function __construct()
    {
		if(!isset($_SESSION)) 
		{ 
			session_start(); 
		} 
		
        if (isset($_GET["logout"])) {
            $this->salir();
        }
        
        elseif (isset($_POST["login"])) {
            $this->entrar();
        }
    }

    /**
     * Luego de hacer un post
     */
    private function entrar()
    {
        if (empty($_POST['login_ususario'])) {
            echo "Usuario vacio.";
        } elseif (empty($_POST['pass_ususario'])) {
            echo "Contraseña vacio.";
        } elseif (!empty($_POST['login_ususario']) && !empty($_POST['pass_ususario'])) {
			$home = $this->loadModel("modelLogin");
            $home->login();			
        }
    }

    /**
     * perform the logout
     */
    public function salir()
    {
        // destruye la sesion del usuario
        $_SESSION = array();
        session_destroy();
    }

    /**
     * retorna el status de conexión de un usuario
     * @return bool status del ususario
     */
    public static function estaConectado()
    {
        if (isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] == 1) {
            return true;
        }
        return false;
    }
}
