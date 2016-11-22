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

        <!-- Modal -->
        <div class="modal fade" id="modal_asignar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><?= $this->lang->line('asignar') . ' ' . $this->lang->line('tecnico_admin'); ?></h4>
                    </div>
                    <form id = "asigna_tecnico_admin_form" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <label><?= $this->lang->line('tecnico_admin'); ?></label>
                                <select id = "seleccion_tecnicos_admins" class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                    <?php
                                    foreach ($tecnicos_admins as $tecnico_admin) {
                                        echo '<option value="' . $tecnico_admin['id_usuario'] . '"> ' . $tecnico_admin['usuario'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?= $this->lang->line('cerrar'); ?></button>
                            <input  type="submit" id="asignar" value = "<?= $this->lang->line('asignar'); ?>" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="box box-primary">
            <!-- CABECERA TÍTULO ---------------------------->
            <div class="box-header with-border">
                <h3 class="box-title"><?= $ticket['titulo'] . ' <small>' . date('d/m/Y H:i', strtotime($ticket['inicio'])) ?> </small></h3>
                <div class="box-tools pull-right">
                    <!--<span class="label label-primary">Label</span>-->
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <!-- ETIQUETAS CABECERA ------------------------->
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="info-box bg-red">
                            <span class="info-box-icon"><i class="fa fa-user"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text"><?= $this->lang->line('cliente'); ?></span>
                                <span class="info-box-number" style="font-size:17px;"><?= $ticket['nombre_cliente'] ?></span>
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
                                <?php
                                if (!isset($ticket['tecnico_admin'])) {
                                    echo '<button data-toggle="modal" data-target="#modal_asignar" style="min-width: 100px" class="col-xs-offset-3 col-xs-6 col-sm-offset-0 btn bg-orange btn-flat btn-sm"> <i class="ionicons ion-person-add"></i> &nbsp;' . $this->lang->line('asignar') . ' </button>';
                                }
                                ?>
                            </div><!-- /.info-box-content -->
                        </div><!-- /.info-box -->
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="info-box bg-aqua">
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
                                        echo 'fa fa-exclamation-exchange';
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
            <!-- DESCRIPCIÓN Y TAREAS ----------------------->
            <div class="box-group" id="accordion">
                <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                <div class="panel box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" class="collapsed">
                                <?= $this->lang->line('descripcion'); ?>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse" aria-expanded="true" style="height: 0px;">
                        <div class="box-body">
                            <?= $mensajes[0]['texto']; ?>
                        </div>
                    </div>
                </div>
                <div class="panel box box-danger">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="" aria-expanded="false">
                                <i class="ion ion-clipboard"></i>  <?= $this->lang->line('tareas'); ?>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse in " aria-expanded="false">
                        <!-- TO DO List -->
                        <div class="box-body">
                            <ul class="todo-list">
                                <?php
                                foreach ($tareas as $tarea) {
                                    echo '<li ';
                                    if ($tarea['estado'] == TAREA_FINALIZADA)
                                        echo 'class="done"';echo '>
                                            <span class="handle">
                                                <i class="fa fa-ellipsis-v"></i>
                                                <i class="fa fa-ellipsis-v"></i>
                                            </span>
                                            <input type="checkbox" ';
                                    if ($tarea['estado'] == TAREA_FINALIZADA)
                                        echo 'checked="true"';
                                    echo ' value="">
                                            <span class="text">' . $tarea['nombre'] . '</span>
                                            <div class="tools">
                                                <i class="fa fa-edit"></i>
                                                <i class="fa fa-trash-o"></i>
                                            </div></li>';
                                }
                                ?>
                            </ul>
                        </div>
                        <!-- /.box-header -->

                        <!-- /.box-body -->
                        <div class="box-footer clearfix no-border">
                            <button type="button" class="btn btn-default pull-right"><i class="fa fa-plus"></i> <?= $this->lang->line('añadir_tarea'); ?></button>
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

                    $fecha_mensaje = date('d/m/Y H:i', strtotime($mensajes[$i]['fecha']));
                    $fecha_mensaje_anterior = date('d/m/Y H:i', strtotime($mensajes[$i - 1]['fecha']));

                    if (($fecha_mensaje - $fecha_mensaje_anterior) > 0) {
                        echo '<li class="time-label">
                                      <span class="bg-red">
                                        ' . date('j M. Y', strtotime($mensajes[$i]['fecha'])) . '
                                      </span>
                                  </li>';
                    }

                    echo '<li style="margin-right: 0px;">
                                <i class="fa fa-comments bg-yellow"></i>   
                                <div class="timeline-item">
                                    <span class="time"><i class="fa fa-clock-o"></i> &nbsp; ' . date('H:i', strtotime($mensajes[$i]['fecha'])) . '</span>
                                    <h3 class="timeline-header"><a href="#">' . $mensajes[$i]['nombre_usuario'] . '</a> ' . $this->lang->line('ha_escrito_comentario') . '</h3>
                                    <div class="timeline-body">
                                        ' . $mensajes[$i]['texto'] . '
                                    </div>
                                </div>
                              </li>';
                }
                ?>

                <li style="margin-right: 0px;">
                    <i class="fa fa-commenting bg-aqua"></i>
                    <div class="timeline-item">
                        <div class="timeline-body">
                            <form method="post" action="<?= site_url('ticket/enviar_mensaje/') . $ticket['id_ticket']; ?>">
                                <div class="form-group">
                                    <textarea name= "mensaje" maxlength="500" class= "form-control" style = "width: 100%" id="mensaje" placeholder="<?= $this->lang->line('añadir_comentario'); ?>" required></textarea>
                                    <input style="margin-top: 15px" name="submit" value="<?= $this->lang->line('enviar'); ?>" type="submit" id="boton" class="btn bg-purple btn-flat btn-md">
                                </div>
                            </form>

                        </div>
                    </div>
                </li>

                <li>
                    <a class="fa fa-repeat bg-gray" title="<?= $this->lang->line('actualizar'); ?>" href="javascript:history.go(0)"></a>
                </li>

                <!-- END timeline item -->

            </ul>
        </div><!-- box-footer -->
        <!-- FIN COMENTARIOS -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->