<?php


namespace rnadvanceemailingwc\core\db\core;


use rnadvanceemailingwc\core\Loader;

abstract class RepositoryBase
{
    /** @var Loader */
    public $Loader;

    /** @var DBManager */
    public $DBManager;

    public function __construct($loader=null)
    {
        $this->Loader=$loader;
        $this->DBManager=new DBManager();
    }

}