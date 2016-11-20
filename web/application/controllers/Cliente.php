<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('plantilla');
        $this->load->model(array('Cliente_Modelo', 'usuario', 'ticket'));

        $config['max_size'] = '100';
        $config['upload_path'] = './uploads/';
        $this->load->library('upload', $config);
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

            if ($this->ticket->registrar_ticket($datosTicket)) {
                $datos['enviado'] = 1;
            } else {
                $datos['error'] = 1;
            }
            $this->crear_ticket($datos);
            // AQUÍ SE TENDRÁ QUE SUBIR EL ARCHIVO ----------------------
//            if($this->upload->do_upload('fichero')) {
//
//                print_r('Subido');
//                $datos = $this->upload->data('fichero');
////                $datosArchivo = array(
////                    'mensaje' => $id_mensaje,
////                    'nombre' => $datos['file_name'],
////                    'nombre_original '=> $datos['file_name']
////                );
////
////                $this->db->insert('Archivo', $datosArchivo);
//            } else {
//                print_r($this->upload->display_errors());
//                print_r($_FILES);
//                print_r($_POST);
//            }
        }

        // ------------------------------------------------------------
    }

}
