<?php
global $content;

use db\dto\ExtensionDto;
use extension\ExtensionManager;

if (is_null(BrowserUtil::getGetParam('plugin'))) {
    if(FileUtil::isPossibleChangeSettingData()){
        $isChanged = false;
        /**
         * @var ExtensionDto $extensionDto 
         */
        foreach(ExtensionManager::getInstance()->getExtensionDtos() as $extensionDto){
            $isUse = BrowserUtil::getPostParam(str_replace(' ', '_', $extensionDto->getExtensionName()).'_isUse');
            $isCallContent = BrowserUtil::getPostParam(str_replace(' ', '_', $extensionDto->getExtensionName()).'_isCallContent');
            if($isUse != null || $isCallContent != null){
                $isChanged = true;
                $extensionDto->setIsUse($isUse);
                $extensionDto->setCallAllowContent($isCallContent);
                ExtensionManager::getInstance()->changePluginSetting(str_replace(' ', '_', $extensionDto->getExtensionName()), $extensionDto);
            }
        }
    }
?>
<style>
table{
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
}

table tr{
  border-bottom: solid 1px #eee;
}

table tr:hover{
  background-color: #d4f0fd;
}
table th,
table .center{
    text-align: center;
}

table th,table td{
  width: 25%;
  padding: 15px 0;
}
.form {
    height: 100%;
    line-height: 20px;
}

</style>
    <form method="post" action="<?php echo CVV_VIEW_URL;?>" class="form setting">
<div class="block">
    <table>
    <tr>
    <th>Extension name</th>
    <th>Description</th>
    <th>Use</th>
    <th>Append page content</th>
    </tr>
    <?php
        /**
         * @var ExtensionDto $extensionDto 
         */
        foreach(ExtensionManager::getInstance()->getExtensionDtos() as $uri=>$extensionDto){
    ?>
    <tr>
    <td>
        <?php if(ExtensionManager::getInstance()->hasSettingPage($uri)){?>
        <a href="<?php echo CVV_TOP_URL.'admin/plugin/?plugin='. $uri; ?>">
        <?php echo $extensionDto->getExtensionName();?>
        </a>
        <?php } else {
            echo $extensionDto->getExtensionName();
        }?>
    </td>
    <td>
        <?php echo $extensionDto->getExtensionDescription();?>
    </td>
    <td class="center">
        <input type="hidden" name="<?php echo str_replace(' ', '_', $extensionDto->getExtensionName());?>_isUse" value="0" >
        <input type="checkbox" name="<?php echo str_replace(' ', '_', $extensionDto->getExtensionName());?>_isUse" value="1" <?php echo $extensionDto->getIsUse()?'checked="checked"':'';?> />
    </td>
    <td class="center">
        <input type="hidden" name="<?php echo str_replace(' ', '_', $extensionDto->getExtensionName());?>_isCallContent" value="0" >
        <input type="checkbox" name="<?php echo str_replace(' ', '_', $extensionDto->getExtensionName());?>_isCallContent" value="1" <?php echo $extensionDto->getCallAllowContent()?'checked="checked"':'';?> />
    </td>
    </tr>
    <?php
        }
    ?>
    </table>
</div>
<input type="submit"  value="<?php $content->getMultilanguage()->get('update')?>">
</form>
<?php
} else {
	echo ExtensionManager::getInstance()->getSettingContent(basename(BrowserUtil::getGetParam('plugin')));
}
