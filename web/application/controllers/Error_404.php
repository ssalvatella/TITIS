<?php

class Error_404 extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->output->set_status_header('404');
        $datos['content'] = 'error_404';
        $this->load->view('error_404', $datos);
    }

}
