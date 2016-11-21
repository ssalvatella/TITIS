<?php

class Ticket extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('plantilla');
        $this->load->model(array('ticket_modelo', 'mensaje'));
    }

    public function enviar_mensaje($id_ticket) {

        $datosMensaje = array('ticket' => $id_ticket,
                'texto' => $this->input->post('mensaje'),
                'usuario' => $this->session->userdata('id_usuario'),
                'fecha' => date("Y-m-d H:i:s")
            );

        if ($this->mensaje->registrar_mensaje($datosMensaje)) {
            $datos['enviado'] = 1;
        } else {
            $datos['error'] = 1;
        }
        redirect('admin/ver_ticket/' . $id_ticket);
    }

}