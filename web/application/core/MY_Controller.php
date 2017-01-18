<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('security'); // form_validation -> xss_clean
        $this->load->helper('string'); // Generar contraseña aleatoria
        $this->load->helper('descarga'); // No se usa download porque no se puede cambiar el nombre del fichero cuando se descarga
        $this->load->library(array('form_validation', 'encryption', 'plantilla', 'upload'));
        $this->load->model(array('usuario', 'cliente_modelo', 'tecnico_admin_modelo', 'ticket_modelo', 'tarea', 'mensaje', 'notificacion', 'factura_modelo', 'archivo'));
        $this->encryption->initialize(
                array(
                    'cipher' => 'aes-256',
                    'mode' => 'ctr',
                    'key' => config_item('encryption_key')
                )
        );
        $this->upload->initialize(
                array(
                    'upload_path' => "./files/",
                    'allowed_types' => "txt|pdf|gif|jpg|jpeg|png|zip|doc|docx|xls|xlsx|rar|ppt|pptm",
                    'max_size' => "10240", // 10 MB
                    'max_height' => "1080",
                    'max_width' => "1920",
                    'encrypt_name' => TRUE
                )
        );
    }

    protected function usuario_permitido($tipo_usuario) {
        if ($this->session->userdata('logged_in') == TRUE) {
            if ($this->session->userdata('tipo_usuario') == $tipo_usuario) {
                return TRUE;
            } else {
                redirect('login');
            }
        } else {
            redirect('login');
        }
    }

    protected function enviar_email($plantilla, $email, $asunto, $datos = array()) {
        /* $config = Array(
          'protocol' => 'smtp',
          'smtp_host' => 'ssl://smtp.live.com',
          'smtp_port' => 587,
          'smtp_user' => EMAIL_PAGINA,
          'smtp_pass' => EMAIL_PAGINA_PASS,
          'mailtype' => 'html',
          'charset' => 'UTF-8',
          'wordwrap' => TRUE
          ); */

        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.mailtrap.io',
            'smtp_port' => 2525,
            'smtp_user' => 'a811e75b96f6bd',
            'smtp_pass' => 'f9408505200962',
            'mailtype' => 'html',
            'charset' => 'UTF-8',
            'wordwrap' => TRUE
        );

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from(EMAIL_PAGINA);
        $this->email->to($email);
        $this->email->subject($asunto);

        $mensaje = $this->load->view($plantilla, $datos, TRUE);
        $this->email->message($mensaje);
        return $this->email->send();
    }

    function cambiar_idioma($idioma = "spanish") {
        $this->session->set_userdata('idioma', $idioma);

        redirect($_SERVER['HTTP_REFERER']);
    }

}
