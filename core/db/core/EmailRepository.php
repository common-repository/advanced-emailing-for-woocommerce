<?php

namespace rnadvanceemailingwc\core\db\core;

use rnadvanceemailingwc\core\Exception\FriendlyException;
use rnadvanceemailingwc\DTO\EmailBuilderOptionsDTO;
use rnadvanceemailingwc\Managers\FileManager;
use rnadvanceemailingwc\TwigManager\Renderers\EmailRenderer;

class EmailRepository extends RepositoryBase
{
    /**
     * @param $email EmailBuilderOptionsDTO
     * @return void
     */
    public function SaveEmail($email,$getUniqueName=false)
    {
        $registeredEmails=$this->DBManager->GetVar('select count(*) from '.$this->Loader->EMAIL_TABLE);
        if($email->Name=='')
            throw new FriendlyException('Name is mandatory');

        if($email->HeaderOptions->Subject=='')
            throw new FriendlyException('Email subject can not be empty');


        $emailRenderer=new EmailRenderer($this->Loader,$email,null);
        $files = $emailRenderer->GetFilesToSave();
        if($email->Id==0)
        {
            if(!$this->Loader->IsPR()&&$registeredEmails>=1)
            {
                throw new FriendlyException('Sorry you can have only one email template in the free version');
            }
            if($this->DBManager->GetVar('select count(*) from '.$this->Loader->EMAIL_TABLE.' where name=%s',$email->Name)>0)
            {
                if($getUniqueName)
                {
                    $baseName=$email->Name;
                    $count=0;
                    do{
                        $count++;
                        $email->Name=$baseName.' '.$count;
                    }while($this->DBManager->GetVar('select count(*) from '.$this->Loader->EMAIL_TABLE.' where name=%s',$email->Name)>0);


                }else
                    throw new FriendlyException('This template name is already in use');
            }
            $email->Id=$this->DBManager->Insert($this->Loader->EMAIL_TABLE,[
               'name'=>$email->Name,
               'custom_fields'=>json_encode($email->CustomFields),
               'email_header_options'=>json_encode($email->HeaderOptions),
               'content_options'=>json_encode($email->ContentOptions)
            ]);

            $this->SaveTriggers($email->Id,$email->Triggers);
            $this->SaveFiles($email->Id,$files);


        }else{
            if(!$this->Loader->IsPR()&&$registeredEmails>1)
            {
                throw new FriendlyException('Sorry you can have only one email template in the free version');
            }

            if($this->DBManager->GetVar('select count(*) from '.$this->Loader->EMAIL_TABLE.' where name=%s and id<>&d',$email->Name,$email->Id)>0)
            {
                throw new FriendlyException('This template name is already in use');
            }

            $this->DBManager->Update($this->Loader->EMAIL_TABLE,[
                'name'=>$email->Name,
                'custom_fields'=>json_encode($email->CustomFields),
                'email_header_options'=>json_encode($email->HeaderOptions),
                'content_options'=>json_encode($email->ContentOptions)
            ],[
                'id'=>$email->Id
            ]);

            $this->SaveTriggers($email->Id,$email->Triggers);
            $this->SaveFiles($email->Id,$files);
        }
    }

    public function GetEmailOptions($emailid)
    {
        $options=$this->DBManager->GetResult('select id Id,name Name, email_header_options HeaderOptions,content_options ContentOptions,custom_fields CustomFields from '.$this->Loader->EMAIL_TABLE.' where id=%d',$emailid);
        if($options==null)
            return null;
        $options->HeaderOptions=json_decode($options->HeaderOptions);
        $options->CustomFields=json_decode($options->CustomFields);
        $options->ContentOptions=json_decode($options->ContentOptions);

        $triggers=[];
        $triggerOptions=$this->DBManager->GetResults('select options from '.$this->Loader->EMAIL_TRIGGER_TABLE.' where email_id=%d',$options->Id);
        foreach($triggerOptions as $currentOptions)
        {
            $triggers[]=json_decode($currentOptions->options);
        }
        $options->Triggers=$triggers;

        $emailOptions=(new EmailBuilderOptionsDTO())->Merge($options);
        return $emailOptions;
    }

    public function GetEmailList($filterCriteria='')
    {
        $where='';
        if($filterCriteria!='')
        {
            global $wpdb;
            $where.=' where id='.$wpdb->prepare('%s',$filterCriteria).' or name like \'%'.$wpdb->esc_like($filterCriteria).'%\'';
        }
        $result=$this->DBManager->GetResults('select id Id,name Name, email_header_options HeaderOptions from '.$this->Loader->EMAIL_TABLE.$where);
        foreach($result as $currentRow)
        {
            $currentRow->HeaderOptions=json_decode($currentRow->HeaderOptions);
        }
        return $result;
    }

    public function GetEmailListCount($filterCriteria='')
    {
        $where='';
        if($filterCriteria!='')
        {
            global $wpdb;
            $where.=' where id='.$wpdb->prepare('%s',$filterCriteria).' or name like \'%'.$wpdb->esc_like($filterCriteria).'%\'';
        }
        return $this->DBManager->GetVar('select count(*) from '.$this->Loader->EMAIL_TABLE.$where);
    }

    public function DeleteEmail($emailId)
    {
        $this->DBManager->Delete($this->Loader->EMAIL_TABLE,['id'=>$emailId]);
    }

    public function GetPotentialEmails(int $postId,$skipEmails=[])
    {
        $where='';
        $ids=[];
        global $wpdb;
        foreach($skipEmails as $currentEmailId)
        {
            if(is_numeric($currentEmailId))
                $ids[]=$wpdb->prepare('%d',$currentEmailId);
        }
        if(count($ids)>0)
            $where=' and id not in('. implode(',',$ids).') ';

        return $this->DBManager->GetResults('select id Id, email_header_options HeaderOptions,triggers Triggers,condition_options ConditionOptions from '.$this->Loader->EMAIL_TABLE.' where condition_options is not null '. $where);
    }

    public function GetEmailTriggers()
    {
        return $this->DBManager->GetResults('select id Id, triggers Triggers from '.$this->Loader->EMAIL_TABLE);
    }

    private function SaveTriggers($emailId, $triggers)
    {
        $this->DBManager->Delete($this->Loader->EMAIL_TRIGGER_TABLE,array('email_id'=>$emailId));
        if(is_array($triggers))
        {
            foreach($triggers as $currentTrigger)
            {
                if($currentTrigger->Type=='')
                    continue;

                $type=$currentTrigger->Type;
                $this->DBManager->Insert($this->Loader->EMAIL_TRIGGER_TABLE,array(
                    'email_id'=>$emailId,
                    'type'=>$type,
                    'options'=>json_encode($currentTrigger)
                ));
            }
        }
    }

    public function EmailExist($emailId)
    {
        return $this->DBManager->GetVar('select 1 from '.$this->Loader->EMAIL_TABLE.' where id=%d',$emailId)!=null;
    }

    public function GetTriggersByType($type)
    {
        $triggers= $this->DBManager->GetResults('select options Options, email_id EmailId from '.$this->Loader->EMAIL_TRIGGER_TABLE.' where type=%s',$type);
        foreach($triggers as $currentTrigger)
            $currentTrigger->Options=json_decode($currentTrigger->Options);
        return $triggers;
    }

    public function GetEmailsIdAndName()
    {
        return $this->DBManager->GetResults('select id Id, name Name from '.$this->Loader->EMAIL_TABLE);
    }

    private function SaveFiles($id, $files)
    {
        $fileManager=new FileManager($this->Loader);
        $path=$fileManager->MaybeCreateEmailResourcesFolder($id);

        foreach($files as $currentFile)
        {
            file_put_contents($path.$currentFile['file'],file_get_contents($_FILES[$currentFile['id']]['tmp_name']));
        }

    }


}