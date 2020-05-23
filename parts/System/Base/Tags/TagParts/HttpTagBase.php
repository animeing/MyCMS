<?php

namespace Tags\Parts;

use Tags\Parts\Attribute;
use Tags\Parts\ClassName;
use Tags\Parts\Node;

abstract class HttpTagBase extends Node{
    protected $attribute;
    protected $className;
    /**
     * @var ICreateElement
     */
    protected $createElement;
    private $value = 'undefined';

    function __construct()
    {
        $this->attribute = new Attribute();
        $this->className = new ClassName();
    }

    public function hasPossibleToChildren(){
        return $this->getCreateElement()->hasPossibleToChildren();
    }


    /**
     * @return string
     */
    abstract function getTagName();

    protected function createTag(){
        $this->getCreateElement()->create($this);
    }

    function create(){
        $this->createTag();
    }
    
    /**
     * @return ICreateElement
     */
    function getCreateElement(){
        return $this->createElement;
    }

    /**
     * @param ICreateElement $createElement
     */
    function setCreateElement($createElement){
        $this->createElement = $createElement;
    }

    function setValue($value){
        $this->value = $value;
    }

    function getValue(){
        return $this->value;
    }

    function getClassNames(){
        return $this->className;
    }

    function getAttributes(){
        return $this->attribute;
    }
}