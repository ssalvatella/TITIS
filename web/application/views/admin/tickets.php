<div class="content-wrapper">
    <!-- Cabecera -->
    <section class="content-header">
        <h1>
            Tickets
            <small>Panel de control</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('admin'); ?>"><i class="fa fa-home"></i> Inicio</a></li>
            <li class="active"></i>Tickets</li>
        </ol>
    </section>

    <!-- Contenido -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">

                    <!-- /.box-header -->
                    <div class="box-body">
                        <a href = "javascript:history.go(0)" class="btn btn-app"><i class="fa fa-repeat"></i>Actualizar</a>
                        <table data-link="" id="clientes" class="table table-bordered table-hover display nowrap"  >
                            <thead>
                            <tr>
                                <th><i class="fa fa-list-ol" aria-hidden="true"></i> &nbsp; Número</th>
                                <th><i class="fa fa-user" aria-hidden="true"></i>&nbsp; Cliente</th>
                                <th><i class="fa fa-pencil" aria-hidden="true"></i> &nbsp; Título</th>
                                <th><i class="fa fa-wrench" aria-hidden="true"></i> &nbsp; Técnico Admin</th>
                                <th><i class="glyphicon glyphicon-ok" aria-hidden="true"></i>&nbsp; Estado</th>
                                <th><i class="glyphicon glyphicon-stats" aria-hidden="true"></i>&nbsp;  Progreso</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php

                            foreach ($tickets as $ticket) {
                                echo '<tr style="cursor: pointer;">
                                            <td><a  href="'.site_url('admin/ver_ticket/'. $ticket['id_ticket']) .'"></a>'. $ticket['id_ticket'].'</td>
                                              <td>'. $ticket['nombre_cliente']. '</td>
                                              <td>'. $ticket['titulo'] . '</td>
                                              <td>'. $ticket['nombre_tecnico_admin'] . '</td>
                                              <td>'. $ticket['estado'] . '</td>
                                              <td> <div class="progress progress-sm active "></div><div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="'. $ticket['progreso']. '" aria-valuemin="0" aria-valuemax="100" </div></td>';

                            }
                            ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th><i class="fa fa-list-ol" aria-hidden="true"></i> &nbsp; Número</th>
                                <th><i class="fa fa-user" aria-hidden="true"></i>&nbsp; Cliente</th>
                                <th><i class="fa fa-pencil" aria-hidden="true"></i> &nbsp; Título</th>
                                <th><i class="fa fa-wrench" aria-hidden="true"></i> &nbsp; Técnico Admin</th>
                                <th><i class="glyphicon glyphicon-ok" aria-hidden="true"></i>&nbsp; Estado</th>
                                <th><i class="glyphicon glyphicon-stats" aria-hidden="true"></i>&nbsp;  Progreso</th>
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