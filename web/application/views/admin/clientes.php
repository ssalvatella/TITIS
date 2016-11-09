<div class="content-wrapper">
    <!-- Cabecera -->
    <section class="content-header">
        <h1>
            Clientes
            <small>Panel de control</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('admin'); ?>"><i class="fa fa-home"></i> Inicio</a></li>
            <li class="active"></i>Clientes</li>
        </ol>
    </section>

    <!-- Contenido -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">

                    <!-- /.box-header -->
                    <div class="box-body">
                        <a href = "<?= site_url('admin/registrar_cliente') ?>" class="btn btn-app"><i class="ion ion-person-add"></i>Añadir</a>
                        <a href = "javascript:history.go(0)" class="btn btn-app"><i class="fa fa-repeat"></i>Actualizar</a>
                        <table data-link="" id="clientes" class="table table-bordered table-hover display nowrap"  >
                            <thead>
                                <tr>
                                    <th><i class="fa fa-user" aria-hidden="true"></i> &nbsp; Usuario</th>
                                    <th><i class="fa fa-envelope" aria-hidden="true"></i>&nbsp; Email</th>
                                    <th><i class="fa fa-user-circle" aria-hidden="true"></i> &nbsp; Nombre</th>
                                    <th><i class="fa fa-globe" aria-hidden="true"></i> &nbsp; País</th>
                                    <th><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp; Ciudad</th>
                                    <th><i class="fa fa-phone" aria-hidden="true"></i>&nbsp;  Teléfono</th>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>

                            <?php

                                foreach ($clientes as $cliente) {
                                    echo '<tr style="cursor: pointer;">
                                            <td><a  href="'.site_url('admin/ver_cliente/'. $cliente['id_cliente']) .'"></a>'. $cliente['usuario'].'</td>
                                              <td>'. $cliente['email']. '</td>
                                              <td>'. $cliente['nombre'] .'</td>
                                              <td>'. $cliente['pais'] . '</td>
                                              <td>'. $cliente['ciudad'] . '</td>
                                              <td>'. $cliente['telefono'] . '</td>
                                              <td align="center">';
                                        if ($cliente['activo'] == 1) {
                                            echo '<a data-toggle="tooltip" data-placement="top" title="Banear" href ="'.site_url('admin/banear_cliente/'. $cliente['usuario']). '" class="btn btn-xs btn-danger"><i class="fa fa-user-times"></i></a></td>';
                                        } else {
                                            echo '<a data-toggle="tooltip" data-placement="top" title="Activar" href ="'.site_url('admin/activar_cliente/'. $cliente['usuario']). '"class="btn btn-xs btn-success"><i class="fa fa-user-plus"></i></a></td>';
                                        }
                                }
                            ?>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th><i class="fa fa-user" aria-hidden="true"></i> &nbsp; Usuario</th>
                                    <th><i class="fa fa-envelope" aria-hidden="true"></i>&nbsp; Email</th>
                                    <th><i class="fa fa-user-circle" aria-hidden="true"></i> &nbsp; Nombre</th>
                                    <th><i class="fa fa-globe" aria-hidden="true"></i> &nbsp; País</th>
                                    <th><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp; Ciudad</th>
                                    <th><i class="fa fa-phone" aria-hidden="true"></i>&nbsp;  Teléfono</th>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->