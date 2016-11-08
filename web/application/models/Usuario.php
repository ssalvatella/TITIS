<?php

class Usuario extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function login($usuario, $contrasena) {
        $datos = array('usuario' => $usuario);
        $consulta = $this->db->get_where('Usuario', $datos, 1);
        if ($consulta->num_rows() == 1) {
            $this->load->library('encryption');
            $this->encryption->initialize(
                    array(
                        'cipher' => 'aes-256',
                        'mode' => 'ctr',
                        'key' => config_item('encryption_key')
                    )
            );
            return $this->encryption->decrypt($consulta->row_array()['contrasena']) == $contrasena;
        } else {
            return FALSE;
        }
    }

    public function obtener_id($usuario) {
        $datos = array('usuario' => $usuario);
        $consulta = $this->db->get_where('Usuario', $datos, 1);
        if ($consulta->num_rows() == 1) {
            return $consulta->row()->id_usuario;
        } else {
            return FALSE;
        }
    }

    public function obtener_datos($usuario) {
        $datos = array('usuario' => $usuario);
        $consulta = $this->db->get_where('Usuario', $datos, 1);
        if ($consulta->num_rows() == 1) {
            return $consulta->row_array();
        } else {
            return FALSE;
        }
    }

    public function modificar_datos($usuario, $datos) {
        $this->db->where('usuario', $usuario);
        return $this->db->update('Usuario', $datos);
    }

    public function registrar($datos) {
        $datos['activo'] = 1;
        $this->db->select('*');
        $this->db->from('Usuario');
        $this->db->where('usuario', $datos['usuario']);
        $this->db->limit(1);
        $consulta = $this->db->get();
        if ($consulta->num_rows() == 0) {
            return $this->db->insert('Usuario', $datos);
        } else {
            // El usuario ya existe
            return FALSE;
        }
    }

    public function obtener_id_cliente($id_usuario) {
        $this->db->select('id_cliente');
        $this->db->from('cliente');
        $this->db->join('Usuario', 'Usuario.id_usuario = Cliente.usuario');
        $this->db->where('Usuario.id_usuario', $id_usuario)->limit(1);
        $consulta = $this->db->get();
        if ($consulta->num_rows() == 1) {
            return $consulta->row()->id_cliente;
        } else {
            return FALSE;
        }
    }

    public function contar_usuarios($tipo) {
        $this->db->from('Usuario');
        $this->db->where('tipo', $tipo);
        return $this->db->get()->num_rows();
    }

}
