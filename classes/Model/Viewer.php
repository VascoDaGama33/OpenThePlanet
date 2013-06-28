<?php

include_once OTP_PATH_MODEL . 'Model.php';

class Model_Viewer extends Model {
   
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
    
    
    public function getCountryName($id) {
        if(empty($this->options['country_name'][$id])) {
            $country_name = $this->db->query_first_cell('SELECT `country` FROM countries WHERE `id` = "' . intval($id) . '"');
            $this->options['country_name'][$id] = !empty($country_name) ? ucfirst($country_name) : null ;
        }
        return $this->options['country_name'][$id];
    }
    
    public function getSectionName($id) {
        if(empty($this->options['section_name'][$id])) {
            $section_name = $this->db->query_first_cell('SELECT `section` FROM sections WHERE `id` = "' . intval($id) . '"');
            $this->options['section_name'][$id] = !empty($section_name) ? ucfirst($section_name) : null ;
        }
        return $this->options['section_name'][$id];
    }
    
    public function getCityName($id) {
        if(empty($this->options['city_name'][$id])) {
            $city_name = $this->db->query_first_cell('SELECT `city` FROM cities WHERE `id` = "' . intval($id) . '"');
            $this->options['city_name'][$id] = !empty($city_name) ? ucfirst($city_name) : null ;
        }
        return $this->options['city_name'][$id];
    }
    
    
    
}

?>
