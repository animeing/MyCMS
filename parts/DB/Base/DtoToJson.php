<?php

namespace db\base;

class DtoToJson{
    /**
     * @return string
     */
    function converter($dto){
        if(!$dto instanceof DtoBase){
            return;
        }
        return json_encode($dto->getDtoCache());
    }
}
