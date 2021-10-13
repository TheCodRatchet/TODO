<?php

namespace App\Repositories\actions;

use App\Models\Action;
use App\Models\Collections\ActionsCollection;

interface ActionsRepository
{
    public function getAll(): ActionsCollection;

    public function getOne(string $id): ?Action;

    public function save(Action $action): void;

    public function delete(Action $action): void;
}