<div class="content-wrapper">
    <!-- Cabecera -->
    <section class="content-header">
        <h1>
            <?= $this->lang->line('tickets'); ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('tecnico_admin'); ?>"><i class="fa fa-home"></i><?= $this->lang->line('inicio'); ?></a></li>
            <li class="active"></i><?= $this->lang->line('tecnicos'); ?></li>
        </ol>
    </section>

    <!-- Contenido -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <!-- /.box-header -->
                    <div class="box-body">                      
                        <a href = "javascript:history.go(0)" class="btn btn-app"><i class="fa fa-spin fa-refresh"></i><?= $this->lang->line('actualizar'); ?></a>
                        <table data-link="" id="tickets" class="table table-bordered table-hover display nowrap">
                            <thead>
                                <tr>
                                    <th><i class="fa fa-user" aria-hidden="true"></i> &nbsp; <?= $this->lang->line('tecnico'); ?></th>
                                    <th><i class="fa fa-envelope" aria-hidden="true"></i>&nbsp; Email</th>
                                    <th><i class="fa fa-calendar" aria-hidden="true"></i> &nbsp; <?= $this->lang->line('registrado'); ?></th>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($tecnicos as $tecnico) {
                                    echo '<tr>
                                            <td><a  href="' . site_url('tecnico_admin/ver_usuario/' . $tecnico['id_usuario']) . '"></a>' . $tecnico['usuario'] . '</td>
                                            <td>' . $tecnico['email'] . '</td>
                                            <td>' . date('d/m/Y H:i', strtotime($tecnico['fecha_registro'])) . '</td>
                                         </tr>';
                                }
                                ?>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th><i class="fa fa-user" aria-hidden="true"></i> &nbsp; <?= $this->lang->line('tecnico'); ?></th>
                                    <th><i class="fa fa-envelope" aria-hidden="true"></i>&nbsp; Email</th>
                                    <th><i class="fa fa-calendar" aria-hidden="true"></i> &nbsp; <?= $this->lang->line('registrado'); ?></th>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->