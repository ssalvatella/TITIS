<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'libraries/websockets/websockets.php');

class Server_websocket extends WebSocketServer {

    //protected $maxBufferSize = 1048576; //1MB... overkill for an echo server, but potentially plausible for other applications.


    protected $interactive = false; // No muestra mensajes de información
    // Instancia de CI
    protected $ci;

    public function __construct($args = array()) {
        call_user_func_array('parent::__construct', $args);

        // Se instancia CodeIgniter
        $this->ci = & get_instance();
    }

    protected function process($user, $message) {
        foreach ($this->users as $u) {
            $message = htmlspecialchars($message);
            $this->send($u, $message);
        }
    }

    protected function connected($user) {
        // Do nothing: This is just an echo server, there's no need to track the user.
        // However, if we did care about the users, we would probably have a cookie to
        // parse at this step, would be looking them up in permanent storage, etc.
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