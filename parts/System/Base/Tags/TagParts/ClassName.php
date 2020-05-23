<?php

namespace Tags\Parts;

use ArrayObject;

final class ClassName{
    private $classNames;

    function __construct()
    {
        $this->classNames = new ArrayObject();
    }
    
    public function set($className){
        $this->classNames[$className] = $className;
    }

    public function get($className){
        return $this->classNames[$className];
    }

    public function hasKey($className){
        return $this->classNames->offsetExists($className);
    }

    public function getClassNameString(){
        $classNames = '';
        foreach ($this->classNames as $key => $value) {
            if(strlen($classNames) != 0){
                $classNames .= ' ';
            }
            $classNames .= $value;
        }
        
        if(strlen($classNames) != 0){
            return ' class="'.$classNames.'"';
        } else {
            return "";
        }
    }

}
