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
                                <input type="text" class="form-control" id="input_usuario" placeholder="<?= $this->lang->line('usuario'); ?>" name="usuario" value="<?= set_value('usuario'); ?>" required>
                                <?= form_error('usuario'); ?>
                            </div>
                            <div class="form-group col-md-6 has-feedback <?= form_error('nombre') != '' ? 'has-error ' : '' ?>">
                                <label for="input_nombre"><?= $this->lang->line('nombre'); ?></label>
                                <input type="text" class="form-control" id="input_nombre" placeholder="<?= $this->lang->line('nombre'); ?>" name="usuario" value="<?= set_value('nombre'); ?>" required>
                                <?= form_error('nombre'); ?>
                            </div>
                            <div class="form-group col-md-6 has-feedback <?= form_error('email') != '' ? 'has-error ' : '' ?>">
                                <label for="input_email"><?= $this->lang->line('email'); ?></label>
                                <input type="email" class="form-control" id="input_email" placeholder="<?= $this->lang->line('email'); ?>" name="email" value="<?= set_value('email'); ?>" required>
                                <?= form_error('email'); ?>
                            </div>
                            <div class="form-group col-md-6 has-feedback <?= form_error('email_opcional') != '' ? 'has-error ' : '' ?>">
                                <label for="input_email_opcional"><?= $this->lang->line('email_opcional'); ?></label>
                                <input type="email" class="form-control" id="input_email_opcional" placeholder="<?= $this->lang->line('email_opcional'); ?>" name="email_opcional" value="<?= set_value('email_opcional'); ?>">
                                <?= form_error('email_opcional'); ?>
                            </div>
                            <div class="form-group col-md-6 has-feedback <?= form_error('pais') != '' ? 'has-error ' : '' ?>">
                                <label for="div_pais"><?= $this->lang->line('pais'); ?></label>
                                <div id="div_pais" class="bfh-selectbox bfh-countries" data-country="<?= set_value('pais'); ?>" data-flags="true" name="pais" required>
                                    <input type="hidden" value="">
                                    <a class="bfh-selectbox-toggle" role="button" data-toggle="bfh-selectbox" href="#">
                                        <span class="bfh-selectbox-option input-medium" data-option=""></span>
                                        <b class="caret"></b>
                                    </a>
                                    <div class="bfh-selectbox-options">
                                        <input type="text" class="bfh-selectbox-filter">
                                        <div role="listbox">
                                            <ul role="option">
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <?= form_error('pais'); ?>
                            </div>
                            <div class="form-group col-md-6 has-feedback <?= form_error('provincia') != '' ? 'has-error ' : '' ?>">
                                <label for="input_provincia"><?= $this->lang->line('provincia'); ?></label>
                                <input type="text" class="form-control" id="input_provincia" placeholder="<?= $this->lang->line('provincia'); ?>" name="provincia" value="<?= set_value('provincia'); ?>" required>
                                <?= form_error('provincia'); ?>
                            </div>
                            <div class="form-group col-md-6 has-feedback <?= form_error('localidad') != '' ? 'has-error ' : '' ?>">
                                <label for="input_localidad"><?= $this->lang->line('localidad'); ?></label>
                                <input type="text" class="form-control" id="input_localidad" placeholder="<?= $this->lang->line('localidad'); ?>" name="localidad" value="<?= set_value('localidad'); ?>" required>
                                <?= form_error('localidad'); ?>
                            </div>
                            <div class="form-group col-md-6 has-feedback <?= form_error('cp') != '' ? 'has-error ' : '' ?>">
                                <label for="input_cp"><?= $this->lang->line('cp'); ?></label>
                                <input type="text" class="form-control" id="input_cp" placeholder="<?= $this->lang->line('cp'); ?>" name="cp" value="<?= set_value('cp'); ?>" required>
                                <?= form_error('cp'); ?>
                            </div>
                            <div class="form-group col-md-6 has-feedback <?= form_error('direccion') != '' ? 'has-error ' : '' ?>">
                                <label for="input_direccion"><?= $this->lang->line('direccion'); ?></label>
                                <input type="text" class="form-control" id="input_direccion" placeholder="<?= $this->lang->line('direccion'); ?>" name="direccion" value="<?= set_value('direccion'); ?>" required>
                                <?= form_error('direccion'); ?>
                            </div>
                            <div class="form-group col-md-6 has-feedback <?= form_error('nif') != '' ? 'has-error ' : '' ?>">
                                <label for="input_nif"><?= $this->lang->line('nif'); ?></label>
                                <input type="text" class="form-control" id="input_nif" placeholder="<?= $this->lang->line('nif'); ?>" name="nif" value="<?= set_value('nif'); ?>" required>
                                <?= form_error('nif'); ?>
                            </div>
                            <div class="form-group col-md-6 has-feedback <?= form_error('contacto') != '' ? 'has-error ' : '' ?>">
                                <label for="input_contacto"><?= $this->lang->line('contacto'); ?></label>
                                <input type="text" class="form-control" id="input_contacto" placeholder="<?= $this->lang->line('contacto'); ?>" name="contacto" value="<?= set_value('contacto'); ?>" required>
                                <?= form_error('contacto'); ?>
                            </div>
                            <div class="form-group col-md-6 has-feedback <?= form_error('telefono') != '' ? 'has-error ' : '' ?>">
                                <label for="input_telefono"><?= $this->lang->line('telefono'); ?></label>
                                <input type="text" class="form-control" id="input_telefono" placeholder="<?= $this->lang->line('telefono'); ?>" name="telefono" value="<?= set_value('telefono'); ?>" required>
                                <?= form_error('telefono'); ?>
                            </div>
                            <div class="form-group col-md-6 has-feedback <?= form_error('numero_cuenta') != '' ? 'has-error ' : '' ?>">
                                <label for="input_numero_cuenta"><?= $this->lang->line('numero_cuenta'); ?></label>
                                <input type="text" class="form-control" id="input_numero_cuenta" placeholder="<?= $this->lang->line('numero_cuenta'); ?>" name="numero_cuenta" value="<?= set_value('numero_cuenta'); ?>" required>
                                <?= form_error('numero_cuenta'); ?>
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