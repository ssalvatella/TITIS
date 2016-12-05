<?php

class Archivo extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function registrar_archivo($datos) {
        return $this->db->insert('Archivo', $datos);
    }

    public function obtener_archivo($id_mensaje) {
        $this->db->select('*');
        $this->db->from('Archivo');
        $this->db->where('Archivo.mensaje', $id_mensaje);
        $this->db->limit(1);
        $datos = $this->db->get()->row_array();
        return $datos;
    }

}
