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
        
        <div class="box box-primary" style="width: 80%; margin: 0 auto;">
            <!-- CABECERA TITULO -->
            <div class="box-header with-border">
                <h3 class="box-title"><?= $factura['descripcion'] . ' <small>'. $this->ticket_modelo->obtener_nombreticket_factura($factura['id_factura'])?></small></h3>
                <div class="box-tools pull-right">
                    
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <!-- ETQUETAS CABECERA -->
            <div class="box-body">
                
                <div class="row">
                    <div class="col-lg-3 col-xs-6 col-md-6">
                        <div class="info-box bg-red">
                            <!-- Apply any bg-* class to to the icon to color it -->
                            <span class="info-box-icon"><i class="fa fa-user"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text"><?= $this->lang->line('cliente'); ?></span>
                                <span class="info-box-number"><?= $factura['nombre_cliente'] ?></span>
                            </div><!-- /.info-box-content -->
                        </div><!-- /.info-box -->
                    </div>
                    <div class="col-lg-3 col-xs-6 col-md-6">
                        <div class="info-box bg-green">
                            <!-- Apply any bg-* class to to the icon to color it -->
                            <span class="info-box-icon"><i class="fa fa-ticket"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text"><?= $this->lang->line('ticket'); ?></span>
                                <span class="info-box-number"><?= $this->ticket_modelo->obtener_nombreticket_factura($factura['id_factura']) ?></span>
                            </div><!-- /.info-box-content -->
                        </div><!-- /.info-box -->
                    </div>
                    <div class="col-lg-3 col-xs-6 col-md-6">
                        <div class="info-box bg-aqua">
                            <!-- Apply any bg-* class to to the icon to color it -->
                            <span class="info-box-icon"><i class="fa fa-euro"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text"><?= $this->lang->line('concepto'); ?></span>
                                <span class="info-box-number"><?= $this->concepto->obtener_concepto($factura['id_factura']). ' €' ?></span>
                            </div><!-- /.info-box-content -->
                        </div><!-- /.info-box -->
                    </div>
                    <div class="col-lg-3 col-xs-6 col-md-6">
                        <div class="info-box bg-yellow">
                            <!-- Apply any bg-* class to to the icon to color it -->
                            <span class="info-box-icon"><i class="fa fa-percent"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text"><?= $this->lang->line('iva'); ?></span>
                                <span class="info-box-number"><?= $factura['iva'] ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>