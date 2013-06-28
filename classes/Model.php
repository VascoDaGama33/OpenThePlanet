<?php


class Model {
    
    
    
    public $options = array();
    
    public $db = null;
    
    
    
    static function &getInstance() {
        
        static $instance;

        if(!isset($instance)) {
            $class_name = __CLASS__;
            $instance = new $class_name();
        }
        return $instance;
    }
    
    
    protected function init() {

        $disp = Dispatcher::getInstance();
        $options = $disp->getOptions();
        
        $this->setOptions($options);
        $this->setDb();
    }
    
    static function &getModel($model_name) {
        $model = NULL;
        $file = OTP_PATH_MODEL . str_replace('_', '/', $model_name) . '.php';

        if(file_exists($file)) {
            include_once $file;
            
            if(class_exists($model_name)) {
                $model = $model_name::getInstance();
            }
        }

        return $model;
    }
    
    protected function setOptions($options) {
        $this->options = $options;
    }
    
    protected function setDb() {
        if(!$this->db) {
            $disp = Dispatcher::getInstance();
            $this->db = $disp->getDbo();
        }
    }
    
}

?>
