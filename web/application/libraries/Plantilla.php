<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Plantilla {

    private $datos = array();
    private $ficheros_js;
    private $ficheros_css;
    private $CI;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->helper('url');
        $this->CI->load->helper('file');

        // CSS and JS por defecto que serán cargados en todas las páginas
        $this->poner_css(base_url('assets/css/bootstrap.min.css'));
        $this->poner_css(base_url('assets/css/font-awesome.min.css'));
        $this->poner_css(base_url('assets/css/ionicons.min.css'));
        //$this->poner_css(base_url('assets/css/AdminLTE.min.css'));
        //$this->poner_css(base_url('assets/css/skins/_all-skins.min.css'));
        $this->poner_js(base_url('assets/plugins/jQuery/jquery.min.js'));
        $this->poner_js(base_url('assets/plugins/jQueryUI/jquery-ui.js'));
        $this->poner_js(base_url('assets/js/bootstrap.min.js'));
        //$this->poner_js(base_url('assets/js/AdminLTE.min.js'));
        //$this->poner_js(base_url('assets/js/TITIS.js'));
        $this->poner_css(site_url('assets/plugins/pace/pace.css'));
        $this->poner_js(site_url('assets/plugins/pace/pace.min.js'));
    }

    public function mostrar($carpeta, $pagina, $datos = array()) {
        if (!file_exists('application/views/' . $carpeta . '/' . $pagina . '.php')) {
            show_404();
        } else {
            $this->datos = array_merge($this->datos, $datos);
            $this->cargar_css_y_js();
            $this->datos['menu'] = $this->CI->load->view($carpeta . '/menu.php', $this->datos, true);
            $this->datos['contenido'] = $this->CI->load->view($carpeta . '/' . $pagina . '.php', $this->datos, true);
            if (file_exists('application/views/' . $carpeta . '/' . $pagina . '.js')) {
                $this->datos['js_pagina'] = read_file('application/views/' . $carpeta . '/' . $pagina . '.js');
            }
            $this->datos['notificaciones'] = $this->CI->notificacion->obtener_notificaciones($this->CI->session->userdata('id_usuario'));
            $this->datos['mensajes_privados'] = $this->CI->mensaje->ver_mensajes_privados($this->CI->session->userdata('id_usuario'), 'No vistos');
            $this->CI->load->view('plantilla.php', $this->datos);
        }
    }

    public function poner_js($nombre) {
        $js = new stdClass();
        $js->file = $nombre;
        $this->ficheros_js[] = $js;
    }

    public function poner_css($nombre) {
        $css = new stdClass();
        $css->file = $nombre;
        $this->ficheros_css[] = $css;
    }

    private function cargar_css_y_js() {
        $this->datos['css'] = '';
        $this->datos['js'] = '';

        if ($this->ficheros_css) {
            foreach ($this->ficheros_css as $css) {
                $this->datos['css'] .= link_tag($css->file);
            }
        }

        if ($this->ficheros_js) {
            foreach ($this->ficheros_js as $js) {
                $this->datos['js'] .= script_tag($js->file);
            }
        }
    }

}
