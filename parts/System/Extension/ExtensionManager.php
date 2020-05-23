<?php

namespace extension;

use db\dto\ExtensionDto;
use Exception;
use FileUtil;
use IniWriter;
use StringUtil;

final class ExtensionManager{
    
    private static $singleton;

    private $extensionDtos;

    private function __construct(){
        $this->extensionDtos = array();
        $this->load();
    }

    public static final function getInstance(){
        if(!isset(self::$singleton)){
            self::$singleton = new ExtensionManager();
        }
        return self::$singleton;
    }

    /**
     * @return array[string=>ExtensionDto]
     */
    public function getExtensionDtos(){
        return $this->extensionDtos;
    }

    private function load(){
        $this->extensionDtos = array();
        $this->loadExtension();
    }

    private function loadExtension(){
        ob_start();
		$extensionList = FileUtil::directoryList(EXTENSION_PATH);
		foreach ($extensionList as $extensionName) {
            $path = EXTENSION_PATH.$extensionName;
            if(!is_dir($path)){
                continue;
            }
            if(!is_file($path.'/detail.ini')){
                continue;
            }
            $extensionDetail = @parse_ini_file($path.'/detail.ini');
            $extensionDto = new ExtensionDto();
            $extensionDto->setExtensionName(isset($extensionDetail['EXTENSION_NAME'])?$extensionDetail['EXTENSION_NAME']:$extensionName);
            $extensionDto->setExtensionDescription(isset($extensionDetail['DESCRIPTION'])?$extensionDetail['DESCRIPTION']:'');
            $extensionDto->setInstallDay(isset($extensionDetail['INSTALL_DAY'])?$extensionDetail['INSTALL_DAY']:'');
            $extensionDto->setChangeDay(isset($extensionDetail['CHANGE_DAY'])?$extensionDetail['CHANGE_DAY']:'');
            $extensionDto->setIsUse(isset($extensionDetail['IS_USE'])?$extensionDetail['IS_USE']:false);
            $extensionDto->setCallAllowContent(isset($extensionDetail['CALL_ALLOW_CONTENT'])?$extensionDetail['CALL_ALLOW_CONTENT']:false);
            if($extensionDto->getIsUse() && !CVV_ADMIN_PAGE){
                if(!is_file($path.'/'.$extensionName.'.php')){
                    $extensionDto->setIsUse(false);
                } else {
                    $ex = FileUtil::existsFileRequire(FileUtil::getFilePath($path.'/', $extensionName.'.php'));
                    if($ex !== false){
                        $extensionDto->setExeInstance(new $extensionName);
                        $this->executeFunction($extensionDto->getExeInstance(), "awake");
                    }
                }
            }
            $this->extensionDtos[$extensionName] = $extensionDto;
        }
        $this->callAllExtension('start');
        ob_clean();
    }

    
    public function callContent(&$contentValue){
        /**
         * @var ExtensionDto $value
         */
        foreach ($this->extensionDtos as $key => $value) {
            if(!$value->getCallAllowContent()){
                continue;
            }
            {
                $extensionContent = $this->executeReturnFunction($value->getExeInstance(), 'contentStart');
                $contentValue = $extensionContent .= $contentValue;
            }
            $contentValue.=$this->executeReturnFunction($value->getExeInstance(), 'contentEnd');
        }
        return $contentValue;
    }

    public function callAllExtension($eventName, $argment = null){
        if($eventName == 'contentStart' || $eventName == 'contentEnd'){
            return;
        }
        /**
         * @var ExtensionDto $value
         */
        foreach ($this->extensionDtos as $key => $value) {
            $this->executeFunction($value->getExeInstance(), $eventName, $argment);
        }
    }

    public function changePluginSetting($extensionName, $extensionDto){
        if (!FileUtil::isPossibleChangeSettingData()) {
            return;
        }
        $pluginPath = EXTENSION_PATH.basename($extensionName).'/';
        $settingPath = $pluginPath.'detail.ini';
        if(!is_file($settingPath)){
            return;
        }
        foreach ($this->extensionDtos[$extensionName]->getDtoCache() as $key => $value) {
            if($extensionDto->getDtoCache() != null || $extensionDto->getDtoCache()[$key] !== $value){
                $extensionDto->setChangeDay(date(StringUtil::TIME_STAMP_FORMAT));
                IniWriter::iniWrite($settingPath, $extensionDto->getDtoCache());
                break;
            }
        }
    }
    
    public function getSettingContent($extensionName){
        if(!FileUtil::isPossibleChangeSettingData()){
            return;
        }
        echo $extensionName;
        if(!CVV_ADMIN_PAGE){
            return "";
        }
        $path = EXTENSION_PATH.$extensionName;
        ob_start();
        require($path.'/setting.php');
        return ob_get_clean();
    }

    public function hasSettingPage($extensionName){
        $path = EXTENSION_PATH.$extensionName;
        return is_readable($path.'/setting.php');
    }

    private function executeReturnFunction($clazz, $functionName, $argment = null){
        ob_start();
        if($argment == null){
            if(method_exists($clazz, $functionName)){
                ob_end_clean();
                return $clazz->$functionName();
            }
        } else {
            if(method_exists($clazz, $functionName)){
                ob_end_clean();
                return $clazz->$functionName($argment);
            }
        }
        ob_end_clean();
        return '';
    }
    
    private function executeFunction($clazz, $functionName, $argment = null){
        ob_start();
        try{
            if($argment == null){
                if(method_exists($clazz, $functionName)){
                    $clazz->$functionName();
                    return ob_get_clean();
                }
            } else {
                if(method_exists($clazz, $functionName)){
                    $clazz->$functionName($argment);
                    return ob_get_clean();
                }
            }
        } catch(Exception $ex) {
            //PLUGIN EXCEPTION
        }
        return ob_clean();
    }
}
//Load data
ExtensionManager::getInstance();

