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

    private function enregistrerLogo(): ?string {
        $fichier = $_FILES['logo'] ?? null;
        if (!is_array($fichier) || !isset($fichier['error'])|| is_array($fichier['error'])) {
            die('Envoi invalide ou trop volumineux');
        }
        if ($fichier['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }
        if ($fichier['error'] !== UPLOAD_ERR_OK) {
            die('Echec du transfert du logo');
        }
        if ($fichier['size'] > 2 * 1024 * 1024) {
            die('Logo trop volumineu');
        }
        $types = ['image/png' => 'png', 'image/jpeg' => 'jpg','image/svg+xml' => 'svg'];
        $mime = (new finfo(FILEINFO_MIME_TYPE))->file($fichier['tmp_name']);
        if (!isset($types[$mime])) {
            die('Seuls PNG, JPEG et SVG sont acceptes');
        }
        $nom = bin2hex(random_bytes(16)) . '.' . $types[$mime];
        $chemin = 'logo_Studio/' . $nom;
        $destination = __DIR__ . '/../../../data/' . $chemin; if (!move_uploaded_file($fichier['tmp_name'], $destination)) {
            die('Impossible de sauvegarder le logo');
        } return $chemin;
    }

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
        $description_studio = trim($_POST['description_studio'] ?? '');


        if ( $nomStudio === null || $nomStudio === '' || $description_studio === null|| $description_studio === ''){
            http_response_code(400);
            echo 'Données du formulaire incorrectes';
            return;
        }
        $cheminLogo = $this->enregistrerLogo();

        if ($cheminLogo === null) {
            http_response_code(400);
            exit('Un logo est obligatoire');
        }
        // voir si on passe pas le nom du studio en unique

        $studio = new Studio(0,$nomStudio,$description_studio,$cheminLogo);// 0 pour id car de tt façon dans le repository l'id n'est pas envoyer dans la bd donc un nouvel id sera crée
        try {
            $idStudio = $this->studioRepository->creerStudio($studio);
        } catch (Throwable $e) {
            $destination = __DIR__ . '/../../../data/' . $cheminLogo;
            if (is_file($destination)) {
                unlink($destination);
            }
            throw $e;
        }
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
