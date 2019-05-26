

$(document).ready(function () {
    $('#slider a:gt(0)').hide();
    var interval = setInterval(changeDiv, 6000);
    function changeDiv(){
        $('#slider a:first-child').fadeOut(1000).next('a').fadeIn(1000).end().appendTo('#slider');
    };
    $('.mas').click(function(){
        changeDiv();
        clearInterval(interval);
        interval = setInterval(changeDiv, 6000);
    });
    $('.menos').click(function(){
        $('#slider a:first-child').fadeOut(1000);
        $('#slider a:last-child').fadeIn(1000).prependTo('#slider');
        clearInterval(interval);
        interval = setInterval(changeDiv, 6000);
    });

    //$(".jg_nav_fruit").addClass("jg_menu_selected");
    //añadimos la clase que le pone negrita a la letra al elemento que hemos seleccionado
    $(".jg_nav_fruit").click(function () {
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
    });

    /*indicamos que cuando seleccionemos por ej. el filtro de los Plátanos, tendrá un color de fondo
    * más vistoso que el resto de filtros*/
    $(".jg_filtros_banana").on('click',function () {
        $(this).addClass("jg_filtros_selected");
        $(".jg_filtro_apple").removeClass("jg_filtros_selected");

    });
    $(".jg_filtro_apple").on('click',function () {
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

});


