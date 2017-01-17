<?php

class Factura_modelo extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('cliente_modelo', 'concepto', 'ticket_modelo'));
    }

    public function obtener_facturas($inicio = 0, $cantidad = 9999) {
        $this->db->select('Factura.*, cliente.nombre as nombre_cliente, Ticket.*, Concepto.*, Ticket.titulo as nombre_ticket', FALSE);
        $this->db->from('Factura');
        $this->db->join('Cliente as cliente', 'cliente.id_cliente = Factura.cliente', 'left');
        $this->db->join('Ticket', 'Factura.id_factura = Ticket.factura', 'left');
        $this->db->join('Concepto', 'Factura.id_factura = Concepto.factura', 'left');
        $this->db->join('Tarea', 'Tarea.ticket = Ticket.id_ticket', 'left');
        $this->db->limit($cantidad, $inicio);
        return $this->db->get()->result_array();
    }

    public function obtener_factura($id_factura) {
        $this->db->select('Factura.*, cliente.nombre as nombre_cliente, '
                . 'cliente.direccion as direccion_cliente, '
                . 'cliente.localidad as localidad_cliente, '
                . 'cliente.pais as pais_cliente, '
                . 'cliente.cp as cp_cliente, '
                . 'cliente.telefono as telefono_cliente, '
                . 'cliente.email_opcional as email_cliente,'
                . ' Ticket.titulo as nombre_ticket, SUM(Tarea.precio) AS precio_tareas, SUM(Concepto.precio) AS precio_conceptos,');
        $this->db->from('Factura');
        $this->db->where('id_factura', $id_factura);
        $this->db->join('Cliente as cliente', 'cliente.id_cliente = Factura.cliente');
        $this->db->join('Ticket', 'Ticket.factura = Factura.id_factura');
        $this->db->join('Concepto', 'Factura.id_factura = Concepto.factura', 'left');
        $this->db->join('Tarea', 'Tarea.ticket = Ticket.id_ticket', 'left');
        $consulta = $this->db->get();
        return $consulta->row_array();
    }
    
    public function obtener_tareas($id_factura) {
        $this->db->select('Tarea.*');
        $this->db->from('Ticket');
        $this->db->where('id_factura', $id_factura);
        $this->db->join('Factura', 'Factura.id_factura = Ticket.factura');
        $this->db->join('Tarea', 'Tarea.ticket = Ticket.id_ticket');
        return $this->db->get()->result_array();
    }
    
    public function sumar_precios($id_factura) {
        $this->db->select_sum('Tarea.precio');
        //$this->db->select('Tarea.precio');
        $this->db->from('Ticket');
        $this->db->where('id_factura', $id_factura);
        $this->db->join('Factura', 'Factura.id_factura = Ticket.factura');
        $this->db->join('Tarea', 'Tarea.ticket = Ticket.id_ticket');
        return $this->db->get()->row()->precio;
    }
    
    public function facturas_pendientes() {
        $this->db->from('Ticket');
        $this->db->where('factura', NULL);
        $this->db->where('estado', TICKET_FINALIZADO);
        return $this->db->get()->num_rows();
    }

    public function obtener_facturacion($tiempo, $año = '') {

        $this->db->select('SUM(Tarea.precio) AS precio_tareas, SUM(Concepto.precio) AS precio_conceptos, Factura.*, Ticket.*, Tarea.*, Concepto.*', FALSE);
        $this->db->from('Factura');
        if ($año == '') {
            $año = 'Y';
        }
        switch ($tiempo) {
            case "mensual":
                $this->db->where('Factura.fecha > ', date($año . '-m-01'));
                $this->db->where('Factura.fecha < ', date($año . '-m-31'));
                break;
            case "trimestral":
                $mes = date('n');
                if ($mes >= 1 AND $mes <= 3 ) {
                    $this->db->where('Factura.fecha > ', date($año . '-01-01'));
                    $this->db->where('Factura.fecha < ', date($año . '-03-31'));
                } else if ($mes >= 4 AND $mes <= 6) {
                    $this->db->where('Factura.fecha > ', date($año . '-04-01'));
                    $this->db->where('Factura.fecha < ', date($año . '-06-31'));
                } else if ($mes >= 7 AND $mes <= 9) {
                    $this->db->where('Factura.fecha > ', date($año . '-07-01'));
                    $this->db->where('Factura.fecha < ', date($año . '-09-31'));
                } else {
                    $this->db->where('Factura.fecha > ', date($año . '-10-01'));
                    $this->db->where('Factura.fecha < ', date($año . '-12-31'));
                }

                break;
            case "anual":
                $this->db->where('Factura.fecha > ', date($año . '-01-01'));
                $this->db->where('Factura.fecha < ', date($año . '-12-31'));
                break;
        }
        $this->db->join('Ticket', 'Factura.id_factura = Ticket.factura', 'left');
        $this->db->join('Concepto', 'Factura.id_factura = Concepto.factura', 'left');
        $this->db->join('Tarea', 'Tarea.ticket = Ticket.id_ticket', 'left');
        $consulta = $this->db->get()->result_array();
        return $consulta[0]['precio_tareas'] + $consulta[0]['precio_conceptos'];
    }

    public function crear_factura($datos) {
        $factura = [
            'descripcion' => $datos['descripcion'],
            'cliente' => $datos['cliente'],
            'ticket' => $datos['ticket'],
            'iva' => $datos['iva']
        ];
        
        //insertamos la factura
        if ($this->db->insert('Factura', $factura)) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }
    }
    
    public function eliminar_factura($id_factura) {
        $this->db->where('id_factura', $id_factura);
        return $this->db->delete('Factura');
    }
}
