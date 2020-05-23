<?php
namespace db\dto;

use db\base\DtoBase;
use db\table\IPaginationTable;

class PaginationDto extends DtoBase implements IPaginationTable{

    public function setUri($uri){
        parent::putDtoCache(IPaginationTable::URI, $uri);
    }

    public function getUri(){
        return parent::getDtoCache(IPaginationTable::URI);
    }

    public function setPageTitle($pageTitle){
        parent::putDtoCache(IPaginationTable::PAGE_TITLE, $pageTitle);
    }

    public function getPageTitle(){
        return parent::getDtoCache(IPaginationTable::PAGE_TITLE);
    }

    public function setDraftDay($draftDay){
        parent::putDtoCache(IPaginationTable::DRAFT_DAY, $draftDay);
    }

    public function getDraftDay(){
        return parent::getDtoCache(IPaginationTable::DRAFT_DAY);
    }

    public function setDescription($description){
        parent::putDtoCache(IPaginationTable::DESCRIPTION, $description);
    }

    public function getDescription(){
        return parent::getDtoCache(IPaginationTable::DESCRIPTION);
    }

    public function setPageData($pageData){
        parent::putDtoCache(IPaginationTable::PAGE_DATA, $pageData);
    }

    public function getPageData(){
        return parent::getDtoCache(IPaginationTable::PAGE_DATA);
    }
}
