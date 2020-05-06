$('#formulario-eliminar').hide();

$('#eliminar-jugador').click(function () {
    $('#formulario-eliminar').show();
    $(this).hide();
});

$(document).ready(function () {
    //Esperar 1 minuto para ocultar a los volados de la partida
    window.setTimeout(function () { ocultarVolados() }, 60000);

    function ocultarVolados() {
        $('#volados').hide();
    }
});