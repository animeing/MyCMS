<?php

namespace Tags\Parts;

interface ICreateElement extends INode{
    /**
     * @param HttpTagBase $tagElement
     * @param array $children
     * @return string
     */
    function create($tagElement);
}