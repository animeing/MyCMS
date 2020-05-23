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
        $menu = array();
        $menu['Home'] = CVV_TOP_URL."admin/";
        $menu['Menu'] = CVV_TOP_URL."admin/menu/";
        $menu['Page'] = CVV_TOP_URL."admin/page/";
        $menu['Post'] = CVV_TOP_URL."admin/post/";
        $menu['Media'] = CVV_TOP_URL."admin/media/";
        $menu['Theme'] = CVV_TOP_URL."admin/theme/";
        $menu['Plugin'] = CVV_TOP_URL."admin/plugin/";
        return $menu;
    }
    
    function getPublicMenu($menuListName){
        return $this->menuData[$menuListName];
    }

    function getPublicMenus(){
        return $this->menuData;
    }
    
}
