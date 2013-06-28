<?php


class Router {
    
    
    static function &getInstance() {
        
        static $instance;
        
        if(!isset($instance)) {
            $class_name = __CLASS__;
            $instance = new $class_name();
        }
        return $instance;
    }
    
    public function parse() {

        if(OTP_MOD_REWRITE) {
            $GET = $this->parseRequestUri();
        } else {
            $GET = $_GET;
        }
        
        return !empty($GET) ? $GET : array();
    }
    
    protected function parseRequestUri() {
        $model = Model::getModel('Model_Router');
        
        $GET = array();
        $requestUri = $_SERVER["REQUEST_URI"];
        $pos = strpos($requestUri, '.html');
        if($pos !== false) {
            $requestUri = substr($requestUri, 0, $pos);
        }
        
        $request_params = explode('/', $requestUri);
        
        if(empty($request_params) || !is_array($request_params))
            return $GET;
        
        $setting_params = array(1 => 'country', 2 => 'section', 3 => 'id', 4 => 'page');
        
        foreach($request_params as $k => $v) {
            if(!empty($setting_params[$k])) {
                $GET[$setting_params[$k]] = $v;
            }
        }
        
        if(!empty($GET['country'])) {
            $GET['country'] = $model->getCountryByName($GET['country']);
            if($GET['country'] === null) 
                $this->errorRedirect();
        }
        
        # In section `cities` in `id` transmit city name
        if(!empty($GET['section']) && !empty($GET['id']) && strtolower($GET['section']) == 'cities') {
            $GET['id'] = $model->getCityByName($GET['id']);
            if($GET['id'] === null) 
                $this->errorRedirect();
        }
        if(!empty($GET['section'])) {
            $GET['section'] = $model->getSectionByName($GET['section']);
            if($GET['section'] === null) 
                $this->errorRedirect();
        }

        
        # On page whith Controller_ArticlesList(cookery, traditions, ...) instead `id` transmit `page`
        if(!empty($GET['section']) && !empty($GET['id'])) {
             $controller_name = $model->getControllerName($GET['section']);
             if(!empty($controller_name) && $controller_name == 'Controller_ArticlesList') {
                 $GET['page'] = $GET['id'];
                 unset($GET['id']);
             }
        }
        
        return $GET;
    }


    public function route() {
        $model = Model::getModel('Model_Router');
        
        $parse = $this->parse();
        
        $vars = $model->checkOptions($parse);

        if($vars === false) {
            $this->errorRedirect();
        }

        $country = !empty($vars['country']) ? intval($vars['country']) : 1;  // set default country
        $section = !empty($vars['section']) ? intval($vars['section']) : 1;  // set default section
        $id = !empty($vars['id']) ? intval($vars['id']) : null;
        $page = !empty($vars['page']) ? intval($vars['page']) : 1;

        $options = array('country' => $country, 'section' => $section, 'id' => $id, 'page' => $page);
        
        $controller_name = $model->getControllerName($section);
        
        if(empty($controller_name)) {
            $this->errorRedirect();
        }

        $controller_path = str_replace('_','/', $controller_name);

        if(file_exists(OTP_PATH_CONTROLLER.$controller_path.'.php')) {
            require_once OTP_PATH_CONTROLLER.$controller_path.'.php';
            $controller = $controller_name::getInstance($options);
        } else {
            $this->errorRedirect();
        }
        
        return $controller;
    }
    
    public function errorRedirect() {
        if(file_exists(OTP_PATH_BASE . 'errors/pages/404.html')) {
            ob_start();
            $error_page = file_get_contents(OTP_PATH_BASE . 'errors/pages/404.html');
            echo $error_page;
            ob_end_flush();
            exit();
        } else {
            die('Error 404! File not found.');
        }
        
    }
    

    
    
}

?>
