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
	
	$("#pagar").click(function(){
		var medPago = $('#agregar').tableToJSON({ignoreColumns: [0]});
		var prod = $('#productos').tableToJSON();//
		$("#id").val(JSON.stringify(medPago));
		$("#id2").val(JSON.stringify(prod));
		/*var datos = { TablaPagos : medPago , TablaProductos : prod};
		$.ajax({
			type: "POST",
			url: "http://127.0.0.1/uvshop/pago/finalizar",
			data:  datos,
			success: function (response) {
				alert(response);
			}
		});*/
	});
});