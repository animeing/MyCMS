<?php

namespace content;

use FileUtil;

final class ThemeFinder{

    private $files;
    private $errorFiles;
    private static $singleton;

    private function __construct(){
        $this->files = FileUtil::directoryFileList(THEME_PATH);
        $this->errorFiles = FileUtil::directoryFileList(THEME_PATH.'error/');
    }

    public static final function getInstance(){
        if(!isset(self::$singleton)){
            self::$singleton = new ThemeFinder();
        }
        return self::$singleton;
    }

    function hasErrorTheme($themeFile){
        foreach ($this->errorFiles as $file) {
            if($themeFile === $file){
                return THEME_PATH.'error/'.$file;
            }
        }
        return false;
    }

    function hasNomalTheme($themeFile){
        foreach ($this->files as $file) {
            if($themeFile === $file){
                return THEME_PATH.$file;
            }
        }
        return false;
    }

    /**
     * @deprecated
     * @uses ThemeFinder::getInstance->hasNomalTheme
     * @uses ThemeFinder::getInstance->hasErrorTheme
     */
    function hasTheme($themeFile){
        foreach ($this->files as $file) {
            if($themeFile === $file){
                return THEME_PATH.$file;
            }
        }
        return $this->hasErrorTheme($themeFile);
    }
}

