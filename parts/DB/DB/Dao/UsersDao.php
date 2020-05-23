<?php
namespace db\dao;

use SqlCreater;
use db\table\IUsers;
use db\dto\UsersDto;

class UsersDao extends SqlCreater implements IUsers{
    function createDto()
    {
        return new UsersDto();
    }
}
