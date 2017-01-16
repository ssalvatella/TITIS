<?php

class Ticket_modelo extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('tarea', 'factura_modelo', 'cliente_modelo'));
    }

    public function obtener_tickets($inicio = 0, $cantidad = 9999, $id_cliente = '', $id_tecnico_admin = '') {
        $this->db->select('Ticket.*, cliente.nombre as nombre_cliente, usuarioTecnico.usuario as nombre_tecnico_admin');
        $this->db->from('Ticket');
        if ($id_cliente != '') {
            $this->db->where('Ticket.cliente', $id_cliente);
        }
        if ($id_tecnico_admin != '') {
             $this->db->where('Ticket.tecnico_admin', $id_tecnico_admin);
        }
        $this->db->join('Cliente as cliente', 'cliente.id_cliente = Ticket.cliente', 'left');
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
            $ticket['total_tareas'] = $total_tareas;
            $ticket['tareas_completadas'] = $tareas_completadas;
            $tickets[$clave] = $ticket;
        }
        return $tickets;
    }

    public function obtener_tickets_tecnico($inicio = 0, $cantidad = 9999, $id_tecnico) {
        $this->db->select('Ticket.* , cliente.nombre as nombre_cliente, usuarioTecnico.usuario as nombre_tecnico_admin');
        $this->db->from('Ticket');
        $this->db->join('Cliente as cliente', 'cliente.id_cliente = Ticket.cliente', 'left');
        $this->db->join('Usuario as usuarioTecnico', 'usuarioTecnico.id_usuario = Ticket.tecnico_admin', 'left');
        $this->db->join('Tarea as tarea', 'Ticket.id_ticket = tarea.ticket', 'left');
        $this->db->join('Usuario as tecnico', 'tarea.tecnico = tecnico.id_usuario AND tarea.tecnico = ' . $id_tecnico);
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
            $ticket['total_tareas'] = $total_tareas;
            $ticket['tareas_completadas'] = $tareas_completadas;
            $tickets[$clave] = $ticket;
        }
        return $tickets;
    }

    public function obtener_tickets_tecnico_admin($id_tecnico_admin) {
        $this->db->select('Ticket.*, cliente.nombre as nombre_cliente, usuarioTecnico.usuario as nombre_tecnico_admin');
        $this->db->from('Ticket');
        if ($id_tecnico_admin != '') {
            $this->db->where('Ticket.tecnico_admin', $id_tecnico_admin);
        }
        $this->db->join('Cliente as cliente', 'cliente.id_cliente = Ticket.cliente', 'left');
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
            $ticket['total_tareas'] = $total_tareas;
            $ticket['tareas_completadas'] = $tareas_completadas;
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
        $this->db->select('Ticket.*, cliente.*,cliente.nombre as nombre_cliente, usuarioTecnico.usuario as nombre_tecnico_admin');
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

    public function contar_tickets_cliente($id_cliente) {
        $this->db->from('Ticket');
        $this->db->where('cliente', $id_cliente);
        return $this->db->get()->num_rows();
    }

    public function registrar_ticket($datos) {
        $ticket = [
            'titulo' => $datos['titulo'],
            'cliente' => $datos['cliente'],
            'inicio' => date("Y-m-d H:i:s"),
            'estado' => TICKET_PENDIENTE
        ];

        // Se inserta el ticket
        if ($this->db->insert('Ticket', $ticket)) {
            $id_ticket = $this->db->insert_id();

            $mensaje = [
                'ticket' => $id_ticket,
                'usuario' => $this->cliente_modelo->obtener_id_usuario($datos['cliente']),
                'fecha' => date("Y-m-d H:i:s"),
                'texto' => $datos['mensaje']
            ];

            // Se inserta el mensaje
            if ($this->db->insert('Mensaje', $mensaje)) {
                return $this->db->insert_id();
            }
        } else {
            return FALSE;
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

    public function comprobar_estado($id_ticket) {
        $this->db->select('*');
        $this->db->from('Ticket');
        $this->db->where('id_ticket', $id_ticket);
        $ticket = $this->db->limit(1)->get()->result_array()[0];
        $total_tareas = $this->tarea->contar_tareas($id_ticket);
        $tareas_completadas = $this->tarea->contar_tareas($id_ticket, TAREA_FINALIZADA);
        $datos['estado'] = $ticket['estado'];
        if ($tareas_completadas == $total_tareas) {
            $datos['estado'] = TICKET_FINALIZADO;
            $datos['fin'] = date('Y-m-d H:i:s');
        } else if (isset($ticket['tecnico_admin'])) {
            $datos['estado'] = TICKET_EN_PROCESO;
        } else {
            $datos['estado'] = TICKET_PENDIENTE;
        }
        $this->db->where('id_ticket', $id_ticket);
        return $this->db->update('Ticket', $datos);
    }

}
