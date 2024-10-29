<?php

namespace rnadvanceemailingwc\TwigManager\Renderers\Core;

use rnadvanceemailingwc\TwigManager\Renderers\EmailRenderer;
use rnadvanceemailingwc\TwigManager\TwigManager;
use rnadvanceemailingwc\Utilities\Sanitizer;
use rnadvanceemailingwc\Utilities\TreeSeeker\INode;
use Twig\Markup;

abstract class RendererBase implements INode
{
    /** @var RendererBase */
    public $Parent;
    /** @var TwigManager */
    public static $TwigManager;
    /** @var RendererBase[] */
    public $Options;
    public function __construct($options,$parent=null)
    {
        $this->Options=$options;
        $this->Parent=$parent;
    }

    public function GetParent()
    {
        return $this->Parent;
    }

    public abstract function IsEmpty();


    public function GetLoader(){
        return $this->GetEmailRenderer()->Loader;
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
    }

    protected abstract function InternalInitialize();
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
            throw new \Exception('Template not found');
        return new Markup($this->GetTwigManager()->Render($templateName,$model),'UTF-8');
    }

    /**
     * @return RendererBase[]
     */
    public function GetChildren(){
        return [];
    }

    public function RenderChildren(){
        $markups='';
        foreach($this->GetChildren() as $currentChildren)
        {
            if($currentChildren->IsEmpty())
                continue;
            $markups.=strval($currentChildren->Render());
        }

        return new Markup($markups,'UTF-8');
    }

}