<!-- Modal -->
	<div class="modal fade  bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Agregar</h4>
      </div>
      <div class="modal-body">
					<div id="agregar">
						<div class="thumbnail">
							<img  id="imag" src="holder.js/200x200">
						</div>
						<form enctype="multipart/form-data" action="<?php echo URL.'producto/agregarProd' ?>" method="POST" id="formulario">
							  <div class="form-group">
								<label for="exampleInputFile">Foto</label>
								<input type="file" id="exampleInputFile" name="file">
							  </div>
							  <div class="form-group">
								  <label for="exampleInputEmail1">id</label>
								  <input type="text" class="form-control" id="codigo" placeholder="ID" name="idProd">
							  </div>
							  <div class="form-group">
								<label for="exampleInputEmail1">Nombre</label>
								<input type="text" class="form-control" id="nombre" placeholder="Ingresa un nombre" name="nProd">
							  </div>
							  <div class="form-group">
								<label for="exampleInputEmail1">Empresa fabricante</label>
								<input type="text" class="form-control" id="empresa_fab" placeholder="Ingresa la empresa fabricante" name="empProd">
							  </div>
							  <div class="form-group">
								<label for="exampleInputPassword1">Descripcion</label>
								<textarea class="form-control" rows="3" id="descripcion" name="descProd" placeholder="Ingresa una descripcion"></textarea>

							  </div>
							  <div class="form-group">
								<label for="exampleInputPassword1">Iva</label>
								<input type="text" class="form-control" id="iva" placeholder="Ingresa el iva" name="ivaProd">
							  </div>
							  
							  <button type="submit" class="btn btn-default" id="boton">Agregar</button>
							  <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
						</form>
					</div>
				</div>
		  </div>
      </div>
      <div class="modal-footer">
        
        <!--<button type="button" class="btn btn-primary">Save changes</button>-->
      </div>
		</div>
	  </div>
	</div>


	<div class="container-fluid">
      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Items</h1>

            <div class="panel panel-default">
				<div class="panel-body" id="Texto">
				Agregando items :D
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-8">
				</div>
				<div class=".col-md-3 .col-md-offset-3">
				<button class="btn btn-primary btn-lg" id="add">
					Agregar item
				</button>
				</div>
			</div>
			<div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
				  <!-- SELECT `codigo`, `nombre`, `empresa_fab`, `descripcion`, `iva` FROM `producto` WHERE 1 -->
                  <th>Codigo</th>
                  <th>Nombre</th>
                  <th>Empresa Fabricante</th>
                  <th>Descripción</th>
                  <th>IVA</th>
				  <th>Acción</th>
                </tr>
              </thead>
              <tbody>
			  <?php foreach($productos as $producto){ ?>
                <tr>
                  <td class="codigo"><?php echo $producto->codigo ?></td>
                  <td class="nombre"><?php echo $producto->nombre ?></td>
                  <td class="empresa_fab"><?php echo $producto->empresa_fab ?></td>
                  <td class="descripcion"><?php echo $producto->descripcion ?></td>
                  <td class="iva"><?php echo $producto->iva ?></td>
				  <td>
					<a href="<?php echo URL."producto/eliminarprod/".$producto->codigo ?>">
						<img src="<?php echo URL;?>imagenes/cruz_roja.png" />
					</a>
					<img class="boton" src="<?php echo URL;?>imagenes/edit.png" />
				  </td>
                </tr>
			  <?php } ?>
        </div>
	
		
		</div>
	  
	  
	  <script type="text/javascript">
		  $(function(){
			function readURL(input) {
			   if (input.files && input.files[0]) {
				   var reader = new FileReader();
				   reader.onload = function(e) {
					   $('#imag').attr('src', e.target.result);
				   }
				   reader.readAsDataURL(input.files[0]);
			   }
		   }
		   $("#exampleInputFile").change(function() {
			   readURL(this);
		   });
		   $("#add").click(function(){
				$('#myModalLabel').text('Agregar');
				$('#boton').text('Agregar');
				$('#formulario').attr('action', '<?php echo URL.'producto/agregarProd' ?>');
				$('#myModal').modal();
				$('#codigo').val('');
				$('#nombre').val('');
				$('#empresa_fab').val('');
				$('#descripcion').val('');
				$('#iva').val('');
			});
			
		   $(".boton").click(function(){
				var $linea = $(this).closest('tr');
				var $id = $linea.find(".codigo").text();
				var $nombre = $linea.find(".nombre").text();
				var $empresa_fab = $linea.find(".empresa_fab").text();
				var $descripcion = $linea.find(".descripcion").text();
				var $iva = $linea.find(".iva").text();
				$('#formulario').attr('action', '<?php echo URL.'producto/actualizarProd' ?>');
				$('#myModalLabel').text('Editar');
				$('#boton').text('Editar');
				$('#codigo').val($id);
				$('#nombre').val($nombre);
				$('#empresa_fab').val($empresa_fab);
				$('#descripcion').val($descripcion);
				$('#iva').val($iva);
				$('#myModal').modal();
			});

		}); 
	</script>