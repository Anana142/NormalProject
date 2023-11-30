<?php


namespace App;

use Twig;

class View
{

    private Twig\Environment $twig;

    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    public function showAllArticles($articles)
    {
        $message = 'dgdsvsdvv';
        echo $this->twig->render('articlesView.twig', ['articles'=>$articles,'abc'=>'abc', 'username'=>$_SESSION['username'], 'mes'=>$_SESSION['message']]);
    }

    public function showOneArticle($article){
        echo $this->twig->render('oneArticleView.twig', ['article'=>$article, 'username'=>$_SESSION['username'], 'message'=>$_SESSION['message']]);
    }

    public function loginPage(){
        echo $this->twig->render('loginUser.twig', []);
    }
    public function adminLoginPage(){
        echo $this->twig->render('login.twig', []);
    }

    public function adminShowAllArticles($articles){
        echo $this->twig->render('adminArticles.twig', ['articles'=>$articles, 'username' => $_SESSION['username'], 'message'=>$_SESSION['message']]);
    }

    public function editPage($article){
        echo $this->twig->render('editArticle.twig', ['article' => $article, 'username' => $_SESSION['username'], 'message'=>$_SESSION['message']]);
    }

    public function registrPageView(){
        echo $this->twig->render('register.twig', []);
    }

    public function errorView(){
        echo $this->twig->render('pageError404.html', []);
    }
}