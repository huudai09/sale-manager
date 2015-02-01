<?php

class Bootstraps extends Action {

    public function init() {
        if (!is_login()) {
            $module = self::getModule();
            if (!in_array($module, array('Login', 'Logout', 'Register'))) {
                Req::location('Login');
            }
        }
    }

}
