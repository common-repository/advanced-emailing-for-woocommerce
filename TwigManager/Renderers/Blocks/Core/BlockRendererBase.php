<?php

namespace rnadvanceemailingwc\TwigManager\Renderers\Blocks\Core;

use rnadvanceemailingwc\core\Exception\FriendlyException;
use rnadvanceemailingwc\DTO\BlockOptionsDTO;
use rnadvanceemailingwc\TwigManager\Renderers\ColumnRenderer;
use rnadvanceemailingwc\TwigManager\Renderers\Core\RendererBase;
use rnadvanceemailingwc\Utilities\FileUtilities;

abstract class BlockRendererBase extends RendererBase
{
    /** @var BlockOptionsDTO */
    public $Options;
    /** @var ColumnRenderer */
    public $Parent;

    protected function InternalInitialize()
    {

    }


    protected abstract function GetTemplateName();

    public function IsEmpty(){
        return false;
    }

    public function GetRetriever(){
        return $this->GetEmailRenderer()->OrderRetriever;
    }

    public function GenerateFileName($suffix)
    {
        return $this->Options->Id . '_' . $suffix;
    }

    protected function GetFileObjects()
    {
        return [];
    }

    public function GetFileToSave($validate=true,$basePath='')
    {
        $files=$this->GetFileObjects($validate,$basePath);
        if($validate)
        {
            foreach($files as $currentFile)
            {
                $pathToCheck='';
                if($basePath=='')
                {
                    if (!isset($_FILES[$currentFile['id']]))
                        throw new FriendlyException('File not found '.$currentFile['id']);

                    $pathToCheck=$_FILES[$currentFile['id']]['tmp_name'];
                }else{
                    $pathToCheck=$basePath.$currentFile['file'];
                }
                switch ($currentFile['type'])
                {
                    case 'image':
                        if(!FileUtilities::IsImage($pathToCheck))
                            throw new FriendlyException('File is not an image');
                        break;
                    default:
                        throw new FriendlyException('Unknown file type');
                }
            }
        }

        return $files;
    }

    public function GetAdditionalClasses(){

    }

    public function GetResourceURL($partialResourceId)
    {
        return $this->GetEmailRenderer()->GetEmailResourcesURL().$this->Options->Id.'_'. $partialResourceId;
    }

    public function GetUniqueId()
    {
        return 'Block_' . $this->Options->Id;
    }

    public function GetContainerTag(){
        return 'div';
    }
}