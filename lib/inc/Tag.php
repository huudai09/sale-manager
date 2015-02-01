<?php

class Tag {

    public static function input($name, $value = '', $attr = array()) {

        $atts = array();
        $attr['name'] = $name;
        $attr['value'] = $value;
        $classes = $attr['class'];

        if (count($attr)) {
            foreach ($attr as $ak => $av) {
                if ($ak == 'class')
                    continue;
                $atts[] = $ak . '="' . $av . '"';
            }
        }

        $atts = count($atts) ? join(' ', $atts) : '';

        return '<input ' . $atts . ' class="aform-inp inp-txt ' . $classes . '" />';
    }

    public static function inputDate($name, $value = '', $attr = array()) {
        $attr['type'] = 'date';
        return self::input($name, $value, $attr);
    }

    public static function inputPassword($name, $value = '', $attr = array()) {
        $attr['type'] = 'password';
        return self::input($name, $value, $attr);
    }

    public static function textarea($name, $value = '') {
        return '<textarea placeholder="Nhập nội dung" class="aform-inp inp-textarea"></textarea>';
    }

    public static function center($html, $attr = array()) {
        $atts = array();
        if (count($attr)) {
            foreach ($attr as $ak => $av) {
                $atts[] = $ak . '="' . $av . '"';
            }
        }

        $atts = count($atts) ? join(' ', $atts) : '';

        return "<center $atts>$html</center>";
    }

    public static function btnSubmit() {
        return '<button class="aform-accept btn">Xác nhận</button>			';
    }

}
