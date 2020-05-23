<?php
namespace db\dto;

use db\base\DtoBase;
use db\table\IContentTable;

class ContentDto extends DtoBase implements IContentTable{

    public function setContentName($contentName){
        parent::putDtoCache(IContentTable::CONTENT_NAME, $contentName);
    }

    public function getContentName(){
        return parent::getDtoCache(IContentTable::CONTENT_NAME);
    }

    public function setContentUri($contentUri){
        parent::putDtoCache(IContentTable::CONTENT_URI, $contentUri);
    }

    public function getContentUri(){
        return parent::getDtoCache(IContentTable::CONTENT_URI);
    }

    public function setContentDay($contentDay){
        parent::putDtoCache(IContentTable::CONTENT_DAY, $contentDay);
    }

    public function getContentDay(){
        return parent::getDtoCache(IContentTable::CONTENT_DAY);
    }

    public function setContentUpdateDay($contentUpDateDay){
        parent::putDtoCache(IContentTable::CONTENT_UPDATE_DAY, $contentUpDateDay);
    }

    public function getContentUpdateDay(){
        return parent::getDtoCache(IContentTable::CONTENT_UPDATE_DAY);
    }

    public function setContentUpUser($contentUpUser){
        parent::putDtoCache(IContentTable::CONTENT_UP_USER_NAME, $contentUpUser);
    }

    public function getContentUpUser(){
        return parent::getDtoCache(IContentTable::CONTENT_UP_USER_NAME);
    }

    public function setContentUpdateUserName($contentUpdateUserName){
        parent::putDtoCache(IContentTable::CONTENT_UPDATE_USER_NAME, $contentUpdateUserName);
    }

    public function getContentUpdateUserName(){
        return parent::getDtoCache(IContentTable::CONTENT_UPDATE_USER_NAME);
    }

    public function setContentGenres($genresArray){
        parent::putDtoCache(IContentTable::CONTENT_GENRE_ARRAY, implode(',', (array)$genresArray));
    }

    public function getContentGenres(){
        return parent::getDtoCache(IContentTable::CONTENT_GENRE_ARRAY);
    }

    public function getContentGenreArray(){
        return explode(',', parent::getDtoCache(IContentTable::CONTENT_GENRE_ARRAY));
    }

}
