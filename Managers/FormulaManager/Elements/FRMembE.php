<?php

namespace rnadvanceemailingwc\Managers\FormulaManager\Elements;

use rnadvanceemailingwc\core\Utils\ArrayUtils;
use rnadvanceemailingwc\Managers\FormulaManager\FRBase;
use rnadvanceemailingwc\Managers\FormulaManager\FRFactory;
use rnadvanceemailingwc\Managers\FormulaManager\Utilities\FRUtilities;

class FRMembE extends FRBase
{
    private $Subt;
    /** @var FRBase */
    private $Prop;
    /** @var FRBase */
    private $Caller;
    /** @var FRBase[] */
    public $Args;


    public function __construct($Options, $Parent)
    {
        parent::__construct($Options, $Parent);

        $this->Subt = $this->Options->St;
        if ($this->Options->St == 'Pr')
            $this->Prop = $this->Options->Pr;
        else
            $this->Prop = FRFactory::GetFRElement($this->Options->Pr, $this);
        $this->Caller = FRFactory::GetFRElement($this->Options->C, $this);

        $this->Args = [];
        if (is_array($this->Options->Args))
            foreach ($this->Options->Args as $x)
                $this->Args[] = FRFactory::GetFRElement($x, $this);

    }

    public function Parse()
    {
        $caller = $this->Caller->Parse();

        switch ($this->Subt)
        {
            case 'Pr':
                $property = strval($this->Prop);


                if (property_exists($caller, $property))
                    return $caller->$property;

                if (method_exists($caller, $property))
                    return call_user_func(array($caller, $property), ...ArrayUtils::Map($this->Args,function ($item){return $item->Parse();}));

                return null;


            case 'Arr':
                $prop = $this->Prop->Parse();
                $index = FRUtilities::SanitizeNumber($prop, null);

                if (!is_array($caller) || !isset($caller[$index]))
                    return null;
                return $caller[$index];
        }

        return null;
    }

    public function Assign($value)
    {
        switch ($this->Subt)
        {
            case 'Arr':
                $caller = &$this->Caller->Parse();
                $index = $this->Prop->Parse();

                if ($index == null)
                    return null;
                if (!is_array($caller) || !isset($caller[$index]))
                    return null;
                $caller[$index] = $value;
                break;
            case 'Pr':
                $caller = $this->Caller->Parse();

                if (count($this->Args) > 0)
                    return;

                $property = strval($this->Prop);

                if ($caller==null||!property_exists($caller, $property))
                    return null;

                $caller->$property = $value;
                return;

        }
    }
}