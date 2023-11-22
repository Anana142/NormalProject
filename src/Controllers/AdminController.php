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
    private \App\Models\ArticlesModel $model;
    public  function  __construct($view, $h, $model)
    {

        $this->view = $view;
        $this->h = $h;
        $this->model = $model;



    }

    public function loginPage(){
        if($this->login()){
            $this->h->goUrl('login');
        }
        $this->view->adminLoginPage();
    }
    public function adminPage(){
        $this->view->adminShowAllArticles($this->model->getAll());
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
        }
        return false;
    }

    public function logout()
    {
        $this->signOut();
        $this->h->goUrl("/admin");
    }

    public function registrationPage(){
        if(!$this->register()){

        }
        $this->view->registrPageView();
    }
    public function register() : bool
    {
        if(isset($_POST['btn_registr'])){

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
        $this->h->goUrl('//normalproject.test/login');
    }
    public function editArticle (){

        $ar = [
            'id' => $_REQUEST['id'],
            'title' => $_REQUEST['title'],
            'image' => '',
            'content' => $_REQUEST['content']
        ];

        $dbArticle = $this->model->getById($ar['id']);
        if(isset($dbArticle) && $dbArticle['image'] != '')
            $ar['image'] = $dbArticle['image'];

        $this->model->updateArticle($ar);

    }
    public function addNewArticle(){

        $newArticle['title'] = $_REQUEST['title'];
        $newArticle['image'] = '';
        $newArticle['content'] = $_REQUEST['content'];

        $this->model->addArticle($newArticle);
    }

    public function delete($id){
        if($id != 0){
            $this->model->delete($id);
        }
        $this->h->goUrl('//normalproject.test/login');
    }
    public function edit($id){
        $article = $this->model->getById($id);
        $this->view->editPage($article);
    }
    public function addView(){
        $article = ['Id'=>0];
        $this->view->editPage($article);
    }

}