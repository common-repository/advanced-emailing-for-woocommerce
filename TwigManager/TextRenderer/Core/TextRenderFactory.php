<?php

namespace rnadvanceemailingwc\TwigManager\TextRenderer\Core;



use rnadvanceemailingwc\TwigManager\TextRenderer\FieldTextRenderer;
use rnadvanceemailingwc\TwigManager\TextRenderer\RawTextRenderer;
use rnadvanceemailingwc\TwigManager\TextRenderer\TextTextRenderer;

class TextRenderFactory
{

    public static function GetRenderer($content,$parent)
    {
        if($content==null)
            return null;

        if(!isset($content->type))
            throw new \Exception('This renderer does not have a type');

        switch ($content->type)
        {
            case 'heading':
                return new SimpleContainerTextRenderer('h'.$content->attrs->level,$content,$parent);
            case 'text':
                return new TextTextRenderer($content,$parent);
            case 'field':
                return new FieldTextRenderer($content,$parent);
            case 'paragraph':
                return new SimpleContainerTextRenderer('p',$content,$parent);
            case 'hard_break':
                return new RawTextRenderer('<br/>',$content,$parent);
            case 'bullet_list':
                return new SimpleContainerTextRenderer('ul',$content,$parent);
            case 'ordered_list':
                return new SimpleContainerTextRenderer('ol',$content,$parent);
            case 'list_item':
                return new SimpleContainerTextRenderer('li',$content,$parent);
            default:
                throw new \Exception('No text renderer found for type '.$content->type);
        }
    }

}