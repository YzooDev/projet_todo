<?php

include '../vendor/autoload.php';
//démarrage de la session
session_start();

//Charger les variables d'environnement
$dotenv = Dotenv\Dotenv::createImmutable("../");
$dotenv->load();

//Récupération de l'URL
$url = parse_url($_SERVER['REQUEST_URI']);
//test soit l'url a une route sinon on renvoi à la racine
$path = isset($url['path']) ? $url['path'] : '/';

//Importer les controllers
use App\Controller\HomeController;
use App\Controller\CategoryController;
use App\Controller\SecurityController;
use App\Controller\TaskController;

//instancier les controllers
$homeController = new HomeController();
$categoryController = new CategoryController();
$securityController = new SecurityController();
$taskController = new TaskController();

//Routeur (test)
switch ($path) {
    case '/':
        $homeController->index();
        break;
    case '/category/new':
        $categoryController->createCategory();
        break;
    case '/category/all':
        $categoryController->showAllCategory();
        break;
    case '/register':
        $securityController->createAccount();
        break;
    case '/login':
        $securityController->connexion();
        break;
    case '/logout':
        $securityController->deconnexion();
        break;
    case '/task/new':
        $taskController->createTask();
        break;
    case '/task/activeall':
        $taskController->showAllTaskByAccount(true);
        break;
    case '/task/inactiveall':
        $taskController->showAllTaskByAccount(false);
        break;
    case '/task/update':
        $taskController->editStatusTask();
        break;
    default:
        echo "404 la page n'existe pas";
        break;
}
