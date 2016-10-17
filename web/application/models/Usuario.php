<?php

class Usuario extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function login($datos) {
        $this->db->where('usuario', $datos);
        $this->db->limit(1);
        $consulta = $this->db->get();

        return $consulta->num_rows() == 1;
    }

}
