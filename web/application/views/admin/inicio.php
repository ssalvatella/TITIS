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
        <div class="row">
            <!-- Cuadro de tickets -->
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>12</h3>
                        <p>Tickets Pendientes</p>
                    </div>
                    <div class="icon">
                        <a style="color: rgba(0,0,0,0.15);" href="<?= site_url('admin/clientes') ?>"><i
                                class="fa fa-ticket"></i></a>
                    </div>
                    <a href="<?= site_url('admin/clientes') ?>" class="small-box-footer">Acceder <i
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
                        <a style="color: rgba(0,0,0,0.15);" href="<?= site_url('admin/clientes') ?>"><i
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
                        <a style="color: rgba(0,0,0,0.15);" href="<?= site_url('admin/clientes') ?>"><i
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
                        <a style="color: rgba(0,0,0,0.15);" href="<?= site_url('admin/clientes') ?>"><i
                                class="fa fa-tasks"></i></a>
                    </div>
                    <a href="#" class="small-box-footer">Acceder <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">

            <!-- TABLA DE TICKETS -->
            <div class="col-lg-6 col-xs-9">

                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Últimos tickets recibidos</h3>

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
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><a href="pages/examples/invoice.html">Pedro</a></td>
                                    <td>Call of Duty IV</td>
                                    <td><span class="label label-success">Shipped</span></td>
                                    <td>
                                        <div class="sparkbar" data-color="#00a65a" data-height="20">
                                            <canvas width="34" height="20"
                                                    style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><a href="pages/examples/invoice.html">José</a></td>
                                    <td>Samsung Smart TV</td>
                                    <td><span class="label label-warning">Pending</span></td>
                                    <td>
                                        <div class="sparkbar" data-color="#f39c12" data-height="20">
                                            <canvas width="34" height="20"
                                                    style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><a href="pages/examples/invoice.html">Luisa</a></td>
                                    <td>iPhone 6 Plus</td>
                                    <td><span class="label label-danger">Delivered</span></td>
                                    <td>
                                        <div class="sparkbar" data-color="#f56954" data-height="20">
                                            <canvas width="34" height="20"
                                                    style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><a href="pages/examples/invoice.html">Javier</a></td>
                                    <td>Samsung Smart TV</td>
                                    <td><span class="label label-info">Processing</span></td>
                                    <td>
                                        <div class="sparkbar" data-color="#00c0ef" data-height="20">
                                            <canvas width="34" height="20"
                                                    style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><a href="pages/examples/invoice.html">Marta</a></td>
                                    <td>Samsung Smart TV</td>
                                    <td><span class="label label-warning">Pending</span></td>
                                    <td>
                                        <div class="sparkbar" data-color="#f39c12" data-height="20">
                                            <canvas width="34" height="20"
                                                    style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><a href="pages/examples/invoice.html">Fernando</a></td>
                                    <td>iPhone 6 Plus</td>
                                    <td><span class="label label-danger">Delivered</span></td>
                                    <td>
                                        <div class="sparkbar" data-color="#f56954" data-height="20">
                                            <canvas width="34" height="20"
                                                    style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><a href="pages/examples/invoice.html">Isabel</a></td>
                                    <td>Call of Duty IV</td>
                                    <td><span class="label label-success">Shipped</span></td>
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
                        <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
                        <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All
                            Orders</a>
                    </div>
                    <!-- /.box-footer -->
                </div>
            </div>
        </div>


    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->