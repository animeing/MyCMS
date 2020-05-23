<?php

namespace db\dto;
use db\table\IAccessTrackingTable;
use db\base\DtoBase;

class AccessTrackingDto extends DtoBase implements IAccessTrackingTable{
    
    public function setIpAddress($ipAddress){
        parent::putDtoCache(IAccessTrackingTable::IP_ADDRESS, $ipAddress);
    }
    public function getIpAddress(){
        return parent::getDtoCache(IAccessTrackingTable::IP_ADDRESS);
    }
    public function setAccessUrl($accessUrl){
        parent::putDtoCache(IAccessTrackingTable::ACCESS_URL, $accessUrl);
    }
    public function getAccessUrl(){
        return parent::getDtoCache(IAccessTrackingTable::ACCESS_URL);
    }
    public function setAccessRequestHeader($requestHeader){
        parent::putDtoCache(IAccessTrackingTable::ACCESS_REQUEST_HEADER, $requestHeader);
    }
    public function getAccessRequestHeader(){
        return parent::getDtoCache(IAccessTrackingTable::ACCESS_REQUEST_HEADER);
    }
    public function setAccessResponseHeader($responseHeader){
        parent::putDtoCache(IAccessTrackingTable::ACCESS_RESPONSE_HEADER, $responseHeader);
    }
    public function getAccessResponseHeader(){
        return parent::getDtoCache(IAccessTrackingTable::ACCESS_RESPONSE_HEADER);
    }
    public function setTimeStamp($timestamp){
        parent::putDtoCache(IAccessTrackingTable::TIME_STAMP, $timestamp);
    }
    public function getTimeStamp(){
        return parent::getDtoCache(IAccessTrackingTable::TIME_STAMP);
    }
}
