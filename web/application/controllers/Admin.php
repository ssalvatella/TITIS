<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends My_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('plantilla');
        $this->load->model('usuario');
        $this->load->model('cliente');
    }

    public function index() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $datos['titulo'] = 'Inicio';
            $this->plantilla->mostrar('admin', 'inicio', $datos);
        }
    }

    public function clientes() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $datos['titulo'] = 'Ver Clientes';
            $datos['clientes'] = $this->cliente->obtener_clientes();
            $this->plantilla->poner_js(site_url('assets/plugins/datatables/jquery.dataTables.min.js'));
            $this->plantilla->poner_js(site_url('assets/plugins/datatables/dataTables.bootstrap.min.js'));
            $this->plantilla->poner_css(site_url('assets/plugins/datatables/dataTables.bootstrap.css'));
            $this->plantilla->poner_js(site_url('assets/plugins/bootstrap-jasny/js/jasny-bootstrap.min.js'));
            $this->plantilla->poner_css(site_url('assets/plugins/bootstrap-jasny/css/jasny-bootstrap.min.css'));
            $this->plantilla->mostrar('admin','clientes',$datos);
        }
    }



}
