<?php

Class Action {

    static $uri;
    static $layout = true;
    static $DB;
    public static $param = array();

    public function __construct() {
        self::$DB = new DB();
    }

    public static function set($arr) {
        if (is_array($arr)) {
            foreach ($arr as $k => $ar) {
                self::$param[$k] = $ar;
            }
        }
    }

    public static function get($name) {
        if (array_key_exists($name, self::$param)) {
            return self::$param[$name];
        }
    }

    public static function removeLayout() {
        self::$layout = false;
    }

    public static function setLayout($name) {
        self::$layout = $name;
    }

    public static function clarifyContent($html) {
        $pattern = "|{@([\d\w\.]+):([\d\w\.]+)}|";
        $callback = function($m) {
            return $m[2];
        };

        $pure = preg_replace_callback($pattern, $callback, $html);

        if (array_key_exists('_json', $_REQUEST)) {
            return json_encode(array(
                title => 'CCCC',
                content => $pure
            ));
        } else {
            return $pure;
        }
    }

    public static function getModule() {
        return self::$uri['module'];
    }

    public function setContentJSON() {
        $this->loadContent();
        die();
    }

    public function loadContent() {
        ob_start(array(self, 'clarifyContent'));
        // Module Layout
        if (self::$layout) {
            if (!is_string(self::$layout)) {
                include implode('/', array('modules', self::$uri['module'], self::$uri['module'] . '.php'));
            }
        }
        // Module View
        include implode('/', array('modules', self::$uri['module'], 'views', self::$uri['controller'] . self::$uri['action'] . '.php'));
        ob_end_flush();
    }

    public function run() {
        if (method_exists($this, 'init'))
            $this->init();

        if (self::$uri['action']) {
            $action = self::$uri['action'] . "Action";
            $this->$action();
            if (array_key_exists('_json', $_REQUEST)) {
                header('Content-type: application/json');
                $this->setContentJSON();
            }

            // Main Layout
            if (self::$layout) {
                if (is_string(self::$layout)) {
                    include implode('/', array('modules', self::$uri['module'], self::$layout . '.php'));
                    return;
                }
                require_once implode('/', array('modules', 'Layout.php'));
            }
        }
    }

}
