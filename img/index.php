<?php
header_remove('X-Powered-By'); 
require(dirname(dirname(__FILE__)).'/parts/Constant/SiteConstants.php');
require(dirname(dirname(__FILE__)).'/parts/Constant/SiteSetting.php');
define('IMG_PATH', THEME_PATH.str_replace(dirname(dirname($_SERVER["SCRIPT_NAME"])).'/', '', $_SERVER["REQUEST_URI"]));
define('STORAGE_PATH', PARTS_DIRECTORY.'Content/Storage/');
if(is_readable(IMG_PATH)){
    require(dirname(dirname(__FILE__)).'/parts/Util/IMimeType.php');
    require(dirname(dirname(__FILE__)).'/parts/Util/FileUtil.php');
    if(FileUtil::fileTypesCheck(IMG_PATH, array(
        FileUtil::GIF,
        FileUtil::ICO,
        FileUtil::JPG,
        FileUtil::PNG,
        FileUtil::BMP
    ))){
        header("Content-Type: ".mime_content_type(IMG_PATH));
        http_response_code(200);
        echo @file_get_contents(IMG_PATH);
        return;
    } else {
        http_response_code(404);
        return;
    }
} else {
    if(is_readable(STORAGE_PATH.basename(CVV_PATH_NAME))){
        require(dirname(dirname(__FILE__)).'/parts/Util/IMimeType.php');
        require(dirname(dirname(__FILE__)).'/parts/Util/FileUtil.php');
        if(FileUtil::fileTypesCheck(STORAGE_PATH.basename(CVV_PATH_NAME), array(
            FileUtil::GIF,
            FileUtil::ICO,
            FileUtil::JPG,
            FileUtil::PNG,
            FileUtil::BMP
        ))){
            header("Content-Type: ".mime_content_type(STORAGE_PATH.basename(CVV_PATH_NAME)));
            http_response_code(200);
            echo @file_get_contents(STORAGE_PATH.basename(CVV_PATH_NAME));
            return;
        } else {
            http_response_code(404);
            return;
        }
    }
}