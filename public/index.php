<?php

$url = parse_url($_SERVER['REQUEST_URI']);
//test soit l'url a une route sinon on renvoi à la racine
$path = isset($url['path']) ? $url['path'] : '/';


switch ($path) {
    case '/':
        echo "Bienvenue";
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
