<?php

namespace rnadvanceemailingwc\Managers\FormulaManager\Elements;

use rnadvanceemailingwc\Managers\FormulaManager\FRBase;
use rnadvanceemailingwc\Managers\FormulaManager\FRFactory;
use rnadvanceemailingwc\Managers\FormulaManager\Utilities\FRUtilities;

class FRBlock extends FRBase
{
    /** @var FRBase[] */
    private $Sentences;
    public $ShouldReturn = false;

    public function __construct($Options, $Parent)
    {
        parent::__construct($Options, $Parent);
        $this->Sentences = [];

        foreach ($this->Options->d as $sentence)
            $this->Sentences[] = FRFactory::GetFRElement($sentence, $this);
    }

    public function Parse()
    {
        $result = null;
        foreach ($this->Sentences as $currentSentence)
        {
            $result = $currentSentence->Parse();
            if ($this->ShouldReturn)
                break;

        }

        return $result;

    }

    public function ReturnWasExecuted()
    {
        $this->ShouldReturn = true;
        FRUtilities::NotifyReturnToParent($this);
    }


}