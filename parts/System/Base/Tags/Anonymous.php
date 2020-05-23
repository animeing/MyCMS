<?php

namespace Tags;

use Tags\Parts\HttpTagBase;

class Anonymous extends HttpTagBase{
    private $tagName="";
    function getTagName(){
        return $this->tagName;
    }

    function setTagName($tagName){
        $this->tagName = $tagName;
    }

}
