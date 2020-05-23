<?php

namespace db\dao;

use db\dto\ContentDto;
use db\table\IContentTable;
use SqlCreater;

class ContentDao extends SqlCreater implements IContentTable{

    /**
     * @Override
     */
    function createDto()
    {
        return new ContentDto();
    }
}
