<div class="content-wrapper">
    <!-- Cabecera -->
    <section class="content-header">
        <h1>
            <?= $this->lang->line('inicio'); ?>
            <small><?= $this->lang->line('panel_de_control'); ?></small>
        </h1>
        <ol class="breadcrumb">
            <li class="active"><i class="fa fa-home"></i> <?= $this->lang->line('inicio'); ?></li>
        </ol>
    </section>

    <!-- Contenido -->
    <section class="content">
        <!-- Cuadros resumen -->

        <div class="row">

            <!-- Cuadro de tickets pendientes -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3><?= sizeof($tickets_pendientes); ?></h3>
                        <text style="font-size: 16px;" ><?= $this->lang->line('tickets_pendientes'); ?></text>
                    </div>
                    <div class="icon">
                        <a style="color: rgba(0,0,0,0.15);">
                            <i class="fa fa-ticket"></i>
                        </a>
                    </div>
                    <a href="<?= site_url('tecnico_admin/tickets'); ?>" class="small-box-footer"><?= $this->lang->line('acceder'); ?>
                        <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- Cuadro de técnicos asignados -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?= sizeof($tecnicos); ?></h3>
                        <text style="font-size: 16px;"><?= $this->lang->line('tecnicos_asignados'); ?></text>
                    </div>
                    <div class="icon">
                        <a style="color: rgba(0,0,0,0.15);"><i class="fa fa-users"></i></a>
                    </div>
                    <a href="<?= site_url('tecnico_admin/tecnicos'); ?>" class="small-box-footer"><?= $this->lang->line('acceder'); ?>  <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-6 col-xs-12 connectedSortable">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= $this->lang->line('tickets'); ?></h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <ul class="todo-list">
                            <?php
                            if (sizeof($tickets_pendientes) == 0) {
                                echo '<p>' . $this->lang->line('no_hay_tickets_pendientes') . '</p>';
                            } else {
                                ?>
                                <table data-link="" id="tickets" class="table table-bordered table-hover display nowrap">
                                    <thead>
                                        <tr>
                                            <th><i class="fa fa-pencil" aria-hidden="true"></i> &nbsp; <?= $this->lang->line('titulo'); ?></th>
                                            <th><i class="fa fa-calendar" aria-hidden="true"></i> &nbsp; <?= $this->lang->line('fecha'); ?> </th>
                                            <th><i class="glyphicon glyphicon-ok" aria-hidden="true"></i>&nbsp; <?= $this->lang->line('estado'); ?></th>
                                            <th><i class="glyphicon glyphicon-stats" aria-hidden="true"></i>&nbsp;  <?= $this->lang->line('progreso'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        foreach ($tickets_pendientes as $ticket) {
                                            echo '<tr style="cursor: pointer;">
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

                                            echo'</td>
                                        <td> 
                                            <div class="progress progress-xs" data-html="true" data-toggle="tooltip" data-placement="top" title="' . intval($ticket['progreso']) . ' %<br />' . $this->lang->line('tareas') . ' ' . $ticket['tareas_completadas'] . '/' . $ticket['total_tareas'] . '">
                                              <div class="progress-bar progress-bar-green" style="width: ' . $ticket['progreso'] . '%" role="progressbar" aria-valuenow="' . $ticket['progreso'] . '" aria-valuemin="0" aria-valuemax="100">
                                              </div>
                                            </div>
                                        </td>
                                      </tr>';
                                        }
                                        ?>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th><i class="fa fa-pencil" aria-hidden="true"></i> &nbsp; <?= $this->lang->line('titulo'); ?></th>
                                            <th><i class="fa fa-calendar" aria-hidden="true"></i> &nbsp; <?= $this->lang->line('fecha'); ?> </th>
                                            <th><i class="glyphicon glyphicon-ok" aria-hidden="true"></i>&nbsp; <?= $this->lang->line('estado'); ?></th>
                                            <th><i class="glyphicon glyphicon-stats" aria-hidden="true"></i>&nbsp;  <?= $this->lang->line('progreso'); ?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->