<div class="content-wrapper">
    <!-- Cabecera -->
    <section class="content-header">
        <h1>
            <?= $this->lang->line('ver_ticket'); ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('cliente'); ?>"><i class="fa fa-home"></i><?= $this->lang->line('inicio'); ?></a></li>
            <li class="active"></i><?= $this->lang->line('ver_ticket'); ?></li>
        </ol>
    </section>
    <!-- Contenido -->
    <section class="content">
        <div class="box box-primary">
            <!-- CABECERA TÍTULO -->
            <div class="box-header with-border">
                <h3 class="box-title"><?= $ticket['titulo'] . ' <small>' . date('d/m/Y H:i', strtotime($ticket['inicio'])) ?> </small></h3>
            </div><!-- /.box-header -->

            <!-- ETIQUETAS CABECERA -->
            <div class="box-body">
                <div class="row">      
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="info-box bg-purple">
                            <span class="info-box-icon"><i class="fa fa-calendar"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text"><?= $this->lang->line('fecha'); ?></span>
                                <span class="info-box-number" style="font-size:17px;"><?= date('d/m/Y H:i', strtotime($ticket['inicio'])); ?></span>
                            </div><!-- /.info-box-content -->
                        </div><!-- /.info-box -->
                    </div>
                    <div class="col-lg-offset-6 col-lg-3 col-md-6 col-sm-6">
                        <div class="info-box <?php
                        switch ($ticket['estado']) {
                            case TICKET_PENDIENTE:
                                echo 'bg-yellow';
                                break;
                            case TICKET_EN_PROCESO:
                                echo 'bg-aqua';
                                break;
                            case TICKET_FINALIZADO:
                                echo 'bg-green';
                                break;
                        }
                        ?>">
                            <span class="info-box-icon"><i class="<?php
                                switch ($ticket['estado']) {
                                    case TICKET_PENDIENTE:
                                        echo 'fa fa-exclamation-triangle';
                                        break;
                                    case TICKET_EN_PROCESO:
                                        echo 'fa fa-exchange';
                                        break;
                                    case TICKET_FINALIZADO:
                                        echo 'glyphicon glyphicon-ok';
                                        break;
                                }
                                ?>"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text"><?= $this->lang->line('estado'); ?></span>
                                <span class="info-box-number" style="font-size:17px;"><?php
                                    switch ($ticket['estado']) {
                                        case TICKET_PENDIENTE:
                                            echo $this->lang->line('pendiente');
                                            break;
                                        case TICKET_EN_PROCESO:
                                            echo $this->lang->line('en_proceso');
                                            break;
                                        case TICKET_FINALIZADO:
                                            echo $this->lang->line('finalizado');
                                            break;
                                    }
                                    ?></span>
                            </div><!-- /.info-box-content -->
                        </div><!-- /.info-box -->
                    </div>
                </div>

            </div><!-- /.box-body -->
            <!-- DESCRIPCIÓN -->
            <div class="box-group" id="accordion">
                <div class="panel box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" class="collapsed">
                                <i class="fa fa-pencil"></i> &nbsp; <?= $this->lang->line('descripcion'); ?>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse" aria-expanded="true" style="height: 0px;">
                        <div id="texto_descripcion" class="box-body">
                            <?= $mensajes[0]['texto']; ?>
                        </div>
                    </div>
                </div>                
            </div>
        </div>

        <!-- INICIO COMENTARIOS -->
        <div class="" style="margin:0 auto; background-color: #ecf0f5; padding-top: 30px">
            <ul class="timeline">
                <?php
                for ($i = 1; $i < count($mensajes); ++$i) {
                    if ($mensajes[$i]['destinatario'] == USUARIO_CLIENTE) {
                        $fecha_mensaje = date('d/m/Y H:i', strtotime($mensajes[$i]['fecha']));
                        $fecha_mensaje_anterior = date('d/m/Y H:i', strtotime($mensajes[$i - 1]['fecha']));

                        if (($fecha_mensaje - $fecha_mensaje_anterior) > 0) {
                            ?>
                            <li class="time-label">
                                <span class="bg-red">
                                    <?= date('j M. Y', strtotime($mensajes[$i]['fecha'])); ?>
                                </span>
                            </li>
                        <?php } ?>

                        <li style="margin-right: 0px;">
                            <i class="fa fa-comments bg-yellow"></i>   
                            <div class="timeline-item">
                                <span class="time"><i class="fa fa-clock-o"></i> &nbsp; <?= date('H:i', strtotime($mensajes[$i]['fecha'])); ?></span>
                                <h3 class="timeline-header">
                                    <a href="#"><?= $mensajes[$i]['nombre_usuario']; ?></a> <?= $this->lang->line('ha_escrito_comentario'); ?>
                                    <?php if (isset($mensajes[$i]['archivos'])) { ?>
                                        <a href="<?= site_url('cliente/descargar_archivo/' . $mensajes[$i]['archivos'][0]['nombre_archivo'] . '/' . $mensajes[$i]['archivos'][0]['nombre_original']); ?>" target="_blank" role="button" class="btn btn-box-tool" style="padding-top: 0px; padding-bottom: 0px;"><i class="fa fa-file" data-toggle="tooltip" data-placement="top" title="<?= $this->lang->line('descargar_adjunto'); ?>"></i></a>
                                    <?php } ?>
                                </h3>
                                <div class="timeline-body">
                                    <div class="mensaje">
                                        <?= $mensajes[$i]['texto']; ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php }
                }
                ?>

                <li style="margin-right: 0px;">
                    <i class="fa fa-commenting bg-aqua"></i>
                    <div class="timeline-item">
                        <div class="timeline-body">
                            <form id="form_enviar_mensaje" enctype="multipart/form-data" method="POST" action="<?= site_url('cliente/enviar_mensaje/') . $ticket['id_ticket']; ?>" data-parsley-errors-messages-disabled="true">
                                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                                <div class="form-group has-feedback">
                                    <textarea name="mensaje" maxlength="500" class="form-control" style="width: 100%" id="mensaje" placeholder="<?= $this->lang->line('añadir_comentario'); ?>" required></textarea>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group has-feedback">
                                        <label class="control-label">Adjuntar archivo</label>
                                        <input id="input_archivo" name="archivo" type="file" class="file file-loading">
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group has-feedback">                                       
                                    </div>
                                </div>
                                <div>
                                    <button style="margin-top: 15px" type="submit" id="boton" class="btn bg-purple btn-flat btn-md"><?= $this->lang->line('enviar'); ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </li>

                <li>
                    <a class="fa fa-repeat bg-gray"  data-toggle="tooltip" data-placement="right" title="<?= $this->lang->line('actualizar'); ?>" href="javascript:history.go(0)"></a>
                </li>

            </ul>
        </div><!-- box-footer -->
        <!-- FIN COMENTARIOS -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->