$(document).ready(function () {

    $('#slider a:gt(0)').hide();
    var interval = setInterval(changeDiv, 6000);

    function changeDiv() {
        $('#slider a:first-child').fadeOut(1000).next('a').fadeIn(1000).end().appendTo('#slider');
    };
    $('.mas').click(function () {
        changeDiv();
        clearInterval(interval);
        interval = setInterval(changeDiv, 6000);
    });
    $('.menos').click(function () {
        $('#slider a:first-child').fadeOut(1000);
        $('#slider a:last-child').fadeIn(1000).prependTo('#slider');
        clearInterval(interval);
        interval = setInterval(changeDiv, 6000);
    });

    //cambiar en producción
    /*sessionStorage.setItem("mfrutas ", 1);
    sessionStorage.setItem("mverduras ", 1);
    sessionStorage.setItem("mcestas ", 1);
    sessionStorage.setItem("mofertas ", 1);*/

    //en local
    /*localStorage.setItem('mfrutas',1);
    localStorage.setItem('mverduras',1);
    localStorage.setItem('mcestas',1);
    localStorage.setItem('mofertas',1);*/

    /*$(".jg_nav_fruit").click(function () {
       // alert("hola");
        sessionStorage.setItem("mfrutas ", 2);
        //localStorage.setItem("mfrutas",2);
        if(sessionStorage.getItem('mfrutas')%2==0){
        //if(localStorage.getItem('mfrutas')%2==0){
            $(".jg_nav_fruit").addClass("jg_menu_selected");
            $(".jg_nav_veg").removeClass("jg_menu_selected");
            $(".jg_nav_basket").removeClass("jg_menu_selected");
            $(".jg_nav_offers").removeClass("jg_menu_selected");
        }
    });
    $(".jg_nav_veg").click(function () {
        sessionStorage.setItem("mverduras ", 2);
        //localStorage.setItem("mverduras",2);
        if (sessionStorage.getItem('mverduras') % 2 == 0) {
        //if (localStorage.getItem('mverduras') % 2 == 0) {
            $(".jg_nav_veg").addClass("jg_menu_selected");
            $(".jg_nav_fruit").removeClass("jg_menu_selected");
            $(".jg_nav_basket").removeClass("jg_menu_selected");
            $(".jg_nav_offers").removeClass("jg_menu_selected");

        }
    });
    $(".jg_nav_basket").click(function () {
        sessionStorage.setItem("mcestas ", 2);
        //localStorage.setItem("mcestas",2);
        if (sessionStorage.getItem('mcestas') % 2 == 0) {
        //if (localStorage.getItem('mcestas') % 2 == 0) {
            $(".jg_nav_basket").addClass("jg_menu_selected");
            $(".jg_nav_fruit").removeClass("jg_menu_selected");
            $(".jg_nav_veg").removeClass("jg_menu_selected");
            $(".jg_nav_offers").removeClass("jg_menu_selected");
        }
    });
    $(".jg_nav_offers").click(function () {
        sessionStorage.setItem("mofertas ", 2);
        //localStorage.setItem("mofertas",2);
        if (sessionStorage.getItem('mofertas') % 2 == 0) {
        //if (localStorage.getItem('mofertas') % 2 == 0) {
            $(".jg_nav_offers").addClass("jg_menu_selected");
            $(".jg_nav_fruit").removeClass("jg_menu_selected");
            $(".jg_nav_veg").removeClass("jg_menu_selected");
            $(".jg_nav_basket").removeClass("jg_menu_selected");
        }
    });*/


    /*if(localStorage.getItem('fruta')) {
        //add class with completed token
        $(".jg_nav_fruit").addClass("jg_menu_selected");

    }*/
    //animación cuando haces hover en el logo
    $("#Logo").hover(function () {
        $(this).addClass("animated 2s swing");
        //$(this).addClass("animated 2s hinge");
    });
    /*$(".jg_nav_fruit").click(function () {
        $(".jg_nav_fruit").addClass("jg_menu_selected");
        $(".jg_nav_veg").removeClass("jg_menu_selected");
        $(".jg_nav_basket").removeClass("jg_menu_selected");
        $(".jg_nav_offers").removeClass("jg_menu_selected");
    });
    $(".jg_nav_veg").click(function () {
        $(".jg_nav_veg").addClass("jg_menu_selected");
        $(".jg_nav_fruit").removeClass("jg_menu_selected");
        $(".jg_nav_basket").removeClass("jg_menu_selected");
        $(".jg_nav_offers").removeClass("jg_menu_selected");
    });
    $(".jg_nav_basket").click(function () {
        $(".jg_nav_basket").addClass("jg_menu_selected");
        $(".jg_nav_fruit").removeClass("jg_menu_selected");
        $(".jg_nav_veg").removeClass("jg_menu_selected");
        $(".jg_nav_offers").removeClass("jg_menu_selected");
    });
    $(".jg_nav_offers").click(function () {
        $(".jg_nav_offers").addClass("jg_menu_selected");
        $(".jg_nav_fruit").removeClass("jg_menu_selected");
        $(".jg_nav_veg").removeClass("jg_menu_selected");
        $(".jg_nav_basket").removeClass("jg_menu_selected");
    });*/

    /*indicamos que cuando seleccionemos por ej. el filtro de los Plátanos, tendrá un color de fondo
    * más vistoso que el resto de filtros*/
    $(".jg_filtros_banana").on('click', function () {
        $(this).addClass("jg_filtros_selected");
        $(".jg_filtro_apple").removeClass("jg_filtros_selected");

    });
    $(".jg_filtro_apple").on('click', function () {
        $(this).addClass("jg_filtros_selected");
        $(".jg_filtros_banana").removeClass("jg_filtros_selected");

    });
    //función para redireccionar los filtros que ordenan por precio
    $('.jg_filtros_precio').on('change', function () {
        var url = $(this).val();//obtengo el valor de la opción - donde hemos indicado la ruta a la que queremos ir
        if (url) {
            window.location = url; //redirigimos con ese valor
        }
        return false;
    });

    //ocultación de campos formulario de registro (6 -9)
    $(".jg_ocultar_campos div div:nth-child(6)").hide();
    $(".jg_ocultar_campos div div:nth-child(7)").hide();
    $(".jg_ocultar_campos div div:nth-child(8)").hide();
    $(".jg_ocultar_campos div div:nth-child(9)").hide();
    $(".jg_atras_1").hide();
    $(".jg_finalizar_1").hide();

    $(".jg_siguiente_1").click(function () {
        var nombre = $(".jg_ocultar_campos div div:nth-child(1)");
        var apellidos = $(".jg_ocultar_campos div div:nth-child(2)");
        var email = $(".jg_ocultar_campos div div:nth-child(3)");
        var contrasenya = $(".jg_ocultar_campos div div:nth-child(4)");
        var contrasenya2 = $(".jg_ocultar_campos div div:nth-child(5)");

        $(".jg_ocultar_campos div div:nth-child(1)").hide(1000);
        $(".jg_ocultar_campos div div:nth-child(2)").hide(1000);
        $(".jg_ocultar_campos div div:nth-child(3)").hide(1000);
        $(".jg_ocultar_campos div div:nth-child(4)").hide(1000);
        $(".jg_ocultar_campos div div:nth-child(5)").hide(1000);
        $(".jg_siguiente_1").hide(1000);
        /////
        $(".jg_ocultar_campos div div:nth-child(6)").show(1000);
        $(".jg_ocultar_campos div div:nth-child(7)").show(1000);
        $(".jg_ocultar_campos div div:nth-child(8)").show(1000);
        $(".jg_ocultar_campos div div:nth-child(9)").show(1000);
        $(".jg_atras_1").show(1000);
        $(".jg_finalizar_1").show(1000);

    });
    $(".jg_atras_1").click(function () {
        $(".jg_atras_1").hide(1000);
        $(".jg_finalizar_1").hide(1000);
        $(".jg_siguiente_1").show(1000);

        $(".jg_ocultar_campos div div:nth-child(6)").hide(1000);
        $(".jg_ocultar_campos div div:nth-child(7)").hide(1000);
        $(".jg_ocultar_campos div div:nth-child(8)").hide(1000);
        $(".jg_ocultar_campos div div:nth-child(9)").hide(1000);

        $(".jg_ocultar_campos div div:nth-child(1)").show(1000);
        $(".jg_ocultar_campos div div:nth-child(2)").show(1000);
        $(".jg_ocultar_campos div div:nth-child(3)").show(1000);
        $(".jg_ocultar_campos div div:nth-child(4)").show(1000);
        $(".jg_ocultar_campos div div:nth-child(5)").show(1000);
    });

    //establezco la cookie que determinará si hemos acceptado el uso de cookies
    Cookies.set('cookie', '0', {expires: 7});
    $(".jg_accept_cookies").click(function () {
        //alert(Cookies.get('aceptarcookies'));
        //alert(Cookies.set('cookie', '1', { expires: 7 }));
        //una vez lo aceptamos, cambio el valor y así no se mostrará más
        Cookies.set('cookie', '1', {expires: 7});
        $(".jg_caja_cookies").slideUp("slow", function () {
        });
    });
    $("#user_province").on("change", function () {
        var provinciaid = $(this).val();
        var cities = $("#user_city");
        cities.empty();
        cities.append('<option selected="true" disabled>Selecciona una ciudad</option>');
        cities.prop('selectedIndex', 0);

        $.getJSON("json/municipios.json", function (data) {
            $.each(data, function (key, entry) {
                if (entry.provincia_id == provinciaid) {
                    cities.append('<option value="'+ entry.id +'">'+ entry.name +'</option>');

                }
            })
        });
    })

});

    //click carrito
    $(".am_carro").click(function () {

    });

    $(".jg_mostrar_carrito").hide();
    //animación carrito
    $(".am_boton_producto").click(function () {
        $(".am_carro").addClass("animated swing delay-5s");
        $(".jg_mostrar_carrito").show();
        //$(".jg_mostrar_carrito").append('{{ product.description }}');
    });


    /*$("#orderr2 div:nth-child(3)").hide();
    $("#orderr2 div:nth-child(4)").hide();*/

    /*$(".jg_input_contact").change(function () {
        if($(".jg_input_contact").valid()){
            $(".jg_valido").attr("src","img/correct.png");
        }else{
            $(".jg_valido").attr("src","img/wrong.png");
        }

    });*/
    //validación en linea de lapagina de contacto
    $(".jg_input_name").on("change", function () {
        //$(".jg_valido").attr("src","img/correct.png");
        var $regexname = /^([a-zA-Z]{1,40})$/;
        if (!$(this).val().match($regexname)) {
            $(".jg_valido_name").attr("src", "img/wrong.png");
        } else {
            $(".jg_valido_name").attr("src", "img/correct.png");
        }

    });
    $(".jg_input_email").on("change", function () {
        var $regexname = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        if (!$(this).val().match($regexname)) {
            $(".jg_valido_email").attr("src", "img/wrong.png");
        } else {
            $(".jg_valido_email").attr("src", "img/correct.png");
        }

    });

    //$(".jg_ocultar_campos div div").append('<img class="jg_valido_register" src="" alt="indicador de campo valido" longdesc="a través de un check o una cruz indica si es válido el campo"/>');

$( "#accordion" ).accordion({
    heightStyle: "content",
    collapsipble: true
});

});