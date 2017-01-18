<?php

class Cliente_modelo extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function obtener_clientes() {
        $this->db->select('*');
        $this->db->from('Cliente');
        $this->db->join('Usuario', 'Usuario.id_usuario = Cliente.usuario');
        $datos = $this->db->get()->result_array();
        foreach ($datos as $clave => $d) {
            unset($d['contrasena']);
            $datos[$clave] = $d;
        }
        return $datos;
    }

    public function obtener_cliente($id_cliente) {
        $this->db->select('*');
        $this->db->from('Cliente');
        $this->db->where('Cliente.id_cliente', $id_cliente);
        $this->db->join('Usuario', 'Usuario.id_usuario = Cliente.usuario');
        $this->db->limit(1);
        $datos = $this->db->get()->row_array();
        unset($datos['contrasena']); // Se elimina la contraseña
        return $datos;
    }

    public function obtener_datos($id_usuario) {
        $this->db->select('*');
        $this->db->from('Cliente');
        $this->db->where('Cliente.usuario', $id_usuario);
        $this->db->join('Usuario', 'Usuario.id_usuario = Cliente.usuario');
        $this->db->limit(1);
        $datos = $this->db->get()->row_array();
        unset($datos['contrasena']); // Se elimina la contraseña
        return $datos;
    }

    public function registrar($datos_usuario, $datos_cliente) {
        $datos_usuario['tipo'] = USUARIO_CLIENTE;
        $datos_usuario['activo'] = 1;
        $this->db->select('*');
        $this->db->from('Usuario');
        $this->db->where('usuario', $datos_usuario['usuario']);
        $this->db->limit(1);
        $consulta = $this->db->get();
        if ($consulta->num_rows() == 0) {
            $datos_usuario ['tipo'] = USUARIO_CLIENTE;
            $this->db->insert('Usuario', $datos_usuario);
            $datos_cliente ['usuario'] = $this->db->insert_id();
            return $this->db->insert('Cliente', $datos_cliente);
        } else {
            // El usuario ya existe
            return FALSE;
        }
    }

    public function modificar_datos($id_cliente, $datos) {
        $this->db->where('id_cliente', $id_cliente);
        return $this->db->update('Cliente', $datos);
    }

    public function obtener_tickets($id_cliente, $numero = null) {
        $this->db->select('id_ticket, titulo, estado, inicio');
        $this->db->from('Ticket');
        $this->db->where('cliente', $id_cliente);
        $this->db->order_by('inicio', 'DESC');
        if (isset($numero)) {
            $this->db->limit($numero);
        }
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

    public function clientes_registrados($dias = 7) {
        $this->db->from('Usuario');
        $this->db->where('fecha_Registro >= ', strtotime('-' . $dias . ' days'));
        $this->db->where('tipo', USUARIO_CLIENTE);
        return $this->db->get()->num_rows();
    }

    public function obtener_id_usuario($id_cliente) {
        $this->db->select('usuario');
        $this->db->from('Cliente');
        $this->db->where('id_cliente', $id_cliente)->limit(1);
        $consulta = $this->db->get();
        if ($consulta->num_rows() == 1) {
            return $consulta->row()->usuario;
        } else {
            return FALSE;
        }
    }

    public function obtener_facturas($id_cliente, $numero = null) {
        $this->db->select('Factura.*, Ticket.*, Concepto.*');
        $this->db->from('Factura');
        $this->db->where('Factura.cliente', $id_cliente);
        $this->db->join('Ticket', 'Ticket.factura = Factura.id_factura', 'left');
        $this->db->join('Concepto', 'Concepto.factura = Factura.id_factura', 'left');
        if (isset($numero)) {
            $this->db->limit($numero);
        }
        $facturas = $this->db->get()->result_array();
        return $facturas;
    }

}
