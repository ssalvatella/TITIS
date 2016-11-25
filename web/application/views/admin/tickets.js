$(function () {
    $('#tickets').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "fnInitComplete": function () {
            $("#cargador").hide();
        }
    });
});

$('#tickets tr td:not(:last-child)').click(function () {
    window.location.href = $(this).parent().find('td:first-child a:first').attr('href');
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

$(document).ajaxStart(function () {
    Pace.restart();
});
$('.ajax-recargar-pagina').click(function () {
    $.ajax({url: '#', success: function (result) {
            // $('.ajax-content').html('<hr>Ajax Request Completed !');
        }});
});