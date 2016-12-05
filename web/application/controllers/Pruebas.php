<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pruebas extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('cliente_modelo');
        $this->load->library('encryption');
        $this->load->helper(array('form', 'url'));
        $this->encryption->initialize(
                array(
                    'cipher' => 'aes-256',
                    'mode' => 'ctr',
                    'key' => config_item('encryption_key')
                )
        );
    }

    public function index() {
        
    }

    public function asd() {
        echo '<a href="' . site_url('admin/descargar_archivo/518bfc837c35d76da6761ecebfcda86d/hola.txt') . '">archivo</a>';
    }

}
