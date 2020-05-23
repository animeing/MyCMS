<?php
global $content;

use content\Menu\Menu;

$menu = new Menu();

if(FileUtil::isPossibleChangeSettingData() && BrowserUtil::getPostParam('menuName') != null){
    $isChanged = false;
    $currentMenus = $menu->getPublicMenus();
    $menuSelector = htmlspecialchars(BrowserUtil::getPostParam('menuSelector'));
    $newMenuSelector = array();
    if($menuSelector != null){
        foreach (BrowserUtil::getPostParam('menuName') as $value) {
            $menuName = htmlspecialchars($value);
            $menuLink = BrowserUtil::getPostParam($menuName);
            $newMenuSelector[$menuName] = $menuLink;
            $isChanged = true;
        }
    }
    
    if($isChanged){
        $currentMenus[$menuSelector] = $newMenuSelector;
        IniWriter::iniWrite(PARTS_DIRECTORY.'/Setting/menu.ini', $currentMenus);
        header("Location: " . CVV_VIEW_URL);
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
    transition: 0.5s;
}

table tr:hover{
  background-color: #d4f0fd;
}
table th,
table .center{
    text-align: center;
}

table input[type="text"]{
    width: calc(100%);
    box-sizing: border-box;
    height: 2.8em;
}

table th,table td{
  width: 25%;
  padding: 15px 0;
}
.form {
    height: 100%;
    line-height: 20px;
}
.setting input {
    margin: 0;
}

.form button{
    transition: 0.5s;
    width: calc(100% / 4 - ( 5px * 4) );
    padding: 10px;
    margin: 5px;
    border-radius: 25px;
    border: 1px solid #000;
    background: rgba(173, 173, 173, 0);
}

.form button:hover{
    background-color: rgba(173, 173, 173, 0.199);
}

</style>
<script>
var menuData = '<?php echo json_encode($menu->getPublicMenus());?>';

const createRecode=(menuName, menuLink)=>{
                let frame = document.createElement('tr');
                let menuNameFrameElement = document.createElement('td');
                let menuNameElement = document.createElement('input');
                menuNameElement.value = menuName;
                menuNameElement.type = 'text';
                menuNameElement.name = 'menuName[]';

                menuNameFrameElement.appendChild(menuNameElement);
                let linkFrameElement = document.createElement('td');
                let linkElement = document.createElement('input');
                linkFrameElement.appendChild(linkElement);
                linkElement.value = menuLink;
                linkElement.type = 'text';
                linkElement.name = menuNameElement.value;

                
                menuNameElement.addEventListener('change', ()=>{
                    linkElement.name = menuNameElement.value;
                });
                frame.appendChild(menuNameFrameElement);
                frame.appendChild(linkFrameElement);

                let actionFrame = document.createElement('td');

                let up = document.createElement('button');
                up.innerText = '↑';
                up.addEventListener('click',(e)=>{
                    let parent = frame.parentElement;
                    parent.insertBefore(frame, frame.previousElementSibling);
                });
                up.type="button";

                actionFrame.appendChild(up);

                let down = document.createElement('button');
                down.innerText = '↓';
                down.addEventListener('click',(e)=>{
                    let parent = frame.parentElement;
                    parent.insertBefore(frame.nextElementSibling, frame);
                });
                down.type="button";
                actionFrame.appendChild(down);

                let add = document.createElement('button');
                add.innerText = '+';
                add.addEventListener('click',(e)=>{
                    let parent = frame.parentElement;
                    parent.insertBefore(createRecode('', ''), frame);
                });
                add.type="button";
                actionFrame.appendChild(add);

                let remove = document.createElement('button');
                remove.innerText = '-';
                remove.addEventListener('click',(e)=>{
                    let parent = frame.parentElement;
                    parent.removeChild(frame);
                });
                remove.type="button";
                actionFrame.appendChild(remove);


                frame.appendChild(actionFrame);

                return frame;
}

window.addEventListener('load',()=>{
    let menus = JSON.parse(menuData);
    let menuSelectorFrame = document.getElementById('menuSelectorFrame');
    let comboBox = new ComboBoxObject();
    for(const menuSelector in menus){
        comboBox.addOption(menuSelector, menuSelector);
    }
    comboBox.object.name = 'menuSelector';
    menuSelectorFrame.appendChild(comboBox.object);
    let menu = (e)=>{
        let select = event.target.value;
        let menuDataElement = document.getElementById('menuData');
        menuDataElement.innerHTML = "<tr><th><?php echo $content->getMultilanguage()->get('menuName');?></th><th><?php echo $content->getMultilanguage()->get('link');?></th><th><?php echo $content->getMultilanguage()->get('action');?></th></tr>";
        for (const menuName in menus[comboBox.object.value]) {
            if ( menus[comboBox.object.value].hasOwnProperty(menuName)) {
                const element = menus[comboBox.object.value][menuName];
                menuDataElement.appendChild(createRecode(menuName, element));
            }
        }
    };
    menu();
    comboBox.object.addEventListener('change', menu);
});

</script>

<div id="content">
<form method="post" action="<?php echo CVV_VIEW_URL;?>" class="form setting" >
<span id="menuSelectorFrame"></span>
<table id="menuData">
</table>
<input type="submit" value="<?php $content->getMultilanguage()->get('update');?>" >
</form>
</div>