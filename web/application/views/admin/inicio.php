<div class="content-wrapper">
    <!-- Cabecera -->
    <section class="content-header">
        <h1>
            <?= $this->lang->line('inicio'); ?>
            <small><?= $this->lang->line('panel de control'); ?></small>
        </h1>
        <ol class="breadcrumb">
            <li class="active"><i class="fa fa-home"></i>  <?= $this->lang->line('inicio'); ?></li>
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
                        <h3><?= $tickets_pendientes ?></h3>
                        <p><?= $this->lang->line('tickets pendientes'); ?></p>
                    </div>
                    <div class="icon">
                        <a style="color: rgba(0,0,0,0.15);" href="<?= site_url('admin/tickets'); ?>"><i
                                class="fa fa-ticket"></i></a>
                    </div>
                    <a href="<?= site_url('admin/clientes'); ?>" class="small-box-footer"><?= $this->lang->line('acceder'); ?> <i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- Cuadro de clientes -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>44</h3>
                        <p><?= $this->lang->line('clientes nuevos'); ?></p>
                    </div>
                    <div class="icon">
                        <a data-toggle="tooltip" data-placement="top" title="<?= $this->lang->line('añadir') . ' ' . $this->lang->line('cliente');?>" style="color: rgba(0,0,0,0.15);" href="<?= site_url('admin/registrar_cliente'); ?>"><i
                                class="ion ion-person-add"></i></a>
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
                        <p><?= $this->lang->line('facturas pendientes'); ?></p>
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
                        <p><?= $this->lang->line('tareas finalizadas'); ?></p>
                    </div>
                    <div class="icon">
                        <a style="color: rgba(0,0,0,0.15);" href="<?= site_url('admin/clientes'); ?>"><i
                                class="fa fa-tasks"></i></a>
                    </div>
                    <a href="#" class="small-box-footer"><?= $this->lang->line('acceder'); ?>  <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- DONUT CHART -->
            <section class="col-lg-6 connectedSortable ui-sorteable">
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= $this->lang->line('numero de usuarios'); ?></h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <!--button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button-->
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="chart-responsive">
                                    <canvas id="numero_clientes" height="250"></canvas>
                                    <!--canvas id="numero_clientes" style="height:250px"></canvas-->
                                    <script>
                                        var PieData = [
                                            {
                                                value: <?= $total_usuarios['admin'] ?>,
                                                color: "#f56954",
                                                highlight: "#f56954",
                                                label: "<?= $this->lang->line('administradores'); ?>"
                                            },
                                            {
                                                value: <?= $total_usuarios['tecnico_admin'] ?>,
                                                color: "#00a65a",
                                                highlight: "#00a65a",
                                                label: "<?= $this->lang->line('tecnicos admin'); ?>"
                                            },
                                            {
                                                value: <?= $total_usuarios['tecnico'] ?>,
                                                color: "#f39c12",
                                                highlight: "#f39c12",
                                                label: "<?= $this->lang->line('tecnicos'); ?>"
                                            },
                                            {
                                                value: <?= $total_usuarios['cliente'] ?>,
                                                color: "#3c8dbc",
                                                highlight: "#3c8dbc",
                                                label: "<?= $this->lang->line('clientes'); ?>"
                                            }
                                        ];
                                    </script>
                                </div>
                                <!-- ./chart-responsive -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-4">
                                <ul class="chart-legend clearfix">
                                    <li><i class="fa fa-circle-o text-red"></i> <?= $this->lang->line('administradores'); ?></li>
                                    <li><i class="fa fa-circle-o text-green"></i> <?= $this->lang->line('tecnicos admin'); ?></li>
                                    <li><i class="fa fa-circle-o text-yellow"></i> <?= $this->lang->line('tecnicos'); ?></li>
                                    <li><i class="fa fa-circle-o text-light-blue"></i> <?= $this->lang->line('clientes'); ?></li>
                                </ul>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </section>

            <!-- TABLA DE TICKETS -->
            <section class="col-lg-6 connectedSortable ui-sorteable">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= $this->lang->line('ultimos tickets'); ?></h3>

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
                                        <th><?= $this->lang->line('cliente'); ?></th>
                                        <th><?= $this->lang->line('titulo'); ?></th>
                                        <th><?= $this->lang->line('fecha'); ?></th>
                                        <th><?= $this->lang->line('estado'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($tickets as $ticket) {
                                        echo '<tr style="cursor: pointer;">
                                                <td><a  href="'.site_url('admin/ver_ticket/'. $ticket['id_ticket']) .'"></a>  <a href="'. site_url('admin/ver_cliente/'). $ticket['cliente']. '">'. $ticket['nombre_cliente']. '</a>'.'</td>
                                                <td> '. $ticket['titulo'] . '</td>
                                                <td>'. date('d/m/Y H:i', strtotime($ticket['inicio'])) . '</td>
                                                 <td> ';
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