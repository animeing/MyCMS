<?php

class SimpleIterator extends IteratorBase{
	private $clazz;
	public function __construct(){
		$this->clazz = new ArrayObject();
	}

	public function add($clazz){
		$this->clazz[] = $clazz;
	}

	public function getIterator(){
		return $this->clazz->getIterator();
	}

	public function count(){
		return $this->clazz->count();
	}
}
