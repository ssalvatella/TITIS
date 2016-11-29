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
                        <a href="javascript:history.go(0)" class="btn btn-app"><i class="fa fa-repeat"></i><?= $this->lang->line('actualizar'); ?></a>
                        <table data-link="" id="facturas" class="table table-bordered table-hover display nowrap">
                            <thead>
                                <tr>
                                    <th><i class="fa fa-list-ol" aria-hidden="true"></i> &nbsp; <?= $this->lang->line('numero'); ?></th>
                                    <th><i class="fa fa-user" aria-hidden="true"></i> &nbsp; <?= $this->lang->line('cliente'); ?></th>
                                    <th><i class="fa fa-ticket" aria-hidden="true"></i> &nbsp; <?= $this->lang->line('ticket'); ?></th>
                                    <th><i class="fa fa-euro" aria-hidden="true"></i> &nbsp; <?= $this->lang->line('concepto'); ?></th>
                                    <th><i class="fa fa-percent" aria-hidden="true"></i> &nbsp; <?= $this->lang->line('iva'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <?php 
                                
                                foreach ($facturas as $factura) {
                                    echo '<tr style="cursor: pointer;">
                                                <td><a href="'.site_url('admin/ver_factura/'. $factura['id_factura']) .'"></a>'. $factura['id_factura'].'</td>
                                                <td><a href="'.site_url('admin/ver_cliente/'. $factura['cliente']) . '">'. $factura['nombre_cliente']. '</a></td>
                                                <td><a href="'.site_url('admin/ver_ticket/'. $factura['ticket']) . '">'. $factura['ticket']. '</a></td>
                                                <td>'. $factura['precio'] . '</td>
                                                <td>'. $factura['iva'] . '</td>';
                                }
                                
                                
                                ?>
                            </tbody>
                            
                            <tfoot>
                                <tr>
                                    <th><i class="fa fa-list-ol" aria-hidden="true"></i> &nbsp; <?= $this->lang->line('numero'); ?></th>
                                    <th><i class="fa fa-user" aria-hidden="true"></i> &nbsp; <?= $this->lang->line('cliente'); ?></th>
                                    <th><i class="fa fa-ticket" aria-hidden="true"></i> &nbsp; <?= $this->lang->line('ticket'); ?></th>
                                    <th><i class="fa fa-euro" aria-hidden="true"></i> &nbsp; <?= $this->lang->line('concepto'); ?></th>
                                    <th><i class="fa fa-percent" aria-hidden="true"></i> &nbsp; <?= $this->lang->line('iva'); ?></th>
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