<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('security'); // form_validation -> xss_clean
        $this->load->helper('string'); // Generar contraseña aleatoria
        $this->load->library(array('form_validation', 'encryption', 'plantilla'));
        $this->load->model(array('usuario', 'cliente_modelo', 'tecnico_admin', 'ticket_modelo', 'tarea', 'mensaje', 'notificacion', 'factura_modelo'));
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
            $datos['tareas_finalizadas'] = $this->tarea->tareas_finalizadas();
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
            $this->plantilla->poner_js(site_url('assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js'));
            $this->plantilla->poner_css(site_url('assets/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css'));
            $this->plantilla->mostrar('admin', 'clientes', $datos);
        }
    }

    public function ver_cliente($id_cliente) {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $datos['titulo'] = $this->lang->line('cliente');
            $datos['cliente'] = $this->cliente_modelo->obtener_cliente($id_cliente);
            $datos['numero_tickets'] = $this->ticket_modelo->contar_tickets_cliente($id_cliente);
            $datos['tickets'] = $this->cliente_modelo->obtener_tickets($id_cliente);
            $datos['numero_mensajes'] = $this->mensaje->contar_comentarios_usuario($datos['cliente']['id_usuario']);
            $this->plantilla->poner_js(site_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'));
            if ($this->session->userdata('idioma') == 'spanish') {
                $this->plantilla->poner_js(site_url('assets/plugins/bootstrap-wysihtml5/locales/bootstrap-wysihtml5.es-ES.js'));
            }
            $this->plantilla->poner_css(site_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css'));
            $this->plantilla->poner_js('assets/plugins/bootstrap-notify/bootstrap-notify.min.js');
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
            $this->plantilla->poner_css(site_url('assets/plugins/BootstrapFormHelpers/css/bootstrap-formhelpers.min.css'));
            $this->plantilla->poner_js(site_url('assets/plugins/BootstrapFormHelpers/js/bootstrap-formhelpers.min.js'));
            if ($this->input->server('REQUEST_METHOD') == 'POST') {
                $this->form_validation->set_error_delimiters('<div class="help-block">', '</div>');
                $this->form_validation->set_rules('usuario', $this->lang->line('usuario'), 'trim|required|xss_clean|is_unique[Usuario.usuario]');
                $this->form_validation->set_rules('email', $this->lang->line('email'), 'trim|required|valid_email|xss_clean|is_unique[Usuario.email]');
                $this->form_validation->set_rules('cp', $this->lang->line('cp'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('direccion', $this->lang->line('direccion'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('pais', $this->lang->line('pais'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('provincia', $this->lang->line('provincia'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('localidad', $this->lang->line('localidad'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('nif', $this->lang->line('nif'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('telefono', $this->lang->line('telefono'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('numero_cuenta', $this->lang->line('numero_cuenta'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('contacto', $this->lang->line('contacto'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('email_opcional', $this->lang->line('email_opcional'), 'trim|required|valid_email|xss_clean|is_unique[Cliente.email_opcional]');
                $this->form_validation->set_rules('observacion', $this->lang->line('observaciones'), 'trim|required|xss_clean');

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
                    $numero_cuenta = $this->input->post('numero_cuenta');
                    $contacto = $this->input->post('contacto');
                    $email_opcional = $this->input->post('email_opcional');
                    $observacion = $this->input->post('observacion');

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

    public function obtener_tecnicos_admin() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            print_r($this->tecnico_admin->obtener_tecnicos_admin());
        }
    }

    public function ver_ticket($id_ticket = null) {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {

            if ($id_ticket == null) {
                redirect('admin');
            }
            $datos['titulo'] = $this->lang->line('tickets');
            $datos['ticket'] = $this->ticket_modelo->obtener_ticket($id_ticket)[0];
            $datos['tareas'] = $this->tarea->obtener_tareas($id_ticket);
            $datos['mensajes'] = $this->mensaje->obtener_mensajes($id_ticket);
            $datos['tecnicos_admins'] = $this->usuario->obtener_usuarios_tipo(USUARIO_TECNICO_ADMIN);
            $datos['tecnicos'] = $this->usuario->obtener_usuarios_tipo(USUARIO_TECNICO);

            $this->plantilla->poner_js(site_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'));
            if ($this->session->userdata('idioma') == 'spanish') {
                $this->plantilla->poner_js(site_url('assets/plugins/bootstrap-wysihtml5/locales/bootstrap-wysihtml5.es-ES.js'));
            }
            $this->plantilla->poner_js(site_url('assets/plugins/fastclick/fastclick.js'));
            $this->plantilla->poner_js(site_url('assets/plugins/select2/select2.full.min.js'));

            $this->plantilla->poner_js(site_url('assets/plugins/daterangepicker/moment.min.js'));

            $this->plantilla->poner_js(site_url('assets/plugins/timepicker/bootstrap-timepicker.js'));
            $this->plantilla->poner_css(site_url('assets/plugins/timepicker/bootstrap-timepicker.css'));

            $this->plantilla->poner_css(site_url('assets/plugins/daterangepicker/daterangepicker.css'));
            $this->plantilla->poner_js(site_url('assets/plugins/daterangepicker/daterangepicker.js'));

            $this->plantilla->poner_css(site_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css'));
            $this->plantilla->poner_css(site_url('assets/plugins/select2/select2.min.css'));

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
            $datos = array('ticket' => $id_ticket, 'nombre' => $descripcion, 'tecnico' => $id_tecnico, 'estado' => TAREA_EN_PROCESO, 'inicio' => $inicio, 'fin_previsto' => $fin_previsto);
            $this->tarea->crear_tarea($datos);
        }
    }

    public function editar_tarea() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $id_tarea = $this->input->post('id_tarea');
            $id_tecnico = $this->input->post('id_tecnico');
            $descripcion = $this->input->post('descripcion_tarea');
            $inicio = $this->input->post('inicio');
            $fin_previsto = $this->input->post('fin_previsto');
            $datos = array('nombre' => $descripcion, 'tecnico' => $id_tecnico, 'estado' => TAREA_EN_PROCESO, 'inicio' => $inicio, 'fin_previsto' => $fin_previsto);
            $this->tarea->editar_tarea($id_tarea, $datos);
        }
    }

    public function asignar_ticket() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $id_ticket = $this->input->post('id_ticket');
            $id_tecnico_admin = $this->input->post('id_tecnico_admin');
            $this->ticket_modelo->asignar_ticket($id_ticket, $id_tecnico_admin);
        }
    }

    public function eliminar_ticket($id_ticket = -1) {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
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

    public function completar_tarea() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $id_tarea = $this->input->post('id_tarea');
            $id_ticket = $this->input->post('id_ticket');
            $this->tarea->completar_tarea($id_tarea);
            $this->ticket_modelo->comprobar_estado($id_ticket);
            $notificacion = [
                'url' => 'admin/ver_ticket/' . $id_ticket,
                'texto' => 'tarea_completada',
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
                'url' => 'admin/ver_ticket/' . $id_ticket,
                'texto' => 'tarea_descompletada',
                'parametros' => $this->session->userdata('nombre_usuario')
            ];
            $this->notificacion->insertar_notificacion_admins($this->session->userdata('id_usuario'), $notificacion);
        }
    }

    public function enviar_mensaje() {
        if ($this->usuario_permitido(USUARIO_ADMIN)) {
            $id_receptor = $this->input->post('id_receptor');
            $id_emisor = $this->session->userdata('id_usuario');
            $mensaje = $this->input->post('mensaje');
            $datos = array('usuario' => $id_emisor, 'destinatario' => $id_receptor, 'texto' => $mensaje);
            $this->mensaje->registrar_mensaje($datos);
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
            $datos['factura'] = $this->factura_modelo->obtener_factura($id_factura)[0];
            $datos['ticket'] = $this->ticket_modelo->obtener_ticket_factura($id_factura)[0];
            $this->plantilla->poner_js(site_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'));
            $this->plantilla->poner_js(site_url('assets/plugins/fastclick/fastclick.js'));
            $this->plantilla->poner_css(site_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css'));
            $this->plantilla->mostrar('admin', 'factura', $datos);
        }
    }
}
