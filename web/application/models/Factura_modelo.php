<?php

class Factura_modelo extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->model(array('cliente_modelo', 'concepto', 'ticket_modelo'));     
    }
    
    public function obtener_facturas($inicio = 0, $cantidad = 9999) {
        $this->db->select('Factura.*, cliente.nombre as nombre_cliente');
        $this->db->from('Factura');
        $this->db->join('Cliente as cliente', 'cliente.id_cliente = Factura.cliente');
        $this->db->limit($cantidad, $inicio);
        $facturas = $this->db->get()->result_array();
        foreach ($facturas as $clave => $factura) {
            $factura['ticket'] = $this->ticket_modelo->obtener_ticket_factura($factura['id_factura']);
            $factura['precio'] = $this->concepto->obtener_concepto($factura['id_factura']);
            $facturas[$clave] = $factura;
            
        }
        return $facturas;
    }
    
    public function obtener_factura($id_factura) {
        $this->db->select('Factura.*, cliente.nombre as nombre_cliente');
        $this->db->from('Factura');
        $this->db->where('id_factura', $id_factura);
        $this->db->join('Cliente as cliente', 'cliente.id_cliente = Factura.cliente');
        $consulta = $this->db->get();
        return $consulta->result_array();
    }
}
