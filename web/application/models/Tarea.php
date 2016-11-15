<?php

class Tarea extends CI_Model {

    public function __construct() {
        parent::__construct();
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

}
