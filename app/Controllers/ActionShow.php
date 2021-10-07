<?php

namespace App\Controllers;

use League\Csv\Reader;
use League\Csv\Statement;

class ActionShow
{
    public function index()
    {
        $read = Reader::createFromPath("files/TODOlist.csv", "r");
        $list = Statement::create()->process($read);
        require_once "app/Views/action.show.template.php";
    }
}