<?php

class Ticket extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function obtener_tickets() {
        $this->db->select('*');
        $this->db->from('Ticket');
        $consulta = $this->db->get();
        return $consulta->result_array();
    }

    public function obtener_ticket($id_ticket) {
        $this->db->select('*');
        $this->db->from('Ticket');
        $this->db->where('id_ticket', $id_ticket);
        $consulta = $this->db->get();
        return $consulta->result_array();
    }

}
