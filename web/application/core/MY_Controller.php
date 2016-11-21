<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    protected function usuario_permitido($tipo_usuario) {
        if ($this->session->userdata('logged_in') == TRUE) {
            if ($this->session->userdata('tipo_usuario') == $tipo_usuario) {
                return TRUE;
            } else {
                redirect('login');
            }
        } else {
            redirect('login');
        }
    }

}
