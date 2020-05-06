$('#otros-botones').hide();
$('#formulario-eliminar').hide();

$('#mostrarOtros').click(function () {
    $(this).hide();
    $('#otros-botones').show();
});

$('#eliminar-jugador').click(function () {
    $('#formulario-eliminar').show();
    $(this).hide();
});