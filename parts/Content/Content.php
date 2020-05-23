<?php

namespace content;

use content\parts\IPagination;
use content\parts\LocalFilePagination;
use db\dto\PaginationDto;
use extension\ExtensionManager;
use FileUtil;
use PostManager;
use Tags\Head;
use Tags\Title;

class Content implements IContent{
    private $httpHeader;
    private $httpHead;
    /**
     * @var IPagination
     */
    private $paginationProvider;

    function __construct()
    {
        $this->httpHeader = new HttpHeader();
        $this->httpHead = new Head();

        //TODO DB版も後々作成
        $this->paginationProvider = new LocalFilePagination();
    
        $title = new Title();
        $this->httpHead->appendChild($title, 'title');
        if($this->hasUrl($this->paginationProvider->toPageDataPath().'.ini')){
            $paginationDto = new PaginationDto();
            $paginationDto->putAllDtoCache(parse_ini_file($this->paginationProvider->toPageDataPath().'.ini'));
            $title->setValue($paginationDto->getPageTitle());
        } else if(strncmp(CVV_PAGE_VIEW_URL, CVV_POST_URL, count(CVV_POST_URL)) == 0){
            $contentUri = basename(rtrim(str_replace(CVV_POST_URL,'',CVV_PAGE_VIEW_URL), '/'));
            $contentDto = PostManager::getInstance()->getPostContentSettingInUri($contentUri);
            if($contentDto != null){
                $title->setValue(htmlspecialchars($contentDto->getContentName()));
            }
        }
    }

    public function getHttpHeader(){
        return $this->httpHeader;
    }

    public function getHttpHead(){
        return $this->httpHead;
    }

    public function getContent(){
        if($this->hasUrl($this->paginationProvider->toPageDataPath().'.ini')){
            ob_start();
            FileUtil::existsFileRequire($this->paginationProvider->toPageDataPath().'.php');
            $content = ob_get_clean();
            ExtensionManager::getInstance()->callContent($content);
            return $content;
        } else if(strncmp(CVV_PAGE_VIEW_URL, CVV_POST_URL, count(CVV_POST_URL)) == 0){
            setlocale(LC_ALL, 'ja_JP.UTF-8');
            $contentUri = basename(rtrim(str_replace(CVV_POST_URL,'',CVV_PAGE_VIEW_URL), '/'));
            if(PostManager::getInstance()->hasPostUri($contentUri) ){
                return PostManager::getInstance()->getPostContentInName($contentUri);
            } else {
                return $this->action404();
            }
        } else {
            return $this->action404();
        }
    }

    private function action404(){
        http_response_code(404);
        $themePath = ThemeFinder::getInstance()->hasErrorTheme('404.html');
        if($themePath === false){
            return;
        }
        ob_start();
        FileUtil::existsFileRequire($themePath);
        return ob_get_clean();
    }

    public function hasUrl($uri){
        return $this->paginationProvider->hasUrl($uri);
    }
}

global $content;
$content = new Content();