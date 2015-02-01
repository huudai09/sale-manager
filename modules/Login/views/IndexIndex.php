<?php

$f = new Form();
$f
        ->addField(array(
            'content' => Tag::input('username', null, array(
                'placeholder' => 'Tài khoản'
            ))
        ))
        ->addField(array(
            'content' => Tag::inputPassword('password', null, array(
                'placeholder' => 'Mật khẩu'
            ))
        ))
        ->addButtons();
e(Tag::center(
                '<h2 style="margin: 30px 0px;font-size: 30px;text-transform: uppercase;">Đăng nhập</h2>'
                . $f->getHTML(), array('style' => 'margin-top: 150px;')
));
?>