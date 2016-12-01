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

    public function contar_comentarios_usuario($id_usuario) {
        $this->db->from('Mensaje');
        $this->db->where('usuario', $id_usuario);
        $this->db->where('ticket !=', 'NULL');
        return $this->db->get()->num_rows();
    }

    public function contar_mensajes_no_vistos($id_usuario) {
        $this->db->from('Mensaje');
        $this->db->where('usuario', $id_usuario);
        $this->db->where('ticket ');
        $this->db->where('visto', '0');
        return $this->db->get()->num_rows();
    }

    public function ver_mensajes_privados($id_usuario, $no_vistos = null) {
        $this->db->select('Mensaje.*, emisor.usuario as nombre_emisor, emisor.*');
        $this->db->from('Mensaje');
        $this->db->where('destinatario', $id_usuario);

        if (isset($no_vistos)) {
            $this->db->where('visto', '0');
        }
        $this->db->join('Usuario as emisor', 'emisor.id_usuario = Mensaje.usuario', 'left');
        return $this->db->get()->result_array();
    }

    public function obtener_mensaje($id_mensaje) {
        $this->db->select('Mensaje.*, emisor.usuario as nombre_emisor, emisor.*');
        $this->db->from('Mensaje');
        $this->db->where('id_mensaje', $id_mensaje);
        $this->db->join('Usuario as emisor', 'Mensaje.usuario = emisor.id_usuario', 'left');
        $this->db->join('Archivo as archivo', 'Mensaje.id_mensaje = archivo.mensaje', 'left');
        return $this->db->get()->result_array();
    }


}