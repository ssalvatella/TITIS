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
            'usuario' => 'cliente',
            'contrasena' => $this->encryption->encrypt('cliente'),
            'email' => 'cliente@titis.dev'
        ];
        $datos_cliente = [
            'nombre' => 'Cliente',
            'cp' => '5003',
            'direccion' => 'Mi casa',
            'pais' => 'España',
            'ciudad' => 'Teruel',
            'localidad' => 'Teruel',
            'nif' => '19865432A',
            'telefono' => '987654321',
            'numero_cuenta' => '68975689675'
        ];
        var_dump($this->cliente->registrar($datos_usuario, $datos_cliente));
    }

}
