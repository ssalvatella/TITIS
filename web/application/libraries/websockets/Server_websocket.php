<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'libraries/websockets/websockets.php');

class Server_websocket extends WebSocketServer {

    //protected $maxBufferSize = 1048576; //1MB... overkill for an echo server, but potentially plausible for other applications.
    //protected $interactive = false; // No muestra mensajes de información
    // Instancia de CI
    protected $CI;

    public function __construct($args = array()) {
        call_user_func_array('parent::__construct', $args);

        // Se instancia CodeIgniter
        $this->CI = & get_instance();

        // Bucle infinito
        $this->run();
    }

    protected function process($user, $message) {
        /* foreach ($this->users as $u) {
          $message = htmlspecialchars($message);
          $this->send($u, $message);
          } */
        // $user->id_usuario = 
        $mensaje = json_decode($message);
        switch ($mensaje->tipo) {
            case 'conexion':
                $user->id_usuario = $mensaje->datos->id_usuario;
                break;
            case 'notificaciones':
                break;
        }

        var_dump($user->id_usuario);
    }

    protected function connected($user) {
        //$session_id = explode('ci_session=', $user->headers['cookie'])[1];
        //$this->CI->session->set_userdata(array('session_id', $session_id));
        //print_r($this->CI->session->userdata());
    }

    protected function closed($user) {
        // Do nothing: This is where cleanup would go, in case the user had any sort of
        // open files or other objects associated with them.  This runs after the socket 
        // has been closed, so there is no need to clean up the socket itself here.
    }

}

/*
$echo = new echoServer("0.0.0.0", "9000");

try {
    $echo->run();
} catch (Exception $e) {
    $echo->stdout($e->getMessage());
}
*/