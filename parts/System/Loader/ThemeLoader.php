<?php

namespace loader;

class ThemeLoader{
    public static function load(){
        require(THEME_PATH.'loader.php');
    }
}