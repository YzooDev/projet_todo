<?php

include '../vendor/autoload.php';
//Charger les variables d'environnement
$dotenv = Dotenv\Dotenv::createImmutable("../");
$dotenv->load();

//Récupération de l'URL
$url = parse_url($_SERVER['REQUEST_URI']);
//test soit l'url a une route sinon on renvoi à la racine
$path = isset($url['path']) ? $url['path'] : '/';

//Importer les controllers
use App\Controller\HomeController;

//instancier les controllers
$homeController = new HomeController();

//Routeur (test)
switch ($path) {
    case '/':
        $homeController->index();
        break;
    case '/register':
        echo "Inscription";
        break;
    case '/login':
        echo "connexion";
        break;
    case '/task/all':
        echo "liste des taches";
        break;
    default:
        echo "404 la page n'existe pas";
        break;
}
