<?php
global $content;
if(admin_theme_function_isChangeSiteSetting()){
    admin_theme_function_siteSettingUpdate();
    header("Location: " . CVV_VIEW_URL);
}
?>
<script>
window.addEventListener('load',()=>{
    let storage = new CookieMap('<?php echo CVV_TOP_URL.'admin/';?>');
    if(storage.get('change')){
        let messageWindow = new MessageButtonWindow();
        messageWindow.value = '<?php $content->getMultilanguage()->get('hasBeenUpdated')?>';
        messageWindow.addItem('OK', ()=>{
            storage.delete('change','');
            messageWindow.close();
        });
    }
});
</script>
<div class="infomation block">
<div>
    <p><?php $content->getMultilanguage()->get('userName');?> : <?php echo admin_theme_loginUser();?></p>
    <p><?php $content->getMultilanguage()->get('theme');?> : <?php echo THEME_NAME;?></p>
    <p><?php $content->getMultilanguage()->get('lastLoginTime');?> : <?php echo $content->getLoginUserDto()->getLastLogin();?></p>
    <p><?php $content->getMultilanguage()->get('currentLoginTime');?> : <?php echo $content->getLoginUserDto()->getLoginTime();?></p>
</div>
<span><?php $content->getMultilanguage()->get('storage')?> : </span>
<?php

print "<span>".StringUtil::getStorageSymbolByQuantity(disk_free_space(dirname(__DIR__)))."/".StringUtil::getStorageSymbolByQuantity(disk_total_space(dirname(__DIR__)))."</span>";
$color = "#90EE90";
if(disk_free_space(dirname(__DIR__)) / disk_total_space(dirname(__DIR__))*100*5 <= 100){
	$color = "#F0E68C";
	if(disk_free_space(dirname(__DIR__)) / disk_total_space(dirname(__DIR__))*100*5 <= 50){
		$color = "#FF0000";
		if(disk_free_space(dirname(__DIR__)) / disk_total_space(dirname(__DIR__))*100*5 <= 25){
			$color = "#DC143C";
			if(disk_free_space(dirname(__DIR__)) / disk_total_space(dirname(__DIR__))*100*5 <= 10){
				$color = "#800000";
				if(disk_free_space(dirname(__DIR__)) / disk_total_space(dirname(__DIR__))*100*5 <= 5){	
					$color = "#000";
				}
			}
		}
	}
}
?>
<div style="width:500px;max-width: 100%;height:10px;border:1px solid #eee;">
    <div style="width:<?php print disk_free_space(dirname(__DIR__)) / disk_total_space(dirname(__DIR__))*100;?>%;height:10px; background-color: <?php print $color;?>;">
	</div>
</div>
</div>
<div>
    <a href="<?php echo CVV_PAGE_VIEW_URL.'user/'?>"><?php $content->getMultilanguage()->get('userSetting')?></a>
    <form method="post" action="<?php echo CVV_VIEW_URL;?>" class="form setting">
        <div class="block">
            <p><?php $content->getMultilanguage()->get('siteTitle')?></p>
            <input type="text" name="siteTitle" value="<?php echo SITE_NAME;?>">
        </div>
        <div class="block">
            <p><?php $content->getMultilanguage()->get('pageSiteTitleFormat')?></p>
            <input type="text" name="siteTitleFormat" value="<?php echo SITE_TITLE_FORMAT;?>">
        </div>
        <div class="block">
            <p><?php $content->getMultilanguage()->get('copyRight')?></p>
            <input type="text" name="siteCopyright" value="<?php echo SITE_COPYRIGHT;?>">
        </div>
        <div class="block">
            <p><?php $content->getMultilanguage()->get('emargencyContactEmailAddress')?></p>
            <input type="text" placeholder="<?php echo StringUtil::EMAIL_ADDRESS_PLACEHOLDER;?>" name="postMailAddress" value="<?php echo POST_MAIL;?>">
        </div>
        <div class="block">
            <p><?php $content->getMultilanguage()->get('CSSJavaScriptCompless')?></p>
            <input type="hidden" name="data_compless" value="0" >
            <input type="checkbox" name="data_compless" value="1" <?php echo DATA_COMPLESS?'checked="checked"':'';?> />
        </div>
        <input type="submit" value="<?php $content->getMultilanguage()->get('update')?>"/>
    </form>
</div>