<?php

final class FileUtil implements IMimeType{
    private function __construct(){}
    
    public static function fileTypeCheck($filePath, $mimeType){
        return strstr(mime_content_type($filePath), $mimeType);
    }

    public static function fileTypesCheck($filePath, $mimeTypes){
        if(is_array($mimeTypes)){
            foreach((array)$mimeTypes as $mimeType){
                if(FileUtil::fileTypeCheck($filePath, $mimeType)){
                    return true;
                }
            }
            return false;
        }
        return false;
    }

    /**
     * 指定のディレクトリ内のファイルをFullPathで返します。
     */
    public static function getFileNames($fileDirectory){
        $files = array();
        foreach(glob($fileDirectory.'/*') as $file){
            if(is_file($file)){
                $files[]=($file);
            }
        }
        return $files;
    }

    public static function write($path, $data, $mode = 'w'){
        $fp = fopen($path, $mode);
        fwrite($fp, $data);
    }

    /**
     * Only folder in directory
     */
    public static function directoryList($directory){
        $directorys = scandir($directory);
		unset($directorys[0]);
        unset($directorys[1]);
        $directorys = array_values($directorys);
        for ($checkDirectory=0; $checkDirectory < count($directorys); $checkDirectory++) {
            if(!is_dir($directory.$directorys[$checkDirectory])){
                unset($directorys[$checkDirectory]);
            }
        }
        return array_values($directorys);
    }

    /**
     * Only files in directory
     */
    public static function directoryFileList($directory){
        $directorys = scandir($directory);
		unset($directorys[0]);
        unset($directorys[1]);
        $directorys = array_values($directorys);
        for ($checkDirectory=0; $checkDirectory < count($directorys); $checkDirectory++) {
            if(!is_file($directory.$directorys[$checkDirectory])){
                unset($directorys[$checkDirectory]);
            }
        }
        return array_values($directorys);
    }

    public static function readJsonDecode($filePath){
        if(is_file($filePath)){
            return json_decode(file_get_contents($filePath), true);
        } else {
            return array();
        }
    }

    /**
     * 設定ファイルを書き換える権限を保持しているか
     * @return boolean true = 書き換え可能
     */
    public static function isPossibleChangeSettingData(){
         if(!CVV_ADMIN_PAGE){
             return false;
         }
         global $content;
         if(!method_exists($content, 'isLoginNow')){
             return false;
         }
         return $content->isLoginNow();
    }

    public static function getFilePath($path, $fileName){
        setlocale(LC_ALL, 'ja_JP.UTF-8');
        return $path.basename($fileName);
    }

    public static function existsFileRequire($filePath){
        if(is_readable($filePath)){
            return require($filePath);
        }
    }

    public static function serialize($filePath, $data){
        ob_start();
        try{
            file_put_contents($filePath, gzcompress(serialize($data)), LOCK_EX);
        } finally {
            ob_end_clean();
        }
    }

    public static function unserialize($filePath){
        ob_start();
        try{
            return unserialize(gzcompress(file_get_contents($filePath)));
        } finally {
            ob_end_clean();
        }
    }
}