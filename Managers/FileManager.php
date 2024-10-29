<?php

namespace rnadvanceemailingwc\Managers;

use rnadvanceemailingwc\core\Loader;

class FileManager
{
    /** @var Loader */
    public $Loader;
    public $_rootPath='';
    public function __construct($loader)
    {
        $this->Loader=$loader;
    }


    public function GetTempFolderPath(){
        $tempFolder=$this->GetRootFolderPath().'temp/';
        $this->MaybeCreateFolder($tempFolder,true);
        return $tempFolder;
    }

    public function GetTempFolderURL(){
        $tempFolder=$this->GetRootFolderURL().'temp/';
        return $tempFolder;
    }

    public function GetUploadDir(){
        $uploadDir=wp_upload_dir();
        return $uploadDir['basedir'];
    }

    public function GetUploadURL(){
        $uploadDir=wp_upload_dir();
        return $uploadDir['baseurl'];
    }

    public function GetRootFolderPath()
    {
        if($this->_rootPath=='')
        {
            $this->_rootPath=\str_replace('\\','/', $this->GetUploadDir().'/'.$this->Loader->Prefix.'/');
            $this->MaybeCreateFolder($this->_rootPath,false);
        }
        return $this->_rootPath;
    }

    public function GetRootFolderURL()
    {
        return $this->GetUploadURL().'/'.$this->Loader->Prefix.'/';
    }


    public function MaybeCreateFolder($directory,$secure=false)
    {
        if(!is_dir($directory))
            if(!mkdir($directory,0777,true))
                throw new Exception('Could not create folder '.$this->_rootPath);
            else{
                if($secure)
                {
                    @file_put_contents( $directory . '.htaccess', 'deny from all' );
                    @touch( $directory . 'index.php' );
                }
            }


    }

    public function GetUniqueTempFileName($suffix)
    {
        $tempPath=$this->GetTempFolderPath();
        $name='';
        $count=0;
        do{
            $count++;
            $name=sanitize_file_name(uniqid().$count).$suffix;
        }while(file_exists($tempPath.$name));

        return $name;
    }

    public function GetEmailResourcesFolderURL(){
        return $this->GetRootFolderURL().'email_resources/';
    }

    public function GetEmailResourcesFolderPath(){
        return $this->GetRootFolderPath().'email_resources/';
    }
    public function GetTemporalEmailResourcePath()
    {
        $tempFolder=$this->GetRootFolderPath();
        $tempFolder=$tempFolder.'temp_email_resources/';

        $this->MaybeCreateFolder($tempFolder);
        $tempFolder.get_current_user_id().'/';
        $this->MaybeCreateFolder($tempFolder);

        $path=$tempFolder.get_current_user_id().'/';
        $this->MaybeCreateFolder($path);

        $this->EmptyFolder($path);

        return $path;
    }

    public function GetTemporalEmailResourceURL()
    {
        return $this->GetRootFolderURL().'temp_email_resources/'.get_current_user_id().'/';
    }

    public function MaybeCreateEmailResourcesFolder($id,$emptyFolder=true)
    {
        $folder=$this->GetRootFolderPath();
        $folder.='email_resources/';
        $this->MaybeCreateFolder($folder,false);

        $folder.=$id.'/';
        $this->MaybeCreateFolder($folder,false);
        if($emptyFolder)
        {
            $this->EmptyFolder($folder);
        }

        return $folder;
    }

    public function EmptyFolder($folder)
    {
        $files = glob($folder.'*'); // get all file names
        foreach($files as $file)
        { // iterate files
            if(is_file($file))
                unlink($file);
            if(is_dir($file))
                $this->EmptyFolder($file);
        }
    }

}