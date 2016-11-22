<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('security'); // form_validation -> xss_clean
        $this->load->helper('string'); // Generar contraseña aleatoria
        $this->load->library(array('form_validation', 'encryption', 'plantilla'));
        $this->load->model(array('usuario', 'cliente_modelo', 'tecnico_admin', 'ticket_modelo', 'tarea', 'mensaje'));
        $this->encryption->initialize(
                array(
                    'cipher' => 'aes-256',
                    'mode' => 'ctr',
                    'key' => config_item('encryption_key')
                )
        );
    }

    public function index() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $datos['titulo'] = $this->lang->line('inicio');
            $datos['total_usuarios']['admin'] = $this->usuario->contar_usuarios(USUARIO_ADMIN);
            $datos['total_usuarios']['tecnico_admin'] = $this->usuario->contar_usuarios(USUARIO_TECNICO_ADMIN);
            $datos['total_usuarios']['tecnico'] = $this->usuario->contar_usuarios(USUARIO_TECNICO);
            $datos['total_usuarios']['cliente'] = $this->usuario->contar_usuarios(USUARIO_CLIENTE);
            $datos['tickets'] = $this->ticket_modelo->obtener_ultimos_tickets();
            $datos['tickets_pendientes'] = $this->ticket_modelo->contar_tickets_estado(TICKET_PENDIENTE);
            $this->plantilla->poner_js(site_url('assets/plugins/chartjs/Chart.min.js'));
            $this->plantilla->mostrar('admin', 'inicio', $datos);
        }
    }

    public function clientes() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $datos['titulo'] = $this->lang->line('clientes');
            $datos['clientes'] = $this->cliente_modelo->obtener_clientes();
            $this->plantilla->poner_js(site_url('assets/plugins/datatables/jquery.dataTables.min.js'));
            $this->plantilla->poner_js(site_url('assets/plugins/datatables/dataTables.bootstrap.min.js'));
            $this->plantilla->poner_css(site_url('assets/plugins/datatables/dataTables.bootstrap.css'));
            $this->plantilla->poner_js(site_url('assets/plugins/datatables/dataTables.responsive.min.js'));
            $this->plantilla->poner_css(site_url('assets/plugins/datatables/responsive.dataTables.min.css'));
            $this->plantilla->mostrar('admin', 'clientes', $datos);
        }
    }

    public function registrar_empleado() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $datos['titulo'] = $this->lang->line('nuevo_empleado');
            $this->plantilla->poner_js(site_url('assets/plugins/bootstrap-validator/validator.min.js'));
            $this->plantilla->poner_css(site_url('assets/plugins/iCheck/all.css'));
            $this->plantilla->poner_js(site_url('assets/plugins/iCheck/icheck.min.js'));
            if ($this->input->server('REQUEST_METHOD') == 'POST') {
                $this->form_validation->set_error_delimiters('<div class="help-block">', '</div>');
                $this->form_validation->set_rules('usuario', $this->lang->line('usuario'), 'trim|required|xss_clean|is_unique[Usuario.usuario]');
                $this->form_validation->set_rules('email', $this->lang->line('email'), 'trim|required|valid_email|xss_clean|is_unique[Usuario.email]');
                $this->form_validation->set_rules('tipo_empleado', $this->lang->line('tipo_empleado'), 'required');
                if ($this->form_validation->run() == TRUE) {
                    $usuario = $this->input->post('usuario');
                    $contrasena = random_string('alnum', 8);
                    $email = $this->input->post('email');
                    $tipo = $this->input->post('tipo_empleado');

                    $datos_empleado = [
                        'tipo' => $tipo,
                        'usuario' => $usuario,
                        'contrasena' => $this->encryption->encrypt($contrasena),
                        'email' => $email
                    ];
                    $empleado_registrado = $this->usuario->registrar_empleado($datos_empleado);
                    if ($empleado_registrado == TRUE) {
                        $datos_email = array(
                            'usuario' => $usuario,
                            'contrasena' => $contrasena,
                        );
                        $this->enviar_email('plantilla_email_registro', $email, $this->lang->line('registro_completado'), $datos_email);
                        $datos['mensaje'] = sprintf($this->lang->line('empleado_registrado'), '<b>' . $usuario . '</b>');
                    } else {
                        $datos['mensaje_error'] = $this->lang->line('registro_incorrecto');
                    }
                }
            }
            $this->plantilla->mostrar('admin', 'nuevo_empleado', $datos);
        }
    }

    public function registrar_cliente() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $datos['titulo'] = $this->lang->line('nuevo_cliente');
            $this->plantilla->mostrar('admin', 'nuevo_cliente', $datos);
        }
    }

    public function activar_cliente($id) {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $datos['activo'] = '1';
            $this->usuario->modificar_datos($id, $datos);
            redirect('admin/clientes');
        }
    }

    public function banear_cliente($id) {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $datos['activo'] = '0';
            $this->usuario->modificar_datos($id, $datos);
            redirect('admin/clientes');
        }
    }

    public function tickets() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $datos['titulo'] = $this->lang->line('tickets');
            $datos['tickets'] = $this->ticket_modelo->obtener_tickets();
            $this->plantilla->poner_js(site_url('assets/plugins/datatables/jquery.dataTables.min.js'));
            $this->plantilla->poner_js(site_url('assets/plugins/datatables/dataTables.bootstrap.min.js'));
            $this->plantilla->poner_css(site_url('assets/plugins/datatables/dataTables.bootstrap.css'));
            $this->plantilla->poner_js(site_url('assets/plugins/datatables/dataTables.responsive.min.js'));
            $this->plantilla->poner_css(site_url('assets/plugins/datatables/responsive.dataTables.min.css'));
            $this->plantilla->mostrar('admin', 'tickets', $datos);
        }
    }

    public function obtener_tecnicos_admin() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            print_r($this->tecnico_admin->obtener_tecnicos_admin());
        }
    }

    public function ver_ticket($id_ticket) {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $datos['titulo'] = $this->lang->line('tickets');
            $datos['ticket'] = $this->ticket_modelo->obtener_ticket($id_ticket)[0];
            $datos['tareas'] = $this->tarea->obtener_tareas($id_ticket);
            $datos['mensajes'] = $this->mensaje->obtener_mensajes($id_ticket);
            $datos['tecnicos_admins'] = $this->usuario->obtener_usuarios_tipo(USUARIO_TECNICO_ADMIN);
            $this->plantilla->poner_js(site_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'));
            if ($this->session->userdata('idioma') == 'spanish') {
                $this->plantilla->poner_js(site_url('assets/plugins/bootstrap-wysihtml5/locales/bootstrap-wysihtml5.es-ES.js'));
            }
            $this->plantilla->poner_js(site_url('assets/plugins/fastclick/fastclick.js'));
            $this->plantilla->poner_js(site_url('assets/plugins/select2/select2.full.min.js'));
            $this->plantilla->poner_css(site_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css'));
            $this->plantilla->poner_css(site_url('assets/plugins/select2/select2.min.css'));
            $this->plantilla->mostrar('admin', 'ticket', $datos);
        }
    }

    public function asignar_ticket() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $id_ticket = $this->input->post('id_ticket');
            $id_tecnico_admin = $this->input->post('id_tecnico_admin');
            $this->ticket_modelo->asignar_ticket($id_ticket, $id_tecnico_admin);
        }
    }

}
