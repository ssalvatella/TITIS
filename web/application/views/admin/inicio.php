<div class="content-wrapper">
    <!-- Cabecera -->
    <section class="content-header">
        <h1>
            Inicio
            <small>Panel de Control</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active"><i class="fa fa-home"></i> Inicio</li>
        </ol>
    </section>

    <!-- Contenido -->
    <section class="content">
        <div class="row" style="margin-top: 125px;">
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>12</h3>
                        <p>Tickets Pendientes</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-ticket"></i>
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
                        <a style="color: rgba(0,0,0,0.15);" href="<?= site_url('admin/clientes') ?>"><i class="ion ion-person-add"></i></a>
                    </div>
                    <a href="<?= site_url('admin/clientes') ?>" class="small-box-footer">Acceder <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>65</h3>
                        <p>Facturas Pendientes</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-money"></i>
                    </div>
                    <a href="#" class="small-box-footer">Acceder <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->