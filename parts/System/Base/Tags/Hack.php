<?php

namespace Tags;

use Tags\Parts\HttpTagBase;
use Tags\Parts\CreateBlockElement;

/**
 * Star hack etc 
 */
class Hack extends HttpTagBase{
    private $condition = '';
    function __construct()
    {
        parent::__construct();
        $this->setCreateElement(new CreateBlockElement());
    }

    function setCondition($condition){
        $this->condition = $condition;
    }

    function getCondition(){
        return $this->condition;
    }

    function getTagName()
    {
        return '!--[if '.$this->getCondition().']';
    }

    function createTag(){
        ?>
<<?php echo $this->getTagName();?>>
<?php
foreach((array)$this->children() as $value){
    if(method_exists($value, 'create')){
        $value->create();
    } else {
        echo $value;
    }
}
        ?>
<![endif]-->
<?php
    }
}