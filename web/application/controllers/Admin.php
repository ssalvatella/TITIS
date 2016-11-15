<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('plantilla');
        $this->load->model('usuario');
        $this->load->model('cliente');
        $this->load->model('tecnico_admin');
        $this->load->model('ticket');
    }

    public function index() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $datos['titulo'] = 'Inicio';
            $datos['total_usuarios']['admin'] = $this->usuario->contar_usuarios(USUARIO_ADMIN);
            $datos['total_usuarios']['tecnico_admin'] = $this->usuario->contar_usuarios(USUARIO_TECNICO_ADMIN);
            $datos['total_usuarios']['tecnico'] = $this->usuario->contar_usuarios(USUARIO_TECNICO);
            $datos['total_usuarios']['cliente'] = $this->usuario->contar_usuarios(USUARIO_CLIENTE);
            $this->plantilla->poner_js(site_url('assets/plugins/chartjs/Chart.min.js'));
            $this->plantilla->mostrar('admin', 'inicio', $datos);
        }
    }

    public function clientes() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $datos['titulo'] = 'Clientes';
            $datos['clientes'] = $this->cliente->obtener_clientes();
            $this->plantilla->poner_js(site_url('assets/plugins/datatables/jquery.dataTables.min.js'));
            $this->plantilla->poner_js(site_url('assets/plugins/datatables/dataTables.bootstrap.min.js'));
            $this->plantilla->poner_css(site_url('assets/plugins/datatables/dataTables.bootstrap.css'));
            $this->plantilla->poner_js(site_url('assets/plugins/datatables/dataTables.responsive.min.js'));
            $this->plantilla->poner_css(site_url('assets/plugins/datatables/responsive.dataTables.min.css'));
            $this->plantilla->mostrar('admin', 'clientes', $datos);
        }
    }

    public function registrar_empleado() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $datos['titulo'] = 'Nuevo Empleado';
            $this->plantilla->mostrar('admin', 'nuevo_empleado', $datos);
        }
    }

    public function registrar_cliente() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $datos['titulo'] = 'Nuevo Cliente';
            $this->plantilla->mostrar('admin', 'nuevo_cliente', $datos);
        }
    }

    public function activar_cliente($id) {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $datos['activo'] = '1';
            $this->usuario->modificar_datos($id, $datos);
            redirect('admin/clientes');
        }
    }

    public function banear_cliente($id) {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $datos['activo'] = '0';
            $this->usuario->modificar_datos($id, $datos);
            redirect('admin/clientes');
        }
    }

    public function tickets() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $datos['titulo'] = 'Tickets';
            $datos['tickets'] = $this->ticket->obtener_tickets();
            $this->plantilla->poner_js(site_url('assets/plugins/datatables/jquery.dataTables.min.js'));
            $this->plantilla->poner_js(site_url('assets/plugins/datatables/dataTables.bootstrap.min.js'));
            $this->plantilla->poner_css(site_url('assets/plugins/datatables/dataTables.bootstrap.css'));
            $this->plantilla->poner_js(site_url('assets/plugins/datatables/dataTables.responsive.min.js'));
            $this->plantilla->poner_css(site_url('assets/plugins/datatables/responsive.dataTables.min.css'));
            $this->plantilla->mostrar('admin', 'tickets', $datos);

        }
    }

    public function obtener_tecnicos_admin() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            print_r($this->tecnico_admin->obtener_tecnicos_admin());
        }
    }


}
