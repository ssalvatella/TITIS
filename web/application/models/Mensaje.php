<?php

class Mensaje extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function obtener_mensajes($id_ticket) {
        $this->db->from('Mensaje');
        $this->db->where('ticket', $id_ticket);
        $this->db->order_by('fecha', 'ASC');
        return $this->db->get()->result_array();
    }


}