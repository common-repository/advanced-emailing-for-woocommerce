<?php

namespace rnadvanceemailingwc\Utilities\TreeSeeker;

class TreeSeeker
{
    /**
     * @param $node INode
     * @param $type
     * @return mixed|void|null
     */
    public static function GetParentOfType($node,$type)
    {
        if($node==null)
            return null;

        if(get_class($node)==$type)
            return $node;

        if($node->GetParent()==null)
            return null;

        return TreeSeeker::GetParentOfType($node->GetParent(),$type);

    }
}