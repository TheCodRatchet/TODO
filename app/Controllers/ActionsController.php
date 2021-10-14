<?php

namespace App\Controllers;

use App\Models\Action;
use App\Redirect;
use App\Repositories\actions\ActionsRepository;
use App\Repositories\actions\CombinedActionsRepository;
use App\Repositories\actions\CsvActionsRepository;
use App\Repositories\actions\MysqlActionsRepository;
use App\View;
use Ramsey\Uuid\Uuid;

class ActionsController
{
    private ActionsRepository $actionsRepository;

    public function __construct()
    {
        $this->actionsRepository = new CombinedActionsRepository();
    }

    public function index(): View
    {
        $actions = $this->actionsRepository->getAll($_GET);

        return new View('actions/index.twig', [
            'actions' => $actions
        ]);
    }

    public function create(): View
    {
        return new View('actions/create.twig', []);
    }

    public function store()
    {
        $action = new Action(Uuid::uuid4(), $_POST['title']);

        $this->actionsRepository->save($action);

        Redirect::url('/');
    }

    public function delete(array $vars)
    {
        $id = $vars['id'] ?? null;
        if ($id == null) Redirect::url('/');

        $action = $this->actionsRepository->getOne($id);

        if ($action !== null) {
            $this->actionsRepository->delete($action);
        }

        Redirect::url('/');
    }

    public function show(array $vars): View
    {
        $id = $vars['id'] ?? null;
        if ($id == null) Redirect::url('/');;

        $action = $this->actionsRepository->getOne($id);

        if ($action === null) Redirect::url('/');;

        return new View('actions/show.twig', [
            'action' => $action
        ]);
    }
}