<?php

include_once OTP_PATH_MODEL . 'Model/Templating.php';

class Model_Templating_ArticlesList extends Model_Templating {
    
    
    protected $_articlesList = array();
    
    protected $_category_id = null;
    
    protected $_countArticles = null;

    
    
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
        
        $content['mc_articles_list'] = $this->getArticlesData();
        $content['mc_pages'] = $this->getPages();
        $content['mc_best_posts'] = $this->getBestPosts();
        $content['ec_intresting'] = $this->getIntresting();
        $content['ec_other_country'] = $this->getOtherCountry();

        return $content;
    }
    
    
    protected function &getArticlesData() {
        if(empty($this->_articlesList)) {
            $category_id = $this->getCategory();
            if($category_id) {
                $per_page =  defined('OTP_ARTICLES_PER_PAGE') ? OTP_ARTICLES_PER_PAGE : null;
                if(!empty($this->options['page']) && $this->options['page'] > 1) {
                    $limit = !empty($per_page) ? ' LIMIT ' . intval($this->options['page'] * $per_page - $per_page) . ',' . $per_page : '';
                } else {
                    $limit = !empty($per_page) ? ' LIMIT ' . $per_page : '';
                }
                
                $articles = $this->db->query('SELECT id, category_id, country_id, city_id, meta_keywords, datetime, title, prev_description, short_description FROM articles WHERE `category_id` = ' . intval($category_id) . ' AND `country_id` = ' . intval($this->options['country']) . ' AND `active` = 1 ORDER BY `datetime` DESC' . $limit );

                foreach($articles as $k => $v) {
                    $this->_articlesList[$v['id']] = $v;
                }

                $this->setArticlesImages();
            }
        }
        
        return $this->_articlesList;
    }
    
    protected function setArticlesImages() {
        
        if(!is_array($this->_articlesList) || empty($this->_articlesList))
            return ;
        
        $ids = array_keys($this->_articlesList);
        
        if(!empty($ids)) {
            $images = array();
            $_images = $this->db->query('SELECT * FROM images_articles_AV WHERE `article_id` IN (' . implode(',', array_map('intval',$ids)) . ')');
            foreach($_images as $k => $v) {
                $images[$v['article_id']] = $v;
            }
            unset($_images);
            foreach($this->_articlesList as $id => $article) {
                if(isset($images[$id]) && file_exists('.' . $images[$id]['image_path'])) {
                    $this->_articlesList[$id]['images']['AV'] = $images[$id];
                } else {
                    $this->_articlesList[$id]['images']['AV'] = array('image_path' => OTP_DEFAULT_ARTICLE_AVATAR, 'alt' => '', 'type' => 'AV');
                }
            }
            unset($images);
        }
        
    }
    
    
    protected function getCategory() {
        if(empty($this->_category_id) && !empty($this->options['section'])) {
            $this->_category_id = $this->db->query_first_cell('SELECT `id` FROM categories WHERE `section_id` = ' . intval($this->options['section']) );
        }
        return $this->_category_id;
    }
    
    protected function getPages() {
        if(empty($this->_countArticles)) {
            $category_id = $this->getCategory();
            $this->_countArticles = $this->db->query_first_cell('SELECT COUNT(*) FROM articles WHERE `category_id` = ' . intval($category_id) . ' AND `country_id` = ' . intval($this->options['country']) . ' AND `active` = 1');
        }
        $pages = $this->getPagesNavigations($this->_countArticles);
        
        return $pages;
    }
    
    
    
}

?>
