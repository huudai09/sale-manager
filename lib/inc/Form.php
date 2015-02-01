<?php

class Form {

    private $fields = array();
    private $has_button = false;
    private $action;
    private $method = 'POST';
    private $ajax = true;

    public function __construct($cfg = array()) {
        $this->action = $cfg['action'] ? $cfg['action'] : join('/', Action::$uri);
        if (count($cfg)) {
            foreach ($cfg as $ck => $cv) {
                if (property_exists($this, $ck)) {
                    $this->$ck = $cv;
                }
            }
        }
    }

    public function addField($f, $bool = false) {
        $f['field_type'] = $bool ? 'multi' : 'single';
        $this->fields[] = $f;
        return $this;
    }

    public function addButtons($b = array()) {
        $this->has_button = true;
        return $this;
    }

    public function getHTML() {

        $html = '';
        if (count($this->fields)) {
            foreach ($this->fields as $k => $field) {
                if ($field['field_type'] === 'single') {
                    $html .= '<div class="aform-row">';
                    $html .= "<h5>{$field['label']}</h5>";
                    $html .= $field['content'];
                    $html .= '</div>';
                } else {
                    $fnum = count($field);
                    if ($fnum) {
                        $field = array_slice($field, 0, $fnum - 1);
                        $html .= '<div class="aform-row af' . count($field) . '">';
                        foreach ($field as $fd) {
                            $html .= '<div class="aform-col">';
                            $html .= "<h5>{$fd['label']}</h5>";
                            $html .= $fd['content'];
                            $html .= '</div>';
                        }
                        $html .= '</div>';
                    }
                }
            }
        }

        if ($this->has_button) {
            $html .= '<div class="aform-row aform-implement">' . Tag::btnSubmit() . '</div>';
        }

        return '<div class="aform-box"><form class="aform ' . ($this->ajax ? 'aform-ajax' : '') . '" method="' . $this->method . '" action="' . url($this->action) . '">' . $html . '</form></div>';
    }

    public function bang() {
        e($this->getHTML());
    }

}
