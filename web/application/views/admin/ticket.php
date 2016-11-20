<div class="content-wrapper">
    <!-- Cabecera -->
    <section class="content-header">
        <h1>
            <?= $this->lang->line('ver_ticket'); ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('admin'); ?>"><i class="fa fa-home"></i><?= $this->lang->line('inicio'); ?></a></li>
            <li class="active"></i><?= $this->lang->line('ver_ticket'); ?></li>
        </ol>
    </section>
    <!-- Contenido -->
    <section class="content">

        <div class="box  box-primary" style="width: 80%; margin:0 auto;">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $ticket['titulo'] . ' <small>'. date('d/m/Y H:i', strtotime($ticket['inicio']))?> </small></h3>
                <div class="box-tools pull-right">
<!--                    <span class="label label-primary">Label</span>-->
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">

                <div class="row">
                    <div class="col-lg-3 col-xs-6">
                        <div class="info-box bg-red">
                            <!-- Apply any bg-* class to to the icon to color it -->
                            <span class="info-box-icon"><i class="fa fa-user"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text"><?= $this->lang->line('cliente'); ?></span>
                                <span class="info-box-number"><?= $ticket['nombre_cliente'] ?></span>
                            </div><!-- /.info-box-content -->
                        </div><!-- /.info-box -->
                    </div>
                    <div class="col-lg-3 col-xs-6">
                        <div class="info-box bg-green">
                            <!-- Apply any bg-* class to to the icon to color it -->
                            <span class="info-box-icon"><i class="fa fa-wrench"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text"><?= $this->lang->line('tecnico_admin'); ?></span>
                                <span class="info-box-number"><?php if(isset($ticket['tecnico_admin'] )) {
                                    echo $ticket['nombre_tecnico_admin'];
                                    } else {
                                        echo $this->lang->line('no_asignado');
                                    }?></span>
                            </div><!-- /.info-box-content -->
                        </div><!-- /.info-box -->
                    </div>
                    <div class="col-lg-3 col-xs-6">
                        <div class="info-box bg-aqua">
                            <!-- Apply any bg-* class to to the icon to color it -->
                            <span class="info-box-icon"><i class="fa fa-calendar"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text"><?= $this->lang->line('fecha'); ?></span>
                                <span class="info-box-number"><?= date('d/m/Y H:i', strtotime($ticket['inicio'])); ?></span>
                            </div><!-- /.info-box-content -->
                        </div><!-- /.info-box -->
                    </div>
                    <div class="col-lg-3 col-xs-6">
                        <div class="info-box <?php switch ($ticket['estado']){

                            case TICKET_PENDIENTE: echo 'bg-yellow'; break;
                            case TICKET_EN_PROCESO: echo 'bg-aqua'; break;
                            case TICKET_FINALIZADO: echo 'bg-green'; break;

                        }?>">
                            <!-- Apply any bg-* class to to the icon to color it -->
                            <span class="info-box-icon"><i class="<?php switch ($ticket['estado']){

                                    case TICKET_PENDIENTE: echo 'fa fa-exclamation-triangle'; break;
                                    case TICKET_EN_PROCESO: echo 'fa fa-exclamation-exchange'; break;
                                    case TICKET_FINALIZADO: echo 'glyphicon glyphicon-ok'; break;

                                }?>"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text"><?= $this->lang->line('estado'); ?></span>
                                <span class="info-box-number"><?php
                                    switch($ticket['estado']) {
                                        case TICKET_PENDIENTE:
                                            echo  $this->lang->line('pendiente');
                                            break;
                                        case TICKET_EN_PROCESO:
                                            echo $this->lang->line('en_proceso');
                                            break;
                                        case TICKET_FINALIZADO:
                                            echo $this->lang->line('finalizado');
                                            break;
                                    } ?></span>
                            </div><!-- /.info-box-content -->
                        </div><!-- /.info-box -->
                    </div>
                </div>

            </div><!-- /.box-body -->
            <div class="box-group" id="accordion">
                <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                <div class="panel box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" class="collapsed">
                                <?= $this->lang->line('descripcion'); ?>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse" aria-expanded="true" style="height: 0px;">
                        <div class="box-body">
                            <?= $mensajes[0]['texto']; ?>
                        </div>
                    </div>
                </div>
                <div class="panel box box-danger">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="" aria-expanded="false">
                                <i class="ion ion-clipboard"></i>  <?= $this->lang->line('tareas'); ?>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse in " aria-expanded="false">
                        <!-- TO DO List -->
                        <div class="box-body">
                            <ul class="todo-list">
                                <?php

                                foreach ($tareas as $tarea) {
                                    echo '<li>
                                            <span class="handle">
                                                <i class="fa fa-ellipsis-v"></i>
                                                <i class="fa fa-ellipsis-v"></i>
                                            </span>
                                            <input type="checkbox" value="">
                                            <span class="text">'. $tarea['nombre'].'</span>
                                            <div class="tools">
                                                <i class="fa fa-edit"></i>
                                                <i class="fa fa-trash-o"></i>
                                            </div></li>';

                                }

                                ?>
                                <li>
                                    <!-- drag handle -->
                                    <span class="handle">
                                        <i class="fa fa-ellipsis-v"></i>
                                        <i class="fa fa-ellipsis-v"></i>
                                    </span>
                                    <!-- checkbox -->
                                    <input type="checkbox" value="">
                                    <!-- todo text -->
                                    <span class="text">Design a nice theme</span>
                                    <!-- Emphasis label -->
                                    <small class="label label-danger"><i class="fa fa-clock-o"></i> 2 mins</small>
                                    <!-- General tools such as edit or delete-->
                                    <div class="tools">
                                        <i class="fa fa-edit"></i>
                                        <i class="fa fa-trash-o"></i>
                                    </div>
                                </li>
                                <li>
                      <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                                    <input type="checkbox" value="">
                                    <span class="text">Make the theme responsive</span>
                                    <small class="label label-info"><i class="fa fa-clock-o"></i> 4 hours</small>
                                    <div class="tools">
                                        <i class="fa fa-edit"></i>
                                        <i class="fa fa-trash-o"></i>
                                    </div>
                                </li>
                                <li>
                      <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                                    <input type="checkbox" value="">
                                    <span class="text">Let theme shine like a star</span>
                                    <small class="label label-warning"><i class="fa fa-clock-o"></i> 1 day</small>
                                    <div class="tools">
                                        <i class="fa fa-edit"></i>
                                        <i class="fa fa-trash-o"></i>
                                    </div>
                                </li>
                                <li>
                      <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                                    <input type="checkbox" value="">
                                    <span class="text">Let theme shine like a star</span>
                                    <small class="label label-success"><i class="fa fa-clock-o"></i> 3 days</small>
                                    <div class="tools">
                                        <i class="fa fa-edit"></i>
                                        <i class="fa fa-trash-o"></i>
                                    </div>
                                </li>
                                <li>
                      <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                                    <input type="checkbox" value="">
                                    <span class="text">Check your messages and notifications</span>
                                    <small class="label label-primary"><i class="fa fa-clock-o"></i> 1 week</small>
                                    <div class="tools">
                                        <i class="fa fa-edit"></i>
                                        <i class="fa fa-trash-o"></i>
                                    </div>
                                </li>
                                <li>
                      <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                                    <input type="checkbox" value="">
                                    <span class="text">Let theme shine like a star</span>
                                    <small class="label label-default"><i class="fa fa-clock-o"></i> 1 month</small>
                                    <div class="tools">
                                        <i class="fa fa-edit"></i>
                                        <i class="fa fa-trash-o"></i>
                                    </div>
                                </li>
                            </ul>
                        </div>
                            <!-- /.box-header -->

                            <!-- /.box-body -->
                            <div class="box-footer clearfix no-border">
                                <button type="button" class="btn btn-default pull-right"><i class="fa fa-plus"></i> <?= $this->lang->line('añadir_tarea'); ?></button>
                            </div>
                        <!-- /.box -->
                    </div>
                </div>
            </div>
            <div class="box-footer">
                The footer of the box
            </div><!-- box-footer -->
        </div>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->