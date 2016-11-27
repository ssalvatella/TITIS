$(function () {
    $('input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    });

    $('input[type="radio"].flat').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    });

});


var parsleyOptions = {
    successClass: 'has-success',
    errorClass: 'has-error',
    classHandler: function (_el) {
        return _el.$element.closest('.form-group');
    },
    errorsWrapper: '<span class="help-inline hideHelp"></span>',
    errorTemplate: "<span></span>"
};

/*
 $(document).ready(function () {
 $.listen('parsley:field:validate', function () {
 validateFront();
 });
 $('#form-registro-empleado .btn').on('click', function () {
 $('#form-registro-empleado').parsley(parsleyOptions).validate();
 validateFront();
 });
 var validateFront = function () {
 if (true === $('#form-registro-empleado').parsley().isValid()) {
 $('.bs-callout-info').removeClass('hidden');
 $('.bs-callout-warning').addClass('hidden');
 } else {
 $('.bs-callout-info').addClass('hidden');
 $('.bs-callout-warning').removeClass('hidden');
 }
 };
 });*/


$(function () {
    $('#form-registro-empleado').parsley(parsleyOptions).on('field:validated', function () {
        var ok = $('.parsley-error').length === 0;
        $('.bs-callout-info').toggleClass('hidden', !ok);
        $('.bs-callout-warning').toggleClass('hidden', ok);
    });
});
