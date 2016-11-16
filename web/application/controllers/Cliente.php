<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('plantilla');
        $this->load->model('cliente_modelo');
        $this->load->model('usuario');
    }

    public function index() {
        if ($this->usuario_permitido(USUARIO_CLIENTE)) {
            $id_cliente = $this->session->userdata('id_cliente');
            $datos['titulo'] = 'Inicio';
            $datos['tickets'] = $this->cliente_modelo->obtener_ultimos_tickets($id_cliente, 7);
            $this->plantilla->poner_js(site_url('assets/plugins/chartjs/Chart.min.js'));
            $this->plantilla->mostrar('cliente', 'inicio', $datos);
        }
    }





}
