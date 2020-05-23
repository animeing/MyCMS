<?php

class Sample{
    function __construct()
    {
    }

    function awake(){
    }

    function contentStart(){
        return '<script src="'.CVV_TOP_URL.'js/index.js?plugin=Sample"></script>';
    }

    function contentEnd(){
    }
    function cssContent(){

    }

    function javascriptContent(){
        return '//TEST';
    }
}