<div class="content-wrapper">
    <!-- Cabecera -->
    <section class="content-header">
        <h1>
            <?= $this->lang->line('factura'); ?>
            <small><?= $factura['titulo']; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('admin'); ?>"><i class="fa fa-home"></i><?= $this->lang->line('inicio'); ?></a></li>
            <li class="active"></i><?= $this->lang->line('ver_factura'); ?></li>
        </ol>
    </section>
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> TITIS
            <small class="pull-right"><?= $this->lang->line('fecha'); ?>: 2/10/2014</small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          <?= $this->lang->line('desde'); ?>
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
          <?= $this->lang->line('a'); ?>
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
          <b><?= $this->lang->line('factura'); ?>: <?= $factura['titulo']; ?></b><br>
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
          <p class="lead"><?= $this->lang->line('cantidad_pagar'); ?> 2/22/2014</p>

          <div class="table-responsive">
            <table class="table">
              <tr>
                <th style="width:50%"><?= $this->lang->line('subtotal'); ?>:</th>
                <td><?= $total_tareas; ?> €</td>
              </tr>
              <tr>
                <th><?= $this->lang->line('iva'); ?> (21%)</th>
                <td>$10.34</td>
              </tr>
              <tr>
                <th><?= $this->lang->line('total'); ?>:</th>
                <td>$265.24</td>
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
          <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> <?= $this->lang->line('imprimir'); ?></a>
          <button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> <?= $this->lang->line('confirmar_pago'); ?>
          </button>
          <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
            <i class="fa fa-download"></i> <?= $this->lang->line('generar_pdf'); ?>
          </button>
        </div>
      </div>
    </section>
    <!-- /.content -->
</div>