<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tecnico_admin extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('security'); // form_validation -> xss_clean
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

    public function index() {
        if ($this->usuario_permitido(USUARIO_TECNICO_ADMIN)) {
            $datos['titulo'] = 'Inicio';
            $this->plantilla->mostrar('tecnico_admin', 'inicio', $datos);
        }
    }

    public function tickets() {
        if ($this->usuario_permitido(USUARIO_TECNICO_ADMIN)) {
            $datos['titulo'] = $this->lang->line('tickets');
            $datos['tickets'] = $this->ticket_modelo->obtener_tickets();
            $this->plantilla->poner_js(site_url('assets/plugins/datatables/jquery.dataTables.min.js'));
            $this->plantilla->poner_js(site_url('assets/plugins/datatables/dataTables.bootstrap.min.js'));
            $this->plantilla->poner_css(site_url('assets/plugins/datatables/dataTables.bootstrap.css'));
            $this->plantilla->poner_js(site_url('assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js'));
            $this->plantilla->poner_css(site_url('assets/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css'));
            $this->plantilla->mostrar('tecnico_admin', 'tickets', $datos);
        }
    }

    public function mensajes() {
        if ($this->usuario_permitido(USUARIO_TECNICO_ADMIN)) {
            $datos['titulo'] = $this->lang->line('mensajes_titulo');
            $datos['mensajes'] = $this->mensaje->ver_mensajes_privados($this->session->userdata('id_usuario'));
            $datos['numero_mensajes_no_vistos'] = $this->mensaje->contar_mensajes_no_vistos($this->session->userdata('id_usuario'));
            ;
            $datos['usuarios'] = $this->usuario->obtener_usuarios();
            $this->plantilla->poner_css(site_url('assets/plugins/summernote/summernote.css'));
            $this->plantilla->poner_js(site_url('assets/plugins/summernote/summernote.min.js'));
            if ($this->session->userdata('idioma') == 'spanish') {
                $this->plantilla->poner_js(site_url('assets/plugins/summernote/lang/summernote-es-ES.js'));
            }
            $this->plantilla->poner_js(site_url('assets/plugins/fastclick/fastclick.js'));

            $this->plantilla->poner_css(site_url('assets/plugins/select2/select2.min.css'));
            $this->plantilla->poner_js(site_url('assets/plugins/select2/select2.full.min.js'));
            if ($this->session->userdata('idioma') == 'spanish') {
                $this->plantilla->poner_js(site_url('assets/plugins/select2/i18n/es.js'));
            }

            $this->plantilla->poner_js(site_url('assets/plugins/iCheck/iCheck.min.js'));
            $this->plantilla->poner_css(site_url('assets/plugins/iCheck/flat/blue.css'));

            $this->plantilla->poner_js(site_url('assets/plugins/datatables/jquery.dataTables.min.js'));
            $this->plantilla->poner_js(site_url('assets/plugins/datatables/dataTables.bootstrap.min.js'));
            $this->plantilla->poner_css(site_url('assets/plugins/datatables/dataTables.bootstrap.css'));
            $this->plantilla->poner_js(site_url('assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js'));
            $this->plantilla->poner_css(site_url('assets/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css'));

            $this->plantilla->poner_css(site_url('assets/plugins/bootstrap-fileinput/css/fileinput.min.css'));
            $this->plantilla->poner_js(site_url('assets/plugins/bootstrap-fileinput/js/fileinput.min.js'));
            if ($this->session->userdata('idioma') == 'spanish') {
                $this->plantilla->poner_js(site_url('assets/plugins/bootstrap-fileinput/js/locales/es.js'));
            }

            $this->plantilla->poner_js('assets/plugins/bootstrap-notify/bootstrap-notify.min.js');
            $this->plantilla->mostrar('tecnico_admin', 'mensajes', $datos);
        }
    }

    public function ver_mensaje($id_mensaje) {
        if ($this->usuario_permitido(USUARIO_TECNICO_ADMIN)) {
            $datos['titulo'] = $this->lang->line('mensajes_titulo');
            $datos['mensaje'] = $this->mensaje->obtener_mensaje($id_mensaje);
            $this->mensaje->marcar_visto($id_mensaje);
            $datos['numero_mensajes_no_vistos'] = $this->mensaje->contar_mensajes_no_vistos($this->session->userdata('id_usuario'));
            $datos['usuarios'] = $this->usuario->obtener_usuarios();

            $this->plantilla->poner_css(site_url('assets/plugins/summernote/summernote.css'));
            $this->plantilla->poner_js(site_url('assets/plugins/summernote/summernote.min.js'));
            if ($this->session->userdata('idioma') == 'spanish') {
                $this->plantilla->poner_js(site_url('assets/plugins/summernote/lang/summernote-es-ES.js'));
            }
            $this->plantilla->poner_js(site_url('assets/plugins/fastclick/fastclick.js'));

            $this->plantilla->poner_css(site_url('assets/plugins/select2/select2.min.css'));
            $this->plantilla->poner_js(site_url('assets/plugins/select2/select2.full.min.js'));
            if ($this->session->userdata('idioma') == 'spanish') {
                $this->plantilla->poner_js(site_url('assets/plugins/select2/i18n/es.js'));
            }

            $this->plantilla->poner_css(site_url('assets/plugins/bootstrap-fileinput/css/fileinput.min.css'));
            $this->plantilla->poner_js(site_url('assets/plugins/bootstrap-fileinput/js/fileinput.min.js'));
            if ($this->session->userdata('idioma') == 'spanish') {
                $this->plantilla->poner_js(site_url('assets/plugins/bootstrap-fileinput/js/locales/es.js'));
            }

            $this->plantilla->poner_js('assets/plugins/bootstrap-notify/bootstrap-notify.min.js');
            $this->plantilla->mostrar('tecnico_admin', 'mensaje', $datos);
        }
    }

    public function perfil() {
        if ($this->usuario_permitido(USUARIO_TECNICO_ADMIN)) {
            $datos['titulo'] = $this->lang->line('perfil');
            $datos['usuario'] = $this->usuario->obtener_datos($this->session->userdata('nombre_usuario'), TRUE);
            $datos['tab_activa'] = 'datos';
            $this->plantilla->poner_js(site_url('assets/plugins/parsley/parsley.min.js'));
            if ($this->input->server('REQUEST_METHOD') == 'POST') {
                $datos['tab_activa'] = 'editar';
                $this->form_validation->set_error_delimiters('<div class="help-block">', '</div>');
                $this->form_validation->set_rules('contrasena_antigua', $this->lang->line('contrasena_antigua'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('contrasena_nueva', $this->lang->line('contrasena_nueva'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('contrasena_nueva_conf', $this->lang->line('contrasena_nueva_conf'), 'trim|required|xss_clean|matches[contrasena_nueva]');

                if ($this->form_validation->run() == TRUE) {
                    $contrasena_antigua = $this->input->post('contrasena_antigua');
                    $contrasena_nueva = $this->input->post('contrasena_nueva');
                    $contrasena_nueva_conf = $this->input->post('contrasena_nueva_conf');
                    if ($this->encryption->decrypt($datos['usuario']['contrasena']) == $contrasena_antigua) {
                        $nuevos_datos = [
                            'contrasena' => $this->encryption->encrypt($contrasena_nueva)
                        ];
                        $this->usuario->modificar_datos($this->session->userdata('nombre_usuario'), $nuevos_datos);
                        $datos['mensaje'] = $this->lang->line('contrasena_cambiada_ok');
                    } else {
                        $datos['mensaje_error'] = $this->lang->line('contrasena_no_cambiada');
                    }
                }
            }
            $this->plantilla->mostrar('tecnico_admin', 'perfil', $datos);
        }
    }

    public function ver_cliente($id_cliente) {
        if ($this->usuario_permitido(USUARIO_TECNICO_ADMIN)) {
            $datos['titulo'] = $this->lang->line('cliente');
            $datos['cliente'] = $this->cliente_modelo->obtener_cliente($id_cliente);
            $datos['numero_tickets'] = $this->ticket_modelo->contar_tickets_cliente($id_cliente);
            $datos['tickets'] = $this->cliente_modelo->obtener_tickets($id_cliente);
            $datos['numero_mensajes'] = $this->mensaje->contar_comentarios_usuario($datos['cliente']['id_usuario']);
            $this->plantilla->poner_css(site_url('assets/plugins/summernote/summernote.css'));
            $this->plantilla->poner_js(site_url('assets/plugins/summernote/summernote.min.js'));
            if ($this->session->userdata('idioma') == 'spanish') {
                $this->plantilla->poner_js(site_url('assets/plugins/summernote/lang/summernote-es-ES.js'));
            }
            $this->plantilla->poner_js('assets/plugins/bootstrap-notify/bootstrap-notify.min.js');
            $this->plantilla->poner_css(site_url('assets/plugins/bootstrap-fileinput/css/fileinput.min.css'));
            $this->plantilla->poner_js(site_url('assets/plugins/bootstrap-fileinput/js/fileinput.min.js'));
            if ($this->session->userdata('idioma') == 'spanish') {
                $this->plantilla->poner_js(site_url('assets/plugins/bootstrap-fileinput/js/locales/es.js'));
            }
            $this->plantilla->poner_css(site_url('assets/plugins/select2/select2.min.css'));
            $this->plantilla->poner_js(site_url('assets/plugins/select2/select2.full.min.js'));
            if ($this->session->userdata('idioma') == 'spanish') {
                $this->plantilla->poner_js(site_url('assets/plugins/select2/i18n/es.js'));
            }

            $this->plantilla->mostrar('tecnico_admin', 'cliente', $datos);
        }
    }

    public function borrar_notificacion() {
        if ($this->usuario_permitido(USUARIO_TECNICO_ADMIN)) {
            $id_notificacion = $this->input->post('id_notificacion');
            $this->notificacion->borrar_notificacion($id_notificacion, $this->session->userdata('id_usuario'));
        }
    }

    public function notificaciones() {
        if ($this->usuario_permitido(USUARIO_TECNICO_ADMIN)) {
            $datos['titulo'] = $this->lang->line('notificaciones');
            $datos['notificaciones'] = $this->notificacion->obtener_notificaciones($this->session->userdata('id_usuario'));
            $this->plantilla->mostrar('tecnico_admin', 'notificaciones', $datos);
        }
    }

}
