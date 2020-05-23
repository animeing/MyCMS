<?php
namespace db\dto;

use db\base\DtoBase;
use db\table\IExtensionTable;

class ExtensionDto extends DtoBase implements IExtensionTable{
    
    public function setExtensionName($extensionName){
        parent::putDtoCache(self::EXTENSION_NAME, $extensionName);
    }

    public function getExtensionName(){
        return parent::getDtoCache(self::EXTENSION_NAME);
    }

    public function setIsUse($isUse){
        parent::putDtoCache(self::IS_USE, $isUse);
    }

    public function getIsUse(){
        return parent::getDtoCache(self::IS_USE);
    }

    public function setExtensionDescription($draftDay){
        parent::putDtoCache(self::EXTENSION_DESCRIPTION, $draftDay);
    }

    public function getExtensionDescription(){
        return parent::getDtoCache(self::EXTENSION_DESCRIPTION);
    }

    public function setInstallDay($installDay){
        parent::putDtoCache(self::INSTALL_DAY, $installDay);
    }

    public function getInstallDay(){
        return parent::getDtoCache(self::INSTALL_DAY);
    }

    public function setChangeDay($changeDay){
        parent::putDtoCache(self::CHANGE_DAY, $changeDay);
    }

    public function getChangeDay(){
        return parent::getDtoCache(self::CHANGE_DAY);
    }

    public function setCallAllowContent($callAllowContent){
        parent::putDtoCache(self::CALL_ALLOW_CONTENT, $callAllowContent);
    }

    public function getCallAllowContent(){
        return parent::getDtoCache(self::CALL_ALLOW_CONTENT);
    }

    private $instance;
    public function setExeInstance($instance){
        $this->instance = $instance;
    }

    public function getExeInstance(){
        return $this->instance;
    }
}
