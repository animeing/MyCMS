<?php

namespace Tags;

use Tags\Parts\HttpTagBase;

class Title extends HttpTagBase{
    
    public function hasPossibleToChildren(){
        return false;
    }

    public function getTagName()
    {
        return 'title';
    }

    public function createTag(){
?>
<title><?php
if(CVV_TOP_URL == CVV_VIEW_URL){
    echo SITE_NAME;
} else {
    $title = str_replace('site_title', SITE_NAME, SITE_TITLE_FORMAT);
    $title = str_replace('page_title', $this->getValue(), $title);
    echo $title;
}
?></title>
<?php
    }
}

