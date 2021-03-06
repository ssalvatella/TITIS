<?php

class Idioma_loader {

    function inicializar() {
        $ci = & get_instance();
        $ci->load->helper('language');
        $idioma = $ci->session->userdata('idioma');
        if ($idioma) {
            $ci->lang->load('titis', $idioma);
        } else {
            if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
                // Si el idioma del navegador es español carga el idioma español
                if (substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) == 'es') {
                    $ci->session->set_userdata('idioma', 'spanish');
                    $ci->lang->load('titis', 'spanish');
                } else {
                    $ci->session->set_userdata('idioma', 'english');
                    $ci->lang->load('titis', 'english');
                }
            } else {
                // Si no se sabe el idioma del navegador se carga el español
                $ci->lang->load('titis', 'spanish');
            }
        }
    }

}
