<?php

class Mensaje extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function obtener_mensajes($id_ticket) {
        $this->db->select('Mensaje.*, usuario.usuario as nombre_usuario');
        $this->db->from('Mensaje');
        $this->db->where('ticket', $id_ticket);
        $this->db->join('Usuario as usuario', 'Mensaje.usuario = usuario.id_usuario', 'left');
        $this->db->order_by('fecha', 'ASC');
        return $this->db->get()->result_array();
    }

    public function registrar_mensaje($datos) {
        return $this->db->insert('Mensaje', $datos);
    }

    public function contar_mensajes_usuario($id_usuario) {
        $this->db->from('Mensaje');
        $this->db->where('usuario', $id_usuario);
        return $this->db->get()->num_rows();
    }


}