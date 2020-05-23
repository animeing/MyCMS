<?php

namespace db\dao;
use \SqlCreater;
use db\table\IAccessTrackingTable;
use db\dto\AccessTrackingDto;
use db\base\ISql;

class AccessTrackingTable extends SqlCreater implements IAccessTrackingTable{

    function countAccess(){
        return parent::countWhereQuery(IAccessTrackingTable::IP_ADDRESS.ISql::EQUAL_PARAM);
    }

    /**
     * @Override
     */
    function createDto(){
        return new AccessTrackingDto();
    }
}
