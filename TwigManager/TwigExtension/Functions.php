<?php

namespace rnadvanceemailingwc\TwigManager\TwigExtension;


use rnadvanceemailingwc\core\Loader;
use Twig\Extension\AbstractExtension;
use Twig\Markup;
use Twig\TwigFunction;

class Functions extends AbstractExtension
{
    /** @var $Loader Loader */
    public $Loader;
    public function __construct($loader)
    {
        $this->Loader=$loader;
    }

    public function getFunctions()
    {
        $me=$this;
        return[
            new TwigFunction('ParseIcon',function ($iconName,$params=[]){return $this->ParseIcon($iconName,$params);}),
            new TwigFunction('ParseURL',[$this,'ParseURL']),
            new TwigFunction('AddStyle',function ($handler,$url,$dependency=array())use($me){
                wp_enqueue_style($handler,$me->Loader->URL.$url,$dependency);
            }),
            new TwigFunction('ParseDisabled',function ($condition){
                if($condition==null)
                    return '';

                return 'disabled';
            }),
            new TwigFunction('ParseChecked',function ($condition){
                if($condition==null)
                    return '';

                return 'checked';
            }),
            new TwigFunction('ParseSelected',function ($condition){
                if($condition==null)
                    return '';

                return 'selected';
            }),
            new TwigFunction('ParseSubmitActionJavascript',function ($actionName,$params)
            {
                if(is_array($params)||is_object($params))
                    $params=json_encode($params);

                if($params=='event.target.value')
                    return "javascript:RNSubmitAction(event,'".esc_attr__($actionName)."',$params)";
                return "javascript:RNSubmitAction(event,'".esc_attr__($actionName)."',".json_encode($params).")";
            })
        ];
    }

    public function ParseIcon($iconName,$params){
        return new Markup(
            file_get_contents($this->Loader->URL.'icons/'.$iconName.'.svg')
            ,'UTF-8');
    }


}