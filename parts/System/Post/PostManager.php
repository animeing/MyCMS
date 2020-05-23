<?php

use db\dao\ContentDao;
use db\dto\ContentDto;
use db\table\IContentTable;

final class PostManager{
    
    private static $singleton;
    private $postDtos = array();

    private function __construct(){
        $this->postUnpack();
    }

    public static final function getInstance(){
        if(!isset(self::$singleton)){
            self::$singleton = new PostManager;
        }
        return self::$singleton;
    }

    private function postPack(){
        $postDtos = $this->loadPostDto();
        file_put_contents(CACHE_DIRECTORY.'Post/data.dat', gzcompress(serialize($postDtos)), LOCK_EX);
        return $postDtos;
    }

    private function postUnpack(){
        $this->postDtos = (array)unserialize(gzuncompress(file_get_contents(CACHE_DIRECTORY.'Post/data.dat')));
    }

    private function currentPostPack(){
        file_put_contents(CACHE_DIRECTORY.'Post/data.dat', gzcompress(serialize($this->postDtos)), LOCK_EX);
        return $this->postDtos;
    }

    public function load(){
        if(!FileUtil::isPossibleChangeSettingData()){
            return;
        }
        $this->postDtos = $this->postPack();
    }

    private function loadPostDto(){
        $postDtos = array();
        foreach (FileUtil::getFileNames(POST_CONTENT_SETTING_DIRECTORY) as  $value) {
            $setting = parse_ini_file($value);
            $contentDao = new ContentDao;
            $postDtos[$setting[IContentTable::CONTENT_URI]] = $contentDao->toDto($setting);
        }
        /**
         * @var ContentDto $dto1
         * @var ContentDto $dto2
         */
        uasort($postDtos, function ($dto1, $dto2){
            if(strtotime($dto1->getContentDay()) > strtotime($dto2->getContentDay())){
                return -1;
            }
            if(strtotime($dto1->getContentDay()) < strtotime($dto2->getContentDay())){
                return 1;
            }
            return 0;
        });
        return $postDtos;
    }

    public function getGenres(){
        return FileUtil::directoryFileList(GENRE_DIRECTORY);
    }

    public function removeContentInGenre($contentTitle, $genreName){
        $contents = $this->getGenreContents($genreName);
        if($contents == null){
            return;
        }
        unset($contents[$contentTitle]);
        IniWriter::iniWrite(FileUtil::getFilePath(GENRE_DIRECTORY, $genreName), $contents, "w+");
    }

    /**
     * @param ContentDto $contentDto
     */
    public function removeContent($contentDto){
        if(!FileUtil::isPossibleChangeSettingData()){
            return;
        }
        foreach ($contentDto->getContentGenreArray() as $value) {
            $this->removeContentInGenre($contentDto->getContentName(), $value);
        }
        unlink(FileUtil::getFilePath(POST_CONTENT_SETTING_DIRECTORY, $contentDto->getContentName()));
        unlink(FileUtil::getFilePath(POST_CONTENT_DIRECTORY, $contentDto->getContentUri().'.html'));
        $this->postDtos = $this->currentPostPack();
    }

    public function getGenreContents($genreName){
        $genreFilePath = FileUtil::getFilePath(GENRE_DIRECTORY, $genreName);
        if(!is_file($genreFilePath)){
            return null;
        }
        return parse_ini_file($genreFilePath, true);
    }

    /**
     * possible admin only
     * @param ContentDto $contentDto
     * @param string $genreName genre名
     * @param string $content コンテンツhtmlデータ
     */
    public function addContents($genreName, $contentDto, $content){
        if(!FileUtil::isPossibleChangeSettingData()){
            return;
        }
        if(!is_array($genreName)){
            if(strpos($genreName, '/')){
                $genreName = '';
            } else {
                $genreData = $this->getGenreContents($genreName);
                if($genreData == null){
                    $genreData = array();
                }
    
                $genreData[$contentDto->getContentName()][IContentTable::CONTENT_URI] = $contentDto->getContentUri();
                IniWriter::iniWrite(FileUtil::getFilePath(GENRE_DIRECTORY, $genreName), $genreData, 'w+');
            }
        } else {
            $genreNames = $genreName;
            foreach ($genreNames as $value) {
                if(strpos($value, '/')){
                    $genreName = array_values(array_diff($genreName, array($value)));
                    continue;
                }
                $genreData = $this->getGenreContents($value);
                if($genreData == null){
                    $genreData = array();
                }
                $genreData[$contentDto->getContentName()][IContentTable::CONTENT_URI] = $contentDto->getContentUri();
                IniWriter::iniWrite(FileUtil::getFilePath(GENRE_DIRECTORY, $value), $genreData, 'w+');
            }
        }

        $contentDto->setContentGenres($genreName);
        IniWriter::iniWrite(FileUtil::getFilePath(POST_CONTENT_SETTING_DIRECTORY, $contentDto->getContentName()), $contentDto->getDtoCache(), 'w+');
        $this->postDtos = $this->currentPostPack();

        {
            $fp = fopen(FileUtil::getFilePath(POST_CONTENT_DIRECTORY, $contentDto->getContentUri().'.html'), 'w+');
            fwrite($fp, $content);
        }
    }

    /**
     * 全投稿データを返します。
     */
    public function getContents(){
        return FileUtil::directoryFileList(POST_CONTENT_SETTING_DIRECTORY);
    }

    public function getPostDtos(){
        return array_values($this->postDtos);
    }

    public function getPostContentSettingInUri($uri){
        return @$this->postDtos[$uri];
    }

    public function getPostContentSettingInTitle($contentTitle){
        if(!is_file(FileUtil::getFilePath(POST_CONTENT_SETTING_DIRECTORY, $contentTitle))){
            return null;
        }
        $contentDao = new ContentDao;
        return $contentDao->toDto(
            parse_ini_file(FileUtil::getFilePath(POST_CONTENT_SETTING_DIRECTORY, $contentTitle)));
    }

    public function hasPostUri($uri){
        return is_file(FileUtil::getFilePath(POST_CONTENT_DIRECTORY, $uri.'.html'));
    }

    public function getPostContentInName($uri){
        if(!is_file(FileUtil::getFilePath(POST_CONTENT_DIRECTORY, $uri.'.html'))){
            return false;
        }
        return file_get_contents(FileUtil::getFilePath(POST_CONTENT_DIRECTORY, $uri).'.html');
    }
}
