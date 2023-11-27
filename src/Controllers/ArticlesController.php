<?php


namespace App\Controllers;

use App\View;
use App\Models\ArticlesModel;
use App\Helper;

class ArticlesController
{
    use Auth;

    private \App\Models\ArticlesModel $model;
    private \App\Models\UsersModel $userModel;
    private \App\View $view;
    private \App\Helper $h;

    public function __construct($h, $view, $model, $userModel)
    {
        $this->model = $model;
        $this->view = $view;
        $this->h = $h;
        $this->userModel = $userModel;

        $this->LogUser();

        if(!$this->checkAuth()){
            $this->login();
            exit;
        }
    }

    public function login()
    {
        $users = $this->userModel->getAll();
        if (isset($_POST['btn_admin']) && $this->Authorisation($_POST['login'], $_POST['password'])) {
            foreach ($users as $us)
                if ($us['login'] == $_POST['login']) {
                    $this->signIn($us['username'], $us['Id']);
                    $this->h->goUrl('//normalproject.test/');
                }
        }
        $this->view->loginPage();
    }
    public function Authorisation($login, $password) : bool
    {
        $users = $this->userModel->getAll();

        foreach ($users as $user){
            if ($user['login'] == $login  && password_verify($password, $user['password'])){
                return true;
            }
        }
        return false;
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
    public function registrationPage(){
        if(!$this->register()){
            //TODO: Сделать СМСку, что user зарегался
        }
        $this->view->registrPageView();
    }

    public function getAllArticles()
    {
        $allArticles = $this->model->getAll();
        $this->view->showAllArticles($allArticles);
    }
    public function getOneArticle($id)
    {
        $oneArticle = $this->model->getById($id);
        $this->view->showOnearticle($oneArticle);
    }

}