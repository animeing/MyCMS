<?php

use db\dto\PaginationDto;

global $content;

if (is_null(BrowserUtil::getGetParam('page'))) {
    $removeLink = BrowserUtil::getPostParam('removePage');
    if(BrowserUtil::getPostParam('remove') != null && $removeLink != null){
        unlink(PAGES_DIRECOTRY.$content->getUriToFile($removeLink.'.ini'));
        unlink(PAGES_DIRECOTRY.$content->getUriToFile($removeLink.'.php'));
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

.overflow_dotreader{
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}

table th,table td{
  width: 25%;
  padding: 15px 0;
}
.form {
    height: 100%;
    line-height: 20px;
}

textarea{
    border: 1px solid #111;
}

</style>

<form method="post" action="<?php echo CVV_VIEW_URL;?>" class="form setting">
<div class="block">
    <table>
    <tr>
    <th><?php $content->getMultilanguage()->get('page');?></th>
    <th><?php $content->getMultilanguage()->get('description');?></th>
    <th><?php $content->getMultilanguage()->get('action');?></th>
    </tr>
    <?php
    /**
     * @var PaginationDto $value
     */
    foreach ($content->getPublicPages() as $key => $value) {
?>
    <tr onclick="window.location.href='<?php echo CVV_VIEW_URL.'?page='.$value->getUri();?>'">
        <td>
            <?php echo $value->getPageTitle();?>
        </td>
        <td>
            <?php echo $value->getDescription()?>
        </td>
        <td>
            <input type="hidden" name="removePage" value="<?php echo $value->getUri();?>" >
            <input type="submit" value="<?php $content->getMultilanguage()->get('remove');?>" name="remove">
        </td>
    </tr>
<?php
    }
    ?>
    <tr onclick="window.location.href='<?php echo CVV_VIEW_URL.'?page=';?>'">
        <td>
        <?php $content->getMultilanguage()->get('newPage')?>
        </td>
        <td>
        <?php $content->getMultilanguage()->get('createPage')?>
        </td>
        <td>
        </td>
    </tr>
    </table>
</div>
</form>

<?php
} else {
    if(BrowserUtil::getPostParam("pageData") != null && FileUtil::isPossibleChangeSettingData()){
        FileUtil::write(PAGES_DIRECOTRY.$content->getUriToFile(BrowserUtil::getPostParam('pageUri').'.php'), 
        base64_decode(BrowserUtil::getPostParam("pageData")), 'w+');
        $dto = new PaginationDto();
        $dto->setUri(BrowserUtil::getPostParam('pageUri'));
        $dto->setPageTitle(htmlspecialchars(BrowserUtil::getPostParam('pageTitle')));
        $dto->setDraftDay(BrowserUtil::getPostParam(''));
        $dto->setDescription(BrowserUtil::getPostParam('description'));
        IniWriter::iniWrite(PAGES_DIRECOTRY.$content->getUriToFile(BrowserUtil::getPostParam('pageUri').'.ini'), $dto->getDtoCache());
    }
    if(BrowserUtil::getGetParam('page') != ""){
        $dto = $content->getPublicPage($content->getUriToFile(urldecode(BrowserUtil::getGetParam('page'))).'.ini');
    } else {
        $dto = new PaginationDto();
    }
?>
<style>

form.setting input.margin_remove{
    margin: 0;
    width: 50%;
    min-width: 50%;
}
</style>
<script>
const submitPageData = () =>{
    document.pageUpsert.pageData.value = Base64.encode(document.pageUpsert.pageData.value);
    // console.log(Base64.encode(document.pageUpsert.pageData.value));
    document.pageUpsert.submit();
}
</script>
<form action="<?php echo CVV_VIEW_URL;?>" name="pageUpsert" method="post" class="form setting">
    <div>
        <span><?php $content->getMultilanguage()->get('page');?> : </span>
        <?php echo CVV_TOP_URL;?><input type="text" name="pageUri" class="margin_remove" value="<?php echo BrowserUtil::getGetParam('page');?>">/
    </div>
    <div>
    <span><?php $content->getMultilanguage()->get('pageTitle')?> : </span><input type="text" name="pageTitle" class="margin_remove" value="<?php echo $dto->getPageTitle();?>">
    </div>
    <span><?php $content->getMultilanguage()->get('pageData')?></span>
    <textarea name="pageData" cols="30" rows="10"><?php
        if($dto != null){
            echo $dto->getPageData();
        }
        ?></textarea>
        <span><?php $content->getMultilanguage()->get('description');?> : </span>
        <input type="text" name="description" class="margin_remove" value="<?php echo $dto->getDescription();?>">
    <button type="button" onclick="submitPageData();"><?php $content->getMultilanguage()->get('update')?></button>
</form>
<?php
}