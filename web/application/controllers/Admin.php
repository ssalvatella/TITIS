<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

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

    public function index() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $datos['titulo'] = $this->lang->line('inicio');
            $datos['total_usuarios']['admin'] = $this->usuario->contar_usuarios(USUARIO_ADMIN);
            $datos['total_usuarios']['tecnico_admin'] = $this->usuario->contar_usuarios(USUARIO_TECNICO_ADMIN);
            $datos['total_usuarios']['tecnico'] = $this->usuario->contar_usuarios(USUARIO_TECNICO);
            $datos['total_usuarios']['cliente'] = $this->usuario->contar_usuarios(USUARIO_CLIENTE);
            $datos['tickets'] = $this->ticket_modelo->obtener_ultimos_tickets();
            $datos['tickets_pendientes'] = $this->ticket_modelo->contar_tickets_estado(TICKET_PENDIENTE);
            $datos['clientes_registrados'] = $this->cliente_modelo->clientes_registrados();
            $datos['facturas_pendientes'] = $this->factura_modelo->facturas_pendientes();
            $datos['tareas_finalizadas'] = $this->tarea->tareas_finalizadas();
            $this->plantilla->poner_js(site_url('assets/plugins/chartjs/Chart.min.js'));
            $this->plantilla->mostrar('admin', 'inicio', $datos);
        }
    }

    public function empleados() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $datos['titulo'] = $this->lang->line('empleados');
            $datos['empleados'] = $this->usuario->obtener_empleados();
            $this->plantilla->poner_js(site_url('assets/plugins/datatables/jquery.dataTables.min.js'));
            $this->plantilla->poner_js(site_url('assets/plugins/datatables/dataTables.bootstrap.min.js'));
            $this->plantilla->poner_css(site_url('assets/plugins/datatables/dataTables.bootstrap.css'));
            $this->plantilla->poner_js(site_url('assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js'));
            $this->plantilla->poner_css(site_url('assets/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css'));
            $this->plantilla->mostrar('admin', 'empleados', $datos);
        }
    }

    public function clientes() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $datos['titulo'] = $this->lang->line('clientes');
            $datos['clientes'] = $this->cliente_modelo->obtener_clientes();
            $this->plantilla->poner_js(site_url('assets/plugins/datatables/jquery.dataTables.min.js'));
            $this->plantilla->poner_js(site_url('assets/plugins/datatables/dataTables.bootstrap.min.js'));
            $this->plantilla->poner_css(site_url('assets/plugins/datatables/dataTables.bootstrap.css'));
            $this->plantilla->poner_js(site_url('assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js'));
            $this->plantilla->poner_css(site_url('assets/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css'));
            $this->plantilla->mostrar('admin', 'clientes', $datos);
        }
    }

    public function ver_usuario($id_usuario) {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            if ($id_usuario == $this->session->userdata('id_usuario')) {
                $this->perfil();
            } else {
                $datos['usuario'] = $this->usuario->obtener_datos_usuario($id_usuario)[0];
                if ($datos['usuario']['tipo'] == USUARIO_CLIENTE) {
                    $this->ver_cliente($id_usuario);
                } else {
                    $datos['titulo'] = $this->lang->line('usuario') . ' ' . $datos['usuario']['usuario'];
                    $datos['numero_comentarios'] = $this->mensaje->contar_comentarios_usuario($datos['usuario']['id_usuario']);
                    switch ($datos['usuario']['tipo']) {
                        case USUARIO_ADMIN:
                            break;
                        case USUARIO_TECNICO_ADMIN:
                            $datos['tickets'] = $this->ticket_modelo->obtener_tickets_tecnico_admin($datos['usuario']['id_usuario']);
                            $datos['numero_tickets'] = sizeof($datos['tickets']);
                            break;
                        case USUARIO_TECNICO:
                            $datos['tareas'] = $this->tarea->obtener_tareas_tecnico($datos['usuario']['id_usuario'], true);
                            break;
                    }
                    $datos['comentarios'] = $this->mensaje->obtener_comentarios_usuario($datos['usuario']['id_usuario']);
                    $this->plantilla->mostrar('admin', 'ver_usuario', $datos);
                }
            }
        }
    }

    public function ver_cliente($id_cliente) {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $datos['titulo'] = $this->lang->line('cliente');
            $datos['cliente'] = $this->cliente_modelo->obtener_cliente($id_cliente);
            $datos['numero_tickets'] = $this->ticket_modelo->contar_tickets_cliente($id_cliente);
            $datos['tickets'] = $this->cliente_modelo->obtener_tickets($id_cliente);
            $datos['numero_mensajes'] = $this->mensaje->contar_comentarios_usuario($datos['cliente']['id_usuario']);
            $datos['facturas'] = $this->cliente_modelo->obtener_facturas($id_cliente);
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

            $this->plantilla->mostrar('admin', 'cliente', $datos);
        }
    }

    public function registrar_empleado() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $datos['titulo'] = $this->lang->line('nuevo_empleado');
            $this->plantilla->poner_js(site_url('assets/plugins/parsley/parsley.min.js'));
            $this->plantilla->poner_css(site_url('assets/plugins/iCheck/all.css'));
            $this->plantilla->poner_js(site_url('assets/plugins/iCheck/icheck.min.js'));
            if ($this->input->server('REQUEST_METHOD') == 'POST') {
                $this->form_validation->set_error_delimiters('<div class="help-block">', '</div>');
                $this->form_validation->set_rules('usuario', $this->lang->line('usuario'), 'trim|required|xss_clean|is_unique[Usuario.usuario]');
                $this->form_validation->set_rules('email', $this->lang->line('email'), 'trim|required|valid_email|xss_clean|is_unique[Usuario.email]');
                $this->form_validation->set_rules('tipo_empleado', $this->lang->line('tipo_empleado'), 'trim|required|xss_clean');
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
            $this->plantilla->poner_js(site_url('assets/plugins/parsley/parsley.min.js'));
            $this->plantilla->poner_css(site_url('assets/plugins/flagstrap/css/flags.css'));
            $this->plantilla->poner_js(site_url('assets/plugins/flagstrap/js/jquery.flagstrap.min.js'));
            $this->plantilla->poner_css(site_url('assets/plugins/summernote/summernote.css'));
            $this->plantilla->poner_js(site_url('assets/plugins/summernote/summernote.min.js'));
            if ($this->session->userdata('idioma') == 'spanish') {
                $this->plantilla->poner_js(site_url('assets/plugins/summernote/lang/summernote-es-ES.js'));
            }
            $this->plantilla->poner_js(site_url('assets/plugins/input-mask/jquery.inputmask.js'));
            $this->plantilla->poner_js(site_url('assets/plugins/input-mask/jquery.inputmask.extensions.js'));
            if ($this->input->server('REQUEST_METHOD') == 'POST') {
                $this->form_validation->set_error_delimiters('<div class="help-block">', '</div>');
                $this->form_validation->set_rules('usuario', $this->lang->line('usuario'), 'trim|required|xss_clean|is_unique[Usuario.usuario]');
                $this->form_validation->set_rules('email', $this->lang->line('email'), 'trim|required|valid_email|xss_clean|is_unique[Usuario.email]');
                $this->form_validation->set_rules('nombre', $this->lang->line('nombre'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('cp', $this->lang->line('cp'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('direccion', $this->lang->line('direccion'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('pais', $this->lang->line('pais'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('provincia', $this->lang->line('provincia'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('localidad', $this->lang->line('localidad'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('nif', $this->lang->line('nif'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('telefono', $this->lang->line('telefono'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('numero_cuenta', $this->lang->line('numero_cuenta'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('contacto', $this->lang->line('contacto'), 'trim|xss_clean');
                $this->form_validation->set_rules('email_opcional', $this->lang->line('email_opcional'), 'trim|valid_email|xss_clean|is_unique[Cliente.email_opcional]');
                $this->form_validation->set_rules('observaciones', $this->lang->line('observaciones'), 'trim|xss_clean');

                if ($this->form_validation->run() == TRUE) {
                    $usuario = $this->input->post('usuario');
                    $contrasena = random_string('alnum', 8);
                    $nombre = $this->input->post('nombre');
                    $email = $this->input->post('email');
                    $cp = $this->input->post('cp');
                    $direccion = $this->input->post('direccion');
                    $pais = $this->input->post('pais');
                    $provincia = $this->input->post('provincia');
                    $localidad = $this->input->post('localidad');
                    $nif = $this->input->post('nif');
                    $telefono = $this->input->post('telefono');
                    $telefono = str_replace("+34 ", "", $telefono);
                    $telefono = str_replace("-", "", $telefono);
                    $numero_cuenta = $this->input->post('numero_cuenta');
                    $contacto = $this->input->post('contacto');
                    $email_opcional = $this->input->post('email_opcional');
                    $observacion = $this->input->post('observaciones');

                    $datos_usuario = [
                        'usuario' => $usuario,
                        'contrasena' => $this->encryption->encrypt($contrasena),
                        'email' => $email
                    ];

                    $datos_cliente = [
                        'nombre' => $nombre,
                        'cp' => $cp,
                        'direccion' => $direccion,
                        'pais' => $pais,
                        'provincia' => $provincia,
                        'localidad' => $localidad,
                        'nif' => $nif,
                        'telefono' => $telefono,
                        'numero_cuenta' => $numero_cuenta
                    ];
                    if ($contacto != NULL) {
                        $datos_cliente['contacto'] = $contacto;
                    }
                    if ($email_opcional != NULL) {
                        $datos_cliente['email_opcional'] = $email_opcional;
                    }
                    if ($observacion != NULL) {
                        $datos_cliente['observacion'] = $observacion;
                    }

                    $cliente_registrado = $this->cliente_modelo->registrar($datos_usuario, $datos_cliente);
                    if ($cliente_registrado == TRUE) {
                        $datos_email = array(
                            'usuario' => $usuario,
                            'contrasena' => $contrasena,
                        );
                        $this->enviar_email('plantilla_email_registro', $email, $this->lang->line('registro_completado'), $datos_email);
                        $datos['mensaje'] = sprintf($this->lang->line('cliente_registrado'), '<b>' . $usuario . '</b>');
                    } else {
                        $datos['mensaje_error'] = $this->lang->line('registro_incorrecto');
                    }
                }
            }
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

    public function activar_usuario($id) {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $datos['activo'] = '1';
            $this->usuario->modificar_datos($id, $datos);
            redirect('admin/empleados');
        }
    }

    public function banear_usuario($id) {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $datos['activo'] = '0';
            $this->usuario->modificar_datos($id, $datos);
            redirect('admin/empleados');
        }
    }

    public function tickets() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $datos['titulo'] = $this->lang->line('tickets');
            $datos['tickets'] = $this->ticket_modelo->obtener_tickets();
            $this->plantilla->poner_js(site_url('assets/plugins/datatables/jquery.dataTables.min.js'));
            $this->plantilla->poner_js(site_url('assets/plugins/datatables/dataTables.bootstrap.min.js'));
            $this->plantilla->poner_css(site_url('assets/plugins/datatables/dataTables.bootstrap.css'));
            $this->plantilla->poner_js(site_url('assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js'));
            $this->plantilla->poner_css(site_url('assets/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css'));
            $this->plantilla->mostrar('admin', 'tickets', $datos);
        }
    }

    public function ver_ticket($id_ticket = null) {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            if ($id_ticket == null) {
                redirect('admin');
            }
            $datos['titulo'] = $this->lang->line('tickets');
            $datos['ticket'] = $this->ticket_modelo->obtener_ticket($id_ticket);
            $datos['tareas'] = $this->tarea->obtener_tareas($id_ticket);
            $datos['tareas_finalizadas'] = $this->tarea->obtener_tareas_finalizadas($id_ticket);
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
            $this->plantilla->mostrar('admin', 'ticket', $datos);
        }
    }

    public function crear_tarea() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $id_ticket = $this->input->post('id_ticket');
            $id_tecnico = $this->input->post('id_tecnico');
            $descripcion = $this->input->post('descripcion_tarea');
            $inicio = $this->input->post('inicio');
            $fin_previsto = $this->input->post('fin_previsto');
            $datos = [
                'ticket' => $id_ticket,
                'nombre' => $descripcion,
                'tecnico' => $id_tecnico,
                'estado' => TAREA_EN_PROCESO,
                'inicio' => $inicio,
                'fin_previsto' => $fin_previsto
            ];
            $this->tarea->crear_tarea($datos);
        }
    }

    public function editar_descripcion() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $id_mensaje = $this->input->post('id_descripcion');
            $texto = $this->input->post('descripcion');
            $datos = [
                'texto' => $texto
            ];
            $this->mensaje->editar_mensaje($id_mensaje, $datos);
        }
    }

    public function editar_mensaje() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $id_mensaje = $this->input->post('id_mensaje');
            $texto = $this->input->post('mensaje');
            $datos = [
                'texto' => $texto
            ];
            $this->mensaje->editar_mensaje($id_mensaje, $datos);
        }
    }

    public function editar_tarea() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $id_tarea = $this->input->post('id_tarea');
            $id_tecnico = $this->input->post('id_tecnico');
            $descripcion = $this->input->post('descripcion_tarea');
            $inicio = $this->input->post('inicio');
            $fin_previsto = $this->input->post('fin_previsto');
            $datos = [
                'nombre' => $descripcion,
                'tecnico' => $id_tecnico,
                'estado' => TAREA_EN_PROCESO,
                'inicio' => $inicio,
                'fin_previsto' => $fin_previsto
            ];
            $this->tarea->editar_tarea($id_tarea, $datos);
        }
    }

    public function asignar_ticket() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $id_ticket = $this->input->post('id_ticket');
            $id_tecnico_admin = $this->input->post('id_tecnico_admin');
            var_dump($id_tecnico_admin);
            $this->ticket_modelo->asignar_ticket($id_ticket, $id_tecnico_admin);
        }
    }

    public function borrar_ticket() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $id_ticket = $this->input->post('id_ticket');
            $this->ticket_modelo->eliminar_ticket($id_ticket);
            $this->session->set_flashdata('mensaje', 'Ticket borrado correctamente.');
            redirect('admin/tickets');
        }
    }

    public function borrar_tarea() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $id_tarea = $this->input->post('id_tarea');
            $this->tarea->borrar_tarea($id_tarea);
        }
    }

    public function borrar_notificacion() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $id_notificacion = $this->input->post('id_notificacion');
            $this->notificacion->borrar_notificacion($id_notificacion, $this->session->userdata('id_usuario'));
        }
    }

    public function completar_tarea() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
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
            $notificacion = [
                'url' => 'ver_ticket/' . $id_ticket,
                'texto' => 'notif_tarea_completada',
                'parametros' => $this->session->userdata('nombre_usuario')
            ];
            $this->notificacion->insertar_notificacion_admins($this->session->userdata('id_usuario'), $notificacion);
        }
    }

    public function descompletar_tarea() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $id_tarea = $this->input->post('id_tarea');
            $id_ticket = $this->input->post('id_ticket');
            $this->tarea->descompletar_tarea($id_tarea);
            $this->ticket_modelo->comprobar_estado($id_ticket);
            $notificacion = [
                'url' => 'ver_ticket/' . $id_ticket,
                'texto' => 'notif_tarea_descompletada',
                'parametros' => $this->session->userdata('nombre_usuario')
            ];
            $this->notificacion->insertar_notificacion_admins($this->session->userdata('id_usuario'), $notificacion);
        }
    }

    public function eliminar_mensaje($id_mensaje) {
        $this->mensaje->eliminar_mensaje($id_mensaje);
        redirect('admin/mensajes/');
    }

    public function eliminar_mensajes() {
        $mensajes = $this->input->post('mensajes');
        foreach ($mensajes as $id) {
            $this->mensaje->eliminar_mensaje($id);
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
            $notificacion = [
                'url' => 'ver_ticket/' . $id_ticket,
                'texto' => 'notif_comentario_ticket',
                'parametros' => $this->session->userdata('nombre_usuario')
            ];
            $this->notificacion->insertar_notificacion_ticket($id_ticket, $this->session->userdata('id_usuario'), $this->input->post('destinatario'), $notificacion);
        } else {
            $datos['error'] = 1;
        }
        redirect('admin/ver_ticket/' . $id_ticket);
    }

    public function enviar_mensaje_privado($origen, $id_mensaje = '') {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
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
            redirect('/admin/' . $origen . '/' . $id_mensaje);
        }
    }

    public function mensajes() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
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
            $this->plantilla->mostrar('admin', 'mensajes', $datos);
        }
    }

    public function ver_mensaje($id_mensaje) {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
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
            $this->plantilla->mostrar('admin', 'mensaje', $datos);
        }
    }

    public function notificaciones() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $datos['titulo'] = $this->lang->line('notificaciones');
            $datos['notificaciones'] = $this->notificacion->obtener_notificaciones($this->session->userdata('id_usuario'));
            $this->plantilla->mostrar('admin', 'notificaciones', $datos);
        }
    }

    public function facturas() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $datos['titulo'] = $this->lang->line('facturas');
            $datos['facturas'] = $this->factura_modelo->obtener_facturas();

            $datos['facturacion_mensual'] = $this->factura_modelo->obtener_facturacion("mensual");
            $datos['facturacion_trimestral'] = $this->factura_modelo->obtener_facturacion("trimestral");
            $datos['facturacion_anual'] = $this->factura_modelo->obtener_facturacion("anual");
            $datos['facturacion_mensual_pasada'] = $this->factura_modelo->obtener_facturacion("mensual", date("Y", strtotime("-1 year")));
            $datos['facturacion_trimestral_pasada'] = $this->factura_modelo->obtener_facturacion("trimestral", date("Y", strtotime("-1 year")));
            $datos['facturacion_anual_pasada'] = $this->factura_modelo->obtener_facturacion("anual", date("Y", strtotime("-1 year")));

            $this->plantilla->poner_js(site_url('assets/plugins/datatables/jquery.dataTables.min.js'));
            $this->plantilla->poner_js(site_url('assets/plugins/datatables/dataTables.bootstrap.min.js'));
            $this->plantilla->poner_css(site_url('assets/plugins/datatables/dataTables.bootstrap.css'));
            $this->plantilla->poner_js(site_url('assets/plugins/datatables/dataTables.responsive.min.js'));
            $this->plantilla->poner_css(site_url('assets/plugin/datatables/responsive.dataTables.min.css'));
            $this->plantilla->mostrar('admin', 'facturas', $datos);
        }
    }

    public function ver_factura($id_factura) {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $datos['titulo'] = $this->lang->line('facturas');
            $datos['factura'] = $this->factura_modelo->obtener_factura($id_factura);
            $datos['conceptos'] = $this->concepto->obtener_conceptos($id_factura);
            $datos['tareas'] = $this->factura_modelo->obtener_tareas($id_factura);
            $datos['total_tareas'] = $this->factura_modelo->sumar_precios($id_factura);
            $datos['total'] = $datos['factura']['precio_tareas'] + $datos['factura']['precio_conceptos'];
            $this->plantilla->poner_js(site_url('assets/plugins/fastclick/fastclick.js'));
            $this->plantilla->mostrar('admin', 'factura', $datos);
        }
    }

    public function imprimir_factura($id_factura) {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $datos['titulo'] = $this->lang->line('facturas');
            $datos['factura'] = $this->factura_modelo->obtener_factura($id_factura);
            $datos['concepto'] = $this->concepto->obtener_concepto($id_factura);
            $datos['tareas'] = $this->factura_modelo->obtener_tareas($id_factura);
            $datos['total_tareas'] = $this->factura_modelo->sumar_precios($id_factura);
            $this->plantilla->poner_js(site_url('assets/plugins/fastclick/fastclick.js'));
            $this->plantilla->mostrar('admin', 'imprimir_factura', $datos);
        }
    }

    public function borrar_factura() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $id_factura = $this->input->post('id_factura');
            $this->factura_modelo->eliminar_factura($id_factura);
            $this->session->set_flashdata('mensaje', 'Factura borrada correctamente.');
            redirect('admin/facturas');
        }
    }

    public function descargar_archivo($nombre_sin_ext = '', $nombre_original = '') {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
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

    public function perfil() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $datos['titulo'] = $this->lang->line('perfil');
            $datos['usuario'] = $this->usuario->obtener_datos($this->session->userdata('nombre_usuario'));
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
            $this->plantilla->mostrar('admin', 'perfil', $datos);
        }
    }

    public function asignar_tecnicos() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $datos['titulo'] = $this->lang->line('asignar_tecnicos');
            $this->plantilla->poner_css(site_url('assets/plugins/select2/select2.min.css'));
            $this->plantilla->poner_js(site_url('assets/plugins/select2/select2.full.min.js'));
            if ($this->session->userdata('idioma') == 'spanish') {
                $this->plantilla->poner_js(site_url('assets/plugins/select2/i18n/es.js'));
            }
            if ($this->input->server('REQUEST_METHOD') == 'POST') {
                $tecnico_admin = $this->input->post('tecnico_admin');
                $tecnicos = $this->input->post('tecnicos');
                $this->tecnico_admin_modelo->asignar_tecnicos($tecnico_admin, $tecnicos);
            }
            $datos['tecnicos_admin'] = $this->tecnico_admin_modelo->obtener_tecnicos_admin();
            $datos['tecnicos'] = $this->tecnico_admin_modelo->obtener_tecnicos();
            $this->plantilla->mostrar('admin', 'asignar_tecnicos', $datos);
        }
    }

}
