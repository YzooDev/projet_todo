<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Account;
use App\Entity\Task;
use App\Database\Mysql;

class TaskRepository
{
    private \PDO $connect;

    public function __construct()
    {
        $this->connect = Mysql::connectBdd();
    }

    /**
     * Méthode pour ajouter une tache en BDD
     * @param Task
     * @return Task
     */
    public function addTask(Task $task): Task
    {
        try {
            //1 Ecrire la requête
            $sql = "INSERT INTO task(title, `description`, 
            created_at, updated_at, finish_on, `status`, `repeat`, account_id ) 
            VALUE(?,?,?,?,?,?,?,?)";
            //2 Préparer la requête
            $req = $this->connect->prepare($sql);
            //3 Assigner les paramètres
            $req->bindValue(1, $task->getTitle(), \PDO::PARAM_STR);
            $req->bindValue(2, $task->getDescription(), \PDO::PARAM_STR);
            $req->bindValue(3, $task->getCreatedAt()->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
            $req->bindValue(4, $task->getUpdatedAt()->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
            $req->bindValue(5, $task->getFinishOn()->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
            $req->bindValue(6, $task->getStatus(), \PDO::PARAM_BOOL);
            $req->bindValue(7, $task->getRepeat(), \PDO::PARAM_STR);
            $req->bindValue(8, $task->getAuthor()->getId(), \PDO::PARAM_INT);
            //4 Exécuter la requête
            $req->execute();
            //5 Récupérer ID de la Task
            $id = $this->connect->lastInsertId();
            //6 Setter Id à la Task
            $task->setId($id);
            //appeler la méthode addCategoriesToTask
            $this->addCategoriesToTask($task);
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
        return $task;
    }

    /**
     * Méthode pour ajouter des categories à une tache
     * @param Task
     * @return Task
     */
    private function addCategoriesToTask(Task $task): Task
    {
        try {
            //boucle sur la collection de Category
            foreach ($task->getCategories() as $category) {
                //1 Ecrire la requête
                $sqlAsso = "INSERT INTO task_category(task_id, category_id) VALUE(?,?)";
                //2 Préparer la requête
                $reqAsso = $this->connect->prepare($sqlAsso);
                //3 Assigner les paramètres
                $reqAsso->bindValue(1, $task->getId(), \PDO::PARAM_INT);
                $reqAsso->bindValue(2, $category->getId(), \PDO::PARAM_INT);
                //4 Exécuter la requête
                $reqAsso->execute();
            }
        } catch (\PDOException $e) {
        }
        return $task;
    }

    /**
     * Méthode pour ajouter des categories à une tache
     * Alternative V2
     * @param Task
     * @return Task
     */
    private function addCategoriesToTaskV2(Task $task): Task
    {
        try {

            //1 Ecrire la requête
            $sqlAsso = "INSERT INTO task_category(task_id, category_id) VALUES";
            //boucle sur la collection de Category
            foreach ($task->getCategories() as $category) {
                //2 compléter la requête
                $sqlAsso .= "(?,?),";
            }
            //3supprimer le dernier , de la requête
            $sqlAsso = substr($sqlAsso, 0, -1);
            //4 Préparer la requête
            $reqAsso = $this->connect->prepare($sqlAsso);
            $cpt = 1;
            //5 boucle pour assigner les paramètres
            foreach ($task->getCategories() as $category) {
                $reqAsso->bindValue($cpt, $task->getId(), \PDO::PARAM_INT);
                $cpt++;
                $reqAsso->bindValue($cpt, $category->getId(), \PDO::PARAM_INT);
                $cpt++;
            }
            //6 exécuter la requête
            $reqAsso->execute();
        } catch (\PDOException $e) {
        }
        return $task;
    }

    /**
     * Méthode pour ajouter des categories à une tache
     * Alternative V3
     * @param Task
     * @return Task
     */
    private function addCategoriesToTaskV3(Task $task): Task
    {
        try {
            $bindArray = [];
            //1 Ecrire la requête
            $sqlAsso = "INSERT INTO task_category(task_id, category_id) VALUES";
            //boucle sur la collection de Category
            foreach ($task->getCategories() as $category) {
                //2 compléter la requête
                $sqlAsso .= "(?,?),";
                $bindArray[] = $task->getId();
                $bindArray[] = $category->getId();
            }
            //3supprimer le dernier , de la requête
            $sqlAsso = substr($sqlAsso, 0, -1);
            //4 Préparer la requête
            $reqAsso = $this->connect->prepare($sqlAsso);
            //5 Exécuter la requête
            $reqAsso->execute($bindArray);
        } catch (\PDOException $e) {
        }
        return $task;
    }

    /**
     * Méthode qui retourne toutes les Task d'un Account
     * @param int $id ID de la tache
     * @param bool $status status de la tache
     * @return array<Task> Tableau d'Entity Task
     */
    public function findAllTaskByAccount(int $id, bool $status = true): array
    {
        try {
            //1 Ecrire la requête SQL
            $sql = <<<SQL
            SELECT t.id AS task_id, t.title AS task_title, t.`description` AS task_description,
            t.created_at AS task_created_at, t.updated_at AS task_updated_at, t.account_id AS task_account_id, 
            t.finish_on AS task_finish_on, t.`repeat` AS task_repeat, t.`status` AS task_status, 
            GROUP_CONCAT(c.category_name) AS categories_name, GROUP_CONCAT(c.id) AS categories_id 
            FROM task AS t 
            LEFT JOIN task_category AS tc ON  t.id = tc.task_id
            LEFT JOIN category AS c ON tc.category_id = c.id
            WHERE t.account_id = ? AND t.`status` = ? GROUP BY t.id
            SQL;
            //2 Préparer la requête
            $req = $this->connect->prepare($sql);
            //3 Assigner le paramètre
            $req->bindParam(1, $id, \PDO::PARAM_INT);
            $req->bindParam(2, $status, \PDO::PARAM_BOOL);
            //4 Exécuter la requête
            $req->execute();
            //5 Retourner la réponse (Tab asso)
            $tasks = $req->fetchAll(\PDO::FETCH_ASSOC);
            //6 Création tableau de Task
            $tasksArray = [];
            //7 Parcours du FetchAll (FETCH_ASSOC)
            foreach ($tasks as $task) {
                //Hydratation et ajout de la Task au tableau
                $tasksArray[] = $this->hydrateTask($task);
            }
        } catch (\PDOException $e) {
        }
        return $tasksArray;
    }

    /**
     * Méthode pour convertir une row SQL (FETCH_ASSOC) en Entity Task
     * @param array $task Tableau associatif
     * @return Task Entity Task
     */
    private function hydrateTask(array $row): Task
    {
        //1 Création du compte
        $author = new Account();
        $author->setId($row["task_account_id"]);

        //2 Création de la tache
        $entityTask = new Task(
            $row["task_title"],
            $row["task_description"],
            new \DateTime($row["task_created_at"]),
            $author
        );

        //3 Set des autres valeurs
        $entityTask
            ->setUpdatedAt(new \DateTime($row["task_updated_at"]))
            ->setFinishOn(new \DateTime($row["task_finish_on"]))
            ->setRepeat($row["task_repeat"])
            ->setStatus($row["task_status"])
            ->setId($row["task_id"])
        ;

        //4 Tableau des catégories
        $categories_name = explode(",",(string)$row["categories_name"]);
        $categories_id = explode(",",(string)$row["categories_id"]);

        //5 Boucle pour assigner les Categories
        for ($i=0; $i <count($categories_name) ; $i++) {
            //6 Test si la category existe
            if($categories_id[$i] != 0 && $categories_name[$i] != "") {
                //7 Création d'une nouvelle Category
                $cat = new Category($categories_name[$i]);
                //8 Set de l'ID de la Category
                $cat->setId((int)$categories_id[$i]);
                //9 Ajout de la Category à la collection de la Task
                $entityTask->addCategory($cat);
            }

        }

        return $entityTask;
    }

    /**
     * Méthode pour passer le status de la task à false
     * @param int $id ID de la tache
     * @return void
     */
    public function updateTaskStatus(int $id, bool $status ): void 
    {
        try {
            $sql = "UPDATE task SET `status` = ? WHERE id = ?";
            $req = $this->connect->prepare($sql);
            $req->bindParam(1, $status, \PDO::PARAM_BOOL);
            $req->bindParam(2, $id, \PDO::PARAM_INT);
            $req->execute();
        } catch(\PDOException $e) {}
    }
}
