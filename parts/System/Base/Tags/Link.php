<?php

namespace Tags;

use ArrayObject;
use Tags\Parts\CreateValueElement;
use Tags\Parts\HttpTagBase;

class Link extends HttpTagBase{

    function __construct()
    {
        parent::__construct();
        $this->setCreateElement(new CreateValueElement());
    }

    function getTagName()
    {
        return 'link';
    }

    function getChildren(){
        return new ArrayObject();
    }
}