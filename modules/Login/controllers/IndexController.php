<?php

class LoginIndexController extends Action {

    private function _field() {
        return array(
            'username' => array(
                'label' => 'Tên đăng nhập',
                'type' => 'USERNAME',
                'required' => true
            ),
            'password' => array(
                'label' => 'Mật khẩu',
                'type' => 'PASSWORD',
                'required' => true
            )
        );
    }

    public function indexAction() {
        self::setLayout('Login');
        if (Req::isPost()) {
            $data = new Validate($this->_field());
            $data = $data->getFields();

            if (!is_array($data)) {
                alert($data);
            }

            $data['password'] = md5($data['password']);

            $user = self::$DB->selectRow(""
                    . "SELECT * "
                    . "FROM `users` "
                    . "WHERE `username`='{$data['username']}'"
                    . "AND `is_deleted`='no'");


            if (!count($user)) {
                alert('Tài khoản không tồn tại');
            }

            if ($user['password'] != $data['password']) {
                alert('Mật khẩu không chính xác');
            }

            save_login($user);

            Req::location('Calendar');
        }
    }

}

?>