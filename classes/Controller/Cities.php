<?php

include_once OTP_PATH_CONTROLLER.'Controller.php';

class Controller_Cities extends Controller {


    function __construct($options = array()) {
        $this->setOptions($options);
    }

    static function &getInstance($options = array()) {
        
        static $instance;
        
        if(!isset($instance)) {
            $class_name = __CLASS__;
            $instance = new $class_name($options);
        }
        return $instance;
    }
    
    public function getTpl() {

        $values = array();
        
        if(!empty($this->options['id'])) {
            $values = $this->getTplCity($this->options['id']);
        } else {
            $values = $this->getTpCitieslList();
        }

        $viewer = Viewer::getInstance($values);
        $tpl = $viewer->getTemplate();
        
        return $tpl;
    }
    
    
    protected function getTplCity($city_id) {
        $model = Model::getModel('Model_Templating_Cities_City');
        //$model = Model::getModel('Model_Templating_ArticlesList');
        
        if(!$model) {
            die("Error. Can't get template data.");
        }
        
        $val = array();

        $val['data'] = $model->getTplData();

        $val = array_merge($val, array(
            'files' => array(
                'main_components' => array(
                    0 => 'components/mc_articles_list.tpl.php', 
                    1 => 'components/mc_pages.tpl.php',
                    2 => 'components/mc_gallery.tpl.php',
                    3 => 'components/mc_best_post.tpl.php', 
                    ),
                'extra_components' => array(
                    0 => 'components/ec_intresting.tpl.php',
                    1 => 'components/ec_other_country.tpl.php',
                    ),
                ),
            )
        );
        
        return $val;
    }
    
    protected function getTpCitieslList() {
        $model = Model::getModel('Model_Templating_Cities_CitiesList');

        if(!$model) {
            die("Error. Can't get template data.");
        }
        
        $val = array();
        $val['data'] = $model->getTplData();

        $val = array_merge($val, array(
            'files' => array(
                'main_components' => array(
                    0 => 'pages/cities/mc_cities_list.tpl.php', 
                 ),
                'extra_components' => array(
                    0 => 'components/ec_intresting.tpl.php',
                    1 => 'components/ec_other_country.tpl.php'),
                ),
            )
        );
        
        return $val;
    }
    
}

?>
