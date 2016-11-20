<?php

class Idioma_Loader {

    function inicializar() {
        $ci = & get_instance();
        $ci->load->helper('language');
        $idioma = $ci->session->userdata('idioma');
        if ($idioma) {
            $ci->lang->load('titis', $idioma);
        } else {
            // Por defecto carga el idioma español
            $ci->lang->load('titis', 'spanish');
        }
    }

}
