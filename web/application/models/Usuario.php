<?php

class Usuario extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function login($usuario, $contrasena) {
        $datos = array('nombre' => $usuario);
        $consulta = $this->db->get_where('Usuario', $datos, 1);
        if ($consulta->num_rows() == 1) {
            return $this->encryption->decrypt($consulta->row_array()['contrasena']) == $contrasena;
        } else {
            return FALSE;
        }
    }

    public function obtener_id($usuario) {
        $datos = array('nombre' => $usuario);
        $consulta = $this->db->get_where('Usuario', $datos, 1);
        if ($consulta->num_rows() == 1) {
            return $consulta->row()->id_usuario;
        } else {
            return FALSE;
        }
    }

    public function obtener_datos($usuario) {
        $datos = array('nombre' => $usuario);
        $consulta = $this->db->get_where('Usuario', $datos, 1);
        if ($consulta->num_rows() == 1) {
            return $consulta->row_array();
        } else {
            return FALSE;
        }
    }

}
