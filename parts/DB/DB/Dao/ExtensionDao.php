<?php
namespace db\dao;

use db\dto\ExtensionDto;
use db\table\IExtensionTable;
use SqlCreater;

class ExtensionDao extends SqlCreater implements IExtensionTable{

    /**
     * @Override
     */
    function createDto(){
        return new ExtensionDto();
    }
}