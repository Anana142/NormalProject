<?php


namespace App\Controllers;

use App\View;
use App\Models;

class RegistrationController
{
    private \App\Models\UsersModel $userModel;
    private \App\View $view;

    public function __construct($view, $usermodel ){

        $this->view = $view;
        $this->userModel = $usermodel;
    }

    public function register() : bool
    {
        if(isset($_POST['btn_registr'])){
            $username = $_POST['username'];
            $email = $_POST['email'];
            $login = $_POST['login'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $users = $this->userModel->getAll();

            foreach ($users as $ur){
                if($ur['login'] == $login || $ur['username'] == $username)
                    return true;
            }

            $user['login'] = $login;
            $user['password'] = $password;
            $user['avatar'] = null;
            $user['email'] = $email;
            $user['emailVerified'] = null;
            $user['rememberToken']= null;
            $user['updateAt'] = null;
            $user['deletedAt'] = null;
            $user['username'] = $username;

            $this->userModel->addUser($user);
            return false;
        }
        return true;
    }
    public function registrationPage()
    {
        if (!$this->register()) {
            //TODO: Сделать СМСку, что user зарегался
        }
        $this->view->registrPageView();
    }
}