$(function () {
    $('[data-toggle="tooltip"]').tooltip();
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

    $('#enviar_mensaje_form').on('submit', function (e) {
        e.preventDefault();
        var getUrl = window.location;
        var baseURL = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
        var id_cliente = getUrl.pathname.split('/')[3];
        var mensaje = $('#mensaje').val();
        $.ajax({
            url: baseURL + '/enviar_mensaje',
            type: 'POST',
            data: {id_receptor: id_cliente, mensaje: mensaje},
            success: function (data) {
                $.notify({
                    icon: 'glyphicon glyphicon-ok',
                    title: '<strong>Mensaje enviado!</strong>'
                },{
                    type: 'success',delay: 100
                });
            }
        });
        $('#modal_mensaje').modal('hide');
    });

})