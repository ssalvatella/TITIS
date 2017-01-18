$('#tickets tr td:not(:last-child)').click(function () {
    window.location.href = $(this).parent().find('td:first-child a:first').attr('href');
});