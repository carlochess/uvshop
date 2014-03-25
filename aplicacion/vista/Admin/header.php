<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Administrador</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
    <link href="<?php echo URL.'public/admin/dashboard.css'; ?>" rel="stylesheet">
	<script src="<?php echo URL; ?>public/producto/holder.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
	<style>
		.modal {
			width: 80%; /* respsonsive width */
			margin-left:auto;
			margin-right:auto; 
		}
	</style>
  </head>

  <body> 
  
	<!-- Barra de navegación -->
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">UvShop admin</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="<?php echo URL ?>">Tienda</a></li>
            <li><a href="#">Configuración</a></li>
            <li><a href="#">Perfil</a></li>
            <li><a href="index.php?logout">Salir</a></li>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form>
        </div>
      </div>
    </div>
	<!-- Barra lateral + Contenido -->
    <div class="container-fluid">
      <div class="row">
		<!-- Barra lateral -->
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li class="active"><a href="<?php echo URL.'admin/';?>">Información</a></li>
            <li><a href="#">Reportes</a></li>
            <li><a href="#">Exportar</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li><a href="">Ventas</a></li>
          </ul>
		  <ul class="nav nav-sidebar">
            <li><a href="<?php echo URL.'admin/producto';?>">Productos</a></li>
			<li><a href="<?php echo URL.'admin/promociones';?>">Promociones</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li><a href="">Clientes</a></li>
          </ul>
		  
        </div>
	 