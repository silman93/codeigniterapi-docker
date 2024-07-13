<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ci_Rabbitmq {
    
    public $config;
    public $connection = NULL;
    public $channel = NULL;
    
    public function __construct($config = array()) {
        $this->CI =& get_instance();
        
        $this->config = (!empty($config)) ? $config : array();
        try {
            $this->initialize($this->config);
        }catch(Exception $e) {
            throw new \Exception($e->getMessage());
        }
        
    }
    
    public function initialize($config = array()) {
        if(empty($config)) {
            throw new \Exception("Config para rabbitmq no existe.");
        }
        $this->config = $config['ci_rabbitmq'];
    }
    
    public function connect() {
        $this->connection = new PhpAmqpLib\Connection\AMQPStreamConnection($this->config['host'], $this->config['port'], $this->config['user'], $this->config['pass']);
        $this->channel = $this->connection->channel();
    }
    
    public function push($queue = null, $data = array(), $permanent = false) {
        if(empty($queue)) {
            throw new \Exception("El parametro [queue] es NULL");
        }
        $this->connect();
        
        $this->channel->queue_declare($queue, false, $permanent, false, false, false);

        $msg = new PhpAmqpLib\Message\AMQPMessage(json_encode($data));
        $this->channel->basic_publish($msg, '', $queue);
        $this->close();
    }
    
    public function getChannel($channel = null) {
        if(empty($channel)) {
            throw new \Exception("El parametro [channel] es NULL");
        }
        $this->connect();

        $this->channel->queue_declare($channel, false, false, false, false, false);
        return $this->channel;
    }
    
    public function close() {
        try {
            if(!empty($this->channel)) {
                $this->channel->close();
                $this->channel = NULL;
            }
            if(!empty($this->connection)) {
                $this->connection->close();
                $this->connection = NULL;
            }
        }catch(\Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function __destruct() {
        $this->close();
    }
}
