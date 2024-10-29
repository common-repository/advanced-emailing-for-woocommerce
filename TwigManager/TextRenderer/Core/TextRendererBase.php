<?php

namespace rnadvanceemailingwc\TwigManager\TextRenderer\Core;

use rnadvanceemailingwc\TwigManager\Renderers\Core\RendererBase;
use rnadvanceemailingwc\TwigManager\Renderers\EmailRenderer;
use rnadvanceemailingwc\TwigManager\TwigManager;
use rnadvanceemailingwc\Utilities\Sanitizer;
use rnadvanceemailingwc\Utilities\TreeSeeker\INode;
use Twig\Markup;

abstract class TextRendererBase implements INode
{
    /** @var RendererBase */
    public $Parent;
    public $Content;
    /** @var TwigManager */
    public static $TwigManager;
    /** @var RendererBase[] */
    public $Children;
    public function __construct($content,$parent=null)
    {
        $this->Content=$content;
        $this->Parent=$parent;
        $this->Children=[];
        $this->ParseChildren();
    }

    public function GetParent(){
        return $this->Parent;
    }

    public function GetAttributeValue($attributeName)
    {
        return Sanitizer::GetValueFromPath($this->Content,['attrs',$attributeName]);
    }

    public function GetStringAttribute($attributeName)
    {
        $value=$this->GetAttributeValue($attributeName);
        if($value==null)
            return '';
        return Sanitizer::SanitizeString($value);

    }

    public function GetLoader(){
        return $this->Parent->GetEmailRenderer()->Loader;
    }

    /**
     * @return EmailRenderer
     */
    public function GetEmailRenderer(){
        if($this instanceof EmailRenderer)
            return $this;

        return $this->Parent->GetEmailRenderer();
    }

    public function Initialize(){
        $this->InternalInitialize();
        foreach ($this->Children as $currentChild)
            $currentChild->Initialize();
        return $this;
    }

    protected function InternalInitialize(){

    }

    public function GetTwigManager(){
        return $this->GetLoader()->GetTwigManager();
    }


    protected abstract function GetTemplateName();

    public function Render(){
        return $this->RenderTemplate($this->GetTemplateName(),$this);
    }

    public function RenderTemplate($templateName,$model)
    {
        if($templateName=='')
            throw new \Exception('Text Template not found');
        return new Markup($this->GetTwigManager()->Render($templateName,$model),'UTF-8');
    }

    public function GetContentChildren(){
        if($this->Content==null||!isset($this->Content->content))
            return [];

        $content=$this->Content->content;
        if(!is_array($content))
            return [$content];

        return $content;
    }

    private function ParseChildren()
    {
        $children=$this->GetContentChildren();
        foreach($children as $currentChild)
        {
            $this->Children[]=TextRenderFactory::GetRenderer($currentChild,$this);
        }

    }

    public function RenderChildren(){
        $markups='';
        foreach($this->Children as $currentChildren)
        {
            $markups.=strval($currentChildren->Render());
        }

        return new Markup($markups,'UTF-8');
    }

}