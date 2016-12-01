$(function () {
    $('#tickets').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "stateSave": true,
        "columnDefs": [{
                "targets": [0, 3, 4, 5],
                "class": "not-mobile",
            }],
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
