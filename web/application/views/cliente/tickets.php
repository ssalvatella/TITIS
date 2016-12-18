<div class="content-wrapper">
    <!-- Cabecera -->
    <section class="content-header">
        <h1>
            <?= $this->lang->line('tickets'); ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('cliente'); ?>"><i class="fa fa-home"></i><?= $this->lang->line('inicio'); ?></a></li>
            <li class="active"></i><?= $this->lang->line('tickets'); ?></li>
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
                        <?php if (isset($mensaje)) { ?>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="alert alert-success alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <i class="fa fa-check-circle"></i> <?= $mensaje . '.' ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <a href = "javascript:history.go(0)" class="btn btn-app"><i class="fa fa-spin fa-refresh"></i><?= $this->lang->line('actualizar'); ?></a>
                        <table data-link="" id="tickets" class="table table-bordered table-hover display nowrap">
                            <thead>
                                <tr>
                                    <th><i class="fa fa-list-ol" aria-hidden="true"></i> &nbsp; <?= $this->lang->line('numero'); ?></th>
                                    <th><i class="fa fa-pencil" aria-hidden="true"></i> &nbsp; <?= $this->lang->line('titulo'); ?></th>
                                    <th><i class="fa fa-calendar" aria-hidden="true"></i> &nbsp; <?= $this->lang->line('fecha'); ?> </th>
                                    <th><i class="glyphicon glyphicon-ok" aria-hidden="true"></i>&nbsp; <?= $this->lang->line('estado'); ?></th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                foreach ($tickets as $ticket) {
                                    echo '<tr style="cursor: pointer;">
                                            <td><a  href="' . site_url('cliente/ver_ticket/' . $ticket['id_ticket']) . '"></a>' . $ticket['id_ticket'] . '</td>
                                            <td>' . $ticket['titulo'] . '</td>
                                            <td>' . date('d/m/Y H:i', strtotime($ticket['inicio'])) . '</td>
                                            <td>';
                                    switch ($ticket['estado']) {
                                        case TICKET_PENDIENTE:
                                            echo '<span class="label label-warning">' . $this->lang->line('pendiente') . '</span>';
                                            break;
                                        case TICKET_EN_PROCESO:
                                            echo '<span class="label label-info">' . $this->lang->line('en_proceso') . '</span>';
                                            break;
                                        case TICKET_FINALIZADO:
                                            echo '<span class="label label-success">' . $this->lang->line('finalizado') . '</span>';
                                            break;
                                    }

                                    echo'</td>';
                                }
                                ?>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th><i class="fa fa-list-ol" aria-hidden="true"></i> &nbsp; <?= $this->lang->line('numero'); ?></th>
                                    <th><i class="fa fa-pencil" aria-hidden="true"></i> &nbsp; <?= $this->lang->line('titulo'); ?></th>
                                    <th><i class="fa fa-calendar" aria-hidden="true"></i> &nbsp; <?= $this->lang->line('fecha'); ?> </th>
                                    <th><i class="glyphicon glyphicon-ok" aria-hidden="true"></i>&nbsp; <?= $this->lang->line('estado'); ?></th>
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