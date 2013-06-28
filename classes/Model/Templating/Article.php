<?php

include_once OTP_PATH_MODEL . 'Model/Templating.php';

class Model_Templating_Article extends Model_Templating {

    protected $_article = array();

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
        $categories = array();

        if (empty($this->options['section']))
            return $categories;

        $article = $this->getArticleData();
        $head = array(
            'title' => !empty($article['title']) ? $article['title'] . ' - Open The Planet' : 'Open The Planet',
            'description' => !empty($article['prev_description']) ? $article['prev_description'] : '',
            'keywords' => !empty($article['meta_keywords']) ? $article['meta_keywords'] : '',
        );

	 if(!empty($article['title'])) {
            $head['description'] .= ' ' . $article['title'] . '. Open The Planet';
        }

        return $head;
    }

    protected function getSlider() {
        $slider = array();
        if (empty($this->options['country']) || empty($this->options['section']))
            return $slider;

        $article = $this->getArticleData();
        if (!empty($article['category_id'])) {
            $slider = $this->db->query('SELECT * FROM images_slider WHERE `country_id` = ' . $this->options['country'] . ' AND `category_id` = ' . intval($article['category_id']) . ' ORDER BY RAND(), `order_by` LIMIT 10');
        }
        if (empty($slider)) {
            $slider = $this->db->query('SELECT * FROM images_slider WHERE `country_id` = ' . $this->options['country'] . ' ORDER BY RAND() LIMIT 5');
        }

        return $slider;
    }

    protected function getContent() {
        $content = array();

        $content['mc_article'] = $this->getArticle();
        $content['mc_best_posts'] = $this->getBestPosts();
        $content['mc_gallery'] = $this->getArticleGallery();
        $content['ec_intresting'] = $this->getIntresting();
        $content['ec_other_country'] = $this->getOtherCountry();

        return $content;
    }

    protected function &getArticleData() {
        if (empty($this->_article)) {
            $this->_article = $this->db->query_first('SELECT * FROM articles WHERE `id` = ' . $this->options['id']);
        }
        return $this->_article;
    }

    protected function getArticle() {
        $res = array('main' => array(), 'images' => array());

        if (empty($this->options['id']))
            return $res;

        $res['main'] = $this->getArticleData();

        if (!empty($res['main']['id'])) {
            $res['images'] = $this->getArticleImages($res['main']['id']);
        }

        return $res;
    }

    protected function getArticleImages($id) {
        $res = array();

        $main = $this->db->query_first('SELECT * FROM images_articles_M WHERE `article_id` = ' . intval($id) . ' AND `type` = "M"');

        if (!empty($main['type']) && !empty($main['image_path'])) {
            if(file_exists('.' . $main['image_path'])) {
                $res[$main['type']] = $main;
            } else {
                $res['M'] = array('image_path' => OTP_DEFAULT_ARTICLE_MAIN, 'alt' => '', 'type' => 'M');
            }
        }

        $gallery = $this->db->query('SELECT * FROM images_articles_GL WHERE `article_id` = ' . intval($id));

        foreach ($gallery as $k => $v) {
            if (!empty($v['type'])) {
                $res[$v['type']][] = $v;
            }
        }

        return $res;
    }

    protected function getArticleGallery() {
        $gallery = array();
        if (empty($this->options['id']))
            return $gallery;

        $_gallery = $this->db->query('SELECT * FROM images_articles_GL WHERE `article_id` = ' . $this->options['id'] . ' ORDER BY `order_by`');
        
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

}

?>
