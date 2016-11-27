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
                noty({text: '¡Tarea marcada como realizada!', type: 'success', layout: 'topRight', timeout: 1000});
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
                noty({text: '¡Tarea marcada como en proceso!', type: 'success', layout: 'topRight', timeout: 1000});
            }
        });
        return ele;
    }
});

var fecha_inicio;
var fecha_fin;

$("#tiempo_tarea").daterangepicker({
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
$("#tiempo_tarea").on('apply.daterangepicker', function (ev, picker) {
    $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
});

$("#tiempo_tarea").on('cancel.daterangepicker', function (ev, picker) {
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

    $(".select2").select2();

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
                noty({text: '¡Tarea creada con éxito!', type: 'success', layout: 'topRight', timeout: 1000});
            }
        });
        $('#modal_tarea').modal('hide');


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
                noty({text: '¡Tarea borrada con éxito!', type: 'success', layout: 'topRight', timeout: 1000});
            }
        });
    });

});


