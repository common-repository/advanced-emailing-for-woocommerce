<?php

namespace rnadvanceemailingwc\Managers\ConditionManager\Comparators\Core;

use rnadvanceemailingwc\DTO\ConditionLineOptionsDTO;
use rnadvanceemailingwc\Fields\Core\OrderRetriever;

abstract class ComparatorBase
{
    /**
     * @param $retriever OrderRetriever
     * @param $condition ConditionLineOptionsDTO
     * @return bool
     */
    public abstract function Compare($retriever,$conditionLine);

}