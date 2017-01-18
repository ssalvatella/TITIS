<?php

class Concepto extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Devuelve el concepto de una factura en particular
     */
    public function obtener_conceptos($id_factura) {
        $this->db->select('Concepto.*');
        $this->db->from('Concepto');
        $this->db->where('factura', $id_factura);
        return $this->db->get()->result_array();
    }

    public function insertar_concepto($datos) {
        return $this->db->insert('Concepto', $datos);
    }

}
