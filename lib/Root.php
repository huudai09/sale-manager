<?php

session_start();

$domain = $_SERVER['HTTP_HOST'];
defined('USER') || define('USER', 'freelancer_management_' . md5($domain . '_' . URL));

require_once 'lib/Ultils.php';
require_once 'lib/Action.php';
require_once 'lib/Bootstrap.php';

class ROOT {

    private $uri;

    public function __construct() {
        $ruri = array_filter(explode('/', str_replace(strtolower(URL), '', strtolower($_SERVER['REDIRECT_URL']))));
        $uri = array_map(ucfirst, $ruri);

        if (count($uri) <= 1) {
            $uri += array_fill(0, 3, 'Index');
        }

        $uri = array_combine(array('module', 'controller', 'action'), $uri);
        $this->uri = $uri;

        $this->runBootstraps();

        require_once implode('/', array('modules', $this->uri['module'], 'controllers', $this->uri['controller'] . 'Controller.php'));
        $stdClass = "{$this->uri['module']}{$this->uri['controller']}Controller";
        $module = new $stdClass();
        $module::$uri = $uri;
        $module->run();
    }

    public function runBootstraps() {
		    
        $df_boostrap = new Bootstraps();
        $df_boostrap::$uri = $this->uri;
        $df_boostrap->init();

        $boostrap = APP_PATH . DS . 'modules' . DS . 'Bootstrap.php';
        if (file_exists($boostrap)) {
            include $boostrap;
            $bt = new Bootstraps();
            $bt->run();
        }
    }

    public function loadAsset($path) {
        $mime_type = array(
            'css' => 'text/css',
            'js' => 'application/javascript',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'woff' => 'application/x-font-woff',
            'woff2' => 'application/font-woff2'
        );

        $file = implode('/', $path);
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        if (file_exists($file)) {
            header("Content-type: {$mime_type[$ext]}");
            include $file;
        }
        die();
    }

}
