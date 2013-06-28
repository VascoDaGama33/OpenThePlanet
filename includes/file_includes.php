<?php
if(!defined('OTP_START')) {
  header("HTTP/1.1 404 Not Found");  
}

require_once OTP_PATH_CONFIG.'Configuration.php';
require_once OTP_PATH_CLASSES . 'Database.php';
require_once OTP_PATH_CLASSES.'Router.php';
require_once OTP_PATH_CLASSES . 'Viewer.php';
require_once OTP_PATH_MODEL . 'Model.php';
require_once OTP_PATH_CLASSES . 'Dispatcher.php';

?>
