<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('security'); // form_validation -> xss_clean
        $this->load->helper('descarga'); // No se usa download porque no se puede cambiar el nombre del fichero cuando se descarga
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
            $datos['titulo'] = $this->lang->line('crear_ticket');
            $this->plantilla->poner_js(site_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'));
            $this->plantilla->poner_js(site_url('assets/plugins/fastclick/fastclick.js'));
            $this->plantilla->poner_css(site_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css'));
            $this->plantilla->mostrar('cliente', 'crear_ticket', $datos);
        }
    }

    public function enviar_ticket() {
        if ($this->usuario_permitido(USUARIO_CLIENTE)) {
            $datos_ticket = [
                'titulo' => $this->input->post('titulo'),
                'mensaje' => $this->input->post('mensaje'),
            ];

            if ($this->ticket_modelo->registrar_ticket($datos_ticket)) {
                $datos['enviado'] = 1;
                $id_mensaje = $this->db->insert_id();
                if (!$this->upload->do_upload('archivo')) {
                    // No se ha podido subir el archivo
                    // Aquí habría que borrar el mensaje
                    // $upload_error = array('error' => $this->upload->display_errors());
                } else {
                    $datos_upload = $this->upload->data();
                    $datos_archivo = [
                        'mensaje' => $id_mensaje,
                        'nombre' => $datos_upload['file_name'],
                        'nombre_original' => $datos_upload['orig_name'],
                        'tamano' => $datos_upload['file_size']
                    ];
                    $this->archivo->registrar_archivo($datos_archivo);
                }
            } else {
                $datos['error'] = 1;
            }
            $this->crear_ticket($datos);
        }
    }

    public function tickets() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $datos['titulo'] = $this->lang->line('tickets');
            $id_cliente = $this->session->userdata('id_cliente');
            $datos['tickets'] = $this->ticket_modelo->obtener_tickets($id_cliente = $id_cliente);
            $this->plantilla->poner_js(site_url('assets/plugins/datatables/jquery.dataTables.min.js'));
            $this->plantilla->poner_js(site_url('assets/plugins/datatables/dataTables.bootstrap.min.js'));
            $this->plantilla->poner_css(site_url('assets/plugins/datatables/dataTables.bootstrap.css'));
            $this->plantilla->poner_js(site_url('assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js'));
            $this->plantilla->poner_css(site_url('assets/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css'));
            $this->plantilla->mostrar('cliente', 'tickets', $datos);
        }
    }

}
