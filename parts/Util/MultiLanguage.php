<?php

final class MultiLanguage{
    private $languageDirectory = "";
    private $lang = "";
    private $langList;
    function __construct($languageDirectory, $lang)
    {
        $this->languageDirectory = $languageDirectory;
        $this->lang = $lang;
        $this->langList = parse_ini_file($languageDirectory.'/lang.ini');
        foreach (parse_ini_file($languageDirectory.'/lang'.$lang.'.ini') as $key => $value) {
            $this->langList[$key] = $value;
        }
    }

    function getLangDirectory(){
        return $this->languageDirectory;
    }

    function getLang(){
        return $this->lang;
    }

    function get($string){
        if(@$this->langList[$string]==null){
            echo $string;
        } else {
            echo $this->langList[$string];
        }
    }
}