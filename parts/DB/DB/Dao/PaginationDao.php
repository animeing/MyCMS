<?php

namespace db\dao;

use db\dto\PaginationDto;
use db\table\IPaginationTable;
use SqlCreater;

class PaginationDao extends SqlCreater implements IPaginationTable{
    
    /**
     * @Override
     */
    function createDto(){
        return new PaginationDto();
    }
}