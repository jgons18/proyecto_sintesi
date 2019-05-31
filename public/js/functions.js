

$(document).ready(function () {




        $("#user_province").on("change", function () {
            var provinciaid = $(this).val();
            var cities = $("#user_city");
            cities.empty();
            cities.append('<option selected="true" disabled>Selecciona una ciudad</option>');

            cities.prop('selectedIndex', 0);

            $.getJSON("json/municipios.json", function (data) {
                $.each(data, function (key, entry) {
                    if (entry.provincia_id == provinciaid) {
                        alert( key + ": " + entry );
                        cities.append('<option value="'+ entry.municipio_id +'">'+ entry.nombre +'</option>');

                    }
                })
            });
        })
});

/*
$.ajax({
    dataType: "json",
    url: 'json/municipios.json',
    success: function (resultado){



        /*  $.each(resultado, function (key, entry) {
              if (mprovinciaid == provinciaid) {
                  cities.append('<option value="'+entry.id+'">'+ entry.name +'</option>');
               }
          })

        alert(municipioid + " " + mprovinciaid+ " "+ciudadName)

    }
});*/
