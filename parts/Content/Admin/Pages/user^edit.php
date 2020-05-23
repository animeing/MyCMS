<?php

global $content;

use admin\page\user\UserViewController;
use db\dto\UsersDto;

FileUtil::existsFileRequire(CONTENT_DIRECTORY.'Admin/Pages/Controller/UserViewController.php');
$userViewController = new UserViewController;

if(BrowserUtil::getPostParam('userName') != null){
    $userViewController->upsertUserData(
        BrowserUtil::getPostParam('userName'),
        BrowserUtil::getPostParam('userPassword'),
        BrowserUtil::getPostParam('userMailaddress'),
        BrowserUtil::getPostParam('userLanguage')
    );
    header("Location: " . BrowserUtil::addGetParam('user', BrowserUtil::getPostParam('userName'), CVV_PAGE_VIEW_URL));
}

$userDto = new UsersDto;
if(BrowserUtil::getGetParam('user')){
    /**
     * @var UsersDto $userDto
     */
    $userDto = 
        ($userViewController->userDto(BrowserUtil::getGetParam('user')) != null) ? 
            $userViewController->userDto(BrowserUtil::getGetParam('user')): 
            new UsersDto;
}
?>

<form action="<?php echo CVV_PAGE_VIEW_URL;?>" method="post" class="form setting">
    <p>User name</p>
    <input type="text" name="userName" value="<?php echo $userDto->getUserName();?>">
    <?php 
    if($userDto->getUserPass() == null){?>
    <p>Password</p>
    <input type="password" name="userPassword">
    <?php
    } else {
    ?>
    <p>Old Password</p>
    <input type="password" name="userOldPassword">
    <p>New Password</p>
    <input type="password" name="userNewPassword">
    <p>Confirmation Password</p>
    <input type="password" name="userConfirmPassword">
    <?php
    }?>
    <p>Mail Address</p>
    <input type="text" name="userMailaddress" value="<?php echo $userDto->getMailAddress();?>">
    <p>Language</p>
    <select name="userLanguage">
        <option value="" <?php echo $userDto->getLanguage() == ''? 'selected ' :''?>>English</option>
        <option value="Jp" <?php echo $userDto->getLanguage() == 'Jp'? 'selected ' :''?>>Japanese</option>
    </select>
    <input type="submit" value="<?php $content->getMultilanguage()->get('update')?>">
</form>
