<?php

class Tecnico_admin_modelo extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function obtener_tecnicos_admin() {
        $this->db->select('*');
        $this->db->from('Usuario');
        $this->db->where('tipo = ' . USUARIO_TECNICO_ADMIN);
        $resultado = $this->db->get()->result_array();
        return $resultado;
    }

    public function obtener_tecnicos($id_tecnico_admin) {
        $this->db->select('id_usuario, tipo, usuario, email, activo');
        $this->db->from('Usuario');
        $this->db->where('tipo', USUARIO_TECNICO);
        $this->db->join('Tecnico', 'Tecnico.id_tecnico = Usuario.id_usuario AND Tecnico.tecnico_admin = ' . $id_tecnico_admin);

        return $this->db->get()->result_array();
    }

}
