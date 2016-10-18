<?php

class Usuario extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function login($datos = array()) {
        $consulta = $this->db->get_where('usuario', $datos, 1);
        return $consulta->row_array();
    }

}
