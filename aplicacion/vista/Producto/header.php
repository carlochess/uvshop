<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <script src="<?php echo URL; ?>public/producto/holder.js"></script>

        <title>Producto</title>
        <link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
        <link href="<?php echo URL; ?>public/producto/carrito.css" rel="stylesheet">
    </head>
    <body>
        <div class="navbar-inverse navbar-static-top" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo URL; ?>">UvShop</a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="<?php echo URL; ?>">Home</a></li>
                        <li><a href="<?php echo URL . 'home/about'; ?>">Acerca de</a></li>
                        <li><a href="<?php echo URL . 'home/contact'; ?>">Contactos</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Categorias <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <?php foreach ($this->categorias as $cat) { ?>
                                    <li><a href="<?php echo URL . 'buscador/categoria/' . str_replace(' ', '_', $cat); ?>"><?php echo $cat; ?> </a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <ul class="nav navbar-nav navbar-right" style="padding-right:60px">
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
                        </ul>
                        <li><a href="./">Cuenta</a></li>
                        <li><a href="../navbar-static-top/">Salir</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div><!--/.container-fluid -->
        </div>