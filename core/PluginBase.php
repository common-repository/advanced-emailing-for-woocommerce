<?php
/**
 * Created by PhpStorm.
 * User: Edgar
 * Date: 7/18/2018
 * Time: 7:36 AM
 */

namespace rnadvanceemailingwc\core;

abstract class PluginBase
{
    public $Version=1;
    public $NAME;
    public $DIR;
    public $URL;
    public $Prefix;
    public $FILE_VERSION;
    private $menuSlugs=[];
    private $dbVersion=0;
    private $menus=array();
    public $MainFilePath;


    public function __construct($mainFilePath,$prefix,$dbVersion,$fileVersion)
    {
        $this->MainFilePath=$mainFilePath;
        $this->dbVersion=$dbVersion;
        $this->FILE_VERSION=$fileVersion;
        $this->NAME=\basename(dirname(dirname(__FILE__)));
        $this->DIR=dirname(dirname(__FILE__)).'/';
        $this->URL=\plugin_dir_url($this->DIR).$this->NAME.'/';
        $this->Prefix=$prefix;
        $this->CreateHooks();
        $this->CreateInternalHooks();




    }




    public function ParseDependencyName($name)
    {
        return $this->Prefix.'_'.$name;
    }

    public function RemoveScript($handler)
    {
        \wp_dequeue_script($this->Prefix.'_'.$handler);
    }


    public function AddScript($handler,$src,$dep=array())
    {
        foreach($dep as &$dependencyName)
        {
            $dependencyName=\str_replace('@',$this->Prefix.'_',$dependencyName);
        }
        wp_enqueue_script($this->Prefix.'_'.$handler,$this->URL.$src,$dep,$this->FILE_VERSION);
        return $this->Prefix.'_'.$handler;
    }

    public function AddRNTranslator($translationFiles)
    {
        $data=array();
        if(\is_scalar($translationFiles))
            $translationFiles=array($translationFiles);
        foreach($translationFiles as $file)
        {
            $data=\array_merge($data,require($this->DIR.'jstranslations/'.$file.'.php'));
        }

        $this->AddScript('RNTranslator','core/js/RNTranslator.js');
        $this->LocalizeScript('RNTranslatorDictionary','RNTranslator',null,$data);


    }




    public function LocalizeScript($varName, $handler,$nonceName,$data)
    {
        if($nonceName!=null)
        {
            $data['_nonce']=\wp_create_nonce($this->Prefix.'_'.$nonceName);
        }

        $data['_prefix']=$this->Prefix;
        wp_localize_script($this->Prefix.'_'.$handler,$varName,$data);
    }

    public function AddStyle($handler,$src,$dep=array())
    {
        wp_enqueue_style($this->Prefix.'_'.$handler,$this->URL.$src,$dep,$this->FILE_VERSION);
    }

    public abstract function CreateHooks();
    public function GetMenus(){
        return null;
    }


    private function CreateInternalHooks()
    {
        add_action('admin_enqueue_scripts',array($this,'_CheckForScriptStyleRemoval'));
        add_action('admin_menu',array($this,'_CreateMenu'));
        add_action('admin_init',array($this,'MaybeCreateTables'));
        register_activation_hook($this->DIR.$this->Prefix.'.php',array($this,'activated'));
    }

    public function activated(){
        $this->MaybeCreateTables();
        $this->OnPluginIsActivated();
    }

    public function MaybeCreateTables(){

        $optionName='rednao_'.$this->Prefix.'_db_version';
        $dbversion=get_site_option($optionName,0);
        if($dbversion<$this->dbVersion)
        {
            $this->OnCreateTable();
            update_site_option($optionName,$this->dbVersion);
        }
    }

    public function OnPluginIsActivated(){


    }

    public function OnCreateTable(){

    }

    public function _CreateMenu(){
        if(count($this->menus)==0)
            return;


        $MainMenu=$this->menus[0];
        \add_menu_page($MainMenu['Title'],$MainMenu['Title'],$MainMenu['Capability'],$MainMenu['Slug'],function()use($MainMenu){
            $this->LoadMenu($MainMenu['Path']);
        },$MainMenu['Icon']);

        for($i=1;$i<count($this->menus);$i++)
        {

            $path=$this->menus[$i]['Path'];
            \add_submenu_page($MainMenu['Slug'],$this->menus[$i]['Title'],$this->menus[$i]['Title'],$this->menus[$i]['Capability'],$this->menus[$i]['Slug'], function()use($path){
                $this->LoadMenu($path);
            });
        }

    }

    public function _CheckForScriptStyleRemoval($hook){

        if(isset($this->menuSlugs[$hook]))
        {
            add_action('admin_print_styles',array($this,'_RemoveExternalStyles'));
            add_action('admin_print_scripts',array($this,'_RemoveExternalScriptsAndNotices'));
        }
    }

    private function LoadMenu($path){
        global $rninstance;
        $rninstance=$this;

        /** @var PageBase $class */
        $class= new $path($this);
        $class->Render();
    }

    public function _RemoveExternalScriptsAndNotices(){
        global $wp_scripts;
        $queuedScripts=$wp_scripts->queue;
        $allowedScripts=array('jquery','common','jquery-ui-core','admin-bar','utils','svg-painter','wp-auth-check');
        foreach($queuedScripts as $queue)
        {
            if(isset($wp_scripts->registered[$queue]))
            {
                if($wp_scripts->registered[$queue]->src)
                {
                    if(strpos($wp_scripts->registered[$queue]->src,'wp-includes/')!==false||strpos($wp_scripts->registered[$queue]->src,'wp-admin/')!==false||$wp_scripts->registered[$queue]->src===true)
                        continue;
                    if(in_array($queue,$allowedScripts))
                        continue;

                    if(strpos($queue,'smart-forms')!==false)
                        continue;

                    wp_dequeue_script($queue);

                }
            }

        }

       // $this->RemoveNotices();
    }

    public function _RemoveExternalStyles(){
        global $wp_styles;
        $styles=$wp_styles->queue;
        $queuedStyles=$wp_styles->queue;
        $allowedStyles=array('admin-bar','colors','ie','wp-auth-check');
        foreach($queuedStyles as $queue)
        {
            if(isset($wp_styles->registered[$queue]))
            {
                if($wp_styles->registered[$queue]->src)
                {
                    if(strpos($wp_styles->registered[$queue]->src,'wp-includes/')!==false||strpos($wp_styles->registered[$queue]->src,'wp-admin/')!==false||$wp_styles->registered[$queue]->src===true)
                        continue;
                    if(in_array($queue,$allowedStyles))
                        continue;

                    if(strpos($queue,'smart-forms')!==false)
                        continue;

                    wp_dequeue_style($queue);

                }
            }

        }

    }

    public function AddMenu($title,$slug,$capability,$icon,$path)
    {
        if(count($this->menus)==0)
            $this->menuSlugs['toplevel_page_'.$slug]='1';
        else
            $this->menuSlugs[$this->menus[0]['Slug'].'/'.$slug]='1';
        $this->menus[]=array('Title'=>$title,"Slug"=>$slug,"Capability"=>$capability,"Icon"=>$icon,"Path"=>$path);
    }

    private function RemoveNotices()
    {
        global $wp_filter;
        if ( ! empty( $wp_filter['user_admin_notices']->callbacks ) && is_array( $wp_filter['user_admin_notices']->callbacks ) ) {
            foreach ( $wp_filter['user_admin_notices']->callbacks as $priority => $hooks ) {
                foreach ( $hooks as $name => $arr ) {
                    if ( is_object( $arr['function'] ) && $arr['function'] instanceof Closure ) {
                        unset( $wp_filter['user_admin_notices']->callbacks[ $priority ][ $name ] );
                        continue;
                    }
                    if ( ! empty( $arr['function'][0] ) && is_object( $arr['function'][0] ) && strpos( strtolower( get_class( $arr['function'][0] ) ), 'wpforms' ) !== false ) {
                        continue;
                    }
                    if ( ! empty( $name ) && strpos( $name, 'wpforms' ) === false ) {
                        unset( $wp_filter['user_admin_notices']->callbacks[ $priority ][ $name ] );
                    }
                }
            }
        }

        if ( ! empty( $wp_filter['admin_notices']->callbacks ) && is_array( $wp_filter['admin_notices']->callbacks ) ) {
            foreach ( $wp_filter['admin_notices']->callbacks as $priority => $hooks ) {
                foreach ( $hooks as $name => $arr ) {
                    if ( is_object( $arr['function'] ) && $arr['function'] instanceof Closure ) {
                        unset( $wp_filter['admin_notices']->callbacks[ $priority ][ $name ] );
                        continue;
                    }
                    if ( ! empty( $arr['function'][0] ) &&
                        is_object( $arr['function'][0] ) &&
                        strpos( strtolower( get_class( $arr['function'][0] ) ), 'wpforms' ) !== false ) {
                        continue;
                    }
                    if ( ! empty( $name ) && strpos( $name, 'wpforms' ) === false ) {
                        unset( $wp_filter['admin_notices']->callbacks[ $priority ][ $name ] );
                    }
                }
            }
        }

        if ( ! empty( $wp_filter['all_admin_notices']->callbacks ) && is_array( $wp_filter['all_admin_notices']->callbacks ) ) {
            foreach ( $wp_filter['all_admin_notices']->callbacks as $priority => $hooks ) {
                foreach ( $hooks as $name => $arr ) {
                    if ( is_object( $arr['function'] ) && $arr['function'] instanceof Closure ) {
                        unset( $wp_filter['all_admin_notices']->callbacks[ $priority ][ $name ] );
                        continue;
                    }
                    if ( ! empty( $arr['function'][0] ) && is_object( $arr['function'][0] ) && strpos( strtolower( get_class( $arr['function'][0] ) ), 'wpforms' ) !== false ) {
                        continue;
                    }
                    if ( ! empty( $name ) && strpos( $name, 'wpforms' ) === false ) {
                        unset( $wp_filter['all_admin_notices']->callbacks[ $priority ][ $name ] );
                    }
                }
            }
        }
    }


    public function CreateNonceForAjax($ajaxNonce)
    {
        return \wp_create_nonce($this->Prefix.'_'.$ajaxNonce);
    }


}