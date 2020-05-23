<?php

if(FileUtil::isPossibleChangeSettingData()){
    if(browserutil::getPostParam('select') != null && browserutil::getPostParam('select') != THEME_NAME){
        admin_theme_theme_change(BrowserUtil::getPostParam('select'));
        header("Location: " . CVV_VIEW_URL);
    }
}
global $content;

?><style>
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

.overflow_dotreader{
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
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
<form action="<?php echo CVV_VIEW_URL;?>"  method="post" class="form setting">
<div class="block">
    <table>
    <tr>
        <th>Image</th>
        <th>Theme Name</th>
        <th>Use</th>
    </tr>
    <?php
        foreach (FileUtil::directoryList(THEME_DIRECTORY) as $value) {
    ?>
    <tr>
        <td><img src="<?php echo CVV_TOP_URL.'admin/?theme='.$value;?>" width="50%" style="display: block;margin: 0 auto;"></td>
        <td><?php echo $value?></td>
        <td><input type="radio" name="select" value="<?php echo $value;?>" <?php echo THEME_NAME == $value?'checked="checked"':'';?>></td>
    </tr>
    <?php
        }
    ?>
    </table>
</div>
<input type="submit" value="<?php $content->getMultilanguage()->get('update')?>" >
</form>