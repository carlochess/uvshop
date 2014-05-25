	<div class="container-fluid">
      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Reportes</h1>

            <div class="panel panel-default">
				<div class="panel-body">
					Seleccionas las opciones para generar un reporte
				</div>
			</div>
			<div class="container">
				<form method="post" action="<?php echo URL.'admin/generarReporte';?>">
					<h1 class="page-header">Visuales</h1>
					<div class="checkbox">
						<label>
							<input type="checkbox" name="top20mas"> Productos más vendidos (Top 20)
						</label>
					</div>
					<div class="checkbox">
						<label>
							<input type="checkbox" name="topClientes"> Clientes que más dinero ingresaron a la tienda (Top 10)
						</label>
					</div>
					<div class="checkbox">
						<label>
							<input type="checkbox" name="top20menos"> Productos menos vendidos (20 productos)
						</label>
					</div>
					<div class="checkbox">
						<label>
							<input type="checkbox" name="totalVentasProd"> Total de ventas de un producto particular en los últimos 6 meses.
						</label>
						<input type="text" name="producto"/>
					</div>
					<div class="checkbox">
						<label>
							<input type="checkbox" name="totalVentasFab"> Total de ventas por empresas fabricantes.
						</label>
					</div>
					<h1 class="page-header">Tablas</h1>
					<div class="checkbox">
						<label>
							<input type="checkbox" name="clientesCumpleanno"> Clientes que cumplirán años el mes que empieza
						</label>
					</div>
					<div class="checkbox">
						<label>
							<input type="checkbox" name="bajasExistencias"> Productos con bajas existencias (menos de 10 ítems en bodega)
						</label>
					</div>
					<div class="checkbox">
						<label>
							<input type="checkbox" name="recaudoIva"> Recaudo de IVA en el mes por cada producto del catálogo
						</label>
					</div>
				
					<button class="btn btn-success" type="summit"> aquí</button>
				</form>
			</div>
			
	</div>
	