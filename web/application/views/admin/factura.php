<div class="content-wrapper">
    <!-- Cabecera -->
    <section class="content-header">
        <h1>
            <?= $this->lang->line('factura'); ?>
            <small><?= $factura['descripcion']; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('admin'); ?>"><i class="fa fa-home"></i><?= $this->lang->line('inicio'); ?></a></li>
            <li class="active"></i><?= $this->lang->line('ver_factura'); ?></li>
        </ol>
    </section>
    <section class="invoice">
        
        <!-- INICIO Modal ELIMINAR FACTURA -->
        <div class="modal fade" id="modal_eliminar_factura" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-danger" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><?= $this->lang->line('eliminar_factura'); ?></h4>
                    </div>
                    <form id="eliminar_factura_form" method="POST" action="<?= site_url('admin/borrar_factura'); ?>">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                        <div class="modal-body">
                            <p><?= $this->lang->line('mensaje_eliminar_factura'); ?></p>
                            <p><?= $this->lang->line('mensaje_eliminar_factura2'); ?></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?= $this->lang->line('cancelar'); ?></button>
                            <button type="submit" id="eliminar_factura" name="id_factura" value="<?= $factura['id_factura']; ?>" class="btn btn-danger"><?= $this->lang->line('eliminar'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- FIN Modal ELIMINAR FACTURA -->
        
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-globe"></i> <?= NOMBRE_WEB ?>
                    <small class="pull-right"><?= $this->lang->line('fecha') . ': ' . date('d/m/Y', strtotime($factura['fecha'])); ?></small>
                </h2>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                <?= $this->lang->line('desde') . ':'; ?>
                <address>
                    <strong>TITIS</strong><br>
                    EUPT, Universidad de Zaragoza<br>
                    Teruel, SPA 44003<br>
                    <?= $this->lang->line('telefono'); ?>: (978) 60 00 00<br>
                    <?= $this->lang->line('email'); ?>: titis@titis.com
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <?= $this->lang->line('a') . ':'; ?>
                <address>
                    <strong><?= $factura['nombre_cliente']; ?></strong><br>
                    <?= $factura['direccion_cliente']; ?><br>
                    <?= $factura['localidad_cliente']; ?>, <?= $factura['pais_cliente']; ?> <?= $factura['cp_cliente']; ?><br>
                    <?= $this->lang->line('telefono'); ?>: <?= $factura['telefono_cliente']; ?><br>
                    <?= $this->lang->line('email'); ?>: <?= $factura['email_cliente']; ?>
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <b><?= $this->lang->line('factura'); ?>: <?= $factura['descripcion']; ?></b><br>
                <br>
                <b><?= $this->lang->line('factura_id'); ?>:</b> <?= $factura['id_factura']; ?><br>
                <b><?= $this->lang->line('factura_fecha'); ?>:</b> <?= $factura['fecha']; ?><br>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Table row -->
        <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><?= $this->lang->line('tarea'); ?></th>
                            <th><?= $this->lang->line('descripcion'); ?></th>
                            <th><?= $this->lang->line('precio'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($tareas as $tarea) {
                            echo '<tr>
                            <td>' . $tarea['id_tarea'] . '</td>
                            <td>' . $tarea['nombre'] . '</td>
                            <td>' . $tarea['precio'] . ' €</td>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <!-- accepted payments column -->
            <div class="col-xs-6">
                <p class="lead"><?= $this->lang->line('metodos_pago'); ?>:</p>
                <img src="<?= site_url('assets/img/pago/visa.png'); ?>" alt="Visa">
                <img src="<?= site_url('assets/img/pago/mastercard.png'); ?>" alt="Mastercard">
                <img src="<?= site_url('assets/img/pago/american-express.png'); ?>" alt="American Express">
                <img src="<?= site_url('assets/img/pago/paypal2.png'); ?>" alt="Paypal">


            </div>
            <!-- /.col -->
            <div class="col-xs-6">
                <p class="lead"><?= $this->lang->line('cantidad_pagar') . ' - ' . date('d/m/Y', strtotime($factura['fecha'])) ; ?></p>

                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th style="width:50%"><?= $this->lang->line('subtotal'); ?>:</th>
                            <td><?= $total ?> €</td>
                        </tr>
                        <tr>
                            <th><?= $this->lang->line('iva'); ?> (21%)</th>
                            <td><?= $total* $factura['iva']; ?> €</td>
                        </tr>
                        <tr>
                            <th><?= $this->lang->line('total'); ?>:</th>
                            <td><?= $total + $total * $factura['iva']; ?> €</td>
                        </tr>
                    </table>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- this row will not appear when printing -->
        <div class="row no-print">
            <div class="col-xs-12">
                <button type="button" data-toggle="modal" data-target="#modal_eliminar_factura" class="btn btn-danger"><i class="fa fa-remove"></i> <?= $this->lang->line('eliminar_factura'); ?>
                </button>
                <button type="button" class="btn btn-default pull-right"><i class="fa fa-edit"></i> <?= $this->lang->line('editar_factura'); ?>
                </button>
                <a href="<?= site_url('admin/imprimir_factura/' . $factura['id_factura']) ?>" target="_blank" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> <?= $this->lang->line('generar_pdf'); ?></a>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>