<div class="content-wrapper">
    <!-- Cabecera -->
    <section class="content-header">
        <h1>
            <?= $this->lang->line('perfil'); ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('cliente'); ?>"><i class="fa fa-home"></i><?= $this->lang->line('inicio'); ?></a></li>
            <li class="active"></i><?= $this->lang->line('perfil'); ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">           
            <div class="col-md-offset-1 col-md-10">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="<?= $tab_activa == 'datos' ? 'active' : '' ?>"><a href="#datos" data-toggle="tab"><?= $this->lang->line('perfil'); ?></a></li>
                        <li class="<?= $tab_activa == 'editar' ? 'active' : '' ?>"><a href="#editar" data-toggle="tab"><?= $this->lang->line('editar'); ?></a></li>
                    </ul>
                    <div class="tab-content">
                        <!-- /.tab-pane -->
                        <div class="<?= $tab_activa == 'datos' ? 'active' : '' ?> tab-pane" id="datos">
                            <div class="row">
                                <div class="col-md-offset-2 col-md-8">
                                    <img class="profile-user-img img-responsive img-circle" src="<?= site_url('assets/img/avatar/1.png'); ?>" alt="<?= $this->lang->line('imagen_perfil'); ?>">
                                    <h3 class="profile-username text-center"><?= $cliente['usuario']; ?></h3>
                                    <p class="text-muted text-center"><?= $this->lang->line('cliente'); ?></p>
                                    <ul class="list-group list-group-unbordered">
                                        <li class="list-group-item">
                                            <b><?= $this->lang->line('registrado'); ?></b> <a class="pull-right"><?= date('d/m/Y H:i', strtotime($cliente['fecha_registro'])); ?></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b><?= $this->lang->line('email'); ?></b> <a class="pull-right"><?= $cliente['email']; ?></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b><?= $this->lang->line('nombre'); ?></b> <a class="pull-right"><?= $cliente['nombre']; ?></a>
                                        </li>
                                        <?php if ($cliente['email_opcional'] != NULL) { ?>
                                            <li class="list-group-item">
                                                <b><?= $this->lang->line('email_opcional'); ?></b> <a class="pull-right"><?= $cliente['email_opcional']; ?></a>
                                            </li>
                                        <?php } ?>
                                        <li class="list-group-item">
                                            <b><?= $this->lang->line('pais'); ?></b> <a class="pull-right"><?= $cliente['pais']; ?></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b><?= $this->lang->line('provincia'); ?></b> <a class="pull-right"><?= $cliente['provincia']; ?></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b><?= $this->lang->line('localidad'); ?></b> <a class="pull-right"><?= $cliente['localidad']; ?></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b><?= $this->lang->line('cp'); ?></b> <a class="pull-right"><?= $cliente['cp']; ?></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b><?= $this->lang->line('direccion'); ?></b> <a class="pull-right"><?= $cliente['direccion']; ?></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b><?= $this->lang->line('nif'); ?></b> <a class="pull-right"><?= $cliente['nif']; ?></a>
                                        </li>
                                        <?php if ($cliente['contacto'] != NULL) { ?>
                                            <li class="list-group-item">
                                                <b><?= $this->lang->line('contacto'); ?></b> <a class="pull-right"><?= $cliente['contacto']; ?></a>
                                            </li>
                                        <?php } ?>
                                        <li class="list-group-item">
                                            <b><?= $this->lang->line('telefono'); ?></b> <a class="pull-right"><?= '+34 ' . substr($cliente['telefono'], 0, 3) . '-' . substr($cliente['telefono'], 3, 3) . '-' . substr($cliente['telefono'], 6, 3); ?></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b><?= $this->lang->line('numero_cuenta'); ?></b> <a class="pull-right"><?= $cliente['numero_cuenta']; ?></a>
                                        </li>
                                        <?php if ($cliente['observacion'] != NULL) { ?>
                                            <li class="list-group-item">
                                                <b><?= $this->lang->line('observaciones'); ?></b> <a class="pull-right"><?= $cliente['observacion']; ?></a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
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
                            <form id="form-perfil-contrasena" class="form-horizontal"  action="<?= site_url('cliente/perfil'); ?>" method="POST" role="form" data-parsley-errors-messages-disabled="true">
                                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                                <input type="hidden" name="cambio_contrasena" value="1" />
                                <div class="form-group has-feedback <?= form_error('contrasena_antigua') != '' ? 'has-error ' : '' ?> required">
                                    <label for="contrasena_antigua" class="col-sm-2 control-label"><?= $this->lang->line('contrasena_antigua'); ?></label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="contrasena_antigua" name="contrasena_antigua" placeholder="<?= $this->lang->line('contrasena_antigua'); ?>" required>
                                    </div>
                                    <?= form_error('contrasena_antigua'); ?>
                                </div>
                                <div class="form-group has-feedback <?= form_error('contrasena_nueva') != '' ? 'has-error ' : '' ?> required">
                                    <label for="contrasena_nueva" class="col-sm-2 control-label"><?= $this->lang->line('contrasena_nueva'); ?></label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="contrasena_nueva" name="contrasena_nueva" placeholder="<?= $this->lang->line('contrasena_nueva'); ?>" required>
                                    </div>
                                    <?= form_error('contrasena_nueva'); ?>
                                </div>
                                <div class="form-group has-feedback <?= form_error('contrasena_nueva_conf') != '' ? 'has-error ' : '' ?> required">
                                    <label for="contrasena_nueva_conf" class="col-sm-2 control-label"><?= $this->lang->line('contrasena_conf'); ?></label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="contrasena_nueva_conf" name="contrasena_nueva_conf" placeholder="<?= $this->lang->line('contrasena_conf'); ?>" required>
                                        <?= form_error('contrasena_nueva_conf'); ?>
                                    </div>                                    
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-danger"><?= $this->lang->line('cambiar'); ?></button>
                                    </div>
                                </div>
                            </form>
                            <form id="form-perfil" style="margin-top: 50px;" class="form-horizontal"  action="<?= site_url('cliente/perfil'); ?>" method="POST" role="form" data-parsley-errors-messages-disabled="true">
                                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                                <div class="form-group has-feedback <?= form_error('nombre') != '' ? 'has-error ' : '' ?> required">
                                    <label for="nombre" class="col-sm-2 control-label"><?= $this->lang->line('nombre'); ?></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="<?= $this->lang->line('nombre'); ?>" value="<?= $cliente['nombre']; ?>" required>
                                        <?= form_error('nombre'); ?>
                                    </div>
                                </div>
                                <div class="form-group has-feedback <?= form_error('email_opcional') != '' ? 'has-error ' : '' ?>">
                                    <label for="email_opcional" class="col-sm-2 control-label"><?= $this->lang->line('email_opcional'); ?></label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="email_opcional" name="email_opcional" placeholder="<?= $this->lang->line('email_opcional'); ?>" value="<?= $cliente['email_opcional']; ?>">
                                        <?= form_error('email_opcional'); ?>
                                    </div>
                                </div>
                                <div class="form-group has-feedback <?= form_error('pais') != '' ? 'has-error ' : '' ?> required">
                                    <label for="pais" class="col-sm-2 control-label"><?= $this->lang->line('pais'); ?></label>
                                    <div class="col-sm-10">
                                        <div id="pais" class="flagstrap" data-input-name="pais" data-input-name="<?= $this->lang->line('pais'); ?>" data-selected-country="<?= ($cliente['pais'] != NULL) ? $cliente['pais'] : 'ES' ?>" required></div>
                                        <?= form_error('pais'); ?>
                                    </div>
                                </div>
                                <div class="form-group has-feedback <?= form_error('povincia') != '' ? 'has-error ' : '' ?> required">
                                    <label for="provincia" class="col-sm-2 control-label"><?= $this->lang->line('provincia'); ?></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="provincia" name="provincia" placeholder="<?= $this->lang->line('provincia'); ?>" value="<?= $cliente['provincia']; ?>" required>
                                        <?= form_error('provincia'); ?>
                                    </div>
                                </div>
                                <div class="form-group has-feedback <?= form_error('localidad') != '' ? 'has-error ' : '' ?> required">
                                    <label for="localidad" class="col-sm-2 control-label"><?= $this->lang->line('localidad'); ?></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="localidad" name="localidad" placeholder="<?= $this->lang->line('localidad'); ?>" value="<?= $cliente['localidad']; ?>" required>
                                        <?= form_error('localidad'); ?>
                                    </div>
                                </div>
                                <div class="form-group has-feedback <?= form_error('cp') != '' ? 'has-error ' : '' ?> required">
                                    <label for="cp" class="col-sm-2 control-label"><?= $this->lang->line('cp'); ?></label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="cp" name="cp" placeholder="<?= $this->lang->line('cp'); ?>" value="<?= $cliente['cp']; ?>" required>
                                        <?= form_error('cp'); ?>
                                    </div>
                                </div>
                                <div class="form-group has-feedback <?= form_error('povincia') != '' ? 'has-error ' : '' ?> required">
                                    <label for="direccion" class="col-sm-2 control-label"><?= $this->lang->line('direccion'); ?></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="direccion" name="direccion" placeholder="<?= $this->lang->line('direccion'); ?>" value="<?= $cliente['direccion']; ?>" required>
                                        <?= form_error('direccion'); ?>
                                    </div>
                                </div>
                                <div class="form-group has-feedback <?= form_error('nif') != '' ? 'has-error ' : '' ?> required">
                                    <label for="nif" class="col-sm-2 control-label"><?= $this->lang->line('nif'); ?></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="nif" name="nif" placeholder="<?= $this->lang->line('nif'); ?>" value="<?= $cliente['nif']; ?>" required>
                                        <?= form_error('nif'); ?>
                                    </div>
                                </div>
                                <div class="form-group has-feedback <?= form_error('contacto') != '' ? 'has-error ' : '' ?>">
                                    <label for="contacto" class="col-sm-2 control-label"><?= $this->lang->line('contacto'); ?></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="contacto" name="contacto" placeholder="<?= $this->lang->line('contacto'); ?>" value="<?= $cliente['contacto']; ?>">
                                        <?= form_error('contacto'); ?>
                                    </div>
                                </div>
                                <div class="form-group has-feedback <?= form_error('telefono') != '' ? 'has-error ' : '' ?> required">
                                    <label for="telefono" class="col-sm-2 control-label"><?= $this->lang->line('telefono'); ?></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="telefono" name="telefono" placeholder="<?= $this->lang->line('telefono'); ?>" value="<?= $cliente['telefono']; ?>" data-inputmask='"mask": "+34 999-999-999"' data-mask required>
                                        <?= form_error('telefono'); ?>
                                    </div>
                                </div>
                                <div class="form-group has-feedback <?= form_error('numero_cuenta') != '' ? 'has-error ' : '' ?> required">
                                    <label for="numero_cuenta" class="col-sm-2 control-label"><?= $this->lang->line('numero_cuenta'); ?></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="numero_cuenta" name="numero_cuenta" placeholder="<?= $this->lang->line('numero_cuenta'); ?>" value="<?= $cliente['numero_cuenta']; ?>" required>
                                        <?= form_error('numero_cuenta'); ?>
                                    </div>
                                </div>
                                <div class="form-group has-feedback <?= form_error('observaciones') != '' ? 'has-error ' : '' ?>">
                                    <label for="observaciones" class="col-sm-2 control-label"><?= $this->lang->line('observaciones'); ?></label>
                                    <div class="col-sm-10">
                                        <textarea type="text" class="form-control" id="observaciones" placeholder="<?= $this->lang->line('observaciones') . '...'; ?>" name="observaciones"><?= $cliente['observacion']; ?></textarea>
                                        <?= form_error('observaciones'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-danger"><?= $this->lang->line('actualizar'); ?></button>
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
