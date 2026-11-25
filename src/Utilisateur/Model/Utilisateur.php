<?php

class Utilisateur
{
    private int $id_utilisateur;
    private string $nom_utilisateur;
    private string $email;
    private string $mot_de_passe;
    private int $id_role;// 1 -> admin -> 2 visiteur

    public function __construct(int $id_utilisateur, string $nom_utilisateur, string $email, string $mot_de_passe, int $id_role)
    {
        $this->id_utilisateur = $id_utilisateur;
        $this->nom_utilisateur = $nom_utilisateur;
        $this->email = $email;
        $this->mot_de_passe = $mot_de_passe;
        $this->id_role = $id_role;
    }

    public function getId(): int
    {
        return $this->id_utilisateur;
    }

    public function getNom(): string
    {
        return $this->nom_utilisateur;
    }

    public function getEMail(): string
    {
        return $this->email;
    }

    public function getMDP(): string
    {
        return $this->mot_de_passe;
    }

    public function getRole(): string
    {
        return $this->id_role;
    }


}
