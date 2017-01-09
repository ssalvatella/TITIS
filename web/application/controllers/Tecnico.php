<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tecnico extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->helper('descarga'); // No se usa download porque no se puede cambiar el nombre del fichero cuando se descarga
        $this->load->library(array('plantilla','upload'));
        $this->load->model(array('notificacion','usuario','mensaje', 'tarea','archivo'));
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
            $datos['tareas_pendientes'] = sizeof($this->tarea->obtener_tareas_tecnico($this->session->userdata('id_usuario')));
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
            $datos['ticket'] = $this->ticket_modelo->obtener_ticket($id_ticket)[0];
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
            $this->ticket_modelo->comprobar_estado($id_ticket);
            $notificacion = [
                'url' => 'tecnico/ver_ticket/' . $id_ticket,
                'texto' => 'notif_tarea_completada',
                'parametros' => $this->session->userdata('nombre_usuario')
            ];
            $this->notificacion->insertar_notificacion_admins($this->session->userdata('id_usuario'), $notificacion);
        }
    }


    public function descompletar_tarea() {
        if ($this->usuario_permitido(USUARIO_TECNICO)) {
            $id_tarea = $this->input->post('id_tarea');
            $id_ticket = $this->input->post('id_ticket');
            $this->tarea->descompletar_tarea($id_tarea);
            $this->ticket_modelo->comprobar_estado($id_ticket);
            $notificacion = [
                'url' => 'tecnico/ver_ticket/' . $id_ticket,
                'texto' => 'notif_tarea_descompletada',
                'parametros' => $this->session->userdata('nombre_usuario')
            ];
            $this->notificacion->insertar_notificacion_admins($this->session->userdata('id_usuario'), $notificacion);
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

}
