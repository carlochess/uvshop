<?php

Class Users extends Controlador {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        
    }

    public function sign_up() {
        echo 'hola mundo';
    }

    public function registro() {

        require('aplicacion/vista/Usuarios/header.php');
        require('aplicacion/vista/Usuarios/registro.php');
        require('aplicacion/vista/Usuarios/footer.php');
    }
    
    public function registrarse() {
        print_r($_POST);
    }

}
