<?php

namespace rnadvanceemailingwc\TwigManager\SimpleTextRenderer;

use rnadvanceemailingwc\Fields\Core\OrderRetriever;
use rnadvanceemailingwc\Utilities\Sanitizer;

class SimpleTextRenderer
{
    /** @var OrderRetriever */
    public $Retriever;
    private function __construct($retriever)
    {
        $this->Retriever=$retriever;
    }

    private function InternalGetText($content)
    {
        if(Sanitizer::GetStringValueFromPath($content,['type'])!='doc')
            return '';

        $text='';
        foreach($content->content as $currentContent)
        {
            switch ($currentContent->type)
            {
                case 'text':
                    $text.=$currentContent->text;
                    break;
                case 'field':
                    $field=$this->Retriever->GetFieldById(Sanitizer::GetStringValueFromPath($currentContent,['attrs','Value']));
                    if($field!=null)
                        $text.=$field->ToText();
                    break;

            }
        }

        return $text;

    }

    public static function GetText($renderer,$content)
    {
        return (new SimpleTextRenderer($renderer))->InternalGetText($content);
    }


}