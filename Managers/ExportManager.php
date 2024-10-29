<?php

namespace rnadvanceemailingwc\Managers;

use rnadvanceemailingwc\core\db\core\EmailRepository;
use rnadvanceemailingwc\core\Loader;
use rnadvanceemailingwc\DTO\EmailBuilderOptionsDTO;
use rnadvanceemailingwc\DTO\ImageBlockOptionsDTO;
use rnadvanceemailingwc\DTO\RowOptionsDTO;
use rnadvanceemailingwc\DTO\SectionOptionsDTO;
use rnadvanceemailingwc\DTO\SubSectionBlockOptionsDTO;
use rnadvanceemailingwc\TwigManager\Renderers\EmailRenderer;
use rnadvanceemailingwc\Utilities\Sanitizer;

class ExportManager
{
    /** @var Loader */
    public $Loader;
    public $ZipPath='';
    /** @var EmailBuilderOptionsDTO */
    public $Options;
    /** @var \ZipArchive */
    public $ZipArchive;
    public $FileOptions;
    /** @var EmailRenderer */
    public $EmailBuilder;
    public function __construct($loader)
    {
        $this->Loader=$loader;
    }

    public function Export($id){
        $this->FileOptions=new \stdClass();
        $emailRepository=new EmailRepository($this->Loader);
        $this->Options=$emailRepository->GetEmailOptions($id);
        if($this->Options==null)
            throw new \Exception('Email template was not found, maybe it was deleted?');




        $this->EmailBuilder=new EmailRenderer($this->Loader,(new EmailBuilderOptionsDTO())->Merge(json_decode(json_encode($this->Options))),null);

        $this->Options->Id=0;
        $fileManager=new FileManager($this->Loader);
        $zipArchive=new \ZipArchive();
        $this->ZipArchive=$zipArchive;
        $this->ZipPath=$fileManager->GetTempFolderPath().'export.zip';
        $zipArchive->open($this->ZipPath,\ZipArchive::CREATE|\ZipArchive::OVERWRITE);

        $this->MaybeAddResources();

        $this->MaybeAddImages();

        $zipArchive->addFromString('Template.json',json_encode($this->Options));
        $zipArchive->addFromString('FileOptions.json',json_encode($this->FileOptions));
        $zipArchive->close();

        return $this->ZipPath;
    }

    public function Remove(){
        \unlink($this->ZipPath);
    }

    private function MaybeAddImages()
    {
        /** @var ImageBlockOptionsDTO[] $blocks */
        $blocks=$this->GetBlocksByType($this->Options->ContentOptions->Sections,'Image');
        $files=[];
        $originalFiles=[];
        foreach($blocks as $imageBlock)
        {
           $file=$this->AddMediaToZip(Sanitizer::GetValueFromPath($imageBlock,['MediaData']),$originalFiles);
           if($file!=null)
                $files[]=$file;
        }

        $style=Sanitizer::GetStringValueFromPath($this->Options,['ContentOptions','Styles']);
        if($style!='')
        {
            $matches=[];
            preg_match_all('/url.*Id:(\d*)\\*\\/.*;/',$style,$matches,PREG_SET_ORDER);

            foreach($matches as $match)
            {
                $id=$match[1];
                $file=$this->AddMediaToZip((object)['Id'=>$id,"URL"=>''],$originalFiles);

                if($file!=null)
                {
                    $files[]=$file;
                    $style=str_replace($match[0],'url("'.$file['Name'].'");',$style);
                }
            }
        }

        $this->Options->ContentOptions->Styles=$style;


        $blocks=$this->GetBlocksByType($this->Options->ContentOptions->Sections,'HeaderBuilder');
        $originalFiles=[];
        foreach($blocks as $headerBuilderBlock)
        {
            foreach($headerBuilderBlock->Elements as $element)
            {
                if($element->Type=='Image')
                {
                    $file = $this->AddMediaToZip(Sanitizer::GetValueFromPath($element, ['ImageData']), $originalFiles);
                    if ($file != null)
                        $files[] = $file;
                }
            }
        }

        $this->FileOptions->OriginalFiles=$originalFiles;

        if(count($files)==0)
            return;

        $this->ZipArchive->addEmptyDir('Images');

        foreach($files as $currentFile)
        {
            $this->ZipArchive->addFromString("Images/".$currentFile['Name'],file_get_contents($currentFile['Path']));
        }
    }

    public function AddMediaToZip($mediaData,&$originalFiles)
    {
        $id=Sanitizer::GetStringValueFromPath($mediaData,['Id']);

        if($id=='')
            return null;

        $filePath=get_attached_file($id);
        if($filePath==false)
            return null;

        $originalPath=get_post_meta($id,'_wp_attached_file',true);
        $fileName=sanitize_file_name(basename($filePath));

        $mediaData->URL=$fileName;
        $originalFiles[$fileName]=$originalPath;
        return [
            "Name"=>$fileName,
            'Path'=>$filePath
        ];
    }

    /**
     * @param $sections SectionOptionsDTO[]
     * @param $blockType
     * @return void
     */
    private function GetBlocksByType($sections,$blockType)
    {
        $blocks=[];
        foreach($sections as $currentSection)
        {
            foreach($currentSection->Rows as $currentRow )
                foreach($currentRow->Columns as $currentColumn)
                {
                    foreach($currentColumn->Blocks as $currentBlock)
                    {
                        if($currentBlock->Type==$blockType)
                            $blocks[]=$currentBlock;
                        if($currentBlock instanceof SubSectionBlockOptionsDTO)
                        {
                            $blocks=array_merge($blocks,$this->GetBlocksByType($currentBlock->Sections,$blockType));
                        }
                    }
                }
        }

        return $blocks;
    }

    private function MaybeAddResources()
    {
        $resourcesPath=$this->EmailBuilder->GetEmailResourcesPath();
        $filesToSave=$this->EmailBuilder->GetFilesToSave(true,$resourcesPath);

        if(count($filesToSave)==0)
            return;

        $this->ZipArchive->addEmptyDir('Resources');
        foreach($filesToSave as $currentFile)
        {
            $this->ZipArchive->addFromString("Resources/".$currentFile['file'],file_get_contents($resourcesPath.$currentFile['file']));
        }

    }

}