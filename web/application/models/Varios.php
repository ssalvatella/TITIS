<?php

class Varios extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // -- MÉTODOS DE PRUEBA ---

    public function obtener_notificaciones() {
        $this->db->select('*');
        $this->db->from('Notificacion');
        $consulta = $this->db->get();
        //if ($consulta->num_rows() > 1) {
        return $consulta->result_array();
        //} else {
        //return FALSE;
        //}
    }

}
