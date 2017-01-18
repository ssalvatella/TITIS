<div class="content-wrapper">
    <!-- Cabecera -->
    <section class="content-header">
        <h1>
            <?= $this->lang->line('ver_ticket'); ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('admin'); ?>"><i class="fa fa-home"></i><?= $this->lang->line('inicio'); ?></a></li>
            <li class="active"></i><?= $this->lang->line('ver_ticket'); ?></li>
        </ol>
    </section>
    <!-- Contenido -->
    <section class="content">
        <!-- INICIO Modal AÑADIR TAREA -->
        <div class="modal fade" id="modal_tarea" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><?= $this->lang->line('añadir_tarea'); ?></h4>
                    </div>
                    <form id="crear_tarea_form" method="POST">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                        <div class="modal-body">
                            <div class="form-group" >
                                <label><?= $this->lang->line('descripcion_tarea'); ?></label>
                                <input required id="descripcion_tarea" maxlength="200" name="descripcion_tarea" type="text" class="form-control" placeholder="<?= $this->lang->line('descripcion_tarea_place_holder'); ?>">
                            </div>
                            <div class="form-group">
                                <label><?= $this->lang->line('tecnico'); ?></label>
                                <select required id="seleccion_tecnicos" class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                    <?php
                                    foreach ($tecnicos as $tecnico) {
                                        echo '<option value="' . $tecnico['id_usuario'] . '"> ' . $tecnico['usuario'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label><?= $this->lang->line('tiempo_estimado'); ?></label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                    <input required type="text" class="form-control pull-right tiempo_tarea" id="tiempo_tarea">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?= $this->lang->line('cerrar'); ?></button>
                            <input type="submit" id="añadir_tarea" value="<?= $this->lang->line('añadir_tarea'); ?>" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- FIN Modal AÑADIR TAREA -->

        <!-- INICIO Modal EDITAR TAREA -->
        <div class="modal fade" id="modal_editar_tarea" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><?= $this->lang->line('editar_tarea'); ?></h4>
                    </div>
                    <form id="editar_tarea_form" method="POST">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                        <div class="modal-body">
                            <div class="form-group" >
                                <label><?= $this->lang->line('descripcion_tarea'); ?></label>
                                <input required id="descripcion_tarea_editar" maxlength="200" name="descripcion_tarea" type="text" class="form-control" placeholder="<?= $this->lang->line('descripcion_tarea_place_holder'); ?>">
                            </div>
                            <div class="form-group">
                                <label><?= $this->lang->line('tecnico'); ?></label>
                                <select required id = "seleccion_tecnicos_editar" class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                    <?php
                                    foreach ($tecnicos as $tecnico) {
                                        echo '<option value="' . $tecnico['id_usuario'] . '"> ' . $tecnico['usuario'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label><?= $this->lang->line('tiempo_estimado'); ?></label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                    <input required type="text" class="form-control pull-right tiempo_tarea" id="tiempo_tarea">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?= $this->lang->line('cerrar'); ?></button>
                            <input type="submit" id="editar_tarea" value="<?= $this->lang->line('editar_tarea'); ?>" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- FIN Modal EDITAR TAREA -->

        <div class="box box-primary">
            <!-- CABECERA TÍTULO -->
            <div class="box-header with-border">
                <h3 class="box-title"><?= $ticket['titulo'] . ' <small>' . date('d/m/Y H:i', strtotime($ticket['inicio'])) ?> </small></h3>
            </div><!-- /.box-header -->

            <!-- ETIQUETAS CABECERA -->
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="info-box bg-red">
                            <span class="info-box-icon"><i class="fa fa-user"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text"><?= $this->lang->line('cliente'); ?></span>
                                <span class="info-box-number" style="font-size:17px;"> <a style="color: inherit;" href="<?= site_url('admin/ver_cliente/') . $ticket['id_cliente'] ?>"><?= $ticket['nombre_cliente'] ?></a></span>
                            </div><!-- /.info-box-content -->
                        </div><!-- /.info-box -->
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="info-box bg-green">
                            <span class="info-box-icon"><i class="fa fa-wrench"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text"><?= $this->lang->line('tecnico_admin'); ?></span>
                                <span class="info-box-number" style="font-size:17px;"><?php
                                    if (isset($ticket['tecnico_admin'])) {
                                        echo $ticket['nombre_tecnico_admin'];
                                    } else {
                                        echo $this->lang->line('no_asignado');
                                    }
                                    ?></span>
                            </div><!-- /.info-box-content -->
                        </div><!-- /.info-box -->
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="info-box bg-purple">
                            <span class="info-box-icon"><i class="fa fa-calendar"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text"><?= $this->lang->line('fecha'); ?></span>
                                <span class="info-box-number" style="font-size:17px;"><?= date('d/m/Y H:i', strtotime($ticket['inicio'])); ?></span>
                            </div><!-- /.info-box-content -->
                        </div><!-- /.info-box -->
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
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
            <!-- DESCRIPCIÓN Y TAREAS -->
            <div class="box-group" id="accordion">
                <div class="panel box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" class="collapsed">
                                <i class="fa fa-pencil"></i> &nbsp; <?= $this->lang->line('descripcion'); ?>
                            </a>
                        </h4>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse" aria-expanded="true" style="height: 0px;">
                        <div id="texto_descripcion" class="box-body">
                            <?= $mensajes[0]['texto']; ?>
                        </div>
                    </div>
                </div>
                <div class="panel box box-danger">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false">
                                <i class="ion ion-clipboard"></i> &nbsp; <?= $this->lang->line('tareas'); ?>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse in" aria-expanded="false">
                        <div class="box-body">
                            <ul class="todo-list">
                                <?php foreach ($tareas as $tarea) { ?>
                                    <li value="<?= $tarea['id_tarea']; ?>" class="<?= $tarea['estado'] == TAREA_FINALIZADA ? 'done' : '' ?>">
                                        <span class="handle">
                                            <i class="fa fa-ellipsis-v"></i>
                                            <i class="fa fa-ellipsis-v"></i>
                                        </span>
                                        <input data-toggle="tooltip" data-placement="top" title="<?php
                                        if ($tarea['tecnico'] == $this->session->userdata('id_usuario')) {
                                            echo $this->lang->line('' . $tarea['estado'] == TAREA_FINALIZADA ? 'descompletar_tarea' : 'completar_tarea');
                                        } else {
                                            echo $this->lang->line('' . $tarea['estado'] == TAREA_FINALIZADA ? 'tarea_completada' : 'tarea_no_completada');
                                        }
                                        ?>" type="checkbox"<?= $tarea['estado'] == TAREA_FINALIZADA ? ' checked ' : ' ' ?>onchange="completar_tarea(this)" <?php if ($tarea['tecnico'] != $this->session->userdata('id_usuario')) echo'disabled readonly' ?>>
                                        <span class="text"><?= $tarea['nombre']; ?></span>
                                        <span class="label label-primary"><i class="fa fa-wrench"></i> &nbsp;<?= $tarea['nombre_tecnico']; ?></span>
                                        <div class="tools">
                                            <?php if ($tarea['estado'] == TAREA_FINALIZADA) { ?>
                                                <i style="margin-right: 10px" class="label label-info fecha_fin"><i class="fa fa-calendar"></i> &nbsp;<?= $tarea['fin']; ?></i>
                                            <?php } ?>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <!-- /.box-header -->

                        <!-- /.box-body -->
                        <div class="box-footer clearfix no-border">
                        </div>
                        <!-- /.box -->
                    </div>
                </div>
            </div>
        </div>

        <!-- INICIO COMENTARIOS -->
        <div class="" style="margin:0 auto; background-color: #ecf0f5; padding-top: 30px">
            <ul class="timeline">
                <?php
                for ($i = 1; $i < count($mensajes); ++$i) {
                    if ($mensajes[$i]['destinatario'] < USUARIO_TECNICO) {
                        continue;
                    }
                    $fecha_mensaje = date('d/m/Y H:i', strtotime($mensajes[$i]['fecha']));
                    $fecha_mensaje_anterior = date('d/m/Y H:i', strtotime($mensajes[$i - 1]['fecha']));

                    if (($fecha_mensaje - $fecha_mensaje_anterior) > 0 || $i == 1) {
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
                                <a href="#"><?= $mensajes[$i]['nombre_usuario']; ?></a> <?= $this->lang->line('ha_escrito_comentario'); ?> <?php if ($mensajes[$i]['destinatario'] == USUARIO_CLIENTE) { ?>
                                    <span style="font-size: 70%;" class="label label-primary"><?= $this->lang->line('todos_cliente'); ?></span>
                                <?php } else if ($mensajes[$i]['destinatario'] == USUARIO_TECNICO) { ?>
                                    <span style="font-size: 70%;" class="label label-success"><?= $this->lang->line('tecnicos'); ?></span>
                                <?php } ?>
                                <?php if (isset($mensajes[$i]['archivos'])) { ?>
                                    <a href="<?= site_url('tecnico/descargar_archivo/' . $mensajes[$i]['archivos'][0]['nombre_archivo'] . '/' . $mensajes[$i]['archivos'][0]['nombre_original']); ?>" target="_blank" role="button" class="btn btn-box-tool" style="padding-top: 0px; padding-bottom: 0px;"><i class="fa fa-file" data-toggle="tooltip" data-placement="top" title="<?= $this->lang->line('descargar_adjunto'); ?>"></i></a>
                                <?php } ?>
                            </h3>
                            <div class="timeline-body">
                                <div class="mensaje">
                                    <?= $mensajes[$i]['texto']; ?>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php } ?>

                <li style="margin-right: 0px;">
                    <i class="fa fa-commenting bg-aqua"></i>
                    <div class="timeline-item">
                        <div class="timeline-body">
                            <form id="form_enviar_mensaje" enctype="multipart/form-data" method="POST" action="<?= site_url('tecnico/enviar_mensaje/') . $ticket['id_ticket']; ?>" data-parsley-errors-messages-disabled="true">
                                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                                <div class="form-group has-feedback required">
                                    <label class="control-label"><?= $this->lang->line('comentario'); ?></label>
                                    <textarea name="mensaje" maxlength="500" class="form-control" style="width: 100%" id="mensaje" placeholder="<?= $this->lang->line('añadir_comentario'); ?>" required></textarea>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group has-feedback">
                                        <label class="control-label"><?= $this->lang->line('fichero_adjunto'); ?></label>
                                        <input id="input_archivo" name="archivo" type="file" class="file file-loading">
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group has-feedback required">
                                        <label class="control-label"><?= $this->lang->line('destinatarios'); ?></label>
                                        <div id="radio_destinatario">
                                            <label class="radio-inline"><input type="radio" name="destinatario" class="flat" value="<?= USUARIO_CLIENTE; ?>" required>&nbsp;<?= $this->lang->line('todos_cliente'); ?></label>
                                            <label class="radio-inline"><input type="radio" name="destinatario" class="flat" value="<?= USUARIO_TECNICO; ?>" required>&nbsp;<?= $this->lang->line('tecnicos'); ?></label>
                                        </div>
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