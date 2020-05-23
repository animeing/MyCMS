<?php

namespace admin\page\user;

use BrowserUtil;
use db\dto\UsersDto;
use FileUtil;

class UserViewController{

    private $userDto;

    public function getUserDto(){
        return $this->userDto;
    }

    public function setUserDto($userDto){
        $this->userDto = $userDto;
    }

    public function upsertUserData($userName, $password, $mailAddress, $language){
        if(!FileUtil::isPossibleChangeSettingData() || strpos($userName, '/')){
            return;
        }
        /**
         * @var UsersDto $userDto
         */
        $userDto = $this->userDto($userName);
        if($userDto == null){
            //新規User登録
            if($password == null){
                return;
            }
            $userDto = new UsersDto;

            $userDto->setUserPass(password_hash($password, PASSWORD_BCRYPT));
        } else {
            //更新
            if(!password_verify($userDto->getUserPass(), BrowserUtil::getPostParam('userOldPassword'))){
                //現在のパスワードが一致しない
                return;
            }
            if(BrowserUtil::getPostParam('userConfirmPassword') != null && 
            BrowserUtil::getPostParam('userConfirmPassword') === BrowserUtil::getPostParam('userNewPassword')){
                $userDto->setUserPass(password_hash(BrowserUtil::getPostParam('userNewPassword'), PASSWORD_BCRYPT));
            }
        }
        $userDto->setUserName($userName);
        $userDto->setMailAddress($mailAddress);
        $userDto->setLanguage($language);
        FileUtil::write(
            FileUtil::getFilePath(CONTENT_DIRECTORY.'Admin/Users/', $userName.'.json'),
            json_encode($userDto->getDtoCache()),
            'w+'
        );
    }

    public function getUserDtos(){
        if(!FileUtil::isPossibleChangeSettingData()){
            return array();
        }
        $usersDto = array();
        $usersDao = new \db\dao\UsersDao;
        foreach(FileUtil::getFileNames(CONTENT_DIRECTORY.'Admin/Users/') as $userDataPath){
            $usersDto[] = $usersDao->toDto(FileUtil::readJsonDecode($userDataPath));
        }
        return $usersDto;
    }

    public function userDto($userName){
        if(!FileUtil::isPossibleChangeSettingData()){
            return null;
        }
        $usersDao = new \db\dao\UsersDao;
        return $usersDao->toDto(FileUtil::readJsonDecode(FileUtil::getFilePath(CONTENT_DIRECTORY.'Admin/Users/', $userName.'.json')));
    }

}
