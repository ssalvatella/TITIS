<div class="content-wrapper">
    <!-- Cabecera -->
    <section class="content-header">
        <h1>
            <?= $this->lang->line('mensajes_titulo'); ?>
            <small>
                <?php
                if ($numero_mensajes_no_vistos == 0) {
                    echo $this->lang->line('no_hay_mensajes');
                } else if ($numero_mensajes_no_vistos == 1) {
                    echo $this->lang->line('tiene_1_mensaje');
                } else {
                    echo $this->lang->line('tiene') . $numero_mensajes_no_vistos . $this->lang->line('mensajes');
                }
                ?>
            </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('tecnico_admin'); ?>"><i class="fa fa-home"></i> <?= $this->lang->line('inicio'); ?></a></li>
            <li class="active"></i><?= $this->lang->line('mensajes_titulo'); ?></li>
        </ol>
    </section>

    <!-- Modal ENVIAR -->
    <div class="modal fade" id="modal_enviar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-lg modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><?= $this->lang->line('enviar_mensaje'); ?></h4>
                </div>
                <form enctype="multipart/form-data" id = "enviar_mensaje_form" method="post" action="<?= site_url('tecnico_admin/enviar_mensaje_privado/mensajes'); ?>" >
                    <div class="modal-body">
                        <div class="form-group">
                            <label><?= $this->lang->line('usuario'); ?></label>
                            <select name="id_receptor" required id = "seleccion_usuarios" class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <?php
                                foreach ($usuarios as $usuario) {
                                    if ($usuario['id_usuario'] != $this->session->userdata('id_usuario')) {
                                        echo '<option value="' . $usuario['id_usuario'] . '"> ' . $usuario['usuario'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><?= $this->lang->line('mensaje'); ?></label>
                            <textarea name= "mensaje" maxlength="500" class= "form-control" style = "width: 100%" id="mensaje" placeholder="<?= $this->lang->line('escribir_mensaje'); ?>" required></textarea>
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
    <!-- END Modal ENVIAR ----------->

    <section class="content">

        <div class="row">
            <div class="col-md-3">
                <a href="#" data-toggle="modal" data-target="#modal_enviar" class="btn btn-primary btn-block margin-bottom"><?= $this->lang->line('enviar_mensaje'); ?></a>

                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= $this->lang->line('carpetas'); ?></h3>

                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <ul class="nav nav-pills nav-stacked">
                            <li class="active"><a href="#"><i class="fa fa-inbox"></i> <?= $this->lang->line('recibidos'); ?>
                                    <span class="label label-primary pull-right"><?php if ($numero_mensajes_no_vistos > 0) echo $numero_mensajes_no_vistos; ?></span></a></li>
                        </ul>
                    </div>

                </div>
            </div>

            <div class="col-md-9">
                <div class="box box-primary" style="padding-bottom: 20px" >
                    <div class="box-header ">
                        <h3 class="box-title"><?= $this->lang->line('recibidos'); ?></h3>
                        <!-- /.box-tools -->
                    </div>
                    <div id = "cargador" class="overlay">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding " >
                        <div class="mailbox-controls">
                            <!-- Check all button -->
                            <button data-html="true" data-toggle="tooltip" data-placement="top" title="<?= $this->lang->line('seleccionar_todos'); ?>" type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i>
                            </button>
                            <div class="btn-group">
                                <button id="eliminar" data-html="true" data-toggle="tooltip" data-placement="top" title="<?= $this->lang->line('eliminar_marcados'); ?>" type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
                            </div>
                            <!-- /.btn-group -->
                            <a href = "javascript:history.go(0)" type="button" class="btn btn-default btn-sm" data-html="true" data-toggle="tooltip" data-placement="top" title="<?= $this->lang->line('actualizar'); ?>"><i class="fa fa-refresh"></i></a>
                            <!-- /.pull-right -->
                        </div>
                        <div class=" mailbox-messages" >
                            <table id= "mensajes" class="table table-hover table-striped" >
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($mensajes as $mensaje) {

                                        $fecha_mensaje = new DateTime($mensaje['fecha']);
                                        $fecha_actual = new DateTime("now");
                                        $intervalo_tiempo = date_diff($fecha_mensaje, $fecha_actual);
                                        if ($intervalo_tiempo->d > 0) {
                                            $dias = $this->lang->line('dias');
                                            if ($intervalo_tiempo->d == 1)
                                                $dias = substr($dias, 0, strlen($dias) - 1);
                                            $diferencia = $intervalo_tiempo->format('%a ' . $dias);
                                        } else if ($intervalo_tiempo->h > 0) {
                                            $diferencia = $intervalo_tiempo->format('%h h %i min');
                                        } else {
                                            $diferencia = $intervalo_tiempo->format('%i min');
                                        }

                                        echo '<tr style="cursor: pointer;"value="' . $mensaje['id_mensaje'] . '">';
                                        echo '<td> <a  href="' . site_url('tecnico_admin/ver_mensaje/' . $mensaje['id_mensaje']) . '"></a><input type="checkbox"></td>';
                                        if ($mensaje['visto'] == 0) {
                                            echo '<td><i data-html="true" data-toggle="tooltip" data-placement="top" title="' . $this->lang->line('no_visto') . '" class="fa fa-eye-slash"></i></td>';
                                        } else {
                                            echo '<td><i data-html="true" data-toggle="tooltip" data-placement="top" title="' . $this->lang->line('visto') . '" class="fa fa-eye"></i></td>';
                                        }
                                        echo '<td class="mailbox-name"> <a href="' . site_url('tecnico_admin/ver_usuario/' . $mensaje['emisor']) . '">' . $mensaje['nombre_emisor'] . '</a></td>';
                                        echo '<td class="mailbox-subject">' . strip_tags(substr($mensaje['texto'], 0, 20)) . '...</td>';
                                        if (isset($mensaje['archivo'])) {
                                            echo '<td class="mailbox-attachment"><i class="fa fa-paperclip"></i></td>';
                                        } else {
                                            echo '<td> </td>';
                                        }
                                        echo '<td class="mailbox-date">' . $diferencia . '</td>';
                                        echo '</tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <!-- /.table -->

                        </div>
                        <!-- /.mail-box-messages -->

                    </div>
                    <!-- /.box-body -->

                </div>
                <!-- /. box -->
            </div>

        </div>

    </section>


</div>