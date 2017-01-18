<div class="content-wrapper">
    <!-- Cabecera -->
    <section class="content-header">
        <h1>
            <?= $this->lang->line('cliente'); ?>
            <small><?= $this->lang->line('perfil'); ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('tecnico'); ?>"><i class="fa fa-home"></i><?= $this->lang->line('inicio'); ?></a></li>
            <li><a href="<?= site_url('tecnico/clientes'); ?>"><?= $this->lang->line('clientes'); ?></a></li>
            <li class="active"><?= $cliente['nombre'] ?></li>
        </ol>
    </section>

    <!-- Modal RESPONDER -->
    <div class="modal fade" id="modal_mensaje" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-lg modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><?= $this->lang->line('enviar_mensaje'); ?></h4>
                </div>
                <form enctype="multipart/form-data" id ="enviar_mensaje_form" method="POST" action="<?= site_url('tecnico/enviar_mensaje_privado/' . $this->uri->segment(2) . '/' . $this->uri->segment(3)); ?>" >
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                    <div class="modal-body">
                        <div class="form-group">
                            <label><?= $this->lang->line('usuario'); ?></label>
                            <select readonly="readonly" name="id_receptor" required id = "seleccion_usuarios" class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <?= '<option value="' . $cliente['id_usuario'] . '"> ' . $cliente['nombre'] . '</option>'; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><?= $this->lang->line('mensaje'); ?></label>
                            <textarea name= "mensaje" maxlength="500" class= "form-control summer" style = "width: 100%" id="mensaje" placeholder="<?= $this->lang->line('escribir_mensaje'); ?>" required></textarea>
                        </div>
                        <div class="form-group has-feedback">
                            <label class="control-label">Adjuntar archivo</label>
                            <input id="input_archivo" name="archivo" type="file" class="file file-loading">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?= $this->lang->line('cancelar'); ?></button>
                        <input  type="submit" id="enviar" value = "<?= $this->lang->line('enviar'); ?>" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END Modal RESPONDER ----------->

    <section class="content">

        <div class="row">

            <!-- INFORMACIÓN DEL CLIENTE-->
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="<?= site_url('assets/img/avatar/1.png'); ?>" alt="<?= $this->lang->line('imagen_perfil'); ?>">

                        <h3 class="profile-username text-center"><?= $cliente['nombre']; ?></h3>

                        <p class="text-muted text-center"><?= $cliente['provincia']; ?></p>

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b><?= $this->lang->line('tickets'); ?></b> <a class="pull-right"><?= $numero_tickets; ?></a>
                            </li>
                            <li class="list-group-item">
                                <b><?= $this->lang->line('comentarios'); ?></b> <a class="pull-right"><?= max(($numero_mensajes - $numero_tickets), 0); ?></a>
                            </li>
                            <li class="list-group-item">
                                <b><?= $this->lang->line('registrado'); ?></b> <a class="pull-right"><?= date('d/m/Y H:i', strtotime($cliente['fecha_registro'])); ?></a>
                            </li>
                        </ul>

                        <a href="#" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal_mensaje"><b><?= $this->lang->line('enviar_mensaje'); ?></b></a>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

                <!-- About Me Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= $this->lang->line('datos_personales'); ?></h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <strong><i class="fa fa-at margin-r-5"></i> Email</strong>

                        <p class="text-muted">
                            <?= $cliente['email'] ?>
                        </p>

                        <hr>

                        <strong><i class="fa fa-map-marker margin-r-5"></i>  <?= $this->lang->line('direccion'); ?></strong>

                        <p class="text-muted"><?= $cliente['direccion'] . ', ' . $cliente['localidad'] . ', ' . $cliente['pais'] . ', ' . $cliente['cp']; ?></p>

                        <hr>

                        <strong><i class="fa fa-phone margin-r-5"></i> <?= $this->lang->line('numero_telefono'); ?></strong>

                        <p>
                        <p class="text-muted">
                            <?= '+34 ' . substr($cliente['telefono'], 0, 3) . '-' . substr($cliente['telefono'], 3, 3) . '-' . substr($cliente['telefono'], 6, 3); ?>
                        </p>
                        </p>

                        <hr>

                        <strong><i class="fa fa-file-text-o margin-r-5"></i> <?= $this->lang->line('observaciones'); ?></strong>

                        <p><?= $cliente['observacion']; ?></p>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>

            <!-- FINAL INFORMACIÓN DEL CLIENTE-->

            <!-- PESTAÑAS DE INFORMACIÓN -->
            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="<?= $tab_activa == 'tickets' ? 'active' : '' ?>"><a href="#activity" data-toggle="tab"><?= $this->lang->line('tickets_enviados'); ?></a></li>
                        <li><a href="#timeline" data-toggle="tab">Timeline</a></li>
                        <li class="<?= $tab_activa == 'editar' ? 'active' : '' ?>"><a href="#settings" data-toggle="tab"><?= $this->lang->line('editar'); ?></a></li>                        
                    </ul>
                    <div class="tab-content">
                        <div class="<?= $tab_activa == 'tickets' ? 'active' : '' ?> tab-pane" id="activity">
                            <div class="row">
                                <?php if (sizeof($tickets) == 0) { ?>                                   
                                    <div class="col-sm-12">
                                        <div class="alert alert-success alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            <i class="fa fa-check-circle"></i> <?= $this->lang->line('cliente_no_tiene_tickets') . '.' ?>
                                        </div>
                                    </div>
                                    <?php
                                }
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
                                ?>
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="timeline">
                            <!-- The timeline -->
                            <ul class="timeline timeline-inverse">


                                <?php
                                for ($i = 0; $i < count($tickets); ++$i) {

                                    $fecha_ticket = date('d/m/Y H:i', strtotime($tickets[$i]['inicio']));
                                    if ($i == 0) {
                                        echo '<li class="time-label">
                                    <span class="bg-red">
                                        ' . date('j M. Y', strtotime($tickets[$i]['inicio'])) . '
                                    </span>
                                  </li>';
                                    } else {
                                        $fecha_ticket_anterior = date('d/m/Y H:i', strtotime($tickets[$i - 1]['inicio']));
                                        if (($fecha_ticket - $fecha_ticket_anterior) < 0) {
                                            echo '<li class="time-label">
                                    <span class="bg-red">
                                        ' . date('j M. Y', strtotime($tickets[$i]['inicio'])) . '
                                    </span>
                                  </li>';
                                        }
                                    }

                                    echo '<li style="margin-right: 0px;">
                                <i class="fa fa-ticket bg-blue"></i>   
                                <div class="timeline-item">
                                    <span class="time"><i class="fa fa-clock-o"></i> &nbsp; ' . date('H:i', strtotime($tickets[$i]['inicio'])) . '</span>
                                    <h3 class="timeline-header"><a href="">' . $cliente['nombre'] . '</a> ' . $this->lang->line('cliente_envio_ticket') . '<a href="' . site_url('tecnico/ver_ticket/' . $tickets[$i]['id_ticket']) . '">' . $tickets[$i]['titulo'] . '</a></h3>
                                </div>
                              </li>';
                                }

                                if (count($tickets) > 0) {
                                    $fecha_ultimo_ticket = date('d/m/Y H:i', strtotime($tickets[count($tickets) - 1]['inicio']));
                                    $fecha_registro = date('d/m/Y H:i', strtotime($cliente['fecha_registro']));
                                    if (($fecha_ultimo_ticket - $fecha_registro) > 0) {
                                        echo '<li class="time-label">
                                    <span class="bg-red">
                                        ' . date('j M. Y', strtotime($cliente['fecha_registro'])) . '
                                    </span>
                                  </li>';
                                    }
                                } else {
                                    echo '<li class="time-label">
                                    <span class="bg-red">
                                        ' . date('j M. Y', strtotime($cliente['fecha_registro'])) . '
                                    </span>
                                  </li>';
                                }
                                ?>

                                <li style="margin-right: 0px;">
                                    <i class="fa fa-address-card bg-green"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fa fa-clock-o"></i> <?= date('H:i', strtotime($cliente['fecha_registro'])); ?> </span>
                                        <h3 class="timeline-header"><a href="#"><?= $cliente['nombre'] . '</a> ' . $this->lang->line('cliente_se_registro') ?> </h3>
                                    </div>
                                </li>

                                <li>
                                    <a class="fa fa-repeat bg-gray"  data-toggle="tooltip" data-placement="right" title="<?= $this->lang->line('actualizar'); ?>" href="javascript:history.go(0)"></a>
                                </li>

                            </ul>
                        </div>
                        <!-- /.tab-pane -->

                        <div class="<?= $tab_activa == 'editar' ? 'active' : '' ?> tab-pane" id="settings">
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
                            <form id="form-editar" class="form-horizontal"  action="<?= site_url('tecnico/ver_cliente/' . $id_cliente); ?>" method="POST" role="form" data-parsley-errors-messages-disabled="true">
                                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                                <input type="hidden" name="id_cliente" value="<?= $id_cliente; ?>" />
                                <div class="form-group has-feedback <?= form_error('nombre') != '' ? 'has-error ' : '' ?> required">
                                    <label for="nombre" class="col-sm-2 control-label"><?= $this->lang->line('nombre'); ?></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="<?= $this->lang->line('nombre'); ?>" value="<?= $cliente['nombre']; ?>" required>
                                        <?= form_error('nombre'); ?>
                                    </div>
                                </div>
                                <div class="form-group has-feedback <?= form_error('email_opcional') != '' ? 'has-error ' : '' ?>">
                                    <label for="email_opcional" class="col-sm-2 control-label"><?= $this->lang->line('email_opcional'); ?></label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="email_opcional" name="email_opcional" placeholder="<?= $this->lang->line('email_opcional'); ?>" value="<?= $cliente['email_opcional']; ?>">
                                        <?= form_error('email_opcional'); ?>
                                    </div>
                                </div>
                                <div class="form-group has-feedback <?= form_error('pais') != '' ? 'has-error ' : '' ?> required">
                                    <label for="pais" class="col-sm-2 control-label"><?= $this->lang->line('pais'); ?></label>
                                    <div class="col-sm-10">
                                        <div id="pais" class="flagstrap" data-input-name="pais" data-input-name="<?= $this->lang->line('pais'); ?>" data-selected-country="<?= ($cliente['pais'] != NULL) ? $cliente['pais'] : 'ES' ?>" required></div>
                                        <?= form_error('pais'); ?>
                                    </div>
                                </div>
                                <div class="form-group has-feedback <?= form_error('povincia') != '' ? 'has-error ' : '' ?> required">
                                    <label for="provincia" class="col-sm-2 control-label"><?= $this->lang->line('provincia'); ?></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="provincia" name="provincia" placeholder="<?= $this->lang->line('provincia'); ?>" value="<?= $cliente['provincia']; ?>" required>
                                        <?= form_error('provincia'); ?>
                                    </div>
                                </div>
                                <div class="form-group has-feedback <?= form_error('localidad') != '' ? 'has-error ' : '' ?> required">
                                    <label for="localidad" class="col-sm-2 control-label"><?= $this->lang->line('localidad'); ?></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="localidad" name="localidad" placeholder="<?= $this->lang->line('localidad'); ?>" value="<?= $cliente['localidad']; ?>" required>
                                        <?= form_error('localidad'); ?>
                                    </div>
                                </div>
                                <div class="form-group has-feedback <?= form_error('cp') != '' ? 'has-error ' : '' ?> required">
                                    <label for="cp" class="col-sm-2 control-label"><?= $this->lang->line('cp'); ?></label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="cp" name="cp" placeholder="<?= $this->lang->line('cp'); ?>" value="<?= $cliente['cp']; ?>" required>
                                        <?= form_error('cp'); ?>
                                    </div>
                                </div>
                                <div class="form-group has-feedback <?= form_error('povincia') != '' ? 'has-error ' : '' ?> required">
                                    <label for="direccion" class="col-sm-2 control-label"><?= $this->lang->line('direccion'); ?></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="direccion" name="direccion" placeholder="<?= $this->lang->line('direccion'); ?>" value="<?= $cliente['direccion']; ?>" required>
                                        <?= form_error('direccion'); ?>
                                    </div>
                                </div>
                                <div class="form-group has-feedback <?= form_error('nif') != '' ? 'has-error ' : '' ?> required">
                                    <label for="nif" class="col-sm-2 control-label"><?= $this->lang->line('nif'); ?></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="nif" name="nif" placeholder="<?= $this->lang->line('nif'); ?>" value="<?= $cliente['nif']; ?>" required>
                                        <?= form_error('nif'); ?>
                                    </div>
                                </div>
                                <div class="form-group has-feedback <?= form_error('contacto') != '' ? 'has-error ' : '' ?>">
                                    <label for="contacto" class="col-sm-2 control-label"><?= $this->lang->line('contacto'); ?></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="contacto" name="contacto" placeholder="<?= $this->lang->line('contacto'); ?>" value="<?= $cliente['contacto']; ?>">
                                        <?= form_error('contacto'); ?>
                                    </div>
                                </div>
                                <div class="form-group has-feedback <?= form_error('telefono') != '' ? 'has-error ' : '' ?> required">
                                    <label for="telefono" class="col-sm-2 control-label"><?= $this->lang->line('telefono'); ?></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="telefono" name="telefono" placeholder="<?= $this->lang->line('telefono'); ?>" value="<?= $cliente['telefono']; ?>" data-inputmask='"mask": "+34 999-999-999"' data-mask required>
                                        <?= form_error('telefono'); ?>
                                    </div>
                                </div>
                                <div class="form-group has-feedback <?= form_error('numero_cuenta') != '' ? 'has-error ' : '' ?> required">
                                    <label for="numero_cuenta" class="col-sm-2 control-label"><?= $this->lang->line('numero_cuenta'); ?></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="numero_cuenta" name="numero_cuenta" placeholder="<?= $this->lang->line('numero_cuenta'); ?>" value="<?= $cliente['numero_cuenta']; ?>" required>
                                        <?= form_error('numero_cuenta'); ?>
                                    </div>
                                </div>
                                <div class="form-group has-feedback <?= form_error('observaciones') != '' ? 'has-error ' : '' ?>">
                                    <label for="observaciones" class="col-sm-2 control-label"><?= $this->lang->line('observaciones'); ?></label>
                                    <div class="col-sm-10">
                                        <textarea type="text" class="form-control" id="observaciones" placeholder="<?= $this->lang->line('observaciones') . '...'; ?>" name="observaciones"><?= $cliente['observacion']; ?></textarea>
                                        <?= form_error('observaciones'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-danger"><?= $this->lang->line('actualizar'); ?></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- FIN --- PESTAÑAS DE INFORMACIÓN -->

        </div>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->