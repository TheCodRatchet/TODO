<?php

namespace App\Models\Collections;

use App\Models\Action;

class ActionsCollection
{
    private array $actions;

    public function __construct(array $actions = [])
    {
        foreach ($actions as $action) {
            $this->add($action);
        }
    }

    public function add(Action $action): void
    {
        $this->actions[$action->getId()] = $action;
    }

    public function getActions(): array
    {
        return $this->actions;
    }
}