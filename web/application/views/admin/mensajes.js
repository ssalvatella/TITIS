$(function () {
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

$("#mensaje").wysihtml5({
    toolbar: {"size": "xs"},
    locale: "es-ES"
    /*showToolbarAfterInit: false,
     "events": {
     "focus": function () {
     this.toolbar.show();
     },
     "blur": function () {
     this.toolbar.hide();
     }
     }*/
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

$('#enviar_mensaje_form').on('submit', function (e) {
    e.preventDefault();
    var getUrl = window.location;
    var baseURL = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
    var id_receptor = $("#seleccion_usuarios").val() ;
    var mensaje = $('#mensaje').val();
    $.ajax({
        url: baseURL + '/enviar_mensaje',
        type: 'POST',
        data: {id_receptor: id_receptor, mensaje: mensaje},
        success: function (data) {
            $.notify({
                icon: 'glyphicon glyphicon-ok',
                title: '<strong>Mensaje enviado!</strong>', message: ''
            },{
                type: 'success',delay: 100
            });
            $('#mensaje').value = "";
        }
    });
    $('#modal_mensaje').modal('hide');
});

$.fn.modal.Constructor.prototype.enforceFocus = function() {};