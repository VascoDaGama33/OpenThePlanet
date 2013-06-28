<?php

include_once OTP_PATH_MODEL . 'Model/Templating.php';

class Model_Templating_Cities extends Model_Templating {
    
    
    function __construct() {
        self::init();
    }
    
    protected function init() {
        parent::init();
    }
    
    public function getTplData() {
        $this->data['head'] = $this->getHead();
        $this->data['header'] = $this->getHeader();
        $this->data['content'] = $this->getContent();
        $this->data['footer'] = $this->getFooter();
        
        return $this->data;
    }
    
    
    
}

?>
