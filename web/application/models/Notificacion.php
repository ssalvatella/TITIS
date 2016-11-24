<?php

class Notificacion extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function obtener_notificaciones($id_usuario) {
        $datos = array('usuario' => $id_usuario);
        $consulta = $this->db->get_where('Notificacion', $datos);
        return $consulta->result_array();
    }

    public function insertar_notificacion($datos) {
        $datos['vista'] = 0;
        $datos['fecha'] = date("Y-m-d H:i:s");
        return $this->db->insert('Notificacion', $datos);
    }

    public function marcar_como_vista($id_notificacion) {
        $this->db->where('id_notificacion', $id_notificacion);
        return $this->db->update('Usuario', array('vista' => NOTIFICACION_VISTA));
    }

}
