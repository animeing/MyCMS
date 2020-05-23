<?php

namespace Tags;

use Tags\Parts\CreateValueElement;
use Tags\Parts\HttpTagBase;

class StringInline extends HttpTagBase{

    function __construct()
    {
        parent::__construct();
        $this->setCreateElement(new CreateValueElement);
    }

    public function hasPossibleToChildren(){
        return false;
    }

    public function getTagName()
    {
        return null;
    }

    public function createTag(){
        echo $this->value;
    }

}