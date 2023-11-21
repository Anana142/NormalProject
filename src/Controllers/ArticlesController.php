<?php


namespace App\Controllers;

use App\View;
use App\Models\ArticlesModel;
use App\Helper;

class ArticlesController
{
    private \App\Models\ArticlesModel $model;
    private \App\View $view;
    private \App\Helper $h;

    public function __construct($h, $view, $model)
    {
        $this->model = $model;
        $this->view = $view;
        $this->h = $h;
    }

    function getAllArticles()
    {
        $allArticles = $this->model->getAll();
        $this->view->showAllArticles($allArticles);
    }
    function getOneArticle($id)
    {
        $oneArticle = $this->model->getById($id);
        $this->view->showOnearticle($oneArticle);
    }

}