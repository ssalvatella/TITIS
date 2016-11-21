<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/

// --- CAMBIO DEL IDIOMA ---
$hook['post_controller_constructor'] = array(
    'class'    => 'Idioma_loader',
    'function' => 'inicializar',
    'filename' => 'Idioma_loader.php',
    'filepath' => 'hooks'
);