<?php


namespace App\Controllers;
use App\View;
use App\Model;
use App\Helper as h;
use App\Models\ArticlesModel;

class AdminController
{
    use Auth;

    private \App\View $view;
    private \App\Helper $h;
    private \App\Models\ArticlesModel $articlesModel;
    private \App\Models\UsersModel $userModel;
    public  function  __construct($view, $h, $articlesModel, $userModel)
    {
        $this->view = $view;
        $this->h = $h;
        $this->articlesModel = $articlesModel;
        $this->userModel = $userModel;
    }

    public function loginPage(){
        if($this->login()){
            $this->view->adminShowAllArticles($this->articlesModel->getAll());
        }
        $this->view->adminLoginPage();
    }

    public function login() : bool
    {
        $login = "admin";
        $password = "12345";

        if(!$this->checkAuth()){
            if (isset($_POST['btn_admin']) && $_POST['login'] == $login && $_POST['password'] == $password){

                $this->signIn('admin', 1);

                return true;
            }
            return false;
        }
        return true;
    }

    public function logout()
    {
        $this->signOut();
        $this->h->goUrl("/admin");
    }

    public function registrationPage(){
        if(!$this->register()){
            echo 'Ура белиссимо грациес !!!';
        }
        $this->view->registrPageView();
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
    public function update(){
        if(isset($_POST['id']) && $_POST['id'] != 0){
            $this->editArticle();
        }
        else{
            $this->addNewArticle();
        }
        $this->h->goUrl('//normalproject.test/admin');
    }
    public function editArticle (){

        $ar = [
            'id' => $_REQUEST['id'],
            'title' => $_REQUEST['title'],
            'image' => '',
            'content' => $_REQUEST['content']
        ];

        $dbArticle = $this->articlesModel->getById($ar['id']);
        if(isset($dbArticle) && $dbArticle['image'] != '')
            $ar['image'] = $dbArticle['image'];

        $this->articlesModel->updateArticle($ar);

    }
    public function addNewArticle(){

        $newArticle['title'] = $_REQUEST['title'];
        $newArticle['image'] = '';
        $newArticle['content'] = $_REQUEST['content'];

        $this->articlesModel->addArticle($newArticle);
    }

    public function delete($id){
        if($id != 0){
            $this->articlesModel->delete($id);
        }
        $this->h->goUrl('//normalproject.test/admin');
    }
    public function edit($id){
        $article = $this->articlesModel->getById($id);
        $this->view->editPage($article);
    }
    public function addView(){
        $article = ['Id'=>0];
        $this->view->editPage($article);
    }

}