<div class="content-wrapper">
    <!-- Cabecera -->
    <section class="content-header">
        <h1>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('admin'); ?>"><i class="fa fa-home"></i><?= $this->lang->line('inicio'); ?></a></li>
        </ol>
    </section>
    <!-- Contenido -->
    <section class="content">

        <div class="box  box-primary" style="width: 80%; margin:0 auto;">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $ticket['titulo'] . ' <small>'. date('d/m/Y H:i', strtotime($ticket['inicio']))?> </small></h3>
                <div class="box-tools pull-right">
<!--                    <span class="label label-primary">Label</span>-->
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">

                <div class="row">
                    <div class="col-lg-3 col-xs-6">
                        <div class="info-box bg-red">
                            <!-- Apply any bg-* class to to the icon to color it -->
                            <span class="info-box-icon"><i class="fa fa-user"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text"><?= $this->lang->line('cliente'); ?></span>
                                <span class="info-box-number"><?= $ticket['cliente'] ?></span>
                            </div><!-- /.info-box-content -->
                        </div><!-- /.info-box -->
                    </div>
                    <div class="col-lg-3 col-xs-6">
                        <div class="info-box bg-green">
                            <!-- Apply any bg-* class to to the icon to color it -->
                            <span class="info-box-icon"><i class="fa fa-wrench"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-number"><?php if(isset($ticket['tecnico_admin'] )) {
                                    echo $ticket['tecnico_admin'];
                                    } else {
                                    }?></span>
                            </div><!-- /.info-box-content -->
                        </div><!-- /.info-box -->
                    </div>
                    <div class="col-lg-3 col-xs-6">
                        <div class="info-box bg-aqua">
                            <!-- Apply any bg-* class to to the icon to color it -->
                            <span class="info-box-icon"><i class="fa fa-calendar"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text"><?= $this->lang->line('fecha'); ?></span>
                                <span class="info-box-number"><?= date('d/m/Y H:i', strtotime($ticket['inicio'])); ?></span>
                            </div><!-- /.info-box-content -->
                        </div><!-- /.info-box -->
                    </div>
                    <div class="col-lg-3 col-xs-6">
                        <div class="info-box <?php switch ($ticket['estado']){

                            case TICKET_PENDIENTE: echo 'bg-yellow'; break;
                            case TICKET_EN_PROCESO: echo 'bg-aqua'; break;
                            case TICKET_FINALIZADO: echo 'bg-green'; break;

                        }?>">
                            <!-- Apply any bg-* class to to the icon to color it -->
                            <span class="info-box-icon"><i class="fa fa-exclamation-triangle"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text"><?= $this->lang->line('estado'); ?></span>
                                <span class="info-box-number"><?php
                                    switch($ticket['estado']) {
                                        case TICKET_PENDIENTE:
                                            echo  $this->lang->line('pendiente');
                                            break;
                                        case TICKET_EN_PROCESO:
                                            break;
                                        case TICKET_FINALIZADO:
                                            echo $this->lang->line('finalizado');
                                            break;
                                    } ?></span>
                            </div><!-- /.info-box-content -->
                        </div><!-- /.info-box -->
                    </div>
                </div>

            </div><!-- /.box-body -->
            <div class="box-footer">
                The footer of the box
            </div><!-- box-footer -->
        </div>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
