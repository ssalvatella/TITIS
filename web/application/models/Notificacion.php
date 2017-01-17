<?php

class Notificacion extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function obtener_notificaciones($id_usuario) {
        $this->db->select('*');
        $this->db->from('Notificacion');
        $this->db->join('Destinatario_notificacion as dn', 'dn.notificacion = Notificacion.id_notificacion');
        $this->db->where('usuario', $id_usuario);
        $this->db->order_by('fecha', 'ASC');
        return $this->db->get()->result_array();
    }

    public function borrar_notificacion($id_notificacion, $id_usuario) {
        $this->db->where('notificacion', $id_notificacion);
        $this->db->where('usuario', $id_usuario);
        return $this->db->delete('Destinatario_notificacion');
    }

    public function insertar_notificacion_admins($id_usuario, $datos) {
        $datos['fecha'] = date("Y-m-d H:i:s");
        if ($this->db->insert('Notificacion', $datos)) {
            $id_notificacion = $this->db->insert_id();
            $this->db->from('Usuario');
            $this->db->where('tipo', USUARIO_ADMIN);
            $this->db->where('id_usuario !=', $id_usuario);
            $admins = $this->db->get()->result_array();
            foreach ($admins as $a) {
                $datos_dn = [
                    'notificacion' => $id_notificacion,
                    'usuario' => $a['id_usuario']
                ];
                $this->db->insert('Destinatario_notificacion', $datos_dn);
            }
        }
    }

    public function insertar_notificacion_cliente($id_cliente, $datos) {
        $datos['fecha'] = date("Y-m-d H:i:s");
        if ($this->db->insert('Notificacion', $datos)) {
            $id_notificacion = $this->db->insert_id();
            $datos_dn = [
                'notificacion' => $id_notificacion,
                'usuario' => $this->cliente_modelo->obtener_cliente($id_cliente)['id_usuario']
            ];
            $this->db->insert('Destinatario_notificacion', $datos_dn);
        }
    }

}
