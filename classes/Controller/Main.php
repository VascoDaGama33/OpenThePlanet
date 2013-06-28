<?php

include_once OTP_PATH_CONTROLLER.'Controller.php';

class Controller_Main extends Controller {
    
    
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
        $model = Model::getModel('Model_Templating_Main');

        if(!$model) {
            die("Error. Can't get template data.");
        }
        $values = array();
        $values['data'] = $model->getTplData();

        $values = array_merge($values, array(
            'files' => array (
                'main_components' => array(
                    0 => 'pages/main/mc_main.tpl.php', 
                    1 => 'components/mc_best_post.tpl.php'),
                'extra_components' => array(
                    0 => 'components/ec_intresting.tpl.php',
                    1 => 'components/ec_other_country.tpl.php'),
                ),
            )
        );

        $viewer = Viewer::getInstance($values);
        $tpl = $viewer->getTemplate();
        
        return $tpl;
    }
    
}

?>
