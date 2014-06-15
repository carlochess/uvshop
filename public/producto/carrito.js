$(function() {
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
        $codigos = $.trim(JSON.parse($.cookie("carritoCod"))).split(" ");

        var $numeroDeElementos = $codigos.length;
        $("#carrito").html('');
        if (parseInt($numeroDeElementos) < 3)
        {
            $('#carrito').css("height", 70 * (parseInt($numeroDeElementos) + 1));
        } else
        {
            $('#carrito').css("height", 210);
        }

        if ($codigos[0].length > 0)
        {
            for (var i = $numeroDeElementos - 1; i >= 0; --i)
            {

                $("#carrito").append('<li class="producto">' + (i + 1) + ': Producto ' + $codigos[i] + '</li>');
                $("#carrito li:last-child").css("background", "url('http://localhost/uvshop/imagenes/" + $codigos[i] + "x50.jpg" + "') no-repeat left center");
                $("#carrito").append('<li class="divider"></li>');
            }
            actualizarContador($numeroDeElementos);
        }
        else
        {
            actualizarContador(0);
            $('#carrito').css("height", 70);
        }

        $("#carrito").append('<li class="divider"></li>');
        $("#carrito").append('<li class="verMas"><a href="http://localhost/uvshop/pago/">Pagar</a></li>');

    }

    $("#pagar").click(function() {
        var $data = $("#codigo").text();

        if ($.cookie("carritoCod"))
        {
            var $cookieCod = JSON.parse($.cookie("carritoCod")).trim();
            $.cookie("carritoCod", JSON.stringify($cookieCod + ' ' + $data), {expires: 7, path: '/'});
        }
        else
        {
            $.cookie("carritoCod", JSON.stringify($data), {expires: 7, path: '/'});
        }
        rederCarrito();
    });

    // Cuando hacen click en el botón "Comprar"
    $("#agregarCarrito").click(function() {
        var $data = $("#codigo").text();

        if ($.cookie("carritoCod"))
        {
            var $cookieCod = JSON.parse($.cookie("carritoCod")).trim();
            $.cookie("carritoCod", JSON.stringify($cookieCod + ' ' + $data), {expires: 7, path: '/'});
        }
        else
        {
            $.cookie("carritoCod", JSON.stringify($data), {expires: 7, path: '/'});
        }
        rederCarrito();
    });

    function eliminarElemento(str, pos)
    {
        var res = str.split(" ");
        var resultado = "";
        for (var i = 0; i < res.length; i++)
        {
            if (i != pos)
            {
                resultado += res[i] + " ";
            }
        }
        return resultado;
    }

    // Función que,agrega una X si el mouse esta sobre algún objeto del carrito
    $(document).on({
        mouseenter: function() {
            $(this).append('<b class="remover">X</b>');
            var $item = $(this);
            $(".remover").on("click", function() {
                var $cookieCod = JSON.parse($.cookie("carritoCod"));
                var posicion = $item.text().indexOf(':');
                $.cookie("carritoCod", JSON.stringify(eliminarElemento($cookieCod, parseInt($item.text().substring(0, posicion)) - 1).trim()), {expires: 7, path: '/'});
                rederCarrito();
            });
        },
        mouseleave: function() {
            $(this).find("b").remove();
        }
    }, ".producto");

    $(".cantidad").keyup(function() {
        var $cantidad = parseInt($(this).val(), 10);
        var $precio = parseFloat($(this).closest("table").find(".valor").text(), 10);
        $(this).closest(".item").find(".text-right").text($cantidad * $precio);
    });
    // Función que borra un elemento en la página Items 
    $(".borrar").click(function() {
        $(this).closest('.item').remove();
    });

    $('.dropdown-menu').click(function(e) {
        e.stopPropagation();
    });

    rederCarrito();
});
