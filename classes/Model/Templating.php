<?php

include_once OTP_PATH_MODEL . 'Model.php';


class Model_Templating extends Model {
    
    
    
    
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
    

    
    
    #############################
    #######               #######
    #######   Get Head    #######
    #######               #######
    #############################
    
    protected function getHead() {
        $section = array();

        if(empty($this->options['section']))
                return $categories;

        $categories = $this->db->query_first('SELECT * FROM categories WHERE `section_id` = "' . $this->options['section'] . '"');
        
        $country = '';
        
        if(!empty($this->options['country'])) {
            $country .= $this->db->query_first_cell('SELECT countryName FROM countries WHERE `id` = "' . $this->options['country'] . '"');
            if(empty($country))
                $country = '';
        }

        $head = array(
            'title' => !empty($categories['category_name'])? $categories['category_name'] . ' - ' . $country . ' - Open The Planet' : $country . ' Open The Planet', 
            'description' =>  !empty($categories['meta_description'])? $categories['meta_description'] . ' ' . $country . '.' : '', 
            'keywords' =>   !empty($categories['meta_keywords'])? $categories['meta_keywords'] . ', ' . $country : '', 
            );

        return $head;  
    }
    
    
    
    #############################
    #######               #######
    #######  Get Header   #######
    #######               #######
    #############################
    
    protected function getHeader() {
        $header = array();

        $header['slider'] = $this->getSlider();
        $header['categories'] = $this->getCategories();
        $header['country_logo'] = $this->getCountryLogo();
        
        return $header;
    }
    
    protected function getSlider() {
        $slider = array();
        if(empty($this->options['country']) || empty($this->options['section']))
                return $slider;
        
        $category_id = $this->db->query_first_cell('SELECT `id` FROM categories WHERE `section_id` = ' . $this->options['section']);
        if (!empty($category_id)) {
              $slider = $this->db->query('SELECT * FROM images_slider WHERE `country_id` = ' . $this->options['country'] . ' AND `category_id` = ' . intval($category_id) . ' ORDER BY RAND(), `order_by` LIMIT 15');  
        }
        
        if(empty($slider)) {
            $slider = $this->db->query('SELECT * FROM images_slider WHERE `country_id` = ' . $this->options['country'] . ' ORDER BY RAND() LIMIT 7');
        }

        return $slider;
    }
    
    protected function getCountryLogo() {
        $logo = array();
        
        if(empty($this->options['country']))
            return $logo;
        
        $_logo = $this->db->query_first_cell('SELECT logo_path FROM countries WHERE `id` = ' . $this->options['country'] );
        
        if(!empty($_logo) && file_exists('.' . $_logo)) {
            $logo = array('image_path' => $_logo, 'country_id' => $this->options['country']);
        }
        
        return $logo;
    }


    protected function getCategories() {
        $categories = array();
        
        $_categories = $this->db->query('SELECT * FROM categories WHERE `active` = 1 ORDER BY `order_by`');
        
        if(!empty($_categories) && is_array($_categories)) {
            $cities_section = $this->db->query_first_cell('SELECT id FROM sections WHERE `section` = "cities"');
            foreach($_categories as $k => $v) {
                $categories[$v['id']]['menu'] = $v;
                $categories[$v['id']]['sub_menu'] = array();
                if(!empty($cities_section) && $v['section_id'] == $cities_section) {
                   $cities = $this->db->query('SELECT * FROM cities WHERE `country_id` = ' . $this->options['country'] . ' ORDER BY `order_by`');
                   foreach($cities as $city) {
                       $categories[$v['id']]['sub_menu'][$city['id']] = array('name' => $city['city_name'], 'link_data' => array('country' => $city['country_id'], 'section' => $cities_section, 'id' => $city['id']));
                   }
                }
            }
        }

        return $categories;
    }
    
    
    
    #############################
    #######               #######
    #######  Get Content  #######
    #######               #######
    #############################
    
    protected function getContent() {
        return array();
    }

    protected function getBestPosts() {
        $best_posts = array();
        $images = array();
        $_best_posts = $this->db->query('SELECT id, country_id, title, prev_description FROM articles WHERE `country_id` = ' . $this->options['country'] . ' ORDER BY RAND() LIMIT 8');
        foreach($_best_posts as $k => $v) {
            $best_posts[$v['id']] = $v;
        }
        $posts_ids = array_keys($best_posts);
        if(!empty($posts_ids)) {
            $_images = $this->db->query('SELECT * FROM images_articles_AV WHERE `article_id` IN (' . implode(',', array_map('intval',$posts_ids)) . ')');
            foreach($_images as $k => $v) {
                $images[$v['article_id']] = $v;
            }
            unset($_images);
        }
        
        foreach($best_posts as $id => $article) {
            if(isset($images[$id]) && file_exists('.' . $images[$id]['image_path'])) {
                $best_posts[$id]['images']['AV'] = $images[$id];
            } else {
                $best_posts[$id]['images']['AV'] = array('image_path' => OTP_DEFAULT_ARTICLE_AVATAR, 'alt' => '', 'type' => 'AV');
            }
        }
        unset($images);
        return $best_posts;
    }
    
    protected function getIntresting() {
        $intresting = $this->db->query_first('SELECT * FROM intresting WHERE `country_id` = ' . $this->options['country'] . ' ORDER BY RAND() LIMIT 1');
        return $intresting;
    }
    
    protected function getOtherCountry() {
        $other_country = array();
        $other_country = $this->db->query('SELECT * FROM countries WHERE `active` = 1 ORDER BY `order_by`');
        return $other_country;
    }






    #############################
    #######               #######
    #######  Get Footer   #######
    #######               #######
    #############################
    
    protected function getFooter() {
        return array();
    }
    
    
    
    
    #############################
    #######               #######
    ####   Module methods   #####
    #######               #######
    #############################
    
    public function getPagesNavigations($count_articles) {
        $res = array();

        if(empty($this->options['page']) || $this->options['page'] < 1 || empty($count_articles) || $count_articles < 2)
                return $res;
        
        $per_page =  defined('OTP_ARTICLES_PER_PAGE') ? OTP_ARTICLES_PER_PAGE : 10;
        $count_pages = ceil($count_articles / $per_page);
        $pageButtons = 5;
        
        if($count_pages < $this->options['page'])
            return $res;
        
        $res['pages'][$this->options['page']] = $res['current_page'] = $this->options['page'];
        
        $count_show_pages = min($count_pages, $pageButtons);
        
        $_next = $_prev = $this->options['page'];
        $locker = false;
        
        
        while(count($res['pages']) < $count_show_pages) {
            $_next++;
            $_prev--;
            
            if($_prev > 0) {
                $res['pages'][$_prev] = $_prev;
                if(!$locker) {
                    $res['prev'] = $_prev;
                }
            }
            if($_next <= $count_pages) {
                $res['pages'][$_next] = $_next;
                if(!$locker) {
                    $res['next'] = $_next;
                }
            }
            $locker = true;
        }

        sort($res['pages']);

        return $res;
    }
    
    
    
}

?>
