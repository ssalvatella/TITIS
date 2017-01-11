<?php

class WebSocketUser {

  public $socket;
  public $id;
  public $headers = array();
  public $handshake = false;

  public $handlingPartialPacket = false;
  public $partialBuffer = "";

  public $sendingContinuous = false;
  public $partialMessage = "";
  
  public $hasSentClose = false;
  
  public $id_usuario = "";
  public $idioma = "";

  function __construct($id, $socket) {
    $this->id = $id;
    $this->socket = $socket;
  }
}