<div class="content-wrapper">
    <!-- Cabecera -->
    <section class="content-header">
        <h1>
            Crear Ticket
            <small>Envía un nuevo ticket y nuestro equipo lo resolverá cuanto antes</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('cliente'); ?>"><i class="fa fa-home"></i> Inicio</a></li>
            <li class="active"></i>Crear Ticket</li>
        </ol>
    </section>

    <!-- Contenido -->
    <section class="content">

        <div class="box box-solid">

        <form method="post" action="<?= site_url('cliente/enviar_ticket'); ?>">

            <div class="box-body pad" style="display: block;">
                <div class="form-group">
                    <label>Asunto</label>
                    <input name= "titulo" type="text" class="form-control" id="titulo" placeholder="Introduce un título para el ticket" maxlength="100" required>
                </div>
                <div class="form-group">
                    <label>Mensaje</label>
                    <textarea name= "mensaje" maxlength="500" class= "form-control" style = "width: 1000px" id="mensaje" placeholder="Describe con tus palabras cual es el problema..." required></textarea>
                </div>
                <div class="form-group">
                    <label>Fichero adjunto <small>(aún no funcional)</small></label>
                    <input name = "fichero" type="file" id="archivo">
                </div>
            </div>
            <div class="box-footer">
                <input name="submit" value="Enviar Ticket" type="submit" id="boton" class="btn bg-purple btn-flat btn-lg">
            </div><!-- box-footer -->
        </form>

        </div>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->