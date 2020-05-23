<?php

use db\dto\ContentDto;

global $content;

if(FileUtil::isPossibleChangeSettingData() && BrowserUtil::getPostParam('cacheRecreate') != null){
    PostManager::getInstance()->load();
}
if(FileUtil::isPossibleChangeSettingData() && BrowserUtil::getPostParam('remove') != null && BrowserUtil::getPostParam('removeContent') != null){
    $postSetting = PostManager::getInstance()->getPostContentSettingInTitle(BrowserUtil::getPostParam('removeContent'));
    if($postSetting != null){
        PostManager::getInstance()->removeContent($postSetting);
    }
}
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
<form action="<?php echo CVV_VIEW_URL;?>" method="post">
    <input type="submit" name="cacheRecreate" value="Cache recreate">
</form>
<table>
        <tr>
        <th>Post title</th>
        <th>Post genre</th>
        <th class="day">Post day</th>
        <th>Action</th>
        </tr>
        <tr onclick="window.location.href='<?php echo CVV_VIEW_URL.'create/';?>'">
                <td>Create new post</td>
                <td>-</td>
                <td class="day" style="text-align: center;"></td>
                <td></td>
        </tr>
        <?php
        /**
         * @var ContentDto $value
         */
        foreach (PostManager::getInstance()->getPostDtos() as $value) {
        ?>
            <tr onclick="window.location.href='<?php echo CVV_VIEW_URL.'create/?post='.urlencode($value->getContentName());?>'">
                <td><?php echo htmlspecialchars($value->getContentName());?></td>
                <td><?php echo htmlspecialchars($value->getContentGenres());?></td>
                <td class="day" style="text-align: center;"><?php echo $value->getContentUpdateDay();?></td>
                <td>
                    <form method="post" action="<?php echo CVV_VIEW_URL;?>" class="form setting">
                    <input type="hidden" value="<?php echo $value->getContentName();?>" name="removeContent">
                    <input type="submit" value="<?php $content->getMultilanguage()->get('remove');?>" name="remove">
                    </form>
                </td>
            </tr>
        <?php
        }
        ?>
    </table>