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

$(function () {
    $('#facturas').DataTable({
        "paging": true,
        "lengthChane": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "stateSave": true,
        "autoWidth": false,
        "responsive": true,
        "fnInitComplete": function() {
            $("#cargador").hide();
        }
    });
    $('[data-toggle="tooltip"]').tooltip();
});

$('#facturas tr td:not(:last-child)').click(function() {
    window.location.href = $(this).parent().find('td:first-child a:first').attr('href');
});