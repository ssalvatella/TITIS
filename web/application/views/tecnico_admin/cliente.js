$(function () {
    $('[data-toggle="tooltip"]').tooltip();

    $('#enviar_mensaje_form').on('submit', function (e) {
        $('#modal_mensaje').modal('hide');
    });
    $('#input_archivo').fileinput({
        language: 'es',
        maxFileSize: 10240, // 10 MB
        allowedFileExtensions: ['txt', 'pdf', 'gif', 'jpg', 'jpeg', 'png', 'zip'],
        showPreview: false,
        showUpload: false
    });
    $(".select2").select2({
        language: 'es'
    });
})

$(document).ready(function () {
    $('.summer').summernote({
        height: 300,
        lang: "es-ES"
    });
});