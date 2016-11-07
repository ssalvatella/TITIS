<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Api extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('usuario');

        // $this->methods['login_get']['limit'] = 5;
    }

    public function login_post() {
        $usuario = $this->post('usuario');
        $contraseña = $this->post('contrasena');
        if (!$usuario || !$contraseña) {
            $this->response([
                'status' => FALSE,
                'error' => 'Se necesita el campo usuario y contrasena'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if ($this->usuario->login($usuario, $contraseña)) {
            $this->response([
                'status' => TRUE
                    ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'error' => 'Usuario/contraseña incorrecta'
                    ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function datos_usuario_get() {
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

}