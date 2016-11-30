<div class="content-wrapper">
    <!-- Cabecera -->
    <section class="content-header">
        <h1>
            <?= $this->lang->line('nuevo_empleado'); ?>
            <small><?= $this->lang->line('registro_empleado'); ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('admin'); ?>"><i class="fa fa-home"></i> <?= $this->lang->line('inicio'); ?></a></li>
            <li class="active"></i> <?= $this->lang->line('nuevo_empleado'); ?></li>
        </ol>
    </section>

    <!-- Contenido -->
    <section class="content">
        <div class="row">
            <div class="col-lg-offset-1 col-lg-10">
                <form id="form-registro-empleado" action="<?= site_url('admin/registrar_empleado'); ?>" method="POST" role="form" data-parsley-errors-messages-disabled="true">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?= $this->lang->line('registrar'); ?></h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <?php if (isset($mensaje_error)) { ?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="alert alert-warning alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            <i class="fa fa-exclamation-circle"></i> <?= $mensaje_error . '.' ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } else if (isset($mensaje)) { ?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="alert alert-success alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            <i class="fa fa-check-circle"></i> <?= $mensaje . '.' ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="form-group col-md-6 has-feedback <?= form_error('usuario') != '' ? 'has-error ' : '' ?>">
                                <label for="input_usuario"><?= $this->lang->line('usuario'); ?></label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <input type="text" class="form-control" id="input_usuario" placeholder="<?= $this->lang->line('usuario'); ?>" name="usuario" value="<?= set_value('usuario'); ?>" required>
                                </div>    
                                <?= form_error('usuario'); ?>
                            </div>
                            <div class="form-group col-md-6 has-feedback <?= form_error('email') != '' ? 'has-error ' : '' ?>">
                                <label for="input_email"><?= $this->lang->line('email'); ?></label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="ion ion-android-mail"></i>
                                    </div>
                                    <input type="email" class="form-control" id="input_email" placeholder="<?= $this->lang->line('email'); ?>" name="email" value="<?= set_value('email'); ?>" required>
                                </div>   
                                <?= form_error('email'); ?>
                            </div>
                            <div class="form-group col-md-6 has-feedback <?= form_error('tipo_empleado') != '' ? 'has-error ' : '' ?>" id="radio_tipo">
                                <label for="radio_tipo"><?= $this->lang->line('tipo_empleado'); ?></label>
                                <div id="radio_tipo">
                                    <text><input type="radio" name="tipo_empleado" class="flat" value="<?= USUARIO_ADMIN; ?>" <?= set_value('tipo_empleado') == USUARIO_ADMIN ? 'checked' : ''; ?> required> <?= $this->lang->line('admin'); ?></text>&nbsp;&nbsp;
                                    <text><input type="radio" name="tipo_empleado" class="flat" value="<?= USUARIO_TECNICO_ADMIN; ?>" <?= set_value('tipo_empleado') == USUARIO_TECNICO_ADMIN ? 'checked' : ''; ?> required> <?= $this->lang->line('tecnico_admin'); ?></text>&nbsp;&nbsp;
                                    <text><input type="radio" name="tipo_empleado" class="flat" value="<?= USUARIO_TECNICO; ?>" <?= set_value('tipo_empleado') == USUARIO_TECNICO ? 'checked' : ''; ?> required> <?= $this->lang->line('tecnico'); ?></text>
                                </div>
                                <?= form_error('tipo_empleado'); ?>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-info pull-right"><?= $this->lang->line('registrar'); ?></button>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                </form> 
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->