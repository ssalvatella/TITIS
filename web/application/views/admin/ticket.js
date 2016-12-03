//jQuery UI sortable for the todo list
$(".todo-list").sortable({
    placeholder: "sort-highlight",
    handle: ".handle",
    forcePlaceholderSize: true,
    zIndex: 999999
});

/* The todo list plugin */
$(".todo-list").todolist({
    onCheck: function (ele) {
        var id_tarea = $(this).closest("li")[0].value;
        var getUrl = window.location;
        var baseURL = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
        var id_ticket = getUrl.pathname.split('/')[3];
        $.ajax({
            url: baseURL + '/completar_tarea',
            type: 'POST',
            data: {id_tarea: id_tarea, id_ticket: id_ticket},
            success: function (data) {
                setTimeout(function () {
                    window.location.reload(true);
                }, 1500);
                $.notify({
                    icon: 'glyphicon glyphicon-ok',
                    title: '<strong>Tarea completada!</strong>',
                    message: 'La tarea ha sido marcada como completada.',
                }, {
                    type: 'success', delay: 100
                });
            }
        });
        return ele;
    },
    onUncheck: function (ele) {
        var id_tarea = $(this).closest("li")[0].value;
        var getUrl = window.location;
        var baseURL = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
        var id_ticket = getUrl.pathname.split('/')[3];
        var li = $(this).closest('li').find('.fecha_fin');
        li.remove();
        $.ajax({
            url: baseURL + '/descompletar_tarea',
            type: 'POST',
            data: {id_tarea: id_tarea, id_ticket: id_ticket},
            success: function (data) {
                setTimeout(function () {
                    window.location.reload(true);
                }, 1500);
                $.notify({
                    icon: 'glyphicon glyphicon-ok',
                    title: '<strong>Tarea pendiente!</strong>',
                    message: 'La tarea ha sido marcada como pendiente.',
                }, {
                    type: 'success', delay: 100
                });
            }
        });
        return ele;
    }
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

$(function () {
    $("#mensaje").wysihtml5({
        toolbar: {"size": "xs"},
        locale: "es-ES"
                /*showToolbarAfterInit: false,
                 "events": {
                 "focus": function () {
                 this.toolbar.show();
                 },
                 "blur": function () {
                 this.toolbar.hide();
                 }
                 }*/
    });

    $('#textarea_descripcion').val(document.getElementById('texto_descripcion').innerHTML);
    $("#textarea_descripcion").wysihtml5({
        toolbar: {"size": "xs"},
        locale: "es-ES"
    });

    var editor_mensaje = $("#textarea_mensaje").wysihtml5({
        toolbar: {"size": "xs"},
        locale: "es-ES"
    });

    $('#asigna_tecnico_admin_form').on('submit', function (e) {
        e.preventDefault();
        var getUrl = window.location;
        var baseURL = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
        var id_ticket = getUrl.pathname.split('/')[3];
        var id_tecnico_admin = $("#seleccion_tecnicos_admins").val();
        $.ajax({
            url: baseURL + '/asignar_ticket',
            type: 'POST',
            data: {id_ticket: id_ticket, id_tecnico_admin: id_tecnico_admin},
        });
        $('#modal_asignar').modal('hide');
        window.location.reload();
    });

    $('#crear_tarea_form').on('submit', function (e) {
        e.preventDefault();
        var getUrl = window.location;
        var baseURL = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
        var id_ticket = getUrl.pathname.split('/')[3];
        var id_tecnico = $("#seleccion_tecnicos").val();
        var descripcion_tarea = $('#descripcion_tarea').val();
        $.ajax({
            url: baseURL + '/crear_tarea',
            type: 'POST',
            data: {id_ticket: id_ticket, id_tecnico: id_tecnico, descripcion_tarea: descripcion_tarea, inicio: fecha_inicio.format('DD/MM/YYYY HH:MM'), fin_previsto: fecha_fin.format('DD/MM/YYYY HH:MM')},
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
        var getUrl = window.location;
        var baseURL = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
        var id_tecnico = $("#seleccion_tecnicos").val();
        var descripcion_tarea = $('#descripcion_tarea_editar').val();
        $.ajax({
            url: baseURL + '/editar_tarea',
            type: 'POST',
            data: {id_tarea: tarea_editar, id_tecnico: id_tecnico, descripcion_tarea: descripcion_tarea, inicio: fecha_inicio.format('DD/MM/YYYY HH:MM'), fin_previsto: fecha_fin.format('DD/MM/YYYY HH:MM')},
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
        var getUrl = window.location;
        var baseURL = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
        var id_descripcion = $("#id_descripcion").val();
        var descripcion = $('#textarea_descripcion').val();
        $.ajax({
            url: baseURL + '/editar_descripcion',
            type: 'POST',
            data: {id_descripcion: id_descripcion, descripcion: descripcion},
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

    $('#modal_editar_mensaje').on('show.bs.modal', function (e) {
        var id_mensaje = $(e.relatedTarget).data('id_mensaje');
        // -----------------------------------------------> NO PUEDO DARLE UN VALOR AL TEXTAREA
        console.log(editor_mensaje);
        console.log(editor_mensaje.data('wysihtml5'));
        console.log(editor_mensaje.data('wysihtml5').editor);
        // $('#textarea_mensaje').val('aaaaaa');
        //editor_mensaje.setValue('asd');
        var editorInstance = editor_mensaje.data('wysihtml5').editor;
        console.log(editorInstance);
        editorInstance.setValue('some text to be inserted into editor', true);
        $('#editar_mensaje_form').on('submit', function (e) {
            e.preventDefault();
            var getUrl = window.location;
            var baseURL = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
            var mensaje = $('#textarea_mensaje').val();
            console.log(id_mensaje);
            console.log(mensaje);
            $.ajax({
                url: baseURL + '/editar_mensaje',
                type: 'POST',
                data: {id_mensaje: id_mensaje, mensaje: mensaje},
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
            $('#modal_editar_mensaje').modal('hide');
        });
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
        var getUrl = window.location;
        var baseURL = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
        var li = $(this).closest('li')
        li.fadeOut('slow', function () {
            li.remove();
        });
        $.ajax({
            url: baseURL + '/borrar_tarea',
            type: 'POST',
            data: {id_tarea: id_tarea},
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

$.fn.modal.Constructor.prototype.enforceFocus = function () {};


