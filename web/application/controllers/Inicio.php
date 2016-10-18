<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('security'); // form_validation -> xss_clean
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('plantilla');
        $this->load->model('usuario');
    }

    public function index() {
        $this->cargar_inicio();
    }

    private function cargar_inicio($datos = '') {
        if ($this->session->userdata('logged_in') == TRUE) {
            $datos['titulo'] = 'Inicio';
            switch ($this->session->userdata('tipo_usuario')) {
                case USUARIO_ADMIN:
                    $this->load->view('login');
                    $this->plantilla->mostrar('admin', 'inicio', $datos);
                    break;
                case USUARIO_TECNICO_ADMIN:
                    $this->plantilla->mostrar('tecnico_admin', 'inicio', $datos);
                    break;
                case USUARIO_TECNICO:
                    $this->plantilla->mostrar('tecnico', 'inicio', $datos);
                    break;
                case USUARIO_CLIENTE:
                    $this->plantilla->mostrar('cliente', 'inicio', $datos);
                    break;
                default:
                    $this->load->view('login');
                    break;
            }
        } else {
            $this->load->view('login');
        }
    }

    public function login() {
        if ($this->session->userdata('logged_in') == TRUE) {
            $this->cargar_inicio();
        } else {
            //$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
            $this->form_validation->set_rules('usuario', 'Usuario', 'trim|required|xss_clean');
            $this->form_validation->set_rules('contrasena', 'Contrasena', 'trim|required|xss_clean');
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('login');
            } else {
                $usuario = $this->input->post('usuario');
                $contrasena = md5($this->input->post('contrasena'));

                if ($this->usuario->login($usuario, $contrasena) == TRUE) {
                    $this->session->set_userdata('logged_in', TRUE);
                    $this->session->set_userdata('nombre_usuario', $usuario);
                    $tipo_usuario = $this->usuario->obtener_tipo($usuario);
                    $this->session->set_userdata('tipo_usuario', $tipo_usuario);
                    if ($this->input->post('recordarme')) {
                        $this->load->helper('cookie');
                        $cookie = $this->input->cookie('ci_session');
                        $this->input->set_cookie('ci_session', $cookie, '2592000'); // La cookie durará 30 días
                    }

                    $resultado = $this->usuario->leer_informacion_usuario($usuario);
                    if ($resultado != FALSE) {
                        $this->session->set_userdata('id_usuario', $resultado[0]->id_usuario);
                        $this->session->set_userdata('email_usuario', $resultado[0]->email);
                        $this->cargar_inicio();
                        if ($tipo_usuario == USUARIO_CLIENTE) {
                            $this->session->set_userdata('id_cliente', $this->usuario->obtener_id_cliente($resultado[0]->id_usuario));
                        }
                    }
                } else {
                    $datos = array(
                        'mensaje_error' => 'Usuario y/o Contraseña incorrectos.',
                    );
                    $this->load->view('login', $datos);
                }
            }
        }
    }

    public function cerrar_sesion() {
        session_destroy();
        $datos['mensaje'] = 'Sesión cerrada correctamente.';
        $this->load->view('login', $datos);
    }

    public function cambiar_pass() {
        $usuario = $this->input->post('usuario');
        $email = $this->input->post('email');
        $datos_usuario = $this->usuario->leer_informacion_usuario($usuario);

        if ($datos_usuario != FALSE && $datos_usuario[0]->email == $email) {
            $this->load->helper('string');
            $nueva_pass = random_string('alnum', 8);
            $datos_email = array(
                'nueva_pass' => $nueva_pass
            );
            $this->enviar_email('plantilla_email_cambio_pass', $email, 'Contraseña cambiada', $datos_email);

            $this->usuario->cambiar_pass($usuario, md5($nueva_pass));
            $datos = array(
                'mensaje' => 'La nueva contraseña se ha enviado a su email.',
            );
        } else {
            $datos = array(
                'mensaje_error' => 'No se ha podido cambiar la contraseña debido a que no existe ningún usuario asociado a ese email.',
            );
        }
        $this->load->view('login', $datos);
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
        //$this->email->from(EMAIL_PAGINA);
         $this->email->from('noreply@titis.dev');
        $this->email->to($email);
        $this->email->subject($asunto);

        $mensaje = $this->load->view($plantilla, $datos, TRUE);
        $this->email->message($mensaje);
        /* if ($this->email->send()) {
          echo 'Email enviado.';
          } else {
          show_error($this->email->print_debugger());
          } */
        return $this->email->send();
    }

    public function prueba_email() {
        $this->load->library('email');
        $this->email->initialize(array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.mailtrap.io',
            'smtp_user' => 'a811e75b96f6bd',
            'smtp_pass' => 'f9408505200962',
            'smtp_port' => 2525,
            'crlf' => "\r\n",
            'newline' => "\r\n"
        ));

        $this->email->from('noreply@titis.dev');
        $this->email->to('titiseupt@outlook.com');
        $this->email->subject('Email Test');
        $this->email->message('Testing the email class.');
        $this->email->send();

        echo $this->email->print_debugger();
    }

}
