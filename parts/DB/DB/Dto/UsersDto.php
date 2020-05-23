<?php
namespace db\dto;
use db\table\IUsers;
use db\base\DtoBase;

class UsersDto extends DtoBase implements IUsers{
    
    public function getId(){
        return parent::getDtoCache(IUsers::ID);
    }
    public function setUserName($userName){
        parent::putDtoCache(IUsers::USER_NAME, $userName);
    }
    public function getUserName(){
        return parent::getDtoCache(IUsers::USER_NAME);
    }
    public function setUserPass($pass){
        parent::putDtoCache(IUsers::USER_PASS, $pass);
    }
    public function getUserPass(){
        return parent::getDtoCache(IUsers::USER_PASS);
    }
    public function setMailAddress($mailAddress){
        parent::putDtoCache(IUsers::MAIL_ADDRESS, $mailAddress);
    }
    public function getMailAddress(){
        return parent::getDtoCache(IUsers::MAIL_ADDRESS);
    }
    public function setAutoLoginCheck($autoLoginCheck){
        parent::putDtoCache(IUsers::AUTO_LOGIN_CHECK, $autoLoginCheck);
    }
    public function getAutoLoginCheck(){
        return parent::getDtoCache(IUsers::AUTO_LOGIN_CHECK);
    }
    public function setLastLogin($lastLogin){
        parent::putDtoCache(IUsers::LAST_LOGIN, $lastLogin);
    }
    public function getLastLogin(){
        return parent::getDtoCache(IUsers::LAST_LOGIN);
    }
    public function setLoginTime($loginTime){
        parent::putDtoCache(IUsers::LOGIN_TIME, $loginTime);
    }
    public function getLoginTime(){
        return parent::getDtoCache(IUsers::LOGIN_TIME);
    }
    public function setLanguage($language){
        parent::putDtoCache(IUsers::LANGUAGE, $language);
    }
    public function getLanguage(){
        return parent::getDtoCache(IUsers::LANGUAGE);
    }
}