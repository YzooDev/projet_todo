<?php

namespace App\Entity;

class Account
{
    private ?int $id;
    private ?string $firstname;
    private ?string $lastname;
    private string $email;
    private string $password;
    private ?string $image;

    public function __construct(
        string $email,
        string $password
    )
    {
        $this->email = $email;
        $this->password = $password;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void 
    {
        $this->id = $id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): void 
    {
        $this->firstname = $firstname;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): void 
    {
        $this->lastname = $lastname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void 
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void 
    {
        $this->password = $password;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): void 
    {
        $this->image = $image;
    }

    //Méthodes
    public function __toString(): string
    {
        return $this->firstname . ", " . $this->lastname;
    }
    
    /**
     * Méthode pour hasher le password en Bycript
     * @return void
     */
    public function hashPassword(): void
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    }

    /**
     * Méthode pour vérifier le hash du password
     * @param string $plainPassword mot de passe en clair
     * @return bool true si valide false si invalide
     */
    public function verifyPassword(string $plainPassword): bool 
    {
        return password_verify($plainPassword, $this->password);
    }
}