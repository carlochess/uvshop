	<div id="footer" style="margin:40px; background-color:black;">
      <div class="container">
        
      </div>
    </div>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.2.1/js/bootstrap.min.js"></script>
	<script src="http://lightswitch05.github.io/table-to-json/javascripts/jquery.tabletojson.min.js"></script>
	<script src="<?php echo URL; ?>public/jquery.cookie.js"></script>
	<script src="<?php echo URL; ?>public/holder.js"></script>
	<script src="<?php echo URL; ?>public/producto/carrito.js"></script>
	<script src="<?php echo URL; ?>public/pagos/modosPago.js"></script>
	<script type="text/javascript" src="<?php echo URL; ?>public/jquery.number.min.js"></script>
	<script>
		$(function(){
			$('.precio').number( true, 0 );
		});
	</script>
  </body>
</html>