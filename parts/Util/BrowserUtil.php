<?php

final class BrowserUtil{
    private function __construct(){}
    
    public static function getCookieParam(string $key){
        if(isset($_COOKIE[$key])){
            return $_COOKIE[$key];
        } else {
            return null;
        }
    }

    /**
     * @param string $value
     * @param long $expirationSecond
     */
    public static function setCookieParam(string $key, $value, $expirationSecond = null, $path = '/'){
        if($expirationSecond == null){
            setcookie($key, $value, 0, $path);
        } else {
            setcookie($key, $value, time() + $expirationSecond, $path);
        }
    }

    public static function getGetParam(string $key){
        if(isset($_GET[$key])){
            return $_GET[$key];
        } else {
            return null;
        }
    }

    public static function addGetParam($key, $value, $url){
        if(strpos($url, '?') === false) {
            $url.='?';
        } else {
            $url.='&';
        }
        return ($url.$key.'='.$value);
    }

    public static function addGetParams($dictionary, $url){
        $data = $url;
        foreach ($dictionary as $key => $value) {
            $data = self::addGetParam($key, $value, $data);
        }
        return $data;
    }
    
    public static function getPostParam($key){
        
        if(isset($_POST[$key])){
            return $_POST[$key];
        } else {
            return null;
        }
    }

	public static function headerToString(array $header){
        $headerString = "";
        foreach ($header as $name => $value) {
            $headerString .= "$name: $value\n";
        }
        return $headerString;
    }
    
    public static function stringToHeader($stringHeader){
        $header = array();
        foreach (explode('\n', $stringHeader) as $record) {
            $sp = explode (': ', $record, 2);
            $header[$sp[0]] = $sp[1];
        }
        return $header;
    }

    public static function getCurrentUrl(){
        return (empty($_SERVER['HTTPS']) ? 'http://' : 'https://').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    }
    
}