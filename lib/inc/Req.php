<?php

class Req {

    public static function location($url = '', $inside = true) {
        $url = URL . '/' . $url;
        header('Location: ' . $url);
    }

    public static function isPost() {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

}
