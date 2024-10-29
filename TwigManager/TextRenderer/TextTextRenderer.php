<?php

namespace rnadvanceemailingwc\TwigManager\TextRenderer;

use rnadvanceemailingwc\TwigManager\TextRenderer\Core\TextRendererBase;

class TextTextRenderer extends TextRendererBase
{

    public $TagToUse;
    public $Styles;
    public $Text;
    public $Attrs=[];
    protected function GetTemplateName()
    {
        return 'TwigManager/TextRenderer/TextTextRenderer.Twig';
    }

    protected function InternalInitialize()
    {
        parent::InternalInitialize();
        $this->Attrs=[];
        $this->TagToUse=$this->GetTag();
        $this->Styles='';
        $this->Text=$this->GetText();
        if(isset($this->Content->marks))
            foreach($this->Content->marks as $currentMark)
            {
                switch ($currentMark->type)
                {
                    case 'color':
                        $this->Styles.='color:'.$currentMark->attrs->color.'; ';
                        break;
                    case 'strong':
                        $this->Styles.='font-weight:bold; ';
                        break;
                    case 'em':
                        $this->Styles.='font-style:italic; ';
                        break;
                }
            }

    }

    public function GetTag()
    {
        if(isset($this->Content->marks))
            foreach($this->Content->marks as $currentMark)
            {
                if($currentMark->type=='link')
                {
                    $this->TagToUse='a';
                    $this->Attrs['target']=$currentMark->attrs->target;
                    if($currentMark->attrs->type=='order')
                        $this->Attrs['href']=$this->Parent->GetEmailRenderer()->OrderRetriever->GetOrderURL();
                    else
                        $this->Attrs['href']=$currentMark->attrs->href;

                     return 'a';


                }
            }
        return 'span';
    }

    public function GetText()
    {
        return $this->Content->text;
    }

    public function GetAttributes()
    {
        $attrs='';
        foreach($this->Attrs as $name=>$value)
        {
            $attrs.=$name.'="'.esc_attr($value).'" ';
        }

        return $attrs;
    }






}