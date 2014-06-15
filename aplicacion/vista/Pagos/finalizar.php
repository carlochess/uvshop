
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

    <div class="container">
        <h1 class="page-header"> Ticket: </h1><small> <?php echo $id_factura; ?> </small>
        <h1 class="page-header"> Detalles Productos: </h1>
        <table id="productos" class="table table-hover">
            <tr>
                <th> imagen </th>
                <th> id </th>
                <th> Nombre </th>
                <th> Cantidad </th>
            <tr>
                <?php foreach ($productos as $producto) { ?>
                <tr>
                    <td> <img src="<?php echo URL . 'imagenes/' . $producto->id . 'x50.jpg'; ?>" /> </td>
                    <td> <?php echo $producto->id; ?> </td>
                    <td> <?php echo $producto->Nombre; ?> </td>
                    <td> <?php echo $producto->Cantidad; ?> </td>
                </tr>
            <?php } ?>
        </table>
        <h1 class="page-header"> Detalles formas de pago: </h1>
        <table id="productos" class="table table-hover">
            <tr>
                <th> Medio_de_pago </th>
                <th> Numero_de_tarjeta </th>
                <th> Numero_de_cuotas </th>
                <th> Monto </th>
            <tr>
                <?php $i = 0;
                foreach ($metodosPago as $metododePago) { ?>
                <tr>
                    <td> <?php echo $metododePago->Medio_de_pago; ?> </td>
                    <td> <?php echo (isset($metododePago->Numero_de_tarjeta)) ? $metododePago->Numero_de_tarjeta : ""; ?> </td>
                    <td> <?php echo $metododePago->Numero_de_cuotas; ?> </td>
                    <td> <?php echo $metododePago->Monto; ?> </td>
                </tr>
<?php } ?>
        </table>
        <div>
            <a href="<?php echo URL ?>">
                <button class= "btn btn-alert" id="volver"> Salir </button>
            </a>
        </div>
    </div>
</div>
