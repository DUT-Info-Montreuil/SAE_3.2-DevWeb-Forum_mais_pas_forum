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
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        http_response_code(404);
        exit;
    }
    if(empty($_POST['nom_jeux'])){
        http_response_code(404);
        exit;
    }
}

    public function modifier(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(404);
            exit;
        }

        $id = filter_var($_POST['id_jeux'] ?? null, FILTER_VALIDATE_INT);

        if ($id === false || $id === null || $id <= 0) {
            http_response_code(404);
            exit;
        }

        $j = $this->jeuxRepository->findById($id);

        if ($j === null) {
            http_response_code(404);
            exit;
        }

        if(empty($_POST['nom_jeux'])){
            http_response_code(404);
            exit;
        }






//
        $nouveauJeux = new Jeux(
            $id,
            $_POST['nom_jeux'],
            $_POST['minimal'],
            $_POST['requise'],
            $_POST['description_jeux']
        );
        $this->jeuxRepository->modifier($nouveauJeux);


        header('Location: index.php?route=detail&id=' . $id);
        exit;
    }





}