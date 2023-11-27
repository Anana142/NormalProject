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

        if(!$this->checkAuth()){
            $this->login();
            exit;
        }
    }

    public function articlesPage(){
        $this->view->adminShowAllArticles($this->articlesModel->getAll());
    }

    public function login()
    {
        $login = "admin";
        $password = "12345";

        //$users = $this->userModel->getAll();
        /*if (isset($_POST['btn_admin']) && $this->Authorisation($_POST['login'], $_POST['password'])){
                foreach ($users as $us)
                    if($us['login'] == $_POST['login']){
                        $this->signIn($us['username'], $us['Id']);
                    }*/

        if (isset($_POST['btn_admin'])) {
            if ($_POST['login'] == $login && $_POST['password'] == $password) {
                $this->signIn("admin", 0);
                $this->h->goUrl('//normalproject.test/admin');
            }
            else
                echo('Неверно!');

        }
        $this->view->adminLoginPage();
    }

    public function logout()
    {
        $this->signOut();
        $this->h->goUrl("/admin");
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