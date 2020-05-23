<?php

global $content;

if(FileUtil::isPossibleChangeSettingData()){
    if(isset($_FILES['file']['error']) && is_int($_FILES['file']['error'])){
        if ($_FILES['file']['size'] > 1000000) {
            //error log

        } else if(FileUtil::fileTypesCheck($_FILES['file']['tmp_name'], array(
            FileUtil::GIF,
            FileUtil::JPG,
            FileUtil::PNG,
            FileUtil::BMP
        ))){
            //アップロードできるのは画像だけ
            $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $path = STORAGE_DIRECTORY.sha1_file($_FILES['file']['tmp_name']).'.'.$extension;
            move_uploaded_file($_FILES['file']['tmp_name'], $path);
            chmod($path, 0644);
        }
    } else if(BrowserUtil::getPostParam('remove') != null){
        unlink (FileUtil::getFilePath(STORAGE_DIRECTORY, BrowserUtil::getPostParam('remove')));
    }
}

?>
<style>
.flex{
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    height: 300px;
    margin: 10px 0;
}
.img-frame{
    max-width: calc(15% - 22px);
    min-width: 265px;
    padding: 5px;
    margin: 7px 5px;
    border: 1px solid #000;
    border-radius: 10px;
    position: relative;
}
.img-frame img{
    max-width: 100%;
    max-height: calc(100% - 3.5em - 25px);
    display: block;
    margin: 0 auto;
}
.property{
    position: absolute;
    bottom: 1.5em;
    margin-bottom: 10px;
}
.property > p{
    border-bottom: 1px solid #000;
}
input[type="file"]{
    display: none;
}

.file{
    display: inline-block;
    box-sizing: border-box;
    border: solid 1px #aaa;
    padding: 10px;
    margin: 5px;
}

.remove{
    position: absolute;
    bottom: 5px;
    width: calc(100% - 10px);
}

</style>

<form action="<?php echo CVV_VIEW_URL;?>" method="post" style="text-align: center;" name="fileUploadFrame" enctype="multipart/form-data">
    <label class="file" for="file_upload">
        select file upload.
    <input type="file" id="file_upload" name="file" onchange="document.fileUploadFrame.submit();">
    </label>
</form>

<?php
if(count(FileUtil::directoryFileList(STORAGE_DIRECTORY)) == 0){
?>
<p style="text-align: center;">Not uploaded medias.</p>
<?php
} else {
    ?>
<div class="flex">
<?php
    foreach (FileUtil::directoryFileList(STORAGE_DIRECTORY) as $value) {
    ?>
<span class="img-frame">
    <a href="<?php echo CVV_TOP_URL.'img/'.$value;?>" target="_blank">
<?php
        if(FileUtil::fileTypesCheck(FileUtil::getFilePath(STORAGE_DIRECTORY, $value), 
        array(FileUtil::GIF, FileUtil::JPG, FileUtil::PNG, FileUtil::BMP))){
        //IMAGE
?>
<img src="<?php echo CVV_TOP_URL.'img/'.$value;?>" alt="">
<?php
        }
?>
        <span class="property">
            <p onclick="return false;" >File link : <input type="text" readonly value="<?php echo CVV_TOP_URL.'img/'.$value;?>"></p>
            <p>File size : <?php echo StringUtil::getStorageSymbolByQuantity(filesize(FileUtil::getFilePath(STORAGE_DIRECTORY, $value)));?></p>
        </span>
    </a>
    <form action="<?php echo CVV_VIEW_URL;?>" method="post">
        <input type="hidden" name="remove" value="<?php echo $value;?>">
        <input type="submit" class="remove" value="<?php $content->getMultilanguage()->get('remove');?>">
    </form>
</span>
<?php
    }
}
?>
</div>
