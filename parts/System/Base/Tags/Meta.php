<?php

namespace Tags;

use ArrayObject;
use Tags\Parts\HttpTagBase;
use Tags\Parts\CreateValueElement;

class Meta extends HttpTagBase{

    function __construct()
    {
        parent::__construct();
        $this->setCreateElement(new CreateValueElement());
    }

    function getTagName()
    {
        return 'meta';
    }

    function getChildren(){
        return new ArrayObject();
    }
}