<?php

class CalendarIndexController extends Action {

    public function indexAction() {
        self::set(array(
            'color' => '12',
            'post' => array(1, 2, 3, 4, 5, 6)
        ));
    }

    public function addAction() {
        self::removeLayout();
        if (Req::isPost()) {

            output(array(
                close => true,
                reload => true
            ));

            $data = new Validate(array(
                'name' => array(
                    'type' => 'CHAR',
                    'label' => 'Tên khách hàng'
                )
            ));
            $data = $data->getFields();

            if (!is_array($data)) {
                alert($data);
            }

            self::$DB->insert('orders', $data);
            output(array(
                close => true,
                reload => true
            ));
        }
    }

}
