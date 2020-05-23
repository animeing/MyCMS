<?php

global $content;

use admin\page\user\UserViewController;
use db\dto\UsersDto;

FileUtil::existsFileRequire(CONTENT_DIRECTORY.'Admin/Pages/Controller/UserViewController.php');
$userViewController = new UserViewController;
?>
<style>
table{
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
}

table tr{
  border-bottom: solid 1px #eee;
}

table tr:hover{
  background-color: #d4f0fd;
}
table th,
table .center{
    text-align: center;
}

table th,table td{
  width: 25%;
  padding: 15px 0;
}
.form {
    height: 100%;
    line-height: 20px;
}

table th{
    width: 0px;
}
</style>
<table>
    <tr>
        <th>User</th>
        <th>Authority</th>
        <th>Action</th>
    </tr>
    <tr onclick="window.location.href='<?php echo CVV_VIEW_URL.'edit/';?>'">
        <td>Create new user</td>
        <td>-</td>
        <td></td>
    </tr>
<?php
/**
 * @var UsersDto $userDto
 */
foreach($userViewController->getUserDtos() as $userDto){
?>
    <tr onclick="window.location.href='<?php echo BrowserUtil::addGetParam('user', $userDto->getUserName(), CVV_VIEW_URL.'edit/') ;?>'">
        <td><?php echo $userDto->getUserName();?></td>
        <td></td>
        <td></td>
    </tr>
<?php
}
?>
</table>