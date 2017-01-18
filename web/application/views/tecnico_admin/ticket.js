// Las tareas se pueden ordenar (no se mantiene el orden cuando se recarga la página)
$(".todo-list").sortable({
    placeholder: "sort-highlight",
    handle: ".handle",
    forcePlaceholderSize: true,
    zIndex: 999999
});

$(".select2").select2({
    language: 'es'
});

// Completar/Descompletar una tarea
function completar_tarea(elem) {
    var id_tarea = $(elem).closest("li")[0].value;
    var id_ticket = window.location.pathname.split('/').pop();

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
            url: url_pagina + '/descompletar_tarea',
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

$('input[type="checkbox"].flat, input[type="radio"].flat').iCheck({
    checkboxClass: 'icheckbox_flat-blue',
    radioClass: 'iradio_flat-blue'
});

var parsley_opciones = {
    successClass: 'has-success',
    errorClass: 'has-error',
    classHandler: function (_el) {
        return _el.$element.closest('.form-group');
    },
    errorsWrapper: '<span class="help-inline hideHelp"></span>',
    errorTemplate: "<span></span>"
};

$('#form_enviar_mensaje').parsley(parsley_opciones).on('field:validated', function () {
    var ok = $('.parsley-error').length === 0;
    $('.bs-callout-info').toggleClass('hidden', !ok);
    $('.bs-callout-warning').toggleClass('hidden', ok);
});


var fecha_inicio;
var fecha_fin;
var tarea_editar;

$(".tiempo_tarea").daterangepicker({
    timePicker: true,
    timePickerIncrement: 30,
    format: 'MM/DD/YYYY h:mm A',
    autoUpdateInput: false,
    locale: {
        "format": "MM/DD/YYYY h:mm A",
        "separator": " - ",
        "applyLabel": "Aplicar",
        "cancelLabel": "Cancelar",
        "fromLabel": "Desde",
        "toLabel": "Hasta",
        "customRangeLabel": "Custom",
        "daysOfWeek": ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
        "monthNames": [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Augosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        ],
        "firstDay": 1
    }},
        function (start, end, label) {
            fecha_inicio = start;
            fecha_fin = end;
        }
);
$(".tiempo_tarea").on('apply.daterangepicker', function (ev, picker) {
    $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
});

$(".tiempo_tarea").on('cancel.daterangepicker', function (ev, picker) {
    $(this).val('');
});

$(document).ready(function () {
    $('#mensaje').summernote({
        lang: "es-ES"
    });
    $('#textarea_descripcion').summernote({
        lang: "es-ES"
    });
    $('#textarea_descripcion').summernote("code", document.getElementById('texto_descripcion').innerHTML);
    $('#textarea_mensaje').summernote({
        lang: "es-ES"
    });
});

$('.boton-guardar-mensaje').hide(); // Oculta los botones de guardar los mensajes
$('.boton-cancelar-mensaje').hide(); // Oculta los botones de cancelar los mensajes

function editar_mensaje(elem) {
    $(elem).hide(); // Oculta el botón de editar
    var boton_guardar = elem.nextElementSibling;
    var boton_cancelar = boton_guardar.nextElementSibling;
    $(boton_guardar).show()
    $(boton_cancelar).show()
    var parent = elem.parentNode;
    var siguiente_div = parent.nextElementSibling;
    var mensaje_div = siguiente_div.children[0];
    $(mensaje_div).summernote({focus: true});
}

function guardar_mensaje(elem) {
    $(elem).hide(); // Oculta el botón de guardar
    var boton_editar = elem.previousElementSibling;
    var boton_cancelar = elem.nextElementSibling;
    $(boton_editar).show()
    $(boton_cancelar).hide()
    var parent = elem.parentNode;
    var siguiente_div = parent.nextElementSibling;
    var mensaje_div = siguiente_div.children[0];

    var id_mensaje = $(elem).val();
    var mensaje = $(mensaje_div).summernote('code');
    $(mensaje_div).summernote('destroy');

    $.ajax({
        url: url_pagina + '/editar_mensaje',
        type: 'POST',
        data: {token_csrf: Cookies.get('token_csrf'), id_mensaje: id_mensaje, mensaje: mensaje},
        success: function (data) {
            /* setTimeout(function () {
             window.location.reload(true);
             }, 1500);*/
            $.notify({
                icon: 'glyphicon glyphicon-ok',
                title: '<strong>Mensaje editado!</strong>',
                message: 'El mensaje ha sido editado con éxito.',
            }, {
                type: 'success', delay: 100
            });
        }
    });
}

function cancelar_mensaje(elem) {
    $(elem).hide(); // Oculta el botón de cancelar
    boton_guardar = elem.previousElementSibling;
    boton_editar = boton_guardar.previousElementSibling;
    $(boton_guardar).hide()
    $(boton_editar).show()
    var parent = elem.parentNode;
    var siguiente_div = parent.nextElementSibling;
    var mensaje_div = siguiente_div.children[0];
    $(mensaje_div).summernote('destroy');
}


$(function () {
    $('#crear_tarea_form').on('submit', function (e) {
        e.preventDefault();
        var id_ticket = window.location.pathname.split('/').pop();
        var id_tecnico = $("#seleccion_tecnicos").val();
        var descripcion_tarea = $('#descripcion_tarea').val();
        $.ajax({
            url: url_pagina + '/crear_tarea',
            type: 'POST',
            data: {token_csrf: token_csrf, id_ticket: id_ticket, id_tecnico: id_tecnico, descripcion_tarea: descripcion_tarea, inicio: fecha_inicio.format('DD/MM/YYYY HH:MM'), fin_previsto: fecha_fin.format('DD/MM/YYYY HH:MM')},
            success: function (data) {
                setTimeout(function () {
                    window.location.reload(true);
                }, 1500);
                $.notify({
                    icon: 'glyphicon glyphicon-ok',
                    title: '<strong>Tarea creada!</strong>',
                    message: 'La tarea ha sido creada con éxito.',
                }, {
                    type: 'success', delay: 100
                });
            }
        });
        $('#modal_tarea').modal('hide');
    });

    $('#editar_tarea_form').on('submit', function (e) {
        e.preventDefault();
        var id_tecnico = $("#seleccion_tecnicos").val();
        var descripcion_tarea = $('#descripcion_tarea_editar').val();
        $.ajax({
            url: url_pagina + '/editar_tarea',
            type: 'POST',
            data: {token_csrf: Cookies.get('token_csrf'), id_tarea: tarea_editar, id_tecnico: id_tecnico, descripcion_tarea: descripcion_tarea, inicio: fecha_inicio.format('DD/MM/YYYY HH:MM'), fin_previsto: fecha_fin.format('DD/MM/YYYY HH:MM')},
            success: function (data) {
                setTimeout(function () {
                    window.location.reload(true);
                }, 1500);
                $.notify({
                    icon: 'glyphicon glyphicon-ok',
                    title: '<strong>Tarea editada!</strong>',
                    message: 'La tarea ha sido editada con éxito.',
                }, {
                    type: 'success', delay: 100
                });
            }
        });
        $('#modal_editar_tarea').modal('hide');
    });

    $('#editar_descripcion_form').on('submit', function (e) {
        e.preventDefault();
        var id_descripcion = $("#id_descripcion").val();
        var descripcion = $('#textarea_descripcion').val();
        $.ajax({
            url: url_pagina + '/editar_descripcion',
            type: 'POST',
            data: {token_csrf: Cookies.get('token_csrf'), id_descripcion: id_descripcion, descripcion: descripcion},
            success: function (data) {
                setTimeout(function () {
                    window.location.reload(true);
                }, 1500);
                $.notify({
                    icon: 'glyphicon glyphicon-ok',
                    title: '<strong>Descripción editada!</strong>',
                    message: 'La descripción ha sido editada con éxito.',
                }, {
                    type: 'success', delay: 100
                });
            }
        });
        $('#modal_editar_descripcion').modal('hide');
    });

    $(".boton_editar").on("click", function () {
        var li = $(this).closest('li');
        var id_tarea = li[0].value;
        var descripcion_tarea = li.find('.text')[0].textContent;
        var tecnico = li.find('.label label-primary');
        $('#descripcion_tarea_editar').val(descripcion_tarea);
        tarea_editar = id_tarea;

    });

    $(".boton_borrar").on("click", function () {
        var id_tarea = $(this).closest("li")[0].value;
        var li = $(this).closest('li')
        li.fadeOut('slow', function () {
            li.remove();
        });
        $.ajax({
            url: url_pagina + '/borrar_tarea',
            type: 'POST',
            data: {token_csrf: Cookies.get('token_csrf'), id_tarea: id_tarea},
            success: function (data) {
                setTimeout(function () {
                    window.location.reload(true);
                }, 1500);
                $.notify({
                    icon: 'glyphicon glyphicon-ok',
                    title: '<strong>Tarea borrada!</strong>',
                    message: 'La tarea ha sido borrada con éxito.',
                }, {
                    type: 'success', delay: 100
                });
            }
        });
    });

});

// Corrige el select2 en los modales
$.fn.modal.Constructor.prototype.enforceFocus = function () {};


$('#input_archivo').fileinput({
    language: 'es',
    maxFileSize: 10240, // 10 MB
    allowedFileExtensions: ['txt', 'pdf', 'gif', 'jpg', 'jpeg', 'png', 'zip'],
    showPreview: false,
    showUpload: false
});
