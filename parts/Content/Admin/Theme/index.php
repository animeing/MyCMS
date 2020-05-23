<!DOCTYPE html>
<html lang="en">
<?php $content->getHttpHead()->create();?>
<body>
<?php
if($content->isLoginNow()){
    echo admin_theme_function_menuData()->create();
?>
<div id="fixed-window">

</div>
<?php
}
?>
<?php
    echo $content->getContent();
?>
</body>
</html>
