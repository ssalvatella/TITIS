<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pruebas extends My_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('varios');
    }

    public function index() {
        $datos['total_usuarios']['admin'] = $this->varios->contar_usuarios(USUARIO_ADMIN);
        $datos['total_usuarios']['tecnico_admin'] = $this->varios->contar_usuarios(USUARIO_TECNICO_ADMIN);
        $datos['total_usuarios']['tecnico'] = $this->varios->contar_usuarios(USUARIO_TECNICO);
        $datos['total_usuarios']['cliente'] = $this->varios->contar_usuarios(USUARIO_CLIENTE);
        print_r($datos['total_usuarios']);
    }

}
