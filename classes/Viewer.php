<?php

class Viewer {

    public $skin = 'modern';
    public $tpl_path = null;
    public $tpl_rel_path = null;
    public $data = array();



    # Path variables for parts files
    public $head = null;
    public $header = null;
    public $content = null;
    public $footer = null;
    public $main_components = array();
    public $extra_components = array();

    function __construct($options = array()) {

        $this->tpl_path = OTP_PATH_THEMES . $this->skin . '/';
        $this->tpl_rel_path = '/templates/' . $this->skin . '/';

        $this->data = !empty($options['data']) ? $options['data'] : $this->data;

        if (!empty($options['files'])) {
            $this->head = !empty($options['files']['head']) && file_exists($this->tpl_path . $options['files']['head']) ? $options['files']['head'] : 'pages/head.tpl.php';
            $this->header = !empty($options['files']['header']) && file_exists($this->tpl_path . $options['files']['header']) ? $options['files']['header'] : 'pages/default_header.tpl.php';
            $this->content = !empty($options['files']['content']) && file_exists($this->tpl_path . $options['files']['content']) ? $options['files']['content'] : 'pages/default_content.tpl.php';
            $this->footer = !empty($options['files']['footer']) && file_exists($this->tpl_path . $options['files']['footer']) ? $options['files']['footer'] : 'pages/default_footer.tpl.php';

            if (!empty($options['files']['main_components'])) {
                foreach ($options['files']['main_components'] as $k => $v) {
                    if (file_exists($this->tpl_path . $v)) {
                        $this->main_components[] = $v;
                    }
                }
            }
            if (!empty($options['files']['extra_components'])) {
                foreach ($options['files']['extra_components'] as $k => $v) {
                    if (file_exists($this->tpl_path . $v)) {
                        $this->extra_components[] = $v;
                    }
                }
            }
        }
    }

    static function &getInstance($options = array()) {

        static $instance;

        if (!isset($instance)) {
            $class_name = __CLASS__;
            $instance = new $class_name($options);
        }
        return $instance;
    }

    public function getTemplate() {
        ob_start();
        include_once $this->tpl_path . 'index.tpl.php';
        $cont = ob_get_contents();
        ob_end_clean();

        return $cont;
    }

    public function loader($file) {
        $file_path = $this->tpl_path . $file;
        $cont = "";
        if (file_exists($file_path)) {
            $extension = pathinfo($file_path, PATHINFO_EXTENSION);
            if (!empty($extension) && $extension === 'php') {
                ob_start();
                include_once $file_path;
                $cont = ob_get_contents();
                ob_end_clean();
            }
        }
        return $cont;
    }

    public function getDataValue($pos, $val = null) {
        $res = array();
        if ($val) {
            if (isset($this->data[$pos][$val])) {
                $res = $this->data[$pos][$val];
            }
        } else {
            if (isset($this->data[$pos])) {
                $res = $this->data[$pos];
            }
        }

        return $res;
    }

    public function getUrl($options = array()) {
        $res = OTP_HOST;
        $res_arr = array();

        if (OTP_MOD_REWRITE) {
            $model = Model::getModel('Model_Viewer');

            foreach ($options as $k => $v) {
                switch ($k) {
                    case 'country':
                        $res_arr[$k] = $model->getCountryName($v);
                        break;
                    case 'section':
                        $res_arr[$k] = $model->getSectionName($v);
                        break;
                    default: $res_arr[$k] = $v;
                }
            }
            if (!empty($res_arr['section']) && !empty($res_arr['id']) && strtolower($res_arr['section']) == 'cities') {
                $res_arr['id'] = $model->getCityName($res_arr['id']);
            }
            $_tpl_arr = array();
            foreach(array('country', 'section', 'id', 'page') as $k => $v) {
                if(!empty($res_arr[$v])) {
                    $_tpl_arr[] = $res_arr[$v];
                } else {
                    // maybe `id` don't need, and `page` need
                    if($v == 'id') {
                        continue;
                    } else {
                        break;
                    }
                }
            }
            if(!empty($_tpl_arr))
                $res .= implode('/', $_tpl_arr) . ''; //.html
        } else {
            $res .= 'index.php';

            foreach ($options as $k => $v) {
                if (!empty($k) && !empty($v)) {
                    $res_arr[] = $k . '=' . $v;
                }
            }

            if (!empty($res_arr)) {
                $res .= '?' . implode('&', $res_arr);
            }
        }

        return $res;
    }

    public function escape($var) {
        $res = htmlspecialchars($var);
        return $res;
    }
    
    public function renderArticleText($text, $need_nl2br = true) {
        $res = '';
        
        if(empty($text))
            return $res;
        
        /*
        $nl_text = explode("\n\n",  $text);
        
        if(!empty($nl_text)) {
            $p_text = array();
            foreach($nl_text as $k => $v) {
                $p_text[] = "<p class=\"articleParagraph\">" . $v . "</p>";
            }
            $_res = implode("", $p_text);

            $res = $need_nl2br ? nl2br($_res) : $_res;
        }*/
        
        $res = $need_nl2br ? nl2br($text) : $text;
        
        return $res;
    }

}

?>
