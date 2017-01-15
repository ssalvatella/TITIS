<?php

class Tecnico_admin_modelo extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function obtener_tecnicos_admin() {
        $this->db->select('id_usuario, tipo, usuario, email, activo', 'fecha_registro');
        $this->db->from('Usuario');
        $this->db->where('tipo = ' . USUARIO_TECNICO_ADMIN);
        $tecnicos_admin = $this->db->get()->result_array();
        foreach ($tecnicos_admin as $clave => $tecnico_admin) {
            $tecnico_admin['tecnicos'] = $this->obtener_tecnicos($tecnico_admin['id_usuario']);
            $tecnicos_admin[$clave] = $tecnico_admin;
        }
        return $tecnicos_admin;
    }

    public function obtener_tecnicos($id_tecnico_admin = '') {
        $this->db->select('id_usuario, tipo, usuario, email, activo, fecha_registro, tecnico_admin');
        $this->db->from('Usuario');
        $this->db->where('tipo', USUARIO_TECNICO);
        if ($id_tecnico_admin != '') {
            $this->db->join('Tecnico', 'Tecnico.id_tecnico = Usuario.id_usuario AND Tecnico.tecnico_admin = ' . $id_tecnico_admin);
            return $this->db->get()->result_array();
        } else {
            $this->db->join('Tecnico', 'Tecnico.id_tecnico = Usuario.id_usuario', 'left');
            $tecnicos = $this->db->get()->result_array();
            foreach ($tecnicos as $clave => $tecnico) {
                $tecnico['nombre_tecnico_admin'] = $this->usuario->obtener_datos_por_id($tecnico['tecnico_admin'])['usuario'];
                $tecnicos[$clave] = $tecnico;
            }

            // Ordena los resultados según los tecnicos admins
            $tecnico_admin = array();
            foreach ($tecnicos as $key => $fila) {
                $tecnico_admin[$key] = $fila['nombre_tecnico_admin'];
            }
            array_multisort($tecnico_admin, SORT_ASC, $tecnicos);

            return $tecnicos;
        }
    }

    public function asignar_tecnicos($id_tecnico_admin, $id_tecnicos) {
        // Se borran primero todos los técnicos que tenía
        $this->db->where('tecnico_admin', $id_tecnico_admin);
        $this->db->delete('Tecnico');
        if ($id_tecnicos != NULL) {
            // Se asignan los nuevos
            foreach ($id_tecnicos as $id_tecnico) {
                $this->db->replace('Tecnico', ['id_tecnico' => $id_tecnico, 'tecnico_admin' => $id_tecnico_admin]);
            }
        }
    }

}
