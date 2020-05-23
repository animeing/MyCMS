<?php

namespace loader;

class ThemeLoader{
    public static function load(){
        require(PARTS_DIRECTORY.'Content/Admin/Theme/loader.php');
    }
}