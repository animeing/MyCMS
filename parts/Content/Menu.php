<?php

namespace content\Menu;

class Menu{
    private $menuData;

    private static $singleton;

    function __construct()
    {
        $this->menuData = parse_ini_file(PARTS_DIRECTORY."Setting/menu.ini", true);
    }

    public static final function getInstance(){
        if(!isset(self::$singleton)){
            self::$singleton = new Menu();
        }
        return self::$singleton;
    }

    function getMenu($menuListName){
        $ret = array();
        foreach ($this->menuData[$menuListName] as $key => $value) {
            if( filter_var( $value, FILTER_VALIDATE_URL ) ){
                $ret[$key] = $value;
            }else{
                $ret[$key] = CVV_TOP_URL.$value;
            }
        }
        return $ret;
    }
    
}
