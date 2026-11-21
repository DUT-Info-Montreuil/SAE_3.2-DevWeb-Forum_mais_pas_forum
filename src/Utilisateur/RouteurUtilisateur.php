<?php
require_once __DIR__ . '/../Utilisateur/Controller/UtilisateurController.php';

class UtilisateurRouteur
{
    private UtilisateurController $utilisateurController;
    public function __construct(UtilisateurController $utilisateurController) {
        $this->utilisateurController = $utilisateurController;
    }

    public function router() : void {

        $route = $_GET["route"] ?? "formulaire_inscription";
    if ($route === 'formulaire_inscription') {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->utilisateurController->formulaireInscription();
        }  else {
            http_response_code(405);
            echo 'Méthode non autorisée';}
    }
    elseif ($route === 'inscrire') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->utilisateurController->inscrire();
        } else {
            http_response_code(405);
            echo 'Méthode non autorisée';
        }
    }
    elseif ($route === 'test') {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->utilisateurController->afficherLesInscrit();
        } else {
            http_response_code(405);
            echo 'Méthode non autorisée';
        }
    }
    else {
        http_response_code(404);
        echo "Action inconnue";
    }

    }
}