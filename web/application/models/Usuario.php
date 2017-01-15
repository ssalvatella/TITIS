<?php

class Usuario extends CI_Model {

    public function __construct() {
        parent::__construct();
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

    public function obtener_datos($usuario, $devolver_contrasena = FALSE) {
        $this->db->select('*');
        $this->db->from('Usuario');
        $this->db->where('usuario', $usuario);
        $consulta = $this->db->limit(1)->get();

        if ($consulta->num_rows() == 1) {
            $datos_usuario = $consulta->row_array();
            if (!$devolver_contrasena) {
                unset($datos_usuario['contrasena']);
            }
            return $datos_usuario;
        } else {
            return FALSE;
        }
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
            //return $this->encryption->decrypt($consulta->row_array()['contrasena']) == $contrasena;
            $datos_usuario = $consulta->row_array();
            if ($this->encryption->decrypt($datos_usuario['contrasena']) == $contrasena) {
                unset($datos_usuario['contrasena']); // Se elimina la contraseña
                return $datos_usuario;
            }
        }
        return FALSE;
    }
    
    public function obtener_datos_usuario($usuario) {
        $this->db->select('id_usuario, tipo, usuario, email, activo, fecha_registro'); // La contraseña no la devuelve
        $this->db->from('Usuario');
        $this->db->where('id_usuario', $usuario);
        $consulta = $this->db->limit(1)->get();

        if ($consulta->num_rows() == 1) {
            return $consulta->result_array();
        } else {
            return FALSE;
        }
    }

    public function modificar_datos($usuario, $datos) {
        $this->db->where('usuario', $usuario);
        return $this->db->update('Usuario', $datos);
    }

    public function registrar_empleado($datos) {
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
        $this->db->from('Cliente');
        $this->db->where('usuario', $id_usuario)->limit(1);
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

    public function obtener_usuarios($tipo = '') {
        $this->db->select('id_usuario, tipo, usuario, email, activo');
        $this->db->from('Usuario');
        if ($tipo != '') {
            $this->db->where('tipo', $tipo);
        }
        return $this->db->get()->result_array();
    }

    public function obtener_empleados($tipo = '') {
        $this->db->select('*');
        $this->db->from('Usuario');
        $this->db->where('tipo != ', USUARIO_CLIENTE);

        return $this->db->get()->result_array();
    }

}
