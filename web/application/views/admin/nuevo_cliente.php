<div class="content-wrapper">
    <!-- Cabecera -->
    <section class="content-header">
        <h1>
            <?= $this->lang->line('nuevo_cliente'); ?>
            <small><?= $this->lang->line('registro_cliente'); ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('admin'); ?>"><i class="fa fa-home"></i> <?= $this->lang->line('inicio'); ?></a></li>
            <li class="active"></i> <?= $this->lang->line('nuevo_cliente'); ?></li>
        </ol>
    </section>

    <!-- Contenido -->
    <section class="content">
        <div class="row">
            <div class="col-lg-offset-1 col-lg-10">
                <form id="form-registro-cliente" action="<?= site_url('admin/registrar_cliente'); ?>" method="POST" role="form" data-parsley-errors-messages-disabled="true">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
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
                            <div class="form-group col-md-6 has-feedback <?= form_error('usuario') != '' ? 'has-error ' : '' ?> required">
                                <label class="control-label" for="input_usuario"><?= $this->lang->line('usuario'); ?></label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <input type="text" class="form-control" id="input_usuario" placeholder="<?= $this->lang->line('usuario'); ?>" name="usuario" value="<?= set_value('usuario'); ?>" required>
                                </div>   
                                <?= form_error('usuario'); ?>
                            </div>
                            <div class="form-group col-md-6 has-feedback <?= form_error('nombre') != '' ? 'has-error ' : '' ?> required">
                                <label class="control-label"><?= $this->lang->line('nombre'); ?></label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <input type="text" class="form-control" placeholder="<?= $this->lang->line('nombre'); ?>" name="nombre" value="<?= set_value('nombre'); ?>" required>
                                </div>      
                                <?= form_error('nombre'); ?>
                            </div>
                            <div class="form-group col-md-6 has-feedback <?= form_error('email') != '' ? 'has-error ' : '' ?> required">
                                <label class="control-label"><?= $this->lang->line('email'); ?></label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="ion ion-android-mail"></i>
                                    </div>
                                    <input type="email" class="form-control" placeholder="<?= $this->lang->line('email'); ?>" name="email" value="<?= set_value('email'); ?>" required>
                                </div>
                                <?= form_error('email'); ?>
                            </div>
                            <div class="form-group col-md-6 has-feedback <?= form_error('email_opcional') != '' ? 'has-error ' : '' ?>">
                                <label class="control-label"><?= $this->lang->line('email_opcional'); ?></label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="ion ion-android-mail"></i>
                                    </div>
                                    <input type="email" class="form-control" placeholder="<?= $this->lang->line('email_opcional'); ?>" name="email_opcional" value="<?= set_value('email_opcional'); ?>">
                                </div>
                                <?= form_error('email_opcional'); ?>
                            </div>
                            <div class="form-group col-md-6 has-feedback <?= form_error('pais') != '' ? 'has-error ' : '' ?> required">
                                <label class="control-label"><?= $this->lang->line('pais'); ?></label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-map-marker"></i>
                                    </div>
                                    <div id="pais" class="flagstrap" data-input-name="pais" data-input-name="<?= $this->lang->line('pais'); ?>" data-selected-country="<?= (set_value('pais') != NULL) ? set_value('pais') : 'ES' ?>" required></div>
                                </div>
                                <?= form_error('pais'); ?>
                            </div>
                            <div class="form-group col-md-6 has-feedback <?= form_error('provincia') != '' ? 'has-error ' : '' ?> required">
                                <label class="control-label"><?= $this->lang->line('provincia'); ?></label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <input type="text" class="form-control" placeholder="<?= $this->lang->line('provincia'); ?>" name="provincia" value="<?= set_value('provincia'); ?>" required>
                                    <?= form_error('provincia'); ?>
                                </div>
                            </div>
                            <div class="form-group col-md-6 has-feedback <?= form_error('localidad') != '' ? 'has-error ' : '' ?> required">
                                <label class="control-label"><?= $this->lang->line('localidad'); ?></label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-map-marker"></i>
                                    </div>
                                    <input type="text" class="form-control" placeholder="<?= $this->lang->line('localidad'); ?>" name="localidad" value="<?= set_value('localidad'); ?>" required>
                                    <?= form_error('localidad'); ?>
                                </div>
                            </div>
                            <div class="form-group col-md-6 has-feedback <?= form_error('cp') != '' ? 'has-error ' : '' ?> required">
                                <label class="control-label"><?= $this->lang->line('cp'); ?></label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-map-marker"></i>
                                    </div>
                                    <input type="number" class="form-control" placeholder="<?= $this->lang->line('cp'); ?>" name="cp" value="<?= set_value('cp'); ?>" required>
                                    <?= form_error('cp'); ?>
                                </div>
                            </div>
                            <div class="form-group col-md-6 has-feedback <?= form_error('direccion') != '' ? 'has-error ' : '' ?> required">
                                <label class="control-label"><?= $this->lang->line('direccion'); ?></label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-map-marker"></i>
                                    </div>
                                    <input type="text" class="form-control" placeholder="<?= $this->lang->line('direccion'); ?>" name="direccion" value="<?= set_value('direccion'); ?>" required>
                                    <?= form_error('direccion'); ?>
                                </div>
                            </div>
                            <div class="form-group col-md-6 has-feedback <?= form_error('nif') != '' ? 'has-error ' : '' ?> required">
                                <label class="control-label"><?= $this->lang->line('nif'); ?></label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <input type="text" class="form-control" placeholder="<?= $this->lang->line('nif'); ?>" name="nif" value="<?= set_value('nif'); ?>" required>
                                    <?= form_error('nif'); ?>
                                </div>
                            </div>
                            <div class="form-group col-md-6 has-feedback <?= form_error('contacto') != '' ? 'has-error ' : '' ?>">
                                <label class="control-label"><?= $this->lang->line('contacto'); ?></label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-address-card"></i>
                                    </div>
                                    <input type="text" class="form-control" placeholder="<?= $this->lang->line('contacto'); ?>" name="contacto" value="<?= set_value('contacto'); ?>">
                                </div>     
                                <?= form_error('contacto'); ?>
                            </div>
                            <div class="form-group col-md-6 has-feedback <?= form_error('telefono') != '' ? 'has-error ' : '' ?> required">
                                <label class="control-label"><?= $this->lang->line('telefono'); ?></label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <input type="text" class="form-control" placeholder="<?= $this->lang->line('telefono'); ?>" name="telefono" value="<?= set_value('telefono'); ?>" data-inputmask='"mask": "+34 999-999-999"' data-mask required>
                                </div>
                                <?= form_error('telefono'); ?>
                            </div>
                            <div class="form-group col-md-6 has-feedback <?= form_error('numero_cuenta') != '' ? 'has-error ' : '' ?> required">
                                <label class="control-label" for="input_numero_cuenta"><?= $this->lang->line('numero_cuenta'); ?></label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-address-card"></i>
                                    </div>
                                    <input type="text" class="form-control" placeholder="<?= $this->lang->line('numero_cuenta'); ?>" name="numero_cuenta" value="<?= set_value('numero_cuenta'); ?>" required>
                                </div>
                                <?= form_error('numero_cuenta'); ?>
                            </div>
                            <div class="form-group col-md-12 has-feedback <?= form_error('observaciones') != '' ? 'has-error ' : '' ?>">
                                <label class="control-label"><?= $this->lang->line('observaciones'); ?></label>
                                <textarea type="text" class="form-control" placeholder="<?= $this->lang->line('observaciones') . '...'; ?>" name="observaciones"><?= set_value('observaciones'); ?></textarea>
                                <?= form_error('observaciones'); ?>
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