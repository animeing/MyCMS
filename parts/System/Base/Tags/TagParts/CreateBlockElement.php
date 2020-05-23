<?php

namespace Tags\Parts;

class CreateBlockElement implements ICreateElement{

    public function hasPossibleToChildren(){
        return true;
    }

    public function create($tagElement)
    {
?>
<<?php echo $tagElement->getTagName();?><?php echo $tagElement->getClassNames()->getClassNameString();?><?php echo $tagElement->getAttributes()->getAttributesString();?>>
<?php
foreach((array)$tagElement->children() as $value){
    if(method_exists($value, 'create')){
        $value->create();
    } else {
        echo $value;
    }
}
?>
</<?php echo $tagElement->getTagName();?>>
<?php
    }
}