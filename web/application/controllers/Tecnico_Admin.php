<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tecnico_Admin extends My_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('plantilla');
        $this->load->model('usuario');
    }

    public function index() {
        if ($this->usuario_permitido(USUARIO_TECNICO_ADMIN)) {
            $datos['titulo'] = 'Inicio';
            $this->plantilla->mostrar('tecnico_admin', 'inicio', $datos);
        }
    }

}
