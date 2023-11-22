<?php
require_once 'vendor/autoload.php';

use NoahBuscher\Macaw\Macaw;
use Filp\Whoops\Handler;
use function DI\factory;
use App;



$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

$containerBuilder = new \DI\ContainerBuilder();
$containerBuilder->useAutowiring(false);
$containerBuilder->useAttributes(false);
$containerBuilder->addDefinitions('configuration/configurationDI.php');
$container = $containerBuilder->build();

$view = $container->get('View');

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', ['App\Controllers\ArticlesController', 'getAllArticles']);
    $r->addRoute('GET', '/article/{id:\d+}', ['App\Controllers\ArticlesController', 'getOneArticle']);

    $r->addRoute('GET', '/admin', ['App\Controllers\AdminController', 'loginPage']);
    $r->addRoute('POST', '/admin', ['App\Controllers\AdminController', 'loginPage']);

    $r->addRoute('GET', '/registr', ['App\Controllers\AdminController', 'registrationPage']);
    $r->addRoute('POST', '/registr', ['App\Controllers\AdminController', 'registrationPage']);

    $r->addRoute('GET', '/login', ['App\Controllers\AdminController', 'adminPage']);
    $r->addRoute('GET', '/logout', ['App\Controllers\AdminController', 'logout']);

    $r->addRoute('POST', '/update', ['App\Controllers\AdminController', 'update']);
    $r->addRoute('GET', '/edit/{id:\d+}', ['App\Controllers\AdminController', 'edit']);
    $r->addRoute('GET', '/delete/{id:\d+}', ['App\Controllers\AdminController', 'delete']);
    $r->addRoute('GET', '/add', ['App\Controllers\AdminController', 'addView']);
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}

$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        $view->errorView();
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        $container->call($handler, $vars);
        break;
}
