<div class="content-wrapper">
    <!-- Cabecera -->
    <section class="content-header">
        <h1>
            <?= $this->lang->line('crear_ticket'); ?>
            <small><?= $this->lang->line('ct_descripcion'); ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('cliente'); ?>"><i class="fa fa-home"></i> <?= $this->lang->line('inicio'); ?></a></li>
            <li class="active"></i><?= $this->lang->line('crear_ticket'); ?></li>
        </ol>
    </section>

    <!-- Contenido -->
    <section class="content">

        <?php if(isset($enviado)) {
            echo '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> '. $this->lang->line('ticket_enviado'). '!</h4>
                '. $this->lang->line('ticket_enviado_mensaje'). ' 
              </div>';
        } else if (isset($error)) {
            echo '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> ' . $this->lang->line('ticket_error') . '!</h4>
                ' .$this->lang->line('ticket_error_mensaje')  . '
              </div>';
        }
        ?>

        <div class="box box-solid">

        <form method="POST" action="<?= site_url('cliente/enviar_ticket'); ?>">

            <div class="box-body pad" style="display: block;">
                <div class="form-group">
                    <label><?= $this->lang->line('asunto'); ?></label>
                    <input name= "titulo" type="text" class="form-control" id="titulo" placeholder="<?= $this->lang->line('asunto_descripcion'); ?>" maxlength="100" required>
                </div>
                <div class="form-group">
                    <label><?= $this->lang->line('mensaje'); ?></label>
                    <textarea name= "mensaje" maxlength="500" class= "form-control" style = "width: 1000px" id="mensaje" placeholder="<?= $this->lang->line('mensaje_descripcion'); ?>" required></textarea>
                </div>
                <div class="form-group">
                    <label><?= $this->lang->line('fichero_adjunto'); ?> <small><?= $this->lang->line('aun no funcional'); ?></small></label>
                    <input name = "fichero" type="file" id="archivo">
                </div>
            </div>
            <div class="box-footer">
                <input name="submit" value="<?= $this->lang->line('enviar_ticket'); ?>" type="submit" id="boton" class="btn bg-purple btn-flat btn-lg">
            </div><!-- box-footer -->
        </form>

        </div>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->