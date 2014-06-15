<div class="container-fluid">
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <footer>
            <p>&copy; 2014 UvShop, Boostrap. &middot; <a href="#">Privacidad</a> &middot; <a href="#">Terminos</a></p>
        </footer>
    </div>
</div>
<script src="<?php echo URL; ?>public/readmore.js"></script>


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.1/js/bootstrap.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.0/jquery.cookie.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>public/jquery.number.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>public/producto/carrito.js"></script>
<script src="<?php echo URL; ?>public/readmore.js"></script>
<script>
    $(function() {
        // Setup drop down menu
        $('.dropdown-toggle').dropdown();

        // Fix input element click problem
        $('.dropdown input, .dropdown label').click(function(e) {
            e.stopPropagation();
        });

        $('.precio').number(true, 0);
    });
</script>
<script>
    $('.descripcion').readmore({
        moreLink: '<a href="#">Ver mas</a>',
        maxHeight: 10,
        lessLink: '<a href="#">Cerrar</a>',
        afterToggle: function(trigger, element, expanded) {
            if (!expanded) {
                $('html, body').animate({scrollTop: element.offset().top}, {duration: 100});
            }
        }
    });

    $('article').readmore({maxHeight: 240});
</script>
</body>
</html>