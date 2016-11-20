<ul class="sidebar-menu">
    <li class="header"><?= $this->lang->line('menu'); ?></li>
    <li id="menu_inicio"><a href="<?= site_url('cliente') ?>"><i class="fa fa-home"></i> <span><?= $this->lang->line('inicio'); ?></span></a></li>

    <li class="treeview">
        <a href="#">
            <i class="fa fa-ticket"></i>
            <span>Tickets</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li id="menu_crear_ticket"><a href="<?= site_url('cliente/crear_ticket') ?>"><i class="fa fa-circle-o"></i> <?= $this->lang->line('crear ticket'); ?></a></li>
            <li id="menu_ver_tickets"><a href="<?= site_url('admin/ver_tickets') ?>"><i class="fa fa-circle-o"></i> <?= $this->lang->line('ver enviados'); ?></a></li>
        </ul>
    </li>
    <li class="header"><?= $this->lang->line('ajustes'); ?></li>
    <li id="menu_perfil"><a href="<?= site_url('cliente/perfil') ?>"><i class="fa fa-cog"></i> <span><?= $this->lang->line('perfil'); ?></span></a></li>

</ul>
<!-- /.sidebar-menu -->