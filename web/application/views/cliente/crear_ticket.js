var parsley_opciones = {
    successClass: 'has-success',
    errorClass: 'has-error',
    classHandler: function (_el) {
        return _el.$element.closest('.form-group');
    },
    errorsWrapper: '<span class="help-inline hideHelp"></span>',
    errorTemplate: "<span></span>"
};

$('#form_crear_ticket').parsley(parsley_opciones).on('field:validated', function () {
    var ok = $('.parsley-error').length === 0;
    $('.bs-callout-info').toggleClass('hidden', !ok);
    $('.bs-callout-warning').toggleClass('hidden', ok);
});

$('#input_archivo').fileinput({
    language: 'es',
    maxFileSize: 10240, // 10 MB
    allowedFileExtensions: ['txt', 'pdf', 'gif', 'jpg', 'jpeg', 'png', 'zip'],
    showPreview: false,
    showUpload: false
});

$(document).ready(function () {
    $('#mensaje').summernote({
        placeholder: placeholder_mensaje,
        height: 100,
        lang: "es-ES"
    });
});
