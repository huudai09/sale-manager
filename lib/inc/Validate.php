<?php

class Validate {

    private $data = array();
    private $err = array();

    public function __construct($data = array()) {
        if ($data) {
            $this->addFields($data);
        }
    }

    public function addFields($data = array()) {
        if (count($data)) {
            foreach ($data as $name => $opt) {
                $this->_validData($name, $opt);
            }
        }
    }

    public function getFields() {
        if (count($this->err)) {
            $err = implode('', $this->err);
            return $err;
        }

        if (count($this->data)) {
            $data = $this->data;
            return $data;
        }
    }

    private function _validData($name, $opt) {
        $data = $_REQUEST[$name];
        $required = $opt['required'];
        $type = $opt['type'];
        $error = '';

        switch ($type) {
            case 'CHAR':
                $data = filter_var($data, FILTER_SANITIZE_STRING);
                break;

            case 'INT':
                if (!filter_var($data, FILTER_VALIDATE_INT)) {
                    $error = $opt['label'] . ' phải là một số nguyên.';
                }
                break;

            case 'FLOAT':
                if (!filter_var($data, FILTER_VALIDATE_FLOAT)) {
                    $error = $opt['label'] . ' phải là một số thực.';
                }
                break;

            case 'EMAIL':
                if (!filter_var($data, FILTER_VALIDATE_EMAIL)) {
                    $error = $opt['label'] . ' không hợp lệ.';
                }
                break;

            case 'ENUM':
                if ($opt['values'] && is_array($opt['values']) && !in_array($data, $opt['values'])) {
                    $error = $opt['label'] . ' không hợp lệ.';
                }
                break;

            case 'DOMAIN':
                if (!preg_match('#^([a-zA-Z0-9])+$#', $data) || strlen($data) < 3 || strlen($data) > 20) {
                    $error = $opt['label'] . ' không hợp lê. Tên miền phải từ 3 - 20 kí tự, các kí tự chỉ chứa số và chữ.';
                }

                break;

            case 'PHONE':
                if (preg_match('#[a-zA-Z]#', $data)) {
                    $error = $opt['label'] . ' không hợp lệ';
                }
                break;

            case 'USERNAME':
                if (!preg_match('#^([a-zA-Z0-9_])+$#', $data) || strlen($data) < 4 || strlen($data) > 20) {
                    $error = $opt['label'] . ' phải từ 4 - 20 kí tự, bao gồm chữ, số và dấu gạch dưới.';
                }
                break;

            case 'PASSWORD':
                if (strlen($data) < 6) {
                    $error = $opt['label'] . ' phải lớn hơn 6 kí tự và nên bao gồm cả chữ, số, kí tự đặc biệt.';
                }
                break;
        }

        if ($required && empty($data)) {
            $error = $opt['label'] . ' không được để trống.';
        }

        if (!$required && empty($data)) {
            $error = '';
        }

        $this->_setError($error);
        $this->_setData($name, $data);
    }

    private function _setError($e) {
        if ($e) {
            $this->err[] = '<div> - ' . $e . '</div>';
        }
    }

    private function _setData($n, $d) {
        if ($n) {
            $this->data[$n] = $d;
        }
    }

}
