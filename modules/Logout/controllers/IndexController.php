<?php

class LogoutIndexController extends Action {

    public function indexAction() {
        if (is_login()) {
            clear_login();
            Req::location('Login');
        }
    }

}

?>