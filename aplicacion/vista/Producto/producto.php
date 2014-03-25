
<div class="container-fluid">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<form action="<?php echo URL; ?>buscador/buscar" method="post">
				<div class="input-group">
				  <input type="text" class="form-control" name="nombre">
				  <div class="input-group-btn">
					<button type="submit" class="btn btn-info">Buscar</button>
				  </div>
				</div>
			</form>
		</div>
		<div class="col-md-3"></div>
	</div>
	 <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header"> <?php  echo $prod->nombre; ?> </h1>
            <div class="panel panel-default">
				<div class="row">
					<div class="col-sm-6 col-md-4">
						<div class="thumbnail">
						  <img class="img-thumbnail" src="<?php echo URL.'imagenes/'.$prod->id_prod.'x400.jpg';?>">
						</div>
					</div>
					<div class="col-md-6">
						<p> Nombre: <?php echo $prod->nombre; ?> </p>
						<p> Empresa fabricante: <?php echo $prod->empresa_fab; ?> </p>
						<p> Iva: <?php echo $prod->iva; ?> </p>
						Codigo:<p id="codigo"><?php echo $prod->id_prod; ?></p>
						<button id="agregarCarrito" class="btn btn-primary">Comprar</button>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="container" style="padding-top:50px;padding-bottom:25px;">
						<?php echo $prod->descripcion;?>
					</div>
				</div>
			</div>
			<div class="row">
				<?php foreach ($productosAleatorios as $prod) { ?>
					<div class="col-md-3">
						<a href="<?php echo URL.'producto/info/'.$prod->id_prod; ?>">
							<img 
							   class="img-thumbnail"
							   src="<?php echo URL.'imagenes/'.$prod->id_prod.'x200.jpg'; ?>" 
							   alt="Generic placeholder image"
							>
						</a>
					  <h2><a href="<?php echo URL.'producto/info/'.$prod->id_prod; ?>"><?php echo $prod->nombre; ?></a></h2>
					  <p><?php echo $prod->descripcion; ?></p>
					</div>
				<?php } ?>
			</div>
			
	</div>
</div>
