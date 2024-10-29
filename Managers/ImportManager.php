<?php

namespace rnadvanceemailingwc\Managers;

use rnadvanceemailingwc\core\db\core\EmailRepository;
use rnadvanceemailingwc\core\Exception\FriendlyException;
use rnadvanceemailingwc\core\Loader;
use rnadvanceemailingwc\DTO\EmailBuilderOptionsDTO;
use rnadvanceemailingwc\TwigManager\Renderers\EmailRenderer;
use rnadvanceemailingwc\Utilities\Sanitizer;
use ZipArchive;

class ImportManager
{
    /** @var Loader */
    public $Loader;
    /** @var \ZipArchive */
    public $ZipArchive;
    public $FileOptions;
    /** @var EmailRenderer */
    public $EmailBuilder;
    /** @var EmailBuilderOptionsDTO */
    public $Options;
    public $LoadedImages=[];
    public function __construct($loader)
    {
        $this->Loader=$loader;
    }

    /**
     * @param $file
     * @return EmailBuilderOptionsDTO
     * @throws \Exception
     */
    public function Import($file){
        $this->LoadedImages=[];
        $zipArchive=new ZipArchive();
        $this->ZipArchive=$zipArchive;
        if(!$zipArchive->open($file))
            throw new \Exception('Invalid import file');

        /** @var EmailBuilderOptionsDTO $options */
        $options=null;
        if(!$options=$zipArchive->getFromName('Template.json'))
            throw new \Exception('Invalid import file');

         $options=(new EmailBuilderOptionsDTO())->Merge(json_decode($options));

        if($options->Name=='')
            throw new \Exception("Invalid import file");

        $this->FileOptions=$zipArchive->getFromName('FileOptions.json');
        $this->FileOptions=\json_decode($this->FileOptions);

        $options->Id=0;
        $this->Options=$options;
        $emailRepository=new EmailRepository($this->Loader);
        $this->EmailBuilder=new EmailRenderer($this->Loader,$options,null);
        $this->GenerateResourcesVariable();
        $this->MaybeUploadImages();
        $emailRepository->SaveEmail($options,true);


        return $options;
    }

    public function Remove(){
        \unlink($this->ZipPath);
    }

    private function MaybeUploadImages()
    {
        if($this->ZipArchive->locateName('Images/')===false||!isset($this->FileOptions->OriginalFiles))
            return;


        $uploadedImages=[];
        foreach($this->Options->ContentOptions->Sections as $section)
        {
            foreach($section->Rows as $currentRow)
            {
                foreach($currentRow->Columns as $currentColumn)
                {
                    foreach($currentColumn->Blocks as $currentBlock)
                    {
                        if($currentBlock->Type=='Image')
                        {
                            $this->MaybeUploadImageToMedia(Sanitizer::GetValueFromPath($currentBlock, ['MediaData']));
                        }

                        if($currentBlock->Type=='HeaderBuilder'){
                            foreach($currentBlock->Elements as $currentElement)
                            {
                                if($currentElement->Type=='Image')
                                    $this->MaybeUploadImageToMedia(Sanitizer::GetValueFromPath($currentElement, ['ImageData']));

                            }
                        }

                    }
                }
            }
        }

        $styles=Sanitizer::GetStringValueFromPath($this->Options,['ContentOptions','Styles']);
        $matches=[];
        preg_match_all('/url\("([^"]*)"\);/',$styles,$matches,PREG_SET_ORDER);

        foreach($matches as $match)
        {
            $imageToUpload=$match[1];
            $mediaData=(object)['URL'=>$imageToUpload];
            $this->MaybeUploadImageToMedia($mediaData);

            if(isset($mediaData->Id))
            {
                $styles=str_replace($match[0],'url("'.$mediaData->URL.'")/*Id:'.$mediaData->Id.'*/ !important;',$styles);
            }

        }

        $this->Options->ContentOptions->Styles=$styles;

        foreach($this->FileOptions->OriginalFiles as $fileName=>$originalFilePath)
        {
            global $wpdb;
            if($wpdb->get_var($wpdb->prepare('select 1 from '.$wpdb->postmeta.' where meta_key="_wp_attached_file" and meta_value = %s',$originalFilePath))==null)
            {
                $fileName=sanitize_file_name($fileName);
                $image=$this->ZipArchive->getFromName('Images/'.$fileName);
                if($image==false)
                    continue;

                $tmp=get_temp_dir();

                if(!file_put_contents($tmp.'/'.$fileName,$image))
                    return false;
                $files=array(
                    'name'=>$fileName,
                    'tmp_name'=>$tmp.'/'.$fileName
                );
                if($_FILES==null)
                    $_FILES=array();
                $_FILES['ImportImage']=$files;

                $result=\media_handle_upload("ImportImage",0,array(),array( 'test_form' => false ,'action'=>'rn_file_upload'));
                if(\is_wp_error($result))
                    return false;

                $url=wp_get_attachment_url($result);

            }

        }

    }

    public function MaybeUploadImageToMedia($mediaData){

        $imageToUpload=Sanitizer::GetValueFromPath($mediaData,['URL'],'');
        if (trim($imageToUpload) == '')
            return null;
        $imageToUpload = sanitize_file_name($imageToUpload);

        if(!isset($this->LoadedImages[$imageToUpload]))
        {

            $image = $this->ZipArchive->getFromName('Images/' . $imageToUpload);
            if ($image == false)
                return null;

            $tmp = get_temp_dir();

            if (!file_put_contents($tmp . '/' . $imageToUpload, $image))
                return null;
            $files = array(
                'name' => $imageToUpload,
                'tmp_name' => $tmp . '/' . $imageToUpload
            );
            if ($_FILES == null)
                $_FILES = array();
            $_FILES['ImportImage'] = $files;

            $result = \media_handle_upload("ImportImage", 0, array(), array('test_form' => false, 'action' => 'rn_file_upload'));
            if (\is_wp_error($result))
                return null;

            $url = wp_get_attachment_url($result);

            $data = [
                'URL' => $url,
                'Id' => $result
            ];

            $this->LoadedImages[$imageToUpload] = $data;
        }

        $mediaData->URL=$this->LoadedImages[$imageToUpload]['URL'];
        $mediaData->Id=$this->LoadedImages[$imageToUpload]['Id'];
        return $this->LoadedImages[$imageToUpload];
    }

    private function GenerateResourcesVariable()
    {
        $files=$this->EmailBuilder->GetFilesToSave(false);
        if($files==null)
            return;

        $basePath=realpath(get_temp_dir());
        $resources=wp_unique_filename($basePath,'temp_resources');
        $basePath=$basePath.'/'.$resources.'/';

        if(!mkdir($basePath)){
            throw new FriendlyException('Error creating temp resource folder');
        }

        foreach($files as $currentFile)
        {
            $filePath=$basePath.sanitize_file_name($currentFile['file']);
            $fileData=$this->ZipArchive->getFromName('Resources/'.$currentFile['file']);
            if($fileData===false)
                throw new \Exception('File not found in zip');
            file_put_contents($filePath,$fileData);
            $_FILES[$currentFile['id']]=array(
                'name'=>$currentFile['file'],
                'tmp_name'=>$filePath
            );
        }
    }

}