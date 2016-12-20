<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Realtime extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->input->is_cli_request()) {
            exit();
        } else {
            echo '\nIniciado el Websocket del servidor' . PHP_EOL;
        }
    }

    public function index() {
        // Se carga la librería
        if (!isset($this->server_websocket)) {
            $this->load->library('websockets/server_websocket', array('0.0.0.0', '9000'));
        }
    }

}
