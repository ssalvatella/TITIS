
var socket;
var texto_header_notificaciones = $("#header_notificaciones").text();
function iniciar_socket() {
    var host = "ws://" + window.location.host + ":9000/echobot";
    //var host = "ws://127.0.0.1:9000/echobot";
    try {
        socket = new WebSocket(host);
        //console.log('WebSocket - status ' + socket.readyState);
        socket.onopen = function (msg) {
            //console.log("Welcome - status " + this.readyState);
            var mensaje = {
                'tipo': 'conexion',
                'datos': {
                    'id_usuario': id_usuario,
                    'idioma': idioma
                }
            };
            socket.send(JSON.stringify(mensaje));
        };
        socket.onmessage = function (msg) {
            var mensaje = JSON.parse(msg.data);
            switch (mensaje.tipo) {
                case 'notificaciones':
                    insertar_ultimas_notificaciones(mensaje.datos);
                    break;
                case 'nueva_notificacion':
                    nueva_notificacion(mensaje.datos);
                    break;

            }

        };
        socket.onclose = function (msg) {
            console.log("Disconnected - status " + this.readyState);
        };
    } catch (ex) {
        //console.log(ex);
    }
}

function finalizar_socket() {
    if (socket != null) {
        socket.close();
        socket = null;
    }
}

function reconectar_socket() {
    finalizar_socket();
    iniciar_socket();
}

function insertar_ultimas_notificaciones(notificaciones) {
    $('#numero_notificaciones').remove();
    $('#menu_notificaciones').empty();
    for (i = 0; i < 4; i++) {
        var contenido_html = '<li>' +
                '<a href="javascript:void(0)" onClick="acceder_notificacion(this, ' + notificaciones[i].id_notificacion + ', \'' + notificaciones[i].url + '\')">' +
                '<i class="fa fa-users text-aqua"></i> ' + notificaciones[i].texto +
                '</a>' +
                '</li>';
        $('#menu_notificaciones').append(contenido_html);
    }
    $("#header_notificaciones").text(texto_header_notificaciones.replace('%d', notificaciones.length));
    $('#icono_notificaciones').append('<span id="numero_notificaciones" class="label label-warning">' + notificaciones.length + '</span>');
}


function nueva_notificacion(notificacion) {
    console.log(notificacion);
}


function acceder_notificacion(elem, id_notificacion, url) {
    $.ajax({
        url: url_pagina + '/borrar_notificacion',
        type: 'POST',
        data: {token_csrf: Cookies.get('token_csrf'), id_notificacion: id_notificacion},
        success: function (data) {
            location.href = url_pagina + '/' + url;
        }
    });

}

$(function () {
    iniciar_socket();
});
