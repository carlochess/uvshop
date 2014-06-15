<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Index</title> <!-- Variable titulos -->

        <link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
        <link href="<?php echo URL; ?>public/producto/carrito.css" rel="stylesheet">
        <link href="<?php echo URL; ?>public/carousel.css" rel="stylesheet">
    </head>
    <!-- NAVBAR ================================================== -->
    <body>
        <div class="navbar">
            <div class="container">
                <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                    <div class="container">
                        <div class="navbar-header">
                            <a class="navbar-brand" href="<?php echo URL; ?>">UvShop</a>
                        </div>
                        <div class="navbar-collapse collapse">
                            <ul class="nav navbar-nav">
                                <li class="active"><a href="<?php echo URL; ?>">Home</a></li>
                                <li><a href="<?php echo URL . 'home/about'; ?>">Acerca de</a></li>
                                <li><a href="<?php echo URL . 'admin'; ?>">Admin</a></li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Categorias <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <?php foreach ($categorias as $cat) { ?>
                                            <li><a href="<?php echo URL . 'buscador/categoria/' . str_replace(' ', '_', $cat); ?>"><?php echo $cat; ?> </a></li>
                                        <?php } ?>
                                    </ul>
                                </li>
                                <li>
                                    <form action="<?php echo URL; ?>buscador/buscar" method="post">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="nombre">
                                            <button type="submit" class="from btn btn-default">Buscar</button>
                                        </div>
                                    </form>
                                </li>
                            </ul>

                            <ul class="nav navbar-nav pull-right">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <ul>
                                            <li class="notification-container">
                                                <i class="fa fa-shopping-cart fa-lg"></i>
                                                <span class="notification-counter">0</span>
                                            </li>
                                        </ul>
                                    </a>
                                    <ul class="dropdown-menu" id="carrito">
                                        <li class="divider"></li>
                                        <li><a href="#">Comprar</a></li>
                                    </ul>
                                </li>
                                <!----	<li><a href="/users/sign_up">Registrarse</a></li> --->
                                <ul class="navbar-form navbar-left">
                                        <form action="<?php echo URL; ?>buscador/buscar" method="post">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="nombre">
                                                </div>
                                                <button type="submit" class="btn btn-default">Buscar</button>
                                        </form>
                                </ul>
		            	<!----	<li><a href="/users/sign_up">Registrarse</a></li> --->
                                <li> <a href="<?php echo URL; ?>users/registro">Registrarse</a></li>
                                <li class="divider-vertical"></li>
                                <li class="dropdown" id="loggin">
                                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">Entrar <strong class="caret"></strong></a>
                                    <div class="dropdown-menu" style="padding: 15px; padding-bottom: 0px;">
                                        <form method="post" action="index.php" name="loginform" style="padding:20px;">
                                            <label for="login_input_username">Usuario</label>
                                            <input id="login_input_username" class="form-control" type="text" name="login_ususario"  required />

                                            <label for="login_input_password">Password</label>
                                            <input id="login_input_password" class="form-control" type="password" name="pass_ususario" autocomplete="off" required />

                                            <input type="submit" class="btn-primary" name="login" value="Log in" />
                                        </form>
                                        <a href="<?php echo URL; ?>users/facebook">Log in FB </a>
                                        <a href="<?php echo URL; ?>users/gmail">Log in G+ </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>



        <!-- ================================================== Fin Cabezote ================================================== -->
