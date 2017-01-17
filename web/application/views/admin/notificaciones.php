<div class="content-wrapper">
    <!-- Cabecera -->
    <section class="content-header">
        <h1>
            <?= $this->lang->line('notificaciones'); ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('admin'); ?>"><i class="fa fa-home"></i><?= $this->lang->line('inicio'); ?></a></li>
            <li class="active"><?= $this->lang->line('notificaciones'); ?></li>
        </ol>
    </section>
    <!-- Contenido -->
    <section class="content">
        <div class="row">
            <!-- INICIO NOTIFICACIONES -->
            <div class="col-lg-offset-2 col-md-offset-1 col-lg-8 col-md-10" style="background-color: #ecf0f5; padding-top: 20px">
                <ul class="timeline">
                    <?php
                    for ($i = 0; $i < count($notificaciones); ++$i) {
                        $fecha_notificacion = date('d/m/Y H:i', strtotime($notificaciones[$i]['fecha']));
                        if ($i == 0) {
                            $fecha_notificacion_anterior = 0;
                        } else {
                            $fecha_notificacion_anterior = date('d/m/Y H:i', strtotime($notificaciones[$i - 1]['fecha']));
                        }
                        if (($fecha_notificacion - $fecha_notificacion_anterior) > 0) {
                            ?>
                            <li class="time-label">
                                <span class="bg-red">
                                    <?= date('j M. Y', strtotime($notificaciones[$i]['fecha'])); ?>
                                </span>
                            </li>
                        <?php } ?>

                        <li style="margin-right: 0px;">
                            <i class="fa fa-bell bg-yellow"></i>   
                            <div class="timeline-item">
                                <span class="time"><a href="#" onClick="borrar_notificacion(this, <?= $notificaciones[$i]['id_notificacion']; ?>)"><i class="remove glyphicon glyphicon-remove-sign glyphicon-white"></i></a></span> <span class="time"><i class="fa fa-clock-o"></i> &nbsp; <?= date('H:i', strtotime($notificaciones[$i]['fecha'])); ?></span>
                                <div class="timeline-body">
                                    <a target="_blank" href="<?= site_url('admin/' . $notificaciones[$i]['url']); ?>" onClick="borrar_notificacion(this, <?= $notificaciones[$i]['id_notificacion']; ?>)"><?= sprintf($this->lang->line($notificaciones[$i]['texto']), '<b>' . $notificaciones[$i]['parametros'] . '</b>'); ?></a>
                                </div>
                            </div>
                        </li>
                    <?php } ?>

                    <li class="actualizar">
                        <a class="fa fa-repeat bg-gray"  data-toggle="tooltip" data-placement="right" title="<?= $this->lang->line('actualizar'); ?>" href="javascript:history.go(0)"></a>
                    </li>

                    <!-- END timeline item -->

                </ul>
            </div><!-- box-footer -->
            <!-- FIN NOTIFICACIONES -->
        </div>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->