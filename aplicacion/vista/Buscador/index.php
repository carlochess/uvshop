
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
        <h1 class="page-header">Encontrados</h1>
		<table>
		<?php foreach($resBusqueda as $res){ ?>
			<tr>
				<td> <img src="<?php echo URL.'imagenes/'.$res->ruta ;?>x200.jpg" /> </td>
				<td> <a href="<?php echo URL.'producto/info/'.$res->codigo ;?>"> <?php echo $res->nombre; ?> </a></td>
			</tr>
		<?php } ?>
		</table>
	</div>
</div>
