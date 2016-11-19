<?php

class Cliente_Modelo extends CI_Model {

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

    public function modificar_datos($cliente, $datos) {
        $this->db->where('id_cliente', $cliente);
        return $this->db->update('Cliente', $datos);
    }

    public function obtener_ultimos_tickets($id_cliente, $numero) {
        $this->db->select('id_ticket, titulo, estado, inicio');
        $this->db->from('Ticket');
        $this->db->where('cliente', $id_cliente);
        $this->db->order_by('inicio', 'DESC');
        $this->db->limit($numero);
        return $this->db->get()->result_array();
    }

}
