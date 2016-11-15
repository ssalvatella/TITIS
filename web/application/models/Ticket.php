<?php

class Ticket extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model('tarea');
    }

    public function obtener_tickets() {
        $this->db->select(' Ticket.*, cliente.nombre as nombre_cliente, usuarioTecnico.usuario as nombre_tecnico_admin');
        $this->db->from('Ticket');
        $this->db->join('Cliente as cliente', 'cliente.id_cliente = Ticket.cliente');
        $this->db->join('Usuario as usuarioTecnico', 'usuarioTecnico.id_usuario = Ticket.tecnico_admin', 'left');
        $consulta = $this->db->get();
        $tickets = $consulta->result_array();
        $resultado = array();
        foreach($tickets as $ticket) {
            $totalTareas = $this->contar_tareas($ticket['id_ticket'], null);
            $tareasCompletadas = $this->contar_tareas($ticket['id_ticket'], TAREA_FINALIZADA);
            if ($totalTareas == 0) {
                $ticket['progreso'] = 0;
            } else {
                $ticket['progreso'] = ($tareasCompletadas/$totalTareas) * 100;
            }
            array_push($resultado, $ticket);
        }
        return $resultado;
    }

    public function obtener_ticket($id_ticket) {
        $this->db->select('*');
        $this->db->from('Ticket');
        $this->db->where('id_ticket', $id_ticket);
        $consulta = $this->db->get();
        return $consulta->result_array();
    }


    /**
     * Devuelve el número de tareas para el ticket y el estado
     * indicados como parámetros. Si el estado de la tarea no
     * es pasado se devuelve el total de todas las tareas.
     * @param $id_ticket
     * @param $estado_tarea
     * @return mixed
     */
    public function contar_tareas($id_ticket, $estado_tarea) {

        $this->db->from('Tarea');
        $this->db->where('ticket' ,$id_ticket);
        if (isset($estado_tarea)) {
            $this->db->where('estado' ,$estado_tarea);
        }
        return $this->db->get()->num_rows();
    }

}
