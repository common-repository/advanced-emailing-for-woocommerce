<?php

namespace rnadvanceemailingwc\core;


class LibraryManager
{
    /** @var Loader */
    public $Loader;

    public $dependencies = [];

    public function __construct($loader)
    {
        $this->Loader = $loader;
    }

    public static function GetInstance(){
        return new LibraryManager(apply_filters('allinoneforms_get_loader',null));
    }

    public function GetDependencyHooks(){
        $hooks=[];
        foreach($this->dependencies as $currentDependency)
        {
            $hooks[]=\str_replace('@',$this->Loader->Prefix.'_',$currentDependency);
        }
        return $hooks;
    }


    public function AddDropdownButton(){
        self::AddLit();
        self::AddCore();
        $this->Loader->AddScript('dropdownbutton','js/dist/RNEmailDropDownButton_bundle.js',array('@Core'));
        $this->Loader->AddStyle('dropdownbutton','js/dist/RNEmailDropDownButton_bundle.css');

        $this->AddDependency('@dropdownbutton');

    }

    public function AddConditionDesigner()
    {

        self::AddLit();
        self::AddFormBuilderCore();
        $this->Loader->AddScript('conditiondesigner','js/dist/RNEmailConditionDesigner_bundle.js',array('@lit','@FormBuilderCore'));
        $this->Loader->AddStyle('conditiondesigner','js/dist/RNEmailConditionDesigner_bundle.css');
        $this->AddDependency('@conditiondesigner');

        $userIntegration=new UserIntegration($this->Loader);
        $this->Loader->LocalizeScript('rnConditionDesignerVar','conditiondesigner','alloinoneforms_list_users',[
            "Roles"=>$userIntegration->GetRoles()
        ]);
    }

    private function AddDependency($dependency)
    {
        if (!in_array($dependency, $this->dependencies))
            $this->dependencies[] = $dependency;
    }

    public function AddConditionalFieldSet(){
        self::AddSwitchContainer();
        $this->Loader->AddScript('conditionalfieldset','js/dist/RNEmailConditionalFieldSet_bundle.js',array('@switchcontainer'));
        $this->AddDependency('@conditionalfieldset');
    }

    public function AddSingleLineGenerator()
    {
        $this->Loader->AddScript('singlelinegenerator','js/dist/RNEmailSingleLineGenerator_bundle.js');
        $this->AddDependency('@singlelinegenerator');

    }

    public function AddHTMLGenerator(){
        self::AddLit();
        $this->Loader->AddScript('htmlgenerator','js/dist/RNEmailHTMLGenerator_bundle.js',array('@FormBuilderCore','@lit'));

    }

    public function AddSwitchContainer(){
        self::AddLit();
        $this->Loader->AddScript('switchcontainer','js/dist/RNEmailSwitchContainer_bundle.js',array('@lit'));
        $this->AddDependency('@switchcontainer');

    }


    public function AddInputs(){
        self::AddLit();
        self::AddCore();
        self::AddSelect();
        $this->Loader->AddScript('date','js/lib/date/flatpickr.js',array('@lit'));
        $this->Loader->AddStyle('date','js/lib/date/flatpickr.min.css');
        $this->Loader->AddScript('inputs','js/dist/RNEmailInputs_bundle.js',array('@lit','@select','@date'));
        $this->Loader->AddStyle('inputs','js/dist/RNEmailInputs_bundle.css');

        $this->AddDependency('@inputs');

    }

    public function AddAlertDialog(){
        self::AddLit();
        self::AddCore();
        self::AddDialog();
        $this->Loader->AddScript('AlertDialog','js/dist/RNEmailAlertDialog_bundle.js',array('@lit','@Dialog','@Core'));
        $this->Loader->AddStyle('AlertDialog','js/dist/RNEmailAlertDialog_bundle.css');
        $this->AddDependency('@AlertDialog');

    }



    public function AddTextEditor(){
        self::AddLit();
        self::AddDialog();
        self::AddInputs();
        self::AddAccordion();
        $this->Loader->AddScript('texteditor','js/dist/RNEmailTextEditor_bundle.js',array('@lit','@Dialog','@inputs'));
        $this->Loader->AddStyle('texteditor','js/dist/RNEmailTextEditor_bundle.css');
        $this->AddDependency('@texteditor');

    }
    public function AddCore(){
        self::AddLoader();
        self::AddLit();
        $this->Loader->AddScript('Core', 'js/dist/RNEmailCore_bundle.js', array('@loader', '@lit'));
        $this->AddDependency('@Core');
    }

    public function AddFormulas(){
        self::AddFormBuilderCore();
        $this->Loader->AddScript('Formula','js/dist/RNEmailFormulaCore_bundle.js',array('@FormBuilderCore'));
        $this->AddDependency('@Formula');
    }



    public function AddFormBuilderCore(){
        self::AddCore();
        self::AddDialog();
        $this->Loader->AddScript('FormBuilderCore', 'js/dist/RNEmailFormBuilderCore_bundle.js', array('@Core','@Dialog'));
        $this->Loader->AddStyle('FormBuilderCore', 'js/dist/RNEmailFormBuilderCore_bundle.css');
        $this->AddDependency('@FormBuilderCore');
    }

    public function AddLoader()
    {
        $this->Loader->AddScript('loader', 'js/lib/loader.js');
        $this->AddDependency('@loader');
    }

    public function AddSelect(){
        $this->Loader->AddScript('select','js/lib/tomselect/js/tom-select.complete.js');
        $this->Loader->AddStyle('select','js/lib/tomselect/css/tom-select.bootstrap5.css');
        $this->AddDependency('@select');
    }


    public function AddLit()
    {
        self::AddLoader();
        $this->Loader->AddScript('lit', 'js/dist/RNEmailLit_bundle.js', array('@loader'));
        $this->AddDependency('@lit');
    }

    public function AddCoreUI()
    {
        self::AddCore();
        $this->Loader->AddScript('CoreUI', 'js/dist/RNEmailCoreUI_bundle.js', array('@Core'));
        $this->Loader->AddStyle('CoreUI', 'js/dist/RNEmailCoreUI_bundle.css');

        $this->AddDependency('@CoreUI');
    }

    public function AddTranslator($fileList)
    {
        $this->Loader->AddRNTranslator($fileList);
        $this->AddDependency('@RNTranslator');
    }

    public function AddDialog()
    {
        self::AddLit();
        $this->Loader->AddScript('Dialog', 'js/dist/RNEmailDialog_bundle.js', array('@lit'));
        $this->Loader->AddStyle('Dialog', 'js/dist/RNEmailDialog_bundle.css');
        $this->AddDependency('@Dialog');
    }

    public function AddContext(){
        self::AddLit();
        $this->Loader->AddScript('Context','js/dist/RNEmailContext_bundle.js');
        $this->Loader->AddStyle('Context','js/dist/RNEmailContext_bundle.css');
    }

    public function AddPreMadeDialog(){
        self::AddDialog();
        self::AddSpinner();
        $this->Loader->AddScript('PreMadeDialog', 'js/dist/RNEmailPreMadeDialogs_bundle.js', array('@Dialog'));

    }

    public function AddFormulaParser(){
        $this->Loader->AddScript('formulaParser','js/dist/RNEmailParser_bundle.js');
        $this->Loader->AddStyle('formulaParser','js/dist/RNEmailParser_bundle.css');
        $this->AddDependency('@formulaParser');
    }

    public function AddContextMenu(){
        self::AddLit();
        $this->Loader->AddScript('ContextMenu','js/dist/RNEmailContextMenu_bundle.js',array('@lit'));
        $this->Loader->AddStyle('ContextMenu','js/dist/RNEmailContextMenu_bundle.css');
        $this->AddDependency('@ContextMenu');
    }

    public function AddDate(){
        self::AddLit();;
        $this->Loader->AddScript('date','js/lib/date/flatpickr.js',array('@lit'));
        $this->Loader->AddStyle('date','js/lib/date/flatpickr.min.css');
        $this->AddDependency('@date');
    }

    public function AddAccordion()
    {
        self::AddLit();
        $this->Loader->AddScript('Accordion', 'js/dist/RNEmailAccordion_bundle.js', array('@lit'));
        $this->Loader->AddStyle('Accordion', 'js/dist/RNEmailAccordion_bundle.css');
        $this->AddDependency('@Accordion');
    }


    public function AddTabs()
    {
        $this->AddLit();
        $this->Loader->AddScript('Tabs', 'js/dist/RNEmailTabs_bundle.js', array('@lit'));
        $this->Loader->AddStyle('Tabs', 'js/dist/RNEmailTabs_bundle.css');

        $this->AddDependency('@Tabs');
    }

    public function AddSpinner(){
        self::AddLit();
        self::AddCore();
        $this->Loader->AddScript('Spinner', 'js/dist/RNEmailSpinnerButton_bundle.js', array('@lit','@Core'));
        $this->Loader->AddStyle('Spinner', 'js/dist/RNEmailSpinnerButton_bundle.css');
    }

    public function AddWPTable()
    {
        self::AddCore();
        $this->Loader->AddScript('WPTable', 'js/dist/RNEmailWPTable_bundle.js', array('@Core'));
        $this->Loader->AddStyle('WPTable', 'js/dist/RNEmailWPTable_bundle.css');
        $this->AddDependency('@WPTable');
    }
}