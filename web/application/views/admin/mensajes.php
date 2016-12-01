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

    <section class="content">

        <div class="row">

            <div class="col-md-3">

                <a href="#" class="btn btn-primary btn-block margin-bottom"><?= $this->lang->line('enviar_mensaje'); ?></a>

                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Folders</h3>

                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <ul class="nav nav-pills nav-stacked">
                            <li class="active"><a href="#"><i class="fa fa-inbox"></i> Inbox
                                    <span class="label label-primary pull-right"><?php if ($numero_mensajes_no_vistos > 0) echo $numero_mensajes_no_vistos;?></span></a></li>
                            <li><a href="#"><i class="fa fa-envelope-o"></i> Sent</a></li>
                            <li><a href="#"><i class="fa fa-file-text-o"></i> Drafts</a></li>
                            <li><a href="#"><i class="fa fa-filter"></i> Junk <span class="label label-warning pull-right">65</span></a>
                            </li>
                            <li><a href="#"><i class="fa fa-trash-o"></i> Trash</a></li>
                        </ul>
                    </div>

                </div>
            </div>

            <div class="col-md-9">
                <div class="box box-primary" style="padding-bottom: 20px" >
                    <div class="box-header ">
                        <h3 class="box-title">Inbox</h3>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding " >

                        <div class="table-responsive mailbox-messages" >
                            <table id= "mensajes" class="table table-hover table-striped" >
                                <tbody>
                                <?php

                                    foreach ($mensajes as $mensaje) {

                                        $fecha_mensaje = new DateTime($mensaje['fecha']);
                                        $fecha_actual = new DateTime("now");
                                        $intervalo_tiempo = date_diff($fecha_mensaje, $fecha_actual);
                                        if ($intervalo_tiempo->d > 0) {
                                            $dias = $this->lang->line('dias');
                                            if ($intervalo_tiempo->d == 1)
                                                $dias = substr($dias, 0, strlen($dias) - 1);
                                            $diferencia = $intervalo_tiempo->format('%a ' . $dias);
                                        } else if ($intervalo_tiempo->h > 0) {
                                            $diferencia = $intervalo_tiempo->format('%h h %i min');
                                        } else {
                                            $diferencia = $intervalo_tiempo->format('%i min');
                                        }


                                        echo '<tr>';
                                        echo '<td><input type="checkbox"></td>';
                                        echo '<td class="mailbox-name"><a href="'.'">'. $mensaje['nombre_emisor'] .'</a></td>';
                                        echo '<td class="mailbox-subject">'. strip_tags(substr($mensaje['texto'],0,20)) .'...</td>';
                                        if (isset($mensaje['archivo'])) {
                                            echo '<td class="mailbox-attachment"><i class="fa fa-paperclip"></i></td>';
                                        } else {
                                            echo '<td> </td>';
                                        }
                                        echo '<td class="mailbox-date">'. $diferencia . '</td>';
                                        echo '</tr>';

                                    }

                                ?>
                                </tbody>
                            </table>
                            <!-- /.table -->

                        </div>
                        <!-- /.mail-box-messages -->

                    </div>
                    <!-- /.box-body -->

                </div>
                <!-- /. box -->
            </div>

        </div>

    </section>


</div>