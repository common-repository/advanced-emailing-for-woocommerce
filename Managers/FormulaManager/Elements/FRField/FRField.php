<?php

namespace rnadvanceemailingwc\Managers\FormulaManager\Elements\FRField;

use rnadvanceemailingwc\Managers\FormulaManager\FRBase;

class FRField extends FRBase
{
    public function Parse()
    {
        return $this->GetRetriever()->GetFieldById('');

    }
}