<?php

namespace Tags\Parts;

abstract class Node implements INode{

    abstract public function hasPossibleToChildren();
    /**
     * @param HttpTagBase
     */
    protected $parent;
    /**
     * @param Array
     */
    private $children;
    function __construct()
    {
        $this->children = array();
    }
    /**
     * @param HttpTagBase|string $value 
     */
    function appendChild($value, $key=null){
        if($value instanceof HttpTagBase){
            $value->parent = $this;
        }
        if($key == null || $key instanceof HttpTagBase){
            $this->children[sha1(serialize($value))] = $value;
        } else {
            $this->children[$key] = $value;
        }
    }

    function removeChild($value){
        if($value instanceof HttpTagBase){
            unset($this->children[sha1(serialize($value))]);
        } else {
            unset($this->children[$value]);
        }
    }

    /**
     * @return HttpTagBase
     */
    public function getParent(){
        return $this->parent;
    }

    /**
     * @return HttpTagBase[]
     */
    public function children(){
        return $this->children;
    }
}
