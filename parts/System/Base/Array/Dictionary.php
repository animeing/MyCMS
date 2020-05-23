<?php

class Dictionary{
    private $array;
    function __construct()
    {
        $this->array = array();
    }

    function set($key, $value)
    {
        $this->array[$key] = $value;
    }

    function get($key)
    {
        if(isset($this->array[$key])){
            return $this->array[$key];
        } else {
            return null;
        }
    }

    function getArray(){
        return $this->array;
    }
}
