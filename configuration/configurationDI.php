<?php

use function DI\create;
use function DI\get;
use Opis\Database\Database;
use Opis\Database\Connection;

use  \App\Models\ArticlesModel;
use  \App\Models\UsersModel;

use \App\View;
use \App\Helper;

use \App\Controllers\ArticlesController;
use \App\Controllers\AdminController;
use \App\Controllers\RegistrationController;

return [
    'Connection'=> create(Connection:: class)->constructor(
        'mysql:host=localhost;dbname=Normal_diagramm',
        'admin',
        'admin'
    ) ,
   'Database' => create(Database::class) -> constructor(
            get('Connection')
    ),

    'UsersModel'=> create(UsersModel::class)->constructor(
        get('Database'),
        'users'
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

    'View' => create(View::class)->constructor(
        get(Twig\Environment::class)
    ),

    Helper::class => create(Helper::class)->constructor(),

    ArticlesController::class => create(ArticlesController::class)->constructor(
        get(\App\Helper::class),
        get('View'),
        get('ArticlesModel'),
        get('UsersModel')
    ),
    AdminController::class => create(AdminController::class)->constructor(
        get('View'),
        get(\App\Helper::class),
        get('ArticlesModel'),
        get('UsersModel')
    ),
    RegistrationController::class => create(RegistrationController::class)->constructor(
        get('View'),
        get('UsersModel')
    )

    ];


