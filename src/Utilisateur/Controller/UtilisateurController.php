<?php

require_once __DIR__ . '/../../Utilisateur/Model/UtilisateurRepository.php';
require_once __DIR__ . '/../Vue/UtilisateurView.php';

class UtilisateurController
{
    private UtilisateurRepository $utilisateurRepository;
    private UtilisateurView $vue;

    public function __construct( UtilisateurRepository $utilisateurRepository,  UtilisateurView $vue)
    {
        $this ->utilisateurRepository = $utilisateurRepository;
        $this ->vue = $vue;
    }

    public function inscrire(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit;
        }
        if (!Csrf::verifier($_POST["jeton"] ?? null)) {
            http_response_code(403);
            die('Jeton CSRF invalide');
        }

//recup les valeurs pour les tester
        $nomUtilisateur = trim($_POST['nom_utilisateur'] ?? '');
        $emailUtilisateur = trim($_POST['email'] ?? '');
        $mot_de_passe_hash_Utilisateur = trim($_POST['mot_de_passe_hash'] ?? '');
        $role = 2;

        if ($nomUtilisateur === false || $nomUtilisateur === null || $nomUtilisateur === '' || $emailUtilisateur === false || $emailUtilisateur === null || $emailUtilisateur === '' || $mot_de_passe_hash_Utilisateur === false || $mot_de_passe_hash_Utilisateur === null || $mot_de_passe_hash_Utilisateur === '') {
//voir si tt les cases ou une valeur correcte
            http_response_code(400);
            echo 'Données du formulaire incorrectes';
            return;
        }
        $emailUtilisateur = trim($_POST['email'] ?? '');

        if ($this->utilisateurRepository->findByEMail($emailUtilisateur) !== null) {//car dans la bd email est unique
            die(' adresse e-mail deja prise');
        }

        $utilisateur = new Utilisateur(0, $nomUtilisateur, $emailUtilisateur, $mot_de_passe_hash_Utilisateur, $role);// 0 pour id car de tt façon dans le repository l'id n'est pas envoyer dans la bd donc un nouvel id sera crée
        $this->utilisateurRepository->inscrire($utilisateur);

        //header('Location: index.php?module=utilisateur&route=formulaire_connexion');
        header('Location: index.php?module=utilisateur&route=test');
        exit;
    }

    public function formulaireInscription(): void
    {
        $this->vue->afficherFormulaireInscription();
    }

    public function formulaireConnexion()
    {
        $this->vue->afficherFormulaireConnexion();
    }

    public function afficherLesInscrit()
    {
        $utilisateurs = $this->utilisateurRepository->findAll();
        $this->vue->afficherListeDesInscrit($utilisateurs);
    }

}