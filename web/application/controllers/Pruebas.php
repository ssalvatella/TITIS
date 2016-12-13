<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pruebas extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('cliente_modelo');
        $this->load->model('mensaje');
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
        $a = [
            '1' => '0',
            '23' => '1'
        ];
        //echo implode(', ', $a);
        /* echo implode(', ', array_map(
          function ($v, $k) {
          return sprintf("%s='%s'", $k, $v);
          }, $a, array_keys($a)
          )); */
        echo str_replace('=', ':', http_build_query($a, null, ', '));

        $cadena = '1:0, 23:1';
        $destinatarios = [];
        $asArr = explode(', ', $cadena);
        foreach ($asArr as $val) {
            $tmp = explode(':', $val);
            $destinatarios[$tmp[0]] = $tmp[1];
        }
        print_r($destinatarios);
    }

    public function asd() {
        print_r($this->mensaje->obtener_mensajes(5));
    }

}
