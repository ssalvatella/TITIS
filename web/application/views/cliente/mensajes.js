$(function () {
    $('#mensaje').summernote({
        height: 200,
        lang: "es-ES"
    });

    //Enable iCheck plugin for checkboxes
    //iCheck for checkbox and radio inputs
    $('.mailbox-messages input[type="checkbox"]').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    });

    //Enable check and uncheck all functionality
    $(".checkbox-toggle").click(function () {
        var clicks = $(this).data('clicks');
        if (clicks) {
            //Uncheck all checkboxes
            $(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
            $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
        } else {
            //Check all checkboxes
            $(".mailbox-messages input[type='checkbox']").iCheck("check");
            $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
        }
        $(this).data("clicks", !clicks);
    });

    //Handle starring for glyphicon and font awesome
    $(".mailbox-star").click(function (e) {
        e.preventDefault();
        //detect type
        var $this = $(this).find("a > i");
        var glyph = $this.hasClass("glyphicon");
        var fa = $this.hasClass("fa");

        //Switch states
        if (glyph) {
            $this.toggleClass("glyphicon-star");
            $this.toggleClass("glyphicon-star-empty");
        }

        if (fa) {
            $this.toggleClass("fa-star");
            $this.toggleClass("fa-star-o");
        }
    });

    $('#mensajes').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": false,
        "info": false,
        "autoWidth": false,
        "stateSave": true,
        "responsive": true,
        "columnDefs": [{
                "targets": [3],
                "class": "not-mobile",
            }],
        "fnInitComplete": function () {
            $("#cargador").hide();
        }
    });

});

$('#mensajes tr td').click(function () {
    window.location.href = $(this).parent().find('td:first-child a:first').attr('href');
});

$(".select2").select2({
    language: 'es'
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})
$('#input_archivo').fileinput({
    language: 'es',
    maxFileSize: 10240, // 10 MB
    allowedFileExtensions: ['txt', 'pdf', 'gif', 'jpg', 'jpeg', 'png', 'zip'],
    showPreview: false,
    showUpload: false
});
$.fn.modal.Constructor.prototype.enforceFocus = function () {};

$('#eliminar').click(function () {
    var seleccionados = [];
    $.each($('#mensajes').find('input[type="checkbox"]:checked'), function () {
        $(this).closest("tr").remove();
        seleccionados.push($(this).closest("tr").valueOf().attr("value"));
    })

    $.ajax({
        url: url_pagina + '/eliminar_mensajes',
        type: 'POST',
        data: {token_csrf: Cookies.get('token_csrf'), mensajes: seleccionados},
        success: function (data) {
            /* setTimeout(function () {
             window.location.reload(true);
             }, 1500); */
            $.notify({
                icon: 'glyphicon glyphicon-ok',
                title: '<strong>Mensajes eliminados!</strong>',
                message: 'Los mensajes han sido eliminados con éxito.',
            }, {
                type: 'success', delay: 100
            });
        }
    });

});