<?php

class Concepto extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Devuelve el concepto de una factura en particular
     */
    public function obtener_concepto($id_factura) {
        $this->db->select('precio');
        $this->db->from('Concepto');
        $this->db->where('factura', $id_factura)->limit(1);
        return $this->db->get()->row_array();
    }

}
