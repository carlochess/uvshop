	<div class="container-fluid">
      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Detalles orden de compra: <?php echo $id[0]; ?> </h1>

            <div class="panel panel-default">
				<div class="panel-body">
					<h2>Productos comprados</h1>
					<p class="text-right"> <a href="<?php echo URL.'admin/ventas/' ?>"> <button class= "btn btn-success"> Volver a facturas </button> </a> </p>
						<table class="table table-hover">
							<tr>
								<th> imagen </th>
								<th> id prod  </th>
								<th> cantidad productos </th>
								
							<tr>
							<?php foreach($productos as $producto) { ?>
							<tr>
								<td> <img src="<?php echo URL.'imagenes/'.$producto->id_prod.'x50.jpg'; ?>" /> </td>
								<td> <?php echo $producto->id_prod; ?> </td>
								<td> <?php echo $producto->cant_prod; ?> </td>
								
							</tr>
							<?php } ?>
						</table>
				</div>
			</div>
			
			
	</div>
	
	