<?php

class DemoIndexController extends Action {

    public function indexAction() {
        self::set(array(
            'color' => '12',
            'post' => array(1, 2, 3, 4, 5, 6)
        ));
    }

    public function viewAction() {

    }

}

?>