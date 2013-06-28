<?php
if(!defined('OTP_START')) {
  header("HTTP/1.1 404 Not Found");  
}

define('OTP_PATH_ROOT', $_SERVER['DOCUMENT_ROOT'] . DS);
define('OTP_PATH_LIBRARIES', OTP_PATH_BASE . 'libraries/');
define('OTP_PATH_THEMES', OTP_PATH_BASE . 'templates/');
define('OTP_PATH_CONFIG', OTP_PATH_BASE . 'classes/');
define('OTP_PATH_CLASSES', OTP_PATH_BASE . 'classes/');
define('OTP_PATH_CONTROLLER', OTP_PATH_BASE . 'classes/');
define('OTP_PATH_MODEL', OTP_PATH_BASE . 'classes/');


define('OTP_HOST', 'http://'. $_SERVER['HTTP_HOST'] .'/');


define('OTP_DEFAULT_ARTICLE_AVATAR', '/images/_main/def_article_avatar.jpg');
define('OTP_DEFAULT_ARTICLE_MAIN', '/images/_main/def_article_main.jpg');


define('OTP_ARTICLES_PER_PAGE', 4);


define('OTP_MOD_REWRITE', true);

?>
