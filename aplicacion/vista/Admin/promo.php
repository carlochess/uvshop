<div class="modal fade  bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Agregar promoción</h4>
            </div>
            <div class="modal-body">
                <div id="agregar">
                    <form  role="form" method="post" action="<?php echo URL ?>promociones/agregarpromo" id="formulario">
                        <div class="form-group">
                            <label for="exampleInputEmail1">ID producto</label>
                            <input type="text" id="id" name="idItem">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Fecha de inicio:</label>
                            <input type="text" id="fecha_ini" class="datepicker" name="f_inicio">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Fecha de finalización:</label>
                            <input type="text" id="fecha_fim" class="datepicker" name="f_finalizacion">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Descuento:</label>
                            <input type="text" id="descuento" name="descuento">
                        </div>
                        <button id="boton" type="submit" class="btn btn-default">Agregar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <h1 class="page-header">Promociones</h1>

        <div class="panel panel-default">
            <div class="panel-body" id="Texto">
                Haz algo
            </div>
            <?php if (isset($error)){
            if (count($error)>0) { ?>
                <div class="alert alert-danger">
                    <?php for ($i = 0; $i < count($error) ; $i++) {
                        echo "<p>".$error[$i]."</p>";
                    } ?>
                </div>    
            <?php }else { ?>
            <div class="alert alert-success">Agregado con éxito</div>
        <?php }} ?>
        </div>

        <div class="row">
            <div class="col-md-8">
            </div>
            <div class=".col-md-3 .col-md-offset-3">
                <button class="btn btn-primary btn-lg" id="add">
                    Agregar promoción
                </button>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Imagen Producto</th>
                        <th>Codigo Producto</th>
                        <th>Fecha de inicio</th>
                        <th>Fecha de finalización</th>
                        <th>Descuento (%)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($promociones as $promocion) { ?>
                        <tr>
                            <td><img src="<?php echo URL . 'imagenes/' . $promocion->cod_producto; ?>x50.jpg"/></td>	
                            <td class="cod_producto"><?php echo $promocion->cod_producto; ?></td>
                            <td class="fecha_ini"><?php echo $promocion->fecha_ini; ?></td>
                            <td class="fecha_fin"><?php echo $promocion->fecha_fin; ?></td>
                            <td class="porcetaje_red"><?php echo $promocion->porcetaje_red; ?></td>
                            <td>
                                <a href="<?php echo URL . "promociones/eliminarpromo/" . $promocion->id_promocion; ?>">
                                    <img src="<?php echo URL; ?>imagenes/aaserver/cruz_roja.png" />
                                </a>
                                <img class="boton" src="<?php echo URL; ?>imagenes/aaserver/edit.png" />
                            </td>
                        </tr>
                    <?php } ?>
                    </div>
                    </div>

                <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script><script>
                    $(function() {
                        $(".datepicker").datepicker();
                        $(".datepicker").datepicker("option", "dateFormat", "yy-mm-dd");
                        $("#add").click(function() {
                            $('#myModalLabel').text('Agregar');
                            $('#boton').text('Agregar');
                            $('#formulario').attr('action', '<?php echo URL . 'promociones/agregarpromo/' ?>');
                            $('#myModal').modal();
                            $('#descuento').val('');
                            $('#id').val('');
                            $('#fecha_ini').val('');
                            $('#fecha_fim').val('');

                        });
                        $(".boton").click(function() {
                            var $linea = $(this).closest('tr');
                            var $cod_producto = $linea.find(".cod_producto").text();
                            var $fecha_ini = $linea.find(".fecha_ini").text();
                            var $fecha_fin = $linea.find(".fecha_fin").text();
                            var $porcetaje_red = $linea.find(".porcetaje_red").text();
                            $('#id').val($cod_producto);
                            $('#fecha_ini').val($fecha_ini);
                            $('#fecha_fim').val($fecha_fin);
                            $('#descuento').val($porcetaje_red);
                            $('#myModalLabel').text('Editar');
                            $('#boton').text('Editar');
                            $('#formulario').attr('action', '<?php echo URL . 'promociones/editarpromo' ?>');
                            $('#myModal').modal();
                        });

                    });
                </script>