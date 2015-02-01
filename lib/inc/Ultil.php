<?php

class Ultil {
    /*
     * Phương thức này cho phép xử lý thông tin SESSION, theo 3 cách
     * 1. Session::session() => Trả về tất cả thông tin trong $_SESSION
     * 2. Session::session('name') => Trả về giá trị cửa SESSION đc chỉ định theo tên
     * 3. Session::session('name', 'value') => Gán giá trị cho SESSION
     */

    public static function session() {
        $num = func_num_args();
        if ($num == 0)
            return $_SESSION;
        if ($num == 1) {
            $name = func_get_arg(0);
            return $_SESSION[USER . $name];
        }

        if ($num >= 2) {
            $name = func_get_arg(0);
            $value = func_get_arg(1);
            if ($value === null) {
                unset($_SESSION[USER . $name]);
            } else {
                $_SESSION[USER . $name] = $value;
            }
        }
    }

    /*
     * Phương thức này cho phép xử lý thông tin COOKIE, theo 3 cách
     * 1. Session::cookie() => Trả về tất cả thông tin trong $_COOKIE
     * 2. Session::cookie('name') => Trả về giá trị cửa COOKIE đc chỉ định theo tên
     * 3. Session::cookie('name', 'value') => Gán giá trị cho COOKIE
     */

    public static function cookie() {
        $num = func_num_args();
        if ($num == 0) {
            return $_COOKIE;
        } else if ($num == 1) {
            $name = func_get_arg(0);
            return $_COOKIE[USER . $name];
        } else if ($num >= 2) {
            $name = func_get_arg(0);
            $value = func_get_arg(1);
            $time = func_get_arg(2);
            $path = func_get_arg(3);

            if ($time === null)
                $time = 3600 * 24 * 100;
            if ($path === null)
                $path = '/';

            setcookie(USER . $name, $value, $time, $path);
        }
    }

}
