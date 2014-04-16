
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
	<div class="row" style="padding-right: 50px;">
		<div class="col-md-4">
			<h1 class="page-header"> Resumen </h1>
				<table id="productos" class="table table-hover">
					<tr>
						<th> imagen </th>
						<th> id </th>
						<th> Nombre </th>
						<th> Cantidad </th>
					<tr>
					<?php $i =0; foreach($detallesProductos as $producto) { ?>
					<tr>
						<td> <img src="<?php echo URL.'imagenes/'.$producto->id_prod.'x50.jpg'; ?>" /> </td>
						<td> <?php echo $producto->id_prod; ?> </td>
						<td> <?php echo $producto->nombre; ?> </td>
						<td> <?php echo $cantidades[$i]; $i++;?> </td>
					</tr>
					<?php } ?>
				</table>
		</div>	
		<div class="col-md-8">
			<h1 class="page-header"> Recibo de pago </h1>
				Total <p id="Restan"> <?php echo $total; ?> </p>
				Restan <p id="Total"> <?php echo $total; ?> </p>

				<table id="agregar" class="table">
					<tr>
						<th> ¿eliminar? </th>
						<th> Medio_de_pago </th>
						<th> Numero_de_cuotas </th>
						<th> monto </th>
					<tr>
					<tr>
						<td> </td>
						<td> 
							<select id="mPago"  class="form-control">
								<option value="tarjeta" selected="selected"> Tarjeta </option>    
								<option value="efectivo"> Efectivo </option>
							</select>
						</td>
						<td> 
							<input class="form-control"  id="nCuotas" type="text" value="22" />
						</td>
						<td> <input class="form-control"  id="monto" type="text" value="22" /> </td>
						<td> <button id="bAgregar" class="btn btn-info"> Agregar </button> </td>
					<tr>
				</table>
				
				<table id="agregados" class="table">
				
		</div>
		<div>
            <p class="text-right">
				<a href="<?php echo URL.'pago/' ?>">
					<button class= "btn btn-alert" id="volver"> << Volver </button>
				</a>
				<form action="<?php echo URL.'pago/confirmar'; ?>" method="post">
					<input type="hidden" id="id" name="metodosFIN" value="">
					<input type="hidden" id="id2" name="prodFIN" value="">
					<button class= "btn btn-success"  type="submit" id="pagar"> Pagar >> </button>
				<form>
			</p>
		</div>
	</div>
</div>
