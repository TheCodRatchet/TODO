<?php

namespace App\Repositories\actions;

use App\Models\Action;
use App\Models\Collections\ActionsCollection;

class CombinedActionsRepository implements ActionsRepository
{
    private CsvActionsRepository $csvActionsRepository;
    private MysqlActionsRepository $mysqlActionsRepository;

    public function __construct()
    {
        $this->csvActionsRepository = new CsvActionsRepository();
        $this->mysqlActionsRepository = new MysqlActionsRepository();
    }

    public function getAll(): ActionsCollection
    {
        return $this->mysqlActionsRepository->getAll();
    }

    public function getOne(string $id): ?Action
    {
        return $this->mysqlActionsRepository->getOne($id);
    }


    public function save(Action $action): void
    {
        $this->csvActionsRepository->save($action);
        $this->mysqlActionsRepository->save($action);
    }

    public function delete(Action $action): void
    {
        $this->csvActionsRepository->delete($action);
        $this->mysqlActionsRepository->delete($action);
    }
}