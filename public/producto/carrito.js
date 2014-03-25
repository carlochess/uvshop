$(function () {
	// Función que actualiza el contador del carrito
	function actualizarContador($con)
	{
		$(".notification-counter").text($con);
		$(".notification-counter").animate(
            {"top": "-=10px"},
            "fast");
		$(".notification-counter").animate(
            {"top": "+=10px"},
            "fast");
	}
	// Función encargada de mostar los objetos comprados
	function rederCarrito()
	{
		if($.cookie("carritoCod"))
		{
			var $codigos = $.trim(JSON.parse($.cookie("carritoCod"))).split(" ");
			var $numeroDeElementos = $codigos.length;
			$("#carrito").html('');
			for(var i=$numeroDeElementos-1; i >= 0 	; --i) //&& i> $numeroDeElementos-4 
			{
				$("#carrito").append('<li class="producto">'+(i+1)+': Producto '+$codigos[i]+'</li>');
				$("#carrito li:last-child").css("background","url('http://127.0.0.1/uvshop/imagenes/"+$codigos[i]+"x50.jpg"+"') no-repeat left center");
				$("#carrito").append('<li class="divider"></li>');
			}
			if(parseInt($numeroDeElementos) < 3)
			{
				$('#carrito').css( "height", 70*(parseInt($numeroDeElementos)+1));
			}else
			{
				$('#carrito').css( "height", 210);
			}
			$("#carrito").append('<li class="divider"></li>');
			$("#carrito").append('<li class="verMas"><a href="http://127.0.0.1/uvshop/pago/">Ver mas</a></li>');
			actualizarContador($numeroDeElementos);
		}
	}
	// Cuando hacen click en el botón "Comprar"
	$("#agregarCarrito").click(function(){
		var $data = $("#codigo").text();
		if($.cookie("carritoCod") && $.cookie("carritoNomb"))
		{
			var $cookieCod = JSON.parse($.cookie("carritoCod"));
			var $cookieNomb = JSON.parse($.cookie("carritoNomb"));
			$.cookie("carritoCod", JSON.stringify($cookieCod+' '+$data), { expires: 7, path: '/' });
			$.cookie("carritoNomb", JSON.stringify($cookieNomb+' '+$data), { expires: 7, path: '/' });
		}
		else
		{
			$.cookie("carritoCod", JSON.stringify($data), { expires: 7, path: '/' });
			$.cookie("carritoNomb", JSON.stringify($data), { expires: 7, path: '/' });
		}
		rederCarrito();
	});
	// Función que,agrega una X si el mouse esta sobre algún objeto del carrito
	$(document).on({
		mouseenter: function () {
			$(this).append('<b class="remover">X</b>');
			var $item = $(this).text();
			$(".remover").on( "click", function(){
				var $nElemento = parseInt($item.substring(0,$item.indexOf(":")));
				//var res str.split(" "); 
			});
		},
		mouseleave: function () {
			$(this).find("b").remove(); 
		}
	}, ".producto");
	
	$(".cantidad").keyup(function(){
		var $cantidad = parseInt($(this).val(),10);
		var $precio = parseFloat($(this).closest("table").find(".valor").text(),10);
		$(this).closest(".item").find(".text-right").text($cantidad*$precio);
	});
	// Función que borra un elemento en la página Items 
	$(".borrar").click(function(){
		 $(this).closest('.item').remove();
	});
	
	rederCarrito();
});