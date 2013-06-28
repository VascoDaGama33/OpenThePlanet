<?php

include_once OTP_PATH_MODEL . 'Model.php';

class Model_Router extends Model {
    
    protected $_controllerName = null;
    
    protected $_options = array();
    
    function __construct() {
        $this->setDb();
    }
    
    static function &getInstance() {
        
        static $instance;

        if(!isset($instance)) {
            $class_name = __CLASS__;
            $instance = new $class_name();
        }
        return $instance;
    }

    public function getControllerName($section_id) {
        if(empty($this->_controllerName)) {
            $this->_controllerName = $this->db->query_first_cell('SELECT `controller` FROM sections WHERE `id` = ' . intval($section_id) );
        }
        return $this->_controllerName;
    }
    
    public function checkOptions($options) {
        $noError = true;
        if(!empty($options['country'])) {
            $country = $this->db->query_first_cell('SELECT `country` FROM countries WHERE `id` = ' . intval($options['country']) . ' AND `active` = 1');
            $options['country'] = !empty($country) ? intval($options['country']) : null;
            
            if($options['country'] === null)
                return false;
        }
        
        if(!empty($options['section'])) {
            $section = $this->db->query_first_cell('SELECT `section` FROM sections WHERE `id` = ' . intval($options['section']) );
            $options['section'] = !empty($section) ? intval($options['section']) : null;
            
            if($options['section'] === null)
                return false;
            
            # Check article or city existing
            if(!empty($options['section']) && !empty($options['id'])) {
                $section_name = $this->db->query_first_cell('SELECT `section` FROM sections WHERE `id` = ' . intval($options['section']) );
                $id = null;
                if(!empty($section_name)) {
                    switch($section_name) {
                        case 'article': 
                            $id = $this->db->query_first_cell('SELECT `id` FROM articles WHERE `id` = ' . intval($options['id']) . ' AND `active` = 1' );
                            break;
                        case 'cities':
                            $id = $this->db->query_first_cell('SELECT `city` FROM cities WHERE `id` = ' . intval($options['id']) );
                            break;
                    }
                }
                $options['id'] = !empty($id) ? intval($options['id']) : null;
                
                if($options['id'] === null)
                    return false;
            }
        }
        
        return $options;
    }
    
    public function getCountryByName($name) {
        if(empty($this->_options['country'])) {
            $country = $this->db->query_first_cell('SELECT `id` FROM countries WHERE `country` = "' . $this->db->db_real_escape_string($name) . '"');
            $this->_options['country'] = !empty($country) ? intval($country) : null;
        }
        return $this->_options['country'];
    }
    
     public function getSectionByName($name){
        if(empty($this->_options['section'])) {
            $section = $this->db->query_first_cell('SELECT `id` FROM sections WHERE `section` = "' . $this->db->db_real_escape_string($name) . '"');
            $this->_options['section'] = !empty($section) ? intval($section) : null;
        }
        return $this->_options['section'];
    }
    
    public function getCityByName($name){
        if(empty($this->_options['id'])) {
            $city = $this->db->query_first_cell('SELECT `id` FROM cities WHERE `city` = "' . $this->db->db_real_escape_string($name) . '"');
            $this->_options['id'] = !empty($city) ? intval($city) : null;
        }
        return $this->_options['id'];
    }
}

?>
