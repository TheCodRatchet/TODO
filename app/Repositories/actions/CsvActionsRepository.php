<?php

namespace App\Repositories\actions;

use App\Models\Action;
use App\Models\Collections\ActionsCollection;
use League\Csv\Reader;
use League\Csv\Statement;
use League\Csv\Writer;

class CsvActionsRepository implements ActionsRepository
{
    private Reader $reader;

    public function __construct()
    {
        $this->reader = Reader::createFromPath('files/TODOlist.csv');
        $this->reader->setDelimiter(";");
    }

    public function getAll(): ActionsCollection
    {
        $collection = new ActionsCollection();

        foreach ($this->reader->getRecords() as $record) {
            $collection->add(new Action(
                $record[0],
                $record[1],
                $record[2],
            ));
        }

        return $collection;
    }

    public function getOne(string $id): ?Action
    {
        $statement = Statement::create()->where(function ($record) use ($id) {
            return $record[0] === $id;
        })->limit(1);

        $record = $statement->process($this->reader)->fetchOne();

        if (empty($record)) return null;

        return new Action(
            $record[0],
            $record[1],
            $record[2]
        );
    }

    public function save(Action $action): void
    {
        $writer = Writer::createFromPath('files/TODOlist.csv', "a+");
        $writer->setDelimiter(";");
        $writer->insertOne($action->toArray());
    }

    public function delete(Action $action): void
    {
        $actions = $this->getAll()->getActions();

        unset($actions[$action->getId()]);

        $records = [];

        foreach ($actions as $action) {
            $records[] = $action->toArray();
        }

        $writer = Writer::createFromPath('files/TODOlist.csv', "w");
        $writer->setDelimiter(";");
        $writer->insertAll($records);
    }
}