<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('plantilla');
        $this->load->model(array('cliente_modelo', 'usuario', 'ticket_modelo', 'notificacion', 'mensaje'));
    }

    public function index() {
        if ($this->usuario_permitido(USUARIO_CLIENTE)) {
            $id_cliente = $this->session->userdata('id_cliente');
            $datos['titulo'] = 'Inicio';
            $datos['tickets'] = $this->cliente_modelo->obtener_tickets($id_cliente, 7);
            $this->plantilla->poner_js(site_url('assets/plugins/chartjs/Chart.min.js'));
            $this->plantilla->mostrar('cliente', 'inicio', $datos);
        }
    }

    public function crear_ticket($datos = null) {
        if ($this->usuario_permitido(USUARIO_CLIENTE)) {
            $datos['titulo'] = 'Crear Ticket';
            $this->plantilla->poner_js(site_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'));
            $this->plantilla->poner_js(site_url('assets/plugins/fastclick/fastclick.js'));
            $this->plantilla->poner_css(site_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css'));
            $this->plantilla->mostrar('cliente', 'crear_ticket', $datos);
        }
    }

    public function enviar_ticket() {
        if ($this->usuario_permitido(USUARIO_CLIENTE)) {

            $datosTicket = array('titulo' => $this->input->post('titulo'),
                'mensaje' => $this->input->post('mensaje'),
            );

            if ($this->ticket_modelo->registrar_ticket($datosTicket)) {
                $datos['enviado'] = 1;
            } else {
                $datos['error'] = 1;
            }
            $this->crear_ticket($datos);
            // AQUÍ SE TENDRÁ QUE SUBIR EL ARCHIVO ----------------------
        }
    }

}
