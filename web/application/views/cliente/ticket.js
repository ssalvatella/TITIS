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

$('#input_archivo').fileinput({
    language: 'es',
    maxFileSize: 10240, // 10 MB
    allowedFileExtensions: ['txt', 'pdf', 'gif', 'jpg', 'jpeg', 'png', 'zip'],
    showPreview: false,
    showUpload: false
});
