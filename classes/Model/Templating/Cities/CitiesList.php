<?php

include_once OTP_PATH_MODEL . 'Model/Templating/Cities.php';

class Model_Templating_Cities_CitiesList extends Model_Templating_Cities {

    protected $_citiesList = array();

    function __construct() {
        parent::init();
    }

    static function &getInstance() {

        static $instance;

        if (!isset($instance)) {
            $class_name = __CLASS__;
            $instance = new $class_name();
        }
        return $instance;
    }

    protected function getContent() {
        $content = array();

        $content['mc_cities_list'] = $this->getCitiesList();
        $content['ec_intresting'] = $this->getIntresting();
        $content['ec_other_country'] = $this->getOtherCountry();

        return $content;
    }

    protected function getCitiesList() {
        $cities = $this->db->query('SELECT * FROM cities WHERE `country_id` = ' . $this->options['country'] . ' ORDER BY `order_by`');
        foreach ($cities as $k => $v) {
            $this->_citiesList[$v['id']] = $v;
        }
        $this->getCitiesAvatars();

        return $this->_citiesList;
    }

    protected function getCitiesAvatars() {
        if (is_array($this->_citiesList) || !empty($this->_citiesList)) {
            $ids = array_keys($this->_citiesList);

            if (!empty($ids)) {
                $images = array();
                $_images = $this->db->query('SELECT * FROM images_cities_AV WHERE `city_id` IN (' . implode(',', array_map('intval', $ids)) . ')');
                foreach ($_images as $k => $v) {
                    $images[$v['city_id']] = $v;
                }
                unset($_images);
                foreach ($this->_citiesList as $id => $article) {
                    if (isset($images[$id])) {
                        $this->_citiesList[$id]['images']['AV'] = $images[$id];
                    } else {
                        $this->_citiesList[$id]['images']['AV'] = array('image_path' => OTP_DEFAULT_ARTICLE_AVATAR, 'alt' => '', 'type' => 'AV');
                    }
                }
                unset($images);
            }
        }
    }

}

?>
