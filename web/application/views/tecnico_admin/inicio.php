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

            <!-- Cuadro de tareas pendientes -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3><?= sizeof($tickets_pendientes); ?></h3>
                        <text style="font-size: 16px;" ><?= $this->lang->line('tickets_pendientes'); ?></text>
                    </div>
                    <div class="icon">
                        <a data-toggle="tooltip" data-placement="top" title="" style="color: rgba(0,0,0,0.15);" href="">
                            <i class="fa fa-ticket"></i>
                        </a>
                    </div>
                    <a href="<?= site_url('tecnico_admin/tickets'); ?>" class="small-box-footer"><?= $this->lang->line('acceder'); ?>
                        <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>


        </div>
    </section>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->