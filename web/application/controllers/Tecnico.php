<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tecnico extends My_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('plantilla');
        $this->load->model('usuario');
    }

    public function index() {
        if ($this->usuario_permitido(USUARIO_TECNICO)) {
            $datos['titulo'] = 'Inicio';
            $this->plantilla->mostrar('tecnico', 'inicio', $datos);
        }
    }

}
