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
                    echo $this->lang->line('tiene') . $numero_mensajes_no_vistos . $this->lang->line('mensajes') ;
                }
                ?>
            </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('admin'); ?>"><i class="fa fa-home"></i> <?= $this->lang->line('inicio'); ?></a></li>
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
                <form enctype="multipart/form-data" id = "enviar_mensaje_form" method="post" action="<?= site_url('admin/enviar_mensaje_privado/'. $this->uri->segment(2) . '/' .$this->uri->segment(3)) ; ?>" >
                    <div class="modal-body">
                        <div class="form-group">
                            <label><?= $this->lang->line('usuario'); ?></label>
                            <select name="id_receptor" required id = "seleccion_usuarios" class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <?php
                                foreach ($usuarios as $usuario) {
                                    if ($usuario['id_usuario'] != $this->session->userdata('id_usuario'))
                                        echo '<option value="' . $usuario['id_usuario'] . '"> ' . $usuario['usuario'] . '</option>';
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
                            <li class="active"><a href="<?= site_url('admin/mensajes') ?>"><i class="fa fa-inbox"></i> <?= $this->lang->line('recibidos'); ?>
                                    <span class="label label-primary pull-right"><?php if ($numero_mensajes_no_vistos > 0) echo $numero_mensajes_no_vistos;?></span></a></li>
                        </ul>
                    </div>

                </div>
            </div>

            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= $this->lang->line('leer_mensaje'); ?></h3>

                        <div class="box-tools pull-right">
                            <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="Previous"><i class="fa fa-chevron-left"></i></a>
                            <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="Next"><i class="fa fa-chevron-right"></i></a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <div class="mailbox-read-info">
                            <h5><?= $this->lang->line('desde'); ?>: <?= $mensaje['nombre_emisor'] ?>
                                <span class="mailbox-read-time pull-right"><?= date('d/m/Y H:i', strtotime($mensaje['fecha']))?></span></h5>
                        </div>
                        <!-- /.mailbox-read-info -->
                        <div class="mailbox-controls with-border text-center">
                            <div class="btn-group">
                                <a href="<?= site_url('admin/eliminar_mensaje/' . $mensaje['id_mensaje'])?>" type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="" data-original-title="<?= $this->lang->line('eliminar'); ?>">
                                    <i class="fa fa-trash-o"></i></a>
                                <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Reply">
                                    <i class="fa fa-reply"></i></button>
                                <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Forward">
                                    <i class="fa fa-share"></i></button>
                            </div>
                            <!-- /.btn-group -->
                            <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title="Print">
                                <i class="fa fa-print"></i></button>
                        </div>
                        <!-- /.mailbox-controls -->
                        <div class="mailbox-read-message">
                            <?= $mensaje['texto'] ?>
                        </div>
                        <!-- /.mailbox-read-message -->
                    </div>
                    <!-- /.box-body -->
                        <?php
                        if (count($mensaje['archivos']) != 0) {
                            echo '<div class="box-footer">';
                            echo '  <ul class="mailbox-attachments clearfix">';

                            foreach ($mensaje['archivos'] as $archivo) {
                                echo '<li>';
                                echo '<span class="mailbox-attachment-icon"><i class="';
                                $extension = pathinfo($archivo['nombre_original'], PATHINFO_EXTENSION);
                                switch ($extension) {
                                    case 'pdf':
                                        echo 'fa fa-file-pdf-o';
                                        break;
                                    case 'txt':
                                        echo 'fa fa-file-text-o';
                                        break;
                                    case 'doc':
                                    case 'docx':
                                        echo 'fa fa-word-o';
                                        break;
                                    case 'xls':
                                    case 'xlsx':
                                        echo 'fa fa-excel-o';
                                        break;
                                    case 'zip':
                                    case 'rar':
                                        echo 'fa fa-archive-o';
                                        break;
                                    case 'ppt':
                                    case 'pptm':
                                        echo 'fa fa-powerpoint-o';
                                        break;
                                    case 'png':
                                    case 'jpg':
                                    case 'gif':
                                    case 'jpeg':
                                        echo 'fa fa-image-o';
                                        break;
                                }
                                echo '"></i></span>';
                                echo '<div class="mailbox-attachment-info">
                                     <a href="'. site_url('admin/descargar_archivo/' . $archivo['nombre_archivo'] . '/' . $archivo['nombre_original']) .'" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> ' . $archivo['nombre_original'] . '</a>
                                     <span class="mailbox-attachment-size">
                                         ' . $archivo['tamano'] . ' KB
                                        <a href="'. site_url('admin/descargar_archivo/' . $archivo['nombre_archivo'] . '/' . $archivo['nombre_original']) .'" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                                     </span>
                                  </div>';
                                echo '</li>';
                            }
                            echo '</ul>';
                            echo '</div>';
                        }
                        ?>
                    <!-- /.box-footer -->
                    <div class="box-footer">
                        <div class="pull-right">
                            <button type="button" class="btn btn-default"><i class="fa fa-reply"></i> Reply</button>
                            <button type="button" class="btn btn-default"><i class="fa fa-share"></i> Forward</button>
                        </div>
                        <a href="<?= site_url('admin/eliminar_mensaje/' . $mensaje['id_mensaje'])?>" type="button" class="btn btn-default"><i class="fa fa-trash-o"></i> <?= $this->lang->line('eliminar'); ?></a>
                        <button type="button" class="btn btn-default"><i class="fa fa-print"></i> Print</button>
                    </div>
                    <!-- /.box-footer -->
                </div>

        </div>

    </section>


</div>