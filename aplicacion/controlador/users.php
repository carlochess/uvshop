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
        $error = "Esta mal";
        require('aplicacion/vista/Usuarios/header.php');
        require('aplicacion/vista/Usuarios/registro.php');
        require('aplicacion/vista/Usuarios/footer.php');
    }
    
    public function facebook(){
        require('aplicacion/vista/Usuarios/header.php');
        require('aplicacion/vista/Usuarios/facebook.php');
        require('aplicacion/vista/Usuarios/footer.php');
    }
}
