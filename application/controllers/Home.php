<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Home extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        try {
            $this->load->library('Ci_Rabbitmq');
        }catch (\Exception $e) {
            echo $e->getMessage(). PHP_EOL;
        }
    }
    
    public function index() {
        $this->load->view('home/index');
    }
    
    public function send() {
        if($this->input->post()) {
            try {
                if(!isset($this->ci_rabbitmq)) {
                    throw new \Exception("Rabbitmq no inicializado.");
                }
                $channel_name = "my_message";
                $data_queue = ['mensaje' => $this->input->post('mensaje')];
                $this->ci_rabbitmq->push($channel_name, $data_queue);
                redirect();
            }catch (\Exception $e) {
                echo $e->getMessage() . PHP_EOL;
            }
        }else {
            echo 'No es POST.'. PHP_EOL;
        }
    }
    
}
