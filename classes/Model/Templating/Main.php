<?php

include_once OTP_PATH_MODEL . 'Model/Templating.php';

class Model_Templating_Main extends Model_Templating {
    
  
    protected $_main = array();
    
    function __construct() {
        parent::init(); 
    }


    static function &getInstance() {
        
        static $instance;

        if(!isset($instance)) {
            $class_name = __CLASS__;
            $instance = new $class_name();
        }
        return $instance;
    }
    
    protected function getContent() {
        $content = array();
        
        $content['mc_main'] = $this->getMain();
        $content['mc_best_posts'] = $this->getBestPosts();
        $content['ec_intresting'] = $this->getIntresting();
        $content['ec_other_country'] = $this->getOtherCountry();
        
        return $content;
    }

    
    protected function getMain() {
        $main = array();
        
        if(empty($this->options['country']))
                return $this->_main;
        
        $main = $this->db->query('SELECT * FROM country_main WHERE `country_id` = ' . intval($this->options['country']) . ' ORDER BY `order_by`');
        foreach($main as $k => $v) {
              $this->_main[$v['id']] = $v;
        }
        $this->setMainImages();

        return $this->_main;
    }
    
    protected function setMainImages() {
        if(!is_array($this->_main) || empty($this->_main))
            return;
        
        $ids = array_keys($this->_main);
        
        if(!empty($ids)) {
            $images = array();
            $_images = $this->db->query('SELECT * FROM images_country_M WHERE `country_main_id` IN (' . implode(',', array_map('intval',$ids)) . ')');
            foreach($_images as $k => $v) {
                $images[$v['country_main_id']] = $v;
            }
            unset($_images);
            foreach($this->_main as $id => $article) {
                if(isset($images[$id])) {
                    $this->_main[$id]['images']['M'] = $images[$id];
                } else {
                    $res['M'] = array('image_path' => OTP_DEFAULT_ARTICLE_MAIN, 'alt' => '', 'type' => 'M');
                }
            }
            unset($images);
        }
    }

}

?>
