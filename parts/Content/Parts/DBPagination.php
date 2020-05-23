<?php

namespace content\parts;

use db\dao\PaginationDao;

class DBPagination implements IPagination{

    public function hasUrl($uri = PARTS_DIRECTORY.'Page'.CVV_PATH_NAME.'.ini'){
        $dao = new PaginationDao();
        return $dao->find($uri) != null;
    }

    public function getUrlData($uri){
        $dao = new PaginationDao();
        return $dao->find($uri);
    }

    public function toPageDataPath($uri = null)
    {
        //TODO
    }
}
