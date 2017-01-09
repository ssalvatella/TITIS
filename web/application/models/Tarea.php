<?php

class Tarea extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('ticket_modelo'));
    }

    /**
     * Devuelve el número de tareas para el ticket y el estado
     * indicados como parámetros. Si el estado de la tarea no
     * es pasado se devuelve el total de todas las tareas.
     * @param $id_ticket
     * @param $estado_tarea
     * @return mixed
     */
    public function contar_tareas($id_ticket, $estado_tarea = null) {
        $this->db->from('Tarea');
        $this->db->where('ticket', $id_ticket);
        if (isset($estado_tarea)) {
            $this->db->where('estado', $estado_tarea);
        }
        return $this->db->get()->num_rows();
    }

    public function obtener_tareas($id_ticket) {
        $this->db->select('Tarea.*, usuario.usuario as nombre_tecnico');
        $this->db->from('Tarea');
        $this->db->where('ticket', $id_ticket);
        $this->db->join('Usuario as usuario', 'usuario.id_usuario = Tarea.tecnico', 'left');
        return $this->db->get()->result_array();
    }
    public function obtener_tareas_tecnico($id_tecnico) {
        $this->db->select('Tarea.*, usuario.usuario as nombre_tecnico');
        $this->db->from('Tarea');
        $this->db->where('tecnico', $id_tecnico);
        $this->db->where('fin', NULL);
        $this->db->join('Usuario as usuario', 'usuario.id_usuario = Tarea.tecnico', 'left');
        return $this->db->get()->result_array();
    }

    public function crear_tarea($datos) {
        $datos['estado'] = TAREA_EN_PROCESO;
        return $this->db->insert('Tarea', $datos);
    }

    public function editar_tarea($id_tarea, $datos) {
        $this->db->where('id_tarea', $id_tarea);
        return $this->db->update('Tarea', $datos);
    }

    public function borrar_tarea($id_tarea) {
        $this->db->where('id_tarea', $id_tarea);
        return $this->db->delete('Tarea');
    }

    public function completar_tarea($id_tarea) {
        $datos = array('estado' => TAREA_FINALIZADA);
        $this->db->where('id_tarea', $id_tarea);
        return $this->db->update('Tarea', $datos);
    }

    public function descompletar_tarea($id_tarea) {
        $datos = array('estado' => TAREA_EN_PROCESO);
        $this->db->where('id_tarea', $id_tarea);
        return $this->db->update('Tarea', $datos);
    }

    public function tareas_finalizadas($dias = 7) {
        $this->db->from('Tarea');
        $this->db->where('fin >= ', strtotime('-' . $dias . ' days'));
        $this->db->where('estado', TAREA_FINALIZADA);
        return $this->db->get()->num_rows();
    }

    public function obtener_suma_precios($id_ticket) {
        $this->db->from('Tarea');
        $this->db->where('ticket', $id_ticket);
    }

}
