<?php

namespace App\Repositories\users;

use App\Models\Collections\ActionsCollection;
use App\Models\Collections\UsersCollection;
use App\Models\User;
use PDO;
use PDOException;

class MysqlUsersRepository implements UsersRepository
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

    public function getAll(): UsersCollection
    {
        $statement = $this->connection->query("SELECT * FROM users");
        $users = $statement->fetchAll(PDO::FETCH_ASSOC);
        $collection = new ActionsCollection();

        $collection = new UsersCollection();

        foreach ($users as $user) {
            $collection->add(new User(
                $user['id'],
                $user['name'],
                $user['email'],
                $user['password']
            ));
        }

        return $collection;
    }

    public function save(User $user): void
    {
        $sql = "INSERT INTO users (id, name, email, password) VALUES (?, ?, ?, ?)";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            $user->getId(),
            $user->getName(),
            $user->getEmail(),
            $user->getPassword(),
        ]);
    }

    public function getByEmail(string $email): ?User
    {
        $sql = "SELECT * FROM users WHERE email = ?";
        $statement = $this->connection->prepare($sql);
        $statement->execute([$email]);

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if (empty($user)) return  null;

        return new User(
            $user['id'],
            $user['name'],
            $user['email'],
            $user['password']
        );
    }
}