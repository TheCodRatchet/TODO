<?php

namespace App\Controllers;

use App\Repositories\users\MysqlUsersRepository;
use App\Repositories\users\UsersRepository;

class UsersController
{
    private UsersRepository $usersRepository;

    public function __construct()
    {
        $this->usersRepository = new MysqlUsersRepository();
    }

    public function index()
    {
        $users = $this->usersRepository->getAll();

        require_once 'app/Views/users/index.template.php';
    }
}