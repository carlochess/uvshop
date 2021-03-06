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
        
         $error;
        try{
            $nombreU=$_POST['nombreUsuario'];
            $apellidoU=$_POST['apellidoUsuario'];
            $tipoIDU=$_POST['tipoIDUsuario'];
            $idU=$_POST['idUsuario'];
            $telefonoU=$_POST['telefonoUsuario'];
            $fechaNacU=$_POST['fechaNUsuario'];
            $correoU=$_POST['correoUsuario'];
            
            $this->establecerDatos($nombreU,$apellidoU,$tipoIDU,$idU,$telefonoU,$fechaNacU,$correoU);
            $this->modelUsuario=$this->loadModel("modeloRegistroUsuario");
            $flag=$this->modelUsuario->existsUser($idU);
            if($flag){
                throw new Exception("Usuario Existente");
            } 
            $this->modelUsuario->createUser($nombreU,$apellidoU,$tipoIDU,$idU,$telefonoU,$fechaNacU,$correoU);
            $error="exito";
            require('aplicacion/vista/Usuarios/header.php');
            require('aplicacion/vista/Usuarios/registro.php');
            require('aplicacion/vista/Usuarios/footer.php');
            
        } catch (Exception $ex) {
            $error=$ex->getMessage();
       
            require('aplicacion/vista/Usuarios/header.php');
            require('aplicacion/vista/Usuarios/registro.php');
            require('aplicacion/vista/Usuarios/footer.php');
        } 
        
    }

    public function facebook() {

        $provider = new League\OAuth2\Client\Provider\Facebook(array(
            'clientId' => '526791157424846',
            'clientSecret' => '9e91996a32f9262e2ac9457b65883efd',
            'redirectUri' => 'http://uvshop.co/users/facebook/'
        ));

        if (!isset($_GET['code'])) {

            header('Location: ' . $provider->getAuthorizationUrl());
            exit;
        } else {
            
            try {
                $token = $provider->getAccessToken('AuthorizationCode', [
                    'code' => $_GET['code']
                ]);
            } catch (Exception $e) {
                echo "Error: " . $e;
            }

            try {

                $userDetails = $provider->getUserDetails($token);
                require('aplicacion/vista/Usuarios/header.php');
                require('aplicacion/vista/Usuarios/facebook.php');
                require('aplicacion/vista/Usuarios/footer.php');
            } catch (Exception $e) {

                // Failed to get user details
                exit('Dios...');
            }

            //echo $token->accessToken;
            //echo $token->refreshToken;
            //echo $token->expires;
        }

        
    }

    public function gmail() {
        require('aplicacion/vista/Usuarios/header.php');
        require('aplicacion/vista/Usuarios/gmail.php');
        require('aplicacion/vista/Usuarios/footer.php');
    }

}