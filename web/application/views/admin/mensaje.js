$('#mensaje').summernote({
    height: 200,
    lang: "es-ES"
});

$(".select2").select2({
    language: 'es'
});

$('#input_archivo').fileinput({
    language: 'es',
    maxFileSize: 10240, // 10 MB
    allowedFileExtensions: ['txt', 'pdf', 'gif', 'jpg', 'jpeg', 'png', 'zip'],
    showPreview: false,
    showUpload: false
});

$.fn.modal.Constructor.prototype.enforceFocus = function () {};

