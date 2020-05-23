<?php

ini_set('display_errors', "On");

define("CVV_TOP_URL", (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER['HTTP_HOST'] . ((dirname($_SERVER["SCRIPT_NAME"]) === '/') ? "" : dirname($_SERVER["SCRIPT_NAME"])) . "/");
define("CVV_ADMIN_PAGE", TRUE);

require_once(dirname(__FILE__) . "/parts/ProjectLoader.php");
projectLoader(__DIR__.'/parts/loader.xml');
if (BrowserUtil::getGetParam('theme') == null && substr(CVV_PAGE_VIEW_URL, strrpos(CVV_PAGE_VIEW_URL, '.') + 1) != 'js' && substr(CVV_PAGE_VIEW_URL, strrpos(CVV_PAGE_VIEW_URL, '.') + 1) != 'css') {
    start();
    require(PARTS_DIRECTORY . 'Content/Admin/Theme/index.php');
    ob_end_flush();
} else {
    if ($content->isLoginNow()) {
        if (BrowserUtil::getGetParam('select') == 'extension') {
            if (!is_readable(EXTENSION_PATH . basename(BrowserUtil::getGetParam('plugin')) . '/' . str_replace(CVV_TOP_URL . 'admin/', '', CVV_PAGE_VIEW_URL))) {
                http_response_code(404);
                return;
            }
            // EXTENSION_PATH.basename(BrowserUtil::getGetParam('plugin')).str_replace(CVV_PAGE_VIEW_URL, '', )
            if (substr(CVV_PAGE_VIEW_URL, strrpos(CVV_PAGE_VIEW_URL, '.') + 1) == 'js') {
                header("Content-Type: " . FileUtil::JAVASCRIPT);
            } else if (substr(CVV_PAGE_VIEW_URL, strrpos(CVV_PAGE_VIEW_URL, '.') + 1) == 'css') {
                header("Content-Type: " . FileUtil::CSS);
            }
            echo file_get_contents(EXTENSION_PATH . basename(BrowserUtil::getGetParam('plugin')) . '/' . str_replace(CVV_TOP_URL . 'admin/', '', CVV_PAGE_VIEW_URL));
        } else if(BrowserUtil::getGetParam('theme') != null) {
            if(is_readable(THEME_DIRECTORY.BrowserUtil::getGetParam('theme').'/themeIcon.png')){
                echo file_get_contents(THEME_DIRECTORY.BrowserUtil::getGetParam('theme').'/themeIcon.png');
            } else {
                http_response_code(404);
                return;
            }
        }
        http_response_code(200);
    }
}

