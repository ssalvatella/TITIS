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
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><?= $this->lang->line('enviar_mensaje'); ?></h4>
                </div>
                <form id = "enviar_mensaje_form" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label><?= $this->lang->line('usuario'); ?></label>
                            <select required id = "seleccion_usuarios" class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true">
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
                            <li><a href="#"><i class="fa fa-envelope-o"></i> <?= $this->lang->line('enviados'); ?></a></li>
                        </ul>
                    </div>

                </div>
            </div>

            <div class="col-md-9">
                <div class="box box-primary" style="padding-bottom: 20px" >

                </div>

        </div>

    </section>


</div>