<?php

namespace content;

use BrowserUtil;
use ComplessUtil;
use content\parts\LocalFilePagination;
use db\base\DtoToJson;
use db\dto\PaginationDto;
use FileUtil;
use MultiLanguage;
use StringUtil;
use Tags\Head;
use Tags\Title;

class Content implements IContent{
    private $httpHeader;
    private $httpHead;
    /**
     * @var IPagination
     */
    private $paginationProvider;
    private $logined = false;
    private $pageDto;
    private $multilanguage;
    private $loginUserDto;

    function __construct()
    {
        $this->httpHeader = new HttpHeader;
        $this->httpHead = new Head;
        $title = new Title();
        $this->httpHead->appendChild($title, 'title');
        $this->paginationProvider = new LocalFilePagination();
        try{
            if(BrowserUtil::getCookieParam('user') == null || BrowserUtil::getCookieParam('pass') == null){
                $this->pageDto = $this->getPaginationDto();
            } else {
                //Auto Login
                $usersDao = new \db\dao\UsersDao();
                /**
                 * @var \db\dto\UsersDto
                 */
                $userParam = $usersDao->toDto(FileUtil::readJsonDecode(PARTS_DIRECTORY.'Content/Admin/Users/'.basename(ComplessUtil::decrypt(BrowserUtil::getCookieParam('user'))).'.json'));
                $this->logined = password_verify(BrowserUtil::getCookieParam('pass'), $userParam->getAutoLoginCheck());
                $this->loginUserDto = $userParam;
                $this->pageDto = $this->getPaginationDto();
                $this->multilanguage = new MultiLanguage(PARTS_DIRECTORY.'Content/Admin/Lang', $userParam->getLanguage());
                if(!$this->logined){
                    echo 'This user may already be logged in from another source.';
                }
                return;
            }
            if(BrowserUtil::getPostParam('user') == null || BrowserUtil::getPostParam('pass') == null){
                $this->pageDto = $this->getPaginationDto();
            } else {
                //Auto Login
                $usersDao = new \db\dao\UsersDao;
                /**
                 * @var \db\dto\UsersDto
                 */
                $userParam = $usersDao->toDto(FileUtil::readJsonDecode(PARTS_DIRECTORY.'Content/Admin/Users/'.basename(BrowserUtil::getPostParam('user')).'.json'));
                $this->logined = password_verify(BrowserUtil::getPostParam('pass'), $userParam->getUserPass());
                if($this->logined){
                    $pas = StringUtil::uniqidString();
                    $userParam->setAutoLoginCheck(password_hash($pas, PASSWORD_BCRYPT));
                    BrowserUtil::setCookieParam('user', ComplessUtil::encrypt(basename(BrowserUtil::getPostParam('user'))), 3600);
                    BrowserUtil::setCookieParam('pass', $pas, 3600);
                    $userParam->setLastLogin($userParam->getLoginTime());
                    $userParam->setLoginTime(date(StringUtil::TIME_STAMP_FORMAT));
                    FileUtil::write(PARTS_DIRECTORY.'Content/Admin/Users/'.basename(BrowserUtil::getPostParam('user')).'.json', DtoToJson::converter($userParam));
                    $this->loginUserDto = $userParam;
                    $this->pageDto = $this->getPaginationDto();
                    $this->multilanguage = new MultiLanguage(PARTS_DIRECTORY.'Content/Admin/Lang', $userParam->getLanguage());
                    header("Location: " . CVV_VIEW_URL);
                    return;
                } else {
                    echo 'Login fail';
                }
            }
            $this->pageDto = $this->getPaginationDto();
            $this->logined = false;
            return;
        } catch(\Exception  $e){
            //ignore
        }
    }

    /**
     * @return \db\dto\UsersDto
     */
    public function getLoginUserDto(){
        return $this->loginUserDto;
    }

    public function getMultilanguage(){
        return $this->multilanguage;
    }

    public function getLoginUserName(){
        if($this->isLoginNow()){
            return $this->getLoginUserDto()->getUserName();
        } else {
            return "undefined.";
        }
    }

    public function getPageDto(){
        return $this->pageDto;
    }

    private function getPaginationDto(){
        $paginationDto = new PaginationDto();
        if($this->isLoginNow()){
            $setting = null;
            if($this->hasUrl()){
                $setting = parse_ini_file($this->toPageDataPath().'.ini');
                $paginationDto->setPageTitle($setting['pageTitle']);
                $paginationDto->setDescription($setting['draftDay']);
                $paginationDto->setPageData(isset($setting['pageData'])?$setting['pageData']:'');
                $paginationDto->setUri(CVV_PATH_NAME);
                if($this->httpHead->children()['title'] != null){
                    $this->httpHead->children()['title']->setValue($setting['pageTitle']);
                }
                return $paginationDto;
            }
        } else {
            $setting = null;
            $paginationDto = new PaginationDto();
            if(file_exists(PARTS_DIRECTORY.'Content/Admin/Pages/LoginForm.ini')){
                $setting = parse_ini_file(PARTS_DIRECTORY.'Content/Admin/Pages/LoginForm.ini');
                $paginationDto->setPageTitle($setting['pageTitle']);
                $paginationDto->setDescription('');
                $paginationDto->setPageData('');
                $paginationDto->setUri(CVV_PATH_NAME);
                if($this->httpHead->children()['title'] != null){
                    $this->httpHead->children()['title']->setValue($setting['pageTitle']);
                }
                return $paginationDto;
            }
        }
        $setting = parse_ini_file(PARTS_DIRECTORY.'Content/Admin/Pages/404.ini');
        $paginationDto->setUri(CVV_PATH_NAME);
        $paginationDto->setPageTitle($setting['pageTitle']);
        $paginationDto->setDescription('');
        $paginationDto->setPageData('');
        if($this->httpHead->children()['title'] != null){
            $this->httpHead->children()['title']->setValue($setting['pageTitle']);
        }
        return $paginationDto;
    }

    public function getHttpHeader(){
        return $this->httpHeader;
    }

    public function getHttpHead(){
        return $this->httpHead;
    }

    public function getContent(){
        if($this->isLoginNow()){
            if($this->hasUrl()){
                ob_start();
                FileUtil::existsFileRequire($this->toPageDataPath().'.php');
                return ob_get_clean();
            } else {
                ob_start();
                require(PARTS_DIRECTORY.'Content/Admin/Pages/404.php');
                return ob_get_clean();
            }
        } else {
            ob_start();
            require(PARTS_DIRECTORY.'Content/Admin/Pages/LoginForm.php');
            return ob_get_clean();
        }
    }

    /**
     * @return string full path
     */
    private function toPageDataPath($uri = null){
        if($uri == null){
            $uri = str_replace(CVV_TOP_URL.'admin/', '', str_replace("?".CVV_QUERY, '',CVV_VIEW_URL));
        }
        if(substr(mb_strtolower(str_replace('/', '^', $uri)), 0, -1) == ''){
            return PARTS_DIRECTORY.'Content/Admin/Pages/index';
        }
        return PARTS_DIRECTORY.'Content/Admin/Pages/'.substr(mb_strtolower(str_replace('/', '^', $uri)), 0, -1);
    }

    public function getUriToFile($uri){
        if(substr(mb_strtolower(str_replace('/', '^', $uri)), 0, -1) == '' || $uri == 'index'){
            return 'index';
        } else {
            return substr(mb_strtolower(str_replace('/', '^', $uri)), 0);
        }
    }

    public function getPublicPageProvider(){
        //TODO
        return new LocalFilePagination();
    }

    public function hasUrl($uri = null){
        if($this->isLoginNow()){
            return $this->paginationProvider->hasUrl($this->toPageDataPath($uri).'.php');
        } else {
            //Login form;
            return true;
        }
    }

    public function isLoginNow(){
        return $this->logined;
    }

    public function getPublicPages(){
        $pageDtos = array();
        foreach (FileUtil::directoryFileList(PAGES_DIRECOTRY) as $fileName) {
            if( preg_match('/.ini$/',$fileName) && is_writable(PAGES_DIRECOTRY.basename($fileName, '.ini').'.php')){
                $pageData = parse_ini_file(PAGES_DIRECOTRY.$fileName);
                $pageDto = new PaginationDto();
                $pageDto->setUri($pageData['URI'] == ''? basename($fileName) : $pageData['URI']);
                $pageDto->setPageTitle($pageData['PAGE_TITLE'] == ''? basename($fileName, '.ini') : $pageData['PAGE_TITLE']);
                $pageDto->setDraftDay($pageData['DRAFT_DAY']);
                $pageDto->setDescription($pageData['DESCRIPTION']);
                $pageDto->setPageData(file_get_contents(PAGES_DIRECOTRY.basename($fileName, '.ini').'.php'));
                $pageDtos[$pageDto->getPageTitle()] = $pageDto;
            }
        }
        return $pageDtos;
    }

    public function getPublicPage($fileName){
        if( preg_match('/.ini$/',$fileName) && is_writable(PAGES_DIRECOTRY.basename($fileName, '.ini').'.php')){
            $pageData = parse_ini_file(PAGES_DIRECOTRY.$fileName);
            $pageDto = new PaginationDto();
            $pageDto->setPageTitle($pageData['PAGE_TITLE'] == ''? basename($fileName, '.ini') : $pageData['PAGE_TITLE']);
            $pageDto->setDraftDay($pageData['DRAFT_DAY']);
            $pageDto->setDescription($pageData['DESCRIPTION']);
            $pageDto->setPageData(file_get_contents(PAGES_DIRECOTRY.basename($fileName, '.ini').'.php'));
            return $pageDto;
        }
    }
}


global $content;
$content = new Content();