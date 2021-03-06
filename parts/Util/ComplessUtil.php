<?php

final class ComplessUtil{
    private function __construct(){
    }

    /**
     * URLに使える文字テーブル
     */
    const TABLE = "@,.<>[]:;!$()abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    
    /**
     * 0~9とa~zまでの文字列をURLで特別な意味を持たない文字列に圧縮します。
     * @param string $str [0~9 | a-z | @,\.<>\[\]:;!$()_-]
     * @return string [0~9 | a-Z]
     */
    public static function compless($str){
        $bb = str_split($str, 5);
        $ret = null;
        foreach ($bb as $key => $value) {
            $data = "";
            if (strlen($ret) > 0 && $bb[$key] != "") {
                $ret.='_';
            }
            $data = $value;
            $option = "";
            while (substr($data, 0 ,1) === '0') {
                $data = substr($data, 1);
                $option .="-";
            }
            $data = ComplessUtil::dec2dohex(hexdec($data));
            $ret .= $option.$data;
        }
        return $ret;
    }

    /**
     * @param string $str [0~9 | a-z | @,\.<>\[\]:;!$()_-]
     * @return string [0~9 | a-z]
     */
    public static function decompless($str){
        $bb = explode ("_", $str);
        $ret = "";
        foreach ($bb as $key => $value) {
            $data = $value;
            $option = "";
            while (substr($data, 0, 1) === '-') {
                $data = substr($data, 1);
                $option .="0";
            }
            $ret .= $option.dechex(ComplessUtil::dohex2dec($data));
        }
        return $ret;
    }
    
    protected static function dec2dohex($dec) {
        $HASHTABLE = ComplessUtil::TABLE;
        $result = '';
        $size = mb_strlen($HASHTABLE);
        while ($dec > 0) {
            $mod = $dec % $size;
            $result = $HASHTABLE[$mod] . $result;
            $dec = ($dec - $mod) / $size;
        }
        return $result;
    }
    
    protected static function dohex2dec($dohex) {
        $HASHTABLE = ComplessUtil::TABLE;
        $len = strlen($dohex);
        $size = mb_strlen($HASHTABLE);
        $result = "";
        for ($i = 0; $i < $len; ++$i) {
            for ($j = 0; $j < $size; ++$j) {
                if ($HASHTABLE[$j] == $dohex[$i]) {
                    @$result += $j * pow($size, $len - $i - 1);
                }
            }
        }
        return $result;
    }

    const ENCRYPT_ALGO = 'aes-256-cbc';
   
    /**
     * データの場所が変わると復号出来なくなります。
     * @return 暗号結果
     */
    public static function encrypt($value) {
      $enc = openssl_encrypt($value, ComplessUtil::ENCRYPT_ALGO, substr(str_replace('/', '',INCLUDE_PATH), -16), OPENSSL_RAW_DATA, substr(str_replace('/', '',INCLUDE_PATH), -16));
      return base64_encode($enc);
    }

    /**
     * 暗号化した場所と同じ場所でしか復号できません。
     * @return 復号結果
     */
    public static function decrypt($value) {
      $dec = base64_decode($value);
      return openssl_decrypt($dec, ComplessUtil::ENCRYPT_ALGO, substr(str_replace('/', '',INCLUDE_PATH), -16), OPENSSL_RAW_DATA, substr(str_replace('/', '',INCLUDE_PATH), -16));
    }
}
