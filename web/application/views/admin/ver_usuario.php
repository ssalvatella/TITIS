<div class="content-wrapper">
    <!-- Cabecera -->
    <section class="content-header">
        <h1>
            <?= $this->lang->line('perfil'); ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('admin'); ?>"><i class="fa fa-home"></i><?= $this->lang->line('inicio'); ?></a></li>
            <li></i><?= $this->lang->line('empleados'); ?></li>
            <li class="active"></i><?= $usuario['usuario']; ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-3">
                <!-- Imagen Perfil -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="<?= site_url('assets/img/avatar/1.png'); ?>" alt="<?= $this->lang->line('imagen_perfil'); ?>">

                        <h3 class="profile-username text-center"><?= $usuario['usuario']; ?></h3>

                        <p class="text-muted text-center"><?php
                            switch ($usuario['tipo']) {
                                case USUARIO_TECNICO:
                                    echo $this->lang->line('tecnico');
                                    break;
                                case USUARIO_ADMIN:
                                    echo $this->lang->line('admin');
                                    break;
                                case USUARIO_TECNICO_ADMIN:
                                    echo $this->lang->line('tecnico_admin');
                                    break;
                            } ?></p>

                        <ul class="list-group list-group-unbordered">
                            <?php
                            switch ($usuario['tipo']) {
                                case USUARIO_TECNICO:
                                    echo '';
                                    break;
                                case USUARIO_ADMIN:
                                    break;
                                case USUARIO_TECNICO_ADMIN:
                                    echo '<li class="list-group-item">
                                                <b>'.  $this->lang->line('tickets') . '</b> <a class="pull-right">' .  $numero_tickets.  ' </a>
                                          </li>';
                                    break;
                            } ?>
                            <li class="list-group-item">
                                <b><?= $this->lang->line('comentarios'); ?></b> <a class="pull-right"><?= $numero_comentarios   ; ?></a>
                            </li>
                            <li class="list-group-item">
                                <b><?= $this->lang->line('registrado'); ?></b> <a class="pull-right"><?= date('d/m/Y H:i', strtotime($usuario['fecha_registro'])); ?></a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <?php
                        switch ($usuario['tipo']) {
                            case USUARIO_TECNICO:
                                echo '<li class="active"><a href="#tareas" data-toggle="tab">'.  $this->lang->line('tareas_pendientes') . '</a></li>';
                                break;
                            case USUARIO_ADMIN:
                                break;
                            case USUARIO_TECNICO_ADMIN:
                                echo '<li class="active"><a href="#tickets" data-toggle="tab">'.  $this->lang->line('tickets') . '</a></li>';
                                break;
                        } ?>
                        <li><a href="#timeline" data-toggle="tab">Timeline</a></li>
                        <li><a href="#editar" data-toggle="tab"><?= $this->lang->line('editar') ?></a></li>
                    </ul>
                    <div class="tab-content">

                        <div class="active tab-pane" id="tickets">
                            <div class="row">
                                <?php
                                if ($usuario['tipo'] == USUARIO_TECNICO_ADMIN) {
                                    foreach ($tickets as $ticket) {

                                        echo '<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">';
                                        echo '<div class="info-box bg-';
                                        switch ($ticket['estado']) {
                                            case TICKET_FINALIZADO: echo'green';
                                                break;
                                            case TICKET_EN_PROCESO: echo'aqua';
                                                break;
                                            case TICKET_PENDIENTE: echo'yellow';
                                                break;
                                        } echo '">';
                                        echo ' <span class="info-box-icon"><i class="';
                                        switch ($ticket['estado']) {
                                            case TICKET_FINALIZADO: echo'glyphicon glyphicon-ok" data-html="true" data-toggle="tooltip" data-placement="top" title="' . $this->lang->line('finalizado') . '<br  />' . intval($ticket['progreso']) . ' %"';
                                                break;
                                            case TICKET_EN_PROCESO: echo'fa fa-exchange" data-html="true" data-toggle="tooltip" data-placement="top" title="' . $this->lang->line('en_proceso') . '<br  />' . intval($ticket['progreso']) . ' %"';
                                                break;
                                            case TICKET_PENDIENTE: echo'fa fa-exclamation-triangle" data-html="true" data-toggle="tooltip" data-placement="top" title="' . $this->lang->line('pendiente') . '<br  />' . intval($ticket['progreso']) . ' %"';
                                                break;
                                        } echo '></i></span>';

                                        echo '<div class="info-box-content">';
                                        echo '<span class="info-box-text">' . $ticket['titulo'] . '</span>';
                                        echo ' <span class="info-box-number">' . $ticket['tareas_completadas'] . '/' . $ticket['total_tareas'] . ' ' . strtolower($this->lang->line('tareas')) . '</span>';
                                        echo ' <div class="progress">';
                                        echo '<div class="progress-bar" style="width: ' . $ticket['progreso'] . '%"></div>';
                                        echo '</div>';
                                        echo'<span class="progress-description">' . date('d/m/Y H:i', strtotime($ticket['inicio'])) . '</span>';
                                        echo '</div>';
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div class=" tab-pane" id="timeline">

                            <!-- The timeline -->
                            <ul class="timeline timeline-inverse">

                                <?php
                                for ($i = 0; $i < count($comentarios); ++$i) {

                                    $fecha = date('d/m/Y H:i', strtotime($comentarios[$i]['inicio']));
                                    if ($i == 0) {
                                        echo '<li class="time-label">
                                    <span class="bg-red">
                                        ' . date('j M. Y', strtotime($comentarios[$i]['inicio'])) . '
                                    </span>
                                  </li>';
                                    } else {
                                        $fecha_anterior = date('d/m/Y H:i', strtotime($comentarios[$i - 1]['inicio']));
                                        if (($fecha - $fecha_anterior) < 0) {
                                            echo '<li class="time-label">
                                    <span class="bg-red">
                                        ' . date('j M. Y', strtotime($comentarios[$i]['inicio'])) . '
                                    </span>
                                  </li>';
                                        }
                                    }

                                    echo '<li style="margin-right: 0px;">
                                <i class="fa fa-comments bg-orange"></i>   
                                <div class="timeline-item">
                                    <span class="time"><i class="fa fa-clock-o"></i> &nbsp; ' . date('H:i', strtotime($comentarios[$i]['inicio'])) . '</span>
                                    <h3 class="timeline-header"><a href="">' . $usuario['usuario'] . '</a> ' . $this->lang->line('usuario_comento_en_ticket') . '<a href="' . site_url('admin/ver_ticket/' . $comentarios[$i]['id_ticket']) . '">' . $comentarios[$i]['titulo'] . '</a></h3>
                                </div>
                              </li>';
                                }

                                if (count($comentarios) > 0) {
                                    $fecha_ultimo_ticket = date('d/m/Y H:i', strtotime($comentarios[count($comentarios) - 1]['inicio']));
                                    $fecha_registro = date('d/m/Y H:i', strtotime($usuario['fecha_registro']));
                                    if (($fecha_ultimo_ticket - $fecha_registro) > 0) {
                                        echo '<li class="time-label">
                                    <span class="bg-red">
                                        ' . date('j M. Y', strtotime($usuario['fecha_registro'])) . '
                                    </span>
                                  </li>';
                                    }
                                } else {
                                    echo '<li class="time-label">
                                    <span class="bg-red">
                                        ' . date('j M. Y', strtotime($usuario['fecha_registro'])) . '
                                    </span>
                                  </li>';
                                }
                                ?>

                                <li style="margin-right: 0px;">
                                    <i class="fa fa-address-card bg-green"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fa fa-clock-o"></i> <?= date('H:i', strtotime($usuario['fecha_registro'])); ?> </span>
                                        <h3 class="timeline-header"><a href="#"><?= $usuario['usuario'] . '</a> ' . $this->lang->line('cliente_se_registro') ?> </h3>
                                    </div>
                                </li>

                                <li>
                                    <a class="fa fa-repeat bg-gray"  data-toggle="tooltip" data-placement="right" title="<?= $this->lang->line('actualizar'); ?>" href="javascript:history.go(0)"></a>
                                </li>

                            </ul>

                        </div>
                        <!-- /.tab-pane -->

                        <?php

                            if ($usuario['tipo'] == USUARIO_TECNICO) {
                                echo '<div class="active tab-pane" id="tareas">';
                                    echo '<div class="row">';
                                        echo '<div class="box-body">';
                                        echo ' <ul class="todo-list">';
                                        foreach ($tareas as $tarea) { ?>
                                            <li ticket="<?= $tarea['ticket']; ?>" value="<?= $tarea['id_tarea']; ?>" class="<?= $tarea['estado'] == TAREA_FINALIZADA ? 'done' : '' ?>">
                                                        <span class="handle">
                                                            <i class="fa fa-ellipsis-v"></i>
                                                            <i class="fa fa-ellipsis-v"></i>
                                                        </span>
                                                <input readonly="readonly" data-toggle="tooltip" data-placement="top" title="<?= $this->lang->line('completar_tarea'); ?>" type="checkbox"<?= $tarea['estado'] == TAREA_FINALIZADA ? ' checked ' : ' ' ?>>
                                                <span class="text"><?= $tarea['nombre']; ?></span>
                                                <span class="label label-primary"><i class="fa fa-wrench"></i> &nbsp;<?= $tarea['nombre_tecnico']; ?></span>
                                                <div class="tools">
                                                    <?php if ($tarea['estado'] == TAREA_FINALIZADA) { ?>
                                                        <i style="margin-right: 10px" class="label label-info fecha_fin"><i class="fa fa-calendar"></i> &nbsp;<?= $tarea['fin']; ?></i>
                                                    <?php } ?>
                                                </div>
                                            </li>
                                        <?php }
                                     echo ' </ul> ';
                                    echo '</div>';
                                    echo '</div>';
                                echo '</div>';
                            }


                        ?>

                        <div class="tab-pane" id="editar">
                            <div class="row">
                            <form id="form-registro-empleado" action="<?= site_url('admin/editar_empleado/' . $usuario['id_usuario']); ?>" method="POST" role="form" data-parsley-errors-messages-disabled="true">
                                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                                <?php if (isset($mensaje_error)) { ?>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="alert alert-warning alert-dismissable">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                <i class="fa fa-exclamation-circle"></i> <?= $mensaje_error . '.' ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } else if (isset($mensaje)) { ?>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="alert alert-success alert-dismissable">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                <i class="fa fa-check-circle"></i> <?= $mensaje . '.' ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="form-group col-md-6 has-feedback <?= form_error('usuario') != '' ? 'has-error ' : '' ?> required">
                                    <label class="control-label" for="input_usuario"><?= $this->lang->line('usuario'); ?></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <input type="text" class="form-control" id="input_usuario" placeholder="<?= $this->lang->line('usuario'); ?>" name="usuario" value="<?= $usuario['usuario']; ?>" required>
                                    </div>
                                    <?= form_error('usuario'); ?>
                                </div>
                                <div class="form-group col-md-6 has-feedback <?= form_error('email') != '' ? 'has-error ' : '' ?> required">
                                    <label class="control-label" for="input_email"><?= $this->lang->line('email'); ?></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="ion ion-android-mail"></i>
                                        </div>
                                        <input type="email" class="form-control" id="input_email" placeholder="<?= $this->lang->line('email'); ?>" name="email" value="<?= $usuario['email']; ?>" required>
                                    </div>
                                    <?= form_error('email'); ?>
                                </div>
                                <!-- /.box-body -->
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-info pull-right"><?= $this->lang->line('guardar'); ?></button>
                                </div>

                            <!-- /.box-footer -->
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                        </div>
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->