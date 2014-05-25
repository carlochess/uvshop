<div class="modal fade  bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Agregar precio</h4>
            </div>
            <div class="modal-body">
                <div id="agregar">
                    <form  role="form" method="post" action="<?php echo URL ?>precios/agregarprecio" id="formulario">
                        <div class="form-group">
                            <input type="hidden" id="id" name="id_precio">
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
                            <label for="exampleInputEmail1">Precio:</label>
                            <input type="text" id="precio" name="precio">
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
        <h1 class="page-header">Precio: productos</h1>

        <div class="panel panel-default">
            <div class="panel-body" id="Texto">
                <img src="<?php echo URL . 'imagenes/' . $id . 'x200.jpg'; ?>"/> Producto <?php echo $id; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
            </div>
            <div class=".col-md-3 .col-md-offset-3">
                <button class="btn btn-primary btn-lg" id="add">
                    Agregar precio
                </button>
                <a href="<?php echo URL . 'admin/producto'; ?>">
                    <button class="btn btn-success btn-lg" id="add">
                        Volver a productos
                    </button>
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th>Fecha de inicio</th>
                        <th>Fecha de finalización</th>
                        <th>Precio ($)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    foreach ($precios as $precio) { ?>
                        <tr id="<?php echo $precio->id_precio; ?>">
                            <td><?php echo $i; ?></td>
                            <td class="fecha_ini"><?php echo $precio->fecha_ini; ?></td>
                            <td class="fecha_fin"><?php echo $precio->fecha_fin; ?></td>
                            <td class="precio"><?php echo $precio->valor; ?></td>
                            <td>
                                <a href="<?php echo URL . "precios/eliminarprecio/" . $precio->id_precio . '/' . $id; ?>">
                                    <img class="eliminar" src="<?php echo URL; ?>imagenes/cruz_roja.png" />
                                </a>
                                <img class="boton" src="<?php echo URL; ?>imagenes/edit.png" />
                            </td>
                        </tr>
    <?php $i++;
} ?>
                    </div>

                    </div>

                <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

                <script>
                    $(function() {
                        $(".datepicker").datepicker();
                        $(".datepicker").datepicker("option", "dateFormat", "yy-mm-dd");
                        $("#add").click(function() {
                            $('#myModalLabel').text('Agregar');
                            $('#boton').text('Agregar');
                            $('#formulario').attr('action', '<?php echo URL . 'precios/agregarprecio/' . $id; ?>');
                            $('#myModal').modal();
                            $('#precio').val('');
                            $('#fecha_ini').val('');
                            $('#fecha_fim').val('');
                            $('#id').val('');
                        });
                        $(".boton").click(function() {
                            var $linea = $(this).closest('tr');
                            var $id_precio = $linea.attr('id');
                            var $fecha_ini = $linea.find(".fecha_ini").text();
                            var $fecha_fin = $linea.find(".fecha_fin").text();
                            var $precio = $linea.find(".precio").text();
                            $('#id').val($id_precio);
                            $('#fecha_ini').val($fecha_ini);
                            $('#fecha_fim').val($fecha_fin);
                            $('#precio').val($precio);
                            $('#myModalLabel').text('Editar');
                            $('#boton').text('Editar');
                            $('#formulario').attr('action', '<?php echo URL . 'precios/editarprecio/' . $id; ?>');
                            $('#myModal').modal();
                        });
                    });
                </script>