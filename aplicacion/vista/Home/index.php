    <!-- ==================================================   Carusel  ================================================== -->
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
	  <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner">
	  
	  <!-- Primer item -->
        <div class="item active">
          <img src=<?php echo URL."imagenes/10291504.jpg";?> alt="First slide">
          <div class="container">
            <div class="carousel-caption">
              <h1>Uv shop.</h1>
              <p>Aquí encontraras los mejores precios y productos que ningun otro sitio puede ofrecerte.</p>
              <p><a class="btn btn-lg btn-primary" href="#" role="button">Registrate</a></p>
            </div>
          </div>
        </div>
		<!-- Segundo item -->
        <div class="item">
          <img src=<?php echo URL."imagenes/10291505.jpg";?> alt="Second slide">
          <div class="container">
            <div class="carousel-caption">
              <h1>¿quieres ver nuestras promociones?.</h1>
              <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
              <p><a class="btn btn-lg btn-primary" href="#" role="button">Ver</a></p>
            </div>
          </div>
        </div>
		<!-- Tercer item -->
        <div class="item">
		  <img src=<?php echo URL."imagenes/10291506.jpg";?> alt="Third slide">
          <div class="container">
            <div class="carousel-caption">
              <h1>Busca por categorias.</h1>
              <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
              <p><a class="btn btn-lg btn-primary" href="#" role="button">Buscar</a></p>
            </div>
          </div>
        </div>
      </div>
	  
      <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
      <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
    </div>
	
	<!-- ==================================================   buscador  ================================================== input-medium search-query-->
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

    <div class="container marketing">
	
      <!-- ==================================================   Tres productos  ================================================== -->
	  <h1 class="page-header">Articulos</h1>
	  <div class="row">
		<?php foreach ($productosAleatorios as $prod) { ?>
			<div class="col-lg-4">
				<a href="<?php echo URL.'producto/info/'.$prod->id_prod; ?>">
					<img 
					   class="img-circle"
					   src="<?php echo URL.'imagenes/'.$prod->ruta.'x200.jpg'; ?>" 
					>
				</a>
			  <h2><a href="<?php echo URL.'producto/info/'.$prod->id_prod; ?>"><?php echo $prod->nombre; ?></a></h2>
			  <p><?php echo $prod->descripcion; ?></p>
			  <p><strong><?php echo $prod->precio; ?><string></p>
			  <p><a class="btn btn-default" href="<?php echo URL.'producto/info/'.$prod->id_prod; ?>" role="button">Ver mas &raquo;</a></p>
			</div>
		<?php } ?>
		
      </div>
	<hr class="featurette-divider">
	<!-- ==================================================   Promociones  ================================================== -->
      <h1 class="page-header">Promociones</h1>
		<?php foreach ($promos as $prod) { ?>
			<div class="row featurette">
			<div class="col-md-7">
			  <h1 class="featurette-heading"> <?php echo $prod->nombre; ?></h1>
			  <p><h2> <?php echo $prod->valor*((100-$prod->porcetaje_red)/100); ?></h2></p>
			  <p class="lead"><?php echo $prod->descripcion; ?></p>
			</div>
			<div class="col-md-5">
				<div style="position: relative; left: 0; top: 0;">
				  <img class="featurette-image img-responsive" src="<?php echo URL.'imagenes/'.$prod->id_prod.'x400.jpg'; ?>" style="position: relative; top: 0; left: 0;"/>
				  <div class="numeroCirculo" style="position: absolute; top: 20px; left: 300px;">-<?php echo $prod->porcetaje_red; ?>%</div>
				</div>
			</div>
		  </div>
		<?php } ?>

      <hr class="featurette-divider">
	<!-- ==================================================   Footer  ================================================== -->

	