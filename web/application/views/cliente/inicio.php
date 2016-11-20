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
            <!-- Cuadro de tickets -->
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>12</h3>
                        <p><?= $this->lang->line('tickets_enviados'); ?></p>
                    </div>
                    <div class="icon">
                        <a data-toggle="tooltip" data-placement="top" title="Crear Ticket" style="color: rgba(0,0,0,0.15);" href="<?= site_url('cliente/crear_ticket'); ?>"><i
                                class="fa fa-plus"></i></a>
                    </div>
                    <a href="<?= site_url('cliente/tickets'); ?>" class="small-box-footer"><?= $this->lang->line('acceder'); ?>  <i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- Cuadro de clientes -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>44</h3>
                        <p><?= $this->lang->line('tareas_finalizadas'); ?></p>
                    </div>
                    <div class="icon">
                        <a style="color: rgba(0,0,0,0.15);" href="<?= site_url('admin/registrar_cliente'); ?>"><i
                                class="fa fa-tasks"></i></a>
                    </div>
                    <a href="<?= site_url('admin/clientes') ?>" class="small-box-footer"><?= $this->lang->line('acceder'); ?>  <i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- Cuadro de facturas -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>65</h3>
                        <p><?= $this->lang->line('facturas_recibidas'); ?></p>
                    </div>
                    <div class="icon">
                        <a style="color: rgba(0,0,0,0.15);" href="<?= site_url('admin/clientes'); ?>"><i
                                class="fa fa-money"></i></a>
                    </div>
                    <a href="#" class="small-box-footer"><?= $this->lang->line('acceder'); ?>  <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- Cuadro de tareas -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>53</h3>
                        <p><?= $this->lang->line('tickets_finalizados'); ?></p>
                    </div>
                    <div class="icon">
                        <a style="color: rgba(0,0,0,0.15);"" href="<?= site_url('admin/clientes'); ?>"><i style="font-size: 80%" class="glyphicon glyphicon-ok"></i></a>
                    </div>
                    <a href="#" class="small-box-footer"><?= $this->lang->line('acceder'); ?>  <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">

            <!-- LINE CHART -->
            <section class="col-lg-6 connectedSortable ui-sorteable">
                <div class="box box-danger ">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= $this->lang->line('grafico_de_gastos'); ?></h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <canvas id="lineChart" style="height: 123px; width: 389px;" height="123" width="389"></canvas>
                            <script>
                                var areaChartData = {
                                    labels: ["January", "February", "March", "April", "May", "June", "July"],
                                    datasets: [
                                        {
                                            label: "Factura",
                                            fillColor: "rgba(210, 214, 222, 1)",
                                            strokeColor: "rgba(210, 214, 222, 1)",
                                            pointColor: "rgba(210, 214, 222, 1)",
                                            pointStrokeColor: "#c1c7d1",
                                            pointHighlightFill: "#fff",
                                            pointHighlightStroke: "rgba(220,220,220,1)",
                                            data: [65, 59, 80, 81, 56, 55, 40]
                                        }
                                    ]
                                };
                            </script>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </section>

            <!-- TABLA DE TICKETS -->
            <section class="col-lg-6 connectedSortable ui-sorteable">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= $this->lang->line('ultimos_tickets'); ?></h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="tickets" class="table table-hover no-margin">
                                <thead>
                                <tr>
                                    <th><?= $this->lang->line('titulo'); ?></th>
                                    <th><?= $this->lang->line('fecha'); ?></th>
                                    <th><?= $this->lang->line('estado'); ?></th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                foreach ($tickets as $ticket) {
                                    echo '<tr style="cursor: pointer;">
                                              <td><a  href="'.site_url('cliente/ver_ticket/'. $ticket['id_ticket']) .'"></a>'. $ticket['titulo'] . '</td>
                                              <td>'. date('d/m/Y H:i', strtotime($ticket['inicio'])) . '</td>
                                              <td>';
                                    switch($ticket['estado']) {

                                        case TICKET_PENDIENTE:
                                            echo '<span class="label label-warning">'.  $this->lang->line('pendiente') .'</span>';
                                            break;
                                        case TICKET_EN_PROCESO:
                                            echo '<span class="label label-info">'.  $this->lang->line('en proceso') .'</span>';
                                            break;
                                        case TICKET_FINALIZADO:
                                            echo '<span class="label label-success">'.  $this->lang->line('finalizado') .'</span>';
                                            break;
                                    }

                                    echo'</td>';

                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <a href="<?= site_url('admin/tickets') ?>" class="btn btn-sm btn-default btn-flat pull-right"><?= $this->lang->line('ver todos'); ?></a>
                    </div>
                    <!-- /.box-footer -->
                </div>
            </section>

            <!-- TABLA DE TÉCNICOS -->

        </div>
    </section>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->