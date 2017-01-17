<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Api extends REST_Controller {

    /**
     * --- GET ---
     * usuario
     * usuarios
     * total_usuarios
     * clientes
     * cliente
     * tickets
     * ticket
     * ultimos_tickets
     * ultimos_tickets_cliente
     * tareas
     * tareas_tecnico
     * notificaciones
     * mensajes
     * mensajes_privados
     * tecnicos
     * facturas
     * factura
     * 
     * --- POST ---
     * login
     * recuperar_contrasena
     * registrar_empleado
     * registrar_cliente
     * activar_usuario
     * banear_usuario
     * modificar_cliente
     * crear_ticket
     * crear_tarea
     * crear_mensaje
     * crear_mensaje_privado
     * modificar_tarea
     * modificar_mensaje
     * borrar_tarea
     * borrar_ticket
     * borrar_factura
     */
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model(array('usuario', 'cliente_modelo', 'ticket_modelo', 'tarea', 'mensaje', 'notificacion', 'tecnico_admin_modelo', 'factura_modelo'));
        $this->load->library('encryption');
        $this->encryption->initialize(
                array(
                    'cipher' => 'aes-256',
                    'mode' => 'ctr',
                    'key' => config_item('encryption_key')
                )
        );
        // $this->methods['login_get']['limit'] = 5;
    }

    public function index_get() {
        $this->response([
            'info' => 'TITIS - API Restful',
            'metodos_GET' => [
                'usuario' => [
                    'info' => 'Obtiene los datos de un usuario',
                    'param_obligatorios' => [
                        'usuario' => 'Nombre del usuario'
                    ]
                ],
                'usuarios' => [
                    'info' => 'Obtiene los datos de todos los usuarios',
                    'param_opcionales' => [
                        'tipo' => 'El tipo de usuario. Valores posibles: Admin=' . USUARIO_ADMIN . ', Técnico admin=' . USUARIO_TECNICO_ADMIN . ', Técnico=' . USUARIO_TECNICO
                    ]
                ],
                'total_usuarios' => [
                    'info' => 'Obtiene el número total de usuarios de cada tipo'
                ],
                'clientes' => [
                    'info' => 'Obtiene los datos de todos los clientes'
                ],
                'cliente' => [
                    'info' => 'Obtiene los datos de un cliente',
                    'param_obligatorios' => [
                        'id_cliente' => 'ID del cliente'
                    ]
                ],
                'tickets' => [
                    'info' => 'Obtiene los datos de todos los tickets'
                ],
                'ticket' => [
                    'info' => 'Obtiene los datos de un ticket',
                    'param_obligatorios' => [
                        'id_ticket' => 'ID del ticket'
                    ]
                ],
                'ultimos_tickets' => [
                    'info' => 'Obtiene los datos de los últimos tickets (7 días)'
                ],
                'ultimos_tickets_cliente' => [
                    'info' => 'Obtiene los datos de los últimos tickets (7 días) de un cliente',
                    'param_obligatorios' => [
                        'id_cliente' => 'ID del cliente'
                    ]
                ],
                'tareas' => [
                    'info' => 'Obtiene las tareas de un ticket',
                    'param_obligatorios' => [
                        'id_ticket' => 'ID del ticket'
                    ]
                ],
                'tareas_tecnico' => [
                    'info' => 'Obtiene las tareas que tiene un técnico',
                    'param_obligatorios' => [
                        'id_tecnico' => 'ID del técnico'
                    ]
                ],
                'notificaciones' => [
                    'info' => 'Obtiene las notificaciones de un usuario',
                    'param_obligatorios' => [
                        'id_usuario' => 'ID del usuario'
                    ]
                ],
                'mensajes' => [
                    'info' => 'Obtiene los mensajes de un ticket',
                    'param_obligatorios' => [
                        'id_ticket' => 'ID del ticket'
                    ]
                ],
                'mensajes_privados' => [
                    'info' => 'Obtiene los mensajes privados de un usuario',
                    'param_obligatorios' => [
                        'id_usuario' => 'ID del usuario'
                    ]
                ],
                'tecnicos' => [
                    'info' => 'Obtiene todos los técnicos que tiene un técnico admin',
                    'param_obligatorios' => [
                        'tecnico_admin' => 'ID del técnico admin'
                    ]
                ],
                'factura' => [
                    'info' => 'Obtiene los datos de una factura',
                    'param_obligatorios' => [
                        'id_factura' => 'ID de la factura'
                    ]
                ],
                'facturas' => [
                    'info' => 'Obtiene los datos de todas las facturas'
                ]
            ],
            'metodos_POST' => [
                'login' => [
                    'info' => 'Inicia sesión',
                    'param_obligatorios' => [
                        'usuario' => 'Nombre del usuario',
                        'contrasena' => 'Constraseña del usuario',
                    ],
                    'param_opcionales' => [
                    ]
                ]
            ]
                ], REST_Controller::HTTP_OK);
    }

    public function login_post() {
        $usuario = $this->post('usuario');
        $contrasena = $this->post('contrasena');
        if (!$usuario || !$contrasena) {
            $this->response([
                'status' => FALSE,
                'error' => 'Se necesita el campo usuario y contrasena'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if (($datos_usuario = $this->usuario->login($usuario, $contrasena)) != FALSE) {
            $this->response([
                'status' => TRUE,
                'datos' => $datos_usuario
                    ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'error' => 'Usuario/contraseña incorrecta'
                    ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function usuario_get() {
        $usuario = $this->get('usuario');
        if (!$usuario) {
            $this->response([
                'status' => FALSE,
                'error' => 'Se necesita el campo usuario'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }
        $datos_usuario = $this->usuario->obtener_datos($usuario);
        if ($datos_usuario) {
            $this->response([
                'status' => TRUE,
                'datos' => $datos_usuario
                    ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'error' => 'El usuario no existe'
                    ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function cliente_get() {
        $id_usuario = $this->get('id_usuario');
        if (!$id_usuario) {
            $this->response([
                'status' => FALSE,
                'error' => 'Se necesita el campo id_usuario'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }
        $datos_cliente = $this->cliente_modelo->obtener_datos($id_usuario);
        if ($datos_cliente) {
            $this->response([
                'status' => TRUE,
                'datos' => $datos_cliente
                    ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'error' => 'El cliente no existe'
                    ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function total_usuarios_get() {
        $datos = [
            'admin' => $this->usuario->contar_usuarios(USUARIO_ADMIN),
            'tecnico_admin' => $this->usuario->contar_usuarios(USUARIO_TECNICO_ADMIN),
            'tecnico' => $this->usuario->contar_usuarios(USUARIO_TECNICO),
            'cliente' => $this->usuario->contar_usuarios(USUARIO_CLIENTE)
        ];
        $this->response([
            'status' => TRUE,
            'datos' => $datos
                ], REST_Controller::HTTP_OK);
    }

    public function clientes_get() {
        $this->response([
            'status' => TRUE,
            'datos' => $this->cliente_modelo->obtener_clientes()
                ], REST_Controller::HTTP_OK);
    }

    public function usuarios_get() {
        $tipo = $this->get('tipo');
        if ($tipo && ($tipo != USUARIO_ADMIN && $tipo != USUARIO_TECNICO_ADMIN && $tipo != USUARIO_TECNICO)) {
            $this->response([
                'status' => FALSE,
                'error' => 'Tipo incorrecto. Valores posibles: Admin=' . USUARIO_ADMIN . ', Técnico admin=' . USUARIO_TECNICO_ADMIN . ', Técnico=' . USUARIO_TECNICO
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $this->response([
            'status' => TRUE,
            'datos' => $this->usuario->obtener_usuarios($tipo)
                ], REST_Controller::HTTP_OK);
    }

    public function registrar_empleado_post() {
        $tipo = $this->post('tipo');
        $usuario = $this->post('usuario');
        $contrasena = $this->post('contrasena');
        $email = $this->post('email');

        if (!$tipo || !$usuario || !$contrasena || !$email) {
            $this->response([
                'status' => FALSE,
                'error' => 'Se necesitan los campos tipo, usuario, contrasena y email'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if ($tipo != USUARIO_ADMIN && $tipo != USUARIO_TECNICO_ADMIN && $tipo != USUARIO_TECNICO) {
            $this->response([
                'status' => FALSE,
                'error' => 'Tipo incorrecto. Valores posibles: Admin=' . USUARIO_ADMIN . ', Técnico admin=' . USUARIO_TECNICO_ADMIN . ', Técnico=' . USUARIO_TECNICO
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $datos_empleado = [
            'tipo' => $tipo,
            'usuario' => $usuario,
            'contrasena' => $this->encryption->encrypt($contrasena),
            'email' => $email
        ];

        $this->response([
            'status' => TRUE,
            'datos' => $this->usuario->registrar_empleado($datos_empleado)
                ], REST_Controller::HTTP_OK);
    }

    public function registrar_cliente_post() {
        $usuario = $this->post('usuario');
        $contrasena = $this->post('contrasena');
        $email = $this->post('email');
        $nombre = $this->post('nombre');
        $cp = $this->post('cp');
        $direccion = $this->post('direccion');
        $pais = $this->post('pais');
        $provincia = $this->post('provincia');
        $localidad = $this->post('localidad');
        $nif = $this->post('nif');
        $telefono = $this->post('telefono');
        $numero_cuenta = $this->post('numero_cuenta');
        $contacto = $this->post('contacto');
        $email_opcional = $this->post('email_opcional');
        $observacion = $this->post('observacion');

        if (!$usuario || !$contrasena || !$email || !$nombre || !$cp || !$direccion || !$pais || !$provincia || !$localidad || !$nif || !$telefono || !$numero_cuenta) {
            $this->response([
                'status' => FALSE,
                'error' => 'Se necesitan los campos usuario, contrasena, email, nombre, cp, direccion, pais, provincia, localidad, nif, telefono, numero_cuenta. Campos opcionales: contacto, email_opcional y observacion'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }

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


        $this->response([
            'status' => TRUE,
            'datos' => $this->cliente_modelo->registrar($datos_usuario, $datos_cliente)
                ], REST_Controller::HTTP_OK);
    }

    public function tickets_get() {
        $tickets = $this->ticket_modelo->obtener_tickets();
        if ($tickets) {
            $this->response([
                'status' => TRUE,
                'datos' => $tickets
                    ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'error' => 'No hay tickets'
                    ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function ticket_get() {
        $id_ticket = $this->get('id_ticket');
        if (!$id_ticket) {
            $this->response([
                'status' => FALSE,
                'error' => 'Se necesita el campo id_ticket'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }
        $datos_ticket = $this->ticket_modelo->obtener_ticket($id_ticket);
        if ($datos_ticket) {
            $this->response([
                'status' => TRUE,
                'datos' => $datos_ticket
                    ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'error' => 'El ticket no existe'
                    ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function ultimos_tickets_get() {
        $ultimos_tickets = $this->ticket_modelo->obtener_ultimos_tickets();
        if ($ultimos_tickets) {
            $this->response([
                'status' => TRUE,
                'datos' => $ultimos_tickets
                    ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'error' => 'No hay tickets'
                    ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function ultimos_tickets_cliente_get() {
        $id_cliente = $this->get('id_cliente');
        if (!$id_cliente) {
            $this->response([
                'status' => FALSE,
                'error' => 'Se necesita el campo id_cliente'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }
        $ultimos_tickets = $this->cliente_modelo->obtener_ultimos_tickets($id_cliente);
        if ($ultimos_tickets) {
            $this->response([
                'status' => TRUE,
                'datos' => $ultimos_tickets
                    ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'error' => 'El cliente no existe o no tiene tickets'
                    ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function tareas_get() {
        $id_ticket = $this->get('id_ticket');
        if (!$id_ticket) {
            $this->response([
                'status' => FALSE,
                'error' => 'Se necesita el campo id_ticket'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }
        $datos_ticket = $this->tarea->obtener_tareas($id_ticket);
        if ($datos_ticket) {
            $this->response([
                'status' => TRUE,
                'datos' => $datos_ticket
                    ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'error' => 'El ticket no existe o no tiene tareas'
                    ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function crear_tarea_post() {
        $id_ticket = $this->input->post('id_ticket');
        $id_tecnico = $this->input->post('id_tecnico');
        $descripcion = $this->input->post('descripcion_tarea');
        $inicio = $this->input->post('inicio');
        $fin_previsto = $this->input->post('fin_previsto');

        if (!$id_ticket || !$id_tecnico || !$descripcion || !$inicio || !$fin_previsto) {
            $this->response([
                'status' => FALSE,
                'error' => 'Se necesitan los campos id_ticket, id_tecnico, descripcion, inicio y fin_previsto'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $datos_tarea = [
            'ticket' => $id_ticket,
            'nombre' => $descripcion,
            'tecnico' => $id_tecnico,
            'inicio' => $inicio,
            'fin_previsto' => $fin_previsto
        ];
        $this->response([
            'status' => TRUE,
            'datos' => $this->tarea->crear_tarea($datos_tarea)
                ], REST_Controller::HTTP_OK);
    }

    public function modificar_tarea_post() {
        $id_tarea = $this->input->post('id_tarea');
        $id_ticket = $this->input->post('id_ticket');
        $id_tecnico = $this->input->post('id_tecnico');
        $descripcion = $this->input->post('descripcion');
        $inicio = $this->input->post('inicio');
        $fin_previsto = $this->input->post('fin_previsto');
        $estado = $this->input->post('estado');

        if (!$id_tarea || !$id_ticket) {
            $this->response([
                'status' => FALSE,
                'error' => 'Se necesita el campo id_tarea y el campo id_ticket'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if (!$id_tecnico && !$descripcion && !$inicio && !$fin_previsto && !$estado) {
            $this->response([
                'status' => FALSE,
                'error' => 'Se necesitan al menos alguno de los siguientes campos: id_tecnico, descripcion, inicio, fin_previsto o estado'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if ($estado != TAREA_EN_PROCESO && $estado != TAREA_FINALIZADA) {
            $this->response([
                'status' => FALSE,
                'error' => 'Destinatario incorrecto. Valores posibles: Procesando=' . TAREA_EN_PROCESO . ', Finalizada=' . TAREA_FINALIZADA
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $datos_tarea = [];
        if ($id_tecnico != NULL) {
            $datos_tarea['tecnico'] = $id_tecnico;
        }
        if ($descripcion != NULL) {
            $datos_tarea['nombre'] = $descripcion;
        }
        if ($inicio != NULL) {
            $datos_tarea['inicio'] = $inicio;
        }
        if ($fin_previsto != NULL) {
            $datos_tarea['fin_previsto'] = $fin_previsto;
        }

        if ($estado != NULL) {
            $datos_tarea['estado'] = $estado;
        }

        $tarea_editada = $this->tarea->editar_tarea($id_tarea, $datos_tarea);

        // Se actualiza el estado del ticket si se ha modificado el estado de la factura
        if ($tarea_editada && $estado != NULL) {
            if ($this->ticket_modelo->comprobar_estado($id_ticket) == TICKET_FINALIZADO) {
                $notificacion = [
                    'url' => 'ver_ticket/' . $id_ticket,
                    'texto' => 'notif_ticket_finalizado'
                ];
                $this->notificacion->insertar_notificacion_cliente($this->ticket_modelo->obtener_ticket($id_ticket)['cliente'], $notificacion);
            }
        }

        $this->response([
            'status' => TRUE,
            'datos' => $tarea_editada
                ], REST_Controller::HTTP_OK);
    }

    public function modificar_cliente_post() {
        $id_cliente = $this->post('id_cliente');
        $nombre = $this->post('nombre');
        $cp = $this->post('cp');
        $direccion = $this->post('direccion');
        $pais = $this->post('pais');
        $provincia = $this->post('provincia');
        $localidad = $this->post('localidad');
        $nif = $this->post('nif');
        $telefono = $this->post('telefono');
        $numero_cuenta = $this->post('numero_cuenta');
        $contacto = $this->post('contacto');
        $email_opcional = $this->post('email_opcional');
        $observacion = $this->post('observacion');

        if (!$id_cliente) {
            $this->response([
                'status' => FALSE,
                'error' => 'Se necesita el campo id_cliente'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if (!$nombre && !$cp && !$direccion && !$pais && !$provincia && !$localidad && !$nif && !$telefono && !$numero_cuenta) {
            $this->response([
                'status' => FALSE,
                'error' => 'Se necesitan al menos alguno de los siguientes campos: usuario, contrasena, email, nombre, cp, direccion, pais, provincia, localidad, nif, telefono, numero_cuenta, contacto, email_opcional u observacion'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $datos_cliente = [];

        if ($nombre != NULL) {
            $datos_cliente['nombre'] = $nombre;
        }
        if ($cp != NULL) {
            $datos_cliente['cp'] = $cp;
        }
        if ($direccion != NULL) {
            $datos_cliente['direccion'] = $direccion;
        }
        if ($pais != NULL) {
            $datos_cliente['pais'] = $pais;
        }
        if ($provincia != NULL) {
            $datos_cliente['provincia'] = $provincia;
        }
        if ($localidad != NULL) {
            $datos_cliente['localidad'] = $localidad;
        }
        if ($nif != NULL) {
            $datos_cliente['nif'] = $nif;
        }
        if ($telefono != NULL) {
            $datos_cliente['telefono'] = $telefono;
        }
        if ($numero_cuenta != NULL) {
            $datos_cliente['numero_cuenta'] = $numero_cuenta;
        }
        if ($contacto != NULL) {
            $datos_cliente['contacto'] = $contacto;
        }
        if ($email_opcional != NULL) {
            $datos_cliente['email_opcional'] = $email_opcional;
        }
        if ($observacion != NULL) {
            $datos_cliente['observacion'] = $observacion;
        }

        $this->response([
            'status' => TRUE,
            'datos' => $this->cliente_modelo->modificar_datos($id_cliente, $datos_cliente)
                ], REST_Controller::HTTP_OK);
    }

    public function notificaciones_get() {
        $id_usuario = $this->get('id_usuario');
        if (!$id_usuario) {
            $this->response([
                'status' => FALSE,
                'error' => 'Se necesita el campo id_usuario'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }
        $this->response([
            'status' => TRUE,
            'datos' => $this->notificacion->obtener_notificaciones($id_usuario)
                ], REST_Controller::HTTP_OK);
    }

    public function mensajes_get() {
        $id_ticket = $this->get('id_ticket');
        if (!$id_ticket) {
            $this->response([
                'status' => FALSE,
                'error' => 'Se necesita el campo id_ticket'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }
        $this->response([
            'status' => TRUE,
            'datos' => $this->mensaje->obtener_mensajes($id_ticket)
                ], REST_Controller::HTTP_OK);
    }

    public function mensajes_privados_get() {
        $id_usuario = $this->get('id_usuario');
        if (!$id_usuario) {
            $this->response([
                'status' => FALSE,
                'error' => 'Se necesita el campo id_usuario'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }
        $this->response([
            'status' => TRUE,
            'datos' => $this->mensaje->ver_mensajes_privados($id_usuario)
                ], REST_Controller::HTTP_OK);
    }

    public function crear_mensaje_post() {
        $id_ticket = $this->input->post('id_ticket');
        $texto = $this->input->post('texto');
        $id_usuario = $this->input->post('id_usuario');
        $destinatario = $this->input->post('destinatario');

        if (!$id_ticket || !$texto || !$id_usuario || !$destinatario) {
            $this->response([
                'status' => FALSE,
                'error' => 'Se necesitan los campos id_ticket, texto, id_usuario y destinatario'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if ($destinatario != USUARIO_ADMIN && $destinatario != USUARIO_TECNICO_ADMIN && $destinatario != USUARIO_TECNICO && $destinatario != USUARIO_CLIENTE) {
            $this->response([
                'status' => FALSE,
                'error' => 'Destinatario incorrecto. Valores posibles: Admins=' . USUARIO_ADMIN . ', Técnico admin=' . USUARIO_TECNICO_ADMIN . ', Técnicos=' . USUARIO_TECNICO . ', Todos (cliente)=' . USUARIO_CLIENTE
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $datos_mensaje = [
            'ticket' => $id_ticket,
            'texto' => $texto,
            'usuario' => $id_usuario,
            'destinatario' => $destinatario
        ];

        $this->response([
            'status' => TRUE,
            'datos' => $this->mensaje->registrar_mensaje($datos_mensaje)
                ], REST_Controller::HTTP_OK);
    }

    public function crear_mensaje_privado_post() {
        $id_emisor = $this->input->post('id_emisor');
        $id_receptor = $this->input->post('id_receptor');
        $texto = $this->input->post('texto');

        if (!$id_emisor || !$id_receptor || !$texto) {
            $this->response([
                'status' => FALSE,
                'error' => 'Se necesitan los campos id_emisor, id_receptor y texto'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $datos_mensaje = [
            'usuario' => $id_emisor,
            'destinatario' => $id_receptor,
            'texto' => $texto
        ];
        $this->response([
            'status' => TRUE,
            'datos' => $this->mensaje->registrar_mensaje($datos_mensaje)
                ], REST_Controller::HTTP_OK);
    }

    public function modificar_mensaje_post() {
        $id_mensaje = $this->input->post('id_mensaje');
        $texto = $this->input->post('texto');

        if (!$id_mensaje) {
            $this->response([
                'status' => FALSE,
                'error' => 'Se necesita el campo id_mensaje'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if (!texto) {
            $this->response([
                'status' => FALSE,
                'error' => 'Se necesitan el campo texto'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $datos_mensaje = [
            'texto' => $texto
        ];

        $this->response([
            'status' => TRUE,
            'datos' => $this->mensaje->editar_mensaje($id_mensaje, $datos_mensaje)
                ], REST_Controller::HTTP_OK);
    }

    public function crear_ticket_post() {
        $titulo = $this->post('titulo');
        $descripcion = $this->post('descripcion');
        $id_cliente = $this->post('id_cliente');

        if (!$titulo || !$descripcion || !$id_cliente) {
            $this->response([
                'status' => FALSE,
                'error' => 'Se necesitan los campos titulo, descripcion, id_cliente'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $datos_ticket = [
            'titulo' => $titulo,
            'mensaje' => $descripcion,
            'cliente' => $id_cliente
        ];

        $this->response([
            'status' => TRUE,
            'datos' => $this->ticket_modelo->registrar_ticket($datos_ticket)
                ], REST_Controller::HTTP_OK);
    }

    public function borrar_tarea_post() {
        $id_tarea = $this->post('id_tarea');
        if (!$id_tarea) {
            $this->response([
                'status' => FALSE,
                'error' => 'Se necesita el campo id_tarea'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }
        $this->response([
            'status' => TRUE,
            'datos' => $this->tarea->borrar_tarea($id_tarea)
                ], REST_Controller::HTTP_OK);
    }

    public function borrar_ticket_post() {
        $id_ticket = $this->post('id_ticket');
        if (!$id_ticket) {
            $this->response([
                'status' => FALSE,
                'error' => 'Se necesita el campo id_ticket'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }
        $this->response([
            'status' => TRUE,
            'datos' => $this->ticket_modelo->eliminar_ticket($id_ticket)
                ], REST_Controller::HTTP_OK);
    }

    public function activar_usuario_post() {
        $id_usuario = $this->post('id_usuario');
        if (!$id_usuario) {
            $this->response([
                'status' => FALSE,
                'error' => 'Se necesita el campo id_usuario'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }
        $this->response([
            'status' => TRUE,
            'datos' => $this->usuario->modificar_datos_por_id($id_usuario, ['activo' => 1])
                ], REST_Controller::HTTP_OK);
    }

    public function banear_usuario_post() {
        $id_usuario = $this->post('id_usuario');
        if (!$id_usuario) {
            $this->response([
                'status' => FALSE,
                'error' => 'Se necesita el campo id_usuario'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }
        $this->response([
            'status' => TRUE,
            'datos' => $this->usuario->modificar_datos_por_id($id_usuario, ['activo' => 0])
                ], REST_Controller::HTTP_OK);
    }

    public function tecnicos_get() {
        $tecnico_admin = $this->get('tecnico_admin');
        if (!$tecnico_admin) {
            $this->response([
                'status' => FALSE,
                'error' => 'Se necesita el campo tecnico_admin'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }
        $datos_tecnicos = $this->tecnico_admin_modelo->obtener_tecnicos($tecnico_admin);
        if ($datos_tecnicos) {
            $this->response([
                'status' => TRUE,
                'datos' => $datos_tecnicos
                    ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'error' => 'El técnico admin no existe o no tiene técnicos'
                    ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function tareas_tecnico_get() {
        $id_tecnico = $this->get('id_tecnico');
        if (!$id_tecnico) {
            $this->response([
                'status' => FALSE,
                'error' => 'Se necesita el campo id_tecnico'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }
        $datos_ticket = $this->tarea->obtener_tareas_tecnico($id_tecnico);
        if ($datos_ticket) {
            $this->response([
                'status' => TRUE,
                'datos' => $datos_ticket
                    ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'error' => 'El tecnico no existe o no tiene tareas'
                    ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function facturas_get() {
        $facturas = $this->factura_modelo->obtener_facturas();
        if ($facturas) {
            $this->response([
                'status' => TRUE,
                'datos' => $facturas
                    ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'error' => 'No hay facturas'
                    ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function factura_get() {
        $id_factura = $this->get('id_factura');
        if (!$id_factura) {
            $this->response([
                'status' => FALSE,
                'error' => 'Se necesita el campo id_factura'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }
        $datos_factura = $this->factura_modelo->obtener_factura($id_factura);
        if ($datos_factura) {
            $this->response([
                'status' => TRUE,
                'datos' => $datos_factura
                    ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'error' => 'La factura no existe'
                    ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    function borrar_factura_post() {
        $id_factura = $this->post('id_factura');
        if (!$id_factura) {
            $this->response([
                'status' => FALSE,
                'error' => 'Se necesita el campo id_factura'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }
        $this->response([
            'status' => TRUE,
            'datos' => $this->factura_modelo->eliminar_factura($id_factura)
                ], REST_Controller::HTTP_OK);
    }

    function recuperar_contrasena_post() {
        $usuario = $this->input->post('usuario');
        $email = $this->input->post('email');
        $idioma = $this->input->post('idioma');
        if (!$usuario || !$email) {
            $this->response([
                'status' => FALSE,
                'error' => 'Se necesitan los campos usuario y email. Opcional el campo idioma (spanish o english)'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if ($idioma) {
            $this->lang->load('titis', $idioma);
        }
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

            $this->response([
                'status' => TRUE,
                'datos' => $this->usuario->modificar_datos($usuario, $nuevos_datos)
                    ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'error' => 'No existe ningún usuario con ese nombre y/o email'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }
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

}
