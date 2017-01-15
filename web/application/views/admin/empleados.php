<div class="content-wrapper">
    <!-- Cabecera -->
    <section class="content-header">
        <h1>
            <?= $this->lang->line('empleados'); ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('admin'); ?>"><i class="fa fa-home"></i> <?= $this->lang->line('inicio'); ?></a></li>
            <li class="active"></i><?= $this->lang->line('empleados'); ?></li>
        </ol>
    </section>

    <!-- Contenido -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">

                    <div id = "cargador" class="overlay">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">
                        <a href = "<?= site_url('admin/registrar_empleado') ?>" class="btn btn-app"><i class="ion ion-person-add"></i><?= $this->lang->line('añadir'); ?></a>
                        <a href = "javascript:history.go(0)" class="btn btn-app"><i class="fa fa-spin fa-refresh"></i><?= $this->lang->line('actualizar'); ?></a>
                        <table data-link="" id="empleados" class="table table-bordered table-hover display nowrap">
                            <thead>
                            <tr>
                                <th><i class="fa fa-user" aria-hidden="true"></i> &nbsp; <?= $this->lang->line('usuario'); ?></th>
                                <th><i class="fa fa-envelope" aria-hidden="true"></i>&nbsp; Email</th>
                                <th><i class="fa fa-calendar" aria-hidden="true"></i> &nbsp; <?= $this->lang->line('registrado'); ?></th>
                                <th><i class="fa fa-black-tie" aria-hidden="true"></i>&nbsp; <?= $this->lang->line('tipo'); ?></th>
                                <td></td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($empleados as $empleado) {
                                echo '<tr style="cursor: pointer;">
                                            <td><a  href="' . site_url('admin/ver_cliente/' . $empleado['id_usuario']) . '"></a>' . $empleado['usuario'] . '</td>
                                            <td>' . $empleado['email'] . '</td>
                                            <td>' .date('d/m/Y H:i', strtotime($empleado['fecha_registro'])) . '</td>
                                            <td>';
                                    switch ($empleado['tipo']) {
                                        case USUARIO_TECNICO:
                                            echo $this->lang->line('tecnico');
                                            break;
                                        case USUARIO_ADMIN:
                                            echo $this->lang->line('admin');
                                            break;
                                        case USUARIO_TECNICO_ADMIN:
                                            echo $this->lang->line('tecnico_admin');
                                            break;
                                    }
                                echo '</td>
                                            <td align="center">';
                                if ($empleado['activo'] == 1) {
                                    echo '<a data-toggle="tooltip" data-placement="top" title="' . $this->lang->line('banear') . '" href ="' . site_url('admin/banear_usuario/' . $empleado['usuario']) . '" class="btn btn-xs btn-danger"><i class="fa fa-user-times"></i></a></td></tr>';
                                } else {
                                    echo '<a data-toggle="tooltip" data-placement="top" title="' . $this->lang->line('activar') . '" href ="' . site_url('admin/activar_usuario/' . $empleado['usuario']) . '"class="btn btn-xs btn-success"><i class="fa fa-user-plus"></i></a></td></tr>';
                                }
                            }
                            ?>

                            </tbody>
                            <tfoot>
                            <tr>
                                <th><i class="fa fa-user" aria-hidden="true"></i> &nbsp; <?= $this->lang->line('usuario'); ?></th>
                                <th><i class="fa fa-envelope" aria-hidden="true"></i>&nbsp; Email</th>
                                <th><i class="fa fa-calendar" aria-hidden="true"></i> &nbsp; <?= $this->lang->line('registrado'); ?></th>
                                <th><i class="fa fa-black-tie" aria-hidden="true"></i>&nbsp; <?= $this->lang->line('tipo'); ?></th>
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