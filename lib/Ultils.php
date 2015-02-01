<?php

function e($msg = '') {
    echo $msg;
}

function h2($title) {
    e('<h2 class="h2">' . $title . '</h2>');
}

function url($url) {
    return URL . '/' . $url;
}

function debug() {
    $args = func_get_args();
    if (count($args)) {
        foreach ($args as $arg) {
            echo '<pre>';
            print_r($arg);
            echo '</pre>';
        }
    }
    exit;
}

function output($d) {
    die(json_encode($d));
}

function alert($msg) {
    output(array(
        alert => $msg
    ));
}

function is_login() {
    return Ultil::session('uid');
}

function is_remember_login() {
    return Ultil::cookie('uid');
}

function get_remember_login() {
    $hash = base64_decode(Ultil::cookie('uid'));
    return explode('@', $hash);
}

function save_login($user, $username = null, $password = null) {
    //clear_login();
    Ultil::session('uid', $user['ID']);
    Ultil::session('uname', $user['username']);

    $hash = base64_encode($username . '@' . $password);
    if ($username && $password) {
        Ultil::cookie('uid', $hash, time() + 3600 * 24 * 100, '/');
    } else {
        Ultil::cookie('uid', '', time() - 3600 * 24 * 100, '/');
    }
}

function clear_login() {
    Ultil::session('uid', null);
    Ultil::session('uname', null);
    Ultil::cookie('uid', '', time() - 3600 * 24 * 100, '/');
}

function getConfig() {
    return (array) include APP_PATH . '/config.php';
}

function autoloader($class) {
    $file = LIB_PATH . DS . 'inc' . DS . $class . '.php';

    if (realpath($file))
        include 'inc/' . $class . '.php';
}

spl_autoload_register('autoloader');
