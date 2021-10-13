<?php

namespace App\Repositories\actions;

use App\Models\Action;
use App\Models\Collections\ActionsCollection;
use PDO;
use PDOException;

class MysqlActionsRepository implements ActionsRepository
{
    private PDO $connection;

    public function __construct()
    {
        $host = '127.0.0.1';
        $db = 'todo_app';
        $user = 'root';
        $pass = 'Ratchet140298';

        $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";

        try {
            $this->connection = new PDO($dsn, $user, $pass);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function getAll(): ActionsCollection
    {
        $statement = $this->connection->query("SELECT * FROM actions");
        $actions = $statement->fetchAll(PDO::FETCH_ASSOC);
        $collection = new ActionsCollection();

        foreach ($actions as $action) {
            $collection->add(new Action(
                $action['id'],
                $action['title'],
                $action['status']
            ));
        }
        return $collection;
    }

    public function getOne(string $id): ?Action
    {
        $sql = "SELECT * FROM actions WHERE id = ?";
        $statement = $this->connection->prepare($sql);
        $statement->execute([$id]);
        $action = $statement->fetch();

        return new Action(
            $action['id'],
            $action['title'],
            $action['status']
        );
    }

    public function save(Action $action): void
    {
        $sql = "INSERT INTO actions (id, title, status) VALUES (?, ?, ?)";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            $action->getId(),
            $action->getName(),
            $action->getStatus()
        ]);
    }

    public function delete(Action $action): void
    {
        $sql = "DELETE FROM actions WHERE id = ?";
        $statement = $this->connection->prepare($sql);
        $statement->execute([$action->getId()]);
    }
}