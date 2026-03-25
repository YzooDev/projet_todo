<?php

namespace App\Controller;

use App\Service\CategoryService;
use App\Service\TaskService;
use App\Controller\AbstractController;

class TaskController extends AbstractController
{
    private CategoryService $categoryService;
    private TaskService $taskService;

    public function __construct()
    {
        $this->categoryService = new CategoryService();
        $this->taskService = new TaskService();
    }

    public function createTask(): mixed 
    {
        //test si non connecté redirection vers accueil
        if (!isset($_SESSION["connected"])) header('Location:/');

        //Récupération des categories
        $data["categories"] = $this->categoryService->getAllCategories();

        //Test si le formulaire est submit
        if (isset($_POST["submit"])) {
            //Ajout de la tache
            $data["msg"] =  $this->taskService->insertTask($_POST);
        }

        return $this->render("add_task","Ajouter tache", $data);
    }
    
    public function showAllTaskByAccount(bool $status) 
    {
        //test si non connecté redirection vers accueil
        if (!isset($_SESSION["connected"])) header('Location:/');

        //Récupération de la liste des taches
        $tasks["tasks"] = $this->taskService->getAllTaskByAccount($_SESSION["id"], $status);


        //Test si le status est à true
        if ($status == 1) {
            //Titre de la page
            $tasks["title"] = " en cours";
            //intitulé du bouton
            $tasks["buttonValue"] = "désactiver";
            //state pour désactiver la tache
            $tasks["state"] = 0;
        } else {
            //Titre de la page
            $tasks["title"] = " terminées";
            //intitulé du bouton
            $tasks["buttonValue"] = "activer";
            //state pour désactiver la tache
            $tasks["state"] = 1;
        }
        //rendu du template
        return $this->render("show_all_task_by_account","liste des taches", $tasks);

    }
    public function editStatusTask(): void 
    {
        //test si non connecté redirection vers accueil
        if (!isset($_SESSION["connected"])) header('Location:/');

        if (isset($_GET["id"]) && isset($_GET["status"])) {
            
            $id = $_GET["id"];
            $status = (bool) $_GET["status"];
            
            //Appel de la méthode du TaskService
            $this->taskService->changeTaskStatus($id, $status);
            
            if ($_GET["status"] == 1) {
                //Redirection vers la page qui affiche toutes ces taches
                header('Location: /task/inactiveall');
            }
            
            if ($_GET["status"] == 0) {
                //Redirection vers la page qui affiche toutes ces taches
                header('Location: /task/activeall');
            }
        }
    }
}
