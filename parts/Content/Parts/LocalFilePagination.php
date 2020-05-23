<?php

namespace content\parts;

class LocalFilePagination implements IPagination{
    
    public function hasUrl($filePath = PARTS_DIRECTORY.'Page'.CVV_PATH_NAME.'.ini'){
        return is_readable($filePath);
    }

    /**
     * @return string full path
     */
    public function toPageDataPath($uri = null){
        if($uri == null){
            $uri = str_replace(CVV_TOP_URL, '', str_replace("?".CVV_QUERY, '',CVV_VIEW_URL));
        }
        if(substr(mb_strtolower(str_replace('/', '^', $uri)), 0, -1) == ''){
            return PARTS_DIRECTORY.'Pages/index';
        }
        return PARTS_DIRECTORY.'Pages/'.substr(mb_strtolower(str_replace('/', '^', $uri)), 0, -1);
    }

    /**
     * @param string $page
     * @param PaginationDto $pageDto 
     */
    public function upsertPage($page, $pageDto){
        $pagePath = $this->toPageDataPath($page);

        $fp = fopen($pagePath.'.php', 'w+');
        fwrite($fp, $pageDto->getPageData());

        $fp = null;
    }

    public function getUrlData($uri){
        
    }

}