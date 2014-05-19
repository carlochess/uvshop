	<div class="container-fluid">
      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Precio: productos</h1>

            <div class="panel panel-default">
				<div class="panel-body" id="Texto">
					<select id="productos">
						<?php foreach($productos as $producto){ ?>
							<option value="<?php echo $producto->id_prod; ?>">
								<?php echo $producto->id_prod; ?>
							</option>
						<?php }; ?>
					</select>
					<button class="btn btn-primary btn-lg" id="edit"> Editar precios </button>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-8">
				</div>
				<div class=".col-md-3 .col-md-offset-3">
					
				</div>
			</div>
			
	</div>
	
	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
	
	<script>
	$(function(){
		$("#edit").click(function(){
			var $opcion = $("#productos").val();
			alert($opcion);
		});
	});
	</script>