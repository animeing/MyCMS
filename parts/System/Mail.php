<?php
namespace System;

/**
 * メール発信ファイルがheaderに入る設定であっても問題のないようにWrap
 */
class Mail{
    private function __construct(){}

    static function send($title, $message, $to, $cc = null, $bcc = null){
        if(!function_exists('mb_send_mail')){
            return false;
        }
        ini_set("mail.add_x_header", FALSE); 
        if(is_array($to)){
            $to = implode(',', $to);
        }
        $message = str_replace('\r\n', PHP_EOL, $message);
        mb_internal_encoding("UTF-8");
        return mb_send_mail($to, $title, ($message),'from: '.SITE_NAME.'<'.SITE_NAME.'>');
    }

    function create(){
        return new Mail();
    }
}

