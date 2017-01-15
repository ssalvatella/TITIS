<div class="content-wrapper">
    <!-- Cabecera -->
    <section class="content-header">
        <h1>
            <?= $this->lang->line('perfil'); ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('admin'); ?>"><i class="fa fa-home"></i><?= $this->lang->line('inicio'); ?></a></li>
            <li class="active"></i><?= $this->lang->line('perfil'); ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-3">
                <!-- Imagen Perfil -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="<?= site_url('assets/img/avatar/1.png'); ?>" alt="<?= $this->lang->line('imagen_perfil'); ?>">

                        <h3 class="profile-username text-center"><?= $usuario['usuario']; ?></h3>

                        <p class="text-muted text-center"><?= $this->lang->line('admin'); ?></p>

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b><?= $this->lang->line('comentarios'); ?></b> <a class="pull-right"><?= $numero_comentarios   ; ?></a>
                            </li>
                            <li class="list-group-item">
                                <b><?= $this->lang->line('registrado'); ?></b> <a class="pull-right"><?= date('d/m/Y H:i', strtotime($usuario['fecha_registro'])); ?></a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="<?= $tab_activa == 'datos' ? 'active' : '' ?>"><a href="#datos" data-toggle="tab"><?= $this->lang->line('perfil'); ?></a></li>
                        <li class="<?= $tab_activa == 'editar' ? 'active' : '' ?>"><a href="#editar" data-toggle="tab"><?= $this->lang->line('editar'); ?></a></li>
                    </ul>
                    <div class="tab-content">
                        <!-- /.tab-pane -->
                        <div class="<?= $tab_activa == 'datos' ? 'active' : '' ?> tab-pane" id="datos">





                        </div>
                        <!-- /.tab-pane -->

                        <div class="<?= $tab_activa == 'editar' ? 'active' : '' ?> tab-pane" id="editar">
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
                            <form id="form-perfil" class="form-horizontal"  action="<?= site_url('admin/perfil'); ?>" method="POST" role="form" data-parsley-errors-messages-disabled="true">
                                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                                <div class="form-group has-feedback <?= form_error('contrasena_antigua') != '' ? 'has-error ' : '' ?>">
                                    <label for="contrasena_antigua" class="col-sm-2 control-label">Antigua contraseña</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="contrasena_antigua" name="contrasena_antigua" placeholder="Antigua contraseña" required>
                                    </div>
                                    <?= form_error('contrasena_antigua'); ?>
                                </div>
                                <div class="form-group has-feedback <?= form_error('contrasena_nueva') != '' ? 'has-error ' : '' ?>">
                                    <label for="contrasena_nueva" class="col-sm-2 control-label">Nueva contraseña</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="contrasena_nueva" name="contrasena_nueva" placeholder="Nueva contraseña" required>
                                    </div>
                                    <?= form_error('contrasena_nueva'); ?>
                                </div>
                                <div class="form-group has-feedback <?= form_error('contrasena_nueva_conf') != '' ? 'has-error ' : '' ?>">
                                    <label for="contrasena_nueva_conf" class="col-sm-2 control-label">Confirmar contraseña</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="contrasena_nueva_conf" name="contrasena_nueva_conf" placeholder="Confirmar contraseña" required>
                                    </div>
                                    <?= form_error('contrasena_nueva_conf'); ?>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-danger">Cambiar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->