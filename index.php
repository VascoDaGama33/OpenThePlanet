<?php

define('OTP_START', true);
define('DS', DIRECTORY_SEPARATOR);
define('OTP_PATH_BASE', realpath(dirname(__FILE__)) . DS);
error_reporting(E_ALL); // E_ALL

//$start_time = microtime(1);

require_once OTP_PATH_BASE.'includes/defines.php';
require_once OTP_PATH_BASE.'includes/file_includes.php';

//header("Content-Type: text/html; charset=utf-8");


$disp = Dispatcher::getInstance();


$controller = $disp->getController();


$tpl = $controller->getTpl();


echo $tpl;

//die(microtime(1) - $start_time);

?>