<?php

namespace content;

use ArrayObject;
use BrowserUtil;
use DateTime;
use db\dto\AccessTrackingDto;
use StringUtil;

class HttpHeader implements \Serializable{
    private $headerData;

    public function __construct()
    {
        $this->headerData = new ArrayObject();
    }

    public function set($key, &$data){
        $this->headerData[$key] = &$data;
    }

    public function get($key){
        return $this->headerData[$key];
    }

    public function hasKey($key){
        return $this->headerData->offsetExists($key);
    }

    public function run(){
        foreach ($this->headerData as $key => $value) {
            
        }
    }

    public function getRequestHeader(){
        $requestHeaderInfomation = new AccessTrackingDto();
        $requestHeaderInfomation->setIpAddress($_SERVER['REMOTE_ADDR']);
        $requestHeaderInfomation->setAccessResponseHeader(BrowserUtil::headerToString(headers_list()));
        $requestHeaderInfomation->setAccessRequestHeader(BrowserUtil::headerToString(getallheaders()));
        $dateTime = new DateTime();
        $requestHeaderInfomation->setTimeStamp($dateTime->format(StringUtil::TIME_STAMP_FORMAT));
        $requestHeaderInfomation->setAccessUrl(BrowserUtil::getCurrentUrl());
        return $requestHeaderInfomation;
    }

    /**
     * @override
     */
    public function serialize(){
        return $this->headerData->serialize();
    }

    /**
     * @override
     */
    public function unserialize($serialized){
        $this->headerData->unserialize($serialized);
    }
}
