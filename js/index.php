<?php

use db\dto\ExtensionDto;
use extension\ExtensionManager;

require_once(dirname(dirname(__FILE__)) . "/parts/ProjectLoader.php");
projectLoader(dirname(__FILE__).'/loader.xml');
define('JAVASCRIPT_DIRECTORY', str_replace(dirname(dirname($_SERVER["SCRIPT_NAME"])), '', $_SERVER["REQUEST_URI"]));
define('JAVASCRIPT_PATH', THEME_PATH.str_replace(dirname(dirname($_SERVER["SCRIPT_NAME"])), '', $_SERVER["REQUEST_URI"]));
if(@file_exists(JAVASCRIPT_PATH) && BrowserUtil::getGetParam('plugin') == null){
    header("Content-Type: ".FileUtil::JAVASCRIPT);
    http_response_code(200);
    if(DATA_COMPLESS){
        echo StringUtil::deleteNonCss(@file_get_contents(JAVASCRIPT_PATH));
    } else {
        echo @file_get_contents(JAVASCRIPT_PATH);
    }
} else {
    if(BrowserUtil::getGetParam('plugin') == null){
        http_response_code(404);
        return;
    }
    /**
     * @var ExtensionDto $extensionDto
     */
    $extensionDto = ExtensionManager::getInstance()->getExtensionDtos()[BrowserUtil::getGetParam('plugin')];
    $executeInstance = $extensionDto->getExeInstance();
    if(method_exists($executeInstance, 'javascriptContent')){
        header("Content-Type: ".FileUtil::JAVASCRIPT);
        http_response_code(200);
        if(DATA_COMPLESS){
            echo StringUtil::deleteNonCss($executeInstance->javascriptContent(JAVASCRIPT_DIRECTORY));
        } else {
            echo $executeInstance->javascriptContent(JAVASCRIPT_DIRECTORY);
        }
        return;
    } else {
        http_response_code(404);
        return;
    }
}