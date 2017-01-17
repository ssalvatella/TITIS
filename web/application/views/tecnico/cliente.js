$(function () {
    $('[data-toggle="tooltip"]').tooltip();

    $('#enviar_mensaje_form').on('submit', function (e) {
        e.preventDefault();
        var getUrl = window.location;
        var baseURL = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
        var id_cliente = $('#modal_mensaje').attr("value");
        var mensaje = $('#mensaje').val();
        $.ajax({
            url: baseURL + '/enviar_mensaje_privado',
            type: 'POST',
            data: {token_csrf: Cookies.get('token_csrf'), id_receptor: id_cliente, mensaje: mensaje},
            success: function () {
                $.notify({
                    icon: 'glyphicon glyphicon-ok',
                    title: '<strong>Mensaje enviado!</strong>', message: ''
                }, {
                    type: 'success', delay: 100
                });
                $('#mensaje').value = "";
            }
        });
        $('#modal_mensaje').modal('hide');
    });
})

$(document).ready(function () {
    $('#mensaje').summernote({
        lang: "es-ES"
    });
});