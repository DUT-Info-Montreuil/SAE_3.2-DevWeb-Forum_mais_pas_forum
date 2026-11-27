<?php
class JeuxController{
    private JeuxRepository  $jeuxRepository;
    private JeuxView $jeuxView;
public function __construct($jeuxRepository , $jeuxView){
    $this->jeuxRepository = $jeuxRepository;
    $this->jeuxView = $jeuxView;
}

public function liste(): void{
    $jeux = $this->jeuxRepository->findAll();
    $this->jeuxView->afficherListe($jeux);
}

public function detail(int $id_jeux): void{
    $jeux = $this->jeuxRepository->findById($id_jeux);

    $avis = $this->jeuxRepository->resultat_avis($id_jeux);

    $this->jeuxView->afficherDetail($jeux, [] , $avis);

}

public function formulaireAjout(): void{
    $this->jeuxView->afficherFormulaireAjout();
}

public function formulaireModification($id): void{
    $monid = $this->jeuxRepository->findById($id);
    if($monid !== null){
        $this->jeuxView->afficherFormulaireModification($monid);

    }else{
        http_response_code(404);
        exit;
    }
}


public function ajouter(): void{
    if (!Csrf::verifier($_POST['jeton'] ?? null)) {
        http_response_code(403);
        die('Jeton CSRF invalide');
    }
    if($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['nom_jeux'])){
        http_response_code(404);
        exit;
    }

    $cheminLogo = $this->enregistrerLogo();
    if($cheminLogo === null){
        http_response_code(404);
        exit;
    }


    $jeux = new Jeux(0 , $_POST['nom_jeux'] , $_POST['configuration_minimal'] , $_POST['configuration_requise'] , $_POST['description_jeux'] , $cheminLogo);
    $id_jeux = $this->jeuxRepository->ajouter($jeux);
    header('Location: index.php?module=jeux&route=detail&id_jeux=' . $id_jeux);
    exit;
}

    public function modifier(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(404);
            exit;
        }

        if (!Csrf::verifier($_POST['jeton'] ?? null)) {
            http_response_code(403);
            die('Jeton CSRF invalide');
        }

        $id_jeux = filter_var($_POST['id_jeux'] ?? null, FILTER_VALIDATE_INT);

        if ($id_jeux  === false || $id_jeux  === null || $id_jeux  <= 0) {
            http_response_code(404);
            exit;
        }

        $j = $this->jeuxRepository->findById($id_jeux );

        if ($j === null || empty($_POST['nom_jeux'])) {
            http_response_code(404);
            exit;
        }

        $nouveauLogo = $this->enregistrerLogo();

        if ($nouveauLogo === null) {
            $cheminLogo = $j->getLogo();
        } else {
            $cheminLogo = $nouveauLogo;
        }


//
        $nouveauJeux = new Jeux(
            $id_jeux ,
            $_POST['nom_jeux'],
            $_POST['configuration_minimal'],
            $_POST['configuration_requise'],
            $_POST['description_jeux'],
            $cheminLogo
        );
        try {
            $this->jeuxRepository->modifier($nouveauJeux);
        }catch(Throwable $e){
            if($nouveauLogo !== null){
                $dest = __DIR__ . '/../../../data/' . $nouveauLogo;

            if(is_file($dest)){
                unlink($dest);
            }
            }
       throw $e;
        }

        header('Location: index.php?module=jeux&route=detail&id_jeux=' . $id_jeux );
        exit;
    }

    public function supprimer(): void{
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(404);
            exit;
        }

        if (!Csrf::verifier($_POST['jeton'] ?? null)) {
            http_response_code(403);
            die('Jeton CSRF invalide');
        }


        $id_jeux = filter_var($_POST['id_jeux'] ?? null, FILTER_VALIDATE_INT);

        if ($id_jeux === false || $id_jeux === null || $id_jeux <= 0) {
            http_response_code(400);
            exit;
        }
        /*
        $autori = new Autorisations();
        $user = $this->utilisateurrepository->findById($_SESSION['utilisateur_id']);
        if($user === null){
            http_response_code(400);
            exit;
        }

        $autori->exiger($user->getrole(), 'iut' , 'ecrire');

        */

        $jeux = $this->jeuxRepository->findById($id_jeux);


        if($jeux === null){
            http_response_code(400);
            exit;
        }
        /* Pour la partie extension
        if(!empty($this->departementrepository->findByIut($id))){
            die("Non il reste des departements");
        }
        */
        $this->jeuxRepository->supprimer($id_jeux);
        header('Location: index.php?module=jeux&route=liste');
        exit;
    }

    private function enregistrerLogo(): ?string{
        $fichier = $_FILES['logo'] ?? null;
        if (!is_array($fichier) || !isset($fichier['error'])
            || is_array($fichier['error'])) {
            die('Envoi invalide ou trop volumineux');
        }
        if ($fichier['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }
        if ($fichier['error'] !== UPLOAD_ERR_OK) {
            die('Echec du transfert du logo');
        }
        if ($fichier['size'] > 2 * 1024 * 1024) {
            die('Logo trop volumineux');
        }
        $types = [
            'image/png' =>'png', 'image/jpeg' => 'jpg',
            'image/svg+xml' => 'svg'
        ];
        $mime = (new finfo(FILEINFO_MIME_TYPE))->file($fichier['tmp_name']);
        if (!isset($types[$mime])) {
            die('Seuls PNG, JPEG et SVG sont acceptes');
        }
        $nom = bin2hex(random_bytes(16)) . '.' . $types[$mime];
        $chemin = 'images/' . $nom;
        $destination = __DIR__ . '/../../../data/' . $chemin;
        if (!move_uploaded_file($fichier['tmp_name'], $destination)) {
            die('Impossible de sauvegarder le logo');
        }
        return $chemin;
    }

    public function donner_avis(): void{
        if (!Csrf::verifier($_POST['jeton'] ?? null)) {
            http_response_code(403);
            die('Jeton CSRF invalide');
        }
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            http_response_code(404);
            exit;
        }


        $id_jeux = filter_var($_POST['id_jeux'] ?? null, FILTER_VALIDATE_INT);
        $note = filter_var($_POST['note'] ?? null , FILTER_VALIDATE_INT);
        $description_avis = trim($_POST['description_avis'] ?? '');


        if ($id_jeux === false || $id_jeux === null || $note === false || $note === null || $note < 0 || $note > 20) {
            http_response_code(400);
            exit('Informations invalides');
        }

        $jeu = $this->jeuxRepository->findById($id_jeux);

        if ($jeu === null) {
            http_response_code(404);
            exit('Jeu non trouvée');
        }

        $id_utilisateur = $_SESSION['id_utilisateur'] ?? null;

        if ($id_utilisateur === null) {
            http_response_code(401);
            exit('Creer un compte avant de donner un avis');
        }

        $this->jeuxRepository->donner_avis(
            $id_utilisateur,
            $id_jeux,
            $description_avis,
            $note
        );

        header('Location: index.php?module=jeux&route=detail&id_jeux=' . $id_jeux);
        exit;




    }

    public function modifier_avis(): void{
        if (!Csrf::verifier($_POST['jeton'] ?? null)) {
            http_response_code(403);
            die('Jeton CSRF invalide');
        }
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            http_response_code(404);
            exit;
        }


        $id_jeux = filter_var($_POST['id_jeux'] ?? null, FILTER_VALIDATE_INT);
        $note = filter_var($_POST['note'] ?? null , FILTER_VALIDATE_INT);
        $description_avis = trim($_POST['description_avis'] ?? '');


        if ($id_jeux === false || $id_jeux === null || $note === false || $note === null || $note < 0 || $note > 20 || $description_avis === '') {
            http_response_code(400);
            exit('Informations invalides');
        }

        $jeu = $this->jeuxRepository->findById($id_jeux);

        if ($jeu === null) {
            http_response_code(404);
            exit('Jeu non trouvée');
        }

        $id_utilisateur = $_SESSION['id_utilisateur'] ?? null;

        if($id_utilisateur == null){
            http_response_code(404);
            exit('Utilisateur introuvable');
        }

    $this->jeuxRepository->modifier_avis(
            $id_utilisateur,
            $id_jeux,
            $description_avis,
            $note
        );

        header('Location: index.php?module=jeux&route=detail&id_jeux=' . $id_jeux);
        exit;
    }


    public function supprimer_avis(): void{
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            http_response_code(404);
            exit;
        }

        if (!Csrf::verifier($_POST['jeton'] ?? null)) {
            http_response_code(403);
            die('Jeton CSRF invalide');
        }
        $id_jeux = filter_var($_POST['id_jeux'] ?? null, FILTER_VALIDATE_INT);

        $id_utilisateur = $_SESSION['id_utilisateur'] ?? null;

        if ($id_jeux === false || $id_jeux === null  || $id_utilisateur === null) {
            http_response_code(400);
            exit;
        }

        $this->jeuxRepository->supprimer_avis($id_utilisateur, $id_jeux);

        header('Location: index.php?module=jeux&route=detail&id_jeux=' . $id_jeux);

        exit;

    }

}