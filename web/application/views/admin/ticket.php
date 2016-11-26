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

        <!-- Modal ASIGNAR TÉCNICO ADMIN -->
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
                                <select required id = "seleccion_tecnicos_admins" class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                    <?php
                                    foreach ($tecnicos_admins as $tecnico_admin) {
                                        echo '<option value="' . $tecnico_admin['id_usuario'] . '"> ' . $tecnico_admin['usuario'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?= $this->lang->line('cancelar'); ?></button>
                            <input  type="submit" id="asignar" value = "<?= $this->lang->line('asignar'); ?>" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- END Modal ASIGNAR TÉCNICO ADMIN ----------->

        <!-- Modal ELIMINAR TICKET -->
        <div class="modal fade" id="modal_eliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-danger" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><?= $this->lang->line('eliminar') . ' ticket '; ?></h4>
                    </div>
                    <form id = "asigna_tecnico_admin_form" method="post" action="<?= site_url('admin/eliminar_ticket/' . $ticket['id_ticket']) ?>">
                        <div class="modal-body">
                            <p><?= $this->lang->line('mensaje_eliminar'); ?></p>
                            <p><?= $this->lang->line('mensaje_eliminar2'); ?></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?= $this->lang->line('cancelar'); ?></button>
                            <input  type="submit" id="eliminar" value = "<?= $this->lang->line('eliminar'); ?>" class="btn btn-danger">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal ELIMINAR TICKET ----------->

        <!-- Modal AÑADIR TAREA -->
        <div class="modal fade" id="modal_tarea" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><?= $this->lang->line('añadir_tarea'); ?></h4>
                    </div>
                    <form id = "crear_tarea_form" method="post">
                        <div class="modal-body">
                            <div class="form-group" >
                                <label><?= $this->lang->line('descripcion_tarea'); ?></label>
                                <input required id="descripcion_tarea" maxlength="200" name="descripcion_tarea" type="text" class="form-control" placeholder="<?= $this->lang->line('descripcion_tarea_place_holder'); ?>">
                            </div>
                            <div class="form-group">
                                <label><?= $this->lang->line('tecnico'); ?></label>
                                <select required id = "seleccion_tecnicos" class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true">
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
                                    <input required type="text" class="form-control pull-right" id="tiempo_tarea">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?= $this->lang->line('cerrar'); ?></button>
                            <input  type="submit" id="añadir_tarea" value = "<?= $this->lang->line('añadir_tarea'); ?>" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- END Modal AÑADIR TAREA ----------->

        <div class="box box-primary">
            <!-- CABECERA TÍTULO ---------------------------->
            <div class="box-header with-border">
                <div class="col-md-6">
                    <h3 class="box-title"><?= $ticket['titulo'] . ' <small>' . date('d/m/Y H:i', strtotime($ticket['inicio'])) ?> </small></h3>
                </div>
                <div class="col-md-6">
                    <div class="box-tools pull-right">
                        <?php
                        if ($this->session->userdata('tipo_usuario') == USUARIO_ADMIN) {
                            echo '<button style="margin-right: 20px" data-toggle="modal" data-target="#modal_asignar" class=" btn bg-yellow btn-flat btn-sm"> <i class="fa fa-wrench"></i> &nbsp;' . $this->lang->line('cambiar') . ' ' . $this->lang->line('tecnico_admin') . ' </button>';
                            echo '<button data-toggle="modal" data-target="#modal_eliminar" class=" btn bg-red btn-flat btn-sm"> <i class="fa fa-trash"></i> &nbsp;' . $this->lang->line('eliminar') . ' </button>';
                            //echo'<button type="button" data-toggle="modal" data-target="#modal_asignar" class="btn btn-box-tool" data-toggle="tooltip" title="' . $this->lang->line('cambiar') . ' ' . $this->lang->line('tecnico_admin') . '"><i class="fa fa-wrench"></i></button>';
                            //echo'<button type="button" data-toggle="modal" data-target="#modal_eliminar" class="btn btn-box-tool" data-toggle="tooltip" title="' . $this->lang->line('eliminar') . '"><i class="fa fa-trash"></i></button>';
                        }
                        ?>
                    </div><!-- /.box-tools -->
                </div>
            </div><!-- /.box-header -->
            <!-- ETIQUETAS CABECERA ------------------------->
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="info-box bg-red">
                            <span class="info-box-icon"><i class="fa fa-user"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text"><?= $this->lang->line('cliente'); ?></span>
                               <span class="info-box-number" style="font-size:17px;"> <a style="color: inherit;" href="<?=site_url('admin/ver_cliente/') . $ticket['id_cliente'] ?>"><?= $ticket['nombre_cliente'] ?></a></span>
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
            <!-- DESCRIPCIÓN Y TAREAS ----------------------->
            <div class="box-group" id="accordion">
                <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                <div class="panel box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" class="collapsed"><i class="fa fa-pencil"></i>&nbsp;
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
                                <i class="ion ion-clipboard"></i> &nbsp; <?= $this->lang->line('tareas'); ?>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse in " aria-expanded="false">
                        <!-- TO DO List -->
                        <div class="box-body">
                            <ul class="todo-list">
                                <?php
                                foreach ($tareas as $tarea) {
                                    echo '<li value="' . $tarea['id_tarea'] . '"';
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
                                            <span class="label label-primary"><i class="fa fa-wrench"></i> &nbsp;' . $tarea['nombre_tecnico'] . '</span>';
                                    echo '
                                            <div class="tools">';
                                    if ($tarea['estado'] == TAREA_FINALIZADA) {
                                        echo '<i style="margin-right: 10px" class="label label-info fecha_fin"><i class="fa fa-calendar"></i> &nbsp;' . $tarea['fin'] . '</i>';
                                    }
                                               echo' <i class="fa fa-edit"></i>
                                                <i data-html="true" data-toggle="tooltip" data-placement="top" title="' . $this->lang->line('eliminar') . '" id = "borrar_tarea" class="fa fa-trash-o boton_borrar"></i>
                                            </div></li>';
                                }
                                ?>
                            </ul>
                        </div>
                        <!-- /.box-header -->

                        <!-- /.box-body -->
                        <div class="box-footer clearfix no-border">
                            <button data-toggle="modal" data-target="#modal_tarea" type="button" class="btn btn-default pull-right"><i class="fa fa-plus"></i> <?= $this->lang->line('añadir_tarea'); ?></button>
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