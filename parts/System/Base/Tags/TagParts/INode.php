<?php

namespace Tags\Parts;

interface INode{
    /**
     * 子要素を保持することができるか
     */
    public function hasPossibleToChildren();
}
