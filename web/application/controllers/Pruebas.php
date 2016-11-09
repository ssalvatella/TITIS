<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pruebas extends My_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('usuario');
        $this->load->model('cliente');
        $this->load->library('encryption');
        $this->encryption->initialize(
                array(
                    'cipher' => 'aes-256',
                    'mode' => 'ctr',
                    'key' => config_item('encryption_key')
                )
        );
    }

    public function index() {
        $datos_usuario = [
            'tipo' => USUARIO_CLIENTE,
            'usuario' => 'cliente3',
            'contrasena' => $this->encryption->encrypt('cliente3'),
            'email' => 'cliente3@titis.dev'
        ];
        $datos_cliente = [
            'nombre' => 'Cliente3',
            'cp' => '5005',
            'direccion' => 'Mi casa 3',
            'pais' => 'España',
            'ciudad' => 'Huesca',
            'localidad' => 'Huesca',
            'nif' => '6985174A',
            'telefono' => '96584752',
            'numero_cuenta' => '65421-654-654658-231'
        ];
        var_dump($this->cliente->registrar($datos_usuario, $datos_cliente));
    }

}
