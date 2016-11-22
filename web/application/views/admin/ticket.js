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
        window.console.log("The element has been checked");
        return ele;
    },
    onUncheck: function (ele) {
        window.console.log("The element has been unchecked");
        return ele;
    }
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

    // $('#eliminar').click($(function () {
    //     var getUrl = window.location;
    //     var baseURL = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
    //     var id_ticket = getUrl.pathname.split('/')[3];
    //     $.ajax({
    //         url: baseURL + '/eliminar_ticket',
    //         type: 'POST',
    //         data: {id_ticket: id_ticket},
    //     });
    //     $('modal_eliminar').modal('hide');
    //
    // }));



});

