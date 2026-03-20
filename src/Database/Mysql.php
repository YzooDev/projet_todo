<?php

namespace App\Database;

class Mysql
{
    public static function connectBdd(): \PDO
    {
        //Création d'un objet PDO
        return new \PDO(
            'mysql:host=' . $_ENV["DATABASE_HOST"] . ';dbname=' . $_ENV["DATABASE_NAME"] . '',
            $_ENV["DATABASE_USERNAME"],
            $_ENV["DATABASE_PASSWORD"],
            [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
        );
    }
}
