<?php

namespace rnadvanceemailingwc\Utilities\TreeSeeker;

interface INode
{
    /**
     * @return INode
     */
    public function GetParent();
}