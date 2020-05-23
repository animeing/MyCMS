<?php

namespace db\base;
use db\base\ISql;
use Dictionary;

/**
 * DtoのBase classです。
 */
abstract class DtoBase implements ISql{
    private $dtoCache = array();

    protected function putDtoCache($key, $data){
        $this->dtoCache[$key] = $data;
    }
    private function getDtoCacheParam($key){
        if(isset($this->dtoCache[$key])){
            return $this->dtoCache[$key];
        } else {
            return null;
        }
    }
    public function putAllDtoCache(array $dto){
        $this->dtoCache = $dto;
    }
    /**
     * @param mixed $key Dtoの値を返します。 nullの場合、すべて返します。
     */
    public function getDtoCache($key = null){
        if($key == null){
            return $this->dtoCache;
        } else {
            return $this->getDtoCacheParam($key);
        }
    }
    public function getPrimaryKey(){
        return $this->getDtoCache()[$this::PRIMARY_KEY];
    }
}