<?php

require_once __DIR__ . '/../../Studio/Model/StudioRepository.php';
require_once __DIR__ . '/../Vue/StudioView.php';

class StudioController {
    private StudioRepository $studioRepository;
    private StudioView $vue;

    public function __construct( StudioRepository $studioRepository,  StudioView $vue)
    {
        $this ->studioRepository = $studioRepository;
        $this ->vue = $vue;
    }

    //a modifier jzoesjicnlqanilct

    public function creerStudio() : void{
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit;
        }
        if (!Csrf::verifier($_POST["jeton"] ?? null)) {
            http_response_code(403);
            die('Jeton CSRF invalide');
        }

        $nomStudio = trim($_POST['nom_studio'] ?? '');

        if ( $nomStudio === null || $nomStudio === '' ){
            http_response_code(400);
            echo 'Données du formulaire incorrectes';
            return;
        }
        // voir si on passe pas le nom du studio en unique

        $studio = new Studio(0,$nomStudio);// 0 pour id car de tt façon dans le repository l'id n'est pas envoyer dans la bd donc un nouvel id sera crée
        $idStudio = $this->studioRepository->creerStudio($studio);

        header('Location: index.php?module=studio&route=detail&id=' . $idStudio);

        exit;

    }
    public function formulaireCreationStudio(): void
    {
        $this->vue->afficherFormulaireCreationStudio();
    }

    public function afficherListeStudio() : void {// temporaire
        $studio = $this->studioRepository->findAll();
        $this->vue->afficherListe($studio);
    }
    public function detailStudio(int $idStudio): void{
        $studio = $this->studioRepository->findById($idStudio);
        $jeux = $this->studioRepository->findJeuxByStudio($idStudio);
        $this->vue->afficherDetail($studio,$jeux);
    }


}
