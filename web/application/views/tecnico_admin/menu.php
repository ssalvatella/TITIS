<ul class="sidebar-menu">
    <li class="header"><?= $this->lang->line('menu'); ?></li>
    <li id="menu_inicio"><a href="<?= site_url('tecnico_admin') ?>"><i class="fa fa-home"></i> <span><?= $this->lang->line('inicio'); ?></span></a></li>
    <li id="menu_tickets"><a href="<?= site_url('tecnico_admin/tickets') ?>"><i class="fa fa-ticket" aria-hidden="true"></i> <span><?= $this->lang->line('tickets'); ?></span></a></li>
    <li id="menu_facturas"><a href="<?= site_url('tecnico_admin/facturas') ?>"><i class="fa fa-money" aria-hidden="true"></i> <span><?= $this->lang->line('facturas'); ?></span></a></li>
    
    <li class="header"><?= $this->lang->line('ajustes'); ?></li>                        
    <li id="menu_perfil"><a href="<?= site_url('tecnico_admin/perfil') ?>"><i class="fa fa-cog"></i> <span><?= $this->lang->line('perfil'); ?></span></a></li>
</ul>
<!-- /.sidebar-menu -->