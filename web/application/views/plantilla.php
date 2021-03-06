<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?= NOMBRE_WEB ?> | <?= $titulo ?></title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?= meta('author', 'Equipo TITIS') ?>
        <?= meta('description', 'TITIS - Gestión de incidencias y tickets') ?>
        <?php echo link_tag(base_url('favicon.ico'), 'shortcut icon', 'image/ico'); ?>

        <!-- CSS REQUERIDOS -->
        <?= $css ?>
        <?= link_tag(base_url('assets/plugins/flag-icon-css/css/flag-icon.min.css')); ?>
        <?= link_tag(base_url('assets/css/AdminLTE.min.css')); ?>
        <?= link_tag(base_url('assets/css/skins/_all-skins.min.css')); ?>
        <?= link_tag(base_url('assets/css/TITIS.css')); ?>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>    
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">

            <header class="main-header">
                <!-- Logo -->
                <a href="<?= base_url(); ?>" class="logo">
                    <span class="logo-mini"><b>T</b></span>
                    <span class="logo-lg"><b>TITIS</b></span>
                </a>

                <!-- Barra lateral de la cabecera -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <!-- Menú Navbar Derecho -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">

                            <!-- Messages: style can be found in dropdown.less-->
                            <li class="dropdown messages-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-envelope-o"></i>
                                    <?php if (count($mensajes_privados) >= 1) { ?>
                                        <span class="label label-success"><?= count($mensajes_privados) ?></span>
                                    <?php } ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">
                                        <?php
                                        if (count($mensajes_privados) == 0) {
                                            echo $this->lang->line('no_hay_mensajes');
                                        } else if (count($mensajes_privados) == 1) {
                                            echo $this->lang->line('tiene_1_mensaje');
                                        } else {
                                            echo $this->lang->line('tiene') . count($mensajes_privados) . $this->lang->line('mensajes');
                                        }
                                        ?>
                                    </li>
                                    <li>
                                        <ul class="menu">
                                            <?php
                                            foreach ($mensajes_privados as $mensaje_privado) {
                                                $fecha_mensaje = new DateTime($mensaje_privado['fecha']);
                                                $fecha_actual = new DateTime("now");
                                                $intervalo_tiempo = date_diff($fecha_mensaje, $fecha_actual);
                                                if ($intervalo_tiempo->d > 0) {
                                                    $diferencia = $intervalo_tiempo->format('%a ' . $this->lang->line('dias'));
                                                } else if ($intervalo_tiempo->h > 0) {
                                                    $diferencia = $intervalo_tiempo->format('%h h %i min');
                                                } else {
                                                    $diferencia = $intervalo_tiempo->format('%i min');
                                                }
                                                ?>
                                                <li>
                                                    <a href="<?= $url_pagina . "/ver_mensaje/" . $mensaje_privado['id_mensaje']; ?>">
                                                        <div class="pull-left">
                                                            <img src="<?= site_url('assets/img/avatar/1.png'); ?>" class="img-circle" alt="<?= $this->lang->line('imagen_perfil'); ?>">
                                                        </div>
                                                        <h4><?= $mensaje_privado['nombre_emisor']; ?><small><i class="fa fa-clock-o"></i><?= $diferencia; ?></small></h4>
                                                        <p><?= strip_tags(substr($mensaje_privado['texto'], 0, 20)); ?></p>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                    <li class="footer"><a href="<?= $url_pagina . '/mensajes'; ?>"><?= $this->lang->line('ver_todos') ?></a></li>
                                </ul>
                            </li>

                            <!-- Menú de notificaciones -->
                            <li class="dropdown notifications-menu">
                                <a id="icono_notificaciones" href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bell-o"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li id="header_notificaciones" class="header">
                                        <?php
                                        if (count($notificaciones) == 0) {
                                            echo $this->lang->line('no_hay_notificaciones');
                                        } else if (count($notificaciones) == 1) {
                                            echo $this->lang->line('tiene_1_notificacion');
                                        } else {
                                            echo sprintf($this->lang->line('tiene_notificaciones'), count($notificaciones));
                                        }
                                        ?>                                        
                                    </li>
                                    <li>
                                        <ul id="menu_notificaciones" class="menu">                                            
                                        </ul>
                                    </li>
                                    <li class="footer"><a href="<?= $url_pagina . '/notificaciones'; ?>"><?= $this->lang->line('ver_todas'); ?></a></li>
                                </ul>
                            </li>
                            <!-- Menú cuenta usuario -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="<?= site_url('assets/img/avatar/1.png'); ?>" class="user-image" alt="<?= $this->lang->line('imagen_perfil'); ?>">
                                    <span class="hidden-xs"><?= $this->session->nombre_usuario ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="user-header">
                                        <!--img src="<?= base_url() ?>assets/img/avatar/<?= $this->session->id_usuario ?>.png" class="img-circle" alt="Imagen de Perfil"-->
                                        <img src="<?= site_url('assets/img/avatar/1.png'); ?>" class="img-circle" alt="<?= $this->lang->line('imagen_perfil'); ?>">
                                        <p>
                                            <?= $this->session->nombre_usuario ?> - 
                                            <?php
                                            switch ($this->session->tipo_usuario) {
                                                case USUARIO_ADMIN:
                                                    echo $this->lang->line('admin');
                                                    break;
                                                case USUARIO_TECNICO_ADMIN:
                                                    echo $this->lang->line('tecnico_admin');
                                                    break;
                                                case USUARIO_TECNICO:
                                                    echo $this->lang->line('tecnico');
                                                    break;
                                                case USUARIO_CLIENTE:
                                                    echo $this->lang->line('cliente');
                                                    break;
                                            }
                                            ?>
                                            <small><?= $this->session->email_usuario ?></small>
                                        </p>
                                    </li> 
                                    <!-- Mení Body -->
                                    <li class="user-body">
                                        <div class="row" style="font-size: 200%;">
                                            <div class="col-xs-6 text-center">
                                                <a href="<?= $url_pagina . '/cambiar_idioma/spanish'; ?>" data-toggle="tooltip" data-placement="top" title="Español"><span class="flag-icon flag-icon-es"></span></a>
                                            </div>
                                            <div class="col-xs-6 text-center">
                                                <a href="<?= $url_pagina . '/cambiar_idioma/english'; ?>" data-toggle="tooltip" data-placement="top" title="English"><span class="flag-icon flag-icon-gb"></span></a>
                                            </div>
                                        </div>
                                        <!-- /.row -->
                                    </li>
                                    <!-- Menú Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="<?= $url_pagina . '/perfil'; ?>" class="btn btn-default btn-flat"><?= $this->lang->line('perfil'); ?></a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="<?= site_url('cerrar_sesion'); ?>" class="btn btn-default btn-flat"><?= $this->lang->line('cerrar_sesion'); ?></a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Columna de la izquierda, contiene el logo y el sidebar -->
            <aside class="main-sidebar">
                <section class="sidebar">

                    <!-- Panel de usuario sidebar -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?= site_url('assets/img/avatar/1.png'); ?>" class="img-circle" alt="<?= $this->lang->line('imagen_perfil'); ?>">
                        </div>
                        <div class="pull-left info">
                            <p><?= $this->session->nombre_usuario ?></p>                            
                            <!-- Estado -->
                            <a><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>

                    <!-- Menú sidebar -->
                    <?= $menu ?>                    
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Contenido de la página -->
            <?= $contenido ?>            

            <!-- Pie de página principal -->
            <footer class="main-footer">
                <strong>Copyright &copy; <?= AÑOS_COPYRIGHT ?> <a href="<?= site_url() ?>"><?= NOMBRE_WEB ?></a>.</strong> <?= $this->lang->line('derechos_reservados'); ?>.
            </footer>

            <!-- Barra lateral de control -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Pestañas -->
                <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
                    <li class="active"><a href="#control-sidebar-layout-tab" data-toggle="tab"><i class="fa fa-wrench"></i></a></li>
                    <li><a href="#control-sidebar-skin-tab" data-toggle="tab"><i class="ionicons ion-android-color-palette" style="font-size: 130%;"></i></a></li>
                </ul>
                <!-- Contenido pestaña -->
                <div class="tab-content">
                    <!-- Home tab content -->
                    <div class="tab-pane active" id="control-sidebar-layout-tab">
                        <h4 class="control-sidebar-heading"><?= $this->lang->line('opciones_de_diseño'); ?></h4>
                        <div class="form-group">
                            <label class="control-sidebar-subheading">
                                <input type="checkbox" data-layout="fixed" class="pull-right"><?= $this->lang->line('diseño_fijo'); ?>
                            </label>
                            <p><?= $this->lang->line('d_fijo_descripcion'); ?></p>
                        </div>
                        <div class="form-group">
                            <label class="control-sidebar-subheading">
                                <input type="checkbox" data-layout="layout-boxed" class="pull-right"><?= $this->lang->line('diseño_en_caja'); ?>
                            </label>
                            <p><?= $this->lang->line('d_caja_descripcion'); ?></p>
                        </div>
                        <div class="form-group">
                            <label class="control-sidebar-subheading">
                                <input type="checkbox" data-layout="sidebar-collapse" class="pull-right"><?= $this->lang->line('minimizar_menu'); ?>
                            </label>
                            <p><?= $this->lang->line('m_minimizar_descripcion'); ?></p>
                        </div>
                        <div class="form-group">
                            <label class="control-sidebar-subheading">
                                <input type="checkbox" data-enable="expandOnHover" class="pull-right"><?= $this->lang->line('expandir_menu'); ?>
                            </label>
                            <p><?= $this->lang->line('expandir_menu_descripcion'); ?></p>
                        </div>
                        <div class="form-group">
                            <label class="control-sidebar-subheading">
                                <input type="checkbox" data-controlsidebar="control-sidebar-open" class="pull-right"><?= $this->lang->line('activa_menu_deslizante'); ?>
                            </label>
                            <p><?= $this->lang->line('a_menu_descripcion'); ?></p>
                        </div>
                        <div class="form-group">
                            <label class="control-sidebar-subheading">
                                <input type="checkbox" data-sidebarskin="toggle" class="pull-right"><?= $this->lang->line('activa_skin'); ?>
                            </label>
                            <p><?= $this->lang->line('a_skin_descripcion'); ?></p>
                        </div>                        
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="control-sidebar-skin-tab">
                        <h4 class="control-sidebar-heading">Skins</h4>
                        <ul class="list-unstyled clearfix">
                            <li style="float:left; width: 33.33333%; padding: 5px;">
                                <a href="javascript:void(0);" data-skin="skin-blue" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                    <div>
                                        <span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9;"></span>
                                        <span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 7px;"></span>
                                    </div>
                                    <div>
                                        <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32;"></span>
                                        <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                                    </div>
                                </a>
                                <p class="text-center no-margin"><?= $this->lang->line('azul'); ?></p>
                            </li>
                            <li style="float:left; width: 33.33333%; padding: 5px;">
                                <a href="javascript:void(0);" data-skin="skin-black" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                    <div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix">
                                        <span style="display:block; width: 20%; float: left; height: 7px; background: #fefefe;"></span>
                                        <span style="display:block; width: 80%; float: left; height: 7px; background: #fefefe;"></span>
                                    </div>
                                    <div>
                                        <span style="display:block; width: 20%; float: left; height: 20px; background: #222;"></span>
                                        <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                                    </div>
                                </a>
                                <p class="text-center no-margin"><?= $this->lang->line('negro'); ?></p>
                            </li>
                            <li style="float:left; width: 33.33333%; padding: 5px;">
                                <a href="javascript:void(0);" data-skin="skin-purple" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                    <div>
                                        <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-purple-active"></span>
                                        <span class="bg-purple" style="display:block; width: 80%; float: left; height: 7px;"></span>
                                    </div>
                                    <div>
                                        <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32;"></span>
                                        <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                                    </div>
                                </a>
                                <p class="text-center no-margin"><?= $this->lang->line('morado'); ?></p>
                            </li>
                            <li style="float:left; width: 33.33333%; padding: 5px;"><a href="javascript:void(0);" data-skin="skin-green" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                    <div>
                                        <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-green-active"></span>
                                        <span class="bg-green" style="display:block; width: 80%; float: left; height: 7px;"></span>
                                    </div>
                                    <div>
                                        <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32;"></span>
                                        <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                                    </div>
                                </a>
                                <p class="text-center no-margin"><?= $this->lang->line('verde'); ?></p>
                            </li>
                            <li style="float:left; width: 33.33333%; padding: 5px;">
                                <a href="javascript:void(0);" data-skin="skin-red" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                    <div>
                                        <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-red-active"></span>
                                        <span class="bg-red" style="display:block; width: 80%; float: left; height: 7px;"></span>
                                    </div>
                                    <div>
                                        <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32;"></span>
                                        <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                                    </div>
                                </a>
                                <p class="text-center no-margin"><?= $this->lang->line('rojo'); ?></p>
                            </li>
                            <li style="float:left; width: 33.33333%; padding: 5px;">
                                <a href="javascript:void(0);" data-skin="skin-yellow" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                    <div>
                                        <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-yellow-active"></span>
                                        <span class="bg-yellow" style="display:block; width: 80%; float: left; height: 7px;"></span>
                                    </div>
                                    <div>
                                        <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32;"></span>
                                        <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                                    </div>
                                </a>
                                <p class="text-center no-margin"><?= $this->lang->line('amarillo'); ?></p>
                            </li>
                            <li style="float:left; width: 33.33333%; padding: 5px;">
                                <a href="javascript:void(0);" data-skin="skin-blue-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                    <div>
                                        <span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9;"></span>
                                        <span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 7px;"></span>
                                    </div>
                                    <div>
                                        <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span>
                                        <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                                    </div>
                                </a>
                                <p class="text-center no-margin" style="font-size: 12px"><?= $this->lang->line('azul_claro'); ?></p>
                            </li>
                            <li style="float:left; width: 33.33333%; padding: 5px;">
                                <a href="javascript:void(0);" data-skin="skin-black-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                    <div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix">
                                        <span style="display:block; width: 20%; float: left; height: 7px; background: #fefefe;"></span>
                                        <span style="display:block; width: 80%; float: left; height: 7px; background: #fefefe;"></span>
                                    </div>
                                    <div>
                                        <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span>
                                        <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                                    </div>
                                </a>
                                <p class="text-center no-margin" style="font-size: 12px"><?= $this->lang->line('negro_claro'); ?></p>
                            </li>
                            <li style="float:left; width: 33.33333%; padding: 5px;">
                                <a href="javascript:void(0);" data-skin="skin-purple-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                    <div>
                                        <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-purple-active"></span>
                                        <span class="bg-purple" style="display:block; width: 80%; float: left; height: 7px;"></span>
                                    </div>
                                    <div>
                                        <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span>
                                        <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                                    </div>
                                </a>
                                <p class="text-center no-margin" style="font-size: 12px"><?= $this->lang->line('morado_claro'); ?></p>
                            </li>
                            <li style="float:left; width: 33.33333%; padding: 5px;">
                                <a href="javascript:void(0);" data-skin="skin-green-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover"><div>
                                        <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-green-active"></span>
                                        <span class="bg-green" style="display:block; width: 80%; float: left; height: 7px;"></span>
                                    </div>
                                    <div>
                                        <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span>
                                        <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                                    </div>
                                </a>
                                <p class="text-center no-margin" style="font-size: 12px"><?= $this->lang->line('verde_claro'); ?></p>
                            </li>
                            <li style="float:left; width: 33.33333%; padding: 5px;">
                                <a href="javascript:void(0);" data-skin="skin-red-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                    <div>
                                        <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-red-active"></span>
                                        <span class="bg-red" style="display:block; width: 80%; float: left; height: 7px;"></span>
                                    </div>
                                    <div>
                                        <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span>
                                        <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                                    </div>
                                </a>
                                <p class="text-center no-margin" style="font-size: 12px"><?= $this->lang->line('rojo_claro'); ?></p>
                            </li>
                            <li style="float:left; width: 33.33333%; padding: 5px;">
                                <a href="javascript:void(0);" data-skin="skin-yellow-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                    <div>
                                        <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-yellow-active"></span>
                                        <span class="bg-yellow" style="display:block; width: 80%; float: left; height: 7px;"></span>
                                    </div>
                                    <div>
                                        <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span>
                                        <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                                    </div>
                                </a>
                                <p class="text-center no-margin" style="font-size: 12px;"><?= $this->lang->line('amarillo_claro'); ?></p>
                            </li>
                        </ul>
                    </div>
                    <!-- /.tab-pane -->
                </div>
            </aside>
            <!-- /.control-sidebar -->
            <div class="control-sidebar-bg"></div>
        </div>
        <!-- ./wrapper -->

        <!-- JAVASCRIPTS REQUERIDOS -->
        <?= $js ?>
        <?= script_tag(base_url('assets/js/AdminLTE.min.js')) ?>
        <script>
            var id_usuario = "<?= $this->session->userdata('id_usuario'); ?>";
            var idioma = "<?= $this->session->userdata('idioma'); ?>";
            var url_pagina = "<?= $url_pagina; ?>";
        </script>
        <?= script_tag(base_url('assets/js/TITIS.js')) ?>
        <?= script_tag(base_url('assets/js/websocket.js')) ?>
        <?php
        if (isset($js_pagina) and $js_pagina != '') {
            echo '<script>' . PHP_EOL;
            print $js_pagina . PHP_EOL;
            print '</script>' . PHP_EOL;
        }
        ?>
    </body>
</html>


