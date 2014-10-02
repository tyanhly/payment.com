<?php

namespace Base;

class Response {

    public $data;

    public static function renderJson ($data) {
        $r = new self();
        $r->data = $data;
        echo $r->toJson();
    }

    public function toJson () {
        return json_encode($this->data);
    }
}