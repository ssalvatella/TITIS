var parsleyOptions = {
    successClass: 'has-success',
    errorClass: 'has-error',
    classHandler: function (_el) {
        return _el.$element.closest('.form-group');
    },
    errorsWrapper: '<span class="help-inline hideHelp"></span>',
    errorTemplate: "<span></span>"
};


$(function () {
    $('#form-editar').parsley(parsleyOptions).on('field:validated', function () {
        var ok = $('.parsley-error').length === 0;
        $('.bs-callout-info').toggleClass('hidden', !ok);
        $('.bs-callout-warning').toggleClass('hidden', ok);
    });

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

    $('#facturas').DataTable({
        "paging": true,
        "lengthChane": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "stateSave": true,
        "autoWidth": false,
        "responsive": true,
        "fnInitComplete": function () {
            $("#cargador").hide();
        }
    });

    $("[data-mask]").inputmask();

    $('#pais').flagStrap({
        placeholder: false
    });

    $('[data-toggle="tooltip"]').tooltip();
})

$(document).ready(function () {
    $('.summer').summernote({
        height: 300,
        lang: "es-ES"
    });

    $('textarea').summernote({
        lang: "es-ES"
    });
});


$('#facturas tr td:not(:last-child)').click(function () {
    window.location.href = $(this).parent().find('td:first-child a:first').attr('href');
});