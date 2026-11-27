<?php

require_once __DIR__ . '/../Studio/Controller/StudioController.php';

class RouteurStudio
{
    private StudioController $studioController;

    public function __construct(StudioController $studioController)
    {
        $this->studioController = $studioController;
    }

    public function router(): void
    {
        $route = $_GET["route"] ?? "liste";

        if ($route === 'creerStudio') {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->studioController->creerStudio();
            }
            elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $this->studioController->formulaireCreationStudio();
            }
            else {
                http_response_code(405);
                echo 'Méthode non autorisée';
            }

        }
        elseif ($route === 'liste') {
            if($_SERVER["REQUEST_METHOD"] !== "GET"){
                http_response_code(404);
                exit;
            }
            $this->studioController->afficherListeStudio();
        }
        elseif($route === "detail") {
            $idStudio = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
            if ($_SERVER["REQUEST_METHOD"] !== "GET") {
                http_response_code(404);
                exit;
            } elseif ($idStudio === false || $idStudio === null) {
                http_response_code(404);
                echo "Identifiant incorrect";
                exit;
            }
            $this->studioController->detailStudio($idStudio);
        }
        else{
            http_response_code(404);
            echo "Action inconnue";
        }

    }
}
