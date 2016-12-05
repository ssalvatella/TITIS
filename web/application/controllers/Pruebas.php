<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pruebas extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('cliente_modelo');
        $this->load->library('encryption');
        $this->load->helper(array('form', 'url'));
        $this->encryption->initialize(
                array(
                    'cipher' => 'aes-256',
                    'mode' => 'ctr',
                    'key' => config_item('encryption_key')
                )
        );
    }

    public function index() {
        $this->load->view('upload_file_view');
    }

    function upload() {
        $config_upload = array(
            'upload_path' => "./files/",
            'allowed_types' => "txt|pdf|gif|jpg|jpeg|png|zip",
            'max_size' => "10240", // 10 MB
            'max_height' => "1080",
            'max_width' => "1920",
            'encrypt_name' => TRUE
        );

        //load upload class library
        $this->load->library('upload', $config_upload);

        if (!$this->upload->do_upload('filename')) {
            // case - failure
            $upload_error = array('error' => $this->upload->display_errors());
            $this->load->view('upload_file_view', $upload_error);
        } else {
            // case - success
            $upload_data = $this->upload->data();
            var_dump($upload_data);
            $data['success_msg'] = '<div class="alert alert-success text-center">Your file <strong>' . $upload_data['file_name'] . '</strong> was successfully uploaded!</div>';
            $this->load->view('upload_file_view', $data);
        }
    }

    public function asd() {
        var_dump($this->cliente_modelo->obtener_cliente(2));
    }

}
