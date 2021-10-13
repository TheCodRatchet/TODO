<?php

namespace App\Controllers;

use App\Authorisation;
use App\Models\User;
use App\Redirect;
use App\Repositories\users\MysqlUsersRepository;
use App\Repositories\users\UsersRepository;
use Ramsey\Uuid\Uuid;

class AuthController
{
    private UsersRepository $usersRepository;

    public function __construct()
    {
        $this->usersRepository = new MysqlUsersRepository();
    }


    public function showRegisterForm()
    {
        require_once 'app/Views/users/register.template.php';
    }

    public function register()
    {
        $this->usersRepository->save(
            new User(
                Uuid::uuid4(),
                $_POST['name'],
                $_POST['email'],
                password_hash($_POST['password_confirmation'], PASSWORD_DEFAULT)
            )
        );

        Redirect::url('/');;
    }

    public function showLoginForm()
    {
        if (Authorisation::loggedIn()) Redirect::url('/');

        require_once 'app/Views/users/login.template.php';
    }

    public function login()
    {
        if (Authorisation::loggedIn()) Redirect::url('/');

        $user = $this->usersRepository->getByEmail($_POST['email']);

        if ($user !== null && password_verify($_POST['password'], $user->getPassword())) {
            $_SESSION['id'] = $user->getId();
            header('Location: /actions');
            exit;
        }

        Redirect::url('/login');;
    }

    public function logout()
    {
        unset ($_SESSION['id']);
        Redirect::url('/');;
    }
}