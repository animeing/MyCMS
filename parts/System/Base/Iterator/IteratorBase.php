<?php

interface IIteratorBase extends Traversable{
	function getIterator();
}

abstract class IteratorBase implements IteratorAggregate, IIteratorBase, Ilist{
	function getIterator(){
		parent::getIterator();
	}
}
