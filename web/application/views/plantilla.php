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
        <?= link_tag(base_url('assets/css/AdminLTE.min.css')); ?>
        <?= link_tag(base_url('assets/css/skins/_all-skins.min.css')); ?>

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
                            <!-- Menú de notificaciones -->
                            <li class="dropdown notifications-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bell-o"></i>
                                    <span class="label label-warning">10</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">Tiene 10 notificaciones</li>
                                    <li>
                                        <ul class="menu">
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-users text-aqua"></i> Notificación ASD
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="footer"><a href="#">Ver todas</a></li>
                                </ul>
                            </li>
                            <!-- Menú cuenta usuario -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="<?= site_url('assets/img/avatar/1.png'); ?>" class="user-image" alt="Imagen de Perfil">
                                    <span class="hidden-xs"><?= $this->session->nombre_usuario ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="user-header">
                                        <!--img src="<?= base_url() ?>assets/img/avatar/<?= $this->session->id_usuario ?>.png" class="img-circle" alt="Imagen de Perfil"-->
                                        <img src="<?= site_url('assets/img/avatar/1.png'); ?>" class="img-circle" alt="Imagen de Perfil">
                                        <p>
                                            <?= $this->session->nombre_usuario ?> - 
                                            <?php
                                            switch ($this->session->tipo_usuario) {
                                                case USUARIO_ADMIN:
                                                    echo 'Administrador';
                                                    break;
                                                case USUARIO_TECNICO_ADMIN:
                                                    echo 'Técnico administrador';
                                                    break;
                                                case USUARIO_TECNICO:
                                                    echo 'Técnico';
                                                    break;
                                                case USUARIO_CLIENTE:
                                                    echo 'Cliente';
                                                    break;
                                            }
                                            ?>
                                            <small><?= $this->session->email_usuario ?></small>
                                        </p>
                                    </li>                                   
                                    <!-- Menú Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="#" class="btn btn-default btn-flat">Perfil</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="<?= site_url('cerrar_sesion'); ?>" class="btn btn-default btn-flat">Cerrar Sesión</a>
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
                            <img src="<?= site_url('assets/img/avatar/1.png'); ?>" class="img-circle" alt="Imagen de Perfil">
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
                <strong>Copyright &copy; <?= AÑOS_COPYRIGHT ?> <a href="<?= site_url() ?>"><?= NOMBRE_WEB ?></a>.</strong> Todos los derechos reservados.
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
                        <h4 class="control-sidebar-heading">Opciones de diseño</h4>
                        <div class="form-group">
                            <label class="control-sidebar-subheading">
                                <input type="checkbox" data-layout="fixed" class="pull-right"> Diseño fijo
                            </label>
                            <p>Activa el diseño fijo. No se puede usar el diseño fijo y en caja a la vez</p>
                        </div>
                        <div class="form-group">
                            <label class="control-sidebar-subheading">
                                <input type="checkbox" data-layout="layout-boxed" class="pull-right"> Diseño en caja
                            </label>
                            <p>Activa el diseño en caja</p>
                        </div>
                        <div class="form-group">
                            <label class="control-sidebar-subheading">
                                <input type="checkbox" data-layout="sidebar-collapse" class="pull-right"> Minimizar menú
                            </label>
                            <p>Cambia el menú lateral izquierdo (abre o colapsa)</p>
                        </div>
                        <div class="form-group">
                            <label class="control-sidebar-subheading">
                                <input type="checkbox" data-enable="expandOnHover" class="pull-right"> Expandir menú al hacer hover
                            </label>
                            <p>Expande el menú lateral izquierdo al hacer hover</p>
                        </div>
                        <div class="form-group">
                            <label class="control-sidebar-subheading">
                                <input type="checkbox" data-controlsidebar="control-sidebar-open" class="pull-right"> Activa menú lateral derecho deslizante
                            </label>
                            <p>Cambia entre entre contenido deslizante y contenido "empujado"</p>
                        </div>
                        <div class="form-group">
                            <label class="control-sidebar-subheading">
                                <input type="checkbox" data-sidebarskin="toggle" class="pull-right"> Activa el skin en la barra de contenido derecha
                            </label>
                            <p>Activa entre skin oscura y clara para la barra de contenido derecha</p>
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
                                <p class="text-center no-margin">Azul</p>
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
                                <p class="text-center no-margin">Negro</p>
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
                                <p class="text-center no-margin">Morado</p>
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
                                <p class="text-center no-margin">Verde</p>
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
                                <p class="text-center no-margin">Rojo</p>
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
                                <p class="text-center no-margin">Amarillo</p>
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
                                <p class="text-center no-margin" style="font-size: 12px">Azul Claro</p>
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
                                <p class="text-center no-margin" style="font-size: 12px">Negro Claro</p>
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
                                <p class="text-center no-margin" style="font-size: 12px">Morado Claro</p>
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
                                <p class="text-center no-margin" style="font-size: 12px">Verde Claro</p>
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
                                <p class="text-center no-margin" style="font-size: 12px">Rojo Claro</p>
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
                                <p class="text-center no-margin" style="font-size: 12px;">Amarillo Claro</p>
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
        <?= script_tag(base_url('assets/plugins/jQuery/jquery.min.js')) ?>
        <?= script_tag(base_url('assets/plugins/jQueryUI/jquery-ui.min.js')) ?>

        <?= $js ?>

        <?= script_tag(base_url('assets/js/AdminLTE.min.js')) ?>
        <?= script_tag(base_url('assets/js/TITIS.js')) ?>
        <?php
        if (isset($js_pagina) and $js_pagina != '') {
            echo '<script>' . PHP_EOL;
            print $js_pagina . PHP_EOL;
            print '</script>' . PHP_EOL;
        }
        ?>
    </body>
</html>


