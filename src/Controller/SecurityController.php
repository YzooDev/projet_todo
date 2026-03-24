<?php

namespace App\Controller;

use App\Service\CategoryService;
use App\Controller\AbstractController;
use App\Service\SecurityService;

class SecurityController extends AbstractController
{
    private SecurityService $securityService;

    public function __construct()
    {
        $this->securityService = new SecurityService();
    }

    public function createAccount() : mixed 
    {
        $data = [];
        if (isset($_POST["submit"])) {
            $data["msg"] = $this->securityService->register($_POST);
        }
        return $this->render("register","inscription", $data);
    }

    public function connexion(): void
    {
        $data= [];
        if (isset($_POST["submit"])) {
            
            //Vérification de la connexion
            $data["msg"] = $this->securityService->login($_POST); 

            //Si on est connecté alors redirection vers l'accueil       
            if ($data["msg"] == "Vous etes connecté") header("Location:/");
            //redirection
            header("Refresh:4;");
        }

        $this->render("connexion","connexion", $data);
    }

    public function deconnexion(): void 
    {
        $this->securityService->logout();
    }
}
