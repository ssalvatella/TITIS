// Completar/Descompletar una tarea
function completar_tarea(elem) {
    var id_tarea = $(elem).closest("li")[0].value;
    var id_ticket = $(elem).closest("li")[0].getAttribute("ticket");
    if (elem.checked) { // Completar tarea
        $.ajax({
            url: url_pagina + '/completar_tarea',
            type: 'POST',
            data: {token_csrf: Cookies.get('token_csrf'), id_tarea: id_tarea, id_ticket: id_ticket},
            success: function (data) {
                $(elem.parentNode).addClass('done');
                /* setTimeout(function () {
                 window.location.reload(true);
                 }, 1500);*/
                $.notify({
                    icon: 'glyphicon glyphicon-ok',
                    title: '<strong>Tarea completada!</strong>',
                    message: 'La tarea ha sido marcada como completada.',
                }, {
                    type: 'success', delay: 100
                });
            }
        });
    } else { // Descompletar tarea
        $.ajax({
            url: baseURL + '/descompletar_tarea',
            type: 'POST',
            data: {token_csrf: Cookies.get('token_csrf'), id_tarea: id_tarea, id_ticket: id_ticket},
            success: function (data) {
                $(elem.parentNode).removeClass('done');
                var li = $(elem).closest('li').find('.fecha_fin');
                li.remove();
                /*setTimeout(function () {
                 window.location.reload(true);
                 }, 1500);*/
                $.notify({
                    icon: 'glyphicon glyphicon-ok',
                    title: '<strong>Tarea pendiente!</strong>',
                    message: 'La tarea ha sido marcada como pendiente.',
                }, {
                    type: 'success', delay: 100
                });
            }
        });
    }
}