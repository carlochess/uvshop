
<div class="container-fluid">
	<div class="row" id="divBuscador">
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
			<h1 class="page-header"> Recibo de pago </h1>
			
            <div class="panel panel-default">
				<div class="panel panel-default">
					<div class="container" style="padding-top:50px;padding-bottom:25px;">
						<form action="<?php echo URL.'pago/modos'; ?>" method="post">
							<?php $i=0; foreach($detallesProductos as $producto) { ?>
							<div class="item" >
								<div class="titulo"><strong class="borrar"><span class="glyphicon glyphicon-remove"></span></strong> <?php echo $producto->nombre; ?> </div>
								<div class="row">
									<div class="col-xs-4"> <img src="<?php echo URL.'imagenes/'.$producto->id_prod.'x200.jpg'; ?>" /> </div>
									<input type="hidden" id="id" name="<?php echo $i;$i++; ?>" value="<?php echo $producto->id_prod; ?>">
									<div class="col-xs-8"> 
										<table class="table table-hover">
											<tr>
												<td> Código </td>
												<td> <?php echo $producto->id_prod; ?> </td>
											</tr>
											<tr>
												<td> Descripcion </td>
												<td> <?php echo $producto->descripcion; ?>  </td>
											</tr>
											<tr>
												<td> Empresa_fab </td>
												<td> <?php echo $producto->empresa_fab; ?>  </td>
											</tr>
											<tr>
												<td> Iva </td>
												<td><?php echo $producto->iva; ?> </td>
											</tr>
											<tr>
												<td> Valor unitario </td>
												<td class="valor"><?php echo $producto->precio; ?></td>
											</tr>
											<tr>
												<td> cantidad </td>
												<td><input type="text" class="cantidad" name="<?php echo $i;$i++; ?>" value="<?php echo $cantidadInit[($producto->id_prod)]; ?>" /> </td>
											</tr>
										</table>
									</div>
								</div>
								<div class="final">
									Subtotal: <p class="text-right"><?php echo $cantidadInit[($producto->id_prod)]*$producto->precio; ?></p>
								</div>
							</div>
							<?php } ?>
							<p class="text-right">
							<a href="<?php echo URL ?>">
								<button class= "btn btn-alert"  type="submit" id="pagar"> << Volver Index </button>
							</a>
								<button class= "btn btn-success"  type="submit" id="pagar"> Pagar >> </button>
							</p>
						</form>
					</div>
				</div>
				<div>
					
				</div>
			</div>	

			
	</div>
</div>
