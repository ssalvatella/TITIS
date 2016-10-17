<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Api extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->database();
        $this->load->model('usuario');

        $this->methods['login_get']['limit'] = 5;
    }

    public function login_get() {
        $nombre = $this->get('nombre');
        $contrasena = $this->get('contrasena');
        $contraseña = $this->get('contrasena');
        $datos = array('nombre' => $nombre,
            'contrasena' => $contraseña);
        $login_correcto = $this->usuario->login($datos);
        if ($login_correcto) {
            $this->response('', REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'mensaje' => 'Login incorrecto'
                    ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

}
