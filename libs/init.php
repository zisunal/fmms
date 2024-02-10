<?php require_once("conf.php"); ?>
<?php
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
if (!empty(SUBDIR)) {
    defined('SITE_ROOT') ? null : define('SITE_ROOT', $_SERVER['HTTP_HOST'] . "/" . SUBDIR);
} else {
    defined('SITE_ROOT') ? null : define('SITE_ROOT', $_SERVER['HTTP_HOST']);
}
defined('INCLUDES_PATH') ? null : define('INCLUDES_PATH', DS . 'includes');
if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
    define('PROTOCOL', 'https://');
} else {
    define('PROTOCOL', 'http://');
}
define("TM_ZONE", "Asia/Kolkata");
date_default_timezone_set(TM_ZONE);
spl_autoload_register(function ($class_name) {
    include str_replace("App\\", "", $class_name) . '.php';
});
require_once "functions.php";
?>