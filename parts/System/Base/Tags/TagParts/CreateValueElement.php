<?php

namespace Tags\Parts;

class CreateValueElement implements ICreateElement{

    public function hasPossibleToChildren(){
        return false;
    }

    public function create($tagElement)
    {
?>
<<?php echo $tagElement->getTagName();?><?php echo $tagElement->getClassNames()->getClassNameString();?><?php echo $tagElement->getAttributes()->getAttributesString();?> >
<?php
    }
}
