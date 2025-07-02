<?php
session_start();
require 'application/config/config.php';
require 'application/libs/application.php';
require 'application/libs/controller.php';

// 상수 로드 시작
$dir = $_SERVER['DOCUMENT_ROOT'] . "/application/config/JsonStructure";
$handle  = opendir($dir);
$files = array();
while (false !== ($filename = readdir($handle)))
{
    if($filename == "." || $filename == "..")
    {
        continue;
    }
    if(is_file($dir . "/" . $filename))
    {
        require_once ($dir . '/' .$filename);
    }
}
// 상수 로드 종료
closedir($handle);
$app = new Application();
$setting = new \system\config\config();
$REQUEST_TIME = $_SERVER['REQUEST_TIME'];

$SESSION_TIMEOUT_DURATION = $setting->SESSION_TIMEOUT_DURATION;

if (isset($_SESSION['LAST_ACTIVITY']) && ($REQUEST_TIME - $_SESSION['LAST_ACTIVITY']) > $SESSION_TIMEOUT_DURATION) {

    session_unset();
    session_destroy();
}
$_SESSION['LAST_ACTIVITY'] = $REQUEST_TIME;
?>
