<?php

namespace Tags;
use Tags\Parts\HttpTagBase;
use Tags\Parts\CreateBlockElement;

class Head extends HttpTagBase{

    function __construct()
    {
        parent::__construct();
        $this->setCreateElement(new CreateBlockElement());
    }

    function getTagName()
    {
        return 'head';
    }

}

