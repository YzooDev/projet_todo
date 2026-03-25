<?php

namespace App\Service;

use App\Entity\Category;
use App\Entity\Account;
use App\Entity\Task;
use App\Repository\TaskRepository;
use App\Repository\CategoryRepository;
use App\Utils\Tools;

class TaskService
{
    private TaskRepository $taskRepository;
    private CategoryRepository $categoryRepository;

    
    public function __construct()
    {
        //Injection des dépendances
        $this->taskRepository = new TaskRepository();
        $this->categoryRepository = new CategoryRepository();
    }

    /**
     * Méthode pour ajouter une Task en BDD depuis la super globale $_POST
     * @param array $task super globale $_POST
     * @return string $msg message de sortie
     */
    public function insertTask(array $task): string 
    {
        //1 Vérifier si les champs sont vides
        if (
            empty($task["title"]) ||
            empty($task["description"])
        ) {
            return "Veuillez remplir les champs obligatoires";
        }
        //2 Nettoyer les entrées utilisateurs
        Tools::sanitize_array($task);

        //3 Mapper le tableau (Super globale POST)
        $addTask = $this->mapFromPost($task);
        
        //4 Ajout en BDD
        $this->taskRepository->addTask($addTask);

        return "La tache : " . $addTask->getTitle() . " a été ajouté en BDD";
    }

    /**
     * Méthode pour récupérer toutes les taches d'un account
     * @param int $id ID de l'Account connecté
     * @param bool $status status de la tache
     * @return array<Task> Tableau d'Entity Task
     */
    public function getAllTaskByAccount(int $id, bool $status = true): array 
    {
        return $this->taskRepository->findAllTaskByAccount($id, $status);
    }

    /**
     * Méthode pour convertir la super globale POST (formulaire) en Entity Task
     * @param array $task Super Globale POST
     * @return Task Entity Task
     */
    private function mapFromPost(array $task): Task 
    {
        //1 Créer un Account
        $author = new Account();
        $author->setId($_SESSION["id"]);
        //2 Créer un objet task
        $addTask = new Task($task["title"], $task["description"], new \DateTime(),$author );
        //3 Ajouter les categories
        foreach ($task["categories"] as $value) {
            //4 Créer une category
            $category = new Category();
            $category->setId($value);
            //5 Ajouter la categorie à la tache
            $addTask->addCategory($category);
        }
        //6 Set si la valeur est non vide
        if(!empty($task["finish_on"])) {
            $addTask->setFinishOn(new \DateTime($task["finish_on"]));
        }
        //7 Set si la valeur est non vide
        if(!empty($task["repeat"])) {
            $addTask->setRepeat($task["repeat"]);
        }

        return $addTask;
    }

    /**
     * 
     */
    public function changeTaskStatus(int $id, bool $status): void 
    {
        Tools::sanitize($id);
        $this->taskRepository->updateTaskStatus($id, (bool) $status);
    }
}
