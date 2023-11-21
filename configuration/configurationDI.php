<?php

use function DI\create;
use function DI\get;
use Opis\Database\Database;
use Opis\Database\Connection;
use  \App\Models\ArticlesModel;

return [
    'Connection'=> create(Connection:: class)->constructor(
        'mysql:host=localhost;dbname=Normal_diagramm',
        'admin',
        'admin'
    ) ,
   'Database' => create(Database::class) -> constructor(
            get('Connection')
    ),

    'ArticlesModel' => create(ArticlesModel::class) -> constructor(
        get('Database'),
        'articles'
    ),

    Twig\Loader\FilesystemLoader::class => create(Twig\Loader\FilesystemLoader::class)->constructor(
        'templates'
    ),
    Twig\Environment::class => create(Twig\Environment::class) -> constructor(
        get(Twig\Loader\FilesystemLoader::class),
        []
    ),

    'View' => create(\App\View::class)->constructor(
        get(Twig\Environment::class)
    ),

    \App\Helper::class => create(\App\Helper::class)->constructor(),

    \App\Controllers\ArticlesController::class => create(\App\Controllers\ArticlesController::class)->constructor(
        get(\App\Helper::class),
        get('View'),
        get('ArticlesModel')
    ),

    \App\Controllers\AdminController::class => create(\App\Controllers\AdminController::class)->constructor(
        get('View'),
        get(\App\Helper::class),
        get('ArticlesModel')
    )
    ];


