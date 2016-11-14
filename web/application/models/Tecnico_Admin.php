<?php



class Tecnico_Admin extends CI_Model {

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


}