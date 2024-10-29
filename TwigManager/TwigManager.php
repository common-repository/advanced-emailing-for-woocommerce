<?php

namespace rnadvanceemailingwc\TwigManager;

use rnadvanceemailingwc\core\Loader;
use rnadvanceemailingwc\TwigManager\TwigExtension\Functions;
use Twig\Environment;
use Twig\Extra\CssInliner\CssInlinerExtension;
use Twig\Loader\FilesystemLoader;

class TwigManager
{
    /** @var Environment */
    public $Twig;
    /** @var Loader */
    public $Loader;

    public function __construct($loader,$paths=[])
    {
        $this->Loader=$loader;
        require_once $this->Loader->DIR.'vendor/autoload.php';
        $twigLoader = new \Twig\Loader\FilesystemLoader(array_merge([$this->Loader->DIR],$paths));
        $this->Twig = new \Twig\Environment($twigLoader, [
            'auto_reload' => true,
            'strict_variables' => true
        ]);

        $this->Twig->addExtension(new Functions($this->Loader));
        $this->Twig->addExtension(new CssInlinerExtension());
    }

    public function AddPath($path)
    {
        /** @var FilesystemLoader $loader */
        $loader=$this->Twig->getLoader();
        $loader->addPath($this->Loader->DIR.'TwigManager/Renderers');
    }

    public function Render($templateName,$model,$additionalProperties=[]){
        return $this->Twig->render($templateName,array_merge(['Model'=>$model],$additionalProperties),'UTF-8');
    }

    public function SetDestiny(){

    }
}