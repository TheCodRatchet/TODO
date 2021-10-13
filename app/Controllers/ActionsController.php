<?php

namespace App\Controllers;

use App\Models\Action;
use App\Redirect;
use App\Repositories\actions\ActionsRepository;
use App\Repositories\actions\CombinedActionsRepository;
use App\Repositories\actions\CsvActionsRepository;
use App\Repositories\actions\MysqlActionsRepository;
use Ramsey\Uuid\Uuid;

class ActionsController
{
    private ActionsRepository $actionsRepository;

    public function __construct()
    {
        $this->actionsRepository = new CombinedActionsRepository();
    }

    public function index()
    {
        $actions = $this->actionsRepository->getAll($_GET);

        require_once 'app/Views/actions/index.template.php';
    }

    public function create()
    {
        require_once 'app/Views/actions/create.template.php';
    }

    public function store()
    {
        $action = new Action(Uuid::uuid4(), $_POST['title']);

        $this->actionsRepository->save($action);

        Redirect::url('/actions');
    }

    public function delete(array $vars)
    {
        $id = $vars['id'] ?? null;
        if ($id == null) Redirect::url('/');;

        $action = $this->actionsRepository->getOne($id);

        if ($action !== null) {
            $this->actionsRepository->delete($action);
        }

        Redirect::url('/');
    }

    public function show(array $vars)
    {
        $id = $vars['id'] ?? null;
        if ($id == null) Redirect::url('/');;

        $action = $this->actionsRepository->getOne($id);

        if ($action === null) Redirect::url('/');;

        require_once 'app/Views/actions/show.template.php';
    }
}