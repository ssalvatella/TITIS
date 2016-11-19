<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?= NOMBRE_WEB ?> | <?= $this->lang->line('iniciar_sesion'); ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?= meta('description', 'TITIS - Gestión de incidencias y tickets') ?>
        <?= link_tag(site_url('favicon.ico'), 'shortcut icon', 'image/ico') ?>

        <!-- CSS REQUERIDOS -->
        <link rel="stylesheet" href="<?= site_url('assets/css/bootstrap.min.css'); ?>">
        <link rel="stylesheet" href="<?= site_url('assets/css/font-awesome.min.css'); ?>">
        <link rel="stylesheet" href="<?= site_url('assets/css/ionicons.min.css'); ?>">
        <link rel="stylesheet" href="<?= site_url('assets/plugins/flag-icon-css/css/flag-icon.min.css'); ?>">
        <link rel="stylesheet" href="<?= site_url('assets/css/AdminLTE.min.css'); ?>">
        <link rel="stylesheet" href="<?= site_url('assets/plugins/iCheck/square/blue.css'); ?>">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="<?= site_url(); ?>"><b>TITIS</b></a>
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <h3 class="login-box-msg"><?= $this->lang->line('iniciar_sesion'); ?></h3>
                <div>
                    <?php if (isset($mensaje)) { ?>
                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $mensaje; ?>
                        </div>
                    <?php } ?>
                    <?php if (isset($mensaje_error)) { ?>
                        <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $mensaje_error; ?>
                        </div>
                    <?php } ?>
                </div>


                <form action="<?= site_url('login'); ?>" method="POST" data-toggle="validator" role="form">
                    <div class="form-group has-feedback <?= form_error('usuario') != '' ? 'has-error ' : '' ?>">
                        <input type="text" class="form-control" placeholder="<?= $this->lang->line('usuario'); ?>" name="usuario" value="<?= set_value('usuario'); ?>" required>
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        <?= form_error('usuario'); ?>
                    </div>
                    <div class="form-group has-feedback <?= form_error('contrasena') != '' ? 'has-error ' : '' ?>">
                        <input type="password" class="form-control" placeholder="<?= $this->lang->line('contrasena'); ?>" name="contrasena" required>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        <?= form_error('contrasena'); ?>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-sm-7">
                            <div class="checkbox icheck">
                                <label>
                                    <input type="checkbox" name="recordarme"> <?= $this->lang->line('recordarme'); ?>
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-6 col-sm-5">
                            <button type="submit" class="btn btn-primary btn-block btn-flat"><?= $this->lang->line('iniciar_sesion'); ?></button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>                

                <br>
                <div class="row">
                    <div class="col-xs-6">
                        <a href="#" data-toggle="modal" data-target="#modal_contrasena_olvidada"><?= $this->lang->line('contrasena_olvidada'); ?></a>
                        <br>
                        <a href="<?= site_url('registro'); ?>" class="text-center"><?= $this->lang->line('registrar'); ?></a>
                    </div>
                    <div class="col-xs-6 text-right" style="font-size: 200%;">
                        <a href="<?= site_url('idioma_switcher/cambiar_idioma/spanish'); ?>" title="Español"><span class="flag-icon flag-icon-es"></span></a>
                        <a href="<?= site_url('idioma_switcher/cambiar_idioma/english'); ?>" title="English"><span class="flag-icon flag-icon-gb"></span></a>
                    </div>
                </div>
                <div class="modal" id="modal_contrasena_olvidada">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="form_contrasena_olvidada" class="form-horizontal" action="<?= site_url('contrasena_olvidada') ?>" method="POST" data-toggle="validator">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h3 class="modal-title"><?= $this->lang->line('contrasena_olvidada'); ?></h3>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group col-md-12">
                                        <label for="input_usuario" class="col-sm-3 control-label"><?= $this->lang->line('usuario'); ?></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="usuario" id="input_usuario" placeholder="<?= $this->lang->line('usuario'); ?>" required>
                                        </div>                                
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="input_email" class="col-sm-3 control-label"><?= $this->lang->line('email'); ?></label>
                                        <div class="col-sm-8">
                                            <input type="email" class="form-control" name="email" id="input_email" placeholder="<?= $this->lang->line('email'); ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?= $this->lang->line('cancelar'); ?></button>
                                    <button id="boton_nuevo" type="submit" class="btn btn-primary"><?= $this->lang->line('cambiar'); ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.modal -->                

            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->

        <script src="<?= site_url('assets/plugins/jQuery/jquery.min.js'); ?>"></script>
        <script src="<?= site_url('assets/js/bootstrap.min.js'); ?>"></script>
        <script src="<?= site_url('assets/plugins/iCheck/icheck.min.js'); ?>"></script>
        <script src="<?= site_url('assets/plugins/bootstrap-validator/validator.min.js'); ?>"></script>
        <script>
            $(function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });
            });
        </script>
    </body>
</html>
