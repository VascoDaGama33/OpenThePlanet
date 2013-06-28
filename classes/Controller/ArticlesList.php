<?php

include_once OTP_PATH_CONTROLLER.'Controller.php';


class Controller_ArticlesList extends Controller {
    
    
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
        $model = Model::getModel('Model_Templating_ArticlesList');

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
                    2 => 'components/mc_best_post.tpl.php', 
                    ),
                'extra_components' => array(
                    0 => 'components/ec_intresting.tpl.php',
                    1 => 'components/ec_other_country.tpl.php',
                    ),
                ),
            )
        );
        $viewer = Viewer::getInstance($val);
        $tpl = $viewer->getTemplate();
        
        return $tpl;
    }
    
}

?>
