	<div class="container-fluid">
      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Ventas</h1>

            <div class="panel panel-default">
				<div class="panel-body">
					<?php if(isset($facturas)){ ?>
						<table class="table table-hover">
							<tr>
								<th> id </th>
								<th> id cliente </th>
								<th> fecha </th>
								<th> cantidad productos </th>
								<th> controles </th>
								
							<tr>
							<?php foreach($facturas as $factura) { ?>
							<tr>
								<td> <?php echo $factura->id_factura; ?> </td>
								<td> <?php echo $factura->id_cliente; ?> </td>
								<td> <?php echo $factura->fecha; ?> </td>
								<td> <?php echo $factura->cantidad_productos; ?> </td>
								<td> <a href="<?php echo URL.'admin/ventas/'.$factura->id_factura; ?>"> <button class= "btn btn-info"> Detalles </button> </a> </p> </td>
							</tr>
							<?php } ?>
						</table>
					<?php }else {echo "No hay facturas hasta el momento";} ?>
				</div>
			</div>
			
			
	</div>
	