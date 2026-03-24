<?php

namespace App\Controller;

abstract class AbstractController
{
    protected function render(string $template, ?string $title, array $data = []): void
    {
        include __DIR__ . "/../../template/template_" . $template . ".php";
    }

    /**
     * Méthode pour gérer les accés connecté et role
     * @param string $role chaine du role à vérifier
     * @return void
     */
    protected function isGranted(string $role): void
    {
        //Si utilisateur non connecté ou connecté et n'a pas le bon role
        if (
            !isset($_SESSION["connected"]) || 
            isset($_SESSION["connected"]) && $_SESSION["right"] != $role
            ) {
            header('Location:/');
        }
    }
}
