<div class="content-wrapper">
    <!-- Cabecera -->
    <section class="content-header">
        <h1>
            Inicio
            <small>Panel de control</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active"><i class="fa fa-home"></i> Inicio</li>
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
                        <p>Tickets Enviados</p>
                    </div>
                    <div class="icon">
                        <a data-toggle="tooltip" data-placement="top" title="Crear Ticket" style="color: rgba(0,0,0,0.15);" href="<?= site_url('cliente/crear_ticket'); ?>"><i
                                class="fa fa-plus"></i></a>
                    </div>
                    <a href="<?= site_url('cliente/tickets'); ?>" class="small-box-footer">Acceder <i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- Cuadro de clientes -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>44</h3>
                        <p>Tareas Completadas</p>
                    </div>
                    <div class="icon">
                        <a style="color: rgba(0,0,0,0.15);" href="<?= site_url('admin/registrar_cliente'); ?>"><i
                                class="fa fa-tasks"></i></a>
                    </div>
                    <a href="<?= site_url('admin/clientes') ?>" class="small-box-footer">Acceder <i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- Cuadro de facturas -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>65</h3>
                        <p>Facturas Recibidas</p>
                    </div>
                    <div class="icon">
                        <a style="color: rgba(0,0,0,0.15);" href="<?= site_url('admin/clientes'); ?>"><i
                                class="fa fa-money"></i></a>
                    </div>
                    <a href="#" class="small-box-footer">Acceder <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- Cuadro de tareas -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>53</h3>
                        <p>Tickets Finalizados</p>
                    </div>
                    <div class="icon">
                        <a style="color: rgba(0,0,0,0.15);"" href="<?= site_url('admin/clientes'); ?>"><i style="font-size: 80%" class="glyphicon glyphicon-ok"></i></a>
                    </div>
                    <a href="#" class="small-box-footer">Acceder <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">

            <!-- LINE CHART -->
            <section class="col-lg-6 connectedSortable ui-sorteable">
                <div class="box box-info ">
                    <div class="box-header with-border">
                        <h3 class="box-title">Line Chart</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <canvas id="lineChart" style="height: 123px; width: 389px;" height="123" width="389"></canvas>
                        </div>
                    </div>
                    <!-- /.box-body -->
            </div>
            </section>

            <!-- TABLA DE TICKETS -->
            <section class="col-lg-6 connectedSortable ui-sorteable">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Últimos tickets</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-hover no-margin">
                                <thead>
                                <tr>
                                    <th>Título</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Instalar impresoras</td>
                                    <td>19/10/2016 14:20</td>
                                    <td><span class="label label-warning">Pendiente</span></td>
                                    <td>
                                        <div class="sparkbar" data-color="#00a65a" data-height="20">
                                            <canvas width="34" height="20"
                                                    style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Arreglar servidores</td>
                                    <td>17/10/2016 12:20</td>
                                    <td><span class="label label-warning">Pendiente</span></td>
                                    <td>
                                        <div class="sparkbar" data-color="#f39c12" data-height="20">
                                            <canvas width="34" height="20"
                                                    style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Formatear ordenadores</td>
                                    <td>17/10/2016 10:44</td>
                                    <td><span class="label label-info">En proceso</span></td>
                                    <td>
                                        <div class="sparkbar" data-color="#f56954" data-height="20">
                                            <canvas width="34" height="20"
                                                    style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Revisar base de datos MySQL</td>
                                    <td>16/10/2016 17:33</td>
                                    <td><span class="label label-info">En proceso</span></td>
                                    <td>
                                        <div class="sparkbar" data-color="#00c0ef" data-height="20">
                                            <canvas width="34" height="20"
                                                    style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Presupuestar página web</td>
                                    <td>15/10/2016 11:54</td>
                                    <td><span class="label label-success">Completado</span></td>
                                    <td>
                                        <div class="sparkbar" data-color="#f39c12" data-height="20">
                                            <canvas width="34" height="20"
                                                    style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Comprar dominio</td>
                                    <td>14/10/2016 09:42</td>
                                    <td><span class="label label-success">Completado</span></td>
                                    <td>
                                        <div class="sparkbar" data-color="#f56954" data-height="20">
                                            <canvas width="34" height="20"
                                                    style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Añadir servidor</td>
                                    <td>13/10/2016 15:20</td>
                                    <td><span class="label label-success">Completado</span></td>
                                    <td>
                                        <div class="sparkbar" data-color="#00a65a" data-height="20">
                                            <canvas width="34" height="20"
                                                    style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <a href="<?= site_url('admin/tickets') ?>" class="btn btn-sm btn-default btn-flat pull-right">Ver todos</a>
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