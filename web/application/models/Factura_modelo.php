<?php

class Factura_modelo extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('cliente_modelo', 'concepto', 'ticket_modelo'));
    }

    public function obtener_facturas($inicio = 0, $cantidad = 9999) {
        $this->db->select('Factura.*, cliente.nombre as nombre_cliente, Ticket.*, Concepto.*');
        $this->db->from('Factura');
        $this->db->join('Cliente as cliente', 'cliente.id_cliente = Factura.cliente');
        $this->db->join('Ticket', 'Ticket.factura = Factura.id_factura');
        $this->db->join('Concepto', 'Concepto.factura = Factura.id_factura');
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
                . ' Ticket.*');
        $this->db->from('Factura');
        $this->db->where('id_factura', $id_factura);
        $this->db->join('Cliente as cliente', 'cliente.id_cliente = Factura.cliente');
        $this->db->join('Ticket', 'Ticket.factura = Factura.id_factura');
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
        return $this->db->get();
    }
    
    public function facturas_pendientes() {
        $this->db->from('Ticket');
        $this->db->where('factura', NULL);
        $this->db->where('estado', TICKET_FINALIZADO);
        return $this->db->get()->num_rows();
    }

}
