<?php
class JeuxRouteur{
    private JeuxController  $jeuxController;

    public function __construct(JeuxController  $jeuxController){
        $this->jeuxController = $jeuxController;
    }

    public function router(): void{
        $route = $_GET["route"] ?? "liste";
        if($route === "liste"){
            $this->jeuxController->liste();
        }elseif($route === "detail"){
            $id_jeux = filter_input(INPUT_GET , "id_jeux" , FILTER_VALIDATE_INT);
            if($id_jeux === false || $id_jeux === null){
                http_response_code(404);
                echo "Identifiant incorrect";
            }else{
                $this->jeuxController->detail($id_jeux);
            }
        }elseif($route === "formulaire_modification"){
            $id_jeux = filter_input(INPUT_GET , "id_jeux" , FILTER_VALIDATE_INT);
            if($id_jeux === false || $id_jeux === null){
                http_response_code(404);
                echo "Identifiant incorrect";
            }else{
                $this->jeuxController->formulaireModification($id_jeux);
            }
        }elseif($route === "modifier"){
            if($_SERVER["REQUEST_METHOD"] !== "POST"){
                http_response_code(404);
                exit;
            }else{
                $this->jeuxController->modifier();
            }

        }elseif($route === "ajouter"){
            $this->jeuxController->ajouter();
        }

        elseif ($route === "formulaire_ajout"){
            $this->jeuxController->formulaireAjout();
        }
    }

}