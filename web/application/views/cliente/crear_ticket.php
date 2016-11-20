<div class="content-wrapper">
    <!-- Cabecera -->
    <section class="content-header">
        <h1>
            <?= $this->lang->line('crear ticket'); ?>
            <small><?= $this->lang->line('ct descripcion'); ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('cliente'); ?>"><i class="fa fa-home"></i> <?= $this->lang->line('inicio'); ?></a></li>
            <li class="active"></i><?= $this->lang->line('crear ticket'); ?></li>
        </ol>
    </section>

    <!-- Contenido -->
    <section class="content">

        <?php if(isset($enviado)) {
            echo '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Ticket enviado!</h4>
                El ticket ha sido enviado correctamente. Nuestro equipo resolverá el incidente cuanto antes.
              </div>';
        } else if (isset($error)) {
            echo '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Error!</h4>
                Ha ocurrido un error inesperado. Intentaremos resolver esta incidencia cuanto antes.
              </div>';
        }
        ?>

        <div class="box box-solid">

        <form method="post" action="<?= site_url('cliente/enviar_ticket'); ?>">

            <div class="box-body pad" style="display: block;">
                <div class="form-group">
                    <label><?= $this->lang->line('asunto'); ?></label>
                    <input name= "titulo" type="text" class="form-control" id="titulo" placeholder="<?= $this->lang->line('asunto descripcion'); ?>" maxlength="100" required>
                </div>
                <div class="form-group">
                    <label><?= $this->lang->line('mensaje'); ?></label>
                    <textarea name= "mensaje" maxlength="500" class= "form-control" style = "width: 1000px" id="mensaje" placeholder="<?= $this->lang->line('mensaje descripcion'); ?>" required></textarea>
                </div>
                <div class="form-group">
                    <label><?= $this->lang->line('fichero adjunto'); ?> <small><?= $this->lang->line('aun no funcional'); ?></small></label>
                    <input name = "fichero" type="file" id="archivo">
                </div>
            </div>
            <div class="box-footer">
                <input name="submit" value="<?= $this->lang->line('enviar ticket'); ?>" type="submit" id="boton" class="btn bg-purple btn-flat btn-lg">
            </div><!-- box-footer -->
        </form>

        </div>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->