<?php

class Ticket_modelo extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('tarea', 'archivo'));
    }

    public function obtener_tickets($inicio = 0, $cantidad = 9999) {
        $this->db->select('Ticket.*, cliente.nombre as nombre_cliente, usuarioTecnico.usuario as nombre_tecnico_admin');
        $this->db->from('Ticket');
        $this->db->join('Cliente as cliente', 'cliente.id_cliente = Ticket.cliente');
        $this->db->join('Usuario as usuarioTecnico', 'usuarioTecnico.id_usuario = Ticket.tecnico_admin', 'left');
        $this->db->limit($cantidad, $inicio);
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

    public function obtener_ultimos_tickets($numero = 10) {
        $this->db->select('Ticket.*, cliente.nombre as nombre_cliente, usuarioTecnico.usuario as nombre_tecnico_admin');
        $this->db->from('Ticket');
        $this->db->join('Cliente as cliente', 'cliente.id_cliente = Ticket.cliente');
        $this->db->join('Usuario as usuarioTecnico', 'usuarioTecnico.id_usuario = Ticket.tecnico_admin', 'left');
        $this->db->order_by('inicio', 'DESC');
        $tickets = $this->db->limit($numero)->get()->result_array();
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
        $this->db->select('Ticket.*, cliente.nombre as nombre_cliente, usuarioTecnico.usuario as nombre_tecnico_admin');
        $this->db->from('Ticket');
        $this->db->where('id_ticket', $id_ticket);
        $this->db->join('Cliente as cliente', 'cliente.id_cliente = Ticket.cliente');
        $this->db->join('Usuario as usuarioTecnico', 'usuarioTecnico.id_usuario = Ticket.tecnico_admin', 'left');
        $consulta = $this->db->get();
        return $consulta->result_array();
    }

    public function contar_tickets_estado($estado) {
        $this->db->from('Ticket');
        $this->db->where('estado', $estado);
        return $this->db->get()->num_rows();
    }

    public function registrar_ticket($datos) {
        $id_cliente = $this->session->userdata('id_cliente');
        $id_usuario_cliente = $this->session->userdata('id_usuario');

        $ticket = array('titulo' => $datos['titulo'],
            'cliente' => $id_cliente,
            'inicio' => date("Y-m-d H:i:s"),
            'estado' => TICKET_PENDIENTE
        );

        // Se inserta el ticket
        if ($this->db->insert('Ticket', $ticket)) {
            $id_ticket = $this->db->insert_id();

            $mensaje = array('ticket' => $id_ticket,
                'usuario' => $id_usuario_cliente,
                'fecha' => date("Y-m-d H:i:s"),
                'texto' => $datos['mensaje']
            );

            // Se inserta el mensaje
            if ($this->db->insert('Mensaje', $mensaje)) {
                $id_mensaje = $this->db->insert_id();
                return true;
            }
        }
    }

    public function asignar_ticket($id_ticket, $id_tecnico_admin) {
        $datos = array('tecnico_admin' => $id_tecnico_admin);
        $this->db->where('id_ticket', $id_ticket);
        return $this->db->update('Ticket', $datos);
    }

    public function eliminar_ticket($id_ticket) {
        $this->db->where('id_ticket', $id_ticket);
        return $this->db->delete('Ticket');
    }

}
