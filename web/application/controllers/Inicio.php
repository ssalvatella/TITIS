<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('security'); // form_validation -> xss_clean
        $this->load->library(array('form_validation', 'encryption', 'plantilla'));
        $this->load->model('usuario');
        $this->encryption->initialize(
                array(
                    'cipher' => 'aes-256',
                    'mode' => 'ctr',
                    'key' => config_item('encryption_key')
                )
        );
    }

    public function index() {
        $this->cargar_inicio();
    }

    private function cargar_inicio($datos = '') {
        if ($this->session->userdata('logged_in') == TRUE) {
            switch ($this->session->userdata('tipo_usuario')) {
                case USUARIO_ADMIN:
                    redirect('admin');
                    break;
                case USUARIO_TECNICO_ADMIN:
                    redirect('tecnico_admin');
                    break;
                case USUARIO_TECNICO:
                    redirect('tecnico');
                    break;
                case USUARIO_CLIENTE:
                    redirect('cliente');
                    break;
                default:
                    redirect('login');
                    break;
            }
        } else {
            redirect('login');
        }
    }

    public function inicio_sesion() {
        if ($this->session->userdata('logged_in') == TRUE) {
            $this->cargar_inicio();
        } else {
            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
            $this->form_validation->set_rules('usuario', 'Usuario', 'trim|required|xss_clean');
            $this->form_validation->set_rules('contrasena', 'Contrasena', 'trim|required|xss_clean');
            if ($this->form_validation->run() == FALSE) {
                $datos['mensaje'] = $this->session->flashdata('mensaje');
                $datos['mensaje_error'] = $this->session->flashdata('mensaje_error');
                $this->load->view('login', $datos);
            } else {
                $usuario = $this->input->post('usuario');
                $contrasena = $this->input->post('contrasena');

                if (($datos_usuario = $this->usuario->login($usuario, $contrasena)) != FALSE) {
                    if ($datos_usuario['activo'] == 0) {
                        $this->session->set_flashdata('mensaje_error', sprintf($this->lang->line('usuario_inactivo'), $datos_usuario['usuario']));
                        redirect('login');
                    }
                    $this->session->set_userdata('logged_in', TRUE);
                    $this->session->set_userdata('nombre_usuario', $usuario);
                    $this->session->set_userdata('tipo_usuario', $datos_usuario['tipo']);
                    if ($this->input->post('recordarme')) {
                        $this->load->helper('cookie');
                        $cookie = $this->input->cookie('ci_session');
                        $this->input->set_cookie('ci_session', $cookie, '2592000'); // La cookie durará 30 días
                    }
                    $this->session->set_userdata('id_usuario', $datos_usuario['id_usuario']);
                    $this->session->set_userdata('email_usuario', $datos_usuario['email']);
                    $this->session->set_userdata('id_cliente', $datos_usuario['id_cliente']);
                    if ($datos_usuario['tipo'] == USUARIO_CLIENTE) {
                        $this->session->set_userdata('id_cliente', $this->usuario->obtener_id_cliente($datos_usuario['id_usuario']));
                    }
                    $this->cargar_inicio();
                } else {
                    $datos['mensaje_error'] = $this->lang->line('datos_login_incorrectos');
                    $this->load->view('login', $datos);
                }
            }
        }
    }

    public function cerrar_sesion() {
        $idioma = $this->session->userdata('idioma');
        session_destroy();
        $this->session->set_userdata('idioma', $idioma); // No funciona (sigue poniendo la página en español al cerrar la sesión estando en inglés)
        $this->session->set_flashdata('mensaje', $this->lang->line('sesion_cerrada'));
        redirect('login');
    }

    public function contrasena_olvidada() {
        $usuario = $this->input->post('usuario');
        $email = $this->input->post('email');
        $datos_usuario = $this->usuario->obtener_datos($usuario);

        if ($datos_usuario != FALSE && $datos_usuario['email'] == $email) {
            $this->load->helper('string');
            $nueva_contrasena = random_string('alnum', 8);
            $datos_email = [
                'usuario' => $usuario,
                'nueva_contrasena' => $nueva_contrasena
            ];
            $this->enviar_email('plantilla_email_contrasena_olvidada', $email, $this->lang->line('contrasena_cambiada'), $datos_email);
            $nuevos_datos = [
                'contrasena' => $this->encryption->encrypt($nueva_contrasena)
            ];
            $this->usuario->modificar_datos($usuario, $nuevos_datos);
            $this->session->set_flashdata('mensaje', $this->lang->line('nueva_contrasena_enviada'));
        } else {
            $this->session->set_flashdata('mensaje_error', $this->lang->line('error_cambio_contrasena'));
        }
        redirect('login');
    }

    private function enviar_email($plantilla, $email, $asunto, $datos = array()) {
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
