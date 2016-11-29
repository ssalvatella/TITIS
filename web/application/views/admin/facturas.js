$(function () {
    $('#facturas').DataTable({
        "paging": true,
        "lengthChane": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "fnInitComplete": function() {
            $("#cargador").hide();
        }
    });
});

$('#facturas tr td:not(:last-child)').click(function() {
    window.location.href = $(this).parent().find('td:first-child a:first').attr('href');
});

$(function() {
    $('[data-toggle="tooltip"]').tooltip();
});