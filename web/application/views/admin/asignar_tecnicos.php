<div class="content-wrapper">
    <!-- Cabecera -->
    <section class="content-header">
        <h1>
            <?= $this->lang->line('asignar_tecnicos'); ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('admin'); ?>"><i class="fa fa-home"></i><?= $this->lang->line('inicio'); ?></a></li>
            <li class="active"></i><?= $this->lang->line('asignar_tecnicos'); ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Asignar técnicos a tecnicos admin</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <?php foreach ($tecnicos_admin as $tecnico_admin) { ?>
                                <form action="<?= site_url('admin/asignar_tecnicos'); ?>" method="POST" role="form" data-parsley-errors-messages-disabled="true">
                                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                                    <input type="hidden" name="tecnico_admin" value="<?= $tecnico_admin['id_usuario']; ?>" />
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label><?= $tecnico_admin['usuario']; ?></label>
                                            <select name="tecnicos[]" class="form-control select2" multiple="multiple" style="width: 100%;">
                                                <?php
                                                $numero_tecnicos = count($tecnicos);
                                                $inicio_optgroup = TRUE;
                                                foreach ($tecnicos as $key => $tecnico) {
                                                    if ($inicio_optgroup) {
                                                        ?>
                                                        <optgroup label="<?= $tecnico['tecnico_admin'] == '' ? 'Técnicos libres' : $tecnico['nombre_tecnico_admin']; ?>">                                                       
                                                            <?php
                                                            $inicio_optgroup = FALSE;
                                                        }
                                                        ?>
                                                        <option value="<?= $tecnico['id_usuario']; ?>" <?= $tecnico['tecnico_admin'] == $tecnico_admin['id_usuario'] ? 'selected' : '' ?>><?= $tecnico['usuario']; ?></option>
                                                        <?php if (($key + 1 > $numero_tecnicos - 1) || ($tecnicos[$key + 1]['tecnico_admin'] != $tecnico['tecnico_admin'])) { ?>
                                                        </optgroup>
                                                        <?php
                                                        $inicio_optgroup = TRUE;
                                                    }
                                                    ?>                                  
                                                <?php } ?>                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-bottom: 30px;">
                                        <button type="submit" class="btn btn-info pull-right"><?= $this->lang->line('asignar'); ?></button>
                                    </div>
                                </form> 
                            <?php } ?>                            
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->