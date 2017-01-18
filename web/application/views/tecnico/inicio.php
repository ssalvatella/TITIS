<div class="content-wrapper">

    <!-- Cabecera -->
    <section class="content-header">
        <h1>
            <?= $this->lang->line('inicio'); ?>
            <small><?= $this->lang->line('panel_de_control'); ?></small>
        </h1>
        <ol class="breadcrumb">
            <li class="active"><i class="fa fa-home"></i>  <?= $this->lang->line('inicio'); ?></li>
        </ol>
    </section>

    <section class="content">
        <!-- Cuadros resumen -->
        <div class="row">

            <!-- Cuadro de tareas pendientes -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3><?= sizeof($tareas_pendientes); ?></h3>
                        <text style="font-size: 16px;" ><?= $this->lang->line('tareas_pendientes'); ?></text>
                    </div>
                    <div class="icon">
                        <a data-toggle="tooltip" data-placement="top" title="" style="color: rgba(0,0,0,0.15);" href="">
                            <i class="fa fa-thumb-tack"></i>
                        </a>
                    </div>
                    <a href="<?= site_url('tecnico/tickets'); ?>" class="small-box-footer"><?= $this->lang->line('acceder'); ?>
                        <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- Cuadro de tareas nuevas-->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?= $ultimas_tareas; ?></h3>
                        <text style="font-size: 16px;" data-toggle="tooltip" data-placement="right" title="<?= sprintf($this->lang->line('ultimos_dias'), 7); ?>"><?= $this->lang->line('tareas_nuevas'); ?></text>
                    </div>
                    <div class="icon">
                        <a style="color: rgba(0,0,0,0.15);" href="<?= site_url('tecnico/tickets'); ?>"><i class="fa fa-tasks"></i></a>
                    </div>
                    <a href="<?= site_url('tecnico/tickets'); ?>" class="small-box-footer"><?= $this->lang->line('acceder'); ?>  <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-6 col-xs-12 connectedSortable">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= $this->lang->line('tareas'); ?></h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <ul class="todo-list">
                            <?php foreach ($tareas_pendientes as $tarea) { ?>
                                <li ticket="<?= $tarea['ticket']; ?>" value="<?= $tarea['id_tarea']; ?>" class="<?= $tarea['estado'] == TAREA_FINALIZADA ? 'done' : '' ?>">
                                    <span class="handle">
                                        <i class="fa fa-ellipsis-v"></i>
                                        <i class="fa fa-ellipsis-v"></i>
                                    </span>
                                    <input data-toggle="tooltip" data-placement="top" title="<?= $this->lang->line('completar_tarea'); ?>" type="checkbox"<?= $tarea['estado'] == TAREA_FINALIZADA ? ' checked ' : ' ' ?>onchange="completar_tarea(this)">
                                    <span class="text"><?= $tarea['nombre']; ?></span>
                                    <span class="label label-primary"><i class="fa fa-wrench"></i> &nbsp;<?= $tarea['nombre_tecnico']; ?></span>
                                    <div class="tools">
                                        <?php if ($tarea['estado'] == TAREA_FINALIZADA) { ?>
                                            <i style="margin-right: 10px" class="label label-info fecha_fin"><i class="fa fa-calendar"></i> &nbsp;<?= $tarea['fin']; ?></i>
                                        <?php } ?>
                                    </div>
                                </li>
                            <?php
                            }
                            if (sizeof($tareas_pendientes) == 0) {
                                echo '<p>' . $this->lang->line('no_hay_tareas_pendientes') . '</p>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>

        </div>

    </section>

</div>