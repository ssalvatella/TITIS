<?php


class Cliente extends CI_Model  {

    public function __construct() {
        parent::__construct();
    }


    public function obtener_clientes() {

        $this->db->select('*');
        $this->db->from('Cliente');
        $this->db->join('Usuario', 'Usuario.id_usuario = Cliente.usuario');
        return  $this->db->get()->result_array;
    }

}