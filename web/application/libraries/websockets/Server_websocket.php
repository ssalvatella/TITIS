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

        $this->CI->load->model(array('mensaje', 'notificacion'));

        // Bucle infinito
        $this->run();
    }

    protected function process($user, $message) {
        /* foreach ($this->users as $u) {
          $message = htmlspecialchars($message);
          $this->send($u, $message);
          } */
        $mensaje_entrada = json_decode($message);
        switch ($mensaje_entrada->tipo) {
            case 'conexion':
                $user->id_usuario = $mensaje_entrada->datos->id_usuario;
                $user->idioma = $mensaje_entrada->datos->idioma;
                $mensaje_salida = json_encode([
                    'tipo' => 'notificaciones',
                    'datos' => $this->formatear_notificaciones($user)
                ]);
                $this->send($user, $mensaje_salida);
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

    private function formatear_notificaciones($user) {
        $notificaciones_sin_formatear = $this->CI->notificacion->obtener_notificaciones($user->id_usuario);
        $this->CI->lang->load('titis', $user->idioma);
        $notificaciones = [];
        foreach ($notificaciones_sin_formatear as $n) {
            $notificacion = [
                'id_notificacion' => $n['id_notificacion'],
                'texto' => sprintf($this->CI->lang->line($n['texto']), '<b>' . $n['parametros'] . '</b>'),
                'fecha' => $n['fecha'],
                'url' => $n['url']
            ];
            array_push($notificaciones, $notificacion);
        }
        return $notificaciones;
    }

    public function enviar_notificacion($id_usuario, $notificacion) {
        foreach ($this->users as $u) {
            if ($u->id_usuario == $id_usuario) {
                $mensaje = json_encode([
                    'tipo' => 'nueva_notificacion',
                    'datos' => $notificacion
                ]);
                $this->send($u, $mensaje);
                break;
            }
        }
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