<?php

use content\Menu\Menu;
use Tags\Anonymous;
use Tags\Meta;
use Tags\Parts\CreateBlockElement;

function admin_theme_function(){
    admin_theme_function_head();
}

function admin_theme_function_head(){
    /**
     * @var content\Content $content
     */
    global $content;
    $charset = new Meta();
    $charset->getAttributes()->set('charset', 'UTF-8');
    $content->getHttpHead()->appendChild($charset);

    $viewport = new Meta();
    $viewport->getAttributes()->set('name', 'viewport');
    $viewport->getAttributes()->set('content', 'width=device-width, initial-scale=1.0');
    $content->getHttpHead()->appendChild($viewport);

    $xua = new Meta();
    $xua->getAttributes()->set('http-equiv', 'X-UA-Compatible');
    $xua->getAttributes()->set('content', 'ie=edge');
    $content->getHttpHead()->appendChild($xua);

    $robot = new Meta();
    $robot->getAttributes()->set('robots', 'noindex, nofollow, noodp, noarchive');
    $content->getHttpHead()->appendChild($robot);

    $content->getHttpHead()->appendChild(admin_theme_function_styleElement());
    if($content->isLoginNow() && $content->hasUrl()){
        $content->getHttpHead()->appendChild(admin_theme_function_scriptElement());
    }
    
    http_response_code(404);
}

function admin_theme_loginUser(){
    /**
     * @var content\Content $content
     */
    global $content;
    return $content->getLoginUserName();
}

function admin_theme_function_menuData(){
    $holder = new Anonymous;
    $holder->setTagName('ul');
    $holder->setCreateElement(new CreateBlockElement);
    $holder->getAttributes()->set('id', 'main-menu-block');
    $holder->getClassNames()->set('menu');

    foreach((array)Menu::getInstance()->getMenu('') as $key=>$value){
        $holder->appendChild(admin_theme_function_menuParts($key, $value));
    }
    return $holder;
}

function admin_theme_function_menuParts($viewname, $link){
    $menuHolder = new Anonymous();
    $menuHolder->setTagName('li');
    $menuHolder->setCreateElement(new CreateBlockElement());

    $menuLink = new Anonymous();
    $menuLink->setTagName('a');
    $menuLink->setCreateElement(new CreateBlockElement());
    $menuLink->appendChild($viewname);
    $menuLink->getAttributes()->set('href', $link);

    $menuHolder->appendChild($menuLink, $viewname);
    return $menuHolder;
}

function admin_theme_theme_change($themeName = THEME_NAME){
    $newSetting = array();
    $newSetting['runningMode'] = "debug";
    $newSetting['error_log_path'] = "/Logs/error.log";
    $newSetting['site_title'] = SITE_NAME;
    $newSetting['site_title_format'] = SITE_TITLE_FORMAT;
    $newSetting['site_copyright'] = SITE_COPYRIGHT;
    $newSetting['data_compless'] = DATA_COMPLESS;
    $newSetting['mail'] = POST_MAIL;
    $newSetting['theme_name'] = $themeName;
    IniWriter::iniWrite(PARTS_DIRECTORY.'Setting/siteSetting.ini', $newSetting);
}

function admin_theme_function_siteSettingUpdate(){
    $siteTitle = htmlspecialchars(BrowserUtil::getPostParam('siteTitle'));
    $siteTitleFormat = htmlspecialchars(BrowserUtil::getPostParam('siteTitleFormat'));
    $siteCopyright = htmlspecialchars(BrowserUtil::getPostParam('siteCopyright'));
    $dataCompless = BrowserUtil::getPostParam('data_compless');
    if(BrowserUtil::getPostParam("postMailAddress") == ""){
        $siteMail = "";
    } else {
        $siteMail = StringUtil::isMailAddress(BrowserUtil::getPostParam("postMailAddress"))?BrowserUtil::getPostParam("postMailAddress"): POST_MAIL;
    }
    
    $newSetting = array();
    $newSetting['runningMode'] = "debug";
    $newSetting['error_log_path'] = "/Logs/error.log";
    if($siteTitle == null){
        $newSetting['site_title'] = SITE_NAME;
    } else {
        $newSetting['site_title'] = $siteTitle;
    }
    if($siteTitleFormat == null){
        $newSetting['site_title_format'] = SITE_TITLE_FORMAT;
    } else {
        $newSetting['site_title_format'] = $siteTitleFormat;
    }
    if($siteCopyright == null){
        $newSetting['site_copyright'] = SITE_COPYRIGHT;
    } else {
        $newSetting['site_copyright'] = $siteCopyright;
    }
    if($dataCompless == null){
        $newSetting['data_compless'] = DATA_COMPLESS;
    } else {
        $newSetting['data_compless'] = $dataCompless;
    }
    $newSetting['mail'] = $siteMail;
    $newSetting['theme_name'] = THEME_NAME;
    IniWriter::iniWrite(PARTS_DIRECTORY.'Setting/siteSetting.ini', $newSetting);
    BrowserUtil::setCookieParam('change', base64_encode('true'), 100, CVV_TOP_URL.'admin/');
}

function admin_theme_function_isChangeSiteSetting(){
    $siteTitle = BrowserUtil::getPostParam('siteTitle');
    $siteTitleFormat = BrowserUtil::getPostParam('siteTitleFormat');
    $siteCopyright = BrowserUtil::getPostParam('siteCopyright');
    $dataCompless = BrowserUtil::getPostParam('data_compless');
    if(BrowserUtil::getPostParam("postMailAddress") == ""){
        $mail = "";
    } else {
        $mail = StringUtil::isMailAddress(BrowserUtil::getPostParam("postMailAddress"))?BrowserUtil::getPostParam("postMailAddress"): POST_MAIL;
    }
    if(isset($siteTitle,$siteTitleFormat,$siteCopyright)){
        return ($siteTitle != SITE_NAME || $siteTitleFormat != SITE_TITLE_FORMAT || $siteCopyright != SITE_COPYRIGHT || $mail != POST_MAIL || $dataCompless != DATA_COMPLESS);
    } else {
        return false;
    }
}

function admin_theme_function_isChangeExtensionSetting(){

}

function admin_theme_function_styleElement(){
    $style = new Anonymous();
    $style->setTagName('style');
    $style->setCreateElement(new CreateBlockElement);
    $style->appendChild(file_get_contents(dirname(__FILE__).'/css/style.css'));
    return $style;
}

function admin_theme_function_scriptElement(){
    $script = new Anonymous();
    $script->setTagName('script');
    $script->setCreateElement(new CreateBlockElement);
    $script->appendChild(file_get_contents(dirname(__FILE__).'/js/index.js'));
    return $script;
}

function admin_theme_layout(){
    global $content;
    if($content->isLoginNow()){
        return "";
    } else {
        return $content->getContent();
    }
}


admin_theme_function();