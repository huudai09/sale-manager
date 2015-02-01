<?php

$baseUrl = str_ireplace('\\', '/', dirname($_SERVER['PHP_SELF']));
$baseUrl = preg_replace('/^\/$/is', '', $baseUrl);
define(DS, DIRECTORY_SEPARATOR);
define(URL, $baseUrl);
define(APP_PATH, dirname(__FILE__));
define(LIB_PATH, APP_PATH . DS . 'lib');
define(APP, $baseUrl . '/modules');
define(ASSET, $baseUrl . '/assets');
define(FILES, $baseUrl . '/files');

require_once 'lib/Root.php';
new ROOT();
?>