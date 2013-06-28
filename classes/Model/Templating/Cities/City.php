<?php

include_once OTP_PATH_MODEL . 'Model/Templating/Cities.php';

class Model_Templating_Cities_City extends Model_Templating_Cities {

    protected $_city = array();
    
    protected $_cityArticles = array();
    
    protected $_countArticles = null;
    

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

    protected function getHead() {
        $section = array();

        if (empty($this->options['section']))
            return $section;

        $city = $this->getCityData();

        $head = array(
            'title' => !empty($city['city_name']) ? $city['city_name'] . ' - Open The Planet' : 'Open The Planet',
            'description' => !empty($city['meta_description']) ? $city['meta_description'] : '',
            'keywords' => !empty($city['meta_keywords']) ? $city['meta_keywords'] : '',
        );

        return $head;
    }

    protected function getContent() {
        $content = array();

        $content['mc_articles_list'] = $this->getCityArticles();
        $content['mc_pages'] = $this->getPages();
        $content['mc_best_posts'] = $this->getBestPosts();
        $content['mc_gallery'] = $this->getCityGallery();
        $content['ec_intresting'] = $this->getIntresting();
        $content['ec_other_country'] = $this->getOtherCountry();

        return $content;
    }

    protected function &getCityData() {
        if (empty($this->_city)) {
            $this->_city = $this->db->query_first('SELECT * FROM cities WHERE `id` = ' . intval($this->options['id']));
        }
        return $this->_city;
    }

    protected function getCityArticles() {
        $articles = array();
        if (empty($this->options['id']))
            return $articles;

        $per_page = defined('OTP_ARTICLES_PER_PAGE') ? OTP_ARTICLES_PER_PAGE : null;
        if (!empty($this->options['page']) && $this->options['page'] > 1) {
            $limit = !empty($per_page) ? ' LIMIT ' . intval($this->options['page'] * $per_page - $per_page) . ',' . $per_page : '';
        } else {
            $limit = !empty($per_page) ? ' LIMIT ' . $per_page : '';
        }
        
        $articles = $this->db->query('SELECT id, category_id, country_id, city_id, meta_keywords, datetime, title, prev_description, short_description FROM articles WHERE `city_id` = ' . intval($this->options['id']) . ' AND `active` = 1 ORDER BY `datetime` DESC' . $limit);
        foreach ($articles as $k => $v) {
            $this->_cityArticles[$v['id']] = $v;
        }
        $this->setCityArticlesImages();

        return $this->_cityArticles;
    }

    protected function setCityArticlesImages() {

        if (!is_array($this->_cityArticles) || empty($this->_cityArticles))
            return;

        $ids = array_keys($this->_cityArticles);

        if (!empty($ids)) {
            $images = array();
            $_images = $this->db->query('SELECT * FROM images_articles_AV WHERE `article_id` IN (' . implode(',', array_map('intval', $ids)) . ')');
            foreach ($_images as $k => $v) {
                $images[$v['article_id']] = $v;
            }

            unset($_images);
            foreach ($this->_cityArticles as $id => $article) {
                if (isset($images[$id]) && file_exists('.' . $images[$id]['image_path'])) {
                    $this->_cityArticles[$id]['images']['AV'] = $images[$id];
                } else {
                    $this->_cityArticles[$id]['images']['AV'] = array('image_path' => OTP_DEFAULT_ARTICLE_AVATAR, 'alt' => '', 'type' => 'AV');
                }
            }
            unset($images);
        }
    }

    protected function getCityGallery() {
        $gallery = array();
        if (empty($this->options['id']))
            return $gallery;

        $_gallery = $this->db->query('SELECT * FROM images_cities_GL WHERE `city_id` = ' . $this->options['id'] . ' ORDER BY `order_by`');
        
        foreach($_gallery as $k => $v) {
            if(file_exists('.' . $v['image_path'])) {
                $gallery[$k] = $v;
                if(empty($v['avatar_path']) || !file_exists('.' . $v['avatar_path'])) {
                    $gallery[$k]['avatar_path'] = $v['image_path'];
                }
            }
        }

        return $gallery;
    }
    
    protected function getPages() {
        if(empty($this->_countArticles)) {
            $this->_countArticles = $this->db->query_first_cell('SELECT COUNT(*) FROM articles WHERE `city_id` = ' . $this->options['id'] . ' AND `active` = 1');
        }
        $pages = $this->getPagesNavigations($this->_countArticles);
        
        return $pages;
    }

}

?>
