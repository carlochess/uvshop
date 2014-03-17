<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	<script src="<?php echo URL; ?>public/producto/holder.js"></script>
    <title>Buqueda</title>

    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  </head>
  <body>
  <div class="navbar-wrapper">
      <div class="container">
        <div class="navbar navbar-inverse navbar-static-top" role="navigation">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="<?php echo URL;?>">UvShop</a>
            </div>
            <div class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
                <li class="active"><a href="<?php echo URL;?>">Home</a></li>
                <li><a href="<?php echo URL.'home/about';?>">Acerca de</a></li>
                <li><a href="<?php echo URL.'home/contact';?>">Contactos</a></li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Categorias <b class="caret"></b></a>
                  <ul class="dropdown-menu">
					<?php foreach($categorias as $categoria){ ?>
						<li><a href="#"><?php echo $categoria->nombre; ?> </a></li>
					<?php } ?>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </div>

      </div>
    </div>