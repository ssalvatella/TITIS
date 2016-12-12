<div class="content-wrapper">
    <!-- Cabecera -->
    <section class="content-header">
        <h1>
            <?= $this->lang->line('ver_factura'); ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('admin'); ?>"><i class="fa fa-home"></i><?= $this->lang->line('inicio'); ?></a></li>
            <li class="active"></i><?= $this->lang->line('ver_factura'); ?></li>
        </ol>
    </section>
    <!-- Contenido --> 
    <section class="content">

        <div class="box box-primary">
            <!-- CABECERA TITULO -->
            <div class="box-header with-border">
                <h3 class="box-title"><?= $factura['descripcion'] . ' <small>' . $factura['titulo'] ?></small></h3>
                <div class="box-tools pull-right">

                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <!-- ETIQUETAS CABECERA -->
            <div class="box-body">

                <div class="row">
                    <div class="col-lg-3 col-xs-6 col-md-6">
                        <div class="info-box bg-red">
                            <span class="info-box-icon"><i class="fa fa-user"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text"><?= $this->lang->line('cliente'); ?></span>
                                <span class="info-box-number"><?= $factura['nombre_cliente'] ?></span>
                            </div><!-- /.info-box-content -->
                        </div><!-- /.info-box -->
                    </div>
                    <div class="col-lg-3 col-xs-6 col-md-6">
                        <div class="info-box bg-green">
                            <span class="info-box-icon"><i class="fa fa-ticket"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text"><?= $this->lang->line('ticket'); ?></span>
                                <span class="info-box-number"><?= $factura['titulo'] ?></span>
                            </div><!-- /.info-box-content -->
                        </div><!-- /.info-box -->
                    </div>
                    <div class="col-lg-3 col-xs-6 col-md-6">
                        <div class="info-box bg-aqua">
                            <span class="info-box-icon"><i class="fa fa-euro"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text"><?= $this->lang->line('concepto'); ?></span>
                                <span class="info-box-number"><?= $concepto['precio'] . ' €' ?></span>
                            </div><!-- /.info-box-content -->
                        </div><!-- /.info-box -->
                    </div>
                    <div class="col-lg-3 col-xs-6 col-md-6">
                        <div class="info-box bg-yellow">
                            <span class="info-box-icon"><i class="fa fa-percent"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text"><?= $this->lang->line('iva'); ?></span>
                                <span class="info-box-number"><?= $factura['iva'] ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- CLIENTE Y DETALLES TICKET -->
            <div class="box-group" id="accordion">
                <div class="panel box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" class="collapsed">
                                <i class="fa fa-user"></i> &nbsp; <?= $this->lang->line('cliente'); ?>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse" aria-expanded="true" style="height: 0px;">
                        <div id="info_cliente" class="box-body">
                            <?= $factura['nombre_cliente']; ?>
                        </div>
                    </div>
                </div>
                <div class="panel box box-danger">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false">
                                <i class="ion ion-clipboard"></i> &nbsp; <?= $this->lang->line('desglose'); ?>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse in" aria-expanded="false">
                        <div class="box-header">
                            <h3 class="box-title">
                                <?= $factura['titulo']; ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>