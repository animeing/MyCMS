<?php

use db\dto\ExtensionDto;
use extension\ExtensionManager;

require_once(dirname(dirname(__FILE__)) . "/parts/ProjectLoader.php");
projectLoader(dirname(__FILE__).'/loader.xml');
define('CSS_DIRECTORY', str_replace(dirname(dirname($_SERVER["SCRIPT_NAME"])), '', $_SERVER["REQUEST_URI"]));
define('CSS_PATH', THEME_PATH.CSS_DIRECTORY);
if(@file_exists(CSS_PATH)){
    header("Content-Type: ".FileUtil::CSS);
    http_response_code(200);
    if(DATA_COMPLESS){
        echo StringUtil::deleteNonCss(@file_get_contents(CSS_PATH));
    } else {
        echo @file_get_contents(CSS_PATH);
    }
    return;
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
    if(method_exists($executeInstance, 'cssContent')){
        header("Content-Type: ".FileUtil::CSS);
        http_response_code(200);
        if(DATA_COMPLESS){
            echo StringUtil::deleteNonCss($executeInstance->cssContent(CSS_DIRECTORY));
        } else {
            echo $executeInstance->cssContent(CSS_DIRECTORY);
        }
        return;
    } else {
        http_response_code(404);
        return;
    }

}
