<?php

abstract class Controller {
    
    // Dispatcher getting this options
    public $options = array();

    
    
    public $content = null;
    
    
    public $skin =  null;
    
    public $tpl_path = null;
    
    
    protected function setOptions($options = array()) {
        $this->options['country'] = !empty($options['country']) ? intval($options['country']) : null;
        $this->options['section'] = !empty($options['section']) ? intval($options['section']) : null;
        $this->options['id'] = !empty($options['id']) ? intval($options['id']) : null;
        $this->options['page'] = !empty($options['page']) ? intval($options['page']) : null;
        
        
        $this->tpl_path = OTP_PATH_THEMES . 'modern/';
    }
    
    public function getOptions() {
        return $this->options;
    }
    
   
    
    abstract function getTpl();
    
    
    
}

?>
