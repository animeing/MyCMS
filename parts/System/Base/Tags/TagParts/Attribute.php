<?php

namespace Tags\Parts;

use ArrayObject;

class Attribute{
    private $attribute;

    function __construct()
    {
        $this->attribute = new ArrayObject();
    }
    
    public function set($key, $data){
        $this->attribute[$key] = $data;
    }

    public function get($key){
        return $this->attribute[$key];
    }

    public function hasKey($key){
        return $this->attribute->offsetExists($key);
    }

    public function getAttributesString(){
        $attributes = '';
        foreach ($this->attribute as $key => $value) {
            $attributes .= ' '.$key.'="'.$value.'"';
        }
        
        if(strlen($attributes) != 0){
            return $attributes;
        } else {
            return '';
        }
    }

}
