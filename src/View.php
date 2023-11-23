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
        dd($_SESSION['username']);
        echo $this->twig->render('articlesView.twig', ['articles'=>$articles, 'username' => $_SESSION['username']]);
    }

    public function showOneArticle($article){
        echo $this->twig->render('oneArticleView.twig', ['article'=>$article]);
    }

    public function adminLoginPage(){
        echo $this->twig->render('login.twig', []);
    }

    public function adminShowAllArticles($articles){
        echo $this->twig->render('adminArticles.twig', ['articles'=>$articles]);
    }

    public function editPage($article){
        echo $this->twig->render('editArticle.twig', ['article' => $article]);
    }

    public function registrPageView(){
        echo $this->twig->render('register.twig', []);
    }

    public function errorView(){
        echo $this->twig->render('pageError404.html', []);
    }
}