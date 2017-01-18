<div class="content-wrapper">
    <!-- Cabecera -->
    <section class="content-header">
        <h1>
            <?= $this->lang->line('facturas'); ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('admin'); ?>"><i class="fa fa-home"></i><?= $this->lang->line('inicio'); ?></a></li>
            <li class="active"></i><?= $this->lang->line('facturas'); ?></li>
        </ol>
    </section>

    <!-- Contenido -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">

                    <!-- <div id = "cargador" class="overlay">
                         <i class="fa fa-refresh fa-spin"></i>
                     </div> -->
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-3 col-xs-6">
                                <div class="description-block border-right">
                                    <a href="javascript:history.go(0)" class="btn btn-app"><i class="fa fa-spin fa-refresh"></i><?= $this->lang->line('actualizar'); ?></a>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 col-xs-6">
                                <div class="description-block border-right">
                                    <span data-toggle="tooltip" title="<?= date("Y",strtotime("-1 year")) .': ' . number_format($facturacion_mensual_pasada, 2, ',', ' ') . ' €'?>" data-placement="top" class="description-percentage
                                    <?php
                                        if ($facturacion_mensual > $facturacion_mensual_pasada) {
                                            echo 'text-green"> <i class="fa fa-caret-up"></i>';
                                        } else if ($facturacion_mensual < $facturacion_mensual_pasada) {
                                            echo 'text-red"> <i class="fa fa-caret-down"></i>';
                                        } else {
                                            echo 'text-yellow"><i class="fa fa-caret-left"></i> ';
                                        }
                                        if ($facturacion_mensual_pasada > 0) {
                                            echo ' ' . round((float)(abs($facturacion_mensual - $facturacion_mensual_pasada)/$facturacion_mensual_pasada) * 100 );
                                        } else {
                                            echo ' &nbsp - ';
                                        }
                                    ?> %</span>

                                    <h5 class="description-header"><?= number_format($facturacion_mensual, 2, ',', ' '); ?> <small><i class="fa fa-eur"></i> </small></h5>
                                    <span class="description-text"><?= $this->lang->line('mensual'); ?></span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 col-xs-6">
                                <div class="description-block border-right">
                                  <span data-toggle="tooltip" title="<?= date("Y",strtotime("-1 year")) .': ' . number_format($facturacion_trimestral_pasada, 2, ',', ' ') . ' €'?>" data-placement="top" class="description-percentage
                                  <?php
                                        if ($facturacion_trimestral > $facturacion_trimestral_pasada) {
                                            echo 'text-green"> <i class="fa fa-caret-up"></i>';
                                        } else if ($facturacion_trimestral < $facturacion_trimestral_pasada) {
                                            echo 'text-red"> <i class="fa fa-caret-down"></i>';
                                        } else {
                                            echo 'text-yellow"><i class="fa fa-caret-left"></i> ';
                                        }
                                  if ($facturacion_trimestral_pasada > 0) {
                                      echo ' ' . round((float)(abs($facturacion_trimestral - $facturacion_trimestral_pasada)/$facturacion_trimestral_pasada) * 100 );
                                  } else {
                                      echo ' &nbsp - ';
                                  }
                                  ?> %</span>
                                    <h5 class="description-header"><?= number_format($facturacion_trimestral, 2, ',', ' '); ?> <small><i class="fa fa-eur"></i> </small></h5>
                                    <span class="description-text"><?= $this->lang->line('trimestral'); ?></span>
                                </div>
                                <!-- /.description-block -->
                            </div>

                            <!-- /.col -->
                            <div class="col-sm-3 col-xs-6">
                                <div class="description-block">
                                     <span data-toggle="tooltip" title="<?= date("Y",strtotime("-1 year")) .': ' . number_format($facturacion_anual_pasada, 2, ',', ' ') . ' €'?>" data-placement="top" class="description-percentage
                                  <?php
                                     if ($facturacion_anual > $facturacion_anual_pasada) {
                                         echo 'text-green"> <i class="fa fa-caret-up"></i>';
                                     } else if ($facturacion_anual < $facturacion_anual_pasada) {
                                         echo 'text-red"> <i class="fa fa-caret-down"></i>';
                                     } else {
                                         echo 'text-yellow"><i class="fa fa-caret-left"></i> ';
                                     }
                                     if ($facturacion_anual_pasada > 0) {
                                         echo ' ' . round((float)(abs($facturacion_anual - $facturacion_anual_pasada)/$facturacion_anual_pasada) * 100 );
                                     } else {
                                         echo ' &nbsp - ';
                                     }
                                     ?> %</span>
                                    <h5 class="description-header"><?= number_format($facturacion_anual, 2, ',', ' '); ?> <small><i class="fa fa-eur"></i> </small></h5>
                                    <span class="description-text"><?= $this->lang->line('anual'); ?></span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                        </div>
                        <!-- /.row -->

                        <table data-link="" id="facturas" class="table table-bordered table-hover display nowrap">
                            <thead>
                                <tr>
                                    <th><i class="fa fa-list-ol" aria-hidden="true"></i> &nbsp; <?= $this->lang->line('numero'); ?></th>
                                    <th><i class="fa fa-user" aria-hidden="true"></i> &nbsp; <?= $this->lang->line('cliente'); ?></th>
                                    <th><i class="fa fa-ticket" aria-hidden="true"></i> &nbsp; <?= $this->lang->line('ticket'); ?></th>
                                    <th><i class="fa fa-euro" aria-hidden="true"></i> &nbsp; <?= $this->lang->line('concepto'); ?> (IVA 21 %) </th>
                                    <th><i class="fa fa-calendar" aria-hidden="true"></i> &nbsp; <?= $this->lang->line('fecha'); ?> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($facturas as $factura) {
                                    echo '<tr style="cursor: pointer;">
                                            <td><a href="' . site_url('admin/ver_factura/' . $factura['id_factura']) . '"></a>' . $factura['id_factura'] . '</td>
                                            <td><a href="' . site_url('admin/ver_cliente/' . $factura['cliente']) . '">' . $factura['nombre_cliente'] . '</a></td>
                                            <td><a href="' . site_url('admin/ver_ticket/' . $factura['id_ticket']) . '">' . $factura['nombre_ticket'] . '</a></td>
                                            <td>' . $factura['precio'] . '</td>
                                            <td>' . date('d/m/Y H:i', strtotime($factura['fecha'])) . '</td>
                                        </tr>
                                         ';
                                }
                                ?>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th><i class="fa fa-list-ol" aria-hidden="true"></i> &nbsp; <?= $this->lang->line('numero'); ?></th>
                                    <th><i class="fa fa-user" aria-hidden="true"></i> &nbsp; <?= $this->lang->line('cliente'); ?></th>
                                    <th><i class="fa fa-ticket" aria-hidden="true"></i> &nbsp; <?= $this->lang->line('ticket'); ?></th>
                                    <th><i class="fa fa-euro" aria-hidden="true"></i> &nbsp; <?= $this->lang->line('concepto'); ?> (IVA 21 %) </th>
                                    <th><i class="fa fa-calendar" aria-hidden="true"></i> &nbsp; <?= $this->lang->line('fecha'); ?> </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- / .box-body -->
                </div>
            </div>
        </div>
    </section>
    <!-- / .content -->
</div>
<!-- / .content-wrapper -->