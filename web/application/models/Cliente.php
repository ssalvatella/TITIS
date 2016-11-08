<?php

class Cliente extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function obtener_clientes() {
        $this->db->select('*');
        $this->db->from('Cliente');
        $this->db->join('Usuario', 'Usuario.id_usuario = Cliente.usuario');
        return $this->db->get()->result_array();
    }

    public function registrar($datos_usuario, $datos_cliente) {
        $datos_usuario['activo'] = 1;
        $this->db->select('*');
        $this->db->from('Usuario');
        $this->db->where('usuario', $datos_usuario['usuario']);
        $this->db->limit(1);
        $consulta = $this->db->get();
        if ($consulta->num_rows() == 0) {
            $datos_usuario ['tipo'] = USUARIO_CLIENTE;
            $this->db->insert('Usuario', $datos_usuario);
            //  $datos_cliente['usuario'] = $this->db->select('*')->from('usuario')->where('nombre', $datos_usuario['nombre'])->limit(1)->get()->row()->id_usuario;
            $datos_cliente ['usuario'] = $this->db->insert_id();
            return $this->db->insert('Cliente', $datos_cliente);
        } else {
            // El usuario ya existe
            return FALSE;
        }
    }

}
