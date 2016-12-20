
var socket;

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
                    'id_usuario': id_usuario
                }
            };
            socket.send(JSON.stringify(mensaje));
        };
        socket.onmessage = function (msg) {
            console.log("Received: " + msg.data);
        };
        socket.onclose = function (msg) {
            console.log("Disconnected - status " + this.readyState);
        };
    } catch (ex) {
        //console.log(ex);
    }
}

/*
 function send() {
 var txt, msg;
 txt = $("msg");
 msg = txt.value;
 if (!msg) {
 alert("Message can not be empty");
 return;
 }
 txt.value = "";
 txt.focus();
 try {
 socket.send(msg);
 console.log('Sent: ' + msg);
 } catch (ex) {
 log(ex);
 }
 }*/
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

$(function () {
    iniciar_socket();
});