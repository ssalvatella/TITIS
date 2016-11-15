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
                        <p>Tickets Pendientes</p>
                    </div>
                    <div class="icon">
                        <a style="color: rgba(0,0,0,0.15);" href="<?= site_url('admin/clientes'); ?>"><i
                                class="fa fa-ticket"></i></a>
                    </div>
                    <a href="<?= site_url('admin/clientes'); ?>" class="small-box-footer">Acceder <i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- Cuadro de clientes -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>44</h3>
                        <p>Clientes Nuevos</p>
                    </div>
                    <div class="icon">
                        <a data-toggle="tooltip" data-placement="top" title="Añadir cliente" style="color: rgba(0,0,0,0.15);" href="<?= site_url('admin/registrar_cliente'); ?>"><i
                                class="ion ion-person-add"></i></a>
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
                        <p>Facturas Pendientes</p>
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
                        <p>Tareas Finalizadas</p>
                    </div>
                    <div class="icon">
                        <a style="color: rgba(0,0,0,0.15);" href="<?= site_url('admin/clientes'); ?>"><i
                                class="fa fa-tasks"></i></a>
                    </div>
                    <a href="#" class="small-box-footer">Acceder <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- DONUT CHART -->
            <section class="col-lg-6 connectedSortable ui-sorteable">
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">Número usuarios</h3>

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
                                                label: "Administradores"
                                            },
                                            {
                                                value: <?= $total_usuarios['tecnico_admin'] ?>,
                                                color: "#00a65a",
                                                highlight: "#00a65a",
                                                label: "Técnicos admin"
                                            },
                                            {
                                                value: <?= $total_usuarios['tecnico'] ?>,
                                                color: "#f39c12",
                                                highlight: "#f39c12",
                                                label: "Técnicos"
                                            },
                                            {
                                                value: <?= $total_usuarios['cliente'] ?>,
                                                color: "#3c8dbc",
                                                highlight: "#3c8dbc",
                                                label: "Clientes"
                                            }
                                        ];
                                    </script>
                                </div>
                                <!-- ./chart-responsive -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-4">
                                <ul class="chart-legend clearfix">
                                    <li><i class="fa fa-circle-o text-red"></i> Administradores</li>
                                    <li><i class="fa fa-circle-o text-green"></i> Técnicos admin</li>
                                    <li><i class="fa fa-circle-o text-yellow"></i> Técnicos</li>
                                    <li><i class="fa fa-circle-o text-light-blue"></i> Clientes</li>
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
                                        <th>Cliente</th>
                                        <th>Título</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><a href="pages/examples/invoice.html">Pedro</a></td>
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
                                        <td><a href="pages/examples/invoice.html">José</a></td>
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
                                        <td><a href="pages/examples/invoice.html">Luisa</a></td>
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
                                        <td><a href="pages/examples/invoice.html">Javier</a></td>
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
                                        <td><a href="pages/examples/invoice.html">Marta</a></td>
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
                                        <td><a href="pages/examples/invoice.html">Fernando</a></td>
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
                                        <td><a href="pages/examples/invoice.html">Isabel</a></td>
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