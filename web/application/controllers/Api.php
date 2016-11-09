<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Api extends REST_Controller {

    /**
     * --- GET ---
     * usuario
     * usuarios
     * total_usuarios
     * clientes
     * cliente
     * 
     * --- POST ---
     * login
     * registrar_empleado
     * registrar_cliente
     */
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('usuario');
        $this->load->model('cliente');

        // $this->methods['login_get']['limit'] = 5;
    }

    public function login_post() {
        $usuario = $this->post('usuario');
        $contrasena = $this->post('contrasena');
        if (!$usuario || !$contrasena) {
            $this->response([
                'status' => FALSE,
                'error' => 'Se necesita el campo usuario y contrasena'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if (($datos_usuario = $this->usuario->login($usuario, $contrasena)) != FALSE) {
            $this->response([
                'status' => TRUE,
                'datos' => $datos_usuario
                    ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'error' => 'Usuario/contraseña incorrecta'
                    ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function usuario_get() {
        $usuario = $this->get('usuario');
        if (!$usuario) {
            $this->response([
                'status' => FALSE,
                'error' => 'Se necesita el campo usuario'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }
        $datos_usuario = $this->usuario->obtener_datos($usuario);
        if ($datos_usuario) {
            $this->response([
                'status' => TRUE,
                'datos' => $datos_usuario
                    ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'error' => 'El usuario no existe'
                    ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function cliente_get() {
        $id_usuario = $this->get('id_usuario');
        if (!$id_usuario) {
            $this->response([
                'status' => FALSE,
                'error' => 'Se necesita el campo id_usuario'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }
        $datos_cliente = $this->cliente->obtener_datos($id_usuario);
        if ($datos_cliente) {
            $this->response([
                'status' => TRUE,
                'datos' => $datos_cliente
                    ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'error' => 'El cliente no existe'
                    ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function total_usuarios_get() {
        $datos = array();
        $datos['admin'] = $this->usuario->contar_usuarios(USUARIO_ADMIN);
        $datos['tecnico_admin'] = $this->usuario->contar_usuarios(USUARIO_TECNICO_ADMIN);
        $datos['tecnico'] = $this->usuario->contar_usuarios(USUARIO_TECNICO);
        $datos['cliente'] = $this->usuario->contar_usuarios(USUARIO_CLIENTE);
        $this->response([
            'status' => TRUE,
            'datos' => $datos
                ], REST_Controller::HTTP_OK);
    }

    public function clientes_get() {
        $this->response([
            'status' => TRUE,
            'datos' => $this->cliente->obtener_clientes()
                ], REST_Controller::HTTP_OK);
    }

    public function usuarios_get() {
        $this->response([
            'status' => TRUE,
            'datos' => $this->usuario->obtener_usuarios()
                ], REST_Controller::HTTP_OK);
    }

    public function registrar_empleado_post() {
        $tipo = $this->post('tipo');
        $usuario = $this->post('usuario');
        $contrasena = $this->post('contrasena');
        $email = $this->post('email');

        if (!$tipo || !$usuario || !$contrasena || !$email) {
            $this->response([
                'status' => FALSE,
                'error' => 'Se necesitan los campos tipo, usuario, contrasena y email'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if ($tipo != USUARIO_ADMIN || $tipo != USUARIO_TECNICO_ADMIN || $tipo != USUARIO_TECNICO) {
            $this->response([
                'status' => FALSE,
                'error' => 'Tipo incorrecto. Valores posibles: Admin=' . USUARIO_ADMIN . ', Técnico admin=' . USUARIO_TECNICO_ADMIN . ', Técnico=' . USUARIO_TECNICO
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $datos_empleado = [
            'tipo' => $tipo,
            'usuario' => $usuario,
            'contrasena' => $this->encryption->encrypt($contrasena),
            'email' => $email
        ];

        $this->response([
            'status' => TRUE,
            'datos' => $this->usuario->registrar_empleado($datos_empleado)
                ], REST_Controller::HTTP_OK);
    }

    public function registrar_cliente_post() {
        $usuario = $this->post('usuario');
        $contrasena = $this->post('contrasena');
        $email = $this->post('email');
        $nombre = $this->post('nombre');
        $cp = $this->post('cp');
        $direccion = $this->post('direccion');
        $pais = $this->post('pais');
        $ciudad = $this->post('ciudad');
        $localidad = $this->post('localidad');
        $nif = $this->post('nif');
        $telefono = $this->post('telefono');
        $numero_cuenta = $this->post('numero_cuenta');
        $contacto = $this->post('contacto');
        $email_opcional = $this->post('email_opcional');
        $observacion = $this->post('observacion');

        if (!$usuario || !$contrasena || !$email || !$nombre || !$cp || !$direccion || !$pais || !$ciudad || !$localidad || !$nif || !$telefono || !$numero_cuenta) {
            $this->response([
                'status' => FALSE,
                'error' => 'Se necesitan los campos tipo, usuario, contrasena, email, nombre, cp, direccion, pais, ciudad, localidad, nif, telefono, numero_cuenta. Campos opcionales: contacto, email_opcional y observacion'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $datos_usuario = [
            'usuario' => $usuario,
            'contrasena' => $this->encryption->encrypt($contrasena),
            'email' => $email
        ];
        $datos_cliente = [
            'nombre' => 'Cliente3',
            'cp' => $cp,
            'direccion' => $direccion,
            'pais' => $pais,
            'ciudad' => $ciudad,
            'localidad' => $localidad,
            'nif' => $nif,
            'telefono' => $telefono,
            'numero_cuenta' => $numero_cuenta
        ];
        if ($contacto != NULL) {
            $datos_cliente['contacto'] = $contacto;
        }
        if ($email_opcional != NULL) {
            $datos_cliente['email_opcional'] = $email_opcional;
        }
        if ($observacion != NULL) {
            $datos_cliente['observacion'] = $observacion;
        }


        $this->response([
            'status' => TRUE,
            'datos' => $this->cliente->registrar($datos_usuario, $datos_cliente)
                ], REST_Controller::HTTP_OK);
    }

}
