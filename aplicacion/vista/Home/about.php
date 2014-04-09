    <div class="container-fluid" style="padding:50px;padding-top:70px;">
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">Acerca de nosotros</h1>
			<div class="container">
				<ol>
				<li> Falta aplicar los descuentos a la hora de hacer la factura </li>
				<li> Falta validar los campos (Que id_producto no contenga espacios, que no inserten apostrofes por ejemplo) </li>
				<li> Al recargar la página de la última instancia de el módulo de pago, se reenvia el fomulario, generando un nuevo pago </li>
				<li> Para evitar una inyección sql, es necesario utilizar correctamente el PDO y su función bind() </li>
				<li> "Detalles del producto (es una lista variable de características importantes según el producto, al menos 5
				detalles por cada tipo de producto)" </li>
				<li> Agregar trasacciones </li>
				<li> Para los pagos con tarjeta se debe guardar el número de tarjeta, número de aprobación, fecha y hora de aprobación y entidad que aprobó 
				(VISA,  MASTERCARD, RED MAESTRO, etc.) </li>
				<li> Cada  vez que se hace una venta los productos comprados deben ser retirados del inventario disponible en la tienda. </li>
				<li> <b>Recordar siempre cambiar las direcciónes en /public/poducto/carrito.js</b> </li>
				</ol>
			</div>
		</div>
	</div>