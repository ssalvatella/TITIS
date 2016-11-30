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
    $('#form-registro-cliente').parsley(parsleyOptions).on('field:validated', function () {
        var ok = $('.parsley-error').length === 0;
        $('.bs-callout-info').toggleClass('hidden', !ok);
        $('.bs-callout-warning').toggleClass('hidden', ok);
    });

    $("textarea").wysihtml5({
        toolbar: {"size": "xs"},
        locale: "es-ES"
    });

    $("[data-mask]").inputmask();

    $('#pais').flagStrap({
        placeholder: false
    });
});

