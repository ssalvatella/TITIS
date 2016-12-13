function borrar_notificacion(elem, id_notificacion) {
    var div_notificacion = elem.parentNode.parentNode.parentNode;
    var div_anterior = div_notificacion.previousElementSibling;
    var div_posterior = div_notificacion.nextElementSibling;
    var div_tiempo = $(div_posterior).hasClass('time-label');
    $(div_notificacion).fadeOut(300, function () {
        $(div_notificacion).remove();
    });
    if (div_tiempo) {
        $(div_anterior).fadeOut(300, function () {
            $(div_anterior).remove();
        });
    }
    var getUrl = window.location;
    var baseURL = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
    $.ajax({
        url: baseURL + '/borrar_notificacion',
        type: 'POST',
        data: {id_notificacion: id_notificacion},
        success: function (data) {
            /*$.notify({
             icon: 'glyphicon glyphicon-ok',
             title: '<strong>Notificacion eliminada!</strong>',
             message: 'La notificacion ha sido eliminada.',
             }, {
             type: 'success', delay: 100
             });*/
        }
    });
}