<?php

class Dispatcher {


    var $config = null;
    
    
    var $connection = null;
    
    var $db = null;
    
    
    var $controller = null;
    
    
    
    static function &getInstance() {
        
        static $instance;
        
        if(!isset($instance)) {
            $class_name = __CLASS__;
            $instance = new $class_name();
        }
        return $instance;
    }

    public function getConfig() {
        if(!$this->config) {
            if(file_exists(OTP_PATH_CONFIG.'Configuration.php')) {
                require_once OTP_PATH_CONFIG.'Configuration.php';
            } else {
                die('Error. Configuration file is lost.');
            }
            $this->config = new Configuration();
        }
        return $this->config;
    }
    
    public function getDbo() {
        if(!$this->db) {
            $this->db = $this->_createDbo();
        }
        return $this->db;
    }
  
    public function getController() {
        if(!$this->controller) {
            $this->controller = $this->_route();
        }
        return $this->controller;
    }
    
    public function getOptions() {
        $controller = $this->getController();
        return $controller->getOptions();
    }
    
    
    private function _createDbo() {
        require_once OTP_PATH_CLASSES . 'Database.php';
        
        $db = null;
        
        $conf = $this->getConfig();
        
        $host = $conf->host;
        $user = $conf->user;
        $password = $conf->password;
        $db_name = $conf->db;
        
        $options = array('host' => $host, 'user' => $user, 'password' => $password, 'db' => $db_name);
        
        $db = Database::getInstance($options);
        
        return $db;
    }

    # Routing to right controller
    private function _route() {
        require_once OTP_PATH_CLASSES.'Router.php';
        
        $router = Router::getInstance();
        $controller = $router->route();
        
        return $controller;
    }
    
}

?>
