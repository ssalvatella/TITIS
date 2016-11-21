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
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= $this->lang->line('registrar'); ?></h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="form-group col-md-6">
                            <label for="input_usuario"><?= $this->lang->line('usuario'); ?></label>
                            <input type="text" class="form-control" id="input_usuario" placeholder="<?= $this->lang->line('usuario'); ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1"><?= $this->lang->line('email'); ?></label>
                            <input type="email" class="form-control" id="input_email" placeholder="<?= $this->lang->line('email'); ?>">
                        </div>
                        <div class="form-group col-md-6" id="radio_tipo">
                            <label for="radio_tipo">Tipo empleado</label>
                            <div id="radio_tipo">
                                <text><input type="radio" name="tipo_empleado" class="flat"> <?= $this->lang->line('admin'); ?></text>&nbsp;&nbsp;
                                <text><input type="radio" name="tipo_empleado" class="flat"> <?= $this->lang->line('tecnico_admin'); ?></text>&nbsp;&nbsp;
                                <text><input type="radio" name="tipo_empleado" class="flat" checked> <?= $this->lang->line('tecnico'); ?></text>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-info pull-right"><?= $this->lang->line('registrar'); ?></button>
                    </div>
                    <!-- /.box-footer -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->