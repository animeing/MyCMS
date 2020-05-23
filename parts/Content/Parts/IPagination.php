<?php

namespace content\parts;

interface IPagination{

    public function hasUrl($filePath = PARTS_DIRECTORY.'Page'.CVV_PATH_NAME.'.ini');
    public function toPageDataPath($uri = null);
    public function getUrlData($uri);
}

