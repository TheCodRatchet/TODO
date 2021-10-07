<?php

namespace App\Controllers;

use App\Models\Action;
use League\Csv\Writer;

class ActionCreate
{
    public function index()
    {
        require_once "app/Views/action.create.template.php";

        if (isset($_POST['submit']) && $_POST['name'] != "") {
            $action = new Action($_POST['name']);
            $actions = [$action->getName()];
            $save = Writer::createFromPath("files/TODOlist.csv", "a+");
            $save->insertOne($actions);

            header("Location: /create");
        }
    }
}