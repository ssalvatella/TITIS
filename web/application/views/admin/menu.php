<ul class="sidebar-menu">
    <li class="header">MENÚ</li>
    <li id="menu_inicio"><a href="<?= site_url('admin') ?>"><i class="fa fa-home"></i> <span>Inicio</span></a></li>
    <li class="treeview">
        <a href="#">
            <i class="ion ion-person-add"></i>
            <span>Registrar</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li id="menu_registro_empleado"><a href="<?= site_url('admin/registrar_empleado') ?>"><i class="fa fa-circle-o"></i> Empleado</a></li>
            <li id="menu_registro_cliente"><a href="<?= site_url('admin/registrar_cliente') ?>"><i class="fa fa-circle-o"></i> Cliente</a></li>
        </ul>
    </li>
    <li id="menu_tickets"><a href="<?= site_url('admin/tickets') ?>"><i class="fa fa-ticket" aria-hidden="true"></i> <span>Tickets</span></a></li>
    <li id="menu_clientes"><a href="<?= site_url('admin/clientes') ?>"><i class="fa fa-address-book" aria-hidden="true"></i> <span>Clientes</span></a></li>
    <li class="header">AJUSTES</li>                        
    <li id="menu_perfil"><a href="<?= site_url('admin/perfil') ?>"><i class="fa fa-cog"></i> <span>Perfil</span></a></li>
</ul>
<!-- /.sidebar-menu -->