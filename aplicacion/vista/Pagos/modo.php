
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
		<div style="margin-botton:20px;">
			<h1 class="page-header"> Recibo de pago </h1>
				Total <p id="Restan"> <?php echo $total; ?> </p>
				Restan <p id="Total"> <?php echo $total; ?> </p>

				<table id="agregar" border="2px">
					<tr>
						<th> ¿eliminar? </th>
						<th> Medio de pago </th>
						<th> Número de cuotas </th>
						<th> monto </th>
					<tr>
					<tr>
						<td> </td>
						<td> 
							<select id="mPago">
								<option value="tarjeta" selected="selected"> Tarjeta </option>    
								<option value="efectivo"> Efectivo </option>
							</select>
						</td>
						<td> 
							<input id="nCuotas" type="text" value="22" />
						</td>
						<td> <input id="monto" type="text" value="22" /> </td>
						<td> <button id="bAgregar"> Agregar </button> </td>
					<tr>
				</table>
		</div>
            <p class="text-right">
				<a href="<?php echo URL.'pago/' ?>">
					<button class= "btn btn-alert"  type="submit" id="pagar"> << Volver </button>
				</a>
				<button class= "btn btn-success"  type="submit" id="pagar"> Pagar >> </button>
			</p>
	</div>
</div>
<script>
$(document).ready(function(){
	$("#mPago").change(function(){
    var $mPago = $(this).val();
    switch($mPago){
        case 'efectivo':
            $("#nCuotas").val("1");
            $("#nCuotas").prop('disabled', true);
            break;
        case 'tarjeta':
           $("#nCuotas").prop('disabled',false);
           break;
    }
	});
	$("#bAgregar").click(function(){
		var $mPago = $("#mPago").val();
		var $nCuotas = parseInt($("#nCuotas").val());
		var $monto = parseFloat($("#monto").val());
		var $total = parseFloat($("#Total").text());
		var $img = '<img class="eliminar" src="http://resilientteenagers.com/wp-content/uploads/2012/08/Redcross-e1345890664918.png" />';
		if(($monto*$nCuotas) >0 && $monto*$nCuotas <= $total){
			var $resto = $total-$monto*$nCuotas;
			$("#agregar tr:last").after('<tr><td>'+$img+'</td><td>'+$mPago+' </td><td class="nCuotas">'+$nCuotas+' </td> <td class="monto">'+$monto+' </td></tr>');
			$("#Total").text($resto);        
		}
	});
	$(document).on( 'click', '.eliminar', function(){
		var $linea = $(this).closest('tr');
		var $nCuotas = parseInt($linea.find(".nCuotas").text());
		var $monto = parseFloat($linea.find(".monto").text());
		var $total = parseFloat($("#Total").text());
		$("#Total").text($nCuotas*$monto+$total);    
		$linea.remove();
	});
});
</script>
