<?php
use db\dto\ContentDto;

global $content;

function hasPostData(){
    return BrowserUtil::getPostParam('title') != null && BrowserUtil::getPostParam('url') != null && BrowserUtil::getPostParam('content') != null;
}

$dto = null;
$contentsData = '';
if(BrowserUtil::getGetParam('post') != null){
    $uri = urldecode(BrowserUtil::getGetParam('post'));
    /**
     * @var ContentDto $dto
     */
    $dto = PostManager::getInstance()->getPostContentSettingInTitle($uri);
    $contentsData = PostManager::getInstance()->getPostContentInName($dto->getContentUri());
}

if(FileUtil::isPossibleChangeSettingData() && hasPostData()){
    if($dto != null){
        foreach ($dto->getContentGenreArray() as $genreName) {
            PostManager::getInstance()->removeContentInGenre($dto->getContentName(), $genreName);
        }
    }

    $genres = BrowserUtil::getPostParam('gneres') == null ? array() : htmlspecialchars(BrowserUtil::getPostParam('gneres'));
    if(BrowserUtil::getPostParam('gnere') != null){
        $genres = array_merge($genres, explode(',', htmlspecialchars(BrowserUtil::getPostParam('gnere'))));
    }
    $contentDto = new ContentDto;
    $contentDto->setContentName(BrowserUtil::getPostParam('title'));
    $contentDto->setContentDay(htmlspecialchars(date(StringUtil::TIME_STAMP_FORMAT)));
    $contentDto->setContentUpdateDay(htmlspecialchars(date(StringUtil::TIME_STAMP_FORMAT)));
    $contentDto->setContentUpUser($dto == null ? $content->getLoginUserName():$dto->getContentUpUser());
    $contentDto->setContentUpdateUserName(htmlspecialchars($content->getLoginUserName()));
    $contentDto->setContentUri(urlencode(strip_tags(BrowserUtil::getPostParam('url'))));

    PostManager::getInstance()->addContents($genres, $contentDto, BrowserUtil::getPostParam('content'));
}
if(BrowserUtil::getGetParam('post') != null){
    /**
     * @var ContentDto $dto
     */
    $dto = PostManager::getInstance()->getPostContentSettingInTitle($uri);
    $contentsData = PostManager::getInstance()->getPostContentInName($dto->getContentUri());
}
?>
<style>
    input{
        height: 2em;
    }
    input, textarea{
        padding: 5px;
        transition: 0.5s;
        border: rgba(0, 0, 0, 0.342) solid 1px;
    }
    .box{
        margin: 5px;
        padding-bottom: 10px;
    }
    input[type="submit"]{
        min-width: calc(100% - 150px);
        margin: 0 calc(150px / 2);
    }
    .child{
        margin: 0 40px;
    }
    .scroll{
        height: 200px;
        overflow-y: scroll;
    }
</style>
<form method="post" action="<?php echo CVV_VIEW_URL;?>" name="contents" >
    <p class="box">Title: <input type="text" name="title" value="<?php if($dto != null) echo $dto->getContentName();?>" id="postTitle"></p>
    <p class="box">URL: <?php echo CVV_TOP_URL;?><input type="text" name="url" value="<?php if($dto != null) echo $dto->getContentUri();?>" id="">/</p>
    <div class="box">Genres:
    <div class="child scroll">
        <div>
            <input type="text" name="gnere" value="">
        </div>
        <?php
        foreach (PostManager::getInstance()->getGenres() as $value) {
            ?>
            <div>
                <input type="checkbox" <?php if($dto != null && in_array($value, $dto->getContentGenreArray())){echo 'checked="checked"';}?> name="gneres[]" value="<?php echo $value;?>">
                <span><?php echo $value;?></span>
            </div>
            <?php
        }
        ?>
    </div>
    </div>
    <div class="box"><p>Content</p>
    <textarea name="content" id="" cols="30" rows="10"><?php echo $contentsData;?></textarea></p>
    <input type="submit" value="<?php $content->getMultilanguage()->get('update');?>" >
</form>

<script>

const titleDom = document.querySelector('#postTitle');
titleDom.addEventListener('change', ()=>{
    document.contents.action = <?php echo CVV_PAGE_VIEW_URL;?>'?post='+titleDom.value;
});


</script>