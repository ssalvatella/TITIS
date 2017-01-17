<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tecnico extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('security'); // form_validation -> xss_clean
        $this->load->helper('descarga'); // No se usa download porque no se puede cambiar el nombre del fichero cuando se descarga
        $this->load->library(array('plantilla', 'encryption', 'upload'));
        $this->load->model(array('notificacion', 'usuario', 'mensaje', 'tarea', 'archivo'));
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
        if ($this->usuario_permitido(USUARIO_TECNICO)) {
            $datos['titulo'] = 'Inicio';
            $datos['tareas_pendientes'] = $this->tarea->obtener_tareas_tecnico($this->session->userdata('id_usuario'), true);
            $datos['ultimas_tareas'] = $this->tarea->tareas_nuevas(7, $this->session->userdata('id_usuario'));

            $this->plantilla->poner_js(site_url('assets/plugins/datepicker/bootstrap-datepicker.js'));
            $this->plantilla->poner_css(site_url('assets/plugins/datepicker/datepicker3.css'));
            $this->plantilla->poner_js(site_url('assets/plugins/fastclick/fastclick.js'));
            $this->plantilla->poner_js('assets/plugins/bootstrap-notify/bootstrap-notify.min.js');
            $this->plantilla->mostrar('tecnico', 'inicio', $datos);
        }
    }

    public function tickets() {
        if ($this->usuario_permitido(USUARIO_TECNICO)) {
            $datos['titulo'] = $this->lang->line('tickets');
            $datos['tickets'] = $this->ticket_modelo->obtener_tickets_tecnico(null, null, $this->session->userdata('id_usuario'));
            $this->plantilla->poner_js(site_url('assets/plugins/datatables/jquery.dataTables.min.js'));
            $this->plantilla->poner_js(site_url('assets/plugins/datatables/dataTables.bootstrap.min.js'));
            $this->plantilla->poner_css(site_url('assets/plugins/datatables/dataTables.bootstrap.css'));
            $this->plantilla->poner_js(site_url('assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js'));
            $this->plantilla->poner_css(site_url('assets/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css'));
            $this->plantilla->mostrar('tecnico', 'tickets', $datos);
        }
    }

    public function ver_ticket($id_ticket = null) {
        if ($this->usuario_permitido(USUARIO_TECNICO)) {
            if ($id_ticket == null) {
                redirect('admin');
            }
            $datos['titulo'] = $this->lang->line('tickets');
            $datos['ticket'] = $this->ticket_modelo->obtener_ticket($id_ticket);
            $datos['tareas'] = $this->tarea->obtener_tareas($id_ticket);
            $datos['mensajes'] = $this->mensaje->obtener_mensajes($id_ticket);
            $datos['tecnicos_admins'] = $this->usuario->obtener_usuarios(USUARIO_TECNICO_ADMIN);
            $datos['tecnicos'] = $this->usuario->obtener_usuarios(USUARIO_TECNICO);
            $this->plantilla->poner_js(site_url('assets/plugins/parsley/parsley.min.js'));
            $this->plantilla->poner_css(site_url('assets/plugins/iCheck/all.css'));
            $this->plantilla->poner_js(site_url('assets/plugins/iCheck/icheck.min.js'));
            $this->plantilla->poner_css(site_url('assets/plugins/summernote/summernote.css'));
            $this->plantilla->poner_js(site_url('assets/plugins/summernote/summernote.min.js'));
            if ($this->session->userdata('idioma') == 'spanish') {
                $this->plantilla->poner_js(site_url('assets/plugins/summernote/lang/summernote-es-ES.js'));
            }
            $this->plantilla->poner_css(site_url('assets/plugins/bootstrap-fileinput/css/fileinput.min.css'));
            $this->plantilla->poner_js(site_url('assets/plugins/bootstrap-fileinput/js/fileinput.min.js'));
            if ($this->session->userdata('idioma') == 'spanish') {
                $this->plantilla->poner_js(site_url('assets/plugins/bootstrap-fileinput/js/locales/es.js'));
            }
            $this->plantilla->poner_js(site_url('assets/plugins/fastclick/fastclick.js'));

            $this->plantilla->poner_css(site_url('assets/plugins/select2/select2.min.css'));
            $this->plantilla->poner_js(site_url('assets/plugins/select2/select2.full.min.js'));
            if ($this->session->userdata('idioma') == 'spanish') {
                $this->plantilla->poner_js(site_url('assets/plugins/select2/i18n/es.js'));
            }

            $this->plantilla->poner_js(site_url('assets/plugins/daterangepicker/moment.min.js'));

            $this->plantilla->poner_js(site_url('assets/plugins/timepicker/bootstrap-timepicker.js'));
            $this->plantilla->poner_css(site_url('assets/plugins/timepicker/bootstrap-timepicker.css'));

            $this->plantilla->poner_css(site_url('assets/plugins/daterangepicker/daterangepicker.css'));
            $this->plantilla->poner_js(site_url('assets/plugins/daterangepicker/daterangepicker.js'));

            $this->plantilla->poner_js('assets/plugins/bootstrap-notify/bootstrap-notify.min.js');
            $this->plantilla->mostrar('tecnico', 'ticket', $datos);
        }
    }

    public function mensajes() {
        if ($this->usuario_permitido(USUARIO_TECNICO)) {
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
            $this->plantilla->mostrar('tecnico', 'mensajes', $datos);
        }
    }

    public function ver_mensaje($id_mensaje) {
        if ($this->usuario_permitido(USUARIO_TECNICO)) {
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
            $this->plantilla->mostrar('tecnico', 'mensaje', $datos);
        }
    }

    public function descargar_archivo($nombre_sin_ext = '', $nombre_original = '') {
        if ($this->usuario_permitido(USUARIO_TECNICO)) {
            if (!$nombre_sin_ext || !$nombre_original) {
                $this->output->set_status_header('404');
                $this->load->view('error_404');
            } else {
                // $ext = substr(strrchr($nombre_original, '.'), 1);
                $ext = pathinfo($nombre_original, PATHINFO_EXTENSION);
                $ruta_fichero = './files/' . $nombre_sin_ext . '.' . $ext;
                if (!file_exists($ruta_fichero)) {
                    $this->output->set_status_header('404');
                    $this->load->view('error_404');
                } else {
                    forzar_descarga($ruta_fichero, NULL, $nombre_original);
                }
            }
        }
    }

    public function completar_tarea() {
        if ($this->usuario_permitido(USUARIO_TECNICO)) {
            $id_tarea = $this->input->post('id_tarea');
            $id_ticket = $this->input->post('id_ticket');
            $this->tarea->completar_tarea($id_tarea);
            if ($this->ticket_modelo->comprobar_estado($id_ticket) == TICKET_FINALIZADO) {
                $notificacion = [
                    'url' => 'ver_ticket/' . $id_ticket,
                    'texto' => 'notif_ticket_finalizado'
                ];
                $this->notificacion->insertar_notificacion_cliente($this->ticket_modelo->obtener_ticket($id_ticket)['cliente'], $notificacion);
            }
        }
    }

    public function descompletar_tarea() {
        if ($this->usuario_permitido(USUARIO_TECNICO)) {
            $id_tarea = $this->input->post('id_tarea');
            $id_ticket = $this->input->post('id_ticket');
            $this->tarea->descompletar_tarea($id_tarea);
            $this->ticket_modelo->comprobar_estado($id_ticket);
        }
    }

    public function enviar_mensaje($id_ticket) {
        $datos_mensaje = [
            'ticket' => $id_ticket,
            'texto' => $this->input->post('mensaje'),
            'usuario' => $this->session->userdata('id_usuario'),
            'destinatario' => $this->input->post('destinatario')
        ];

        if ($this->mensaje->registrar_mensaje($datos_mensaje)) {
            $datos['enviado'] = 1;
            $id_mensaje = $this->db->insert_id();
            if (!$this->upload->do_upload('archivo')) {
                // No se ha podido subir el archivo
                // Aquí habría que borrar el mensaje
                // $upload_error = array('error' => $this->upload->display_errors());
            } else {
                $datos_upload = $this->upload->data();
                $datos_archivo = [
                    'mensaje' => $id_mensaje,
                    'nombre' => $datos_upload['file_name'],
                    'nombre_original' => $datos_upload['orig_name'],
                    'tamano' => $datos_upload['file_size']
                ];
                $this->archivo->registrar_archivo($datos_archivo);
            }
        } else {
            $datos['error'] = 1;
        }
        redirect('tecnico/ver_ticket/' . $id_ticket);
    }

    public function enviar_mensaje_privado($origen, $id_mensaje = '') {
        if ($this->usuario_permitido(USUARIO_TECNICO)) {
            $id_receptor = $this->input->post('id_receptor');
            $id_emisor = $this->session->userdata('id_usuario');
            $mensaje = $this->input->post('mensaje');
            $datos_mensaje = [
                'usuario' => $id_emisor,
                'destinatario' => $id_receptor,
                'texto' => $mensaje
            ];
            if ($this->mensaje->registrar_mensaje($datos_mensaje)) {
                $datos['enviado'] = 1;
                $id_mensaje = $this->db->insert_id();
                if (!$this->upload->do_upload('archivo')) {
                    // No se ha podido subir el archivo
                    // Aquí habría que borrar el mensaje
                    // $upload_error = array('error' => $this->upload->display_errors());
                    $this->upload->display_errors();
                } else {
                    $datos_upload = $this->upload->data();
                    $datos_archivo = [
                        'mensaje' => $id_mensaje,
                        'nombre' => $datos_upload['file_name'],
                        'nombre_original' => $datos_upload['orig_name'],
                        'tamano' => $datos_upload['file_size']
                    ];
                    $this->archivo->registrar_archivo($datos_archivo);
                }
            } else {
                $datos['error'] = 1;
            }
            redirect('/tecnico/' . $origen . '/' . $id_mensaje);
        }
    }

    public function ver_cliente($id_cliente) {
        if ($this->usuario_permitido(USUARIO_TECNICO)) {
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
            $this->plantilla->mostrar('tecnico', 'cliente', $datos);
        }
    }

    public function eliminar_mensaje($id_mensaje) {
        $this->mensaje->eliminar_mensaje($id_mensaje);
        redirect('tecnico/mensajes/');
    }

    public function eliminar_mensajes() {
        $mensajes = $this->input->post('mensajes');
        foreach ($mensajes as $id) {
            $this->mensaje->eliminar_mensaje($id);
        }
    }

    public function borrar_notificacion() {
        if ($this->usuario_permitido(USUARIO_TECNICO)) {
            $id_notificacion = $this->input->post('id_notificacion');
            $this->notificacion->borrar_notificacion($id_notificacion, $this->session->userdata('id_usuario'));
        }
    }

    public function notificaciones() {
        if ($this->usuario_permitido(USUARIO_TECNICO)) {
            $datos['titulo'] = $this->lang->line('notificaciones');
            $datos['notificaciones'] = $this->notificacion->obtener_notificaciones($this->session->userdata('id_usuario'));
            $this->plantilla->mostrar('tecnico', 'notificaciones', $datos);
        }
    }

    public function perfil() {
        if ($this->usuario_permitido(USUARIO_TECNICO)) {
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
            $this->plantilla->mostrar('tecnico', 'perfil', $datos);
        }
    }

}
