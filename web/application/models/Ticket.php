<?php

class Ticket extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model('tarea');
    }

    public function obtener_tickets() {
        $this->db->select('Ticket.*, cliente.nombre as nombre_cliente, usuarioTecnico.usuario as nombre_tecnico_admin');
        $this->db->from('Ticket');
        $this->db->join('Cliente as cliente', 'cliente.id_cliente = Ticket.cliente');
        $this->db->join('Usuario as usuarioTecnico', 'usuarioTecnico.id_usuario = Ticket.tecnico_admin', 'left');
        $tickets = $this->db->get()->result_array();
        foreach ($tickets as $clave => $ticket) {
            $total_tareas = $this->tarea->contar_tareas($ticket['id_ticket']);
            $tareas_completadas = $this->tarea->contar_tareas($ticket['id_ticket'], TAREA_FINALIZADA);
            if ($total_tareas == 0) {
                $ticket['progreso'] = 0;
            } else {
                $ticket['progreso'] = ($tareas_completadas / $total_tareas) * 100;
            }
            $tickets[$clave] = $ticket;
        }
        return $tickets;
    }

    public function obtener_ticket($id_ticket) {
        $this->db->select('*');
        $this->db->from('Ticket');
        $this->db->where('id_ticket', $id_ticket);
        $consulta = $this->db->get();
        return $consulta->result_array();
    }

}
