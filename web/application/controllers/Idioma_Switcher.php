<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Idioma_Switcher extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    function cambiar_idioma($idioma = "spanish") {
        $this->session->set_userdata('idioma', $idioma);

        redirect($_SERVER['HTTP_REFERER']);
    }

}
