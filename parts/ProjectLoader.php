<?php
/**
 * @var content\Content $content
 */
$content;
if(!defined("CVV_ADMIN_PAGE")){
    define("CVV_ADMIN_PAGE", FALSE);
}
header_remove('X-Powered-By'); 
ob_start();
/**
 * private method
 */
function projectLoader($file){
    $xmlFileName = $file;
    $dir = __DIR__.'/';
    $datas = simplexml_load_file($xmlFileName);
    foreach($datas->constant as $item){
        require($dir.$item);
    }
    foreach($datas->util as $item){
        require($dir.$item);
    }
    foreach($datas->base as $item){
        require($dir.$item);
    }
    foreach($datas->data as $item){
        require($dir.'DB/DB/Table/'.$item["table"]);
        require($dir.'DB/DB/Dto/'.$item["dto"]);
        require($dir.'DB/DB/Dao/'.$item["dao"]);
    }
    foreach($datas->sub as $item){
        if(isset($item["admin"], $item["nomal"], $item["readName"])){
            if(CVV_ADMIN_PAGE){
                require($dir.$item["admin"].$item["readName"]);
            } else {
                require($dir.$item["nomal"].$item["readName"]);
            }
        } else {
            require($dir.$item);
        }
    }

    foreach($datas->main as $item){
        require($dir.$item);
    }

    
}

function start(){
    loader\ThemeLoader::load();
}
